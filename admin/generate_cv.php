<?php
ob_start();
require '../vendor/autoload.php';

use Dompdf\Dompdf;

use function Safe\json_encode;



$data = json_decode(file_get_contents("php://input"), true);

$folder = "../assets/uploads/cv/";
$filePath = $folder . "cv.pdf";

// إنشاء المجلد إذا غير موجود
if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

// حذف القديم
if (file_exists($filePath)) {
    unlink($filePath);
}

$html = "
<h1>{$data['fullName']}</h1>
<p>{$data['email']} | {$data['phone']}</p>

<h3>Summary</h3>
<p>{$data['summary']}</p>

<h3>Skills</h3><ul>";

foreach ($data['skills'] as $s) {
    $html .= "<li>{$s['skill_name']}</li>";
}

$html .= "</ul><h3>Experience</h3>";

foreach ($data['experience'] as $e) {
    $html .= "
    <div>
        <b>{$e['exp_title_en']}</b> - {$e['exp_company']}<br>
        <small>{$e['start_date']} - {$e['end_date']}</small>
        <p>{$e['exp_description_en']}</p>
    </div>";
}

$html = "

<div style='text-align:center; margin-bottom:10px;'>
    <h1 style='margin:0;'>{$data['fullName']}</h1>
    <div style='font-size:14px;'>
        {$data['phone']} | {$data['email']}
    </div>
</div>

<hr>

<div style='text-align:left;'>

<h3>SUMMARY</h3>
<p>{$data['summary']}</p>

<hr>


<h3>EDUCATION</h3>
<p>{$data['education']}</p>

<hr>



<h3>SKILLS</h3>
<ul>";

foreach ($data['skills'] as $s) {
    $html .= "<li>{$s['skill_name_en']}</li>";
}

$html .= "</ul>

<hr>

<h3>EXPERIENCE</h3>";

foreach ($data['experience'] as $e) {
    $html .= "
    <div style='margin-bottom:10px;'>
        <b>{$e['exp_title_en']}</b> - {$e['exp_company']}<br>
        <small>{$e['start_date']} - {$e['end_date']}</small>
        <p style='margin:5px 0;'>{$e['exp_description_en']}</p>
    </div>";
}

$html .= "<hr>

<h3>PROJECTS</h3>";

foreach ($data['projects'] as $p) {
    $html .= "
    <div style='margin-bottom:10px;'>
        <b>{$p['project_title_en']}</b>
        <p>{$p['project_description_en']}</p>
    </div>";
}

$html .= "<hr>


<h3>LANGUAGES</h3>
<p>{$data['languages']}</p>

<hr>

<h3>CERTIFICATIONS</h3>
<p>{$data['certifications']}</p>

</div>
";


$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();

// حفظ الملف
file_put_contents($filePath, $dompdf->output());

ob_clean();
header('Content-Type: application/json');


echo json_encode(["status" => "success"]);
exit();