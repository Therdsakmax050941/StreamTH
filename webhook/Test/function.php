<?php
function pushMsg($arrayHeader,$arrayPostData){
    $strUrl = "https://api.line.me/v2/bot/message/push";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$strUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close ($ch);
 }
function db_con()
{
    $db_status = 0;
    if ($db_status == 1) {
        $dbHost = 'localhost'; // โฮสต์ฐานข้อมูล
        $dbName = 'streaming'; // ชื่อฐานข้อมูล
        $dbUser = 'root'; // ชื่อผู้ใช้ของฐานข้อมูล
        $dbPass = ''; // รหัสผ่านของฐานข้อมูล
    } else {
        $dbHost = '127.0.0.1'; // โฮสต์ฐานข้อมูล
        $dbUser = 'ugzkj7rk5jeky'; // ชื่อผู้ใช้ของฐานข้อมูล
        $dbPass = 'xq8htnm6wsau'; // รหัสผ่านของฐานข้อมูล
        $dbName = 'dbpgpuxfegqmrr';
    }

    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage());
    }
}
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

    $response = curl_exec($ch);
    curl_close($ch);
    $profileJson = $response; // ไม่ต้องทำ json_decode ในที่นี้
    $check_member = checkUser_member($userId);
    if ($check_member === false) {
        return false; // แปลง JSON string เป็น array ก่อนการบันทึก
    } else {
        return json_decode($profileJson, true); // แปลง JSON string เป็น array ก่อนการคืนค่า
    }
}


function checkUser_member($userId)
{
    $pdo = db_con(); // เรียกใช้ฟังก์ชัน db_con() เพื่อเชื่อมต่อกับฐานข้อมูล
    if (!$pdo) {
        return 'เกิดข้อผิดพลาดในการเชื่อมต่อกับฐานข้อมูล';
    }

    $stmt = $pdo->prepare("SELECT `DisplayName` FROM users WHERE User_ID = :userId");
    $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        return true;
    } else {
        return false;
    }
}
function sendFlexMessage($to, $flexMessageJson, $logFilePath)
{
    $url = "https://api.line.me/v2/bot/message/push";

    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer " . con_line()
    ];

    $data = [
        "to" => $to,
        "messages" => [
            [
                "type" => "flex",
                "altText" => "This is a Flex Message",
                "contents" => json_decode($flexMessageJson, true)
            ]
        ]
    ];

    $dataJson = json_encode($data);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    file_put_contents($logFilePath, "Response: " . $response . "\n", FILE_APPEND);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpStatus === 200) {
        // บันทึกผลลัพธ์ลงในไฟล์ log
        file_put_contents($logFilePath, "ส่ง Flex Message สำเร็จ001\n", FILE_APPEND);
        return true; // ส่ง Flex Message สำเร็จ
    } else {
        // บันทึกผลลัพธ์ลงในไฟล์ log
        file_put_contents($logFilePath, "การส่ง Flex Message ไม่สำเร็จ001\n", FILE_APPEND);
        return false; // การส่ง Flex Message ไม่สำเร็จ
    }
}
function getLineMessageContent($messageId)
{
    $url = "https://api-data.line.me/v2/bot/message/{$messageId}/content";

    $ch = curl_init($url);

    // ตั้งค่า cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Authorization: Bearer ' . con_line()
        )
    );

    // ส่งคำขอ GET ไปยัง API
    $response = curl_exec($ch);

    // ตรวจสอบสถานะการเรียก API
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // ปิดการใช้งาน cURL
    curl_close($ch);

    // ตรวจสอบการสำเร็จของการดึงข้อมูล
    if ($httpStatus === 200) {
        // กำหนดโฟลเดอร์ที่คุณต้องการเก็บรูปภาพ
        $uploadDir = './image_slip/';

        // ตรวจสอบและสร้างโฟลเดอร์หากไม่มี
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // สร้างชื่อไฟล์จากชื่อผู้ส่งและวันเวลา
        $currentDateTime = date("YmdHis");
        $fileName = $currentDateTime . '_' . $messageId . '.jpg';

        // ตำแหน่งของไฟล์ที่จะบันทึก
        $filePath = $uploadDir . $fileName;

        // บันทึกรูปภาพลงในไฟล์
        if (file_put_contents($filePath, $response) !== false) {
            // คืนค่าเส้นทางไฟล์ที่บันทึกเมื่อเสร็จสิ้น
            return $filePath;
        } else {
            return false; // การบันทึกไฟล์ไม่สำเร็จ
        }
    } else {
        return false; // การเรียก API ไม่สำเร็จ
    }
}



