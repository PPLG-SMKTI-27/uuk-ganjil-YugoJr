<?php
session_start();

// Debug: Tampilkan path untuk troubleshooting
// echo "Current directory: " . __DIR__ . "<br>";

// Include required files
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Perizinan.php';
require_once __DIR__ . '/../app/models/Kelas.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/controllers/WaliController.php';
require_once __DIR__ . '/../app/controllers/MuridController.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Set default action
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Debug: Tampilkan action yang dipilih
// echo "Action: " . $action . "<br>";

// Route requests
switch($action) {
    case 'login':
        $auth = new AuthController($db);
        $auth->login();
        break;
        
    case 'register':
        $auth = new AuthController($db);
        $auth->register();
        break;
        
    case 'logout':
        $auth = new AuthController($db);
        $auth->logout();
        break;
        
    case 'profile':
        $auth = new AuthController($db);
        $auth->profile();
        break;
        
    case 'dashboard':
        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        
        switch($_SESSION['role']) {
            case 'admin':
                $admin = new AdminController($db);
                $admin->dashboard();
                break;
            case 'wali':
                $wali = new WaliController($db);
                $wali->dashboard();
                break;
            case 'murid':
                $murid = new MuridController($db);
                $murid->dashboard();
                break;
            default:
                header("Location: index.php?action=login");
                exit();
        }
        break;
        
    case 'admin_dashboard':
        $admin = new AdminController($db);
        $admin->dashboard();
        break;
        
    case 'admin_users':
        $admin = new AdminController($db);
        $admin->users();
        break;
        
    case 'admin_kelas':
        $admin = new AdminController($db);
        $admin->kelas();
        break;
        
    case 'wali_dashboard':
        $wali = new WaliController($db);
        $wali->dashboard();
        break;
        
    case 'wali_perizinan':
        $wali = new WaliController($db);
        $wali->perizinan();
        break;
        
    case 'murid_dashboard':
        $murid = new MuridController($db);
        $murid->dashboard();
        break;
        
    case 'ajukan_izin':
        $murid = new MuridController($db);
        $murid->ajukanIzin();
        break;
        
    default:
        header("Location: index.php?action=login");
        exit();
}
?>