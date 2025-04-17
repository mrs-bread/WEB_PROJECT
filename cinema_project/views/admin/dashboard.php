<?php require __DIR__.'/../partials/header.php'; ?>
<h1>Админка: Dashboard</h1>
<ul>
  <li>Фильмов: <?php echo $movieCount; ?></li>
  <li>Залов: <?php echo $hallCount; ?></li>
  <li>Сегодняшних сеансов: <?php echo $sessionCount; ?></li>
</ul>
<?php require __DIR__.'/../partials/footer.php'; ?>