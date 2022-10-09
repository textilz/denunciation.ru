<?php

require_once 'main.php';

$service = $_POST['service'];
$theme = $_POST['theme'];
$text = $_POST['text-review'];
$rate = $_POST['rate'];
$id_user = $_SESSION['id_user'];

if ($theme != '' && $text != '') {
    $insert = "INSERT INTO posts (`id_service`, `id_user`, `title`, `rating`, `text_post`) VALUES ('$service', '$id_user', '$theme', $rate, '$text')";
    mysqli_query($connect, $insert);
}



header("Location: ../profile.php");