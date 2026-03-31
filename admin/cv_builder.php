<?php
session_start();
require_once "../includes/db.php";

// حماية الصفحة (مهم جدًا)
require_once "../includes/auth.php";

// جلب البيانات
$projects = $conn->query("SELECT project_title_en, project_description_en FROM projects");
$experience = $conn->query("SELECT exp_title_en, exp_company, start_date, end_date, exp_description_en FROM experience");
$skills = $conn->query("SELECT skill_name_en FROM skills");


$currentPage = basename($_SERVER['PHP_SELF']); // to get the current page's name2
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CV Builder</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<!-- Admin Style (نفس النظام السابق) -->
<link rel="stylesheet" href="../assets/css/adminDahs.css">
<link rel="stylesheet" href="../assets/css/cv.css?v=<?php echo time(); ?>">


</head>

<body class="admin-body">


 <!-- SIDEBAR (نفس باقي الصفحات) -->
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
                <a class="nav-link nav-animate active" href="#">
                    <i class="bi bi-file-earmark-pdf"></i> CV Builder
                </a>
            </li>

            <?php if($currentPage == "cv_builder.php"): ?>

            <li class="nav-item">
                <a class="nav-link nav-animate" href="view_cv.php">
                    <i class="bi bi-pencil-square"></i> View CV
                </a>
            </li>

            <?php endif; ?>

            <!-- زر تسجيل الخروج -->
            <li class="nav-item">
                <button class="btn btn-outline-danger ms-lg-3 mt-2 mt-lg-0" onclick="confirmLogout()">
                    <i class="bi bi-box-arrow-right"></i>Logout
                </button>
            </li>

        </ul>

    </div>
</nav>


<div class="admin-wrapper">

   

    <!-- CONTENT -->
    <div class="admin-content">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">
                <i class="bi bi-file-earmark-person"></i> CV Builder
            </h3>

            <a href="view_cv.php" class="btn btn-outline-primary">
                <i class="bi bi-eye"></i> View CV
            </a>
        </div>

        <!-- FORM -->
        <div class="admin-card p-4 mb-4">

            <div class="row">
                <div class="col-md-6 mb-2">
                    <input id="fullName" class="form-control" placeholder="Full Name">
                </div>

                <div class="col-md-6 mb-2">
                    <input id="email" class="form-control" placeholder="Email">
                </div>

                <div class="col-md-6 mb-2">
                    <input id="phone" class="form-control" placeholder="Phone">
                </div>

                <div class="col-md-12 mb-2">
                    <textarea id="summary" class="form-control" placeholder="Professional Summary"></textarea>
                </div>

                <div class="col-md-4 mb-2">
                    <input id="languages" class="form-control" placeholder="Languages">
                </div>

                <div class="col-md-4 mb-2">
                    <input id="education" class="form-control" placeholder="Education">
                </div>

                <div class="col-md-4 mb-2">
                    <input id="certifications" class="form-control" placeholder="Certifications">
                </div>

                <div class="col-12 mt-3">
                    <button class="btn btn-success w-100" onclick="generateCV()">
                        <i class="bi bi-file-earmark-pdf"></i> Generate & Save CV
                    </button>
                </div>

            </div>
        </div>

        <!-- PREVIEW -->
        <div id="preview" class="admin-card p-4">
            <div class="text-muted">CV preview will appear here...</div>
        </div>

    </div>
</div>

<!-- DATA -->
<script>
const projects = <?= json_encode($projects->fetch_all(MYSQLI_ASSOC)); ?>;
const experience = <?= json_encode($experience->fetch_all(MYSQLI_ASSOC)); ?>;
const skills = <?= json_encode($skills->fetch_all(MYSQLI_ASSOC)); ?>;
</script>

<!-- JS -->
<script src="../assets/js/cv.js?v=<?php echo time(); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>