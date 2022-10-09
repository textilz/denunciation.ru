<?php

require_once 'main.php';

$login = trim($_POST['login']);
$password = md5(trim($_POST['password']));

$select = "SELECT * FROM users WHERE login = '$login'";
$data = mysqli_fetch_all(mysqli_query($connect, $select), MYSQLI_ASSOC);

if ($data[0]['password_user'] == $password) {
    $_SESSION['id_user'] = $data[0]['id_user'];
    header("Location: ../profile.php");
} else {
    header("Location: ../login.php?error=yes");
}