<?php
function getConnection() {
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "product_db"; 

    $conn = new mysqli($servername, $username, $password, $dbname); 

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function uploadFile($file) {
    $targetPath = "../uploads/" . basename($file['name']);
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $targetPath;
    } else {
        die("File upload failed.");
    }
}

function insertProduct($conn, $productName, $creator, $price, $category, $photo, $link) {
    $stmt = $conn->prepare("INSERT INTO productbite (name, creator, price, category, photo, link) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsss", $productName, $creator, $price, $category, $photo, $link);
    
    if ($stmt->execute()) {
        echo "Product added successfully.";
    } else {
        echo "Error adding product: " . $stmt->error; // Capture any errors
    }
    
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product-name'];
    $creator = $_POST['creator'];
    $price = (double)$_POST['price']; 
    $category = $_POST['category'];
    $photo = uploadFile($_FILES['photo']);
    $link = $_POST['link'];

    if (empty($productName) || empty($creator) || empty($price) || empty($category) || empty($photo) || empty($link)) {
        die("All fields are required.");
    }

    $conn = getConnection();
    insertProduct($conn, $productName, $creator, $price, $category, $photo, $link);
    $conn->close();

    header('Location: ../category.html');
    exit();
}
