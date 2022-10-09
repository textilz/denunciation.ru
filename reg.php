<?php
    require_once 'action/main.php';
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<?php include 'content/header.php'?>
    <section class="login">
        <h1>Регистрация</h1>
        <form action="action/reg.php" method="post">
            <input type="text" name="name" placeholder="Имя">
            <input type="email" name="email" placeholder="Почта">
            <input type="text" name="login" placeholder="Логин">
            <input type="password" name="password" placeholder="Пароль">
            <input type="password" name="password_too" placeholder="Повторите пароль">
            <button type="submit">
                <svg>
                    <defs>
                        <mask id="mask">
                            <rect width="100%" height="100%" fill="white"></rect>
                            <text x="50%" y="65%" text-anchor="middle" fill="black">Войти</text>
                        </mask>
                    </defs>
                    <rect class="btnBg" width="100%" height="100%" mask="url(#mask)"></rect>
                </svg>
            </button>
        </form>
    </section>
</body>
</html>