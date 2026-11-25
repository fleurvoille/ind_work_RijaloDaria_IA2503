<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

requireLogin();

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: logout.php');
    exit;
}

include 'includes/header.php';

?>

<section class="section">
    <div class="container">

        <h1 class="section-title">My Profile</h1>

        <div class="profile-card">

            <div class="profile-avatar">
                <?= strtoupper(substr($user['username'], 0, 1)) ?>
            </div>

            <h2><?= htmlspecialchars($user['username']) ?></h2>

            <p><?= htmlspecialchars($user['email']) ?></p>

            <p class="profile-role">
                <?= htmlspecialchars($user['role']) ?>
            </p>

            <a href="favorites.php" class="btn">
                My Favorites
            </a>

        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
