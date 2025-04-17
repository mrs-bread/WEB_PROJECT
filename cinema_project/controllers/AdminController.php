<?php
class AdminController {
    private $pdo;
    public function __construct($pdo){ $this->pdo=$pdo; }
    public function dashboard(){
        $movieCount = count((new Movie($this->pdo))->all());
        $hallCount = count((new Hall($this->pdo))->all());
        $sessionCount = count((new SessionModel($this->pdo))->getByDate(date('Y-m-d')));
        require __DIR__.'/../views/admin/dashboard.php';
    }
    public function movies(){
        $movieModel = new Movie($this->pdo);
        if($_SERVER['REQUEST_METHOD']==='POST'){
            // simple upload без валидации
            $target = 'public/uploads/'.basename($_FILES['poster']['name']);
            move_uploaded_file($_FILES['poster']['tmp_name'],$target);
            $movieModel->create($_POST['title'],$target,$_POST['description']);
            header('Location: /cinema_project/admin/movies'); exit;
        }
        if(isset($_GET['delete'])){
            $movieModel->delete($_GET['delete']); header('Location: /cinema_project/admin/movies');
        }
        $movies = $movieModel->all();
        require __DIR__.'/../views/admin/movies.php';
    }
    public function halls(){
        $hallModel = new Hall($this->pdo);
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $hallModel->create($_POST['name'],$_POST['seats']); header('Location: /cinema_project/admin/halls'); exit;
        }
        if(isset($_GET['delete'])){
            $hallModel->delete($_GET['delete']); header('Location: /cinema_project/admin/halls');
        }
        $halls = $hallModel->all();
        require __DIR__.'/../views/admin/halls.php';
    }
    public function sessions(){
        $sessModel = new SessionModel($this->pdo);
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $sessModel->create($_POST['movie_id'],$_POST['hall_id'],$_POST['date'],$_POST['time']);
            header('Location: /cinema_project/admin/sessions'); exit;
        }
        if(isset($_GET['delete'])){
            $sessModel->delete($_GET['delete']); header('Location: /cinema_project/admin/sessions');
        }
        $movies = (new Movie($this->pdo))->all();
        $halls = (new Hall($this->pdo))->all();
        $sessions = $sessModel->getByDate(date('Y-m-d'));
        require __DIR__.'/../views/admin/sessions.php';
    }
}