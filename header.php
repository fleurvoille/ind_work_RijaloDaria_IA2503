
<?php
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmWatch</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<header>
    <div class="container navbar">
        <a href="/index.php" class="logo">FilmWatch.</a>

        <nav class="nav-links">
            <a href="/index.php">Главная</a>
            <a href="/catalog.php">Фильмы</a>

            <?php if (isLoggedIn()): ?>
                <a href="/favorites.php">Избранное</a>
                <a href="/profile.php">
                    <?= htmlspecialchars($_SESSION['username']) ?>
                </a>
                <a href="/logout.php">Выйти</a>
            <?php else: ?>
                <a href="/login.php">Войти</a>
                <a href="/register.php">Регистрация</a>
            <?php endif; ?>

        </nav>
    </div>
</header>
