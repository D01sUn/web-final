<?php 
session_start();
include("database/dbconnect.php");

$ProductName = $_POST["ProductName"];
$Descript = $_POST["Descript"];
$Price = $_POST["Price"];
$ImageUrl = $_POST["ImageUrl"];
$Size = $_POST["Size"];
$Crust = $_POST["Crust"];

if ($dbconn->connect_error) {
    die("Conection Failed: " . $dbconn->connect_error);
}

$stmt = $dbconn->prepare("INSERT INTO products (ProductName, Descript, Price, ImageUrl, Size, Crust) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssdsii", $ProductName, $Descript, $Price, $ImageUrl, $Size, $Crust);
$stmt->execute();

header("location:add_to_product.php");
exit(0);
?>