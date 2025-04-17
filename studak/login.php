<?php
require 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $login    = trim($_POST['login']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("
      SELECT * FROM users WHERE login = :login LIMIT 1
    ");
    $stmt->execute(['login'=>$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['fio']        = $user['fio'];
        $_SESSION['role_id']    = $user['role_id'];
        $_SESSION['faculty_id'] = $user['faculty_id'];
        $_SESSION['group_id']   = $user['group_id'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Неверный логин или пароль';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Вход — Студак</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="login-container">
    <form method="post" class="login-form">
      <h2>Войти в Студак</h2>
      <?php if($error): ?><div class="error"><?=$error?></div><?php endif; ?>
      <input type="text" name="login"    placeholder="Логин" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit">Войти</button>
    </form>
  </div>
</body>
</html>
