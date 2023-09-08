document.addEventListener("DOMContentLoaded", function () {
    const sendButton = document.getElementById("send-button");
    const messageTextarea = document.getElementById("message");
    const groupSelect = document.getElementById("group");

    sendButton.addEventListener("click", function () {
        const message = messageTextarea.value;
        const selectedGroup = groupSelect.options[groupSelect.selectedIndex].text;

        if (message.trim() === "") {
            Swal.fire({
                icon: 'warning', // ประเภทของ Sweetalert (success, error, warning, info, etc.)
                title: 'โปรดกรอกข้อความ',
                confirmButtonColor: 'green' // สีปุ่มยืนยัน
            });

            // ล้างข้อความใน textarea
            messageTextarea.value = '';

        } else {
            // สร้าง Sweetalert ในรูปแบบที่คุณต้องการ
            Swal.fire({
                icon: 'success', // ประเภทของ Sweetalert (success, error, warning, info, etc.)
                title: 'ส่งข้อความสำเร็จ',
                text: `ส่งข้อความ "${message}" ถึงกลุ่มลูกค้า "${selectedGroup}" เรียบร้อยแล้ว`,
                confirmButtonColor: '#007bff' // สีปุ่มยืนยัน
            });

            // ล้างข้อความใน textarea
            messageTextarea.value = '';
        }
    });
});
