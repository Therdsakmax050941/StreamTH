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
function getPackagesFromDatabase() {

    $pdo = db_con();

    $sql = "SELECT * FROM packages";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    $products = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $product = array(
            "imageUrl" => $row["imageUrl"],
            "actions" => array(
                array(
                    "type" => "message",
                    "label" => "เลือก",
                    "text" => $row["product_data"]
                )
            ),

        );

        $products[] = $product;

        error_log("database: " . json_encode($product));
    }
    $pdo = null;
    return $products;
}

function getProductsFromDatabase($product_name) {
    $pdo = db_con();

    $sql = "SELECT * FROM products WHERE product_data = :product_name"; 

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":product_name", $product_name, PDO::PARAM_STR); 

    $stmt->execute();

    $products = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $product = array(
            "imageUrl" => $row["imageUrl"],
            "actions" => array(
                array(
                    "type" => "message",
                    "label" => "เลือก",
                    "text" => $row["product_key"]
                )
            ),
        );

        $products[] = $product;

        error_log("database: " . json_encode($product));
    }
    $pdo = null;
    return $products;
}

function createColumnsFromProducts($products) {
    $columns = array();

    foreach ($products as $product) {
        $column = array(
            "imageUrl" => $product["imageUrl"],
            "action" => array(
                "type" => "message",
                "label" => "เลือก",
                "text" => $product["actions"][0]["text"]
            )
        );
        $columns[] = $column;
    }
    error_log("get database to json: " . json_encode($columns));
    return $columns;
}

function getProductsAndSendImageCarousel($userId, $text) {
    $products = getProductsFromDatabase($text);
    $columns = createColumnsFromProducts($products);

    $imageCarouselData = array(
        "type" => "template",
        "altText" => "รายการสินค้า",
        "template" => array(
            "type" => "image_carousel",
            "columns" => $columns
        )
    );

    $logFilePath = "log.txt"; // พาธไฟล์ log สำหรับบันทึกผลการส่ง Image Carousel Message

    // ส่ง Image Carousel Message และเช็คค่าผลลัพธ์
    $result = sendTemplateMessage($userId, $imageCarouselData, $logFilePath);

    if ($result) {
        file_put_contents($logFilePath, "สำเร็จ\n{$result}", FILE_APPEND);
    } else {
        file_put_contents($logFilePath, "ไม่สำเร็จ\n{$result}", FILE_APPEND);
    }
}
function getPackagesAndSendImageCarousel($userId) {
    $products = getPackagesFromDatabase();
    $columns = createColumnsFromProducts($products);

    $imageCarouselData = array(
        "type" => "template",
        "altText" => "รายการสินค้า",
        "template" => array(
            "type" => "image_carousel",
            "columns" => $columns
        )
    );

    $logFilePath = "log.txt"; // พาธไฟล์ log สำหรับบันทึกผลการส่ง Image Carousel Message

    // ส่ง Image Carousel Message และเช็คค่าผลลัพธ์
    $result = sendTemplateMessage($userId, $imageCarouselData, $logFilePath);

    if ($result) {
        file_put_contents($logFilePath, "ส่ง Package สำเร็จ\n{$result}", FILE_APPEND);
    } else {
        file_put_contents($logFilePath, "Package ไม่สำเร็จ\n{$result}", FILE_APPEND);
    }
}


