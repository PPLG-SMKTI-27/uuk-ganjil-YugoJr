<?php
require_once __DIR__.'/../models/Permission.php';

class PermissionController {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    // ======================
    // CREATE PERMISSION
    // ======================
    public function create(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Invalid request method");
        }

        if (!isset($_SESSION['user_id'])) {
            die("User not logged in");
        }

        if (empty($_POST['reason'])) {
            die("Reason cannot be empty");
        }

        $perm = new Permission($this->db);
        $perm->user_id = $_SESSION['user_id'];
        $perm->reason  = trim($_POST['reason']);
        $perm->status  = "pending";

        if (!$perm->create()) {
            die("Failed to create permission");
        }

        header("Location: index.php?action=dashboard");
        exit;
    }

    // ======================
    // READ PERMISSIONS
    // ======================
    public function read(){
        $perm = new Permission($this->db);

        // If student → only show his own permissions
        if ($_SESSION['role_id'] == 1) {
            return $perm->readByUser($_SESSION['user_id']);
        }

        // Teacher/Admin → show all
        return $perm->readAll();
    }

    // ======================
    // UPDATE STATUS (Teacher Only)
    // ======================
    public function updateStatus(){
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
            die("You are not allowed to update status");
        }

        if (empty($_POST['id']) || empty($_POST['status'])) {
            die("Missing data");
        }

        $perm = new Permission($this->db);
        $perm->id = $_POST['id'];
        $perm->status = $_POST['status'];

        if (!$perm->updateStatus()) {
            die("Failed to update status");
        }

        header("Location: index.php?action=dashboard");
        exit;
    }

    // ======================
    // DELETE PERMISSION
    // ======================
    public function delete(){
        if (empty($_POST['id'])) {
            die("Missing permission ID");
        }

        $perm = new Permission($this->db);
        $perm->id = $_POST['id'];

        if (!$perm->delete()) {
            die("Failed to delete");
        }

        header("Location: index.php?action=dashboard");
        exit;
    }
}