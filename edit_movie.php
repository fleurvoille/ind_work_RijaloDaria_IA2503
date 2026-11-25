<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

requireAdmin();

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$id]);
$movie = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$movie) {
    exit('Movie not found');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $year = (int)($_POST['year'] ?? 0);
    $genre = trim($_POST['genre'] ?? '');
    $rating = (float)($_POST['rating'] ?? 0);
    $poster = trim($_POST['poster'] ?? '');
    $trailer = trim($_POST['trailer'] ?? '');

    if ($title === '' || $description === '' || $genre === '' ||
        $year < 1888 || $year > 2100 || $rating < 0 || $rating > 10) {
        $error = 'Please fill in all required fields correctly.';
    } else {
        $stmt = $pdo->prepare("
            UPDATE movies
            SET title = ?, description = ?, year = ?, genre = ?,
                rating = ?, poster = ?, trailer = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $title,
            $description,
            $year,
            $genre,
            $rating,
            $poster,
            $trailer,
            $id
        ]);

        header('Location: index.php');
        exit;
    }
}

include '../includes/header.php';
?>

<section class="section">
    <div class="container">
        <h1 class="section-title">Edit Movie</h1>

        <div class="form-container">

            <?php if ($error !== ''): ?>
                <p class="error-message">
                    <?= htmlspecialchars($error) ?>
                </p>
            <?php endif; ?>

            <form method="POST">

                <div class="form-group">
                    <label>Movie Title</label>
                    <input type="text" name="title"
                           value="<?= htmlspecialchars($movie['title']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" required><?= htmlspecialchars($movie['description']) ?></textarea>
                </div>

                <div class="form-group">
                    <label>Year</label>
                    <input type="number" name="year"
                           value="<?= (int)$movie['year'] ?>" min="1888" max="2100" required>
                </div>

                <div class="form-group">
                    <label>Genre</label>
                    <input type="text" name="genre"
                           value="<?= htmlspecialchars($movie['genre']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Rating</label>
                    <input type="number" name="rating"
                           value="<?= htmlspecialchars((string)$movie['rating']) ?>"
                           min="0" max="10" step="0.1" required>
                </div>

                <div class="form-group">
                    <label>Poster URL</label>
                    <input type="url" name="poster"
                           value="<?= htmlspecialchars($movie['poster'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Trailer URL</label>
                    <input type="url" name="trailer"
                           value="<?= htmlspecialchars($movie['trailer'] ?? '') ?>">
                </div>

                <button type="submit" class="btn">Save Changes</button>
                <a href="index.php" class="btn">Back</a>

            </form>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
