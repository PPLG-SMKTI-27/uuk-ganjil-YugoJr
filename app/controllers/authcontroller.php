<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;

    public function __construct($db){ 
        $this->db = $db; 
    }

public function login() {
    $userModel = new User($this->db);
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $userModel->findByUsername($username);

    // ❌ no password_verify
    if ($user && $password === $user['password']) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role_id'] = $user['role_id'];

        if ($user['role_id'] == 1) {
            header("Location: index.php?action=dashboard");
            exit;
        }
        if ($user['role_id'] == 2) {
            header("Location: index.php?action=teacher-dashboard");
            exit;
        }

        echo "Role not recognized.";

    } else {
        echo "Invalid Credentials";
    }
}}