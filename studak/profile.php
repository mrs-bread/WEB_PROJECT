<?php
require 'config.php';
require_login();

$success = '';
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $stmt = $pdo->prepare("
      UPDATE users SET email=:e,phone=:p WHERE id=:uid
    ");
    $stmt->execute([
      'e'=>$email,'p'=>$phone,'uid'=>$_SESSION['user_id']
    ]);
    $success = 'Сохранено';
}

$stmt = $pdo->prepare("SELECT email,phone FROM users WHERE id=:uid");
$stmt->execute(['uid'=>$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Мой профиль</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h1>Студак</h1>
      <ul>
        <li><a href="index.php">Главная</a></li>
      </ul>
      <a href="logout.php" class="logout-btn">Выход</a>
    </div>
    <div class="main-content">
      <h2>Мой профиль</h2>
      <?php if($success): ?><div class="success"><?=$success?></div><?php endif; ?>
      <form method="post">
        <label>Эл. почта</label><br>
        <input type="email" name="email" value="<?=htmlspecialchars($user['email'])?>"><br>
        <label>Телефон</label><br>
        <input type="text" name="phone" value="<?=htmlspecialchars($user['phone'])?>"><br>
        <button type="submit">Сохранить</button>
      </form>
    </div>
  </div>
</body>
</html>
