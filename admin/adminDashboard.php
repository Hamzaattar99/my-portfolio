<?php
session_start();
require_once "../includes/db.php";
// حماية الصفحة (مهم جدًا)
/*if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}  */



// إحصائيات
$skills_count = $conn->query("SELECT COUNT(*) as c FROM skills")->fetch_assoc()['c'];
$projects_count = $conn->query("SELECT COUNT(*) as c FROM projects")->fetch_assoc()['c'];
$exp_count = $conn->query("SELECT COUNT(*) as c FROM experience")->fetch_assoc()['c'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/adminDahs.css">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="admin-body">

<!-- Navbar -->
<nav class="admin-nav d-flex justify-content-between align-items-center px-4">
    <h4>Admin Panel</h4>
    <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</nav>

<!-- Dashboard -->
<div class="container py-5">
<div class="row g-4">

<!-- Skills -->
<div class="col-md-4">
    <a href="admin_skills.php" class="admin-card">
        <i class="bi bi-lightning-fill"></i>
        <h5>Skills</h5>
        <p><?php echo $skills_count; ?> Items</p>
    </a>
</div>

<!-- Projects -->
<div class="col-md-4">
    <a href="admin_projects.php" class="admin-card">
        <i class="bi bi-kanban-fill"></i>
        <h5>Projects</h5>
        <p><?php echo $projects_count; ?> Items</p>
    </a>
</div>

<!-- Experience -->
<div class="col-md-4">
    <a href="experience.php" class="admin-card">
        <i class="bi bi-briefcase-fill"></i>
        <h5>Experience</h5>
        <p><?php echo $exp_count; ?> Items</p>
    </a>
</div>

<!-- Admins -->
<div class="col-md-4">
    <a href="admins.php" class="admin-card">
        <i class="bi bi-person-fill"></i>
        <h5>Admins</h5>
    </a>
</div>

<!-- Statistics -->
<div class="col-md-4">
    <a href="statistics.php" class="admin-card">
        <i class="bi bi-bar-chart-fill"></i>
        <h5>Statistics</h5>
    </a>
</div>

<!-- Settings -->
<div class="col-md-4">
    <a href="settings.php" class="admin-card">
        <i class="bi bi-gear-fill"></i>
        <h5>Settings</h5>
    </a>
</div>

</div>
</div>

<script src="../assets/js/adminDash.js"></script>
</body>
</html>