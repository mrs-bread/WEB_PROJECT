<?php
session_start();
require __DIR__ . '/config/db.php';

spl_autoload_register(function($class) {
    foreach (['controllers','models'] as $dir) {
        $file = __DIR__ . "/$dir/$class.php";
        if(file_exists($file)) { require $file; return; }
    }
});

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = '/cinema_project';
$route = substr($uri, strlen($base)) ?: '/';

switch($route) {
    case '/': (new HomeController($pdo))->index(); break;
    case '/login': (new AuthController($pdo))->login(); break;
    case '/logout': (new AuthController($pdo))->logout(); break;
    case '/register': (new AuthController($pdo))->register(); break;
    case '/booking': (new BookingController($pdo))->show(); break;
    case '/book': (new BookingController($pdo))->book(); break;
    case '/profile': (new BookingController($pdo))->profile(); break;
    case '/admin': (new AdminController($pdo))->dashboard(); break;
    case '/admin/movies': (new AdminController($pdo))->movies(); break;
    case '/admin/halls': (new AdminController($pdo))->halls(); break;
    case '/admin/sessions': (new AdminController($pdo))->sessions(); break;
    default: http_response_code(404); echo '404 Not Found';
}