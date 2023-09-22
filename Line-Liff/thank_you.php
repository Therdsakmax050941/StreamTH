<?php
 session_start();
 require_once('../Line-Liff/send_message.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ขอบคุณที่สมัครสมาชิก</title>
    <link href="../Line-Liff/css/thank_you.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300&display=swap" rel="stylesheet">
    <style>
        body{
            background-color: black;
        }
    </style>
</head>

<body>
    <div class="container">
        <video autoplay playsinline loop muted>
            <source src="https://streamth.co/Line-Liff/media/watch01.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <h1>ขอบคุณที่สมัครสมาชิก</h1>
        <p>กลับสู่หน้า LINE ภายใน <span id="countdown">10</span> วินาที</p>
        <a href="https://lin.ee/l5mnuzJ" class="btn btn-success">กลับสู่หน้า LINE</a>
    </div>
    <script>
  let countdown = 10; 
  const countdownInterval = setInterval(() => {
    if (countdown > 0) {
      document.getElementById('countdown').innerText = countdown;
      countdown--;
    } else {
      clearInterval(countdownInterval);
      liff.closeWindow();
    }
  }, 1000);
</script>

</body>
</html>
