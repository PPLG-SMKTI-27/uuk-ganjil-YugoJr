<?php
require_once __DIR__ . '/../models/Permission.php';


class TeacherController {
private $db;


public function __construct($db){
$this->db = $db;
}


// Teacher Dashboard (view all permissions)
public function dashboard(){
$perm = new Permission($this->db);
$data = $perm->readAll();
include __DIR__ . '/../views/teacher_dashboard.php';
}


// Update Permission Status
public function updateStatus(){
if ($_SESSION['role_id'] != 2) die("Not Allowed");


$perm = new Permission($this->db);
$perm->id = $_POST['id'];
$perm->status = $_POST['status'];
$perm->updateStatus();


header("Location: index.php?action=teacher-dashboard");
}
}