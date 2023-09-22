<?php
require_once('./function.php');
/*Return HTTP Request 200*/
http_response_code(200);
$LINEDatas['url'] = "https://api.line.me/v2/bot/message/reply";
$LINEDatas['token'] = con_line();
/*Get Data From POST Http Request*/
$datas = file_get_contents('php://input');
/*Decode Json From LINE Data Body*/
$deCode = json_decode($datas, true);

file_put_contents('log.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);

$replyToken = $deCode['events'][0]['replyToken'];
$userId = $deCode['events'][0]['source']['userId'];
$text = $deCode['events'][0]['message']['text'];
$messageType = $deCode['events'][0]['message']['type'];

$messages = [];
$profileJson = Get_Profile($userId);
if ($profileJson == true) {
    $message = getFormatTextMessage("สวัสดีคุณ " . $profileJson['displayName']);
    $results = sentMessage(json_encode(['replyToken' => $replyToken,'messages' => [$message],]), $LINEDatas);
    if($text == 'สมัครสมาชิก'){

    } elseif ($text == 'แจ้งการชำระเงิน' && $messageType == 'text') {
        $messages['replyToken'] = $replyToken;
        // แทนที่ด้วย JSON ของ Flex Message ที่คุณต้องการส่ง
        // อ่าน JSON จากไฟล์
        $flexMessageJsonPath = './flexmessage/form_order.json'; // เปลี่ยนเป็นเส้นทางที่ถูกต้องถ้าไฟล์อยู่ในโฟลเดอร์อื่น
        $flexMessageJson = file_get_contents($flexMessageJsonPath);

        // เพิ่มตัวแปร $flexMessageJson ลงในโค้ดเดิมที่คุณต้องการส่ง Flex Message

        $logFilePath = "flex_message_log.txt"; // ระบุเส้นทางและชื่อไฟล์ log ที่คุณต้องการใช้

        $result = sendFlexMessage($userId, $flexMessageJson, $logFilePath);
    } elseif ($messageType == 'image') {
        // ดึง Message ID ของรูปภาพ

        $messageId = $deCode['events'][0]['message']['id'];
        // เรียกใช้ฟังก์ชัน getLineMessageContent เพื่อดึงรูปภาพ LINE และเก็บไฟล์
        $uploadedImagePath = getLineMessageContent($messageId);

        if ($uploadedImagePath !== false) {
            // สร้างชื่อไฟล์จากชื่อผู้ส่งและวันเวลา
            $senderName = $deCode['events'][0]['source']['userId'];
            $currentDateTime = date("YmdHis");
            $fileName = $senderName . "_" . $currentDateTime . ".jpg";

            // ตำแหน่งของโฟลเดอร์ที่คุณต้องการเก็บไฟล์
            $folderPath = './image_slip/';

            // ตรวจสอบและสร้างโฟลเดอร์หากไม่มี
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            // ย้ายไฟล์ที่บันทึกมาไปยังโฟลเดอร์ที่คุณกำหนด
            $newFilePath = $folderPath . $fileName;
            if (rename($uploadedImagePath, $newFilePath)) {
                // ตรวจสอบสลิป
                $branchId = '10132';
                $apiKey = 'SLIPOKHD9SG2I';

                $isSlipAuthentic = checkSlipAuthenticity($branchId, $apiKey, $newFilePath);

                $messages['replyToken'] = $replyToken;


                if ($isSlipAuthentic) {
                    // ถ้าสลิปถูกต้อง
                    $messages['messages'][] = getFormatTextMessage("สลิปถูกต้อง");
                    $messages['messages'][] = getFormatTextMessage("กำลังยืนยันในระบบ");
                    $messages['messages'][] = getFormatTextMessage("การชำระเงินสำเร็จ");
                } else {
                    // ถ้าสลิปไม่ถูกต้อง
                    $messages['messages'][] = getFormatTextMessage("สลิปไม่ถูกต้อง");
                }
            } else {
                // ไม่สามารถย้ายไฟล์ไปยังโฟลเดอร์ที่กำหนดได้
                $messages['replyToken'] = $replyToken;
                $messages['messages'][] = getFormatTextMessage("ไม่สามารถย้ายไฟล์ไปยังโฟลเดอร์ที่กำหนดได้");
            }
        } else {
            // ไม่สามารถดึง content รูปภาพ LINE ได้
            $messages['replyToken'] = $replyToken;
            $messages['messages'][] = getFormatTextMessage("ไม่สามารถดึง content รูปภาพ LINE ได้");
        }
        //push mesage
        $encodeJson = json_encode($messages);
        $results = sentMessage($encodeJson, $LINEDatas);

    } elseif (preg_match('/Order\s*:\s*(\d+)/', $text, $matches)) {
        // หากพบเลขออเดอร์ในข้อความ
        $order = $matches[1]; // เก็บเลขออเดอร์ในตัวแปร $order
        $messages['replyToken'] = $replyToken;
        $flexMessageJsonPath = './flexmessage/callback_order.json';
        $flexMessageJson = file_get_contents($flexMessageJsonPath);

        // แทนที่ค่าใน JSON
        $flexMessageJson = str_replace("ออเดอร์ของท่าน คือ :", "ออเดอร์ของท่าน คือ : $order", $flexMessageJson);
        $flexMessageJson = str_replace("cf:", "cf: $order", $flexMessageJson);

        // แปลง JSON เป็นอาเรย์แบบแชช
        $flexMessageArray = json_decode($flexMessageJson, true);

        // ต่อมาคุณสามารถส่ง Flex Message ด้วย JSON ที่ถูกแก้ไขแล้ว
        $encodedJson = json_encode($flexMessageArray);
        $results = sendFlexMessage($userId, $encodedJson, $logFilePath);
    } elseif (preg_match('/cf\s*:\s*(\d+)/', $text, $matches)) {
        $order = $matches[1];

        $messages['replyToken'] = $replyToken;
        $messages['messages'][] = getFormatTextMessage("กำลังบันทึกข้อมูลเพื่อเริ่มรายการแจ้งยอดโอน");
        $messages['messages'][] = getFormatTextMessage("กรุณาส่งสลิปเพื่อยืนยันการชำระเงิน");
        $encodeJson = json_encode($messages);
        $results = sentMessage($encodeJson, $LINEDatas);
    } elseif ($text == 'บริการของเราทั้งหมด') {
        $messages['replyToken'] = $replyToken;

        $flexMessageJsonPath = './flexmessage/form.json'; // path flex message
        $flexMessageJson = file_get_contents($flexMessageJsonPath);


        $logFilePath = "flex_message_log.txt"; // \log

        $result = sendFlexMessage($userId, $flexMessageJson, $logFilePath);
    } else {
        $messages['replyToken'] = $replyToken;

        $flexMessageJsonPath = './flexmessage/resgister.json'; // path flex message
        $flexMessageJson = file_get_contents($flexMessageJsonPath);


        $logFilePath = "flex_message_log.txt"; // \log

        $result = sendFlexMessage($userId, $flexMessageJson, $logFilePath);
     
    }

} else {
    $messages['replyToken'] = $replyToken;

    $flexMessageJsonPath = './flexmessage/resgister.json'; 
    $flexMessageJson = file_get_contents($flexMessageJsonPath);
    $logFilePath = "flex_message_log.txt"; 

    $result = sendFlexMessage($userId, $flexMessageJson, $logFilePath);

}
$text = null;
?>