<?php
session_start();
require_once "../includes/db.php";

// حماية الصفحة (مهم جدًا)
require_once "../includes/auth.php";

// البحث اللحظي
$search = $_GET['search'] ?? '';

if(!empty($search)){
    $stmt = $conn->prepare("SELECT * FROM projects 
        WHERE project_title_en LIKE ? OR project_title_ar LIKE ? 
        ORDER BY created_at DESC");
    $searchParam = "%$search%";
    $stmt->bind_param("ss", $searchParam, $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
}

$count = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Projects</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/adminDahs.css">
<link rel="stylesheet" href="../assets/css/admin_projects.css">
<link rel="stylesheet" href="../assets/css/admin_nav.css">

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
                <a class="nav-link nav-animate active" href="#">
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

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h4>Projects (<?php echo $count; ?>)</h4>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#projectModal" onclick="openForm(true)">+ Add Project</button>
    </div>

    <!-- Search -->
    <div class="mb-3 col-12 col-md-6 px-0 px-md-2">
        <input type="text" id="searchInput" name="search" class="form-control" 
        placeholder="Search projects..." value="<?php echo htmlspecialchars($search); ?>">
    </div>

    <!-- Projects List -->
    <div id="projectsContainer" class="projects-list row g-3">

        <?php while($row = $result->fetch_assoc()): ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="project-card p-3 rounded bg-white bg-opacity-10 text-white d-flex flex-column align-items-center">
                <img src="<?php echo !empty($row['project_image']) ? '../assets/images/'.$row['project_image'] : 'https://via.placeholder.com/150'; ?>" 
                     class="project-img mb-2" alt="Project Image">

                <h5 class="text-center mb-1"><?php echo $row['project_title_en']; ?></h5>
                <h6 class="text-center text-secondary mb-2"><?php echo $row['project_title_ar']; ?></h6>

                <div class="d-flex justify-content-center gap-2 mb-2">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailsModal" 
                        onclick="viewProject(<?php echo $row['project_id']; ?>)">View</button>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#projectModal" 
                        onclick="editProject(
                            <?php echo $row['project_id']; ?>,
                            '<?php echo addslashes($row['project_title_en']); ?>',
                            '<?php echo addslashes($row['project_title_ar']); ?>',
                            '<?php echo addslashes($row['project_description_en']); ?>',
                            '<?php echo addslashes($row['project_description_ar']); ?>',
                            '<?php echo addslashes($row['project_technologies']); ?>',
                            '<?php echo addslashes($row['github_link']); ?>',
                            '<?php echo addslashes($row['live_link']); ?>',
                            '<?php echo addslashes($row['project_image']); ?>'
                        )">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteProject(<?php echo $row['project_id']; ?>)">Delete</button>
                </div>
            </div>
        </div>
        <?php endwhile; ?>

    </div>
</div>

<!-- Add/Edit Project Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="formTitle">Add Project</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="project_id">
        <input type="text" id="title_en" class="form-control mb-2" placeholder="Title (EN)" required>
        <input type="text" id="title_ar" class="form-control mb-2" placeholder="Title (AR)" required>
        <textarea id="description_en" class="form-control mb-2" placeholder="Description (EN)" rows="3" required></textarea>
        <textarea id="description_ar" class="form-control mb-2" placeholder="Description (AR)" rows="3" required></textarea>
        <input type="text" id="technologies" class="form-control mb-2" placeholder="Technologies used (comma separated)" required>
        <input type="url" id="github_link" class="form-control mb-2" placeholder="GitHub Link" required>
        <input type="url" id="live_link" class="form-control mb-2" placeholder="Live Link (optional)">
        <input type="file" id="project_image" class="form-control mb-2">
      </div>
      <div class="modal-footer d-flex flex-column">
        <button class="btn btn-primary w-100 mb-2" onclick="saveProject()">Save</button>
        <button class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Project Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsTitle">Project Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <img id="detailsImage" src="" class="img-fluid rounded mb-3" alt="Project Image">
        <h5 id="detailsTitleEn"></h5>
        <h6 id="detailsTitleAr" class="text-secondary mb-2"></h6>
        <p>
            <span id="detailsDescription"></span>
            <button class="btn btn-sm btn-link text-info" onclick="toggleDescriptionLang()">Change Language</button>
        </p>
        <p><strong>Technologies:</strong> <span id="detailsTechnologies"></span></p>
        <p><strong>GitHub:</strong> <a href="#" id="detailsGithub" target="_blank">Link</a></p>
        <p><strong>Live Link:</strong> <a href="#" id="detailsLive" target="_blank">Link</a></p>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin_projects.js"></script>
</body>
</html>