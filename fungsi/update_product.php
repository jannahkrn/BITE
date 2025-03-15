<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

$connect = new mysqli($servername, $username, $password, $dbname);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
$id = $_POST['productid'];

$result = mysqli_query($connect, "SELECT * FROM productbite WHERE id='$id'");
$productbite = mysqli_fetch_assoc($result);
if (!$productbite) {
    header('Location: ../category.html');
    exit;
}

$name = $_POST['name'];
$creator = $_POST['creator'];
$price = $_POST['price'];
$category = $_POST['category'];
$link = $_POST['link'];
$photo = $_FILES['product_photo'];

$img = '';
if (!empty($photo['tmp_name'])) {
    $tujuan = '../uploads/';
    $ext	= array('png','jpg','jpeg','PNG','JPEG','JPG');
    $batas = $config['size'] ?? 1044070;
    $nama = $photo['name'];
    $x = explode('.', $nama);
    $ekstensi = strtolower(end($x));
    $ukuran	= $photo['size'];
    $photo_tmp = $photo['tmp_name'];	
    if(in_array($ekstensi, $ext) === true){
        if($ukuran < $batas){		
            $photoname   = $config['file_rename'] ?? uniqid() . "-" . time(); 
            $basename   = $photoname . "." . $ekstensi;
            move_uploaded_file($photo_tmp, $tujuan.$basename);
            $route = $tujuan.$basename;
            $img .= ", photo='".$basename."'";
        }else{
            echo '<script>
            alert("Update gagal ukuran file terlalu besar!");
            setTimeout(() => {
                window.location.href = "../updateproduct.html?id='.$id.'";
            }, 100); 
        </script>
        ';
        die();
        }
    }else{
         echo '<script>
            alert("Tipe file tidak di izinkan!");
            setTimeout(() => {
                window.location.href = "../updateproduct.html?id='.$id.'";
            }, 100); 
        </script>
        ';
        die();
    }
}

$stmt = $connect->prepare("UPDATE productbite SET name='".$name."', creator='".$creator."', price='".$price."', category='".$category."', link='".$link."'".$img." WHERE id=".$id);
$update = $stmt->execute();


if ($stmt) {
    echo '<script>
        alert("Berhasil Update Data");
        setTimeout(() => {
            window.location.href = "../category.html";
        }, 100); 
    </script>
    ';
    die();
} else {
    echo '<script>
        alert("Update gagal: '.mysqli_error($connect).'");
        setTimeout(() => {
            window.location.href = "../category.html";
        }, 100); 
    </script>
    ';
    die();
}

$stmt->close();
$connect->close();

?>
