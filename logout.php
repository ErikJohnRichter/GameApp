<?php 

    require("common.php"); 

    setcookie("game-remember",false, time()-3600);
     
    unset($_SESSION['user']); 
     
    header("Location: index.php"); 
    die("Redirecting to: index.php");