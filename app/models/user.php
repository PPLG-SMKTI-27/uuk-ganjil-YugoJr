<?php
class User {
    private $conn;
    public $id;
    public $username;
    public $password;
    public $role_id;

    public function __construct($db){
        $this->conn = $db;
    }

    public function findByUsername($username){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ❌ REMOVE password_hash
    public function create(){
        $stmt = $this->conn->prepare("INSERT INTO users(username,password,role_id) VALUES(?,?,?)");
        return $stmt->execute([
            $this->username,
            $this->password, // <-- plain text now
            $this->role_id
        ]);
    }
}