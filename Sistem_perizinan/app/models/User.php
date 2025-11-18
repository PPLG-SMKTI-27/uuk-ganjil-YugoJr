<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $nama_lengkap;
    public $role;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method untuk validasi input
    private function validateInput() {
        if(empty($this->username) || empty($this->password) || empty($this->nama_lengkap)) {
            return "Semua field harus diisi!";
        }
        
        if(strlen($this->username) < 3) {
            return "Username minimal 3 karakter!";
        }
        
        if(strlen($this->password) < 6) {
            return "Password minimal 6 karakter!";
        }
        
        if(!in_array($this->role, ['admin', 'wali', 'murid'])) {
            return "Role tidak valid!";
        }
        
        return null;
    }

    // Method untuk cek username sudah ada
    public function usernameExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->username);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    // Method register dengan validasi
    public function register() {
        // Validasi input
        $validationError = $this->validateInput();
        if($validationError) {
            return $validationError;
        }
        
        // Cek username sudah ada
        if($this->usernameExists()) {
            return "Username sudah digunakan!";
        }
        
        $query = "INSERT INTO " . $this->table_name . " 
                SET username=:username, password=:password, 
                nama_lengkap=:nama_lengkap, role=:role";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->nama_lengkap = htmlspecialchars(strip_tags($this->nama_lengkap));
        $this->role = htmlspecialchars(strip_tags($this->role));
        
        // Bind parameters
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":nama_lengkap", $this->nama_lengkap);
        $stmt->bindParam(":role", $this->role);
        
        if($stmt->execute()) {
            return true;
        }
        return "Terjadi kesalahan sistem. Silakan coba lagi.";
    }

    // Method login dengan validasi
    public function login() {
        if(empty($this->username) || empty($this->password)) {
            return "Username dan password harus diisi!";
        }
        
        $query = "SELECT id, username, password, nama_lengkap, role 
                FROM " . $this->table_name . " 
                WHERE username = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->username);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verify password
            if(password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->nama_lengkap = $row['nama_lengkap'];
                $this->role = $row['role'];
                return true;
            }
        }
        return "Username atau password salah!";
    }

    // Method untuk mendapatkan user by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->nama_lengkap = $row['nama_lengkap'];
            $this->role = $row['role'];
            $this->created_at = $row['created_at'];
            return true;
        }
        return false;
    }

    // Method untuk update profile
    public function updateProfile() {
        $query = "UPDATE " . $this->table_name . " 
                SET nama_lengkap = :nama_lengkap 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->nama_lengkap = htmlspecialchars(strip_tags($this->nama_lengkap));
        
        $stmt->bindParam(":nama_lengkap", $this->nama_lengkap);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Method untuk ganti password
    public function changePassword($new_password) {
        $query = "UPDATE " . $this->table_name . " 
                SET password = :password 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        
        $stmt->bindParam(":password", $new_password_hashed);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Method untuk membaca semua user
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Method untuk update role
    public function updateRole() {
        $query = "UPDATE " . $this->table_name . " 
                SET role = :role 
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Method untuk menghapus user
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Method untuk mendapatkan wali kelas
    public function getWaliKelas() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE role = 'wali'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Method untuk mendapatkan murid
    public function getMurid() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE role = 'murid'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Method untuk mendapatkan statistics
    public function getStatistics() {
        $query = "SELECT role, COUNT(*) as count FROM " . $this->table_name . " GROUP BY role";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>