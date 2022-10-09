<?php
    require_once 'action/main.php';

    $id_user = $_SESSION['id_user'];

    $sort_service = '';

    if (!empty($_GET['service']) && !empty($_GET['rate'])) {
        $sort_service = 'WHERE id_service = ' . $_GET['service'] . ' AND rating = ' . $_GET['rate'];
    } elseif (!empty($_GET['service'])) {
        $sort_service = 'WHERE id_service = ' . $_GET['service'];
    } elseif (!empty($_GET['rate'])) {
        $sort_service = 'WHERE rating = ' . $_GET['rate'];
    }

    $sort = "ORDER BY id_post DESC";
    if ($_GET['sort'] == 'new') {
        $sort = "ORDER BY id_post DESC";
    } elseif ($_GET['sort'] == 'old') {
        $sort = "ORDER BY id_post ASC";
    } elseif ($_GET['sort'] == 'high') {
        $sort = "ORDER BY rating DESC";
    } elseif ($_GET['sort'] == 'low') {
        $sort = "ORDER BY rating ASC";
    }

    $posts = mysqli_fetch_all(mysqli_query($connect, "SELECT `id_post`, `id_service`, posts.`id_user`, `title`, `rating`, `text_post`, COUNT(views.id_view) AS 'view' FROM posts
LEFT JOIN views USING(id_post) $sort_service GROUP BY id_post $sort"), MYSQLI_ASSOC);
    $services = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM services"), MYSQLI_ASSOC);

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
    <script src="js/jquery-3.3.1.min.js" defer></script>
    <script src="js/fixed-item.js" defer></script>
    <script src="js/choose-service.js" defer></script>
    <script src="js/rate.js" defer></script>
    <script src="js/reset-all-reviews.js" defer></script>
</head>

<body>
<?php include 'content/header.php'?>
    <section class="all-reviews">
        <div class="filter fixed">
            <div class="filter-block fixed-block">
                <form action="" method="get">
                <h2>Фильтр</h2>
                <div class="filter-item">
                    <div class="filter-item__name">Оценка от:</div>
                    <input type="hidden" class="rate_input" name="rate" value="<?=$_GET['rate']?>">
                    <div class="rates">
                        <div class="rate" data-rate="1"></div>
                        <div class="rate" data-rate="2"></div>
                        <div class="rate" data-rate="3"></div>
                        <div class="rate" data-rate="4"></div>
                        <div class="rate" data-rate="5"></div>
                    </div>
                </div>
                <div class="filter-item">
                    <div class="filter-item__name">Сервис:</div>
                    <input type="hidden" class="service_sort" name="service" value="<?php if (!empty($_GET['service'])) { echo $_GET['service'];} ?>">
                    <input type="text" placeholder="Введите сервис" class="founded-services_input" value="<?php if (!empty($_GET['service'])) { echo get_service_name($connect, $_GET['service']);} ?>">
                    <div class="founded-services">
                    </div>
                </div>
                <div class="filter-item">
                    <div class="filter-item__name">Сортировка:</div>
                    <select name="sort" id="">
                        <option value="new" <?php if (empty($_GET['sort'] || $_GET['sort'] == 'new')) { echo selected; } ?>>Сначала новые</option>
                        <option value="old" <?php if ($_GET['sort'] == 'old') { echo selected; } ?>>Сначала старые</option>
                        <option value="high" <?php if ($_GET['sort'] == 'high') { echo selected; } ?>>Высокий рейтинг</option>
                        <option value="low" <?php if ($_GET['sort'] == 'low') { echo selected; } ?>>Низкий рейтинг</option>
                    </select>
                </div>
                <div class="button-container">
                <button type="submit" class="reset">Сбросить</button>
                <button type="submit">Применить</button>
                </div>
            </form>
            </div>
        </div>
        <div class="review-items">
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
                    <a class="review-item__name" href="all-reviews.php?service=<?=$post['id_service']?>"><?=get_service_name($connect, $post['id_service'])?></a>
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
        </div>
    </section>
</body>

</html>