<?php
session_start();
require_once "../includes/db.php";

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if($action === "change_password"){
    $old = $_POST['old'];
    $new = $_POST['new'];

    $res = $conn->query("SELECT * FROM admin LIMIT 1");
    $user = $res->fetch_assoc();

    if(!password_verify($old, $user['password'])){
        echo "Wrong current password";
        exit();
    }

    $newHash = password_hash($new, PASSWORD_DEFAULT);
    $conn->query("UPDATE admin SET password='$newHash' WHERE user_id=".$user['user_id']);

    echo "Password updated";
}

elseif($action === "add_admin"){
    $user = $_POST['user'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admin(username,password) VALUES(?,?)");
    $stmt->bind_param("ss",$user,$pass);
    $stmt->execute();

    echo "Admin added";
}

elseif($action === "save_links"){
    foreach($_POST as $key=>$val){
        if($key !== "action"){
            $stmt = $conn->prepare("UPDATE settings SET value=? WHERE name=?");
            $stmt->bind_param("ss",$val,$key);
            $stmt->execute();
        }
    }
    echo "Saved successfully";
}

elseif($action === "backup"){
    header('Content-Type: application/sql');
    header('Content-Disposition: attachment; filename=backup.sql');

    $tables = $conn->query("SHOW TABLES");

    while($table = $tables->fetch_array()){
        $t = $table[0];
        $res = $conn->query("SELECT * FROM $t");

        while($row = $res->fetch_assoc()){
            echo "INSERT INTO $t VALUES('".implode("','",$row)."');\n";
        }
    }
}