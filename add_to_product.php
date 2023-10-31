<?php
session_start();
include("database/dbconnect.php");
include("config/informationUser.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/home.css">
    <link rel="stylesheet" href="style/information.css">
</head>

<body class="bg-danger" style="overflow: auto;">
    <div class="container-fluid" style="padding: 0;">
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
                        <?= $rowUser['Name'] ?>
                    </div>

                    <div class="dropdown">
                        <button class="drop-btn">
                            <img src="image/setting.svg" width="30px" height="30px">
                        </button>
                        <div class="dropdown-content">
                            <a href="productAdmin.php">หน้าหลัก</a>
                            <a href="informationAdmin.php">ข้อมูลส่วนตัว</a>
                            <a href="order_Admin.php">ดูรายการสั่งซื้อ</a>
                            <a href="add_to_product.php">เพิ่มรายการอาหาร</a>
                            <a href="config/logout.php">ออกจากระบบ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <div class="container" style="margin-top: 50px; position: relative; top: 30px;">
            <div class="container bg-white-bar shadow p-3 mb-5 bg-body rounded"
                style="width: 800px; height: 1100px; padding: 50px 0">
                <div class="container" style="padding: 50px">
                    <div class="row d-flex justify-content-center">
                        <div class="container d-flex justify-content-center">
                            <img src="image/logo.png" style="width: 200px; height: 200px" />
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center text-danger fs-1 fw-bold">
                        ValoRian Pizza
                    </div>
                    <div class="row">
                        <form action="add_product.php" method="post">
                            <div class="mb-3">
                                <label for="ProductName" class="form-label">ProductName</label>
                                <input type="text" class="form-control rounded-pill shadow p-3 mb-5 bg-body rounded"
                                    id="ProductName" name="ProductName" />
                            </div>

                            <div class="mb-3">
                                <label for="Descript" class="form-label">Descript</label>
                                <input type="text" class="form-control rounded-pill shadow p-3 mb-5 bg-body rounded"
                                    id="Descript" name="Descript" />
                            </div>

                            <div class="mb-3">
                                <label for="Price" class="form-label">Price</label>
                                <input type="text" class="form-control rounded-pill shadow p-3 mb-5 bg-body rounded"
                                    id="Price" name="Price" />
                            </div>

                            <div class="mb-3">
                                <label for="ImageUrl" class="form-label">ImageUrl</label>
                                <input type="url" class="form-control rounded-pill shadow p-3 mb-5 bg-body rounded"
                                    id="ImageUrl" name="ImageUrl" />
                            </div>

                            <div class="mb-3">
                                <label for="enumField">เลือกขนาด:</label>
                                <select id="enumField" name="Size">
                                    <option value="1">S</option>
                                    <option value="2">M</option>
                                    <option value="3">L</option>
                                    <option value="4">XL</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="enumField">เลือกขอบ:</label>
                                <select id="enumField" name="Crust">
                                    <option value="1">Thin</option>
                                    <option value="2">Thick and soft</option>
                                    <option value="3">Cheese</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-center" style="margin-top: 50px">
                                <button type="submit" class="btn btn-warning text-white rounded-pill"
                                    style="padding: 15px 40px">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
</body>

</html>