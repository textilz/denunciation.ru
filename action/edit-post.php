<?php

require_once 'main.php';

$theme = trim($_POST['theme']);
$text = trim($_POST['text_post']);
$rate = $_POST['rate'];
$id_post = $_POST['id_post'];

mysqli_query($connect, "UPDATE posts SET `title` = '$theme', `text_post` = '$text', `rating` = '$rate' WHERE `id_post` = $id_post");

header("Location: ../post.php?post=$id_post");