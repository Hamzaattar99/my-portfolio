<?php
session_start();
require_once "../includes/db.php";

if($_SESSION['role'] !== 'superAdmin'){
    http_response_code(403);
    exit("Access denied");
}

$id = $_POST['id'] ?? '';
$username = trim($_POST['username']);
$password = $_POST['password'];
$role = $_POST['role'];
$status = $_POST['status'];

// تحقق
if(empty($username)){
    exit("Username required");
}

if(empty($id)){
    // إضافة
    if(empty($password)) exit("Password required");

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admin (username,password,role,is_active) VALUES (?,?,?,?)");
    $stmt->bind_param("sssi",$username,$hash,$role,$status);
    $stmt->execute();

} else {
    // تعديل (بدون تغيير كلمة المرور)
    $stmt = $conn->prepare("UPDATE admin SET username=?, role=?, is_active=? WHERE user_id=?");
    $stmt->bind_param("ssii",$username,$role,$status,$id);
    $stmt->execute();
}