<?php

session_start();


$connect = mysqli_connect('localhost', 'root', 'root', 'reviews', 8889);

function create_view_token() {

    $view_token = random_bytes(100);
    $_SESSION['view_token'] = bin2hex($view_token);

}

if (empty($_SESSION['view_token']) ) {
    create_view_token();
}

function get_image($connect, $table, $key, $value) {
    $select = "SELECT `image` FROM $table WHERE `$key` = $value";
    $query_image = mysqli_query($connect, $select);

    $image = [];
    while($row = mysqli_fetch_array($query_image, MYSQLI_ASSOC)) {
        $image[] = $row['image'];
    }
    return $image;
}

function get_avatar($connect, $table, $key, $value) {
    $select = "SELECT `avatar` FROM $table WHERE `$key` = $value";
    $query_image = mysqli_query($connect, $select);

    $image = [];
    while($row = mysqli_fetch_array($query_image, MYSQLI_ASSOC)) {
        $image[] = $row['avatar'];
    }
    return $image;
}

function get_author($connect, $id) {
    $select = "SELECT * FROM users WHERE id_user = $id";
    $author_data = mysqli_fetch_all(mysqli_query($connect, $select), MYSQLI_ASSOC);
    return $author_data[0]['name'];
}

function get_service_name ($connect, $id) {
    $select = "SELECT `name` FROM services WHERE id_services = $id";
    $data = mysqli_fetch_all(mysqli_query($connect, $select), MYSQLI_ASSOC);
    return $data[0]['name'];
}

function get_service_rating($connect, $id) {
    $select = "SELECT AVG(`rating`) AS 'avg' FROM posts INNER JOIN services ON posts.id_service = services.id_services WHERE `id_service` = $id;";
    $data = mysqli_fetch_all(mysqli_query($connect, $select), MYSQLI_ASSOC);
    return $data[0]['avg'];
}

function get_votes($connect, $id) {
    $select = "SELECT SUM(`vote`) as 'votes_sum' FROM `votes` WHERE `id_post` = $id";
    $data = mysqli_fetch_all(mysqli_query($connect, $select), MYSQLI_ASSOC);
    if ($data[0]['votes_sum'] != null) {
        return $data[0]['votes_sum'];
    } else {
        return 0;
    }
}

function get_class_votes($connect, $id) {
    $votes = get_votes($connect, $id);
    if ($votes > 0) {
        return 'vote__sum_more';
    } elseif ($votes < 0) {
        return 'vote__sum_less';
    } else {
        return null;
    }
}

function check_view($connect, $id_post, $view_token) {
    $id_user = $_SESSION['id_user'];
    if ($id_user != null) {
        $data = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM views WHERE `id_post` = $id_post AND `id_user` = $id_user"), MYSQLI_ASSOC);
    } else {
        $data = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM views WHERE `id_post` = $id_post AND `view_token` = '$view_token'"), MYSQLI_ASSOC);
    }

   if ($data == null) {
       return false;
   } else {
       return true;
   }

}


function add_view($connect, $id_post, $view_token) {
    $id_user = $_SESSION['id_user'];
    if ($id_user != null) {
        // тут для авторизированных
        if (!check_view($connect, $id_post, $view_token)) {
            // если пользователь еще не смотрел
            mysqli_query($connect, "INSERT INTO views (`id_post`, `id_user`) VALUES ($id_post, $id_user)");
        }
    } else {
        if (!check_view($connect, $id_post, $view_token)) {
            // если пользователь еще не смотрел
            mysqli_query($connect, "INSERT INTO views (`id_post`, `view_token`) VALUES ($id_post, '$view_token')");
        }
    }
}

