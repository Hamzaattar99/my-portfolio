<?php

// ✅ تشغيل Session إذا لم تكن مفعلة
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// حماية الصفحة (مهم جدًا)
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}  

if(isset($_SESSION['last_activity']))
    {

        if(time() - $_SESSION['last_activity'] > 1800)
            {
                session_unset(); // wiping the session data .
                session_destroy(); // ending the session .
                header("Location: ../admin/login.php");
                exit();
            }


    }

    $_SESSION['last_activity'] = time();







?>