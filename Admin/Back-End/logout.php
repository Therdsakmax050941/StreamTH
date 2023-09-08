<?php
require_once('../Back-End/line/LineLogin.php');
session_start();
session_destroy();
header("Location: ../index.php");
exit();

//line logout
if (isset($_SESSION['profile'])) {
    $profile = $_SESSION['profile'];
    $line = new LineLogin();
    $line->revoke($profile->access_token);
    session_destroy();
}

?>