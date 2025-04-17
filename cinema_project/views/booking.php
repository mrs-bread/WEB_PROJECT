<?php require 'partials/header.php'; ?>
<h1>Бронирование сеанса</h1>
<p>Сеанс: <?php echo htmlspecialchars($session_id); ?></p>
<form method="post" action="/cinema_project/book">
  <input type="hidden" name="session_id" value="<?php echo $session_id; ?>">
  <div class="seats">
    <?php for($i=1; $i<=$session[0]['seats']; $i++): ?>
      <?php $cls = in_array($i, $occupied) ? 'occupied' : 'free'; ?>
      <label class="seat <?php echo $cls; ?>">
        <input type="checkbox" name="seats[]" value="<?php echo $i; ?>" <?php echo $cls==='occupied'?'disabled':''; ?>>
        <?php echo $i; ?>
      </label>
      <?php if($i % 10 === 0) echo '<br>'; ?>
    <?php endfor; ?>
  </div>
  <button type="submit">Подтвердить</button>
</form>
<?php require 'partials/footer.php'; ?>