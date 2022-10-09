<?php
    require_once 'action/main.php';

    $id_user = $_SESSION['id_user'];

    if ($id_user == null) {
        header("Location: login.php");
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
    <link rel="stylesheet" href="css/create-post.css">
    <script src="js/fixed-item.js" defer></script>
    <script src="js/edit.js" defer></script>
    <script src="js/jquery-3.3.1.min.js" defer></script>
    <script src="js/add-genre.js" defer></script>
    <script src="js/choose-service.js" defer></script>
    <script src="js/rate.js" defer></script>
</head>

<body>

<?php include 'content/header.php'?>

    <section class="create-post">
        <div class="choose-service fixed">
            <div class="choose-service-block fixed-block">
                <h2>Выберите сервис</h2>
                <form action="action/add-genre.php" method="post" class="add-service" enctype="multipart/form-data">
                    <div class="choose-service-block__image input-place input-place_image hide">
                        <div class="choose-service-block__image-change input-place input-place_image hide">
                            <label for="ava">
                                <span>Загрузить<br>изображение</span>
                                <input type="file" name="image" class="hide" id="ava">
                            </label>
                        </div>
                    </div>
                    <input type="text" name="service-name" class="input-place input-place_name hide"
                        placeholder="Название">
                    <input type="text" name="service-url" class="input-place input-place_url hide" placeholder="URL">
                    <div class="buttons-container input-place hide">
                        <button type="submit" class="button button_submit">Добавить</button>
                        <button class="button button_cancel">Отменить</button>
                    </div>
                </form>
                <div class="find-service edit-place">
                    <div class="find-service_image">
                        
                    </div>
                    <input type="text" placeholder="Введите сервис" class="founded-services_input">
                    <div class="founded-services">
                    </div>
                    <p class="edit">Моего сервиса нет</p>
                </div>
            </div>
        </div>
        <div>
            <form action="action/add-post.php" method="post" class="create-post-container">
                <input type="hidden" name="service" class="input-place_genre" value="">
                <input type="text" name="theme" placeholder="Заголовок">
                <textarea name="text-review" placeholder="Ваш отзыв..."></textarea>
                <input type="hidden" class="rate_input" name="rate" value="">
                <div class="button-container">
                    <div class="rates">
                            <div class="rate" data-rate="1"></div>
                            <div class="rate" data-rate="2"></div>
                            <div class="rate" data-rate="3"></div>
                            <div class="rate" data-rate="4"></div>
                            <div class="rate" data-rate="5"></div>
                        </div>
                    <button type="submit" class="button button_submit">Опубликовать</button>
                </div>
            </form>
        </div>
    </section>
</body>

</html>