<?php
session_start();
session_unset(); // مسح كل بيانات الجلسة
session_destroy(); // تدمير الجلسة تماماً
header("Location: Basir.php"); // العودة لصفحة تسجيل الدخول
exit();
?>