<?php
session_start();
require_once('../Report/function.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reportType = $_POST["report_type"];
    $reportDescription = $_POST["report_description"];

    $profileJson = json_decode(Get_Profile($_SESSION['userId']), true);

    if ($profileJson !== null) {
        $name = $profileJson['displayName'];
    } else {
        $name = 'ไม่พบชื่อ';
    }


    $message .= "ชื่อ LINE: $name\n\n"; // เพิ่มชื่อ LINE ลงในข้อความ

    $message .= "รายงานการใช้งาน\n\n";
    $message .= "ประเภทรายงาน: $reportType\n\n";

    if ($reportType == "อื่นๆ") {
        $otherReportType = $_POST["other_report_type"];
        $message .= "ประเภทรายงานอื่นๆ: $otherReportType\n\n";
    }
    $message .= "รายละเอียด: $reportDescription";

    $accessToken = "UxajG6rZU3ol6lPZaBOu2O9qo83asJYq2SkeGb5k3Tq";
    $noti = sendLineNotifyMessage($accessToken, $message);
    header("location: ../Report/index.php?noti={$noti}&output={$name}");
    exit();
}