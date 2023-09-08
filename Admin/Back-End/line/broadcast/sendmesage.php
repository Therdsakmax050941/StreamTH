<?php
session_start();
include_once('../config/connection.php');

if(isset($_POST['text'])){
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
        'messages' => $messages //,
        //'to' => ["U86f9a9557c60144c8edc3c11cb194be6", "U5ee83ced9cf2be3493559f8bef5707e4"],
    ];
    
    $url = 'https://api.line.me/v2/bot/message/broadcast';
    
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
        echo 'Curl error: ' . curl_error($ch);
    } else {
        echo 'Broadcast sent successfully';
    }
    
    curl_close($ch);
    
    
    
}else
{
    
}
