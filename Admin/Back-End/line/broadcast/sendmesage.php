<?php
session_start();
require_once('../config/connection.php');
require_once('./function.php');

if (isset($_POST['group']) && isset($_POST['text'])) {
    if ($_POST['group'] == 'ALL') {
        $text = $_POST['text'];
        $messages = [
            [
                'type' => 'text',
                'text' => $text
            ],
            [
                'type' => 'text',
                'text' => '*****************'
            ]
        ];

        $data = [
            'messages' => $messages,
        ];

        $url = 'https://api.line.me/v2/bot/message/multicast';

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $channelAccessToken
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if ($response === false) {
            header('location: ../../../pages/broadcast.php?menu=3&broadcast=false');
        } else {
            echo 'Broadcast sent successfully';
            header('location: ../../../pages/broadcast.php?treeview=3.3&menu=3&broadcast=true');
        }

        curl_close($ch);


    } elseif ($_POST['group'] == "Netflix") {
        //$content = file_get_contents('php://input');
        $content = '{"destination":"U53674edaa5e5eac34fee45c54677bdcf","events":[{"type":"message","message":{"type":"text","id":"472572068169515014","contentProvider":{"type":"line"}},"webhookEventId":"01HA471HPPGPM58BNSQ21Q903F","deliveryContext":{"isRedelivery":false},"timestamp":1694506206929,"source":{"type":"user","userId":"Ufcc6f2382ada6ba537f320d354de41ed"},"replyToken":"921c1ccfc836464a9ec6834ceaae0ea5","mode":"active"}]}';
        $arrayJson = json_decode($content, true);
        $arrayHeader = array();
        $arrayHeader[] = "Content-Type: application/json";
        $arrayHeader[] = "Authorization: Bearer {'$channelAccessToken'}";
        //รับข้อความจากผู้ใช้
        //$message = $arrayJson['events'][0]['message']['text'];
        //รับ id ของผู้ใช้
        $id = $arrayJson['events'][0]['source']['userId'];
        //if($message == "นับ 1-10"){
        for ($i = 1; $i <= 10; $i++) {
            $arrayPostData['to'] = $id;
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "ทดสอบระบบ Broadcast แบบรายคน";
            pushMsg($arrayHeader, $arrayPostData);
        }
        // }
    }
} else {
}

exit;
?>
