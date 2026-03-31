<?php
session_start();
require_once "../includes/db.php";

// حماية الصفحة (مهم جدًا)
require_once "../includes/auth.php";

// استلام قيمة البحث
$search = $_GET['search'] ?? '';

if(!empty($search)){
    $stmt = $conn->prepare("SELECT * FROM skills 
        WHERE skill_name_en LIKE ? OR skill_name_ar LIKE ? 
        ORDER BY created_at DESC");

    $searchParam = "%$search%";
    $stmt->bind_param("ss", $searchParam, $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM skills ORDER BY created_at DESC");
}

$count = $result->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Skills</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/adminDahs.css">
<link rel="stylesheet" href="../assets/css/admin_skills.css">
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
                <a class="nav-link nav-animate active" href="#">
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

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h4>Skills (<?php echo $count; ?>)</h4>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#skillModal" onclick="openForm(true)">+ Add Skill</button>
    </div>

    <!-- Search -->
    <div class="mb-3 col-12 col-md-6 px-0 px-md-2">
        <input type="text" id="searchInput" name="search" class="form-control" 
        placeholder="Search..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
    </div>

    <!-- Skills List -->
    <div id="skillsContainer" class="skills-list">
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="skill-item row align-items-center py-2 px-3 rounded">
            <div class="col-12 col-sm-7">
                <strong><?php echo $row['skill_name_en']; ?></strong> |
                <?php echo $row['skill_name_ar']; ?>
                <span class="level <?php echo strtolower($row['skill_level']); ?>">
                    <?php echo $row['skill_level']; ?>
                </span>
            </div>
            <div class="col-12 col-sm-5 text-sm-end mt-2 mt-sm-0">
                <button class="btn btn-warning btn-sm me-2 w-20 w-sm-auto"
                onclick="editSkill(
                    <?php echo $row['skill_id']; ?>,
                    '<?php echo $row['skill_name_en']; ?>',
                    '<?php echo $row['skill_name_ar']; ?>',
                    '<?php echo $row['skill_level']; ?>'
                )" data-bs-toggle="modal" data-bs-target="#skillModal">Edit</button>

                <button class="btn btn-danger btn-sm w-20 w-sm-auto"
                onclick="deleteSkill(<?php echo $row['skill_id']; ?>)">Delete</button>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Popup Modal -->
<div class="modal fade" id="skillModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="formTitle">Add Skill</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="skill_id">
        <input type="text" id="name_en" class="form-control mb-2" placeholder="Skill (EN)" required>
        <input type="text" id="name_ar" class="form-control mb-2" placeholder="Skill (AR)" required>
        <div class="form-check mb-2">
          <input type="checkbox" id="autoTranslate" class="form-check-input">
          <label class="form-check-label">Auto Translate (EN → AR)</label>
        </div>
        <select id="level" class="form-select mb-2">
          <option value="Beginner">Beginner</option>
          <option value="Intermediate">Intermediate</option>
          <option value="Advanced">Advanced</option>
        </select>
      </div>
      <div class="modal-footer d-flex flex-column">
        <button class="btn btn-primary w-100 mb-2" onclick="saveSkill()">Save</button>
        <button class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin_skills.js"></script>
</body>
</html>