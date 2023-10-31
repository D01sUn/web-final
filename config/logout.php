<?php
session_start();

if (isset($_SESSION['UserID'])) {
    session_destroy();

    header("Location: ../index.php");
    exit();
}else {
    header("Location: ../index.php");
    exit();
}
?>