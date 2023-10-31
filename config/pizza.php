<?php
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $searchTerm = '%' . $search . '%';

    $sql = "SELECT *, s.Name AS SizeName, c.Name AS CrustName, (products.Price + s.Price +  c.Price) AS PriceTotal
        FROM products
        INNER JOIN size s ON products.Size = s.SizeID 
        INNER JOIN crust c ON products.Crust = c.CrustID
        WHERE ProductName LIKE ?;
        ";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
}else {
    $sql = "SELECT  *
            FROM    products";
    $result = $dbconn->query($sql);
}