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

$richMenuId_A = 'richmenu-800a9dac81e6ebbe2749228858a18f85';
$richMenuId_B = 'richmenu-6e1430949a5c68c10515606828dcd559';
$branchId = '10132'; //slipok
$apiKey = 'SLIPOKHD9SG2I'; //slipok
$PackageArray = array('hbogo', 'disney', 'gagaoolala', 'hbogo', 'joox', 'monomax', 'netflix', 'prime', 'spotify', 'trueid', 'viu', 'wetv', 'youku', 'youtube');


$messages = [];
$profileJson = Get_Profile($userId);


if ($profileJson == true) {
    setRichMenuForUser($userId, $richMenuId_B);
    //$imagePath = '../webhook/images/rich-menu-A.jpg'; // เปลี่ยนเป็นพาธของรูปภาพ Rich Menu ของคุณ
    //$result = uploadRichMenuImage($richMenuId, $imagePath);

    if ($text == 'ทดสอบ') {
        
    } elseif ($text == 'แจ้งการชำระเงิน' && $messageType == 'text') {
        $messages['replyToken'] = $replyToken;
        $flexMessageJsonPath = './flexmessage/form_order.json'; // เปลี่ยนเป็นเส้นทางที่ถูกต้องถ้าไฟล์อยู่ในโฟลเดอร์อื่น
        $flexMessageJson = file_get_contents($flexMessageJsonPath);
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

            // ย้ายไฟล์ที่บันทึกมาไปยังโฟลเดอร์ $newFilePath
            $newFilePath = $folderPath . $fileName;
            if (rename($uploadedImagePath, $newFilePath)) {
                $isSlipAuthentic = checkSlipAuthenticity($branchId, $apiKey, $newFilePath);
                $messages['replyToken'] = $replyToken;
                if ($isSlipAuthentic) {
                    // ถ้าสลิปถูกต้อง
                    $messages['messages'][] = getFormatTextMessage("สลิปถูกต้อง");
                    $messages['messages'][] = getFormatTextMessage("กำลังยืนยันในระบบ");
                    $messages['messages'][] = getFormatTextMessage("การชำระเงินสำเร็จ");
                } else {
                    $messages['messages'][] = getFormatTextMessage("สลิปไม่ถูกต้อง");
                }
            } else {
                $messages['replyToken'] = $replyToken;
                $messages['messages'][] = getFormatTextMessage("ไม่สามารถย้ายไฟล์ไปยังโฟลเดอร์ที่กำหนดได้");
            }
        } else {

            $messages['replyToken'] = $replyToken;
            $messages['messages'][] = getFormatTextMessage("ไม่สามารถดึง content รูปภาพ LINE ได้");
        }

        $encodeJson = json_encode($messages);
        $results = sentMessage($encodeJson, $LINEDatas);

    } elseif (preg_match('/Order\s*:\s*(\d+)/', $text, $matches)) {
        // หากพบเลขออเดอร์ในข้อความ
        $order = $matches[1]; // เก็บเลขออเดอร์ในตัวแปร $order
        $messages['replyToken'] = $replyToken;
        $flexMessageJsonPath = './flexmessage/callback_order.json';
        $flexMessageJson = file_get_contents($flexMessageJsonPath);
        $flexMessageJson = str_replace("ออเดอร์ของท่าน คือ :", "ออเดอร์ของท่าน คือ : $order", $flexMessageJson);
        $flexMessageJson = str_replace("cf:", "cf: $order", $flexMessageJson);
        $flexMessageArray = json_decode($flexMessageJson, true);
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
        $flexMessageJson = file_get_contents('./flexmessage/form.json'); // อ่าน JSON จากไฟล์
        $logFilePath = "flex_message_log.txt"; // ไฟล์ log
        $result = sendFlexMessage($userId, $flexMessageJson, $logFilePath); // ส่ง Flex Message        
    } elseif ($text == 'สมัครบริการเพิ่มเติม') {
        getPackagesAndSendImageCarousel($userId);
    } else {
        $ProductArray = getAllProductsByProductData();
        if (in_array($text, $PackageArray)) {
            getProductsAndSendImageCarousel($userId,$text);
            exit();
        }
        elseif(in_array($text, $ProductArray)){
        $order = createNewOrder($userId,$text,'order_a'); 
        $image = getProduct($text, "imageUrl");
        $messages['replyToken'] = $replyToken;
        $flexMessageJsonPath = './flexmessage/callback_order.json';
        $flexMessageJson = file_get_contents($flexMessageJsonPath);
        
        $flexMessageJson = str_replace("https://www.streamth.co/wp-content/uploads/2023/09/FM_GF_002.jpg", $image, $flexMessageJson);

        $flexMessageJson = str_replace("ออเดอร์ของท่าน คือ :", "ออเดอร์ของท่าน คือ : $order", $flexMessageJson);
        $flexMessageJson = str_replace("cf:", "cf: $order", $flexMessageJson);
        $flexMessageArray = json_decode($flexMessageJson, true);
        $encodedJson = json_encode($flexMessageArray);
        $results = sendFlexMessage($userId, $encodedJson, $logFilePath);
        }
        $message = getFormatTextMessage("สวัสดีคุณ " . $profileJson['displayName']);
        $results = sentMessage(json_encode(['replyToken' => $replyToken, 'messages' => [$message],]), $LINEDatas);
    }
} elseif ($profileJson == false) {
    setRichMenuForUser($userId, $richMenuId_A);
    if ($text = 'สมัครสมาชิก') {
        $result = sendFlexMessage($userId, file_get_contents('./flexmessage/resgister.json'), 'flex_message_log.txt');
    } elseif ($text = 'เกี่ยวกับเรา') {
        $message = getFormatTextMessage("สวัสดีคุณ " . $profileJson['displayName'] . "เราคือบลาๆๆๆๆๆ");
        $results = sentMessage(json_encode(['replyToken' => $replyToken, 'messages' => [$message],]), $LINEDatas);
    } elseif ($text = 'วิธีการสมัคร') {
        $message = getFormatTextMessage("สวัสดีคุณ " . $profileJson['displayName'] . "นี่คือวิธีการสมัคร บลาๆๆ");
        $results = sentMessage(json_encode(['replyToken' => $replyToken, 'messages' => [$message],]), $LINEDatas);
    } elseif ($text = 'FAQ') {
        $message = getFormatTextMessage("สวัสดีคุณ " . $profileJson['displayName'] . "คำถามที่พบบ่อย บลาๆๆ");
        $results = sentMessage(json_encode(['replyToken' => $replyToken, 'messages' => [$message],]), $LINEDatas);
    } else {
        $messages['replyToken'] = $replyToken;
        $flexMessageJson = file_get_contents('./flexmessage/resgister.json'); // อ่าน JSON จากไฟล์
        $logFilePath = "flex_message_log.txt"; // ไฟล์ log
        $result = sendFlexMessage($userId, $flexMessageJson, $logFilePath);
    }
}
?>
