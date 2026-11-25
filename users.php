<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int)$_POST['delete_id'];

    if ($id !== (int)$_SESSION['user_id']) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }

    header('Location: users.php');
    exit;
}

$stmt = $pdo->query("SELECT id, username, email, role FROM users ORDER BY id");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
?>

<section class="section">
    <div class="container">
        <h1 class="section-title">Manage Users</h1>

        <div class="admin-actions">
            <a href="index.php" class="btn">Back to Admin Panel</a>
        </div>

        <div class="admin-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= (int)$user['id'] ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td>
                                <?php if ((int)$user['id'] !== (int)$_SESSION['user_id']): ?>
                                    <form method="POST" onsubmit="return confirm('Delete this user?');">
                                        <input type="hidden" name="delete_id"
                                               value="<?= (int)$user['id'] ?>">
                                        <button type="submit" class="remove-btn">
                                            Delete
                                        </button>
                                    </form>
                                <?php else: ?>
                                    Current user
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
