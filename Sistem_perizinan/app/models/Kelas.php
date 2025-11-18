<?php
class Kelas {
    private $conn;
    private $table_name = "kelas";

    public $id;
    public $nama_kelas;
    public $wali_kelas_id;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method untuk validasi input
    private function validateInput() {
        if(empty($this->nama_kelas)) {
            return "Nama kelas harus diisi!";
        }
        
        if(strlen($this->nama_kelas) < 2) {
            return "Nama kelas minimal 2 karakter!";
        }
        
        return null;
    }

    // Method untuk cek nama kelas sudah ada
    public function namaKelasExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE nama_kelas = ?";
        
        if($this->id) {
            $query .= " AND id != ?";
        }
        
        $query .= " LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nama_kelas);
        
        if($this->id) {
            $stmt->bindParam(2, $this->id);
        }
        
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    // Method untuk create kelas
    public function create() {
        // Validasi input
        $validationError = $this->validateInput();
        if($validationError) {
            return $validationError;
        }
        
        // Cek nama kelas sudah ada
        if($this->namaKelasExists()) {
            return "Nama kelas sudah digunakan!";
        }
        
        $query = "INSERT INTO " . $this->table_name . " 
                SET nama_kelas=:nama_kelas, wali_kelas_id=:wali_kelas_id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->nama_kelas = htmlspecialchars(strip_tags($this->nama_kelas));
        $this->wali_kelas_id = $this->wali_kelas_id ? htmlspecialchars(strip_tags($this->wali_kelas_id)) : null;
        
        // Bind parameters
        $stmt->bindParam(":nama_kelas", $this->nama_kelas);
        $stmt->bindParam(":wali_kelas_id", $this->wali_kelas_id);
        
        if($stmt->execute()) {
            return true;
        }
        return "Terjadi kesalahan sistem. Silakan coba lagi.";
    }

    // Method untuk read semua kelas dengan nama wali kelas
    public function readAll() {
        $query = "SELECT k.*, u.nama_lengkap as nama_wali_kelas 
                  FROM " . $this->table_name . " k
                  LEFT JOIN users u ON k.wali_kelas_id = u.id
                  ORDER BY k.nama_kelas ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Method untuk read kelas by ID
    public function readOne() {
        $query = "SELECT k.*, u.nama_lengkap as nama_wali_kelas 
                  FROM " . $this->table_name . " k
                  LEFT JOIN users u ON k.wali_kelas_id = u.id
                  WHERE k.id = ? 
                  LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $row['id'];
            $this->nama_kelas = $row['nama_kelas'];
            $this->wali_kelas_id = $row['wali_kelas_id'];
            $this->created_at = $row['created_at'];
            
            return true;
        }
        return false;
    }

    // Method untuk update kelas
    public function update() {
        // Validasi input
        $validationError = $this->validateInput();
        if($validationError) {
            return $validationError;
        }
        
        // Cek nama kelas sudah ada
        if($this->namaKelasExists()) {
            return "Nama kelas sudah digunakan!";
        }
        
        $query = "UPDATE " . $this->table_name . " 
                SET nama_kelas = :nama_kelas, wali_kelas_id = :wali_kelas_id 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->nama_kelas = htmlspecialchars(strip_tags($this->nama_kelas));
        $this->wali_kelas_id = $this->wali_kelas_id ? htmlspecialchars(strip_tags($this->wali_kelas_id)) : null;
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind parameters
        $stmt->bindParam(":nama_kelas", $this->nama_kelas);
        $stmt->bindParam(":wali_kelas_id", $this->wali_kelas_id);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return "Terjadi kesalahan sistem. Silakan coba lagi.";
    }

    // Method untuk delete kelas
    public function delete() {
        // Cek apakah kelas memiliki siswa
        if($this->hasSiswa()) {
            return "Kelas tidak dapat dihapus karena masih memiliki siswa!";
        }
        
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return "Terjadi kesalahan sistem. Silakan coba lagi.";
    }

    // Method untuk cek apakah kelas memiliki siswa
    private function hasSiswa() {
        $query = "SELECT id FROM users WHERE role = 'murid' AND id IN (
                    SELECT siswa_id FROM perizinan WHERE wali_kelas_id IN (
                        SELECT id FROM users WHERE role = 'wali' AND id = ?
                    )
                  ) LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->wali_kelas_id);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    // Method untuk mendapatkan kelas by wali_kelas_id
    public function getByWaliKelas($wali_kelas_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE wali_kelas_id = ? 
                  ORDER BY nama_kelas ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $wali_kelas_id);
        $stmt->execute();
        return $stmt;
    }

    // Method untuk mendapatkan semua wali kelas yang tersedia (yang belum memiliki kelas)
    public function getAvailableWaliKelas() {
        $query = "SELECT u.* FROM users u 
                  WHERE u.role = 'wali' 
                  AND u.id NOT IN (SELECT wali_kelas_id FROM kelas WHERE wali_kelas_id IS NOT NULL)
                  ORDER BY u.nama_lengkap ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Method untuk mendapatkan statistics
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_kelas,
                    COUNT(wali_kelas_id) as kelas_berwali,
                    (COUNT(*) - COUNT(wali_kelas_id)) as kelas_tanpa_wali
                  FROM " . $this->table_name;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method untuk search kelas
    public function search($keyword) {
        $query = "SELECT k.*, u.nama_lengkap as nama_wali_kelas 
                  FROM " . $this->table_name . " k
                  LEFT JOIN users u ON k.wali_kelas_id = u.id
                  WHERE k.nama_kelas LIKE ? OR u.nama_lengkap LIKE ?
                  ORDER BY k.nama_kelas ASC";
        
        $stmt = $this->conn->prepare($query);
        
        $keyword = "%{$keyword}%";
        $stmt->bindParam(1, $keyword);
        $stmt->bindParam(2, $keyword);
        
        $stmt->execute();
        return $stmt;
    }

    // Method untuk mendapatkan kelas dengan jumlah siswa
    public function readAllWithSiswaCount() {
        $query = "SELECT k.*, u.nama_lengkap as nama_wali_kelas,
                         COUNT(s.id) as jumlah_siswa
                  FROM " . $this->table_name . " k
                  LEFT JOIN users u ON k.wali_kelas_id = u.id
                  LEFT JOIN users s ON s.role = 'murid' 
                  GROUP BY k.id
                  ORDER BY k.nama_kelas ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>