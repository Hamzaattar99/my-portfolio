<?php
session_start();
require_once "includes/db.php";
$language = $_SESSION['lang'] ?? 'en';


$result = $conn->query("SELECT * FROM experience ORDER BY start_date DESC");
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>" dir="<?php echo ($language=='ar')?'rtl':'ltr'; ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Experience</title>

<?php if($language=='ar'): ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-rtl@5.3.0/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
<?php else: ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<?php endif; ?>

<link rel="stylesheet" href="assets/css/nav.css">
<link rel="stylesheet" href="assets/css/foot.css">
<link rel="stylesheet" href="assets/css/experience.css">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body style="font-family: <?php echo ($language=='ar')?'Cairo':'Roboto'; ?>, sans-serif;">

<?php include 'includes/header.php'; ?>

<!-- Hero -->
<section class="exp-hero text-center d-flex align-items-center justify-content-center">
    <h1><?php echo ($language=='en') ? "My Experience" : "خبراتي"; ?></h1>
</section>

<!-- Timeline -->
<section class="container py-5">
<div class="timeline">

<?php while($row = $result->fetch_assoc()): 

$title = ($language=='ar') ? $row['exp_title_ar'] : $row['exp_title_en'];
$desc = ($language=='ar') ? $row['exp_description_ar'] : $row['exp_description_en'];

$company = $row['exp_company'] ?? '';
$start = $row['start_date'] ?? '';
$end = $row['end_date'] ?? '';

?>

<div class="timeline-item fade-in">

    <div class="timeline-icon">
        <i class="bi bi-briefcase-fill"></i>
    </div>

    <div class="timeline-content">

        <h3><?php echo $title; ?></h3>

        <?php if(!empty($company)): ?>
            <p class="company"><i class="bi bi-building"></i> <?php echo $company; ?></p>
        <?php endif; ?>

        <?php if(!empty($start) || !empty($end)): ?>
            <p class="date">
                <i class="bi bi-calendar"></i>
                <?php echo $start ?: ''; ?> 
                <?php echo ($end) ? " - $end" : ($language=='en' ? " - Present" : " - حتى الآن"); ?>
            </p>
        <?php endif; ?>

        <?php if(!empty($desc)): ?>
            <p class="desc"><?php echo $desc; ?></p>
        <?php endif; ?>

    </div>

</div>

<?php endwhile; ?>

</div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="assets/js/experience.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>