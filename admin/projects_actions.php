<?php
session_start();
require_once "../includes/db.php";

// تأكد من كون الطلب POST أو GET حسب العملية
$action = $_GET['action'] ?? '';

function sanitize($data){
    return htmlspecialchars(trim($data), ENT_QUOTES);
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // إضافة أو تعديل المشروع
    $id = $_POST['id'] ?? '';
    $title_en = sanitize($_POST['title_en'] ?? '');
    $title_ar = sanitize($_POST['title_ar'] ?? '');
    $description_en = sanitize($_POST['description_en'] ?? '');
    $description_ar = sanitize($_POST['description_ar'] ?? '');
    $technologies = sanitize($_POST['technologies'] ?? '');
    $github_link = sanitize($_POST['github_link'] ?? '');
    $live_link = sanitize($_POST['live_link'] ?? '');
    $image_name = '';

    // التحقق من الحقول المطلوبة
    if(empty($title_en) || empty($title_ar) || empty($description_en) || empty($description_ar) || empty($technologies) || empty($github_link)){
        http_response_code(400);
        echo "Please fill all required fields.";
        exit();
    }

    // معالجة الصورة إذا تم رفعها
    if(isset($_FILES['project_image']) && $_FILES['project_image']['error'] === 0){
        $ext = pathinfo($_FILES['project_image']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid('project_').'.'.$ext;
        move_uploaded_file($_FILES['project_image']['tmp_name'], "../assets/images/$image_name");
    } elseif(!empty($_POST['existing_image'])){
        $image_name = $_POST['existing_image'];
    }

    if(empty($id)){
        // إضافة مشروع جديد
        $stmt = $conn->prepare("INSERT INTO projects 
            (project_title_en, project_title_ar, project_description_en, project_description_ar, project_image, project_technologies, github_link, live_link, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssssss", $title_en, $title_ar, $description_en, $description_ar, $image_name, $technologies, $github_link, $live_link);
        $stmt->execute();
        echo "Project added successfully.";
    } else {
        // تعديل مشروع موجود
        if(!empty($image_name)){
            $stmt = $conn->prepare("UPDATE projects SET 
                project_title_en=?, project_title_ar=?, project_description_en=?, project_description_ar=?, project_image=?, project_technologies=?, github_link=?, live_link=? 
                WHERE project_id=?");
            $stmt->bind_param("ssssssssi", $title_en, $title_ar, $description_en, $description_ar, $image_name, $technologies, $github_link, $live_link, $id);
        } else {
            $stmt = $conn->prepare("UPDATE projects SET 
                project_title_en=?, project_title_ar=?, project_description_en=?, project_description_ar=?, project_technologies=?, github_link=?, live_link=? 
                WHERE project_id=?");
            $stmt->bind_param("sssssssi", $title_en, $title_ar, $description_en, $description_ar, $technologies, $github_link, $live_link, $id);
        }
        $stmt->execute();
        echo "Project updated successfully.";
    }

} elseif($action === 'get' && isset($_GET['id'])){
    // جلب بيانات مشروع واحد
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM projects WHERE project_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_assoc());

} elseif($action === 'search' && isset($_GET['query'])){
    // البحث اللحظي
    $query = "%".sanitize($_GET['query'])."%";
    $stmt = $conn->prepare("SELECT * FROM projects WHERE project_title_en LIKE ? OR project_title_ar LIKE ? ORDER BY created_at DESC");
    $stmt->bind_param("ss", $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()){
        $image = !empty($row['project_image']) ? '../assets/images/'.$row['project_image'] : 'https://via.placeholder.com/150';
        echo '
        <div class="col-12 col-md-6 col-lg-4">
            <div class="project-card p-3 rounded bg-white bg-opacity-10 text-white d-flex flex-column align-items-center">
                <img src="'.$image.'" class="project-img mb-2" alt="Project Image">
                <h5 class="text-center mb-1">'.$row['project_title_en'].'</h5>
                <h6 class="text-center text-secondary mb-2">'.$row['project_title_ar'].'</h6>
                <div class="d-flex justify-content-center gap-2 mb-2">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailsModal" onclick="viewProject('.$row['project_id'].')">View</button>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#projectModal" 
                        onclick="editProject('.$row['project_id'].', \''.addslashes($row['project_title_en']).'\', \''.addslashes($row['project_title_ar']).'\', \''.addslashes($row['project_description_en']).'\', \''.addslashes($row['project_description_ar']).'\', \''.addslashes($row['project_technologies']).'\', \''.addslashes($row['github_link']).'\', \''.addslashes($row['live_link']).'\', \''.addslashes($row['project_image']).'\')">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteProject('.$row['project_id'].')">Delete</button>
                </div>
            </div>
        </div>
        ';
    }
}
?>