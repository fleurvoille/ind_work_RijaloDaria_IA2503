<?php

require_once 'config/database.php';
require_once 'includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($username === '' || $email === '' || $password === '' || $confirmPassword === '') {
        $error = 'Please fill in all fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email';
    } elseif (strlen($password) < 6) {
        $error = 'Password must contain at least 6 characters';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } else {

        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'This email is already registered';
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO users (username, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->execute([$username, $email, $hashedPassword]);

            header('Location: login.php');
            exit;
        }
    }
}

include 'includes/header.php';

?>

<div class="form-container">

    <h2>Create Account</h2>

    <?php if ($error): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required minlength="2"
                   value="<?= htmlspecialchars($username ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required
                   value="<?= htmlspecialchars($email ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required minlength="6">
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required minlength="6">
        </div>

        <button type="submit" class="btn">Register</button>

    </form>

    <p class="form-link">
        Already have an account?
        <a href="login.php">Login</a>
    </p>

</div>

<?php include 'includes/footer.php'; ?>
