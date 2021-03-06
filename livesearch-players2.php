<?php
require("common.php"); 

$myFile = "./livesearch/".$_SESSION['username'].".xml";
$fh = fopen($myFile, 'w') or die("can't open file");

$rss_txt .= '<players>';
    $query = " 
            SELECT 
                * 
            FROM players WHERE user_id = :userid ORDER BY player asc
        "; 
         
         $query_params = array( 
        ':userid' => $_SESSION['userid']
      ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die($ex); 
        } 
                 
                $rows = $stmt->fetchAll();
                if ($rows) {
                    foreach ($rows as $x) {
        $rss_txt .= '<player>';

        $rss_txt .= '<id>' .$x['id']. '</id>';
        $rss_txt .= '<name>' .$x['player'].'</name>';

        $rss_txt .= '</player>';
      }

    }
$rss_txt .= '</players>';


fwrite($fh, $rss_txt);
fclose($fh);

$xmlDoc=new DOMDocument();
$xmlDoc->load("./livesearch/".$_SESSION['username'].".xml");

$x=$xmlDoc->getElementsByTagName('player');

//get the q parameter from URL
$q=$_GET["q"];

//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
  $hint="";
  for($i=0; $i<($x->length); $i++) {
    
    $y=$x->item($i)->getElementsByTagName('name');
    $z=$x->item($i)->getElementsByTagName('id');
    
    if ($y->item(0)->nodeType==1) {
      //find a link matching the search text
      if (stristr($y->item(0)->childNodes->item(0)->nodeValue,$q)) {
        if ($hint=="") {
          $hint="<a href='#' class='livesearch-player2' value='" . 
          $z->item(0)->childNodes->item(0)->nodeValue . 
          "' style='margin: 5px; color: black; display:block;'>" . 
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        } else {
          $hint=$hint . "<a href='#' class='livesearch-player2' value='" . 
          $z->item(0)->childNodes->item(0)->nodeValue . 
          "' style='margin: 5px; color: black; display:block;'>" . 
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        }
      }
    }
  }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint=="") {
  $response="<span style='margin: 5px; color: black; display:block;'>No Suggestions</span>";
} else {
  $response=$hint;
}

//output the response
echo $response;
?>