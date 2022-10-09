<?php
require_once 'action/main.php';

$id_user = $_SESSION['id_user'];

$services = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM services ORDER BY id_services DESC LIMIT 8"), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.3.1.min.js" defer></script>
    <script src="js/choose-service.js" defer></script>
</head>

<body>
<?php include 'content/header.php'?>
    <section class="search">
        <form action="action/find-service.php" method="post">
            <input type="text" class="founded-services_input" name="service" placeholder="Найти отзыв..." autocomplete="off">
            <button type="submit">
                <svg>
                    <defs>
                        <mask id="mask">
                            <rect width="100%" height="100%" fill="white"></rect>
                            <text x="50%" y="65%" text-anchor="middle" fill="black">Искать</text>
                        </mask>
                    </defs>
                    <rect class="btnBg" width="100%" height="100%" mask="url(#mask)"></rect>
                </svg>
            </button>
        </form>
        <div class="founded-services">
        </div>
    </section>

    <section class="pop-reviews">
        <h1>Отзывы на популярные ресурсы</h1>
        <div class="pop-reviews__items">
            <?php foreach ($services as $service): ?>
            <div class="reviews-item">
                <div class="reviews-item__image">
                    <?php
                    $image = get_image($connect, 'services', 'id_services', $service['id_services']);
                    if (!empty($image[0])) {
                        echo '<img class="image-database" src="data:image/png;base64,'.base64_encode($image[0]).'">';
                    }
                    ?>
                </div>
                <a class="reviews-item__name"><?=$service['name']?></a>
                <div class="reivews-item__stars rates">
                    <?php
                    if (get_service_rating($connect, $service['id_services']) > 0) {
                        for ($i = 1; $i <= 5; $i++) {
                        if ($i <= get_service_rating($connect, $service['id_services'])) {
                            echo '<div class="rate__user rate__user_index rate_active"></div>';
                        } else {
                            echo '<div class="rate__user rate__user_index"></div>';
                        }
                    }
                    }

                    ?>
                </div>
                <div class="reviews-item__buttons">
                    <div class="reviews-item__see-review"><a href="all-reviews.php?service=<?=$service['id_services']?>">Посмотреть</a></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <a href="all-reviews.php" class="see-all">Посмотреть все</a>
    </section>
    <?php include('content/footer.php') ?>
</body>

</html>