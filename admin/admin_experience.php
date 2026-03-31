<?php
session_start();
require_once "../includes/db.php";


// حماية الصفحة (مهم جدًا)
require_once "../includes/auth.php";


$search = $_GET['search'] ?? '';

if(!empty($search)){
    $stmt = $conn->prepare("SELECT * FROM experience 
        WHERE exp_title_en LIKE ? OR exp_title_ar LIKE ? OR exp_company LIKE ?
        ORDER BY start_date DESC");
    $q = "%$search%";
    $stmt->bind_param("sss",$q,$q,$q);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM experience ORDER BY start_date DESC");
}

$count = $result->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Experience</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/adminDahs.css">
<link rel="stylesheet" href="../assets/css/admin_experience.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="admin-body">

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
                <a class="nav-link nav-animate active" href="#">
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

<div class="d-flex justify-content-between mb-3">
    <h4>Experience (<?= $count ?>)</h4>
    <button class="btn btn-success" onclick="openForm(true)">
        <i class="bi bi-plus"></i> Add
    </button>
</div>

<input type="text" id="searchInput" class="form-control mb-3" placeholder="Search...">

<div id="experienceContainer">

<?php while($row = $result->fetch_assoc()): ?>
<div class="exp-item">

    <div class="exp-info">
        <h5><?= $row['exp_title_en'] ?> | <?= $row['exp_title_ar'] ?></h5>
        <p class="company"><?= $row['exp_company'] ?></p>
        <p><?= $row['exp_description_en'] ?></p>
        <p><?= $row['exp_description_ar'] ?></p>
        <p class="date"><?= $row['start_date'] ?> → <?= $row['end_date'] ?: 'Present' ?></p>
    </div>

    <div class="exp-actions">
        <button class="btn btn-warning btn-sm"
        onclick="editExp(
            <?= $row['exp_id'] ?>,
            '<?= addslashes($row['exp_title_en']) ?>',
            '<?= addslashes($row['exp_title_ar']) ?>',
            '<?= addslashes($row['exp_company']) ?>',
            '<?= addslashes($row['exp_description_en']) ?>',
            '<?= addslashes($row['exp_description_ar']) ?>',
            '<?= $row['start_date'] ?>',
            '<?= $row['end_date'] ?>'
        )">Edit</button>

        <button class="btn btn-danger btn-sm"
        onclick="deleteExp(<?= $row['exp_id'] ?>)">Delete</button>
    </div>

</div>
<?php endwhile; ?>

</div>
</div>

<!-- Modal -->
<div class="modal fade" id="expModal">
<div class="modal-dialog">
<div class="modal-content bg-dark text-white">

<div class="modal-header">
<h5 id="formTitle">Add Experience</h5>
<button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<input type="hidden" id="exp_id">

<input id="title_en" class="form-control mb-2" placeholder="Title EN">
<input id="title_ar" class="form-control mb-2" placeholder="Title AR">
<input id="company" class="form-control mb-2" placeholder="Company">

<textarea id="desc_en" class="form-control mb-2" placeholder="Description EN"></textarea>
<textarea id="desc_ar" class="form-control mb-2" placeholder="Description AR"></textarea>

<input type="date" id="start_date" class="form-control mb-2">
<input type="date" id="end_date" class="form-control mb-2">

</div>

<div class="modal-footer">
<button class="btn btn-primary w-100" onclick="saveExp()">Save</button>
</div>

</div>
</div>
</div>

<script src="../assets/js/admin_experience.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>