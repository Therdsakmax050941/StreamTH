<?php
function con_line()
{
    $channelAccessToken = '9M45apjYQRXZbqSH5JnVAPm0GSiFEfwSwOykyIUD6yptd/RMqZgju+sJ+67Flph79rzZ7BheT7RPI032V8Zr+GujrQkuzc2Wj2OH+YEamjeUtwW32C/ks2VQ3Qz/JZYowEGXVOthJpFc2cfDA+6iFwdB04t89/1O/w1cDnyilFU=';
    return $channelAccessToken;
}

function createRichMenu($richMenuData)
{
    // URL ของ API เพื่อสร้าง Rich Menu
    $apiUrl = 'https://api.line.me/v2/bot/richmenu';
    $channelAccessToken = con_line();
    // ส่งคำขอ HTTP POST เพื่อสร้าง Rich Menu
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($richMenuData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $channelAccessToken
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    // ตรวจสอบการสร้าง Rich Menu สำเร็จหรือไม่
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpStatus === 200) {
        return 'สร้าง Rich Menu สำเร็จ' . $response;
    } else {
        return 'เกิดข้อผิดพลาดในการสร้าง Rich Menu' . ' HTTP Status Code: ' . $httpStatus . ' Response: ' . $response;
    }
}
function uploadRichMenuImage($richMenuId, $imagePath)
{
    $channelAccessToken = con_line();
    $apiUrl = 'https://api.line.me/v2/bot/richmenu/' . $richMenuId . '/content';

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: image/jpeg',
        'Authorization: Bearer ' . $channelAccessToken
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($imagePath));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpStatus === 200) {
        return 'อัปโหลดรูปภาพ Rich Menu สำเร็จ';
    } else {
        return 'เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ Rich Menu' . ' HTTP Status Code: ' . $httpStatus . ', Response: ' . $response;
    }
}
// 1 = สร้าง
// 2 = update รูป
$i = 1;
// สร้าง
$richMenuJson = file_get_contents('./rich-json/richmenu_B.json');

// อัปรูป
$richMenuId = 'richmenu-6e1430949a5c68c10515606828dcd559';
$imagePath = './images/rich-menu-B.jpg';

if($i == 1){

    $richMenuData = json_decode($richMenuJson, true);
    
    $result = createRichMenu($richMenuData);
    if (strpos($result, 'สร้าง Rich Menu สำเร็จ') !== false) {
        echo 'สร้าง Rich Menu สำเร็จ' . $result;
    } else {
        echo 'เกิดข้อผิดพลาดในการสร้าง Rich Menu: ' . $result;
    } 
}else{

$result = uploadRichMenuImage($richMenuId, $imagePath); //upload image
echo $result; 
}

?>

