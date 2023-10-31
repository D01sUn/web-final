<?php
session_start();
include("database/dbconnect.php");
include("config/informationUser.php");
// รหัสผู้ใช้งาน (ในกรณีนี้, คุณต้องกำหนดค่า userID ของผู้ใช้)
$userID = $_SESSION['UserID'];

// คำสั่ง SQL เพื่อดึงข้อมูลสินค้าในตะกร้า
$sqlCartItems = "SELECT     p.ProductName, p.Image, p.Price, s.Name AS SizeName, c.Name AS CrustName, od.OrderDetailID, od.Quantity, (p.Price + s.Price +  c.Price ) as PricePerAmount, ((p.Price + s.Price +  c.Price ) * od.Quantity) AS TotalPrice
                FROM        orderdetail od
                INNER JOIN  products p ON od.ProductID = p.ProductID
                INNER JOIN  size s ON od.Size = s.SizeID 
                INNER JOIN  crust c ON od.Crust = c.CrustID
                WHERE       od.OrderID IN (
                            SELECT  OrderID
                            FROM    iorder
                            WHERE   UserID = ?
                            AND     Total = 0
                            AND     DeliveryStatus = 'not_shipped'
                            )
                ORDER BY    od.OrderDetailID ASC";

$stmtCartItems = $dbconn->prepare($sqlCartItems);
$stmtCartItems->bind_param("i", $userID);
$stmtCartItems->execute();
$resultCartItems = $stmtCartItems->get_result();

