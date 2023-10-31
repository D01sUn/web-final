<?php 
session_start();
include("database/dbconnect.php");

$UserID = $_GET["UserID"];
$Email = $_POST["Email"];
$Password = $_POST["Password"];
$Name = $_POST["Name"];
$Phone = $_POST["Phone"];
$Address = $_POST["Address"];
$ImageUrl = $_POST["ImageUrl"];

if ($dbconn->connect_error) {
    die("Conection Failed: " . $dbconn->connect_error);
}

$stmt = $dbconn->prepare("UPDATE users SET Email = ?, Name = ?, Phone = ?, Address = ?, ImageUrl = ? WHERE UserID = $UserID");
$stmt->bind_param("sssss", $Email, $Name, $Phone, $Address, $ImageUrl);
$stmt->execute();

header("location:information.php");
exit(0);