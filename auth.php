<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Проверяет, авторизован ли пользователь
 *
 * @return bool
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * Проверяет, является ли пользователь администратором
 *
 * @return bool
 */
function isAdmin(): bool
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Проверяет доступ к защищённой странице
 *
 * @return void
 */
function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit;
    }
}
/**
 * Проверяет, является ли пользователь администратором
 * Если нет, перенаправляет на главную страницу
 * @return void
 */
function requireAdmin(): void
{
    if (!isAdmin()) {
        header('Location: /index.php');
        exit;
    }
}
