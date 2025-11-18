<?php
class AdminController {
    private $userModel;
    private $perizinanModel;
    private $kelasModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($db);
        $this->perizinanModel = new Perizinan($db);
        $this->kelasModel = new Kelas($db);
    }

    public function dashboard() {
        if($_SESSION['role'] != 'admin') {
            header("Location: index.php?action=login");
            exit();
        }

        $success = isset($_GET['success']) ? $_GET['success'] : '';
        $error = isset($_GET['error']) ? $_GET['error'] : '';

        // Ambil statistics
        $user_stats = $this->userModel->getStatistics();
        $kelas_stats = $this->kelasModel->getStatistics();
        $perizinan_stats = $this->getPerizinanStatistics();
        
        // Ambil data terbaru
        $recent_users = $this->userModel->readAll();
        $recent_perizinan = $this->perizinanModel->readAll();

        include_once 'app/views/admin/dashboard.php';
    }

    public function users() {
        if($_SESSION['role'] != 'admin') {
            header("Location: index.php?action=login");
            exit();
        }

        $success = isset($_GET['success']) ? $_GET['success'] : '';
        $error = isset($_GET['error']) ? $_GET['error'] : '';

        // Handle update role
        if(isset($_POST['update_role'])) {
            $this->userModel->id = $_POST['user_id'];
            $this->userModel->role = $_POST['role'];

            if($this->userModel->updateRole()) {
                header("Location: index.php?action=admin_users&success=Role user berhasil diubah!");
                exit();
            } else {
                $error = "Gagal mengubah role user!";
            }
        }

        // Handle delete user
        if(isset($_POST['delete_user'])) {
            $this->userModel->id = $_POST['user_id'];
            
            if($this->userModel->delete()) {
                header("Location: index.php?action=admin_users&success=User berhasil dihapus!");
                exit();
            } else {
                header("Location: index.php?action=admin_users&error=Gagal menghapus user!");
                exit();
            }
        }

        // Ambil data users
        $users = $this->userModel->readAll();

        include_once 'app/views/admin/users.php';
    }

    public function kelas() {
        if($_SESSION['role'] != 'admin') {
            header("Location: index.php?action=login");
            exit();
        }

        $success = isset($_GET['success']) ? $_GET['success'] : '';
        $error = isset($_GET['error']) ? $_GET['error'] : '';

        // Handle create kelas
        if(isset($_POST['create_kelas'])) {
            $this->kelasModel->nama_kelas = $_POST['nama_kelas'];
            $this->kelasModel->wali_kelas_id = $_POST['wali_kelas_id'] ?: null;

            $result = $this->kelasModel->create();
            if($result === true) {
                header("Location: index.php?action=admin_kelas&success=Kelas berhasil ditambahkan!");
                exit();
            } else {
                $error = $result;
            }
        }

        // Handle update kelas
        if(isset($_POST['update_kelas'])) {
            $this->kelasModel->id = $_POST['id'];
            $this->kelasModel->nama_kelas = $_POST['nama_kelas'];
            $this->kelasModel->wali_kelas_id = $_POST['wali_kelas_id'] ?: null;

            $result = $this->kelasModel->update();
            if($result === true) {
                header("Location: index.php?action=admin_kelas&success=Kelas berhasil diupdate!");
                exit();
            } else {
                $error = $result;
            }
        }

        // Handle delete kelas
        if(isset($_POST['delete_kelas'])) {
            $this->kelasModel->id = $_POST['id'];
            
            $result = $this->kelasModel->delete();
            if($result === true) {
                header("Location: index.php?action=admin_kelas&success=Kelas berhasil dihapus!");
                exit();
            } else {
                header("Location: index.php?action=admin_kelas&error=" . urlencode($result));
                exit();
            }
        }

        // Ambil data
        $kelas = $this->kelasModel->readAll();
        $available_wali = $this->kelasModel->getAvailableWaliKelas();
        $stats = $this->kelasModel->getStatistics();

        include_once 'app/views/admin/kelas.php';
    }

    private function getPerizinanStatistics() {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
                    SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak
                  FROM perizinan";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>