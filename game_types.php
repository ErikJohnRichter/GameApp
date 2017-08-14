
<option value="Abstract Strategy">Abstract Strategy</option>
<option value="Area Control">Area Control</option>
<option value="Bluffing">Bluffing</option>
<option value="Card Drafting">Card Drafting</option>
<option value="Card Game">Card Game</option>
<option value="Children Game">Children Game</option>
<option value="Combat">Combat</option>
<option value="Cooperative">Cooperative</option>
<option value="Crossover">Crossover</option>
<option value="Deck Building">Deck Building</option>
<option value="Dexterity">Dexterity</option>
<option value="Dice">Dice</option>
<option value="Deduction">Deduction</option>
<option value="Educational">Educational</option>
<option value="Expansion">Expansion</option>
<option value="Filler">Filler</option>
<option value="Horror">Horror</option>
<option value="Humor">Humor</option>
<option value="Party">Party</option>
<option value="Pattern Building">Pattern Building</option>
<option value="Point to Point">Point to Point</option>
<option value="Puzzle">Puzzle</option>
<option value="Roll and Move">Roll and Move</option>
<option value="Speed">Speed</option>
<option value="Territory Building">Territory Building</option>
<option value="Tile Laying">Tile Laying</option>
<option value="Trick Taking">Trick Taking</option>
<option value="Trivia">Trivia</option>
<option value="War Game">War Game</option>
<option value="Word Game">Word Game</option>
<option value="Worker Placement">Worker Placement</option>
<option value="Needs a Category">Needs a Category</option>

<?php

$query = " 
            SELECT 
                * 
            FROM custom_types WHERE user_id = :userid ORDER BY type asc
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
                 
                $rowszzz = $stmt->fetchAll();
                if ($rowszzz) {
                  echo '<option disabled>--Custom Types--</option>';
                    foreach ($rowszzz as $c) {
                      echo '<option value="'.$c['type'].'">'.$c['type'].'</option>';
                    }
                  }


?>