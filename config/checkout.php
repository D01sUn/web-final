<?php
include("../database/dbconnect.php");
session_start();

$redirect = "../home.php";

// if (isset($_POST['checkout-btn'])) {
    // Get the checkout form data.
    $name = $_POST['name'];
    $phone = 'เบอร์โทร : ' . $_POST['phone'];
    $address = 'ที่อยู่ : ' .$_POST['address'];
    $totalPrice = $_POST['totalprice']+15;
    $paymentMethod = $_POST['payment_method'];

    // Check if the user has an existing unpaid order.
    $sqlSelectIorder = "SELECT OrderID FROM iorder WHERE UserID = ? AND Total = 0";
    $stmtSelectIorder = $dbconn->prepare($sqlSelectIorder);
    $stmtSelectIorder->bind_param("i", $_SESSION['UserID']);
    $stmtSelectIorder->execute();
    $resultSelectIorder = $stmtSelectIorder->get_result();

    // If the user has an existing unpaid order, update it with the new checkout data.
    if ($rowIorder = $resultSelectIorder->fetch_assoc()) {
        $orderID = $rowIorder['OrderID'];
        //enum
        $paymentStatusUpdate = "";
        $paymentMethodUpdate = "";
        if ($paymentMethod === "cash") {
            $paymentStatusUpdate = "unpay";
            $paymentMethodUpdate = "cash";
        } elseif ($paymentMethod === "qr_code") {
            $paymentStatusUpdate = "paid";
            $paymentMethodUpdate = "qr";
        }

        $sqlUpdateIorder = "UPDATE iorder SET Name = ?, Phone = ?, Address = ?, PayMethod = ?, PaymentStatus = ?, Total = ?, Odate = NOW() WHERE OrderID = ?";
        $stmtUpdateIorder = $dbconn->prepare($sqlUpdateIorder);
        $stmtUpdateIorder->bind_param("sssssdi", $name, $phone, $address, $paymentMethodUpdate, $paymentStatusUpdate, $totalPrice, $orderID);
        $stmtUpdateIorder->execute();

        // Check if the update was successful.
        if ($stmtUpdateIorder->affected_rows > 0) {
            // The update was successful.
            // header("Location:    $redirect");
            // exit();
            // echo 'Place Order successfully.';
            echo json_encode(array("status" => "success", "msg" => "สั่งซื้อสำเร็จ"));
        } else {
            // The update was not successful.
            // header("Location:    $redirect");
            // exit();
            // echo 'An error occurred while place the order.';
            echo json_encode(array("status" => "error", "msg" => "สั่งซื้อไม่สำเร็จ"));
        }
    }
// }
