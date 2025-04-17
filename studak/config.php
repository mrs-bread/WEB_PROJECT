<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_NAME', 'studak');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}
function is_student() {
    return (isset($_SESSION['role_id']) && $_SESSION['role_id']==2);
}
function is_teacher_or_dean() {
    return (isset($_SESSION['role_id']) && in_array($_SESSION['role_id'], [1,3]));
}
