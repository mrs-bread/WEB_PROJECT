<?php
// Этот скрипт выполните один раз: http://localhost/studak/seed.php
require 'config.php';

// 1) Очистим таблицы
$pdo->exec("SET FOREIGN_KEY_CHECKS=0");
foreach (['news','users','groups','directions','faculty','roles'] as $t) {
    $pdo->exec("TRUNCATE TABLE `$t`");
}
$pdo->exec("SET FOREIGN_KEY_CHECKS=1");

// 2) Роли
$roles = ['преподаватель','студент','деканат'];
$stmt = $pdo->prepare("INSERT INTO roles(name) VALUES (:n)");
foreach($roles as $r) $stmt->execute(['n'=>$r]);

// 3) Факультеты
$fac = ['Компьютерных наук','Экономический'];
$stmt = $pdo->prepare("INSERT INTO faculty(name) VALUES (:n)");
foreach($fac as $f) $stmt->execute(['n'=>$f]);

// 4) Направления
$dirs = [
  ['faculty'=>1,'name'=>'Программная инженерия'],
  ['faculty'=>1,'name'=>'Прикладная математика'],
  ['faculty'=>2,'name'=>'Менеджмент']
];
$stmt = $pdo->prepare("INSERT INTO directions(faculty_id,name) VALUES (:f,:n)");
foreach($dirs as $d) $stmt->execute(['f'=>$d['faculty'],'n'=>$d['name']]);

// 5) Группы
$grs = [
  ['faculty'=>1,'name'=>'ПКС-101'],
  ['faculty'=>1,'name'=>'ПМ-102'],
  ['faculty'=>2,'name'=>'МЕН-201']
];
$stmt = $pdo->prepare("INSERT INTO groups(faculty_id,name) VALUES (:f,:n)");
foreach($grs as $g) $stmt->execute(['f'=>$g['faculty'],'n'=>$g['name']]);

// 6) Пользователи
$users = [
  // fio,      role, fac, grp, dir, login,    пароль
  ['Иванов И.И.', 2,    1,   1,   1,   'ivanov', 'pass123'],
  ['Петров П.П.', 2,    1,   1,   1,   'petrov', 'pass123'],
  ['Сидоров С.С.',1,    1,   0,   0,   'sidorov', 'teach123'],
  ['Декан Д.Д.',  3,    2,   0,   0,   'dekan',  'dean123'],
];
$stmt = $pdo->prepare("
  INSERT INTO users(fio,role_id,faculty_id,group_id,direction_id,login,password)
  VALUES(:fio,:rid,:fid,:gid,:did,:login,:pass)
");
foreach($users as $u) {
  $hash = password_hash($u[6], PASSWORD_DEFAULT);
  $stmt->execute([
    'fio'   => $u[0],
    'rid'   => $u[1],
    'fid'   => $u[2],
    'gid'   => $u[3],
    'did'   => $u[4],
    'login' => $u[5],
    'pass'  => $hash
  ]);
}

// 7) Пара новостей
$news = [
  ['user'=>'sidorov','text'=>'Добро пожаловать на курс Операционные системы.'],
  ['user'=>'dekan','text'=>'Собрание деканата в пятницу в 15:00.']
];
$stmtUser = $pdo->prepare("SELECT id FROM users WHERE login=:l");
$stmtNews = $pdo->prepare("
  INSERT INTO news(user_id,news_title,news_text)
  VALUES(:uid,'',:txt)
");
foreach($news as $n) {
  $stmtUser->execute(['l'=>$n[0]]);
  $uid = $stmtUser->fetchColumn();
  $stmtNews->execute(['uid'=>$uid,'txt'=>$n[1]]);
}

echo "Сид данных успешно выполнен!";
