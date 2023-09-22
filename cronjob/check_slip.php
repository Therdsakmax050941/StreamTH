<?php
 function check_slip ($img_path,$orderId){

    $branchId = '10132';
    $apiKey = 'SLIPOKHD9SG2I';
    $url = "https://api.slipok.com/api/line/apikey/" . $branchId;
    
    
    //$file = './slip01.png';
    $file = $img_path;
    $orderId;
    
    if($orderId == true){ // $order(id) เจอและยังไม่เท่ากับ completed
        $headers = [
            'Content-Type: multipart/form-data',
            'x-authorization: ' . $apiKey
        ];
        
        
        $fields = [
            'files' => new CURLFile($file, 'image/png')
        ];
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        
        
        var_dump(curl_exec($ch));
        var_dump(curl_error($ch));
    }else{ // false คือ ไม่เจอ orderId(id) หรือ = completed

    }
   
 }



?>