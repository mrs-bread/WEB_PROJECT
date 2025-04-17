<?php
class AuthController {
    private $pdo;
    private $userModel;
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
    }
    public function login() {
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $u = $_POST['username']; $p = $_POST['password'];
            $user = $this->userModel->findByUsername($u);
            if($user && password_verify($p,$user['password'])){
                $_SESSION['user'] = $user;
                header('Location: /cinema_project/'); exit;
            }
            $error = 'Неверные данные';
        }
        require __DIR__.'/../views/login.php';
    }
    public function logout() {
        session_destroy();
        header('Location: /cinema_project/');
    }
    public function register() {
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if($this->userModel->create($_POST['username'],$_POST['password'])){
                header('Location: /cinema_project/login'); exit;
            }
            $error = 'Ошибка регистрации';
        }
        require __DIR__.'/../views/register.php';
    }
}