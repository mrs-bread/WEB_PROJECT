<?php
class Hall {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    public function all() {
        return $this->pdo->query('SELECT * FROM halls')->fetchAll();
    }

    public function create($name, $seats) {
        $stmt = $this->pdo->prepare('INSERT INTO halls(name,seats) VALUES(?,?)');
        return $stmt->execute([$name, $seats]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM halls WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
