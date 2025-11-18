<?php
class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function login() {
        // Jika user sudah login, redirect ke dashboard
        if(isset($_SESSION['user_id'])) {
            $this->redirectToDashboard();
        }

        $error = '';
        $success = '';

        // Handle form submission
        if($_POST) {
            $this->userModel->username = $_POST['username'];
            $this->userModel->password = $_POST['password'];
            
            $loginResult = $this->userModel->login();
            
            if($loginResult === true) {
                // Set session
                $_SESSION['user_id'] = $this->userModel->id;
                $_SESSION['username'] = $this->userModel->username;
                $_SESSION['nama_lengkap'] = $this->userModel->nama_lengkap;
                $_SESSION['role'] = $this->userModel->role;
                
                // Set cookie jika remember me dicentang
                if(isset($_POST['remember_me'])) {
                    setcookie('remember_user', $this->userModel->id, time() + (86400 * 30), "/"); // 30 hari
                }
                
                // Redirect ke dashboard
                $this->redirectToDashboard();
            } else {
                $error = $loginResult;
            }
        }

        // Check remember me cookie
        if(!$_POST && isset($_COOKIE['remember_user'])) {
            if($this->userModel->getById($_COOKIE['remember_user'])) {
                $_SESSION['user_id'] = $this->userModel->id;
                $_SESSION['username'] = $this->userModel->username;
                $_SESSION['nama_lengkap'] = $this->userModel->nama_lengkap;
                $_SESSION['role'] = $this->userModel->role;
                $this->redirectToDashboard();
            }
        }

        // Tampilkan pesan success jika ada (misal dari redirect setelah register)
        if(isset($_GET['success'])) {
            $success = $_GET['success'];
        }

        include_once 'app/views/auth/login.php';
    }

    public function register() {
        // Jika user sudah login, redirect ke dashboard
        if(isset($_SESSION['user_id'])) {
            $this->redirectToDashboard();
        }

        $error = '';
        $success = '';

        if($_POST) {
            // Assign data dari form
            $this->userModel->username = $_POST['username'];
            $this->userModel->password = $_POST['password'];
            $this->userModel->nama_lengkap = $_POST['nama_lengkap'];
            $this->userModel->role = $_POST['role'];
            
            // Konfirmasi password
            $confirm_password = $_POST['confirm_password'];
            if($this->userModel->password !== $confirm_password) {
                $error = "Password dan konfirmasi password tidak sama!";
            } else {
                $registerResult = $this->userModel->register();
                
                if($registerResult === true) {
                    header("Location: index.php?action=login&success=Registrasi berhasil! Silakan login.");
                    exit();
                } else {
                    $error = $registerResult;
                }
            }
        }

        include_once 'app/views/auth/register.php';
    }

    public function profile() {
        // Cek login
        if(!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $error = '';
        $success = '';

        // Load data user
        $this->userModel->getById($_SESSION['user_id']);

        // Handle update profile
        if(isset($_POST['update_profile'])) {
            $this->userModel->nama_lengkap = $_POST['nama_lengkap'];
            
            if($this->userModel->updateProfile()) {
                $_SESSION['nama_lengkap'] = $this->userModel->nama_lengkap;
                $success = "Profile berhasil diupdate!";
            } else {
                $error = "Gagal mengupdate profile!";
            }
        }

        // Handle change password
        if(isset($_POST['change_password'])) {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            
            // Verify current password
            if(!password_verify($current_password, $this->userModel->password)) {
                $error = "Password saat ini salah!";
            } elseif($new_password !== $confirm_password) {
                $error = "Password baru dan konfirmasi password tidak sama!";
            } elseif(strlen($new_password) < 6) {
                $error = "Password baru minimal 6 karakter!";
            } else {
                if($this->userModel->changePassword($new_password)) {
                    $success = "Password berhasil diubah!";
                } else {
                    $error = "Gagal mengubah password!";
                }
            }
        }

        include_once 'app/views/auth/profile.php';
    }

    public function logout() {
        // Hapus session
        session_unset();
        session_destroy();
        
        // Hapus cookie remember me
        if(isset($_COOKIE['remember_user'])) {
            setcookie('remember_user', '', time() - 3600, "/");
        }
        
        header("Location: index.php?action=login&success=Logout berhasil!");
        exit();
    }

    private function redirectToDashboard() {
        switch($_SESSION['role']) {
            case 'admin':
                header("Location: index.php?action=admin_dashboard");
                break;
            case 'wali':
                header("Location: index.php?action=wali_dashboard");
                break;
            case 'murid':
                header("Location: index.php?action=murid_dashboard");
                break;
            default:
                header("Location: index.php?action=login");
        }
        exit();
    }
}
?>