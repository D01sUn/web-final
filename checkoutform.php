<?php
session_start();
include("database/dbconnect.php");
include("config/informationUser.php");
// รหัสผู้ใช้งาน (ในกรณีนี้, คุณต้องกำหนดค่า userID ของผู้ใช้)
$userID = $_SESSION['UserID'];

// คำสั่ง SQL เพื่อดึงข้อมูลสินค้าในตะกร้า
$sqlCartItems = "SELECT     p.ProductName, p.Image, p.Price, s.Name AS SizeName, c.Name AS CrustName, od.OrderDetailID, od.Quantity, (p.Price + s.Price +  c.Price ) as PricePerAmount, ((p.Price + s.Price +  c.Price ) * od.Quantity) AS TotalPrice
                FROM        orderdetail od
                INNER JOIN  products p ON od.ProductID = p.ProductID
                INNER JOIN  size s ON od.Size = s.SizeID 
                INNER JOIN  crust c ON od.Crust = c.CrustID
                WHERE       od.OrderID IN (
                            SELECT  OrderID
                            FROM    iorder
                            WHERE   UserID = ?
                            AND     Total = 0
                            AND     DeliveryStatus = 'not_shipped'
                            )";

$stmtCartItems = $dbconn->prepare($sqlCartItems);
$stmtCartItems->bind_param("i", $userID);
$stmtCartItems->execute();
$resultCartItems = $stmtCartItems->get_result();

$totalPrice = 0;
if(isset($_POST['default-address'])){
    include("config/defaultCheckOut.php");
}elseif(isset($_POST['another-address'])){
    include("config/anotherCheckout.php");
}else {
    include("config/defaultCheckOut.php");
}