$totalPrice = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>

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

        <?php if ($count != 0) { ?>
            <div class="container" style="margin-top: 50px; position: relative; top: 30px;">
                <div class="row bg-body rounded-top p-3">
                    <div class="col-1 d-flex justify-content-center align-items-center fw-bold">ลำดับ</div>
                    <div class="col-4 fw-bold">สินค้า(<?= $count ?>)</div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col d-flex justify-content-center fw-bold">ราคาต่อชิ้น</div>
                            <div class="col d-flex justify-content-center fw-bold">จำนวน</div>
                            <div class="col d-flex justify-content-center fw-bold">ราคารวม</div>
                            <div class="col d-flex justify-content-center fw-bold">แอคชั่น</div>
                        </div>
                    </div>
                    <hr class="mt-2">
                </div>

                <?php
                $itemNumber = 1; // Initialize the item number
                while ($row = $resultCartItems->fetch_assoc()) {
                ?>
                    <div class="row bg-body p-3">
                        <div class="col-1 d-flex justify-content-center align-items-center"><?= $itemNumber ?></div>
                        <div class="col-4 d-flex">
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
                                <div class="col d-flex justify-content-center align-items-center"><?= $row['PricePerAmount'] ?></div>
                                <div class="col d-flex justify-content-center align-items-center">
                                    <script>
                                        function confirmDecrease() {
                                            const inputQuantity = document.querySelector('.input-quantity');
                                            const quantityValue = inputQuantity.value;
                                            const quantityNumber = parseInt(quantityValue, 10);

                                            if (quantityNumber === 1) {
                                                if (confirm("ต้องการลบสินค้านี้หรือไม่")) {
                                                    return true;
                                                } else {
                                                    return false;
                                                }
                                            }
                                        }
                                    </script>

                                    <form action="config/updatecart.php" method="post">
                                        <input type="hidden" name="OrderDetailIDDecrease" value="<?= $row['OrderDetailID'] ?>">
                                        <div>
                                            <button type="submit" style="border: none;" name="decrease-btn" onclick="return confirmDecrease();">
                                                <img src="image/baseline-minus.svg">
                                            </button>
                                        </div>
                                    </form>

                                    <div class="ps-3 pe-3">
                                        <form action="config/updatecart.php" method="post">
                                            <input type="hidden" name="OrderDetailIDUpdate" value="<?= $row['OrderDetailID'] ?>">
                                            <input type="text" name="quantity" value="<?= $row['Quantity'] ?>" class="input-quantity" style="text-align: center; width: 50px;">
                                        </form>
                                    </div>

                                    <form action="config/updatecart.php" method="post">
                                        <input type="hidden" name="OrderDetailIDIncrease" value="<?= $row['OrderDetailID'] ?>">
                                        <div>
                                            <button type="submit" style="border: none;" name="increase-btn">
                                                <img src="image/baseline-plus.svg">
                                            </button>
                                        </div>
                                    </form>

                                </div>
                                <div class="col d-flex justify-content-center align-items-center">฿ <?= $row['TotalPrice'] ?></div>
                                <div class="col d-flex justify-content-center align-items-center text-danger">
                                    <form action="config/updatecart.php" method="post" class="delete-form">
                                        <input type="hidden" name="OrderDetailIDDelete" value="<?= $row['OrderDetailID'] ?>">
                                        <input type="hidden" class="product-name" value="<?= $row['ProductName'] ?>">
                                        <input type="hidden" class="size-name" value="<?= $row['SizeName'] ?>">
                                        <input type="hidden" class="crust-name" value="<?= $row['CrustName'] ?>">
                                        <button type="submit" name="delete-btn" style="border: none; background-color: white;">
                                            <img src="image/bin-outline.svg" width="30px" height="30px">
                                            ลบ
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    $totalPrice += $row["TotalPrice"];
                    $itemNumber++; // Increment the item number for the next item
                }
                ?>
                <div class="row bg-body d-flex justify-content-end ps-5 pe-5 pb-3">
                    <hr class="mt-2">
                    <div class="col-7 d-flex justify-content-end p-0 fw-bold">
                        ราคารวม:
                    </div>
                    <div class="col-5 d-flex justify-content-end">
                        <?= $totalPrice ?> ฿
                    </div>
                </div>
                <div class="row bg-body d-flex justify-content-end ps-5 pe-5 pb-3">
                    <div class="col-7 d-flex justify-content-end p-0 fw-bold">
                        ราคาที่ต้องจ่าย(ค่าส่ง 15 บาท):
                    </div>
                    <div class="col-5 d-flex justify-content-end">
                        <?= $totalPrice + 15 ?> ฿
                    </div>
                </div>
                <div class="row bg-body d-flex justify-content-end ps-5 pe-5 pb-3 rounded-bottom">
                    <div class="col-3 d-flex justify-content-end">
                        <a href="checkoutform.php" style="text-decoration: none;">
                            <button class="btn bg-danger text-light d-flex align-items-center">
                                ดำเนินการต่อ
                            </button>
                        </a>
                    </div>
                </div>
            </div>

        <?php } else { ?>
            <div class="container" style="margin-top: 50px; position: relative; top: 30px;">
                <div class="container bg-body rounded">
                    <div class="row pt-5">
                        <img src="image/empty_cart.svg" width="250px" height="250px">
                    </div>
                    <div class="row">
                        <h3 class="fw-bold d-flex justify-content-center">คุณยังไม่มีสินค้าในตะกร้า!</h3>
                    </div>
                    <div class="row mt-2">
                        <h4 class="d-flex justify-content-center">คุณยังไม่ได้เพิ่มสินค้าใดๆ ลงในตะกร้า!</h4>
                    </div>
                    <div class="row bg-body mt-3 ps-5 pe-5 pb-5 rounded">
                        <a class="d-flex justify-content-center" href="home.php" style="text-decoration: none;">
                            <button class="btn bg-danger text-light d-flex align-items-center" style="padding: 15px 170px;">
                                <span style="font-size: 22px; font-weight: bold;">เริ่มการสั่งซื้อ</span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
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
        $(".delete-form").on("submit", function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มแบบปกติ

            let form = this;
            let productName = $(form).find(".product-name").val();
            let sizeName = $(form).find(".size-name").val();
            let crustName = $(form).find(".crust-name").val();

            swalWithBootstrapButtons.fire({
                title: 'ยืนยันการลบ',
                text: 'คุณแน่ใจที่จะลบ ' + productName + ' ขนาด: ' + sizeName + ' ขอบ: ' + crustName,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ลบ!',
                cancelButtonText: 'ไม่, ยกเลิก',
                cancelButtonClass: 'btn btn-danger', // กำหนดคลาส CSS สำหรับปุ่ม "ไม่"
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let formUrl = $(form).attr("action");
                    let reqMethod = $(form).attr("method");
                    let formData = $(form).serialize();
                    console.log(crustName);
                    $.ajax({
                        url: formUrl,
                        type: reqMethod,
                        data: formData,
                        success: function(data) {
                            let result = JSON.parse(data);
                            if (result.status === 'success') {
                                swalWithBootstrapButtons.fire({
                                    title: 'ลบแล้ว!',
                                    text: 'รายการถูกลบแล้ว',
                                    icon: 'success'
                                }).then(function() {
                                    window.location.href = 'cart.php';
                                });
                            } else {
                                swalWithBootstrapButtons.fire('เกิดข้อผิดพลาด', 'ไม่สามารถลบรายการ', 'error');
                            }
                        }
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire('ยกเลิก', 'ไฟล์อมชื่อมูมปลองปลอม :)', 'error');
                }
            });
        });
    </script>
    <!-- <script>
        function confirmDecrease(form) {
            const inputQuantity = form.querySelector('.input-quantity');
            const quantityValue = inputQuantity.value;
            const quantityNumber = parseInt(quantityValue, 10);

            if (quantityNumber === 1) {
                if (confirm("ต้องการลบสินค้านี้หรือไม่")) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    </script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>