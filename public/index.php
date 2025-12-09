<?php
session_start();

require_once __DIR__.'/../app/config/Database.php';
require_once __DIR__.'/../app/controllers/AuthController.php';
require_once __DIR__.'/../app/controllers/PermissionController.php';
require_once __DIR__.'/../app/controllers/TeacherController.php';

$db = (new Database())->connect();

$action = $_GET['action'] ?? 'login';

switch ($action) {

    // ---- LOGIN ----
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new AuthController($db))->login();
        } else {
            include __DIR__ . '/../app/views/login.php';
        }
        break;


    // ---- STUDENT DASHBOARD ----
    case 'dashboard':
        $controller = new PermissionController($db);
        $data = $controller->read();
        include __DIR__ . '/../app/views/student_dashboard.php';
        break;


    case 'create-permission':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new PermissionController($db))->create();
        } else {
            include __DIR__.'/../app/views/create_permission.php';
        }
        break;

    case 'update-status':
        (new PermissionController($db))->updateStatus();
        break;


    case 'delete-permission':
        (new PermissionController($db))->delete();
        break;


    // ---- TEACHER ROUTES ----
    case 'teacher-dashboard':
        (new TeacherController($db))->dashboard();
        break;

    case 'teacher-update-status':
        (new TeacherController($db))->updateStatus();
        break;


    default:
        echo "404 Not Found";
}