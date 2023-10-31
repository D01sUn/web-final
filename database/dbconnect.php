<?php
$servername = "localhost";
$username = "demo";
$password = "abc123";
$dbname = "web66_65011212011";

$dbconn = new mysqli($servername, $username, $password, $dbname);

if($dbconn->connect_error){
    die("Conection Failed: " . $conn->connect_error);
}
?>