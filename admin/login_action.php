<?php
session_start();
require_once "../includes/db.php";
// echo password_hash("admin123", PASSWORD_DEFAULT);
header("Content-Type: application/json");

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

$flag = true;

if(empty($username) || empty($password)){
    echo json_encode(["success"=>false]);
    exit();
}

$stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()){

    if($row['is_active'] == 1)
        {

        if(password_verify($password, $row['password'])){
            $_SESSION['admin'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];
            

            $_SESSION['last_activity'] = time();

            try
            {
                $ip = getUserIP();
                $_SESSION['user_ip'] = $ip;
            }
            catch(Exception $ex)
            {
                $_SESSION['error_ip'] = "No ip address provided .";
                $_SESSION['error_ip_reason'] = $ex -> getMessage();
            }

            session_write_close();

            echo json_encode(["success"=>true]);
                $flag = false;
                exit();
            }

        }

        else
        {
            $_SESSION['is_active'] = $row['is_active'];
            echo json_encode([
                "success"=>false,
                "reason"=>"inactive"
            ]);
            
            $flag = false;
         }

         
}

if($flag == true) {

    
echo json_encode([
    "success"=>false,
    "reason"=>"invalid"
    
    ]);

}


function getUserIP()
{

    if(!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
    
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        }
    elseif(!empty($_SERVER['REMOTE_ADDR']))
        {
            return $_SERVER['REMOTE_ADDR'];
        }
    else{

        return "UNKNOWN";
    }

}