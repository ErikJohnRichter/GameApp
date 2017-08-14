<?php
require("common.php"); 

$myFile = "./livesearch/".$_SESSION['username'].".xml";
$fh = fopen($myFile, 'w') or die("can't open file");

$rss_txt .= '<games>';
    $query = " 
            SELECT *, COUNT(publisher)
          FROM game_details WHERE publisher IS NOT null AND user_id=:userid
          GROUP BY publisher ORDER BY publisher asc, COUNT(publisher) desc
        "; 

        /*SELECT *, COUNT(publisher)
          FROM game_details WHERE publisher IS NOT null AND user_id=:userid
          GROUP BY publisher ORDER BY publisher asc, COUNT(publisher) desc*/
         
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
                      if (!strpos($x['publisher'], '&')) {
                          $publisher = $x['publisher'];
                        }
                        else {
                          $publisher = str_replace("&", "&#x26;", $x['publisher']);
                        }
      
        $rss_txt .= '<game>';

        $rss_txt .= '<publisher>' .$publisher.'</publisher>';

        $rss_txt .= '</game>';
      }

    }
$rss_txt .= '</games>';


fwrite($fh, $rss_txt);
fclose($fh);

$xmlDoc=new DOMDocument();
$xmlDoc->load("./livesearch/".$_SESSION['username'].".xml");

$x=$xmlDoc->getElementsByTagName('game');

//get the q parameter from URL
$q=$_GET["q"];

//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
  $hint="";
  for($i=0; $i<($x->length); $i++) {
    
    $y=$x->item($i)->getElementsByTagName('publisher');
    
    if ($y->item(0)->nodeType==1) {
      //find a link matching the search text
      if (stristr($y->item(0)->childNodes->item(0)->nodeValue,$q)) {
        if ($hint=="") {
          $hint="<a href='#' class='livesearch-link' style='margin: 5px; color: black; display:block;'>" . 
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        } else {
          $hint=$hint . "<a href='#' class='livesearch-link' style='margin: 5px; color: black; display:block;'>" . 
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