<?php

require_once 'config/database.php';
require_once 'includes/auth.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {

    $movieId = (int)($_POST['movie_id'] ?? 0);

    $stmt = $pdo->prepare("
        DELETE FROM favorites
        WHERE user_id = ? AND movie_id = ?
    ");

    $stmt->execute([$_SESSION['user_id'], $movieId]);

    header('Location: favorites.php');
    exit;
}


$stmt = $pdo->prepare("
    SELECT movies.*
    FROM favorites
    JOIN movies ON favorites.movie_id = movies.id
    WHERE favorites.user_id = ?
    ORDER BY movies.title
");

$stmt->execute([$_SESSION['user_id']]);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';

?>

<section class="section">
    <div class="container">

        <h1 class="section-title">My Favorites</h1>

        <div class="movie-grid">

            <?php if (count($movies) > 0): ?>

                <?php foreach ($movies as $movie): ?>

                    <div class="movie-card">

                        <?php if (!empty($movie['poster'])): ?>

                            <img src="<?= htmlspecialchars($movie['poster']) ?>"
                                 alt="<?= htmlspecialchars($movie['title']) ?>">

                        <?php else: ?>

                            <div class="movie-placeholder">
                                FilmWatch
                            </div>

                        <?php endif; ?>

                        <div class="movie-info">

                            <h3><?= htmlspecialchars($movie['title']) ?></h3>

                            <p>
                                <?= htmlspecialchars($movie['genre']) ?>
                                ·
                                <?= htmlspecialchars((string)$movie['year']) ?>
                            </p>

                            <a href="movie.php?id=<?= (int)$movie['id'] ?>"
                               class="btn">View details</a>

                            <form method="POST" action="favorites.php">
                                <input type="hidden" name="movie_id"
                                       value="<?= (int)$movie['id'] ?>">

                                <button type="submit" name="remove"
                                        class="btn remove-btn">
                                    Remove
                                </button>
                            </form>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>
                <p>You haven't added any favorite movies yet.</p>
            <?php endif; ?>

        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
