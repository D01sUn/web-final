<?php
session_start();

if ($_SESSION['userType'] == 'c') {
    include("database/dbconnect.php");
    include("config/informationUser.php");
    include("config/pizza.php");
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style/home.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
    </head>

    <body class="bg-danger" style="overflow: auto;">
        <div class="container-fluid p-0">
            <div class="container-fluid bg-white header-container">
                <div class="d-flex justify-content-between sub-container">
                    <!-- left-section -->
                    <div class="d-flex justify-content-between d-flex align-items-center">
                        <div class="image-container">
                            <img src="image/logo.png" width="40px" height="40px">
                        </div>
                        <div class="fw-bold text-danger" style="font-size: 25px;">
                            ValoRian Pizza
                        </div>
                    </div>

                    <!-- right-section -->
                    <div class="right-section">
                        <div style="margin-right: 8px;">
                            <img src="<?= $rowUser['ImageUrl'] ?>" class="rounded-circle" style="width: 35px; height: 35px; object-fit:cover;">
                        </div>
                        <div class="fw-bold" style="font-size: 25px; margin-right: 10px; display: flex; align-items: center;">
                            <img src="image/person-outline.svg" width="30px" height="30px">
                            (<?= $rowUser['Name'] ?>) <?= $rowUser['Username'] ?> 
                        </div>

                        <a href="cart.php">
                            <button type="button" class="cart-btn">
                                <img src="image/cart-outline.svg" width="30px" height="30px">
                                <?php
                                if ($count != 0) {
                                    echo '<div class="bg-danger text-white rounded-circle notification-cart">';
                                    echo $count;
                                    echo '</div>';
                                }
                                ?>
                            </button>
                        </a>

                        <div class="dropdown">
                            <button class="drop-btn">
                                <img src="image/setting.svg" width="30px" height="30px">
                            </button>
                            <div class="dropdown-content">
                                <a href="home.php">หน้าหลัก</a>
                                <a href="info.php">ข้อมูลส่วนตัว</a>
                                <a href="orderlist.php">รายการสั่งซื้อ</a>
                                <a href="config/logout.php">ออกจากระบบ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" style="margin-top: 50px; position: relative; top: 30px;">
                <!-- <div class="container rounded d-flex justify-content-center" style="height: 300px;">
                    <img src="https://cdn.1112.com/1112/public/images/banners/Sep23/BOGO_Pizza_1440_TH.jpg" width="auto" height="300px">
                </div> -->
                <div id="carouselExampleControls" class="carousel slide rounded" data-bs-ride="carousel">
                    <div class="carousel-inner rounded">
                        <div class="carousel-item active">
                            <img src="https://cdn.1112.com/1112/public/images/banners/Sep23/BOGO_Pizza_1440_TH.jpg" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="https://cdn.1112.com/1112/public/images/banners/Oct2023/Ham_Cheese_1440_TH_1.jpg" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="https://cdn.1112.com/1112/public/images/banners/Sep23/sqaure_1440-th.jpg" class="d-block w-100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <?php
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    if ($count % 4 == 0) {
                        echo '<div class="row d-flex justify-content-center" style="margin-top: 20px;">';
                    }
                ?>
                    <div class="col-3 rounded-3 d-flex flex-column align-items-center product-container">
                        <div class="row m-0" style="height: 216px; width: 230px;">
                            <img src="<?= $row["Image"] ?>" style="padding: 0;">
                            <div class="p-0">
                                <h1 class="text-danger" style="font-size: 24px; line-height: 15px; margin-bottom: 0px; text-align: center; font-weight: 700;">
                                    <?= $row["ProductName"] ?>
                                </h1>
                            </div>
                        </div>

                        <div class="rounded-pill add-to-cart-btn">
                            <a href="addToCartForm.php?productID=<?= $row['ProductID'] ?>" style="display: flex; justify-content: space-between; text-decoration: none;">
                                <span class="text-price"><?= $row['Price'] ?> ฿</span>
                                <span class="text-plus">เลือก</span>
                            </a>
                        </div>
                    </div>
                <?php
                    $count++;
                    if ($count % 4 == 0) {
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <div class="row p-0" style="margin-top: 100px;">
                <div class="col text-light" style="display: flex; justify-content: center;">
                    ValoRian Pizza CSMSU @ 2023
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>

    </html>
<?php } else {
    include("database/dbconnect.php");
    //include("config/informationUser.php");
    include("config/pizza.php");
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style/home.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
    </head>

    <body class="bg-danger" style="overflow: auto;">

        <div class="container-fluid p-0">
            <div class="container-fluid bg-white header-container">
                <div class="d-flex justify-content-between sub-container">
                    <!-- left-section -->
                    <div class="d-flex justify-content-between d-flex align-items-center">
                        <div class="image-container">
                            <img src="image/logo.png" width="40px" height="40px">
                        </div>
                        <div class="fw-bold text-danger" style="font-size: 25px;">
                            ValoRian Pizza
                        </div>
                    </div>

                    <!-- right-section -->
                    <div class="right-section">
                        <a href="index.php">
                            <button type="button" class="cart-btn">
                                <img src="image/cart-outline.svg" width="30px" height="30px">
                            </button>
                        </a>

                        <div class="login">
                            <a href="index.php">
                                <button class="drop-btn">
                                    <img src="image/login.svg" width="30px" height="30px">
                                    <span>เข้าสู่ระบบ</span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" style="margin-top: 50px; position: relative; top: 30px;">
                <div id="carouselExampleControls" class="carousel slide rounded" data-bs-ride="carousel">
                    <div class="carousel-inner rounded">
                        <div class="carousel-item active">
                            <img src="https://cdn.1112.com/1112/public/images/banners/Sep23/BOGO_Pizza_1440_TH.jpg" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="https://cdn.1112.com/1112/public/images/banners/Oct2023/Ham_Cheese_1440_TH_1.jpg" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="https://cdn.1112.com/1112/public/images/banners/Sep23/sqaure_1440-th.jpg" class="d-block w-100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <?php
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    if ($count % 4 == 0) {
                        echo '<div class="row d-flex justify-content-center" style="margin-top: 20px;">';
                    }
                ?>
                    <div class="col-3 rounded-3 d-flex flex-column align-items-center product-container">
                        <div class="row m-0" style="height: 216px; width: 230px;">
                            <img src="<?= $row["Image"] ?>" style="padding: 0;">
                            <div class="p-0">
                                <h1 class="text-danger" style="font-size: 24px; line-height: 15px; margin-bottom: 0px; text-align: center; font-weight: 700;">
                                    <?= $row["ProductName"] ?>
                                </h1>
                            </div>
                        </div>

                        <div class="rounded-pill add-to-cart-btn">
                            <a href="index.php" style="display: flex; justify-content: space-between; text-decoration: none;">
                                <span class="text-price"><?= $row['Price'] ?> ฿</span>
                                <span class="text-plus">เลือก</span>
                            </a>
                        </div>
                    </div>
                <?php
                    $count++;
                    if ($count % 4 == 0) {
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <div class="row p-0" style="margin-top: 100px;">
                <div class="col text-light" style="display: flex; justify-content: center;">
                    ValoRian Pizza CSMSU @ 2023
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>

    </html>
<?php } ?>