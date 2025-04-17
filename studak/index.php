<?php
require 'config.php';
require_login();

// Добавление новости (только для преп./деканата)
if (is_teacher_or_dean() && $_SERVER['REQUEST_METHOD']=='POST' && !empty($_POST['news_text'])) {
    $stmt = $pdo->prepare("
      INSERT INTO news(user_id, news_title, news_text, publication_date, created_at)
      VALUES(:uid,'',:txt,NOW(),NOW())
    ");
    $stmt->execute([
      'uid' => $_SESSION['user_id'],
      'txt' => trim($_POST['news_text'])
    ]);
    header('Location: index.php');
    exit;
}

// Фильтры
$sort   = $_GET['sort']   ?? 'new';     // new|old
$author = $_GET['author'] ?? 'all';     // all|user_id

// Список преподавателей/деканата
$teachers = $pdo->query("
  SELECT u.id,u.fio
  FROM users u
  JOIN roles r ON u.role_id=r.id
  WHERE r.name IN('преподаватель','деканат')
")->fetchAll(PDO::FETCH_ASSOC);

// Собираем запрос на новости
$where = []; $params=[];
if($author!=='all'){
  $where[]       = 'n.user_id=:author';
  $params['author']=$author;
}
$where_sql = $where? 'WHERE '.implode(' AND ',$where):'';
$order     = $sort=='old'? 'ASC':'DESC';

$stmt = $pdo->prepare("
  SELECT n.*,u.fio
  FROM news n
  JOIN users u ON n.user_id=u.id
  $where_sql
  ORDER BY n.publication_date $order
");
$stmt->execute($params);
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Одногруппники (только студенты)
$groupmates = [];
if(is_student()){
  $stm = $pdo->prepare("
    SELECT fio FROM users
    WHERE group_id=:gid AND id<>:me
  ");
  $stm->execute([
    'gid'=>$_SESSION['group_id'],
    'me'=>$_SESSION['user_id']
  ]);
  $groupmates = $stm->fetchAll(PDO::FETCH_COLUMN);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Студак — Главная</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
  <script>
    function toggleForm(){ document.getElementById('news-form').classList.toggle('hidden'); }
  </script>
</head>
<body>
  <div class="container">
    <!-- sidebar -->
    <div class="sidebar">
      <h1>Студак</h1>
      <ul>
        <li><a href="index.php">Главная</a></li>
        <li><a href="#">Журнал</a></li>
        <li><a href="#">Расписание</a></li>
      </ul>
      <a href="logout.php" class="logout-btn">Выход</a>
    </div>

    <!-- main -->
    <div class="main-content">
      <h2>Добро пожаловать, <?=htmlspecialchars($_SESSION['fio'])?>!</h2>

      <form method="get" class="filters">
        <label>Автор:
          <select name="author" onchange="this.form.submit()">
            <option value="all">Все</option>
            <?php foreach($teachers as $t): ?>
              <option value="<?=$t['id']?>" <?= $author==$t['id']?'selected':''?>>
                <?=htmlspecialchars($t['fio'])?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>Сортировка:
          <select name="sort" onchange="this.form.submit()">
            <option value="new" <?= $sort=='new'?'selected':''?>>Сначала новые</option>
            <option value="old" <?= $sort=='old'?'selected':''?>>Сначала старые</option>
          </select>
        </label>
      </form>

      <?php if(is_teacher_or_dean()): ?>
        <button class="filter-button" onclick="toggleForm()">➕ Добавить новость</button>
        <form id="news-form" method="post" class="message-card hidden">
          <textarea name="news_text" rows="4" placeholder="Текст новости..." required></textarea>
          <button type="submit">Опубликовать</button>
        </form>
      <?php endif; ?>

      <?php foreach($news as $n): ?>
        <div class="message-card">
          <h3><?=htmlspecialchars($n['fio'])?> говорит:</h3>
          <p><?=nl2br(htmlspecialchars($n['news_text']))?></p>
          <small><?=date('d.m.Y H:i',strtotime($n['publication_date']))?></small>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- right sidebar -->
    <div class="right-sidebar">
      <h3><?=htmlspecialchars($_SESSION['fio'])?></h3>
      <a href="profile.php">Редактировать профиль</a>

      <?php if(is_student()): ?>
        <h3>Одногруппники</h3>
        <ul class="student-list">
          <?php foreach($groupmates as $m): ?>
            <li><?=htmlspecialchars($m)?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
