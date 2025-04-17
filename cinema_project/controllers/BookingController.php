<?php
class BookingController {
    private $pdo;
    public function __construct($pdo){ $this->pdo=$pdo; }
    public function show(){
        $session_id = $_GET['session_id'];
        $session = (new SessionModel($this->pdo))->getByDate($_GET['date']);
        $occupied = (new Booking($this->pdo))->getOccupied($session_id);
        require __DIR__.'/../views/booking.php';
    }
    public function book(){
        $user = $_SESSION['user'] ?? null;
        if(!$user){ http_response_code(403); exit; }
        $bModel = new Booking($this->pdo);
        foreach($_POST['seats'] as $seat){
            $bModel->book($_POST['session_id'],$user['id'],$seat);
        }
        header('Location: /cinema_project/profile');
    }
    public function profile(){
        $user = $_SESSION['user'] ?? null;
        $bookings = (new Booking($this->pdo))->getByUser($user['id']);
        require __DIR__.'/../views/profile.php';
    }
}