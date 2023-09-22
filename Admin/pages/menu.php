<?php
session_start();
if (isset($_GET['user'])) {
  $_SESSION['name'] = $_GET['user'];
}
if (isset($_SESSION['name'])) {
  $encodedUser = $_SESSION['name'];
  $name = $encodedUser;
} else {
  header("Location: ../Back-End/logout.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <script src="jquery-3.6.4.min.js"></script>
  <link rel="stylesheet" href="dist/css/adminlte.min.css?v=3.2.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script defer="" referrerpolicy="origin" src="/cdn-cgi/zaraz/s.js?z=JTdCJTIyZXhlY3V0ZWQlMjIlM0ElNUIlNUQlMkMlMjJ0JTIyJTNBJTIyQWRtaW5MVEUlMjAzJTIwJTdDJTIwRGFzaGJvYXJkJTIwMyUyMiUyQyUyMnglMjIlM0EwLjc1OTMzMTU1MzE1MTI4NzYlMkMlMjJ3JTIyJTNBMTA4MCUyQyUyMmglMjIlM0ExOTIwJTJDJTIyaiUyMiUzQTE4MTUlMkMlMjJlJTIyJTNBMTA4MCUyQyUyMmwlMjIlM0ElMjJodHRwcyUzQSUyRiUyRmFkbWlubHRlLmlvJTJGdGhlbWVzJTJGdjMlMkZpbmRleDMuaHRtbCUyMiUyQyUyMnIlMjIlM0ElMjJodHRwcyUzQSUyRiUyRmFkbWlubHRlLmlvJTJGdGhlbWVzJTJGdjMlMkZpbmRleDIuaHRtbCUyMiUyQyUyMmslMjIlM0EyNCUyQyUyMm4lMjIlM0ElMjJVVEYtOCUyMiUyQyUyMm8lMjIlM0EtNDIwJTJDJTIycSUyMiUzQSU1QiU1RCU3RA=="></script>
  <script nonce="71e54950-964b-4269-8645-a67d011bf720">
    (function(w, d) {
      ! function(a, b, c, d) {
        a[c] = a[c] || {};
        a[c].executed = [];
        a.zaraz = {
          deferred: [],
          listeners: []
        };
        a.zaraz.q = [];
        a.zaraz._f = function(e) {
          return function() {
            var f = Array.prototype.slice.call(arguments);
            a.zaraz.q.push({
              m: e,
              a: f
            })
          }
        };
        for (const g of ["track", "set", "debug"]) a.zaraz[g] = a.zaraz._f(g);
        a.zaraz.init = () => {
          var h = b.getElementsByTagName(d)[0],
            i = b.createElement(d),
            j = b.getElementsByTagName("title")[0];
          j && (a[c].t = b.getElementsByTagName("title")[0].text);
          a[c].x = Math.random();
          a[c].w = a.screen.width;
          a[c].h = a.screen.height;
          a[c].j = a.innerHeight;
          a[c].e = a.innerWidth;
          a[c].l = a.location.href;
          a[c].r = b.referrer;
          a[c].k = a.screen.colorDepth;
          a[c].n = b.characterSet;
          a[c].o = (new Date).getTimezoneOffset();
          if (a.dataLayer)
            for (const n of Object.entries(Object.entries(dataLayer).reduce(((o, p) => ({
                ...o[1],
                ...p[1]
              })), {}))) zaraz.set(n[0], n[1], {
              scope: "page"
            });
          a[c].q = [];
          for (; a.zaraz.q.length;) {
            const q = a.zaraz.q.shift();
            a[c].q.push(q)
          }
          i.defer = !0;
          for (const r of [localStorage, sessionStorage]) Object.keys(r || {}).filter((t => t.startsWith("_zaraz_"))).forEach((s => {
            try {
              a[c]["z_" + s.slice(7)] = JSON.parse(r.getItem(s))
            } catch {
              a[c]["z_" + s.slice(7)] = r.getItem(s)
            }
          }));
          i.referrerPolicy = "origin";
          i.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(a[c])));
          h.parentNode.insertBefore(i, h)
        };
        ["complete", "interactive"].includes(b.readyState) ? zaraz.init() : a.addEventListener("DOMContentLoaded", zaraz.init)
      }(w, d, "zarazData", "script");
    })(window, document);
  </script>
  <style type="text/css">
    /* Chart.js */
    @keyframes chartjs-render-animation {
      from {
        opacity: .99
      }

      to {
        opacity: 1
      }
    }

    .chartjs-render-monitor {
      animation: chartjs-render-animation 1ms
    }

    .chartjs-size-monitor,
    .chartjs-size-monitor-expand,
    .chartjs-size-monitor-shrink {
      position: absolute;
      direction: ltr;
      left: 0;
      top: 0;
      right: 0;
      bottom: 0;
      overflow: hidden;
      pointer-events: none;
      visibility: hidden;
      z-index: -1
    }

    .chartjs-size-monitor-expand>div {
      position: absolute;
      width: 1000000px;
      height: 1000000px;
      left: 0;
      top: 0
    }

    .chartjs-size-monitor-shrink>div {
      position: absolute;
      width: 200%;
      height: 200%;
      left: 0;
      top: 0
    }

    h5 {
      color: white;
    }
    /* CSS สำหรับปุ่ม Logout */
    .btn-logout {
        width: 100%;
        color: #dc3545;
        background-color: #313131;
        margin-top:450px; /* กำหนดระยะห่างด้านบนของปุ่ม */
    }

    .btn-logout:hover {
        background-color: white;
        color: gray;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <br>
      <div class="text-center margin-bottom">
      <img src="../image/favicon.ico" width="80px" style="border: 1px solid ; border-radius: 30%;">
      <br>
    </div>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="../pages/dashboard.php?menu=1" class="nav-link <?php if (isset($_GET['menu']) && $_GET['menu'] == 1) {
                                                                        echo 'active';
                                                                      } ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard

                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="./package.php?menu=3" class="nav-link <?php if (isset($_GET['menu']) && $_GET['menu'] == 2) {
                                                                echo 'active';
                                                              } ?>">
                <i class="far  nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-buildings" viewBox="0 0 16 16">
                    <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022ZM6 8.694 1 10.36V15h5V8.694ZM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15Z" />
                    <path d="M2 11h1v1H2v-1Zm2 0h1v1H4v-1Zm-2 2h1v1H2v-1Zm2 0h1v1H4v-1Zm4-4h1v1H8V9Zm2 0h1v1h-1V9Zm-2 2h1v1H8v-1Zm2 0h1v1h-1v-1Zm2-2h1v1h-1V9Zm0 2h1v1h-1v-1ZM8 7h1v1H8V7Zm2 0h1v1h-1V7Zm2 0h1v1h-1V7ZM8 5h1v1H8V5Zm2 0h1v1h-1V5Zm2 0h1v1h-1V5Zm0-2h1v1h-1V3Z" />
                  </svg></i>
                <p>จัดการ Package</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../Back-End/line/check_login.php?menu=3" class="nav-link <?php if (isset($_GET['menu']) && $_GET['menu'] == 3) {
                                                                                  echo 'active';
                                                                                } ?> ">
                <i class="far  nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-right-fill" viewBox="0 0 16 16">
                    <path d="M14 0a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z" />
                  </svg></i>
                <p>Broadcast Message</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link <?php if (isset($_GET['menu']) && $_GET['menu'] == 4) {
                                            echo 'active';
                                          } ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>กำลังจะหมดอายุ</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link <?php if (isset($_GET['menu']) && $_GET['menu'] == 5) {
                                            echo 'active';
                                          } ?>">
                <i class="far  nav-icon"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                    <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zM11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                    <path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293 2.354.646zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118l.137-.274z" />
                  </svg></i>
                <p>Slip</p>
              </a>
            </li>
            <!-- การจัดการ Users Admin -->
            <li class="nav-item">
              <a href="../pages/users_admin.php?menu=2" class="nav-link <?php if (isset($_GET['menu']) && $_GET['menu'] == 6) {
                                                                          echo 'active';
                                                                        } ?>">
                <i class="nav-icon far "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-.245z" />
                  </svg></i>
                <p>
                  Admin
                </p>
              </a>
            </li>
            <div class="sidebar-menu">
              <!-- เมนูอื่น ๆ ที่อยู่ข้างบน -->

              <!-- ปุ่ม Logout -->
              <a href="../Back-End/logout.php" class="btn btn-logout">LOGOUT</a>
            </div>

            <!-- End การจัดการร่วม -->
            <!-- /.sidebar -->
    </aside>