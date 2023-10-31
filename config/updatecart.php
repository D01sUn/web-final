<?php
include("../database/dbconnect.php");
session_start();

$redirect = "../cart.php";

if (isset($_POST['increase-btn'])) {
    $orderDetailID = $_POST['OrderDetailIDIncrease'];

    $sqlUpdateQuantity = "  UPDATE    orderdetail
                            SET         Quantity = Quantity + 1
                            WHERE       OrderDetailID = ?
                        ";
    $stmtUpdateQuantity = $dbconn->prepare($sqlUpdateQuantity);
    $stmtUpdateQuantity->bind_param("i", $orderDetailID);
    $stmtUpdateQuantity->execute();

    header("Location:    $redirect");
    exit();
} elseif (isset($_POST['decrease-btn'])) {
    $orderDetailID = $_POST['OrderDetailIDDecrease'];

    $sqlUpdateQuantity = "  UPDATE      orderdetail
                            SET         Quantity = Quantity - 1
                            WHERE       OrderDetailID = ?
                        ";
    $stmtUpdateQuantity = $dbconn->prepare($sqlUpdateQuantity);
    $stmtUpdateQuantity->bind_param("i", $orderDetailID);
    $stmtUpdateQuantity->execute();

    // ตรวจสอบจำนวนสินค้า
    $sqlGetQuantity = "SELECT Quantity FROM orderdetail WHERE OrderDetailID = ?";
    $stmtGetQuantity = $dbconn->prepare($sqlGetQuantity);
    $stmtGetQuantity->bind_param("i", $orderDetailID);
    $stmtGetQuantity->execute();
    $resultGetQuantity = $stmtGetQuantity->get_result();
    $quantity = $resultGetQuantity->fetch_assoc()['Quantity'];

    // ลบ order หากจำนวนสินค้าเหลือ 0
    if ($quantity == 0) {
        $sqlDeleteOrder = "DELETE FROM orderdetail WHERE OrderDetailID = ?";
        $stmtDeleteOrder = $dbconn->prepare($sqlDeleteOrder);
        $stmtDeleteOrder->bind_param("i", $orderDetailID);
        $stmtDeleteOrder->execute();
        
        // if () {
        //     $response = array('status' => 'success', 'msg' => 'ลบรายการสำเร็จ');
        //     echo json_encode($response);
        // } else {
        //     $response = array('status' => 'error', 'msg' => 'ลบรายการไม่สำเร็จ');
        //     echo json_encode($response);
        // }
    }

    header("Location:    $redirect");
    exit();
} elseif (isset($_POST['OrderDetailIDDelete'])) {
    $orderDetailID = $_POST['OrderDetailIDDelete'];
    $sqlDeleteOrder = "DELETE FROM orderdetail WHERE OrderDetailID = ?";
    $stmtDeleteOrder = $dbconn->prepare($sqlDeleteOrder);
    $stmtDeleteOrder->bind_param("i", $orderDetailID);

    if ($stmtDeleteOrder->execute()) {
        $response = array('status' => 'success', 'msg' => 'ลบรายการสำเร็จ');
        echo json_encode($response);
    } else {
        $response = array('status' => 'error', 'msg' => 'ลบรายการไม่สำเร็จ');
        echo json_encode($response);
    }
} elseif (isset($_POST['quantity']) && is_numeric($_POST['quantity']) && $_POST['quantity'] > 0) {
    $orderDetailID = $_POST['OrderDetailIDUpdate'];
    $quantity = $_POST['quantity'];

    $sqlUpdateQuantity = "  UPDATE      orderdetail
                            SET         Quantity = ?
                            WHERE       OrderDetailID = ?
                        ";
    $stmtUpdateQuantity = $dbconn->prepare($sqlUpdateQuantity);
    $stmtUpdateQuantity->bind_param("ii", $quantity, $orderDetailID);
    $stmtUpdateQuantity->execute();

    header("Location:    $redirect");
    exit();
}
