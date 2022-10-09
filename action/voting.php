<?php

require_once 'main.php';
$id_post = $_GET['post'];
$data = $_POST['vote'];
$id_user = $_SESSION['id_user'];

function check_vote($connect, $query) {
    $check = mysqli_fetch_all(mysqli_query($connect, $query), MYSQLI_ASSOC);
    return $check[0];
}

if (check_vote($connect, "SELECT `id_vote` FROM votes WHERE `id_post` = $id_post AND `id_user` = $id_user") == null) {
    mysqli_query($connect, "INSERT INTO votes (`id_user`, `id_post`, `vote`) VALUES ($id_user, $id_post, '$data')");
} else {
    if (check_vote($connect, "SELECT `id_vote` FROM votes WHERE `id_post` = $id_post AND `id_user` = $id_user AND `vote` = $data") == null) {
        mysqli_query($connect, "UPDATE votes SET `vote` = $data WHERE `id_post` = $id_post AND `id_user` = $id_user");
    } else {
        mysqli_query($connect, "DELETE FROM votes WHERE `id_post` = $id_post AND `id_user` = $id_user");
    }
}



echo json_encode('yes');