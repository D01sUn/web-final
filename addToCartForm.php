<?php
session_start();
include("database/dbconnect.php");
include("config/informationUser.php");
//begin price
$price = 0;
$size = 1; // ขนาดเล็ก
$crust = 1; // ขอบบาง

if (isset($_GET['size']) || isset($_GET['crust'])) {
    $size = $_GET['size'];
    $crust = $_GET['crust'];

    // ดึงข้อมูลขนาด
    $sqlSize = "SELECT Price
                FROM   size
                WHERE  SizeID = ?";
    $stmtSize = $dbconn->prepare($sqlSize);
    $stmtSize->bind_param("i", $size);
    $stmtSize->execute();
    $resultSize = $stmtSize->get_result();
    $rowSize = $resultSize->fetch_assoc();

    // ดึงข้อมูลขอบ
    $sqlCrust = "SELECT Price
                 FROM   crust
                 WHERE  CrustID = ?";
    $stmtCrust = $dbconn->prepare($sqlCrust);
    $stmtCrust->bind_param("i", $crust);
    $stmtCrust->execute();
    $resultCrust = $stmtCrust->get_result();
    $rowCrust = $resultCrust->fetch_assoc();

    // คำนวณราคารวม
    $price = $rowSize['Price'] + $rowCrust['Price'];
}

//select size
$sizeQuery = "SELECT * FROM size";
$sizeResult = $dbconn->query($sizeQuery);
//select crust
$crustQuery = "SELECT * FROM crust";
$crustResult = $dbconn->query($crustQuery);
//select product
$productQuery = "SELECT * FROM products";
$productResult = $dbconn->query($productQuery);

$sizes = array();
$crusts = array();
$product = array();

while ($sizeRow = $sizeResult->fetch_assoc()) {
    $sizes[$sizeRow['SizeID']] = $sizeRow['Name'];
}
while ($crustRow = $crustResult->fetch_assoc()) {
    $crusts[$crustRow['CrustID']] = $crustRow['Name'];
}
while ($productRow = $productResult->fetch_assoc()) {
    $product[$productRow['ProductID']] = $productRow['ProductName'];
}

//select product
if (isset($_GET['productID'])) {
    $prodcutID = $_GET['productID'];

    $sqlCurProduct = "SELECT  *
                      FROM    products
                      WHERE   ProductID = ?";
    $stmtCurrent = $dbconn->prepare($sqlCurProduct);
    $stmtCurrent->bind_param("i", $prodcutID);
    $stmtCurrent->execute();
    $result = $stmtCurrent->get_result();
    $row = $result->fetch_assoc();
}

/*if (isset($_SESSION['alert'])) {
    // แสดง alert
    echo "<script>alert('{$_SESSION['alert']}');</script>";

    // ลบตัวแปร $_SESSION['alert']
    unset($_SESSION['alert']);
}*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add To Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/home.css">
    <link rel="stylesheet" href="style/addToCartForm.css">
</head>

<body class="bg-danger" style="overflow: auto;">
    <div class="container-fluid p-0">
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
                                <a href="cart.php">รายการสั่งซื้อ</a>
                                <a href="config/logout.php">ออกจากระบบ</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="container" style="margin-top: 50px; position: relative; top: 30px;">

                <h2 class="product-select-text">เลือกถาดแรก</h2>

                <div class="bg-light rounded-3 pizza-item-container">
                    <div class="row">
                        <div class="col-md-7 image-product-container">
                            <div class="image-product">
                                <img src="<?= $row['Image'] ?>" style="width: 440px; height: 252px;">
                            </div>
                        </div>
                        <div class="col-md-5 product-detail-container">
                            <form action="addToCartForm.php" method="get">
                                <div class="row">
                                    <div class="col productname text-danger">
                                        <?= $row['ProductName'] ?>
                                    </div>
                                    <div class="col">
                                        <select class="form-select" aria-label="Default select example" name="productID" onchange="this.form.submit()">
                                            <?php
                                            //asociative array
                                            foreach ($product as $key => $name) {
                                                $selected = ($prodcutID == $key) ? "selected" : "";
                                                echo "<option value='$key' $selected>$name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <p class="product-descript">
                                <?= $row['Descript'] ?>
                            </p>
                            <div class="pizza-price">
                                <span>ราคา <?php echo $row['Price'] + $price ?> ฿</span>
                            </div>

                            <form action="addToCartForm.php" method="get">
                                <input type="hidden" name="productID" value="<?= $row['ProductID'] ?>">

                                <div class="row select-size">
                                    <div class="col-lg-3">เลือกขนาด</div>
                                    <div class="col-lg-9">
                                        <select class="form-select" aria-label="Default select example" name="size" onchange="this.form.submit()">
                                            <?php
                                            //asociative array
                                            foreach ($sizes as $key => $name) {
                                                $selected = ($size == $key) ? "selected" : "";
                                                echo "<option value='$key' $selected>$name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row select-crust">
                                    <div class="col-lg-3">เลือกขอบ</div>
                                    <div class="col-lg-9">
                                        <select class="form-select" aria-label="Default select example" name="crust" onchange="this.form.submit()">
                                            <?php
                                            //asociative array
                                            foreach ($crusts as $key => $name) {
                                                $selected = ($crust == $key) ? "selected" : "";
                                                echo "<option value='$key' $selected>$name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center">
                                <form id="addToCartForm" action="config/addToCart.php" method="post">
                                    <input type="hidden" class="ProductID" name="ProductID" value="<?= $row['ProductID'] ?>">
                                    <input type="hidden" name="Price" value="<?= $row['Price'] ?>">
                                    <input type="hidden" name="SizeID" value="<?php echo $size ?>">
                                    <input type="hidden" name="CrustID" value="<?php echo $crust ?>">
                                    <input type="hidden" name="Quantity" value="1">
                                    <button type="submit" name="add-to-cart" class="rounded-3 select-pizza-btn">
                                        เลือกพิซซ่า
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row p-0" style="margin-top: 100px;">
                    <div class="col text-light" style="display: flex; justify-content: center;">
                        ValoRian Pizza CSMSU @ 2023
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $("#addToCartForm").submit(function(e) {
                e.preventDefault();
                let productID = $(this).find(".ProductID").val();
                //console.log("submit");
                //console.log(productID);

                let formUrl = $(this).attr("action");
                let reqMethod = $(this).attr("method");
                let formData = $(this).serialize();
                $.ajax({
                    url: formUrl,
                    type: reqMethod,
                    data: formData,
                    success: function(data) {
                        let result = JSON.parse(data);
                        if (result.status == "success") {
                            console.log("Success", result);
                            swal.fire("Success", result.msg, result.status).then(function() {
                                window.location.href = "addToCartForm.php?productID=" + productID;
                            })
                        } else {
                            console.log("Feiled", result);
                            swal.fire("Feiled", result.msg, result.status);
                        }
                    }
                })
            })
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>