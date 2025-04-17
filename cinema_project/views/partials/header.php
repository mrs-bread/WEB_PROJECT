<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="/cinema_project/public/css/style.css">
  <script defer src="/cinema_project/public/js/main.js"></script>
  <title>Кинотеатр</title>
</head>
<body>
<nav>
  <a href="/cinema_project/">Главная</a>
  <?php if(isset($_SESSION['user'])): ?>
    <a href="/cinema_project/profile">Профиль</a>
    <?php if($_SESSION['user']['role']==='admin'): ?><a href="/cinema_project/admin">Админка</a><?php endif; ?>
    <a href="/cinema_project/logout">Выход</a>
  <?php else: ?>
    <a href="/cinema_project/login">Вход</a>
    <a href="/cinema_project/register">Регистрация</a>
  <?php endif; ?>
</nav>
<main>