<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "product_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category = isset($_GET['category']) ? $_GET['category'] : 'all'; 
$id = isset($_GET['id']) ? $_GET['id'] : ''; 
$where_id = '';
$where_cat = '';
$limit = '';
if ($id) {
    $where_id .= ' WHERE product.id = '.$id;
    $limit .= ' LIMIT 1';
}
if ($category && $category != 'all') {
    if (!$id) {
        $where_cat .= ' WHERE ';
    }else{
        $where_Cat .= ' AND ';
    }
    $where_cat .= " category = '".$conn->real_escape_string($category)."'";
}
$sql = "SELECT * FROM productbite" .$where_id.$where_cat.$limit;
$result = $conn->query($sql);

$productsByCategory = [];
if ($result->num_rows > 0) {
    if ($id) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
        exit;
    }else{
        echo "<link rel='stylesheet' type='text/css' href='./assets/css/stylefetchproducts.css'>"; 
        echo "<div class='offerings-grid'>"; 
        while($row = $result->fetch_assoc()) {
            $productsByCategory[$row['category']][] = $row; 
        }
        
        foreach ($productsByCategory as $category => $products) {   
            if (count($products) > 0) {
                foreach ($products as $productbite) {
                    echo "<div class='card'>"; 
                    if ($productbite['photo']) {
                         echo "<img src='" . './uploads/'.htmlspecialchars($productbite['photo']) . "' alt='" . htmlspecialchars($product['name']) . "' />";
                    }
                    echo "<h3>" . htmlspecialchars($productbite['name']) . "</h3>";
                    echo "<p>By: " . htmlspecialchars($productbite['creator']) . "</p>";
                    echo "<p>IDR " . htmlspecialchars($productbite['price']) . "</p>"; 
                    echo "<a href='" . htmlspecialchars($productbite['link']) . "'>View Product</a><br>"; 
                    echo "<form action='./fungsi/delete_product.php' method='POST' style='display:inline;'>"; 
                    echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($productbite['id']) . "'>"; 
                    echo "<button type='submit'>Delete</button>";
                    echo "</form>";
                    echo "<a href='updateproduct.html?id=" . htmlspecialchars($productbite['id']) . "'><button>Update</button></a>"; 
                    echo "</div>";
                }
            } 
        }
        echo "</div>"; 
    }
    
} else {
    if ($id) {
        // Redirect back to category page
        header('Location: ../category.html');
        exit();
    }else{
        echo "<p>No products found.</p>"; 
    }
    
}

$conn->close();
?>
