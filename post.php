<?php
require_once 'action/main.php';

$id_user = $_SESSION['id_user'];
$edit = false;

add_view($connect, $data_post['id_post'], $_SESSION['view_token']);

$data_post = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_post`, `id_service`, posts.`id_user`, `title`, `rating`, `text_post`, COUNT(views.id_view) AS 'view' FROM posts
LEFT JOIN views USING(id_post) WHERE id_post = " . $_GET['post']. " GROUP BY id_post"), MYSQLI_ASSOC);
$data_post = $data_post[0];
$comments = mysqli_fetch_all(mysqli_query($connect, 'SELECT * FROM comments WHERE id_post = '. $_GET['post'].' ORDER BY id_comment DESC'), MYSQLI_ASSOC);
if ($data_post['id_user'] == $id_user) {
    $edit = true;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/post.css">
    <script src="js/fixed-item.js" defer></script>
    <script src="js/post.js" defer></script>
    <script src="js/jquery-3.3.1.min.js" defer></script>
    <script src="js/edit-post.js" defer></script>
    <script src="js/rate.js" defer></script>
    <script src="js/vote.js" defer></script>
</head>

<body>
<?php include 'content/header.php'?>
    <section class="post-container">
        <div class="service fixed">
            <div class="service-block fixed-block">
                <div class="service-container">
                    <div class="service-block__image">
                        <?php
                        $image = get_image($connect, 'services', 'id_services', $data_post['id_service']);
                        if (!empty($image[0])) {
                            echo '<img class="image-database" src="data:image/png;base64,'.base64_encode($image[0]).'">';
                        }
                        ?>
                    </div>

                    <a href="all-reviews.php?service=<?=$data_post['id_service']?>"><h2><?=get_service_name($connect, $data_post['id_service'])?></h2></a>
                </div>
                <?php if ($edit): ?>
                <div class="service-block__edit-panel">
                    <form action="action/delete-post.php" method="post">
                        <div class="service-block__edit-panel_edit">Редактировать<br>пост</div>
                        <input type="hidden" name="id_post" value="<?=$data_post['id_post']?>">
                        <button type="submit" class="service-block__edit-panel_delete">Удалить<br>пост</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="post-block">
            <form class="post" action="action/edit-post.php" method="post">
                <input type="hidden" name="id_post" class="id_post" value="<?=$data_post['id_post']?>">
                <div class="author-block">
                    <div class="author-block__image">
                        <?php
                        $image = get_avatar($connect, 'users', 'id_user', $data_post['id_user']);
                        if (!empty($image[0])) {
                            echo '<img class="image-database" src="data:image/png;base64,'.base64_encode($image[0]).'">';
                        }
                        ?>
                    </div>
                    <a class="author-block__name" href="profile.php?id_user=<?=$data_post['id_user']?>"><?=get_author($connect, $data_post['id_user'])?></a>
                </div>
                <div class="post-block__theme-rate">
                    <div class="post-block__theme edit-place-post"><?=$data_post['title']?></div>
                    <input class="post-block__theme input-place-post input-place-post_theme hide" type="text" name="theme" value="<?=$data_post['title']?>">
                    <div class="post-block__rate edit-place-post">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $data_post['rating']) {
                                echo '<div class="rate__user rate_active"></div>';
                            } else {
                                echo '<div class="rate__user"></div>';
                            }
                        }
                        ?>
                    </div>
                    <input type="hidden" class="rate_input" name="rate" value="<?=$data_post['rating']?>">
                    <div class="rates input-place-post hide">
                        <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $data_post['rating']) {
                                    echo '<div class="rate rate_active" data-rate="'.$i.'"></div>';
                                } else {
                                    echo '<div class="rate" data-rate="'.$i.'"></div>';
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="post-block__text edit-place-post">
                    <?=nl2br($data_post['text_post'])?>
                </div>
                <textarea name="text_post" class="post-block__text input-place-post input-place-post_text hide"><?=$data_post['text_post']?></textarea>
                <div class="post-block__footer">
                    <div class="view-vote">
                        <div class="view">
                            <div class="view__icon"></div>
                            <div class="view__sum"><?=$data_post['view']?></div>
                        </div>

                        <div class="vote">
                            <div class="vote__minus voting">-</div>
                            <div class="vote__sum">0</div>
                            <div class="vote__plus voting">+</div>
                        </div>
                    </div>
                    <button type="submit" class="input-place-post hide update-post">Обновить</button>
                </div>
            </form>
            <div class="comments">
                <h2>Написать комментарий:</h2>
                <form action="action/add-comment.php" method="post">
                    <input type="hidden" name="post" value="<?=$data_post['id_post']?>">
                    <textarea name="comment" placeholder="Комментарий..."></textarea>
                    <div class="button-container">
                        <button type="submit" class="btn ">Отправить</button>
                    </div>
                </form>
                <?php if ($comments != null): ?>
                <h2>Комментарии:</h2>
                <div class="comments-container">
                    <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <form action="action/edit-comment.php" method="post">
                            <div class="comment__author_image">
                                <?php
                                $image = get_avatar($connect, 'users', 'id_user', $comment['id_user']);
                                if (!empty($image[0])) {
                                    echo '<img class="image-database" src="data:image/png;base64,'.base64_encode($image[0]).'">';
                                }
                                ?>
                            </div>
                            <div class="comment__content">
                                <a class="comment__author" href="profile.php?id_user=<?=$comment['id_user']?>"><?=get_author($connect, $comment['id_user'])?></a>
                                <input type="hidden" name="author" value="<?=$comment['id_user']?>">
                                <input type="hidden" name="id_comment" value="<?=$comment['id_comment']?>">
                                <input type="hidden" name="id_post" value="<?=$comment['id_post']?>">
                                <div class="comment__text edit-place"><?=$comment['text_comment']?></div>
                                <textarea type="text" class="comment__text input-place input-place_text hide" name="comment-text"><?=$comment['text_comment']?></textarea>
                            </div>
                            <?php if($id_user == $comment['id_user'] || $id_user == $data_post['id_user']): ?>
                            <div class="admin-panel edit-place">
                                <input type="submit" name="delete" class="admin-panel__delete" value="Удалить">
                                <?php if($id_user == $comment['id_user']): ?>
                                <div class="admin-panel__edit edit">Редактировать</div>
                                <?php endif; ?>
                            </div>
                            <div class="edit-panel input-place hide">
                                <div class="edit-panel_cancel button_cancel">Отменить</div>
                                <button type="submit" class="edit-panel_submit">Применить</button>
                            </div>
                            <?php endif; ?>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>

</html>