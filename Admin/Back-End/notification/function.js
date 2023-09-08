function broadcast_notification(status) {
    if (status == true) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: 'info',
            title: 'ระบบเริ่ม Broadcast Message'
        });

        // แสดง SweetAlert2 และรอ 3 วินาทีเพื่อแสดงข้อความ "Broadcast เสร็จสิ้น"
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Broadcast เสร็จสิ้น'
            });
        }, 3000);
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: 'warning',
            title: 'ไม่สามารถทำการ Broadcast ได้!!'
        });
    }
}
function order_update(status){
    if (status == true) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: 'success',
                title: 'อนุมัติสำเร็จ'
        });
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: 'warning',
            title: 'มีข้อผิดพลาดเกิดขึ้น!!'
        });
    }
}