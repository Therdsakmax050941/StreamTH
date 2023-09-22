<?php
function con_line()
{
    $channelAccessToken = '9M45apjYQRXZbqSH5JnVAPm0GSiFEfwSwOykyIUD6yptd/RMqZgju+sJ+67Flph79rzZ7BheT7RPI032V8Zr+GujrQkuzc2Wj2OH+YEamjeUtwW32C/ks2VQ3Qz/JZYowEGXVOthJpFc2cfDA+6iFwdB04t89/1O/w1cDnyilFU=';
    return $channelAccessToken;
}

function Get_Profile($userId)
{
    $url = "https://api.line.me/v2/bot/profile/" . urlencode($userId);

    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . con_line()
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   echo $response = curl_exec($ch);
    curl_close($ch);
    return $profileJson = $response; 
}
function sendLineNotifyMessage($accessToken, $message) {
    $url = 'https://notify-api.line.me/api/notify';
    
    // ตั้งค่า header สำหรับการส่งข้อมูล
    $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Bearer ' . $accessToken,
    ];

    // ข้อมูลที่จะส่ง
    $data = [
        'message' => $message,
    ];

    // ส่งข้อมูลโดยใช้ cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);

    // ตรวจสอบการส่งข้อมูล
    if ($response === FALSE) {
       return $noti =  "false";
    } else {
        return $noti =  "success";
    }
}
?>
