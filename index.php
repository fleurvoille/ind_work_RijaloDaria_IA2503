<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

requireAdmin();

$stmt = $pdo->query("SELECT * FROM movies ORDER BY id DESC");
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
?>

<section class="section">
    <div class="container">
        <h1 class="section-title">Admin Panel</h1>

        <div class="admin-actions">
            <a href="add_movie.php" class="btn">Add Movie</a>
            <a href="users.php" class="btn">Manage Users</a>
        </div>

        <h2>Movies Management</h2>

        <?php if (count($movies) > 0): ?>

            <div class="admin-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Year</th>
                            <th>Genre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($movies as $movie): ?>
                            <tr>
                                <td><?= (int)$movie['id'] ?></td>
                                <td><?= htmlspecialchars($movie['title']) ?></td>
                                <td><?= (int)$movie['year'] ?></td>
                                <td><?= htmlspecialchars($movie['genre']) ?></td>
                                <td>
                                    <a href="edit_movie.php?id=<?= (int)$movie['id'] ?>"
                                       class="edit-btn">Edit</a>

                                    <form method="POST" action="delete_movie.php"
                                          style="display:inline-block;">
                                        <input type="hidden" name="id"
                                               value="<?= (int)$movie['id'] ?>">
                                        <button type="submit" class="remove-btn">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>
            <p>No movies found.</p>
        <?php endif; ?>

    </div>
</section>

<?php include '../includes/footer.php'; ?>
