<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LIFF - Streaming World-Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://streamth.co/Line-Liff/css/report.css" media="screen, projection" />
</head>

<body>
    <div class="report-box">
        <h2>รายงานการใช้งาน</h2>
        <form action="../Report/get_report.php" method="post">
            <div class="form-group">
                <label for="report_type">ประเภทรายงาน</label>
                <select class="form-control" id="report_type" name="report_type" required>
                    <option value="ปัญหา">ปัญหา</option>
                    <option value="ข้อเสนอแนะ">ข้อเสนอแนะ</option>
                    <option value="อื่นๆ">อื่นๆ</option>
                </select>
                <div class="form-group" id="other_report_type" style="display: none;">
                    <label for="other_report_type">ระบุประเภทรายงานอื่นๆ</label>
                    <input class="form-control" id="other_report_type" type="text" name="other_report_type">
                </div>
            </div>
            <div class="form-group">
                <label for="report_description">รายละเอียด</label>
                <textarea class="form-control" id="report_description" name="report_description" rows="4" required></textarea>
            </div>
            <button class="btn btn-primary" type="submit">ส่งรายงาน</button>
        </form>
    </div>
    <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const noti = urlParams.get('noti');

        if (noti === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'การส่งรายงานสำเร็จ',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../menu.php';
                }
            });
        } else if (noti === 'false') {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาดในการแจ้งรายงาน',
            });
        }
    </script>
    <script>
        const reportTypeSelect = document.getElementById('report_type');
        const otherReportTypeInput = document.getElementById('other_report_type');
        reportTypeSelect.addEventListener('change', function() {
            if (reportTypeSelect.value === 'อื่นๆ') {
                otherReportTypeInput.style.display = 'block';
            } else {
                otherReportTypeInput.style.display = 'none';
            }
        });
    </script>
</body>

</html>