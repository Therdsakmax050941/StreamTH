<?php header("Cache-Control: no-cache, must-revalidate");
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LIFF - LINE Front-end Framework</title>
  <style>
    body { 
      margin: 16px; 
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh; /* ทำให้เต็มหน้าจอ */
    }
    .login-container {
      background-color: #fff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      max-width: 300px;
      text-align: center;
    }
    .login-button {
      background-color: #00c300; /* สีเขียวตามสีของ LINE */
      color: #fff;
      border: none;
      border-radius: 4px;
      padding: 12px 20px;
      cursor: pointer;
      font-size: 16px;
    }
    .login-button:hover {
      background-color: #00a000; /* สีเขียวเข้มเมื่อ hover */
    }
    .line-logo {
      width: 100px; /* ขนาดของ logo LINE */
    }
    img { 
      width: 40%;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <img class="line-logo" src="https://icons.veryicon.com/png/o/business/third-party-sharing-payment/line-20.png" alt="LINE Logo">
    <h1>LINE Login</h1>
    <button class="login-button" id="btnLogIn" onclick="logIn()">Log In with LINE</button>
    <button class="login-button" id="btnLogOut" onclick="logOut()">Log Out</button>
  </div>
  <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
  <script>
    function logOut() {
      liff.logout()
      window.location.reload()
    }
    function logIn() {
      liff.login({ redirectUri: window.location.href })
    }
    async function getUserProfile() {
      const profile = await liff.getProfile()
    }
    async function main() {
      await liff.init({ liffId: "2000187314-rROp67QQ" })
      if (liff.isInClient()) {
        getUserProfile()
      } else {
        if (liff.isLoggedIn()) {
          getUserProfile()
          document.getElementById("btnLogIn").style.display = "none"
          document.getElementById("btnLogOut").style.display = "block"
        } else {
          document.getElementById("btnLogIn").style.display = "block"
          document.getElementById("btnLogOut").style.display = "none"
        }
      }
      if (liff.isLoggedIn()) {
        const profile = await liff.getProfile();
        const userId = profile.userId;
        
         window.location.href = `https://streamth.co/Line-Liff/form.php?userId=${userId}&name=${profile.displayName}&pictureUrl=${profile.pictureUrl}`;
        } 
    }
    main()
  </script>
</body>
</html>