<?php
function setRichMenuForUser($userId) {
    $channelAccessToken = con_line();
    $richMenuId = 'richmenu-9d1b8c2485fd88a3f463fb3eddcaa2a0';
    $apiUrl = 'https://api.line.me/v2/bot/user/' . $userId . '/richmenu/' . $richMenuId;

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $channelAccessToken
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    // สร้างไฟล์ log เพื่อเก็บข้อมูล
    $logFileName = 'rich_menu_log.txt';

    if ($httpStatus === 200) {
        $logMessage = 'กำหนด Rich Menu ใหม่ให้กับผู้ใช้สำเร็จ' . PHP_EOL;
    } else {
        $logMessage = 'เกิดข้อผิดพลาดในการกำหนด Rich Menu' . ' HTTP Status Code: ' . $httpStatus . ', Response: ' . $response . PHP_EOL;
    }

    file_put_contents($logFileName, $logMessage, FILE_APPEND);

}
function con_line()
{
    $channelAccessToken = '9M45apjYQRXZbqSH5JnVAPm0GSiFEfwSwOykyIUD6yptd/RMqZgju+sJ+67Flph79rzZ7BheT7RPI032V8Zr+GujrQkuzc2Wj2OH+YEamjeUtwW32C/ks2VQ3Qz/JZYowEGXVOthJpFc2cfDA+6iFwdB04t89/1O/w1cDnyilFU=';
    return $channelAccessToken;
}
?>