<?php
session_start();
require_once "../includes/db.php";

// Counts
$projects = $conn->query("SELECT COUNT(*) as c FROM projects")->fetch_assoc()['c'];
$skills = $conn->query("SELECT COUNT(*) as c FROM skills")->fetch_assoc()['c'];
$experience = $conn->query("SELECT COUNT(*) as c FROM experience")->fetch_assoc()['c'];
$admins = $conn->query("SELECT COUNT(*) as c FROM admin")->fetch_assoc()['c'];

// آخر دخول (مؤقت - من السيشن)
$last_login = $_SESSION['last_login'] ?? "First login";
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

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">Statistics</span>
    <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
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