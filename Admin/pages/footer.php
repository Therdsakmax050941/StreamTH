<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://streamth.co/">streamth.co</a>.</strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-view').click(function() {
            var orderId = $(this).data('order-id');
            $.ajax({
                type: 'GET',
                url: '../Back-End/order/get_all_orders.php',
                data: {
                    order_id: orderId
                },
                success: function(response) {
                    $('#orderDetails').html(response);
                    $('#viewModal').modal('show');
                },
                error: function() {
                    alert('Error fetching orders.');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.btn-edit').on('click', function() {
            var productId = $(this).data('product-id');
            var productName = $(this).data('product-name');
            var productPrice = $(this).data('product-price');
            var productDescription = $(this).data('product-description');
            var productImage = $(this).data('product-image');
            var inputImage = $(this).data('product-image');

            // เติมข้อมูลลงในช่อง input ใน Modal
            $('#editProductId').val(productId);
            $('#editProductName').val(productName);
            $('#editProductPrice').val(productPrice);
            $('#editProductDescription').val(productDescription);
            $('#editProductImagePreview').attr('src', productImage);
            $('#inputProductImagePreview').val(productImage);

            console.log('Product ID:', productId);
            console.log('Product Name:', productName);
            console.log('Product Price:', productPrice);
            console.log('Product Description:', productDescription);
            console.log('Product Image:', productImage);
            console.log('Product Image:', inputImage);

            // เพิ่ม event handler สำหรับปุ่ม Update
            $('#updateProductButton').on('click', function() {
                $('#updateProductButton').off('click');
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function createProduct() {
        const form = document.getElementById('productForm');
        const formData = new FormData(form);

        axios.post('../Back-End/add_product_api.php', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
            .then(response => {
                console.log('Product created successfully with ID: ' + response.data.id);
                // Do something after product is successfully created
            })
            .catch(error => {
                console.error('Error creating product:', error);
            });
    }
</script>
<script>
    function confirmDelete(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            // ส่ง request ไปยังหน้า delete_product.php เพื่อลบสินค้า
            window.location.href = "../Back-End/delete_product.php?id=" + productId;
        }
    }
</script>
<script>
    function editAdminUser(id, username, status, status2) {
        // กำหนดค่าให้กับแบบฟอร์มการแก้ไขข้อมูล
        document.getElementById('editUserId').value = id;
        document.getElementById('editUsername').value = username;
        document.getElementById('editStatus').value = status;
        document.getElementById('editStatus2').value = status2;

        // เปิด modal แบบฟอร์มการแก้ไขข้อมูล
        $('#editAdminUserModal').modal('show');
    }

    // ส่งค่าแบบฟอร์มการแก้ไขข้อมูลผู้ใช้
    document.getElementById('editAdminUserForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('../Back-End/update_user.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // ใช้ Console Log เพื่อดูข้อมูลที่ได้รับจากการแก้ไข

                if (data.success) {
                    // ซ่อน modal แบบฟอร์มการแก้ไขข้อมูล
                    $('#editAdminUserModal').modal('hide');

                    // แสดง SweetAlert2 แสดงสถานะการแก้ไขสำเร็จ
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: 'แก้ไขข้อมูลผู้ใช้สำเร็จ',
                    }).then(() => {
                        // โหลดข้อมูลใหม่แสดงในตาราง
                        window.location.href = '../pages/users_admin.php?menu=2';
                        displayAdminUsers();
                    });
                } else {
                    // แสดง SweetAlert2 แสดงสถานะการแก้ไขไม่สำเร็จ
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล',
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('inlineFormInputGroup');
        const showPasswordIcon = document.getElementById('showPasswordIcon');

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordIcon.classList.remove("far", "fa-eye");
            showPasswordIcon.classList.add("far", "fa-eye-slash");
        } else {
            passwordInput.type = "password";
            showPasswordIcon.classList.remove("far", "fa-eye-slash");
            showPasswordIcon.classList.add("far", "fa-eye");
        }
    }
</script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            icon: 'warning',
            title: 'ยืนยันการลบข้อมูล',
            text: 'คุณต้องการลบข้อมูลนี้ใช่หรือไม่?',
            showCancelButton: true,
            confirmButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่งค่าไอดีของข้อมูลที่ต้องการลบไปยังหน้า PHP เพื่อดำเนินการลบข้อมูลในฐานข้อมูล
                deleteAdminUser(id);
            }
        });
    }

    function deleteAdminUser(id) {
        fetch('../Back-End/delete_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'userId=' + id,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // แสดง SweetAlert2 แสดงสถานะการลบสำเร็จ
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: 'ลบข้อมูลผู้ใช้สำเร็จ',
                    }).then(() => {
                        // โหลดข้อมูลใหม่แสดงในตาราง
                        window.location.href = '../pages/users_admin.php?menu=2';
                        displayAdminUsers();
                    });
                } else {
                    // แสดง SweetAlert2 แสดงสถานะการลบไม่สำเร็จ
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'เกิดข้อผิดพลาดในการลบข้อมูล',
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    displayAdminUsers();
</script>
<script>
    // สร้างฟังก์ชันสำหรับรีเฟรชตารางแสดงข้อมูลผู้ใช้งาน
    function displayAdminUsers() {
        fetch('../Back-End/get_users.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const adminUsersTable = document.getElementById('adminUsersTable');
                    adminUsersTable.innerHTML = data.table;
                } else {
                    // ถ้าเกิดข้อผิดพลาดในการรับข้อมูลจากเซิร์ฟเวอร์
                    console.error('Error:', data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // รีเฟรชตารางเมื่อเวลาโหลดหน้าหรือเมื่อลบข้อมูลสำเร็จ
    displayAdminUsers();
</script>

<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.js?v=3.2.0"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<script src="../dist/js/pages/dashboard3.js"></script>
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>
<script src="../Back-End//notification/function.js"></script>
<script>
    const urlParams = new URLSearchParams(window.location.search);
    const broadcastParam = urlParams.get('broadcast');
    const orderupdate = urlParams.get('orderupdate');

    // call broadcast_notification 
    if (broadcastParam === 'true') {
        broadcast_notification(true);
    } else if (broadcastParam === 'false') {
        broadcast_notification(false);
    }
    else if (orderupdate === 'true') {
        order_update(true);
    } else if (orderupdate === 'false') {
        order_update(false);
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>