<?php
class SessionModel {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    public function getByDate($date) {
        $stmt = $this->pdo->prepare(
            'SELECT s.id, s.session_date, s.session_time,
                    m.title, m.poster,
                    h.name AS hall_name, h.seats
             FROM sessions s
             JOIN movies m ON s.movie_id = m.id
             JOIN halls h   ON s.hall_id  = h.id
             WHERE s.session_date = ?'
        );
        $stmt->execute([$date]);
        return $stmt->fetchAll();
    }

    public function create($movie_id, $hall_id, $date, $time) {
        $stmt = $this->pdo->prepare(
            'INSERT INTO sessions(movie_id,hall_id,session_date,session_time)
             VALUES(?,?,?,?)'
        );
        return $stmt->execute([$movie_id, $hall_id, $date, $time]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM sessions WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
