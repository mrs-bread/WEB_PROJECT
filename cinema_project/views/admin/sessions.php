<?php require __DIR__.'/../partials/header.php'; ?>
<h1>Управление сеансами</h1>
<form method="post">
  <label>Фильм:
    <select name="movie_id">
      <?php foreach($movies as $m): ?>
        <option value="<?php echo $m['id']; ?>"><?php echo htmlspecialchars($m['title']); ?></option>
      <?php endforeach; ?>
    </select>
  </label><br>
  <label>Зал:
    <select name="hall_id">
      <?php foreach($halls as $h): ?>
        <option value="<?php echo $h['id']; ?>"><?php echo htmlspecialchars($h['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </label><br>
  <label>Дата: <input type="date" name="date" required></label><br>
  <label>Время: <input type="time" name="time" required></label><br>
  <button type="submit">Добавить сеанс</button>
</form>
<table>
  <tr><th>ID</th><th>Фильм</th><th>Зал</th><th>Дата</th><th>Время</th><th>Действие</th></tr>
  <?php foreach($sessions as $s): ?>
    <tr>
      <td><?php echo $s['id']; ?></td>
      <td><?php echo htmlspecialchars($s['title']); ?></td>
      <td><?php echo htmlspecialchars($s['hall_name']); ?></td>
      <td><?php echo $s['session_date']; ?></td>
      <td><?php echo $s['session_time']; ?></td>
      <td><a href="?delete=<?php echo $s['id']; ?>">Удалить</a></td>
    </tr>
  <?php endforeach; ?>
</table>
<?php require __DIR__.'/../partials/footer.php'; ?>