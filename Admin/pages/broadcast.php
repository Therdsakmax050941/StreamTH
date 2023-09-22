<?php 
include_once('../pages/menu.php');
require_once('../Back-End/function.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: 2128.12px;">


  <div class=content>
    <h2 class="text-center">Broadcast Message</h2>
    <div class="container mt-5">
        <!--Content -->
        <form id="broadcast-form" action="../Back-End/line/broadcast/sendmesage.php" method="post">
            <div class="mb-3">
                <label for="message" class="form-label">ข้อความ:</label>
                <textarea class="form-control" id="message" name="text" rows="4"></textarea>
            </div>
            <div class="mb-3">
                <label for="group" class="form-label">กลุ่มลูกค้า:</label>
                <select class="form-select" id="group" name="group">
                    <option value="group1">ทั้งหมด</option>
                    <option value="group1">กลุ่ม 1</option>
                    <option value="group2">กลุ่ม 2</option>
                    <option value="group3">กลุ่ม 3</option>
                </select>
            </div>
            <button type="submit" id="send-button" class="btn btn-primary">ส่งข้อความ</button>
        </form>

        <div id="message-output" class="mt-3"></div>
    </div>

    </div>
  </div>
</div>


</div>

</div>
</div>
<!-- footer -->

<?php include_once './footer.php'; ?>