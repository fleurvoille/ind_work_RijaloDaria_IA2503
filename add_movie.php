
<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

requireAdmin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $year = (int)($_POST['year'] ?? 0);
    $genre = trim($_POST['genre'] ?? '');
    $rating = (float)($_POST['rating'] ?? 0);
    $poster = trim($_POST['poster'] ?? '');
    $trailer = trim($_POST['trailer'] ?? '');

    if ($title === '' || $description === '' || $genre === '' || $year < 1888 || $year > 2100 || $rating < 0 || $rating > 10) {
        $error = 'Please fill in all required fields correctly.';
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO movies (title, description, year, genre, rating, poster, trailer)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $title,
            $description,
            $year,
            $genre,
            $rating,
            $poster,
            $trailer
        ]);

        header('Location: index.php');
        exit;
    }
}

include '../includes/header.php';
?>

<section class="section">
    <div class="container">
        <h1 class="section-title">Add New Movie</h1>

        <div class="form-container">

            <?php if ($error !== ''): ?>
                <p class="error-message">
                    <?= htmlspecialchars($error) ?>
                </p>
            <?php endif; ?>

            <form method="POST">

                <div class="form-group">
                    <label>Movie Title</label>
                    <input type="text" name="title" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" required></textarea>
                </div>

                <div class="form-group">
                    <label>Year</label>
                    <input type="number" name="year" min="1888" max="2100" required>
                </div>

                <div class="form-group">
                    <label>Genre</label>
                    <input type="text" name="genre" required>
                </div>

                <div class="form-group">
                    <label>Rating (0–10)</label>
                    <input type="number" name="rating" min="0" max="10" step="0.1" required>
                </div>

                <div class="form-group">
                    <label>Poster URL</label>
                    <input type="url" name="poster">
                </div>

                <div class="form-group">
                    <label>Trailer URL</label>
                    <input type="url" name="trailer">
                </div>

                <button type="submit" class="btn">Add Movie</button>
                <a href="index.php" class="btn">Back</a>

            </form>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
