<?php

session_start();

if(isset($_SESSION['profile'])) {

    header('location: ../../pages/broadcast.php?treeview=3.3&menu=3');
    exit();
}else{

    header('location: ../../pages/loginline.php?treeview=3.3&menu=3');
    exit();
}
?>