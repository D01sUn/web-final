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

        <div class="container bg-white shadow p-3 mb-5 bg-body rounded card-container">
            <div class="container" style="padding: 50px;">
                <div class="row mb-4">
                    <div class="col-3 d-flex justify-content-center">
                        <img src="<?= $rowUser['ImageUrl'] ?>" class="profile-picture">
                    </div>
                    <div class="col-9">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label d-flex align-items-end">
                                <img src="image/person-outline.svg" width="30px" height="30px">
                                ชื่อ
                            </label>
                            <input value="<?= $rowUser["Name"] ?>" type="text" class="form-control rounded-pill shadow p-3 mb-4 bg-body rounded" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label d-flex align-items-end">
                                <img src="image/outline-email.svg" class="me-1" width="30px" height="30px">
                                อีเมล
                            </label>
                            <input value="<?= $rowUser["Email"] ?>" type="text" class="form-control rounded-pill shadow p-3 mb-4 bg-body rounded" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label d-flex align-items-end">
                            <img src="image/phone.svg" width="30px" height="30px" class="me-1">
                            เบอร์โทร
                        </label>
                        <input value="<?= $rowUser["Phone"] ?>" type="text" class="form-control rounded-pill shadow p-3 mb-4 bg-body rounded" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label d-flex align-items-end">
                            <img src="image/address-book.svg" width="30px" height="30px" class="me-1">
                            ที่อยู่
                        </label>
                        <input value="<?= $rowUser["Address"] ?>" type="text" class="form-control rounded-pill shadow p-3 mb-4 bg-body rounded" id="exampleInputPassword1">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-danger text-white rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#edit_member" style="padding: 15px 150px; font-size: 18px;">
                            แก้ไข
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal edit member-->
        <div class="modal fade" id="edit_member" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="edit.php" method="post" style="width: 100%;">
                        <div class="modal-body">
                            <!-- label -->
                            <div>
                                <h4>
                                    You can click on each of fields, to update your information.
                                </h4>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-3 mt-3">
                                        <input type="text" class="form-control" id="fname" placeholder="Enter First name" name="name" value="<?= $rowUser["Email"] ?>">
                                        <label for="fname">อีเมล</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" id="lname" placeholder="Enter Last name" name="username" value="<?= $rowUser["Name"] ?>">
                                        <label for="lname">ชื่อ</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" id="phone" placeholder="Enter Nick name" name="phone" value="<?= $rowUser["Phone"] ?>">
                                        <label for="phone">เบอร์โทร</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" id="phone" placeholder="Enter Nick name" name="phone" value="<?= $rowUser["Address"] ?>">
                                        <label for="phone">ที่อยู่</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mt-3 mb-3">
                                <input type="password" class="form-control" id="old_pwd" placeholder="Enter password" name="password">
                                <label for="old_pwd">รหัสเก่า</label>
                            </div>
                            <div class="form-floating mt-3 mb-3">
                                <input type="password" class="form-control" id="new_pwd" placeholder="Enter password" name="new_password">
                                <label for="new_pwd">รหัสใหม่</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Closed</button>
                            <button type="submit" class="btn btn-primary" name="edit-member">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
</body>

</html>