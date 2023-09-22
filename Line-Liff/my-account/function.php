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
function getUsersByUserId($userId) {
    $conn = db_connect();

    $sql = "SELECT * FROM users WHERE user_ID = '$userId'";
    $result = $conn->query($sql);

    $users = array(); 

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row; 
        }
    }


    $conn->close();

    return $users; 
}

?>