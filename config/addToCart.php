<?php
include("../database/dbconnect.php");
session_start();
// if (isset($_POST['add-to-cart'])) {
$productID = $_POST['ProductID'];
$price = $_POST['Price'];
$quantity = $_POST['Quantity'];
$sizeID = $_POST['SizeID'];
$crustID = $_POST['CrustID'];

$redirect = "../addToCartForm.php?productID=" . $productID;

if (!empty($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];

    // check iorder alrady exists?
    $sql_check = "SELECT OrderID FROM iorder 
                        WHERE UserID = ? 
                        AND Total = 0
                        AND DeliveryStatus = 'not_shipped'";
    $stmt_check = $dbconn->prepare($sql_check);
    $stmt_check->bind_param("i", $userID);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows == 0) {
        // หากไม่มี iorder อยู่ ให้สร้าง iorder ใหม่
        $sqlCreateOrder = "INSERT INTO iorder 
                                (UserID, PaymentStatus, DeliveryStatus, Odate)
                                 VALUES (?, null, 'not_shipped', null)";

        $stmtCreateOrder = $dbconn->prepare($sqlCreateOrder);
        $stmtCreateOrder->bind_param("i", $userID);

        if ($stmtCreateOrder->execute()) {
            $newOrderID = $stmtCreateOrder->insert_id; // รหัส Order ใหม่ที่สร้างขึ้น
        } else {
            echo json_encode(array("status" => "error", "msg" => "เกิดข้อผิดพลาดในการสร้าง Order"));
            //$_SESSION['alert'] = "เกิดข้อผิดพลาดในการสร้าง Order: " . $dbconn->error;
            //header("Location:    $redirect");
            //exit();
        }
    } else {
        // if aleaydy exists orderID in iorder
        $row = $result_check->fetch_assoc();
        $newOrderID = $row["OrderID"];
    }

    // เช็คว่าสินค้าอยู่ในตะกร้าหรือไม่
    $sqlCheckCart = "SELECT  OrderID 
                         FROM    orderdetail
                         WHERE   OrderID = ?
                         AND     ProductID = ?
                         AND     Size = ?
                         AND     Crust = ?
                         ";

    $stmtCheckCart = $dbconn->prepare($sqlCheckCart);
    $stmtCheckCart->bind_param("iiii", $newOrderID, $productID, $sizeID, $crustID);
    $stmtCheckCart->execute();
    $resultCheckCart = $stmtCheckCart->get_result();

    if ($resultCheckCart->num_rows > 0) {
        // หากสินค้าอยู่ในตะกร้า ให้อัพเดทจำนวนสินค้า
        $sqlUpdateQuantity = "UPDATE    orderdetail 
        SET       Quantity = Quantity + ?
        WHERE     OrderID = ?
        AND       ProductID = ?
        AND       Size = ?
        AND       Crust = ?
        ";

        $stmtUpdateQuantity = $dbconn->prepare($sqlUpdateQuantity);
        $stmtUpdateQuantity->bind_param("iiiii", $quantity, $newOrderID, $productID, $sizeID, $crustID);

        if ($stmtUpdateQuantity->execute()) {
            echo json_encode(array("status" => "success", "msg" => "อัพเดทจำนวนสินค้าเรียบร้อย"));
            //$_SESSION['alert'] = "อัพเดทจำนวนสินค้าเรียบร้อย";
            //header("Location:    $redirect");
            //exit();
        } else {
            echo json_encode(array("status" => "error", "msg" => "เกิดข้อผิดพลาดในการอัพเดท"));
            //$_SESSION['alert'] = "เกิดข้อผิดพลาดในการอัพเดท: " . $dbconn->error;
            //header("Location:    $redirect");
            //exit();
        }
    } else {
        // หากสินค้าไม่อยู่ในตะกร้า ให้สร้าง Order Detail ใหม่
        $sqlCreateOrderDetail = "INSERT INTO orderdetail 
                                    (OrderID, ProductID, Size, Crust, Quantity)
                                    VALUES (?, ?, ?, ?, ?)";

        $stmtCreateOrderDetail = $dbconn->prepare($sqlCreateOrderDetail);
        $stmtCreateOrderDetail->bind_param("iiiii", $newOrderID, $productID, $sizeID, $crustID, $quantity);

        if ($stmtCreateOrderDetail->execute()) {
            echo json_encode(array("status" => "success", "msg" => "เพิ่มสินค้าในตะกร้าเรียบร้อย"));
            // $_SESSION['alert'] = "เพิ่มสินค้าในตะกร้าเรียบร้อย";
            // header("Location:    $redirect");
            // exit();
        } else {
            echo json_encode(array("status" => "error", "msg" => "เกิดข้อผิดพลาด"));
            //$_SESSION['alert'] = "เกิดข้อผิดพลาดในการสร้าง Order Detail: " . $dbconn->error;
            //header("Location:    $redirect");
            //exit();
        }
    }
}
// }
