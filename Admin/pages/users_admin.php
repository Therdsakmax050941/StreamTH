<?php include_once('../pages/menu.php') ?>
<div class="content-wrapper" style="min-height: 2128.12px;">
    <div class=content>
    <div class="container">
            <h2 class="text-center">จัดการสมาชิก Admin</h2>
            <form action="../Back-End/save_user.php" method="post">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label class="sr-only" for="inlineFormInput">Username</label>
                        <input type="text" name="username" class="form-control mb-2" id="inlineFormInput" placeholder="Username">
                    </div>
                    <div class="col-auto">
                        <label class="sr-only" for="inlineFormInputGroup">Password</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                            </div>
                            <input type="password" name="password" class="form-control" id="inlineFormInputGroup" placeholder="Password">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="far fa-eye" id="showPasswordIcon" onclick="togglePasswordVisibility()"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                            </div>
                            <select class="form-control" name="status">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-2">สร้างสมาชิก</button>
                    </div>
                </div>
            </form>

            <div id="adminUsersTable">
                <?php include_once('../Back-End/function.php');
                echo displayAdminUsers(); ?>
                <!-- เพิ่มแบบฟอร์มสำหรับการแก้ไขข้อมูล -->
                <div id="editAdminUserModal" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">แก้ไขข้อมูลผู้ใช้</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editAdminUserForm">
                                    <div class="form-group">
                                        <label for="editUsername">Username</label>
                                        <input type="text" class="form-control" id="editUsername" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editStatus">Status</label>
                                        <select class="form-control" id="editStatus" name="status">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editStatus2">Status2</label>
                                        <select class="form-control" id="editStatus2" name="status2">
                                            <option value="1">ใช้งานอยู่</option>
                                            <option value="0">ถูกปิดการใช้งาน</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="editUserId" name="userId">
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- footer -->

<?php include_once './footer.php'; ?>
