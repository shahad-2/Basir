<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    try {
        $sql = "INSERT INTO Users (FullName, PhoneNumber, Email, PasswordHash) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$fullname, $phone, $email, $password])) {
            header("Location: Basir.php?success=1");
            exit();
        }
    } catch(PDOException $e) {
        $error = "عذراً، هذا البريد أو الرقم مسجل مسبقاً.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بصير - إنشاء حساب جديد</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* تنسيق مخصص لصفحة التسجيل فقط لضمان عدم خرابها */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #e0f2f7 0%, #ffffff 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border-top: 6px solid #2c7da0;
        }

        .logo-section img {
            width: 90px;
            margin-bottom: 10px;
        }

        .logo-section h1 {
            color: #014f86;
            font-size: 22px;
            margin-bottom: 5px;
        }

        .logo-section p {
            color: #777;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .input-group {
            text-align: right;
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            font-size: 13px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fcfcfc;
            box-sizing: border-box;
            outline: none;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #2c7da0;
            box-shadow: 0 0 5px rgba(44, 125, 160, 0.2);
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            background: #2c7da0;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            transition: 0.3s;
        }

        .btn-register:hover {
            background: #014f86;
            transform: translateY(-2px);
        }

        .footer-links {
            margin-top: 20px;
            font-size: 13px;
            color: #666;
        }

        .footer-links a {
            color: #2c7da0;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="logo-section">
            <img src="logo3.jpg" alt="لوجو بصير">
            <h1>إنشاء حساب جديد</h1>
            <p>انضم إلى مجتمع بصير للسلامة المرورية</p>
        </div>

        <?php if(isset($error)) echo "<p style='color:#e63946; font-size:11px; margin-bottom:10px;'>$error</p>"; ?>

        <form action="register.php" method="POST">
            <div class="input-group">
                <label>الاسم الكامل</label>
                <input type="text" name="fullname" placeholder="أدخل اسمك الثلاثي" required>
            </div>

            <div class="input-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" placeholder="example@mail.com" required>
            </div>

            <div class="input-group">
                <label>رقم الجوال</label>
                <input type="tel" name="phone" placeholder="05xxxxxxxx" required>
            </div>

            <div class="input-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" placeholder="********" required>
            </div>

            <button type="submit" class="btn-register">إتمام التسجيل</button>
        </form>

        <div class="footer-links">
            لديك حساب بالفعل؟ <a href="Basir.php">تسجيل الدخول</a>
        </div>
    </div>

</body>
</html>