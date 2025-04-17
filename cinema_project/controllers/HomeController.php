<?php
class HomeController {
    private $pdo;
    public function __construct($pdo){ $this->pdo=$pdo; }
    public function index(){
        $sessionModel = new SessionModel($this->pdo);
        $date = $_GET['date'] ?? date('Y-m-d');
        $sessions = $sessionModel->getByDate($date);
        require __DIR__.'/../views/home.php';
    }
}