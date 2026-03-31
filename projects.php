<?php
session_start();
require_once "includes/db.php";

$language = $_SESSION['lang'] ?? 'en';



$search = $_GET['search'] ?? '';
$search = preg_replace("/[^a-zA-Z0-9\x{0600}-\x{06FF}\s]/u", "", $search); // to remove any special characters from the search 

$sort = $_GET['sort'] ?? 'new';

$order = "ORDER BY created_at DESC";
if($sort == "old") $order = "ORDER BY created_at ASC";
if($sort == "az") $order = ($language=='ar') ? "ORDER BY project_title_ar ASC" : "ORDER BY project_title_en ASC";

$query = "SELECT * FROM projects WHERE 
project_title_en LIKE '%$search%' OR project_title_ar LIKE '%$search%' $order";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>" dir="<?php echo ($language=='ar')?'rtl':'ltr'; ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Projects</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<?php if($language=='ar'): ?>
<style>
    body {
        direction: ltr;
        text-align: left;
    }
</style>
<?php endif; ?>

<link rel="stylesheet" href="assets/css/nav.css">
<link rel="stylesheet" href="assets/css/foot.css">
<link rel="stylesheet" href="assets/css/projects.css">
</head>

<body style="font-family: <?php echo ($language=='ar')?'Cairo':'Roboto'; ?>, sans-serif;">

<?php include 'includes/header.php'; ?>

<!-- Hero -->
<section class="projects-hero text-center d-flex align-items-center justify-content-center">
    <div>
        <h1><?php echo ($language=='en') ? "My Projects" : "مشاريعي"; ?></h1>
    </div>
</section>

<!-- Search & Filter -->
<section class="container py-4">
    <form class="row g-2">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control"
            placeholder="<?php echo ($language=='en')?'Search...':'بحث...'; ?>" >
        </div>
        <div class="col-md-4">
            <select name="sort" class="form-control">
                <option value="new"><?php echo ($language=='en')?'Newest':'الأحدث'; ?></option>
                <option value="old"><?php echo ($language=='en')?'Oldest':'الأقدم'; ?></option>
                <option value="az"><?php echo ($language=='en')?'A-Z':'أبجدي'; ?></option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                <?php echo ($language=='en')?'Apply':'تطبيق'; ?>
            </button>
        </div>
    </form>
</section>

<!-- Projects -->
<section class="container py-5">
<div class="row">

<?php while($row = $result->fetch_assoc()): 
$title = ($language=='ar') ? $row['project_title_ar'] : $row['project_title_en'];
$desc = ($language=='ar') ? $row['project_description_ar'] : $row['project_description_en'];
?>

<div class="col-md-4 mb-4">
<div class="project-card">

<div class="card-inner">

<!-- Front -->
<div class="card-front">
    <img src="assets/images/<?php echo $row['project_image']; ?>" alt="">
    <h3><?php echo $title; ?></h3>
</div>

<!-- Back -->
<div class="card-back">
    <p class="desc">
        <span class="short"><?php echo substr($desc,0,100); ?>...</span>
        <span class="full d-none"><?php echo $desc; ?></span>
    </p>

    <button class="toggle-desc btn btn-sm btn-outline-light">
        <?php echo ($language=='en')?'Show More':'عرض المزيد'; ?>
    </button>

    <p class="tech"><?php echo $row['project_technologies']; ?></p>

    <div class="links">
        <a href="<?php echo $row['github_link']; ?>" target="_blank" class="btn btn-dark btn-sm">GitHub</a>

        <?php if(!empty($row['live_link'])): ?>
        <a href="<?php echo $row['live_link']; ?>" target="_blank" class="btn btn-success btn-sm">
            <?php echo ($language=='en')?'Live':'عرض'; ?>
        </a>
        <?php endif; ?>
    </div>
</div>

</div>

</div>
</div>

<?php endwhile; ?>

</div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="assets/js/projects.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>