function checkSlipAuthenticity($branchId, $apiKey, $filePath)
{
    $url = "https://api.slipok.com/api/line/apikey/" . $branchId;

    $headers = [
        'Content-Type: multipart/form-data',
        'x-authorization: ' . $apiKey
    ];

    $fields = [
        'files' => new CURLFile($filePath, 'image/png')
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return $response;
    } else {
        // ตรวจสอบคำตอบจาก API และคืนค่าตามเงื่อนไขของคุณ
        // ตัวอย่าง: ถ้าคำตอบมีข้อความ "สลิปถูกต้อง" ให้คืนค่า true
        //return (strpos($response, "สลิปถูกต้อง") !== false);
        return $response;
    }
}

function getFormatTextMessage($text)
{
    $datas = [];
    $datas['type'] = 'text';
    $datas['text'] = $text;

    return $datas;
}

function sentMessage($encodeJson, $datas)
{
    $datasReturn = [];
    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $datas['url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $encodeJson,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $datas['token'],
                "cache-control: no-cache",
                "content-type: application/json; charset=UTF-8",
            ),
        )
    );

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $datasReturn['result'] = 'E';
        $datasReturn['message'] = $err;
    } else {
        if ($response == "{}") {
            $datasReturn['result'] = 'S';
            $datasReturn['message'] = 'Success';
        } else {
            $datasReturn['result'] = 'E';
            $datasReturn['message'] = $response;
        }
    }

    return $datasReturn;
}
function setRichMenuForUser($userId,$richMenuId) {
    $channelAccessToken = con_line();
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
    $logFileName = '../Line-Liff/rich_menu_log.txt';

    if ($httpStatus === 200) {
        $logMessage = 'กำหนด Rich Menu ใหม่ให้กับผู้ใช้สำเร็จ' . PHP_EOL . $userId;
    } else {
        $logMessage = 'เกิดข้อผิดพลาดในการกำหนด Rich Menu' . ' HTTP Status Code: ' . $httpStatus . ', Response: ' . $response . PHP_EOL;
    }

    file_put_contents($logFileName, $logMessage, FILE_APPEND);

}
function uploadRichMenuImage($richMenuId, $imagePath) {
    $channelAccessToken = con_line();
    $apiUrl = 'https://api.line.me/v2/bot/richmenu/' . $richMenuId . '/content';

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: image/png',
        'Authorization: Bearer ' . $channelAccessToken
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($imagePath));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    $logFileName = '../Line-Liff/rich_menu_log.txt';

    if ($httpStatus === 200) {
        $logMessage = 'อัปโหลดรูปภาพ Rich Menu สำเร็จ';
    } else {
        $logMessage = 'เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ Rich Menu' . ' HTTP Status Code: ' . $httpStatus . ', Response: ' . $response;
    }
    file_put_contents($logFileName, $logMessage, FILE_APPEND);
}
function getProductsFromDatabase() {
    $pdo = db_con();
    
    // คำสั่ง SQL ในการดึงข้อมูลรายการสินค้าทั้งหมด
    $sql = "SELECT * FROM packages";
    
    // สร้างคำสั่ง SQL โดยใช้ PDO
    $stmt = $pdo->prepare($sql);
    
    // ประมวลผลคำสั่ง SQL
    $stmt->execute();
    
    // ดึงข้อมูลรายการสินค้า
    $products = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $product = array(
            "thumbnailImageUrl" => $row["thumbnail_url"],
            "text" => $row["product_name"],
            "actions" => array(
                array(
                    "type" => "message",
                    "label" => "เลือก",
                    "text" => $row["product_name"]
                )
            ),
            "imageBackgroundColor" => "#000000"
        );
        $products[] = $product;
    }

    // ปิดการเชื่อมต่อกับฐานข้อมูล
    $pdo = null;
    return $products;
}
function createFlexMessageFromProducts($products) {
    $carouselColumns = array();

    foreach ($products as $product) {
        $carouselColumns[] = array(
            "thumbnailImageUrl" => $product["thumbnailImageUrl"],
            "text" => $product["text"],
            "actions" => $product["actions"],
            "imageBackgroundColor" => "#000000"
        );
    }

    $flexMessageData = array(
        "type" => "template",
        "altText" => "รายการสินค้า",
        "template" => array(
            "type" => "carousel",
            "imageSize" => "contain",
            "imageAspectRatio" => "rectangle",
            "columns" => $carouselColumns
        )
    );

    return json_encode($flexMessageData);
}
?>
