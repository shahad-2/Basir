<?php
session_start();
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM Users WHERE Email = ? AND PasswordHash = ?");
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['user_name'] = $user['FullName'];
        header("Location: home.php");
        exit();
    } else {
        $error = "البريد الإلكتروني أو كلمة المرور غير صحيحة";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بصير - تسجيل الدخول</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* التنسيقات هنا لضمان عملها فوراً */
        :root {
            --main-blue: #2c7da0;
            --light-bg: #f0f7f9;
            --accent-blue: #014f86;
        }

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

        .login-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border-top: 6px solid var(--main-blue);
        }

        .logo-section img {
            width: 110px;
            margin-bottom: 15px;
        }

        .logo-section h1 {
            color: var(--accent-blue);
            font-size: 24px;
            margin: 0 0 10px 0;
        }

        .logo-section p {
            color: #777;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .input-group {
            text-align: right;
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fcfcfc;
            box-sizing: border-box;
            outline: none;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: var(--main-blue);
            box-shadow: 0 0 5px rgba(44, 125, 160, 0.2);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--main-blue);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: var(--accent-blue);
            transform: translateY(-2px);
        }

        .footer-links {
            margin-top: 25px;
            font-size: 13px;
            color: #666;
        }

        .footer-links a {
            color: var(--main-blue);
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-section">
            <img src="logo3.jpg" alt="لوجو بصير">
            <h1>نظام بصير</h1>
            <p>إدارة الاستجابة الفورية للحوادث</p>
        </div>

        <?php if(isset($error)) echo "<p style='color:#e63946; font-size:12px; margin-bottom:15px;'>$error</p>"; ?>

        <form action="Basir.php" method="POST">
            <div class="input-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" placeholder="example@mail.com" required>
            </div>

            <div class="input-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" placeholder="********" required>
            </div>

            <button type="submit" class="btn-login">تسجيل الدخول</button>
        </form>

        <div class="footer-links">
            ليس لديك حساب؟ <a href="register.php">إنشاء حساب جديد</a>
        </div>
    </div>

</body>
</html>