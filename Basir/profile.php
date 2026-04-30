<?php
session_start();
include 'db_config.php';

// 1. التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: Basir.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// 2. معالجة تحديث البيانات عند ضغط "حفظ"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $update_stmt = $conn->prepare("UPDATE Users SET FullName = ?, PhoneNumber = ?, Email = ? WHERE UserID = ?");
    if ($update_stmt->execute([$fullname, $phone, $email, $user_id])) {
        $message = "تم تحديث البيانات بنجاح!";
    } else {
        $message = "حدث خطأ أثناء التحديث.";
    }
}

// 3. جلب بيانات المستخدم الحالية
$stmt = $conn->prepare("SELECT * FROM Users WHERE UserID = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>بصير - الملف الشخصي</title>
    <link rel="stylesheet" href="style3.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f4f9fb; margin: 0; display: block; }
        .profile-container { max-width: 500px; margin: 40px auto; padding: 0 20px; }
        .profile-card { 
            background: white; border-radius: 20px; padding: 30px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-top: 6px solid #2c7da0; text-align: center;
        }
        .profile-avatar { width: 80px; height: 80px; background: #e1f1f6; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 15px; font-size: 35px; color: #2c7da0; }
        
        .info-group { text-align: right; margin-bottom: 15px; }
        .info-group label { display: block; font-size: 13px; color: #999; margin-bottom: 5px; }
        .info-group input { 
            width: 100%; padding: 10px; border: 1px solid #eee; border-radius: 8px; 
            background: #f9f9f9; color: #333; font-size: 15px; outline: none;
        }
        .info-group input:not([readonly]) { background: #fff; border-color: #2c7da0; }

        .btn-action { width: 100%; padding: 12px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer; transition: 0.3s; margin-top: 10px; font-size: 15px; }
        .btn-edit { background: #2c7da0; color: white; }
        .btn-save { background: #2ecc71; color: white; display: none; }
        .btn-logout-card { background: #fff; color: #e63946; border: 1px solid #e63946; text-decoration: none; display: block; margin-top: 15px; padding: 10px; font-size: 14px; border-radius: 8px; }
        .btn-logout-card:hover { background: #fdf2f2; }
        
        .alert { padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 13px; background: #d4edda; color: #155724; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo-area"><img src="logo3.jpg" alt="بصير" style="height: 50px;"></div>
        <div class="nav-links">
            <a href="home.php">الرئيسية</a>
            <a href="reports.php">البلاغات</a>
            <a href="profile.php" style="color: #2c7da0;">الملف الشخصي</a>
        </div>
    </nav>

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-avatar">👤</div>
            
            <?php if($message) echo "<div class='alert'>$message</div>"; ?>

            <form id="profileForm" method="POST">
                <div class="info-group">
                    <label>الاسم الكامل</label>
                    <input type="text" name="fullname" id="fname" value="<?php echo $user['FullName']; ?>" readonly>
                </div>
                <div class="info-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" id="femail" value="<?php echo $user['Email']; ?>" readonly>
                </div>
                <div class="info-group">
                    <label>رقم الجوال</label>
                    <input type="text" name="phone" id="fphone" value="<?php echo $user['PhoneNumber']; ?>" readonly>
                </div>

                <button type="button" id="editBtn" class="btn-action btn-edit" onclick="enableEditing()">تعديل البيانات</button>
                <button type="submit" name="update_profile" id="saveBtn" class="btn-action btn-save">حفظ التغييرات</button>
            </form>

            <a href="logout.php" class="btn-logout-card">تسجيل الخروج من الحساب</a>
        </div>
    </div>

    <script>
        function enableEditing() {
            // تحويل الحقول لتكون قابلة للتعديل
            document.getElementById('fname').readOnly = false;
            document.getElementById('femail').readOnly = false;
            document.getElementById('fphone').readOnly = false;
            
            // إخفاء زر التعديل وإظهار زر الحفظ
            document.getElementById('editBtn').style.display = 'none';
            document.getElementById('saveBtn').style.display = 'block';
            
            // تركيز على أول حقل
            document.getElementById('fname').focus();
        }
    </script>

</body>
</html>