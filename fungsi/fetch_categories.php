<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT category, COUNT(*) as product_count FROM products GROUP BY category";
$result = $conn->query($sql);

$categories = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categories[$row['category']] = $row['product_count'];
    }
}

$conn->close();
?>