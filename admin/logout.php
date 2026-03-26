<?php
session_start();

// حذف كل بيانات الجلسة
$_SESSION = [];

// تدمير الجلسة
session_destroy();

// إعادة التوجيه لصفحة تسجيل الدخول
header("Location: login.php");
exit();