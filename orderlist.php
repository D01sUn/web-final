<?php
session_start();
include("database/dbconnect.php");
include("config/informationUser.php");

$userID = $_SESSION['UserID'];
if (isset($_POST['history-order'])) {
    $deliveryStatus = "shipped";
} else {
    $deliveryStatus = "not_shipped";
}

$sql = "SELECT          *, date_format(o.Odate, '%d/%m/%Y') AS date, date_format(o.Odate, '%T') AS time, o.Name AS UserName, o.Address as Address, o.Phone as Phone 
        FROM            iorder o
        INNER JOIN      users u ON o.UserID = u.UserID
        WHERE           o.UserID = ?
        AND             o.Total != 0
        AND             o.DeliveryStatus = ?
        ORDER BY        o.OrderID DESC
        ";
$stmtdemo = $dbconn->prepare($sql);
$stmtdemo->bind_param("is", $userID, $deliveryStatus);
$stmtdemo->execute();
$resultdemo = $stmtdemo->get_result();
$numrows = $resultdemo->num_rows;

if (isset($_POST['inprogress-order'])) {
    include("config/inprogress_order.php");
} elseif (isset($_POST['history-order'])) {
    include("config/history_order.php");
} else {
    include("config/inprogress_order.php");
}
