<?php
    require_once 'action/main.php';

    $id_user = $_SESSION['id_user'];
    $edit = false;

    if (empty($_GET['id_user'])) {
        if ($id_user == null) {
            header("Location: login.php");
        } else {
            $edit = true;
        }
    } else {
        if ($id_user == $_GET['id_user']) {
            $edit = true;
        } else {
            $id_user = $_GET['id_user'];
        }
    }

    $select = "SELECT * FROM users WHERE id_user = $id_user";
    $data = mysqli_fetch_all(mysqli_query($connect, $select), MYSQLI_ASSOC);
    $data = $data[0];


    $select = "SELECT `id_post`, `id_service`, posts.`id_user`, `title`, `rating`, `text_post`, COUNT(views.id_view) AS 'view' FROM posts
LEFT JOIN views USING(id_post) WHERE posts.id_user = $id_user GROUP BY id_post ORDER BY `id_post` DESC";
    $posts = mysqli_fetch_all(mysqli_query($connect, $select), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all-reviews.css">
    <link rel="stylesheet" href="css/profile.css">
    <script src="js/edit.js" defer></script>
    <script src="js/fixed-item.js" defer></script>
</head>
<body>
    <?php include 'content/header.php'?>
    <section class="profile-section">
        <div class="profile-view fixed">
            <div class="profile-view-block fixed-block">
                <form action="action/update-profile.php" method="post" enctype="multipart/form-data">
                    <h2 class="profile-view-block__login edit-place"><?=$data['login']?></h2>
                    <input type="text" name="login" class="input-place input-place_login hide" value="<?=$data['login']?>">
                    <div class="profile-view-block__image">
                        <?php
                        $image = get_avatar($connect, 'users', 'id_user', $id_user);
                        if (!empty($image[0])) {
                            echo '<img src="data:image/png;base64,'.base64_encode($image[0]).'">';
                        }
                        ?>
                        <div class="profile-view-block__image-change input-place input-place_image hide">
                            <label for="ava">
                                <span>Загрузить<br>изображение</span>
                            <input type="file" name="image" class="hide" id="ava">
                            </label>
                        </div>
                    </div>
                    <p class="profile-view-block__name edit-place"><?=$data['name']?></p>
                    <input type="text" name="username" class="hide input-place input-place_name" value="<?=$data['name']?>">
                    <p class="profile-view-block__email edit-place"><?=$data['email']?></p>
                    <input type="email" name="email" class="hide input-place input-place_email" value="<?=$data['email']?>">
                    <input type="password" name="password" class="hide input-place input-place_password" placeholder="Новый пароль">
                    <div class="buttons-container input-place hide">
                        <button type="submit" class="button button_submit">Применить</button>
                        <button type="submit" class="button button_cancel">Отменить</button>
                    </div>
                    <?php if ($edit) {
                        echo '<button class="edit edit-place">Редактировать профиль</button>';
                    } ?>
                </form>
                <?php
                    if ($_SESSION['id_user'] == $_GET['id_user'] || empty($_GET['id_user'])) {
                        echo '<a href="create-post.php" class="new-post-button">Написать новый пост</a>';
                    }
                ?>
            </div>
        </div>
        <div class="review-items">
            <?php if(!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
            <div class="review-item">
                <div class="review-item__service">
                    <div class="review-item__image">
                        <?php
                        $image = get_image($connect, 'services', 'id_services', $post['id_service']);
                        if (!empty($image[0])) {
                            echo '<img src="data:image/png;base64,'.base64_encode($image[0]).'">';
                        }
                        ?>
                    </div>
                    <div class="review-item__name"><?= get_service_name($connect, $post['id_service'])?></div>
                </div>
                <div class="review-item__preview">
                    <div class="review-item__name-rating">
                        <div class="review-item__theme"><?=$post['title']?></div>
                        <div class="review-item__user-rating">
                            <div class="rates_user">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $post['rating']) {
                                        echo '<div class="rate__user rate_active"></div>';
                                    } else {
                                        echo '<div class="rate__user"></div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="review-item__post-preview"><?=$post['text_post']?></div>

                    <div class="review-item__footer">
                        <div class="review-item__username">Автор: <a href="profile.php?id_user=<?=$post['id_user']?>"><?=get_author($connect, $post['id_user'])?></a></div>
                        <div class="view-vote">
                            <div class="view">
                                <div class="view__icon"></div>
                                <div class="view__sum"><?=$post['view']?></div>
                            </div>
                            <div class="vote">
                                <div class="vote__sum <?=get_class_votes($connect, $post['id_post'])?>"><?=get_votes($connect, $post['id_post'])?></div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="review-item__open">

                    <a href="post.php?post=<?=$post['id_post']?>">
                        <div class="review-item__open-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21.257 10.962C21.731 11.582 21.731 12.419 21.257 13.038C19.764 14.987 16.182 19 12 19C7.81801 19 4.23601 14.987 2.74301 13.038C2.51239 12.7411 2.38721 12.3759 2.38721 12C2.38721 11.6241 2.51239 11.2589 2.74301 10.962C4.23601 9.013 7.81801 5 12 5C16.182 5 19.764 9.013 21.257 10.962V10.962Z"
                                    stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                    stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </div>
                        <div class="review-item__open-text">
                            Читать полностью
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <h1>У вас еще нет постов</h1>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>