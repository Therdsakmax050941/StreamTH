<?php
require_once('../woo_connection.php');
if (isset($_GET['orderid'])) {
    $data = [
        'status' => 'completed'
    ];
    $orderid = $_GET['orderid'];
    $woocommerce->put('orders/'. $orderid, $data);
    header('location: ../pages/order.php?treeview=3.2&menu=3&orderupdate=true');
    exit();
}else{
    header('location: ../pages/order.php?treeview=3.2&menu=3&orderupdate=false');
    exit();
}

?>