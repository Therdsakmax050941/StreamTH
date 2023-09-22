<?php session_start(); 

?>
<!DOCTYPE html>
<html>
<head>
<title>My Account</title>
<link rel="stylesheet" type="text/css" href="../Line-Liff/css/menu.css" />
<link href="../Line-Liff/css/menu.scss" rel="stylesheet/scss" type="text/css">
</head>
<body>
<ul class="card-list">
	
	<li class="card">
		<a class="card-image" href="#" target="_blank" style="background-image: url(../Line-Liff/image/myshop.png);" data-image-full="../Line-Liff/image/myshop.png">
			<img src="../Line-Liff/image/myshop.png" alt="let's go" />
		</a>
		<a class="card-description" href="#" target="_blank">
			<h2>ประวัติสั่งซื้อของฉัน</h2>
		</a>
	</li>
	
	<li class="card">
		<a class="card-image" href="../Line-Liff/my-account/index.php?userId={$userId}" style="background-image: url(../Line-Liff/image/profile.png);" data-image-full="../Line-Liff/image/profile.png">
			<img src="../Line-Liff/image/profile.png" alt="The Beautiful Game" />
		</a>
		<a class="card-description" href="'../Line-Liff/my-account/index.php" >
			<h2>My Account</h2>
		</a>
	</li>
	
	<li class="card">
		<a class="card-image" href="#" style="background-image: url(../Line-Liff/image/doc.png);" data-image-full="../Line-Liff/image/doc.png">
			<img src="../Line-Liff/image/doc.png" alt="Jane Doe" />
		</a>
		<a class="card-description" href="#">
			<h2>คู่มือการใช้งาน</h2>
		</a>
	</li>
    <li class="card">
		<a class="card-image" href="#" target="_blank" style="background-image: url(../Line-Liff/image/report.png);" data-image-full="../Line-Liff/image/report.png">
			<img src="../Line-Liff/image/report.png" alt="Jane Doe" />
		</a>
		<a class="card-description" href="https://convergecult.bandcamp.com/album/jane-doe" target="_blank">
			<h2>แจ้งปัญหา</h2>
		</a>
	</li>
	
</ul>
<script src="../Line-Liff/js/menu.js" type="text/javascript"></script>
</body>
</html>