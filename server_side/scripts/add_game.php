<?php 

mysql_connect("localhost","root","");
mysql_select_db("gameapp");
error_reporting(E_ALL && ~E_NOTICE);

$name=$_POST['name'];
$type=$_POST['type'];
$rating=$_POST['rating'];
$cost=$_POST['cost'];
$purchaseDate=$_POST['purchaseDate'];
$notes=$_POST['notes'];

$sql="INSERT INTO game_details(name, type, rating, cost, purchase_date, notes) VALUES ('$name', '$type', '$rating', '$cost', '$purchase_date', '$notes')";
$result=mysql_query($sql);

?>