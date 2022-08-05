<?php
require 'credentials.php';

$server =constant("serverName");
$user =constant("username");
$pass =constant("password");
$db =constant("dbName");

$conn=mysqli_connect($server,$user,$pass,$db);
if(!$conn){
    die("not connected".mysqli_connect_error());
}




?>