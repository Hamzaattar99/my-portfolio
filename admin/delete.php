<?php
require_once "../includes/db.php";

$id = intval($_POST['id']); // تأكد أن id عدد صحيح
$type = $_POST['type'] ?? '';

if($type === "skill"){
    $stmt = $conn->prepare("DELETE FROM skills WHERE skill_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "Skill deleted successfully.";

} elseif($type === "project"){
    // حذف صورة المشروع إذا موجودة
    $stmt = $conn->prepare("SELECT project_image FROM projects WHERE project_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    if(!empty($result['project_image']) && file_exists("../assets/images/".$result['project_image'])){
        unlink("../assets/images/".$result['project_image']);
    }

    $stmt = $conn->prepare("DELETE FROM projects WHERE project_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "Project deleted successfully.";

} elseif($type === "user"){
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "User deleted successfully.";

} elseif($type === "experience"){
    $stmt = $conn->prepare("DELETE FROM experience WHERE exp_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "Experience deleted successfully.";

} else {
    http_response_code(400);
    echo "Invalid type.";
}