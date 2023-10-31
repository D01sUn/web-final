<?php include("database/dbconnect.php");

$ProductID = $_GET["ProductID"];
$ProductName = $_POST["ProductName"];
$Descript = $_POST["Descript"];
$Price = $_POST["Price"];
$ImageUrl = $_POST["ImageUrl"];
$Size = $_POST["Size"];
$Crust = $_POST["Crust"];

if ($dbconn->connect_error) {
    die("Conection Failed: " . $dbconn->connect_error);
}

$stmt = $dbconn->prepare("UPDATE products SET ProductName = ?, Descript = ?, Price = ?, ImageUrl = ?, Size = ?, Crust = ? WHERE ProductID = $ProductID");
$stmt->bind_param("ssdsii", $ProductName, $Descript, $Price, $ImageUrl, $Size, $Crust);
$stmt->execute();

header("location:productAdmin.php");
exit(0);