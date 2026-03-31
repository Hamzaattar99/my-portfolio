<?php
session_start();
require_once "../includes/db.php";

// حماية الصفحة (مهم جدًا)
require_once "../includes/auth.php";

// جلب الإعدادات
$settings = [];
$res = $conn->query("SELECT * FROM settings");
while($row = $res->fetch_assoc()){
    $settings[$row['name']] = $row['value'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Settings</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/adminDahs.css">
<link rel="stylesheet" href="../assets/css/settings.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="admin-body">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3 shadow-sm">

   <!-- Dashboard -->
    <a class="navbar-brand fw-bold nav-animate" href="adminDashboard.php">
        <i class="bi bi-speedometer2"></i> Admin Dashboard
    </a>


    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav ms-auto">

            <li class="nav-item">
                <a class="nav-link nav-animate" href="admin_projects.php">
                    <i class="bi bi-kanban"></i> Projects
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-animate" href="admin_skills.php">
                    <i class="bi bi-lightning-charge"></i> Skills
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-animate" href="admin.php">
                    <i class="bi bi-people"></i> Admins
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-animate" href="statistics.php">
                    <i class="bi bi-bar-chart"></i> Statistics
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-animate active" href="#">
                    <i class="bi bi-gear"></i> Settings
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-animate" href="admin_experience.php">
                    <i class="bi bi-briefcase"></i> Experience
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-animate" href="cv_builder.php">
                    <i class="bi bi-file-earmark-pdf"></i> CV Builder
                </a>
            </li>

            <!-- زر تسجيل الخروج -->
            <li class="nav-item">
                <button class="btn btn-outline-danger ms-lg-3 mt-2 mt-lg-0" onclick="confirmLogout()">
                    <i class="bi bi-box-arrow-right"></i>Logout
                </button>
            </li>

        </ul>

    </div>
</nav>

<div class="container py-4">

<!-- 🔐 Change Password -->
<div class="card-box">
    <h5><i class="bi bi-lock"></i> Change Password</h5>

    <input type="password" id="old_password" class="form-control mb-2" placeholder="Current Password">
    <input type="password" id="new_password" class="form-control mb-2" placeholder="New Password">

    <button class="btn btn-primary w-100" onclick="changePassword()">Update</button>
    <div id="passMsg" class="text-danger mt-2"></div>
</div>

<!-- 👤 Add Admin -->
<div class="card-box">
    <h5><i class="bi bi-person-plus"></i> Add Admin</h5>

    <input type="text" id="new_user" class="form-control mb-2" placeholder="Username">
    <input type="password" id="new_pass" class="form-control mb-2" placeholder="Password">

    <button class="btn btn-success w-100" onclick="addAdmin()">Add Admin</button>
    <div id="adminMsg" class="text-danger mt-2"></div>
</div>

<!-- 🌐 Social Links -->
<div class="card-box">
    <h5><i class="bi bi-globe"></i> Social Links</h5>

    <input type="text" id="facebook" class="form-control mb-2" value="<?= $settings['facebook'] ?>">
    <input type="text" id="github" class="form-control mb-2" value="<?= $settings['github'] ?>">
    <input type="text" id="twitter" class="form-control mb-2" value="<?= $settings['twitter'] ?>">
    <input type="text" id="instagram" class="form-control mb-2" value="<?= $settings['instagram'] ?>">
    <input type="text" id="linkedin" class="form-control mb-2" value="<?= $settings['linkedin'] ?>">
    <input type="text" id="email" class="form-control mb-2" value="<?= $settings['email'] ?>">

    <button class="btn btn-warning w-100" onclick="saveLinks()">Save</button>
    <div id="linksMsg" class="text-success mt-2"></div>
</div>

<!-- 💾 Backup -->
<div class="card-box text-center">
    <h5><i class="bi bi-download"></i> Backup</h5>
    <button class="btn btn-dark w-100" onclick="backup()">Download Backup</button>
</div>

</div>

<script src="../assets/js/settings.js"></script>
</body>
</html>