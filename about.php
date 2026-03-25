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

    <?php if($language=='ar'): ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-rtl@5.3.0/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
    <?php else: ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>

    <link rel="stylesheet" href="assets/css/nav.css">
    <link rel="stylesheet" href="assets/css/foot.css">
    <link rel="stylesheet" href="assets/css/about.css">

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
            "I am an IT student and backend developer interested in cybersecurity and web development. I build real projects and continuously improve my skills." :
            "أنا طالب تقنية معلومات ومطور Backend مهتم بالأمن السيبراني وتطوير الويب. أبني مشاريع حقيقية وأطور مهاراتي باستمرار."; ?>
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
    "My goal is to become a Security Engineer and build secure systems." :
    "هدفي أن أصبح مهندس أمن وأن أبني أنظمة آمنة."; ?>
    </p>
</section>

<!-- CTA -->
<section class="cta text-center py-5">
    <a href="contact.php" class="btn btn-primary btn-lg">
        <?php echo ($language=='en') ? "Contact Me" : "تواصل معي"; ?>
    </a>
</section>

<?php include 'includes/footer.php'; ?>

<script src="assets/js/about.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>