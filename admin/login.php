<?php
session_start();
if(isset($_SESSION['admin'])){
    header("Location: adminDashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/admin_login.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body class="login-body">



<div class="login-container">
    <div class="login-card">

        <h3 class="text-center mb-4">Admin Login</h3>

        <div id="messageBox"></div>

        <div class="mb-3">
            <label>Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
                <input type="text" id="username" class="form-control">
            </div>
            <small class="text-danger" id="userError"></small>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                <input type="password" id="password" class="form-control">
            </div>
            <small class="text-danger" id="passError"></small>
        </div>

        <button class="btn btn-primary w-100" onclick="login()">Login</button>

    </div>
</div>

<script src="../assets/js/admin_login.js"></script>
</body>
</html>