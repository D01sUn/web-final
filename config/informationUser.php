<?php
if (!empty($_SESSION['UserID'])) {
    $count = 0;
    //select user information
    $stmt = $dbconn->prepare("SELECT * FROM users WHERE UserID = ?");
    $stmt->bind_param("i", $_SESSION['UserID']);
    $stmt->execute();
    $resultUser = $stmt->get_result();
    $rowUser = $resultUser->fetch_assoc();

    // select cart amount
    $stmtIorder = $dbconn->prepare("SELECT OrderID FROM iorder WHERE UserID = ? AND Total = 0");
    $stmtIorder->bind_param("i", $_SESSION['UserID']);
    $stmtIorder->execute();
    $resultIorder = $stmtIorder->get_result();

    if ($resultIorder->num_rows > 0) {
        //$rowIorder = $resultIorder->fetch_assoc();
        //$count = $rowIorder['count(*)'];
        $rowIorder = $resultIorder->fetch_assoc();
        $OrderID = $rowIorder['OrderID'];

        $stmtOrderDetail = $dbconn->prepare("SELECT count(*) FROM orderdetail od
                                            INNER JOIN iorder o ON od.OrderID = o.OrderID
                                            WHERE   o.OrderID = ? 
                                            ");
        $stmtOrderDetail->bind_param("i", $OrderID);
        $stmtOrderDetail->execute();
        $resultOrderDetail = $stmtOrderDetail->get_result();

        if ($resultOrderDetail->num_rows > 0) {
            $rowOrderDetail = $resultOrderDetail->fetch_assoc();
            $count = $rowOrderDetail['count(*)'];
        }
    }
}
