<?php
function con_line()
{
    $channelAccessToken = '9M45apjYQRXZbqSH5JnVAPm0GSiFEfwSwOykyIUD6yptd/RMqZgju+sJ+67Flph79rzZ7BheT7RPI032V8Zr+GujrQkuzc2Wj2OH+YEamjeUtwW32C/ks2VQ3Qz/JZYowEGXVOthJpFc2cfDA+6iFwdB04t89/1O/w1cDnyilFU=';
    return $channelAccessToken;
}
function pushMsg($arrayHeader, $arrayPostData) {
    $strUrl = "https://api.line.me/v2/bot/message/push";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $strUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    // เพิ่มโค้ดสำหรับเขียนข้อมูลลงในไฟล์ log
    if ($result === false) {
        // การส่งข้อผิดพลาดไปยังไฟล์ log
        $error = curl_error($ch);
        $logData = date('Y-m-d H:i:s') . " - Error: " . $error . "\n";
        file_put_contents('error.log', $logData, FILE_APPEND);
    } else {
        // บันทึกการสำเร็จไปยังไฟล์ log
        $logData = date('Y-m-d H:i:s') . " - Success: " . $result . "\n";
        file_put_contents('success.log', $logData, FILE_APPEND);
    }
}

$channelAccessToken = con_line();
if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer " . $channelAccessToken;

    $arrayPostData['to'] = $userId;
    $arrayPostData['messages'][0]['type'] = "flex";
    $arrayPostData['messages'][0]['altText'] = "Flex Message ทดสอบ";
    $arrayPostData['messages'][0]['contents'] = [
        "type" => "bubble",
        "header" => [
            "type" => "box",
            "layout" => "vertical",
            "contents" => [
                [
                    "type" => "text",
                    "text" => "🎊สมัครสมาชิกสำเร็จ",
                    "align" => "center",
                    "size" => "xl"
                ]
            ]
        ],
        "footer" => [
            "type" => "box",
            "layout" => "vertical",
            "spacing" => "sm",
            "contents" => [
                [
                    "type" => "button",
                    "style" => "primary",
                    "height" => "sm",
                    "action" => [
                        "type" => "message",
                        "label" => "บริการของเราทั้งหมด",
                        "text" => "บริการของเราทั้งหมด"
                    ]
                ]
            ],
            "flex" => 0
        ]
    ];

    pushMsg($arrayHeader, $arrayPostData);
}
?>