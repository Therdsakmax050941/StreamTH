<?php
   require_once '../Back-End/line/config/connection.php';
   //$content = file_get_contents('php://input');
   $content = '{"destination":"U53674edaa5e5eac34fee45c54677bdcf","events":[{"type":"message","message":{"type":"text","id":"472572068169515014","contentProvider":{"type":"line"}},"webhookEventId":"01HA471HPPGPM58BNSQ21Q903F","deliveryContext":{"isRedelivery":false},"timestamp":1694506206929,"source":{"type":"user","userId":"Ufcc6f2382ada6ba537f320d354de41ed"},"replyToken":"921c1ccfc836464a9ec6834ceaae0ea5","mode":"active"}]}';
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {'$channelAccessToken'}";
   //รับข้อความจากผู้ใช้
   //$message = $arrayJson['events'][0]['message']['text'];
   //รับ id ของผู้ใช้
   //$id = $arrayJson['events'][0]['source']['userId'];
   $id = 'U6abe3894d92be79ca70fa483431d399c';
   //if($message == "นับ 1-10"){
       //for($i=1;$i<=10;$i++){
          $arrayPostData['to'] = $id;
          $arrayPostData['messages'][0]['type'] = "text";
          $arrayPostData['messages'][0]['text'] = "ทดสอบระบบ Broadcast แบบรายคน";
          pushMsg($arrayHeader,$arrayPostData);
       //}
   // }
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
   exit;
?>
