<?php
include("database/dbconnect.php");


if (isset($_POST['deliout-btn'])) {
    // Get the checkout form data.
    $UserID = $_POST['UserID'];
    $PaymentMethod = $_POST['PaymentMethod'];
    $DeliveryStatus = "not_shipped";
    $sqlUpdateIorder = "";

    // Check if the user has an existing unpaid order.
    $sqlSelectIorder = "SELECT OrderID FROM iorder WHERE UserID = ? AND DeliveryStatus = ?";
    $stmtSelectIorder = $dbconn->prepare($sqlSelectIorder);
    $stmtSelectIorder->bind_param("is", $UserID, $DeliveryStatus);
    $stmtSelectIorder->execute();
    $resultSelectIorder = $stmtSelectIorder->get_result();

    // If the user has an existing unpaid order, update it with the new checkout data.
    if ($rowIorder = $resultSelectIorder->fetch_assoc()) {
        $orderID = $rowIorder['OrderID'];
        $DeliveryStatusUpdate = "shipped";

        if ($PaymentMethod === "cash") {
            $PaymentStatus = "paid";
            $sqlUpdateIorder = "UPDATE iorder SET PaymentStatus = ?, DeliveryStatus = ? WHERE OrderID = ?";
            $stmtUpdateIorder = $dbconn->prepare($sqlUpdateIorder);
            $stmtUpdateIorder->bind_param("ssi", $PaymentStatus, $DeliveryStatusUpdate, $orderID);
            $stmtUpdateIorder->execute();
            // Check if the update was successful.
            if ($stmtUpdateIorder->affected_rows > 0) {
                // The update was successful.
                echo 'Delivery Status Update successfully.';
            } else {
                // The update was not successful.
                echo 'Delivery Status Update error.';
            }
        } else {
            $sqlUpdateIorder = "UPDATE iorder SET DeliveryStatus = ? WHERE OrderID = ?";
            $stmtUpdateIorder = $dbconn->prepare($sqlUpdateIorder);
            $stmtUpdateIorder->bind_param("si", $DeliveryStatusUpdate, $orderID);
            $stmtUpdateIorder->execute();
            // Check if the update was successful.
            if ($stmtUpdateIorder->affected_rows > 0) {
                // The update was successful.
                echo 'Delivery Status Update successfully.';
            } else {
                // The update was not successful.
                echo 'Delivery Status Update error.';
            }
        }
    }
}

header("location:productAdmin.php");
exit(0);
