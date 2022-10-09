<?php

require_once 'main.php';

$id_post = $_POST['id_post'];

mysqli_query($connect, "DELETE FROM posts WHERE `id_post` = $id_post");
mysqli_query($connect, "DELETE FROM posts WHERE `id_post` = $id_post");

header("Location: ../all-reviews.php");
