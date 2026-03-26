<?php
session_start();
$language = $_SESSION['lang'] ?? 'en';


require_once "includes/db.php";

$settings = [];
$result = $conn->query("SELECT name, value FROM settings");

while($row = $result->fetch_assoc()){
    $settings[$row['name']] = $row['value'];
}


?>
<!DOCTYPE html>
<html lang="<?php echo $language; ?>" dir="<?php echo ($language=='ar')?'rtl':'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

    <?php if($language=='ar'): ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-rtl@5.3.0/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
    <?php else: ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>

    <link rel="stylesheet" href="assets/css/nav.css">
    <link rel="stylesheet" href="assets/css/foot.css">
    <link rel="stylesheet" href="assets/css/contact.css">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body style="font-family: <?php echo ($language=='ar')?'Cairo':'Roboto'; ?>, sans-serif;">

<?php include 'includes/header.php'; ?>

<!-- Hero -->
<section class="contact-hero text-center d-flex align-items-center justify-content-center">
    <div>
        <h1 class="fade-in"><?php echo ($language=='en') ? "Contact Me" : "تواصل معي"; ?></h1>
        <p class="fade-in"><?php echo ($language=='en') ? "Let's work together" : "دعنا نعمل معًا"; ?></p>
    </div>
</section>

<!-- Contact Form -->
<section class="container py-5">
    <div class="row">
        <div class="col-md-6 fade-in">
            <h3><?php echo ($language=='en') ? "Send Message" : "أرسل رسالة"; ?></h3>
            <form>
                <input type="text" class="form-control mb-3" placeholder="<?php echo ($language=='en') ? "Your Name" : "اسمك"; ?>">
                <input type="email" class="form-control mb-3" placeholder="Email">
                <textarea class="form-control mb-3" rows="5" placeholder="<?php echo ($language=='en') ? "Message" : "رسالتك"; ?>"></textarea>
                <button type="submit" class="btn btn-primary w-100">
                    <?php echo ($language=='en') ? "Send" : "إرسال"; ?>
                </button>
            </form>
        </div>

        <!-- Social Links -->
       <div class="col-md-6 text-center fade-in">
    <h3><?php echo ($language=='en') ? "Follow Me" : "تابعني"; ?></h3>

    <a href="<?php echo $settings['facebook'] ?? '#'; ?>" target="_blank" class="social-box facebook">
        <i class="bi bi-facebook"></i> Facebook
    </a>

    <a href="<?php echo $settings['github'] ?? '#'; ?>" target="_blank" class="social-box github">
        <i class="bi bi-github"></i> GitHub
    </a>

    <a href="<?php echo $settings['twitter'] ?? '#'; ?>" target="_blank" class="social-box twitter">
        <i class="bi bi-twitter"></i> X
    </a>

    <a href="<?php echo $settings['instagram'] ?? '#'; ?>" target="_blank" class="social-box instagram">
        <i class="bi bi-instagram"></i> Instagram
    </a>

    <a href="<?php echo $settings['linkedin'] ?? '#'; ?>" target="_blank" class="social-box linkedin">
        <i class="bi bi-linkedin"></i> LinkedIn
    </a>

    <!-- Email -->
    <div class="email-box mt-4">
        <span id="email">
            <?php echo $settings['email'] ?? 'your@email.com'; ?>
        </span>
        <button class="btn btn-outline-primary btn-sm" onclick="copyEmail()">
            <?php echo ($language=='en') ? "Copy" : "نسخ"; ?>
        </button>
    </div>
    </div>

    
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="assets/js/contact.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>