<?php require __DIR__.'/../partials/header.php'; ?>
<h1>Управление фильмами</h1>
<form method="post" enctype="multipart/form-data">
  <label>Название: <input type="text" name="title" required></label><br>
  <label>Постер: <input type="file" name="poster" accept="image/*" required></label><br>
  <label>Описание:<br><textarea name="description" rows="4"></textarea></label><br>
  <button type="submit">Добавить фильм</button>
</form>
<table>
  <tr><th>ID</th><th>Название</th><th>Постер</th><th>Действие</th></tr>
  <?php foreach($movies as $m): ?>
    <tr>
      <td><?php echo $m['id']; ?></td>
      <td><?php echo htmlspecialchars($m['title']); ?></td>
      <td><img src="/<?php echo $m['poster']; ?>" width="50"></td>
      <td><a href="?delete=<?php echo $m['id']; ?>">Удалить</a></td>
    </tr>
  <?php endforeach; ?>
</table>
<?php require __DIR__.'/../partials/footer.php'; ?>