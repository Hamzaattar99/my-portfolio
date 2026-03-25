<?php
session_start();
$language = $_SESSION['lang'] ?? 'en';
?>
<!DOCTYPE html>
<html lang="<?php echo $language; ?>" dir="<?php echo ($language=='ar')?'rtl':'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    
    <?php if($language=='ar'): ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-rtl@5.3.0/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
    <?php else: ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/nav.css">
    <link rel="stylesheet" href="assets/css/foot.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>
<body style="font-family: <?php echo ($language=='ar')?'Cairo':'Roboto'; ?>, sans-serif; background:#f8f9fa;">

<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero d-flex align-items-center justify-content-center text-center" style="height:100vh;">
    <div class="container">
        <h1 class="display-4 fw-bold fade-in">
            <?php echo ($language=='en') ? "Hi, I'm Hamza" : "مرحباً، أنا حمزة"; ?>
        </h1>
        <p class="lead mt-3 fade-in">
            <?php echo ($language=='en') ? "I am a Backend & Web Developer. I build modern and responsive websites." : "أنا مطور ويب و Backend. أقوم ببناء مواقع حديثة ومتجاوبة."; ?>
        </p>
        <a href="#projects" class="btn btn-primary btn-lg mt-3">
            <?php echo ($language=='en') ? "View My Projects" : "عرض مشاريعي"; ?>
        </a>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4 fade-in">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <h3 class="mb-3"><?php echo ($language=='en') ? "Projects" : "المشاريع"; ?></h3>
                    <p><?php echo ($language=='en') ? "I develop modern and responsive web applications." : "أقوم بتطوير تطبيقات ويب حديثة ومتجاوبة."; ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-4 fade-in">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <h3 class="mb-3"><?php echo ($language=='en') ? "Skills" : "المهارات"; ?></h3>
                    <p><?php echo ($language=='en') ? "Backend, PHP, MySQL, JavaScript, Bootstrap." : "Backend، PHP، MySQL، JavaScript، Bootstrap."; ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-4 fade-in">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <h3 class="mb-3"><?php echo ($language=='en') ? "Experience" : "الخبرات"; ?></h3>
                    <p><?php echo ($language=='en') ? "I have worked on multiple professional projects." : "عملت على عدة مشاريع احترافية."; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="assets/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>