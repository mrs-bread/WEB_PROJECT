<?php
class Booking {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    public function book($session_id, $user_id, $seat) {
        $stmt = $this->pdo->prepare(
            'INSERT INTO bookings(session_id, user_id, seat_number)
             VALUES(?,?,?)'
        );
        return $stmt->execute([$session_id, $user_id, $seat]);
    }

    public function getOccupied($session_id) {
        $stmt = $this->pdo->prepare('SELECT seat_number FROM bookings WHERE session_id = ?');
        $stmt->execute([$session_id]);
        return array_column($stmt->fetchAll(), 'seat_number');
    }

    public function getByUser($user_id) {
        $stmt = $this->pdo->prepare(
            'SELECT b.*, s.session_date, s.session_time,
                    m.title,
                    h.name AS hall_name
             FROM bookings b
             JOIN sessions s ON b.session_id = s.id
             JOIN movies m   ON s.movie_id   = m.id
             JOIN halls h    ON s.hall_id    = h.id
             WHERE b.user_id = ?'
        );
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
}
