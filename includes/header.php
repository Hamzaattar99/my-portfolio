<?php
// session_start();
if(isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$language = $_SESSION['lang'] ?? 'en';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Portfolio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="index.php"><?php echo ($language=='en') ? "Home" : "الرئيسية"; ?></a></li>
                <li class="nav-item"><a class="nav-link" href="projects.php"><?php echo ($language=='en') ? "Projects" : "المشاريع"; ?></a></li>
                <li class="nav-item"><a class="nav-link" href="experience.php"><?php echo ($language=='en') ? "Experience" : "الخبرات"; ?></a></li>
                <li class="nav-item"><a class="nav-link" href="skills.php"><?php echo ($language=='en') ? "Skills" : "المهارات"; ?></a></li>
                <li class="nav-item"><a class="nav-link" href="about.php"><?php echo ($language=='en') ? "About" : "من أنا"; ?></a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php"><?php echo ($language=='en') ? "Contact" : "تواصل"; ?></a></li>

                <!-- Language Buttons -->
                <li class="nav-item d-lg-flex align-items-center ms-lg-3">
                    <a href="?lang=en" class="btn btn-outline-primary btn-sm me-2 <?php echo ($language=='en')?'active':''; ?>">EN</a>
                    <a href="?lang=ar" class="btn btn-outline-primary btn-sm <?php echo ($language=='ar')?'active':''; ?>">AR</a>
                </li>
            </ul>
        </div>
    </div>
</nav>