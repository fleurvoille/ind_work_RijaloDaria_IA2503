<?php

require_once 'config/database.php';

$search = $_GET['search'] ?? '';
$genre = $_GET['genre'] ?? '';
$sort = $_GET['sort'] ?? 'rating';

$sql = "SELECT * FROM movies WHERE title ILIKE :search";

$params = [
    'search' => '%' . $search . '%'
];

if (!empty($genre)) {
    $sql .= " AND genre = :genre";
    $params['genre'] = $genre;
}

if ($sort === 'year') {
    $sql .= " ORDER BY year DESC";
} elseif ($sort === 'oldest') {
    $sql .= " ORDER BY year ASC";
} elseif ($sort === 'title') {
    $sql .= " ORDER BY title ASC";
} else {
    $sql .= " ORDER BY rating DESC";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

$genres = $pdo->query("SELECT DISTINCT genre FROM movies ORDER BY genre")
               ->fetchAll(PDO::FETCH_COLUMN);

include 'includes/header.php';

?>

<section class="section">
    <div class="container">

        <h1 class="section-title">Explore Movies</h1>

        <p class="catalog-description">
            Find your next favorite movie.
        </p>

        <form method="GET" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="Search movies..."
                value="<?= htmlspecialchars($search) ?>"
            >

            <select name="genre">
                <option value="">All genres</option>

                <?php foreach ($genres as $item): ?>

                    <option value="<?= htmlspecialchars($item) ?>"
                        <?= $genre === $item ? 'selected' : '' ?>>
                        <?= htmlspecialchars($item) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <select name="sort">
                <option value="rating" <?= $sort === 'rating' ? 'selected' : '' ?>>Highest rating</option>
                <option value="year" <?= $sort === 'year' ? 'selected' : '' ?>>Newest first</option>
                <option value="oldest" <?= $sort === 'oldest' ? 'selected' : '' ?>>Oldest first</option>
                <option value="title" <?= $sort === 'title' ? 'selected' : '' ?>>By title</option>
            </select>

            <button type="submit" class="btn">Search</button>

        </form>

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

                            <div class="rating">
                                ★ <?= htmlspecialchars((string)$movie['rating']) ?>/10
                            </div>

                            <br>

                            <a href="movie.php?id=<?= (int)$movie['id'] ?>"
                               class="btn">View details</a>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <p>No movies found</p>

            <?php endif; ?>

        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
