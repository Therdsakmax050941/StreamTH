<?php include_once('../pages/menu.php');
require_once('../Back-End/function.php');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: 2128.12px;">


  <div class=content>
    <h2 class="text-center">การจัดการออเดอร์</h2>
    <div class="container mt-5">
      <!-- Modal เพื่อแสดงข้อมูลลูกค้า -->
      <?php include_once('../Back-End/order/get_order.php') ?>
    </div>
  </div>
</div>


</div>

</div>
</div>

<!-- footer -->
<?php include_once './footer.php'; ?>