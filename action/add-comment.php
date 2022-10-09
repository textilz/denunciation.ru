<?php

require_once 'main.php';

$id_user = $_SESSION['id_user'];
$id_post = $_POST['post'];
$text = trim($_POST['comment']);

$insert = "INSERT INTO comments (`id_post`, `id_user`, `text_comment`) VALUES ($id_post, $id_user, '$text')";
mysqli_query($connect, $insert);

header("Location: ../post.php?post=$id_post");