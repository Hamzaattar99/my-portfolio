<?php
session_start();
require_once "../includes/db.php";

// حماية الصفحة (مهم جدًا)
require_once "../includes/auth.php";

// Counts
$projects = $conn->query("SELECT COUNT(*) as c FROM projects")->fetch_assoc()['c'];
$skills = $conn->query("SELECT COUNT(*) as c FROM skills")->fetch_assoc()['c'];
$experience = $conn->query("SELECT COUNT(*) as c FROM experience")->fetch_assoc()['c'];
$admins = $conn->query("SELECT COUNT(*) as c FROM admin")->fetch_assoc()['c'];

// آخر دخول (مؤقت - من السيشن)
$last_login = $_SESSION['last_login'] ?? "First login";


 $last_active_time = $_SESSION['last_activity'] ;
 $last_user_ip = $_SESSION['user_ip']  ?? $_SESSION['error_ip']  ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Statistics</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/adminDahs.css">
<link rel="stylesheet" href="../assets/css/statistics.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
                <a class="nav-link nav-animate active" href="#">
                    <i class="bi bi-bar-chart"></i> Statistics
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link nav-animate" href="settings.php">
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

    <!-- Stats Cards -->
    <div class="row g-3">

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <i class="bi bi-kanban"></i>
                <h4><?php echo $projects; ?></h4>
                <p>Projects</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <i class="bi bi-lightbulb"></i>
                <h4><?php echo $skills; ?></h4>
                <p>Skills</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <i class="bi bi-briefcase"></i>
                <h4><?php echo $experience; ?></h4>
                <p>Experience</p>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <i class="bi bi-people"></i>
                <h4><?php echo $admins; ?></h4>
                <p>Admins</p>
            </div>
        </div>

    </div>

    <!-- Logs Section -->
    <div class="logs-box mt-4">
        <h5><i class="bi bi-clock-history"></i> Activity Logs</h5>

        <ul>
            <li>Last Login: <?php echo $last_login; ?></li>
            <li>System Running Normally</li>
            <li>Last Update: <?php echo date("Y-m-d H:i"); ?></li>
            <li>Last Activity: <?php echo $last_active_time; ?></li>
            <li>User IP (Last Active): <?php echo $last_user_ip; ?></li>
        </ul>
    </div>

    <!-- Progress Section -->
    <div class="progress-box mt-4">
        <h5>System Distribution</h5>

        <?php
        $total = $projects + $skills + $experience;
        $p1 = $total ? ($projects/$total)*100 : 0;
        $p2 = $total ? ($skills/$total)*100 : 0;
        $p3 = $total ? ($experience/$total)*100 : 0;
        ?>

        <div class="mb-2">Projects</div>
        <div class="progress mb-3">
            <div class="progress-bar bg-primary" style="width:<?php echo $p1; ?>%"></div>
        </div>

        <div class="mb-2">Skills</div>
        <div class="progress mb-3">
            <div class="progress-bar bg-success" style="width:<?php echo $p2; ?>%"></div>
        </div>

        <div class="mb-2">Experience</div>
        <div class="progress mb-3">
            <div class="progress-bar bg-warning" style="width:<?php echo $p3; ?>%"></div>
        </div>

    </div>

    <!-- Live Clock -->
    <div class="clock-box mt-4 text-center">
        <h5>Current Time</h5>
        <h3 id="clock"></h3>
    </div>

</div>

<script src="../assets/js/statistics.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>