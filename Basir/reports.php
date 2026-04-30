<?php
session_start();
include 'db_config.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: Basir.php");
    exit();
}

// جلب البلاغات من قاعدة البيانات وربطها بالمواقع والحالة
$query = "SELECT a.report_id, a.report_time, l.city, l.district, l.nearest_landmark, rs.status_name 
          FROM Accidents a
          LEFT JOIN Locations l ON a.address_id = l.location_id
          LEFT JOIN Report_status rs ON a.report_id = rs.report_id
          ORDER BY a.report_time DESC";

$stmt = $conn->prepare($query);
$stmt->execute();
$reports = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بصير - لوحة البلاغات</title>
    <link rel="stylesheet" href="style3.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* تنسيقات إضافية مخصصة لصفحة البلاغات لضمان مظهر الألوان الجديدة */
        body {
            background-color: #f4f9fb; /* لون خلفية سماوي فاتح جداً */
            margin: 0;
            display: block;
        }

        .reports-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-title {
            color: #014f86;
            margin-bottom: 30px;
            text-align: center;
            font-size: 26px;
        }

        .report-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-right: 6px solid #2c7da0; /* لون أزرق بصير */
            transition: transform 0.2s;
        }

        .report-card:hover {
            transform: scale(1.01);
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .report-id { font-weight: bold; color: #2c7da0; }
        .report-time { font-size: 13px; color: #888; }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-item { display: flex; flex-direction: column; }
        .info-label { font-size: 12px; color: #999; margin-bottom: 4px; }
        .info-value { font-size: 15px; color: #333; font-weight: 500; }

        .status-box {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #f9f9f9;
        }

        .status-tag {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            background: #e1f1f6;
            color: #2c7da0;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo-area">
            <img src="logo3.jpg" alt="بصير" style="height: 50px;">
        </div>
        <div class="nav-links">
            <a href="home.php">الرئيسية</a>
            <a href="reports.php" style="color: #2c7da0;">البلاغات</a>
            <a href="profile.php">الملف الشخصي</a>
        </div>
    </nav>

    <div class="reports-container">
        <h1 class="page-title">لوحة متابعة البلاغات الحية</h1>

        <?php if (empty($reports)): ?>
            <div style="text-align:center; padding:50px; background:white; border-radius:15px; color:#999;">
                <p>لا توجد بلاغات مسجلة حالياً.</p>
            </div>
        <?php else: ?>
            <?php foreach ($reports as $report): ?>
                <div class="report-card">
                    <div class="report-header">
                        <span class="report-id">رقم البلاغ: #<?php echo $report['report_id']; ?></span>
                        <span class="report-time"><?php echo date('Y/m/d - h:i A', strtotime($report['report_time'])); ?></span>
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">المدينة / الحي</span>
                            <span class="info-value"><?php echo $report['city'] . " - " . $report['district']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">أقرب معلم</span>
                            <span class="info-value"><?php echo $report['nearest_landmark']; ?></span>
                        </div>
                    </div>
                    <div class="status-box">
                        <span class="status-tag">
                            حالة البلاغ: <?php echo $report['status_name'] ?? 'تحت المراجعة'; ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>
</html>