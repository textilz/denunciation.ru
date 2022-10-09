<?php

require_once 'main.php';

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$login = trim($_POST['login']);
$password = md5(trim($_POST['password']));

$insert = "INSERT INTO users (`name`, `email`, `login`, `password_user`) VALUES ('$name', '$email', '$login', '$password')";
mysqli_query($connect, $insert);

$_SESSION['id_user'] = mysqli_insert_id($connect);

header('Location: ../profile.php');