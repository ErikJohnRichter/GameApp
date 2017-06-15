<?php
$connection = mysqli_connect("localhost", "root", "Gibson11", "gameapp"); // Establishing Connection with Server..
//Fetching Values from URL
$name=$_POST['name'];
$type=$_POST['type'];
$rating=$_POST['rating'];
$cost=$_POST['cost'];
$date=$_POST['purchaseDate'];
$notes=$_POST['notes'];
//Insert query
mysqli_query($connection, "insert into game_details(name, type, rating, cost, purchase_date, notes) values ('$name', '$type', '$rating','$cost', '$date', '$notes')");

mysqli_close($connection); // Connection Closed
?>