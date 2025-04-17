<?php require 'partials/header.php'; ?>
<h1>Расписание на <?php echo $date; ?></h1>
<form method="get">
  <input type="date" name="date" value="<?php echo $date; ?>">
  <button>Показать</button>
</form>
<div class="grid">
  <?php foreach($sessions as $s): ?>
    <div class="card">
      <img src="<?php echo $s['poster']; ?>" alt="<?php echo $s['title']; ?>">
      <h2><?php echo $s['title']; ?></h2>
      <p>Зал: <?php echo $s['hall_name']; ?></p>
      <p>Время: <?php echo $s['session_time']; ?></p>
      <a href="/cinema_project/booking?session_id=<?php echo $s['id']; ?>&date=<?php echo $date; ?>">Бронирование</a>
    </div>
  <?php endforeach; ?>
</div>
<?php require 'partials/footer.php'; ?>