<?php
session_start();
// التحقق من أن المستخدم مسجل دخول، وإلا يرجعه لصفحة Basir.php
if (!isset($_SESSION['user_id'])) {
    header("Location: Basir.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>بصير - الصفحة الرئيسية</title>
    <link rel="stylesheet" href="style3.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div class="logo-area">
            <img src="logo3.jpg" alt="بصير">
        </div>
        <div class="nav-links">
            <a href="home.php">الرئيسية</a>
            <a href="reports.php">البلاغات</a>
            <a href="profile.php">الملف الشخصي</a>
        </div>
    </nav>

    <div class="container">
        <div class="hero-section">
            <h1>مرحباً بك في نظام بصير</h1>
            <p>منصة تقنية متطورة لتعزيز السلامة المرورية وسرعة الاستجابة للحوادث من خلال الربط المباشر مع الجهات المختصة.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="card-icon">📍</div>
                <h3>تحديد المواقع</h3>
                <p>تحديد دقيق لموقع الحادث فور وقوعه باستخدام تقنيات الـ GPS المتقدمة لضمان وصول الإسعاف في أسرع وقت.</p>
            </div>

            <div class="feature-card">
                <div class="card-icon">⚡</div>
                <h3>رصد فوري</h3>
                <p>استخدام الحساسات الذكية في تطبيق Flutter لرصد الارتطامات المفاجئة وإرسال بلاغ آلي دون تدخل بشري.</p>
            </div>

            <div class="feature-card">
                <div class="card-icon">📊</div>
                <h3>إدارة البيانات</h3>
                <p>لوحة تحكم متكاملة تتيح للمسؤولين متابعة حالات البلاغات وتحديثها لحظة بلحظة لضمان جودة الاستجابة.</p>
            </div>
        </div>
    </div>

</body>
</html>