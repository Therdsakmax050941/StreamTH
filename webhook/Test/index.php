<?php
header("Cache-Control: no-cache, must-revalidate");
require_once('../function.php');




$userId = "U824367251f161b18ff7fb717c4881ada"; // รหัสผู้ใช้ที่คุณต้องการข้อมูลโปรไฟล์

$profileJson = Get_Profile($userId);

if ($profileJson != false) {
     // แสดงข้อมูลโปรไฟล์ที่ได้รับ
     echo "Display Name: " . $profileJson['displayName'] . "<br>";
     echo "User ID: " . $profileJson['userId'] . "<br>";
     if (isset($profileJson['image'])) {
         echo "email: " . $profileJson['email']['url'] . "<br>";
     } else {
         echo "ไม่มีรูปโปรไฟล์";
     }
   
} else {
    echo "เกิดข้อผิดพลาดในการร้องขอข้อมูลโปรไฟล์";
    
}