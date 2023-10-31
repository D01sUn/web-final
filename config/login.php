<?php
session_start();
include("../database/dbconnect.php");

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $_SESSION['error'] = "Please enter your username";
        header("Location: index.php");
        exit(); // ออกจากสคริปต์เพื่อไม่ให้รหัสด้านล่างทำงาน
    } elseif (empty($password)) {
        $_SESSION['error'] = "Please enter your password";
        header("Location: index.php");
        exit(); // ออกจากสคริปต์เพื่อไม่ให้รหัสด้านล่างทำงาน
    }

    $stmt = $dbconn->prepare("SELECT * FROM users WHERE Email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // check data in database already exists or not exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['UserID'] = $row['UserID'];
        $_SESSION['userType'] = $row['UserType'];

        echo $username . ' ' . $password;
        if ($row['UserType'] == 'a') {
            if (password_verify($password, $row['Password'])) {
                header("Location: ../productAdmin.php");
                exit();
            } else {
                $_SESSION['alert'] = "Username or password invalid please try again";
                header("Location: index.php");
                exit(); // ออกจากสคริปต์เพื่อไม่ให้รหัสด้านล่างทำงาน
            }
        } elseif ($row['UserType'] == 'c') {
            if (password_verify($password, $row['Password'])) {
                header("Location: ../home.php");
                exit();
            } else {
                $_SESSION['alert'] = "Username or password invalid please try again";
                header("Location: index.php");
                exit(); // ออกจากสคริปต์เพื่อไม่ให้รหัสด้านล่างทำงาน
            }
        }
    } else {
        // ไม่พบ username ในฐานข้อมูล
        $_SESSION['error'] = "Username not found in our system. Please check your username or sign up if you don't have an account.";
        header("Location: index.php");
        exit(); // ออกจากสคริปต์เพื่อไม่ให้รหัสด้านล่างทำงาน
    }
} else {
    // ถ้าไม่มีการส่งข้อมูล username และ password มา
    $_SESSION['error'] = "Please enter your username and password";
    header("Location: index.php");
    exit();
}
?>