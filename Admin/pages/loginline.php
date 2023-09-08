<?php
include_once ('../Back-End/line/LineLogin.php');
if(!isset($_SESSION['profile'])) {
    $line = new LineLogin();
    $link = $line->getLink();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Line Login</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Line Login</h4>
                </div>
                <div class="card-body">
                    <!-- รูปภาพหรือโลโก้ของ Line  -->
                    <img src="https://logos-world.net/wp-content/uploads/2021/03/Line-Emblem.png" alt="Line Logo" class="img-fluid mx-auto d-block mb-3">

                    <!-- ปุ่ม Line Login -->
                    <a href="<?php echo $link ?>" class="btn btn-primary btn-block">Login with Line</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- เรียกใช้ Bootstrap JS และ jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>