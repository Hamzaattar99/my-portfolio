<?php
session_start();
require_once "../includes/db.php";
// echo password_hash("admin123", PASSWORD_DEFAULT);
header("Content-Type: application/json");

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if(empty($username) || empty($password)){
    echo json_encode(["success"=>false]);
    exit();
}

$stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()){

    if(password_verify($password, $row['password'])){
        $_SESSION['admin'] = $row['user_id'];

        echo json_encode(["success"=>true]);
        
        exit();
    }
}

echo json_encode(["success"=>false]);