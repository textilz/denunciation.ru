<?php

require_once 'main.php';

$id_user = $_SESSION['id_user'];

if (!empty($_POST['username'])) {
    $name = $_POST['username'];
    mysqli_query($connect, "UPDATE users SET `name` = '$name' WHERE `id_user` = $id_user");
}

if (!empty($_FILES['image']['tmp_name'])) {
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    mysqli_query($connect, "UPDATE users SET `avatar` = '$image' WHERE `id_user` = $id_user");
}

if (!empty($_POST['login'])) {
    $login = $_POST['login'];
    mysqli_query($connect, "UPDATE users SET `login` = '$login' WHERE `id_user` = $id_user");
}

if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    mysqli_query($connect, "UPDATE users SET `email` = '$email' WHERE `id_user` = $id_user");
}

if (!empty($_POST['password'])) {
    $password = $_POST['password'];
    $password = md5($password);
    mysqli_query($connect, "UPDATE users SET `password_user` = '$password' WHERE `id_user` = $id_user");
}


header("Location: ../profile.php");