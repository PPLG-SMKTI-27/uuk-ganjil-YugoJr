<?php
class MuridController {
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
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'murid') {
            header("Location: index.php?action=login");
            exit();
        }

        $success = isset($_GET['success']) ? $_GET['success'] : '';
        $error = isset($_GET['error']) ? $_GET['error'] : '';

        // Ambil data perizinan murid
        $perizinan = $this->perizinanModel->readBySiswa($_SESSION['user_id']);
        
        // Hitung statistics
        $stats = $this->getStatistics($_SESSION['user_id']);

        // Ambil daftar wali kelas untuk dropdown
        $wali_kelas = $this->userModel->getWaliKelas();

        include_once 'app/views/murid/dashboard.php';
    }

    public function ajukanIzin() {
        // Cek login dan role
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'murid') {
            header("Location: index.php?action=login");
            exit();
        }

        $success = '';
        $error = '';

        // Handle pengajuan izin
        if(isset($_POST['ajukan_izin'])) {
            $this->perizinanModel->siswa_id = $_SESSION['user_id'];
            $this->perizinanModel->wali_kelas_id = $_POST['wali_kelas_id'];
            $this->perizinanModel->alasan = $_POST['alasan'];
            $this->perizinanModel->tanggal = $_POST['tanggal'];
            $this->perizinanModel->jam_keluar = $_POST['jam_keluar'];

            if($this->perizinanModel->create()) {
                $success = "Perizinan berhasil diajukan! Menunggu persetujuan wali kelas.";
            } else {
                $error = "Gagal mengajukan perizinan! Silakan coba lagi.";
            }
        }

        // Ambil daftar wali kelas
        $wali_kelas = $this->userModel->getWaliKelas();

        include_once 'app/views/murid/ajukan_izin.php';
    }

    private function getStatistics($siswa_id) {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
                    SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak
                  FROM perizinan 
                  WHERE siswa_id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $siswa_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>