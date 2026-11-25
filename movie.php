<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$id]);

$movie = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$movie) {
    http_response_code(404);
    exit('Movie not found.');
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    requireLogin();

    $stmt = $pdo->prepare("
        INSERT INTO favorites (user_id, movie_id)
        VALUES (?, ?)
        ON CONFLICT (user_id, movie_id) DO NOTHING
    ");

    $stmt->execute([$_SESSION['user_id'], $id]);

    $message = 'Movie added to favorites!';
}

include 'includes/header.php';

?>

<section class="section">
    <div class="container">

        <div class="movie-details">

            <?php if (!empty($movie['poster'])): ?>

                <img class="details-poster"
                     src="<?= htmlspecialchars($movie['poster']) ?>"
                     alt="<?= htmlspecialchars($movie['title']) ?>">

            <?php else: ?>

                <div class="details-poster movie-placeholder">
                    FilmWatch
                </div>

            <?php endif; ?>

            <div class="details-info">

                <h1><?= htmlspecialchars($movie['title']) ?></h1>

                <p>
                    <?= htmlspecialchars((string)$movie['year']) ?>
                    ·
                    <?= htmlspecialchars($movie['genre']) ?>
                </p>

                <div class="rating">
                    ★ <?= htmlspecialchars((string)$movie['rating']) ?>/10
                </div>

                <p class="movie-description">
                    <?= htmlspecialchars($movie['description']) ?>
                </p>

                <?php if ($message): ?>
                    <p class="success-message"><?= $message ?></p>
                <?php endif; ?>

                <?php if (isLoggedIn()): ?>

                    <form method="POST">
                        <button type="submit" class="btn">
                            Add to Favorites
                        </button>
                    </form>

                <?php else: ?>

                    <a href="login.php" class="btn">
                        Login to save
                    </a>

                <?php endif; ?>

                <?php if (!empty($movie['trailer'])): ?>

                    <a href="<?= htmlspecialchars($movie['trailer']) ?>"
                       target="_blank" rel="noopener noreferrer"
                       class="btn">Watch Trailer</a>

                <?php endif; ?>

            </div>

        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
