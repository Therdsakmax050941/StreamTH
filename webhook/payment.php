<!DOCTYPE html>
<html>
<head>
    <title>อัปโหลดสลิป</title>
</head>
<body>
    <h1>อัปโหลดสลิป</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="slip">เลือกไฟล์สลิป:</label>
        <input type="file" name="slip" id="slip" accept=".jpg, .jpeg, .png, .pdf" required>
        <br>
        <input type="submit" value="อัปโหลด">
    </form>
</body>
</html>
