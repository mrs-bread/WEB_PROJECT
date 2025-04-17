<?php require __DIR__.'/../partials/header.php'; ?>
<h1>Управление залами</h1>
<form method="post">
  <label>Название: <input type="text" name="name" required></label><br>
  <label>Мест: <input type="number" name="seats" required></label><br>
  <button type="submit">Добавить зал</button>
</form>
<table>
  <tr><th>ID</th><th>Название</th><th>Мест</th><th>Действие</th></tr>
  <?php foreach($halls as $h): ?>
    <tr>
      <td><?php echo $h['id']; ?></td>
      <td><?php echo htmlspecialchars($h['name']); ?></td>
      <td><?php echo $h['seats']; ?></td>
      <td><a href="?delete=<?php echo $h['id']; ?>">Удалить</a></td>
    </tr>
  <?php endforeach; ?>
</table>
<?php require __DIR__.'/../partials/footer.php'; ?>