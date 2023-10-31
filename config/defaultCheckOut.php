<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Out</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/home.css">

    <style>
        .btn-danger {
            margin-right: 20px;
        }
    </style>
</head>

<body class="bg-danger" style="overflow:auto;">

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
                        <?= $rowUser['Name'] ?>
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
            <div class="row bg-body rounded-top pt-5 ps-5 pe-5 pb-3">
                <div class="col fw-bold fs-4">รายการสั่งซื้อ</div>
                <hr class="mt-2">
            </div>
            <?php
            while ($row = $resultCartItems->fetch_assoc()) {
            ?>
                <div class="row rounded-bottom bg-body ps-5 pb-5 pe-5">
                    <div class="col-5 d-flex">
                        <div class="col-s-4" style="border: 1px solid rgb(220, 53, 69); margin-right: 10px; border-radius: 10px;">
                            <img src="<?= $row['Image'] ?>" width="150px" height="80px">
                        </div>
                        <div class="col-s-8">
                            <div class="text-danger fw-bold">
                                <?= $row['ProductName'] ?>
                            </div>
                            <div class="d-flex">
                                <p class="me-2">ขนาด: <?= $row['SizeName'] ?></p>
                                <p>ขอบ: <?= $row['CrustName'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-7 d-flex flex-column justify-content-center">
                        <div class="row">
                            <div class="col d-flex justify-content-center align-items-center">
                                <div class="ps-3 pe-3">
                                    x <?= $row['Quantity'] ?>
                                </div>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center"><?= $row['TotalPrice'] ?> ฿</div>
                        </div>
                    </div>
                </div>
            <?php
                $totalPrice += $row["TotalPrice"];
            }
            ?>
            <div class="row bg-body d-flex justify-content-end ps-5 pb-5 pe-5 rounded-bottom">
                <hr class="mt-2">
                <div class="col-7 d-flex justify-content-end p-0 fw-bold">
                    รวม:
                </div>
                <div class="col-5 d-flex justify-content-end">
                    <?= $totalPrice+15 ?> ฿
                </div>
            </div>
        </div>


        <div class="container" style="margin-top: 50px; position: relative; top: 30px;">
            <div class="row bg-body rounded-top pt-5 ps-5 pe-5 pb-3">
                <div class="col fw-bold fs-4">การจัดส่ง</div>
                <hr class="mt-2">
                <div class="col">
                    <form action="checkoutform.php" method="post">
                        <button type="submit" name="default-address" class="btn col-12 bg-danger p-3 rounded-3 text-light">
                            ที่อยู่ปัจจุบัน
                        </button>
                    </form>
                </div>
                <div class="col">
                    <form action="checkoutform.php" method="post">
                        <button type="submit" name="another-address" class="btn col-12 p-3 rounded-3" style="border: 1px solid rgb(220, 53, 69); color:rgb(220, 53, 69);">
                            ที่อยู่อื่น
                        </button>
                    </form>
                </div>
            </div>

            <form action="config/checkout.php" id="checkoutForm" method="post">
                <input type="hidden" name="name" value="<?= $rowUser['Name'] ?>">
                <input type="hidden" name="phone" value="<?= $rowUser['Phone'] ?>">
                <input type="hidden" name="address" value="<?= $rowUser['Address'] ?>">
                <input type="hidden" name="totalprice" value="<?= $totalPrice ?>">
                <div class="row bg-body pt-5 ps-5 pe-5">
                    <div class="col fw-bold fs-4">ที่อยู่จัดส่ง</div>
                    <hr class="mt-2">
                    <div class="d-flex mb-1">
                        <div class="col">
                            ที่อยู่จัดส่ง
                        </div>
                        <div class="col">
                            <img src="image/address-book.svg" width="30px" height="30px">
                            <?= $rowUser['Address'] ?>
                        </div>
                    </div>
                    <div class="d-flex mb-1">
                        <div class="col">
                            ชื่อ
                        </div>
                        <div class="col">
                            <img src="image/person-outline.svg" width="30px" height="30px">
                            <?= $rowUser['Name'] ?>
                        </div>
                    </div>
                    <div class="d-flex mb-1">
                        <div class="col">
                            เบอร์โทร
                        </div>
                        <div class="col">
                            <img src="image/phone.svg" width="30px" height="30px">
                            <?= $rowUser['Phone'] ?>
                        </div>
                    </div>
                    <div class="bg-body d-flex mt-4">
                        <div class="col p-0 fw-bold">
                            รวม:
                        </div>
                        <div class="col d-flex justify-content-end">
                            <?= $totalPrice ?> ฿
                        </div>
                    </div>
                    <div class="bg-body d-flex">
                        <div class="col p-0 fw-bold">
                            ค่าจัดส่ง:
                        </div>
                        <div class="col d-flex justify-content-end">
                            15 ฿
                        </div>
                    </div>
                    <hr class="mt-2">
                </div>
                <div class="row bg-body d-flex justify-content-end ps-5 pe-5 pb-3">
                    <div class="col-7 d-flex justify-content-end p-0 fw-bold">
                        ราคารวม:
                    </div>
                    <div class="col-5 d-flex justify-content-end">
                        <?= $totalPrice+15 ?> ฿
                    </div>
                </div>
                <div class="row d-flex align-items-center bg-body ps-5 pe-5 pb-3">
                    <div class="col fw-bold fs-4">การชำระเงิน</div>
                    <hr class="mt-2">
                    <div class="col-3 d-flex justify-content-between">
                        <label for="payment_method_cash">
                            <img src="image/outline-payments.svg">
                            เงินสด
                        </label>
                        <input type="radio" name="payment_method" value="cash" required>
                    </div>
                    <div class="col-3 d-flex justify-content-between">
                        <label for="payment_method_qr_code">
                            <img src="image/money-cashier-qr-code-codes-tags-code-qr.svg">
                            QR Code
                        </label>
                        <input type="radio" name="payment_method" value="qr_code" required>
                    </div>
                </div>

                <div class="row bg-body d-flex justify-content-end ps-5 pe-5 pb-3">
                    <hr class="mt-2">
                    <div class="col-3 d-flex justify-content-end">
                        <button class="btn bg-danger text-light d-flex align-items-center" type="submit" name="checkout-btn">
                            <img src="image/wireless-checkout.svg" width="30px" height="30px" style="margin-right: 5px;">
                            Check Out
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- footer -->
        <div class="row p-0" style="margin-top: 100px;">
            <div class="col text-light" style="display: flex; justify-content: center;">
                ValoRian Pizza CSMSU @ 2023
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        // ตรวจสอบว่า Swal ถูกเรียกและกำหนดให้อยู่ในตัวแปร swalWithBootstrapButtons ถูกต้อง
        console.log(swalWithBootstrapButtons);

        // ที่ส่วนล่างของคำสั่ง JavaScript ของคุณ
        $("#checkoutForm").on("submit", function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มแบบปกติ

            let form = this;

            swalWithBootstrapButtons.fire({
                title: 'ยืนยันการสั่งซื้อ',
                text: 'คุณแน่ใจที่จะสั่งซื้อ',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, สั่งซื้อ!',
                cancelButtonText: 'ไม่, ยกเลิก',
                cancelButtonClass: 'btn btn-danger', // กำหนดคลาส CSS สำหรับปุ่ม "ไม่"
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let formUrl = $(form).attr("action");
                    let reqMethod = $(form).attr("method");
                    let formData = $(form).serialize();
                    $.ajax({
                        url: formUrl,
                        type: reqMethod,
                        data: formData,
                        success: function(data) {
                            let result = JSON.parse(data);
                            if (result.status == "success") {
                                console.log("Success", result);
                                swalWithBootstrapButtons.fire("Success", result.msg, result.status).then(function() {
                                    window.location.href = "home.php";
                                });
                            } else {
                                console.log("Feiled", result);
                                swalWithBootstrapButtons.fire("Feiled", result.msg, result.status);
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire('ยกเลิก', 'ไฟล์อมชื่อมูมปลองปลอม :)', 'error');
                }
            });
        });

        // $(document).ready(function() {
        //     $("#checkoutForm").submit(function(e) {
        //         e.preventDefault();
        //         let formUrl = $(this).attr("action");
        //         let reqMethod = $(this).attr("method");
        //         let formData = $(this).serialize();
        //         $.ajax({
        //             url: formUrl,
        //             type: reqMethod,
        //             data: formData,
        //             success: function(data) {
        //                 let result = JSON.parse(data);
        //                 if (result.status == "success") {
        //                     console.log("Success", result);
        //                     swal.fire("Success", result.msg, result.status).then(function() {
        //                         window.location.href = "home.php"; // แก้ไขตรงนี้
        //                     });
        //                 } else {
        //                     console.log("Feiled", result);
        //                     swal.fire("Feiled", result.msg, result.status);
        //                 }
        //             }
        //         })
        //     })
        // })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>