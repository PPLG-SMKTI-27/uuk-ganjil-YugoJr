<?php
class Perizinan {
    private $conn;
    private $table_name = "perizinan";

    public $id;
    public $siswa_id;
    public $wali_kelas_id;
    public $alasan;
    public $tanggal;
    public $jam_keluar;
    public $jam_kembali;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                SET siswa_id=:siswa_id, wali_kelas_id=:wali_kelas_id, 
                alasan=:alasan, tanggal=:tanggal, jam_keluar=:jam_keluar";
        
        $stmt = $this->conn->prepare($query);
        
        $this->siswa_id = htmlspecialchars(strip_tags($this->siswa_id));
        $this->wali_kelas_id = htmlspecialchars(strip_tags($this->wali_kelas_id));
        $this->alasan = htmlspecialchars(strip_tags($this->alasan));
        $this->tanggal = htmlspecialchars(strip_tags($this->tanggal));
        $this->jam_keluar = htmlspecialchars(strip_tags($this->jam_keluar));
        
        $stmt->bindParam(":siswa_id", $this->siswa_id);
        $stmt->bindParam(":wali_kelas_id", $this->wali_kelas_id);
        $stmt->bindParam(":alasan", $this->alasan);
        $stmt->bindParam(":tanggal", $this->tanggal);
        $stmt->bindParam(":jam_keluar", $this->jam_keluar);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readByWali($wali_kelas_id) {
        $query = "SELECT p.*, u.nama_lengkap as nama_siswa 
                FROM " . $this->table_name . " p
                JOIN users u ON p.siswa_id = u.id
                WHERE p.wali_kelas_id = ?
                ORDER BY p.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $wali_kelas_id);
        $stmt->execute();
        return $stmt;
    }

    public function readBySiswa($siswa_id) {
        $query = "SELECT p.*, u.nama_lengkap as nama_wali 
                FROM " . $this->table_name . " p
                JOIN users u ON p.wali_kelas_id = u.id
                WHERE p.siswa_id = ?
                ORDER BY p.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $siswa_id);
        $stmt->execute();
        return $stmt;
    }

    public function updateStatus() {
        $query = "UPDATE " . $this->table_name . " 
                SET status = :status, jam_kembali = :jam_kembali 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->jam_kembali = htmlspecialchars(strip_tags($this->jam_kembali));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":jam_kembali", $this->jam_kembali);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT p.*, u1.nama_lengkap as nama_siswa, u2.nama_lengkap as nama_wali 
                FROM " . $this->table_name . " p
                JOIN users u1 ON p.siswa_id = u1.id
                JOIN users u2 ON p.wali_kelas_id = u2.id
                ORDER BY p.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>