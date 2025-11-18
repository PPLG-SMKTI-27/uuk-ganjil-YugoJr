<?php
class WaliController {
    private $userModel;
    private $perizinanModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($db);
        $this->perizinanModel = new Perizinan($db);
    }

    public function dashboard() {
        // Cek login dan role
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'wali') {
            header("Location: index.php?action=login");
            exit();
        }

        $success = isset($_GET['success']) ? $_GET['success'] : '';
        $error = isset($_GET['error']) ? $_GET['error'] : '';

        // Ambil data perizinan untuk wali ini
        $perizinan = $this->perizinanModel->readByWali($_SESSION['user_id']);
        
        // Hitung statistics
        $stats = $this->getStatistics($_SESSION['user_id']);

        include_once 'app/views/wali/dashboard.php';
    }

    public function perizinan() {
        // Cek login dan role
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'wali') {
            header("Location: index.php?action=login");
            exit();
        }

        $success = '';
        $error = '';

        // Handle update status perizinan
        if(isset($_POST['update_status'])) {
            $this->perizinanModel->id = $_POST['perizinan_id'];
            $this->perizinanModel->status = $_POST['status'];
            $this->perizinanModel->jam_kembali = $_POST['jam_kembali'] ?? null;

            if($this->perizinanModel->updateStatus()) {
                $success = "Status perizinan berhasil diupdate!";
            } else {
                $error = "Gagal mengupdate status perizinan!";
            }
        }

        // Ambil data perizinan
        $perizinan = $this->perizinanModel->readByWali($_SESSION['user_id']);

        include_once 'app/views/wali/perizinan.php';
    }

    private function getStatistics($wali_id) {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
                    SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak
                  FROM perizinan 
                  WHERE wali_kelas_id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $wali_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>