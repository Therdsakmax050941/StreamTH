<?php
function db_connect()
{   
    $servername = "127.0.0.1"; 
    $username = "ugzkj7rk5jeky"; 
    $password = "xq8htnm6wsau"; 
    $dbname = "dbpgpuxfegqmrr"; 



    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อฐานข้อมูล
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ตั้งค่าภาษาให้กับฐานข้อมูล
    $conn->set_charset("utf8");

    return $conn;
}
function con_line()
{
    $channelAccessToken = '9M45apjYQRXZbqSH5JnVAPm0GSiFEfwSwOykyIUD6yptd/RMqZgju+sJ+67Flph79rzZ7BheT7RPI032V8Zr+GujrQkuzc2Wj2OH+YEamjeUtwW32C/ks2VQ3Qz/JZYowEGXVOthJpFc2cfDA+6iFwdB04t89/1O/w1cDnyilFU=';
    return $channelAccessToken;
}


function checkUserExists($userId) {
      $conn =  db_connect();


    $sql = "SELECT * FROM users WHERE user_ID = '$userId'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $conn->close();
        return true; 
    } else {
        // ปิดการเชื่อมต่อกับฐานข้อมูล
        $conn->close();
        return false;
    }
}
?>
