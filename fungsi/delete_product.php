<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];

    $stmt = $conn->prepare("DELETE FROM productbite WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    
    if ($stmt->execute()) {
        echo "Product deleted successfully.";
    } else {
        echo "Error deleting product: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

header('Location: ../category.html');
exit();
?>
