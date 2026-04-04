<?php
session_start();
$language = $_SESSION['lang'] ?? 'en';
?>
<!DOCTYPE html>
<html lang="<?php echo $language; ?>" dir="<?php echo ($language=='ar')?'rtl':'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me</title>

       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<?php if($language=='ar'): ?>
<style>
    body {
        direction: ltr;
        text-align: left;
    }
</style>
<?php endif; ?>

    <link rel="stylesheet" href="assets/css/nav.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/foot.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/about.css?v=<?php echo time(); ?>">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>

<body style="font-family: <?php echo ($language=='ar')?'Cairo':'Roboto'; ?>, sans-serif;">

<?php include 'includes/header.php'; ?>

<!-- Hero -->
<section class="about-hero text-center d-flex align-items-center justify-content-center">
    <div>
        <h1 class="fade-in">
            <?php echo ($language=='en') ? "About Me" : "من أنا"; ?>
        </h1>
        <p class="fade-in">
            <?php echo ($language=='en') ? 
            "Backend Developer passionate about building secure systems" : 
            "مطور Backend شغوف ببناء أنظمة آمنة"; ?>
        </p>
    </div>
</section>

<!-- About -->
<section class="container py-5">
    <div class="row align-items-center">
        <div class="col-md-6 fade-in">
            <h2><?php echo ($language=='en') ? "Who I Am" : "من أنا"; ?></h2>
            <p>
            <?php echo ($language=='en') ?
            "I am interested in backend development, with a focus on designing efficient, secure, and scalable server-side applications." :
            "أنا مهتم بتطوير الأنظمة ، مع التركيز على تصميم تطبيقات خادم فعالة وآمنة وقابلة للتوسع."; ?>
            </p>
        </div>
        <div class="col-md-6 text-center fade-in">
            <img src="assets/img/profile.png" class="img-fluid rounded shadow" alt="profile">
        </div>
    </div>
</section>

<!-- Skills -->
<section class="skills-section py-5 text-center">
    <div class="container">
        <h2 class="mb-4 fade-in"><?php echo ($language=='en') ? "Skills" : "المهارات"; ?></h2>

        <div class="row">
            <?php 
            $skills = ["PHP","MySQL","JavaScript","Bootstrap","C#","Linux"];
            foreach($skills as $skill): ?>
            <div class="col-md-2 col-6 mb-3 fade-in">
                <div class="skill-box"><?php echo $skill; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Goals -->
<section class="container py-5 text-center fade-in">
    <h2><?php echo ($language=='en') ? "My Goal" : "هدفي"; ?></h2>
    <p>
    <?php echo ($language=='en') ?
    "To design, develop, and maintain scalable and secure backend systems that support high-performance applications 
    <br>and deliver reliable services." :
    "تطوير وتصميم وصيانة أنظمة قابلة للتوسع وآمنة تدعم تطبيقات عالية الأداء وتوفر خدمات موثوقة."; ?>
    </p>
</section>


<?php $cvFile = "assets/uploads/cv/cv.pdf"; ?>

<section class="container py-5 text-center fade-in">
    <div class="cv-box mx-auto">

        <h2 class="mb-3">
            <?php echo ($language=='en') ? "My Resume" : "سيرتي الذاتية"; ?>
        </h2>

        <p class="mb-4 ">
            <?php echo ($language=='en') ? 
            "Download my professional CV (ATS optimized)" : 
            "قم بتحميل سيرتي الذاتية الاحترافية"; ?>
        </p>

        <?php if(file_exists($cvFile)): ?>

        <div class="d-flex justify-content-center gap-3 flex-wrap">

            <!-- Download -->
            <a href="<?= $cvFile ?>" download class="btn cv-btn-primary">
                <i class="bi bi-download"></i>
                <?php echo ($language=='en') ? "Download CV" : "تحميل CV"; ?>
            </a>

            <!-- Preview -->
            <a href="<?= $cvFile ?>" target="_blank" class="btn cv-btn-outline">
                <i class="bi bi-eye"></i>
                <?php echo ($language=='en') ? "Preview" : "عرض"; ?>
            </a>

        </div>

        <?php
            $timestamp = filemtime($cvFile);

            if($language == 'ar'){
                $dateText = "آخر تحديث: " . date("Y-m-d", $timestamp);
            }else {
                $dateText = "Last updated: " . date("Y-m-d", $timestamp);
            }
        ?>

        <p class="mt-3 small ">
            <?= $dateText ?>
        </p>

        <?php else: ?>

        <div class="alert alert-warning">
            <?php echo ($language=='en') ? 
            "CV not available yet" : 
            "لم يتم إنشاء السيرة الذاتية بعد"; ?>
        </div>

        <?php endif; ?>

    </div>
</section>

<!-- CTA -->
<section class="cta text-center py-5">
    <a href="contact.php" class="btn btn-primary btn-lg bti">
        <?php echo ($language=='en') ? "Contact Me" : "تواصل معي"; ?>
    </a>
</section>

<?php include 'includes/footer.php'; ?>

<script src="assets/js/about.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>