function sendTemplateMessage($to, $template, $logFilePath)
{
    $url = "https://api.line.me/v2/bot/message/push";

    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer " . con_line()
    ];

    $data = [
        "to" => $to,
        "messages" => [
            json_decode(json_encode($template), true) // แปลง JSON ของ Template ให้เป็นอาร์เรย์
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
    error_log("json to Line: " . json_encode($dataJson));
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpStatus === 200) {
        // บันทึกผลลัพธ์ลงในไฟล์ log
        file_put_contents($logFilePath, "ส่ง Template Message สำเร็จ\n", FILE_APPEND);
        return true; // ส่ง Template Message สำเร็จ
    } else {

        file_put_contents($logFilePath, "การส่ง Template Message ไม่สำเร็จ\n", FILE_APPEND);
        return false; // การส่ง Template Message ไม่สำเร็จ
    }
}
function getAllProductsByProductData() {
    // กำหนดการเชื่อมต่อกับฐานข้อมูล
    $pdo = db_con(); // แทน db_con() ด้วยฟังก์ชันที่ใช้ในการเชื่อมต่อกับฐานข้อมูลของคุณ

    // คำสั่ง SQL เพื่อดึงข้อมูล product_data ทั้งหมด
    $sql = "SELECT DISTINCT product_key FROM products";

    // ประมวลผลคำสั่ง SQL
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // สร้าง array เพื่อเก็บผลลัพธ์
    $productDataArray = array();

    // วนลูปเพื่อดึงข้อมูลแต่ละแถว
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // เพิ่มข้อมูล product_data ในแต่ละแถวเข้าใน array
        $productDataArray[] = $row["product_key"];
    }

    // ปิดการเชื่อมต่อกับฐานข้อมูล
    $pdo = null;

    // ส่งผลลัพธ์กลับเป็น array
    return $productDataArray;
}
function getProduct($product_data,$rowdata) {
  // เชื่อมต่อฐานข้อมูล
  $logFilePath = 'log.txt';
  $pdo = db_con(); // สร้างฟังก์ชัน db_con() ของคุณเองเพื่อเชื่อมต่อกับฐานข้อมูล
 
  // สร้างคำสั่ง SQL สำหรับดึงราคาสินค้าจากฐานข้อมูล
  $sql = "SELECT $rowdata FROM products WHERE product_key = :product_data";

  // เตรียมคำสั่ง SQL สำหรับการดึงราคา
  $stmt = $pdo->prepare($sql);

  // ผูกค่า `$product_data` กับพารามิเตอร์ในคำสั่ง SQL
  $stmt->bindParam(":product_data", $product_data, PDO::PARAM_STR);

  // ประมวลผลคำสั่ง SQL สำหรับการดึงราคา
  $stmt->execute();

  // ดึงข้อมูลราคาจากผลลัพธ์
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $pdo = null;
  // ตรวจสอบว่าข้อมูลราคาถูกดึงมาหรือไม่
  if ($row) {
      return $row[$rowdata]; // ส่งค่าราคากลับ
  } else {
      return false; // ถ้าไม่พบข้อมูลราคา
  }
}
function createNewOrder($User_ID, $product_key, $status) {
    // เชื่อมต่อฐานข้อมูล
    $pdo = db_con(); // สร้างฟังก์ชัน db_con() ของคุณเองเพื่อเชื่อมต่อกับฐานข้อมูล
    $amount = getProduct($product_key, "price");
    get_log ("amount: " , $amount);
    if ($amount === false) {
        return false; // ไม่สามารถหาข้อมูลราคาสินค้าได้
    }

    // สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูลใหม่ลงในตาราง
    $sql = "INSERT INTO orders_detail (User_ID, product_data, amount, status) VALUES (:User_ID, :product_data, :amount, :status)";

    // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูลใหม่
    $stmt = $pdo->prepare($sql);

    // ผูกค่าที่ต้องการเพิ่มใหม่กับพารามิเตอร์ในคำสั่ง SQL
    $stmt->bindParam(":User_ID", $User_ID, PDO::PARAM_STR);
    $stmt->bindParam(":product_data", $product_key, PDO::PARAM_STR); // แก้ไขเป็น $product_key แทน product_data
    $stmt->bindParam(":amount", $amount, PDO::PARAM_STR); // แก้ไขเป็น PDO::PARAM_DECIMAL
    $stmt->bindParam(":status", $status, PDO::PARAM_STR);

    // ประมวลผลคำสั่ง SQL สำหรับการเพิ่มข้อมูลใหม่
    $result = $stmt->execute();

    if ($result) {
        $order_id = $pdo->lastInsertId(); // รับค่า order_id ที่ถูกสร้างโดยอัตโนมัติ
        $pdo = null;
        return $order_id; // ส่งค่า order_id กลับ
    } else {
        return false;
    }
}
function get_log($title,$data ){
    $logFilePath = 'log.txt';
    file_put_contents($logFilePath, $title ." ". $data ."\n", FILE_APPEND);
}

?>
