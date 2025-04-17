<?php
class Movie {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    public function all() {
        return $this->pdo->query('SELECT * FROM movies')->fetchAll();
    }

    public function create($title, $poster, $description) {
        $stmt = $this->pdo->prepare('INSERT INTO movies(title,poster,description) VALUES(?,?,?)');
        return $stmt->execute([$title, $poster, $description]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM movies WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
