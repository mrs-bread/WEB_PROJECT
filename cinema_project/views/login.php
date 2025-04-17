<?php require 'partials/header.php'; ?>
<h1>Вход</h1>
<?php if(isset($error)): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
<form method="post">
  <label>Логин: <input type="text" name="username" required></label><br>
  <label>Пароль: <input type="password" name="password" required></label><br>
  <button type="submit">Войти</button>
</form>
<?php require 'partials/footer.php'; ?>