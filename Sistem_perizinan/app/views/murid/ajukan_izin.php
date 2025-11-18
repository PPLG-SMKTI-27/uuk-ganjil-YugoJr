<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Izin - Murid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
        }
        
        .sidebar {
            background: var(--primary);
            color: white;
            min-height: 100vh;
            padding: 0;
        }
        
        .sidebar-brand {
            padding: 20px;
            background: rgba(0,0,0,0.1);
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-menu a {
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            display: block;
            transition: all 0.3s;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: var(--secondary);
            color: white;
        }
        
        .sidebar-menu i {
            width: 20px;
            margin-right: 10px;
        }
        
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .form-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .form-body {
            padding: 30px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .info-box {
            background: #e8f4fd;
            border-left: 4px solid var(--secondary);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="sidebar-brand">
                    <h4><i class="fas fa-user-graduate"></i> Sistem Perizinan</h4>
                    <small>Murid</small>
                </div>
                
                <ul class="sidebar-menu">
                    <li>
                        <a href="index.php?action=murid_dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=ajukan_izin" class="active">
                            <i class="fas fa-paper-plane"></i> Ajukan Izin
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=profile">
                            <i class="fas fa-user"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=logout">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <span class="navbar-brand">Ajukan Izin Keluar</span>
                        <div class="d-flex">
                            <span class="navbar-text me-3">
                                <i class="fas fa-user me-1"></i> <?php echo $_SESSION['nama_lengkap']; ?>
                            </span>
                        </div>
                    </div>
                </nav>
                
                <!-- Content -->
                <div class="container-fluid mt-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="form-container">
                                <div class="form-header">
                                    <h3><i class="fas fa-paper-plane me-2"></i>Form Pengajuan Izin</h3>
                                    <p class="mb-0">Isi form berikut untuk mengajukan izin keluar sekolah</p>
                                </div>
                                
                                <div class="form-body">
                                    <?php if($success): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if($error): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="info-box">
                                        <h5><i class="fas fa-info-circle me-2"></i>Informasi Penting</h5>
                                        <p class="mb-0">Pastikan mengisi form dengan benar. Izin akan diproses oleh wali kelas dan Anda akan mendapatkan notifikasi ketika status berubah.</p>
                                    </div>
                                    
                                    <form method="POST" action="index.php?action=ajukan_izin" id="izinForm">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="wali_kelas_id" class="form-label">Wali Kelas <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="wali_kelas_id" name="wali_kelas_id" required>
                                                        <option value="">Pilih Wali Kelas</option>
                                                        <?php while($wali = $wali_kelas->fetch(PDO::FETCH_ASSOC)): ?>
                                                        <option value="<?php echo $wali['id']; ?>" 
                                                                <?php echo isset($_POST['wali_kelas_id']) && $_POST['wali_kelas_id'] == $wali['id'] ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($wali['nama_lengkap']); ?>
                                                        </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tanggal" class="form-label">Tanggal Izin <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                                           value="<?php echo isset($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d'); ?>" 
                                                           min="<?php echo date('Y-m-d'); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="jam_keluar" class="form-label">Jam Keluar <span class="text-danger">*</span></label>
                                                    <input type="time" class="form-control" id="jam_keluar" name="jam_keluar" 
                                                           value="<?php echo isset($_POST['jam_keluar']) ? $_POST['jam_keluar'] : ''; ?>" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Perkiraan Jam Kembali</label>
                                                    <input type="time" class="form-control" id="perkiraan_jam_kembali" readonly>
                                                    <small class="form-text text-muted">Akan diisi oleh wali kelas</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="alasan" class="form-label">Alasan Izin <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="alasan" name="alasan" rows="4" 
                                                      placeholder="Jelaskan alasan mengapa Anda perlu izin keluar sekolah..." 
                                                      required><?php echo isset($_POST['alasan']) ? htmlspecialchars($_POST['alasan']) : ''; ?></textarea>
                                            <div class="form-text">
                                                <span id="charCount">0</span>/500 karakter
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Keterangan Tambahan</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="urgent" name="urgent">
                                                <label class="form-check-label" for="urgent">
                                                    <i class="fas fa-exclamation-triangle text-warning me-1"></i>Izin Penting/Mendesak
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <a href="index.php?action=murid_dashboard" class="btn btn-secondary me-md-2">
                                                <i class="fas fa-arrow-left me-1"></i> Kembali
                                            </a>
                                            <button type="submit" name="ajukan_izin" class="btn btn-submit">
                                                <i class="fas fa-paper-plane me-1"></i> Ajukan Izin
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Tips Section -->
                            <div class="card mt-4">
                                <div class="card-body">
                                    <h5><i class="fas fa-lightbulb me-2 text-warning"></i>Tips Pengajuan Izin</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success me-2"></i> Ajukan izin minimal 1 jam sebelum waktu keluar</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Jelaskan alasan dengan jelas dan singkat</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Pastikan memilih wali kelas yang tepat</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Periksa kembali data sebelum mengajukan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto close alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
            
            // Character counter for alasan
            const alasanTextarea = document.getElementById('alasan');
            const charCount = document.getElementById('charCount');
            
            alasanTextarea.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = length;
                
                if (length > 500) {
                    charCount.className = 'text-danger';
                } else if (length > 400) {
                    charCount.className = 'text-warning';
                } else {
                    charCount.className = 'text-muted';
                }
            });
            
            // Set min time for jam_keluar to current time
            const now = new Date();
            const currentTime = now.getHours().toString().padStart(2, '0') + ':' + 
                              now.getMinutes().toString().padStart(2, '0');
            document.getElementById('jam_keluar').min = currentTime;
            
            // Auto calculate perkiraan jam kembali (3 hours later)
            const jamKeluarInput = document.getElementById('jam_keluar');
            const perkiraanJamKembali = document.getElementById('perkiraan_jam_kembali');
            
            jamKeluarInput.addEventListener('change', function() {
                if (this.value) {
                    const [hours, minutes] = this.value.split(':').map(Number);
                    let returnHours = hours + 3;
                    if (returnHours >= 24) returnHours -= 24;
                    
                    const returnTime = returnHours.toString().padStart(2, '0') + ':' + 
                                     minutes.toString().padStart(2, '0');
                    perkiraanJamKembali.value = returnTime;
                }
            });
            
            // Form validation
            document.getElementById('izinForm').addEventListener('submit', function(e) {
                const alasan = document.getElementById('alasan').value;
                const tanggal = document.getElementById('tanggal').value;
                const selectedDate = new Date(tanggal);
                const today = new Date();
                
                // Reset date time for comparison
                today.setHours(0, 0, 0, 0);
                selectedDate.setHours(0, 0, 0, 0);
                
                if (selectedDate < today) {
                    e.preventDefault();
                    alert('Tanggal izin tidak boleh kurang dari hari ini!');
                    return false;
                }
                
                if (alasan.length > 500) {
                    e.preventDefault();
                    alert('Alasan maksimal 500 karakter!');
                    return false;
                }
                
                return true;
            });
        });
    </script>
</body>
</html>