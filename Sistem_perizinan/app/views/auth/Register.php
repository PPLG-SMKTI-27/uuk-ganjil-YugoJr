<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Perizinan Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --success: #27ae60;
            --danger: #e74c3c;
            --warning: #f39c12;
            --light: #ecf0f1;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            backdrop-filter: blur(10px);
        }
        
        .register-header {
            background: var(--primary);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        .register-header h2 {
            margin: 0;
            font-weight: 600;
        }
        
        .register-header p {
            margin: 5px 0 0 0;
            opacity: 0.8;
        }
        
        .register-body {
            padding: 30px;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-register {
            background: var(--success);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            background: #219a52;
            transform: translateY(-2px);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .login-link {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        
        .input-group-text {
            background: white;
            border: 2px solid #e9ecef;
            border-right: none;
        }
        
        .password-toggle {
            cursor: pointer;
            background: white;
            border: 2px solid #e9ecef;
            border-left: none;
        }
        
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
        }
        
        .form-select:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .password-strength {
            height: 5px;
            border-radius: 5px;
            margin-top: 5px;
            transition: all 0.3s;
        }
        
        .strength-weak { background: var(--danger); width: 25%; }
        .strength-fair { background: var(--warning); width: 50%; }
        .strength-good { background: #f1c40f; width: 75%; }
        .strength-strong { background: var(--success); width: 100%; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="register-container">
                    <div class="register-header">
                        <h2><i class="fas fa-user-plus me-2"></i>Registrasi</h2>
                        <p>Buat akun baru untuk sistem perizinan</p>
                    </div>
                    
                    <div class="register-body">
                        <?php if(isset($error) && !empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="index.php?action=register" id="registerForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                                                   value="<?php echo isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : ''; ?>" 
                                                   placeholder="Masukkan nama lengkap" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" id="username" name="username" 
                                                   value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                                                   placeholder="Masukkan username" required>
                                        </div>
                                        <small class="form-text text-muted">Minimal 3 karakter</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="murid" <?php echo (isset($_POST['role']) && $_POST['role'] == 'murid') ? 'selected' : ''; ?>>Murid</option>
                                    <option value="wali" <?php echo (isset($_POST['role']) && $_POST['role'] == 'wali') ? 'selected' : ''; ?>>Wali Kelas</option>
                                </select>
                                <small class="form-text text-muted">Pilih peran Anda dalam sistem</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="password" name="password" 
                                                   placeholder="Masukkan password" required onkeyup="checkPasswordStrength()">
                                            <span class="input-group-text password-toggle" onclick="togglePassword('password')">
                                                <i class="fas fa-eye" id="password-icon"></i>
                                            </span>
                                        </div>
                                        <div class="password-strength" id="password-strength"></div>
                                        <small class="form-text text-muted">Minimal 6 karakter</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                                   placeholder="Konfirmasi password" required>
                                            <span class="input-group-text password-toggle" onclick="togglePassword('confirm_password')">
                                                <i class="fas fa-eye" id="confirm-password-icon"></i>
                                            </span>
                                        </div>
                                        <div id="password-match" class="form-text"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="agree_terms" name="agree_terms" required>
                                <label class="form-check-label" for="agree_terms">
                                    Saya menyetujui <a href="#" class="login-link">syarat dan ketentuan</a>
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-register w-100 mb-3">
                                <i class="fas fa-user-plus me-2"></i>Daftar
                            </button>
                            
                            <div class="text-center">
                                <span>Sudah punya akun? 
                                    <a href="index.php?action=login" class="login-link">Login di sini</a>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const passwordIcon = document.getElementById(fieldId + '-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'fas fa-eye';
            }
        }
        
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('password-strength');
            const strengthText = document.getElementById('password-match');
            
            let strength = 0;
            
            if (password.length >= 6) strength++;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            strengthBar.className = 'password-strength';
            
            if (password.length === 0) {
                strengthBar.style.width = '0%';
                strengthBar.className = 'password-strength';
                strengthText.textContent = '';
            } else if (strength <= 2) {
                strengthBar.className += ' strength-weak';
                strengthText.textContent = 'Password lemah';
                strengthText.className = 'form-text text-danger';
            } else if (strength === 3) {
                strengthBar.className += ' strength-fair';
                strengthText.textContent = 'Password cukup';
                strengthText.className = 'form-text text-warning';
            } else if (strength === 4) {
                strengthBar.className += ' strength-good';
                strengthText.textContent = 'Password baik';
                strengthText.className = 'form-text text-info';
            } else {
                strengthBar.className += ' strength-strong';
                strengthText.textContent = 'Password kuat';
                strengthText.className = 'form-text text-success';
            }
            
            // Check password match
            const confirmPassword = document.getElementById('confirm_password').value;
            if (confirmPassword.length > 0) {
                if (password !== confirmPassword) {
                    document.getElementById('password-match').textContent = 'Password tidak cocok';
                    document.getElementById('password-match').className = 'form-text text-danger';
                } else {
                    document.getElementById('password-match').textContent = 'Password cocok';
                    document.getElementById('password-match').className = 'form-text text-success';
                }
            }
        }
        
        document.getElementById('confirm_password').addEventListener('keyup', checkPasswordStrength);
        
        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak sama!');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Password minimal 6 karakter!');
                return false;
            }
            
            return true;
        });
        
        // Auto close alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>