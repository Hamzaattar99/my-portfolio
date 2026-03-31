<?php
$file = "../assets/uploads/cv/cv.pdf";


$currentPage = basename($_SERVER['PHP_SELF']); // to get the current page's name
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View CV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- نفس ستايل الأدمن -->
    <link rel="stylesheet" href="../assets/css/adminDahs.css">
    <link rel="stylesheet" href="../assets/css/cv_view.css?v=<?php echo time(); ?>">

    
</head>

<body class="container py-4">






<div class="cv-container fade-in">

    <div class="cv-header">
        <h3><i class="bi bi-file-earmark-person"></i> Current CV</h3>

        <div>
            <a href="cv_builder.php" class="btn btn-outline-light btn-custom me-2">
                <i class="bi bi-pencil-square"></i> Edit CV
            </a>
        </div>
    </div>

<?php if (file_exists($file)): ?>

    <!-- Buttons -->
    <div class="mb-3 d-flex gap-2 flex-wrap">

        <a href="<?= $file ?>" class="btn btn-success btn-custom" download>
            <i class="bi bi-download"></i> Download
        </a>

        <a href="<?= $file ?>" target="_blank" class="btn btn-info btn-custom">
            <i class="bi bi-box-arrow-up-right"></i> Open Full
        </a>

        <button onclick="reloadPreview()" class="btn btn-warning btn-custom">
            <i class="bi bi-arrow-clockwise"></i> Refresh
        </button>

    </div>

    <!-- Preview -->
    <iframe 
        id="cvFrame"
        src="<?= $file ?>" 
        width="100%" 
        height="750px">
    </iframe>

<?php else: ?>

    <div class="no-cv">
        <i class="bi bi-exclamation-triangle fs-1 text-warning"></i>
        <h4 class="mt-3">No CV Found</h4>
        <p>Please generate your CV from builder page</p>

        <a href="cv_builder.php" class="btn btn-primary btn-custom mt-2">
            <i class="bi bi-plus-circle"></i> Create CV
        </a>
    </div>

<?php endif; ?>

</div>

<script>
function reloadPreview(){
    const frame = document.getElementById("cvFrame");
    frame.src = frame.src;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>