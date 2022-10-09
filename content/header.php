<div class="background"></div>
<header>
    <nav>
        <a href="all-reviews.php">Отзывы</a>
    </nav>
    <a href="index.php">
        <h1 class="logo">Донос.ru</h1>
    </a>
    <div class="profile">
        <?php if ($_SESSION['id_user'] == null): ?>
            <a href="login.php">Войти</a>
        <?php else: ?>
            <a href="profile.php">Профиль</a>
            <a href="action/logout.php">Выйти</a>
        <?php endif; ?>
    </div>
</header>