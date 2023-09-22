<?php
$servername = "127.0.0.1";
$username = "ugzkj7rk5jeky";
$password = "xq8htnm6wsau";
$dbname = "dbpgpuxfegqmrr";

$connection = mysqli_connect($servername, $username, $password, $dbname);

if (!$connection) {
    die("การเชื่อมต่อล้มเหลว: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
        $userId = $_POST['userId'];
        $name_line = $_POST['name_line'];
        $name = $_POST['full_name'];
        $name = mysqli_real_escape_string($connection, $name); // ป้องกัน SQL Injection
        $email = $_POST['Email'];
        $lineId = $_POST['lineId'];
        $phone = $_POST['phone'];
        $image = $_POST['image'];
        session_start();
        $_SESSION['userId'] = $userId;
        

    // ตรวจสอบว่ามีข้อมูลซ้ำในฐานข้อมูลหรือไม่
    $checkDuplicateSql = "SELECT * FROM users WHERE DisplayName = '$name' OR email = '$email'";
    $result = mysqli_query($connection, $checkDuplicateSql);

    if (mysqli_num_rows($result) > 0) {
        $noti =  "ชื่อหรืออีเมลล์นี้มีอยู่ในระบบแล้ว";
    } else {
        // ถ้าไม่มีข้อมูลซ้ำ ให้ทำการ INSERT
        $insertSql = "INSERT INTO users (User_ID, DisplayName, full_name, image_url, email, lineId, phone) VALUES ('$userId','$name_line', '$name', '$image', '$email', '$lineId', '$phone')";

        if (mysqli_query($connection, $insertSql)) {
            header("location: ../Line-Liff/thank_you.php?userId={$userId}");
        } else {
            $noti = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
            header("location: ../Line-Liff/form.php?userId={$userId}&name={$name_line}&pictureUrl={$image}&noti={$noti}");
        }
    }

    
    mysqli_close($connection);
}

?>
