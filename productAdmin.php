<?php
session_start();
include("database/dbconnect.php");
include("config/informationUser.php");

if ($_SESSION['userType'] != 'a') {
    header("Location: config/logout.php");
    print_r($_SESSION);
    exit();
}

$Total = 0;
$deliveryStatus = "not_shipped";

$sql = "SELECT          *, u.Name AS UserName, date_format(o.Odate, '%d/%m/%Y') AS date, date_format(o.Odate, '%T') AS time , o.Address as Address , o.Phone as Phone
        FROM            iorder o
        INNER JOIN      users u ON o.UserID = u.UserID
        WHERE           o.Total != ?
        AND             o.DeliveryStatus = ?
        ORDER BY        o.OrderID DESC
        ";
$stmtdemo = $dbconn->prepare($sql);
$stmtdemo->bind_param("ds", $Total, $deliveryStatus);
$stmtdemo->execute();
$resultdemo = $stmtdemo->get_result();
$numrows = $resultdemo->num_rows;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrderList Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/home.css">
    <link rel="stylesheet" href="style/addToCartForm.css">
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

        <?php if ($numrows != 0) { ?>
            <div class="container" style="margin-top: 50px; position: relative; top: 30px;">
                <div class="row bg-body rounded-top p-3">
                    <div class="col fw-bold fs-4">ประวัติการสั่งซื้อ</div>
                </div>
                <div class="row bg-body p-3">
                    <div class="col-1 d-flex align-items-center fw-bold">OrderID(
                        <?= $numrows ?>)
                    </div>
                    <div class="col-1 d-flex align-items-center fw-bold">สั่งเมื่อ</div>
                    <div class="col-1 d-flex align-items-center fw-bold">ลูกค้า</div>
                    <div class="col-2 d-flex align-items-center fw-bold">ที่อยู่</div>
                    <div class="col-4 d-flex align-items-center fw-bold">รายละเอียด</div>
                    <div class="col-1 d-flex justify-content-center fw-bold">ราคารวม</div>
                    <div class="col-1 d-flex justify-content-center fw-bold">การชำระ</div>
                    <div class="col-1 d-flex justify-content-center fw-bold">การจัดส่ง</div>
                    <hr class="mt-2">
                </div>

                <?php
                while ($row = $resultdemo->fetch_assoc()) {
                    $OrderID = $row['OrderID'];
                ?>
                    <div class="row bg-body p-3">

                        <div class="col-1 d-flex justify-content-center">
                            <?= $row['OrderID'] ?>
                        </div>
                        <div class="col-1">
                            <?= $row['date'] ?>
                            <br>
                            <?= $row['time'] ?>
                        </div>
                        <div class="col-1">
                            <?= $row['UserName'] ?>
                        </div>
                        <div class="col-2">
                            <?= $row['Address'] ?>
                            <br>
                            <?= $row['Phone'] ?>
                        </div>
                        <div class="col-4">
                            <?php
                             $sqlCartItems = "SELECT     p.ProductName, p.Image, p.Price, s.Name AS SizeName, c.Name AS CrustName, od.OrderDetailID, od.Quantity, (p.Price + s.Price +  c.Price ) as PricePerAmount, ((p.Price + s.Price +  c.Price ) * od.Quantity) AS TotalPrice
                             FROM        orderdetail od
                             INNER JOIN  products p ON od.ProductID = p.ProductID
                             INNER JOIN  size s ON od.Size = s.SizeID 
                             INNER JOIN  crust c ON od.Crust = c.CrustID
                             WHERE       od.OrderID IN (
                                     SELECT  OrderID
                                     FROM    iorder
                                     WHERE   OrderID = ?
                                     AND     Total != 0
                                     )";
                            $stmt = $dbconn->prepare($sqlCartItems);
                            $stmt->bind_param("i", $OrderID);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($rowDetail = $result->fetch_assoc()) {
                            ?>
                               <div class="row">
                                    <div class="col-3">
                                        <?= $rowDetail['ProductName'] ?>
                                    </div>
                                    <div class="col-1">
                                        <?= $rowDetail['SizeName'] ?>
                                    </div>
                                    <div class="col-2">
                                        ฿<?= $rowDetail['PricePerAmount'] ?>
                                    </div>
                                    <div class="col">
                                        <?= $rowDetail['CrustName'] ?>
                                    </div>
                                    <div class="col">
                                        x <?= $rowDetail['Quantity'] ?>
                                    </div>
                                    <div class="col-2 text-end">
                                        ฿<?= $rowDetail['TotalPrice'] ?>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-1 d-flex justify-content-center">
                            <?= $row['Total'] + 15 ?>
                        </div>
                        <div class="col-1 d-flex justify-content-center">
                            <?php if ($row['PaymentStatus'] === 'paid') {
                                echo '<span style="color: blue;">ชำระแล้ว</span>';
                            } else {
                                echo '<span style="color: red;">รอการชำระ</span>';
                            } ?>
                        </div>


                        <div class="col-1 d-flex justify-content-center">
                            <?php
                            if ($row['DeliveryStatus'] === "not_shipped") {
                                echo '<span style="color: red;">ยังไม่จัดส่ง</span>';
                            } elseif ($row['DeliveryStatus'] === "shipped") {
                                echo '<span style="color: green;">จัดส่งแล้ว</span>';
                            }
                            ?>
                        </div>
                        <form id="productAdmin" action="Deliveryout.php" method="post">
                            <input type="hidden" class="UserID" name="UserID" value="<?= $row['UserID'] ?>">
                            <input type="hidden" name="name" value="<?= $rowUser['Name'] ?>">
                            <input type="hidden" name="phone" value="<?= $rowUser['Phone'] ?>">
                            <input type="hidden" name="address" value="<?= $rowUser['Address'] ?>">
                            <input type="hidden" name="totalprice" value="<?= $row['Total'] ?>">
                            <input type="hidden" name="PaymentMethod" value="<?= $row['PayMethod'] ?>">
                            <div class="row bg-body d-flex justify-content-end ps-5 pb-3">
                                <div class="col-3 d-flex justify-content-end">
                                    <button class="btn bg-danger text-light d-flex align-items-center" type="submit" onclick="return confirm('ยืนยันกาารจัดส่ง')" name="deliout-btn">
                                        <img src="image/motorcycle-solid.svg" width="30px" height="30px" style="margin-right: 5px;">
                                        จัดส่งแล้ว
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                <?php
                }
                ?>
            </div>
        <?php } else { ?>
            <div class="container" style="margin-top: 50px; position: relative; top: 30px;">
                <div class="row bg-body rounded-top p-3">
                    <div class="col fw-bold fs-4">ประวัติการสั่งซื้อ</div>
                    <hr class="mt-2">
                </div>
                <div class="row bg-body d-flex justify-content-center rounded-bottom">
                    <div class="row pt-5">
                        <img src="image/empty_cart.svg" width="250px" height="250px">
                    </div>
                    <div class="row">
                        <h3 class="fw-bold d-flex justify-content-center">ไม่มีคำสั่งที่กำลังดำเนินการ</h3>
                    </div>
                    <div class="row mt-2">
                        <h4 class="d-flex justify-content-center">ยังไม่มีการสั่งซื้อใดๆ!</h4>
                    </div>
                    <div class="row mt-3 ps-5 pe-5 pb-5">
                    </div>
                </div>
            </div>
        <?php } ?>
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