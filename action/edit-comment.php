<?php

require_once 'main.php';

$id_post = $_POST['id_post'];
$id_comment = $_POST['id_comment'];
$delete = $_POST['delete'];
$text = trim($_POST['comment-text']);

if ($delete == 'Удалить') {
    mysqli_query($connect, "DELETE FROM comments WHERE `id_comment` = $id_comment");
} else {
    mysqli_query($connect, "UPDATE comments SET `text_comment` = '$text' WHERE `id_comment` = $id_comment");
}

header("Location: ../post.php?post=$id_post");