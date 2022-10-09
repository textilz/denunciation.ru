<?php

require_once 'main.php';
$id_post = $_POST['post'];
$id_user = $_POST['id_user'];

$vote = mysqli_fetch_all(mysqli_query($connect, "SELECT `vote` FROM votes WHERE `id_post` = $id_post AND `id_user` = $id_user"), MYSQLI_ASSOC);
$vote = $vote[0];

echo json_encode($vote);
