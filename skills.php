<?php
require_once "includes/db.php";
session_start();
$language = $_SESSION['lang'] ?? 'en';


$result = $conn->query("SELECT * FROM skills ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>" dir="<?php echo ($language=='ar')?'rtl':'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills</title>

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
    <link rel="stylesheet" href="assets/css/skills.css">
</head>

<body style="font-family: <?php echo ($language=='ar')?'Cairo':'Roboto'; ?>, sans-serif;">

<?php include 'includes/header.php'; ?>

<!-- Hero -->
<section class="skills-hero text-center d-flex align-items-center justify-content-center">
    <div>
        <h1 class="fade-in"><?php echo ($language=='en') ? "My Skills" : "مهاراتي"; ?></h1>
        <p class="fade-in"><?php echo ($language=='en') ? "What I am good at" : "ما أجيده"; ?></p>
    </div>
</section>

<!-- Skills -->
<section class="container py-5">
    <div class="row">

    <?php while($row = $result->fetch_assoc()): 
        $skill_name = ($language=='ar') ? $row['skill_name_ar'] : $row['skill_name_en'];

        $level = $row['skill_level'];
        if($language=='ar'){
            if($level == "Beginner") $level = "مبتدئ";
            elseif($level == "Intermediate") $level = "متوسط";
            else $level = "متقدم";
        }
    ?>

        <div class="col-md-4 mb-4 fade-in">
            <div class="skill-card">
                <h3><?php echo $skill_name; ?></h3>
                <span class="level"><?php echo $level; ?></span>

                <!-- Progress -->
                <div class="progress mt-3">
                    <div class="progress-bar" data-level="<?php echo $row['skill_level']; ?>"></div>
                </div>
            </div>
        </div>

    <?php endwhile; ?>

    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="assets/js/skills.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>