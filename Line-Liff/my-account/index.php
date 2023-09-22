<?php
session_start(); 
require_once('../my-account/function.php');
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $users = getUsersByUserId($userId);

    if (!empty($users)) {
        foreach ($users as $user) {
            $display =  $user['DisplayName'];
            $full_name =  $user['full_name'];
            $email =  $user['email'];
            $line_id =  $user['lineId'];
            $image = $user['image_url'];
            $phone = $user['phone'];
        }
    }
} else {
   // header('location: https://liff.line.me/2000187314-rROp67QQ');
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LIFF - Streaming World</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background: #f7f7f7;
        }

        .head-box {
            margin: auto;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            /* ทำให้เนื้อหาอยู่ตรงกลางตามแนวแกนตั้ง */
            text-align: center;
            /* ปรับขนาดรูปภาพให้พอดีกับขนาดของพื้นที่ */
        }

        .form-box {
            max-width: 500px;
            margin: auto;
            padding: 50px;
            background: #ffffff;
            border: 10px solid #f2f2f2;
            display: flex;
            flex-direction: column;
        }

        h1,
        p {
            text-align: center;
        }

        input,
        textarea {
            width: 100%;
        }

        .img_profile {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            /* ทำให้รูปภาพเป็นวงกลม */
            object-fit: cover;
        }

        .greeting {
            margin-top: 20px;
            /* ระยะห่างด้านบนของข้อความ "สวัสดีคุณ" */
        }
    </style>
</head>

<body>
    <div class="form-box">
        <div class="head-box">
            <h1>สมัครสมาชิก</h1>

            <img src="<? echo $image ?>" class="img_profile">
            <p class="greeting">สวัสดีคุณ <? echo $display; ?></p>
        </div>
        <form action="../Line-Liff/save_register.php" method="post">
            <input type="hidden" name="userId" value="<? echo $userId ?>">
            <input type="hidden" name="name" value="<? echo $name ?>">
            <input type="hidden" name="image" value="<? echo $image ?>">
            <div class="form-group">
                <label for="name">ชื่อ-นามสกุล</label>
                <input class="form-control" id="name" type="text" name="Name" value="<? echo $full_name; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" id="email" type="email" name="Email" value="<? echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">LineID</label>
                <input class="form-control" id="email" type="text" name="lineId" value="<? echo $line_id; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">เบอร์โทรติดต่อ</label>
                <input class="form-control" id="email" type="number" name="phone" value="<? echo $phone; ?>" required>
            </div>
            <button class="btn btn-success align-items-center" type="submit">ยืนยันการสมัคร</button>
        </form>
    </div>
    <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const noti = urlParams.get('noti');

        if (noti === 'ชื่อหรืออีเมลล์นี้มีอยู่ในระบบแล้ว') {
            Swal.fire({
                icon: 'warning',
                title: 'ชื่อหรืออีเมลล์นี้มีอยู่ในระบบแล้ว',
                text: noti,
            });
        } else if (noti === 'เกิดข้อผิดพลาดในการบันทึกข้อมูล') {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
                text: noti,
            });
        }
    </script>


</body>

</html>