<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Perizinan - Wali Kelas</title>
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
        
        .badge-pending { background: var(--warning); }
        .badge-approved { background: var(--success); }
        .badge-rejected { background: var(--danger); }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .status-pending { border-left: 4px solid var(--warning); }
        .status-approved { border-left: 4px solid var(--success); }
        .status-rejected { border-left: 4px solid var(--danger); }
        
        .action-buttons .btn {
            margin: 2px;
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
                    <small>Wali Kelas</small>
                </div>
                
                <ul class="sidebar-menu">
                    <li>
                        <a href="index.php?action=wali_dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=wali_perizinan" class="active">
                            <i class="fas fa-clipboard-list"></i> Kelola Perizinan
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
                        <span class="navbar-brand">Kelola Perizinan Siswa</span>
                        <div class="d-flex">
                            <span class="navbar-text me-3">
                                <i class="fas fa-user me-1"></i> <?php echo $_SESSION['nama_lengkap']; ?>
                            </span>
                        </div>
                    </div>
                </nav>
                
                <!-- Content -->
                <div class="container-fluid mt-4">
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
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clipboard-list me-2"></i>Daftar Perizinan Siswa
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Siswa</th>
                                            <th>Tanggal</th>
                                            <th>Jam Keluar</th>
                                            <th>Alasan</th>
                                            <th>Status</th>
                                            <th>Tanggal Ajuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $perizinan->fetch(PDO::FETCH_ASSOC)): ?>
                                        <tr class="<?php echo 'status-' . $row['status']; ?>">
                                            <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                            <td><?php echo date('H:i', strtotime($row['jam_keluar'])); ?></td>
                                            <td>
                                                <span title="<?php echo htmlspecialchars($row['alasan']); ?>">
                                                    <?php echo strlen($row['alasan']) > 50 ? substr($row['alasan'], 0, 50) . '...' : $row['alasan']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                $badge_class = '';
                                                switch($row['status']) {
                                                    case 'pending': $badge_class = 'badge-pending'; break;
                                                    case 'disetujui': $badge_class = 'badge-approved'; break;
                                                    case 'ditolak': $badge_class = 'badge-rejected'; break;
                                                }
                                                ?>
                                                <span class="badge <?php echo $badge_class; ?>">
                                                    <?php echo ucfirst($row['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editModal<?php echo $row['id']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                                
                                                <!-- Modal -->
                                                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST" action="index.php?action=wali_perizinan">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Update Status Perizinan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nama Siswa</label>
                                                                        <input type="text" class="form-control" 
                                                                               value="<?php echo htmlspecialchars($row['nama_siswa']); ?>" readonly>
                                                                    </div>
                                                                    
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Alasan</label>
                                                                        <textarea class="form-control" rows="3" readonly><?php echo htmlspecialchars($row['alasan']); ?></textarea>
                                                                    </div>
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Tanggal</label>
                                                                                <input type="text" class="form-control" 
                                                                                       value="<?php echo date('d/m/Y', strtotime($row['tanggal'])); ?>" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Jam Keluar</label>
                                                                                <input type="text" class="form-control" 
                                                                                       value="<?php echo date('H:i', strtotime($row['jam_keluar'])); ?>" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Status</label>
                                                                        <select class="form-select" name="status" required>
                                                                            <option value="pending" <?php echo $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                                            <option value="disetujui" <?php echo $row['status'] == 'disetujui' ? 'selected' : ''; ?>>Disetujui</option>
                                                                            <option value="ditolak" <?php echo $row['status'] == 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Jam Kembali (jika disetujui)</label>
                                                                        <input type="time" class="form-control" name="jam_kembali" 
                                                                               value="<?php echo $row['jam_kembali'] ? date('H:i', strtotime($row['jam_kembali'])) : ''; ?>">
                                                                    </div>
                                                                    
                                                                    <input type="hidden" name="perizinan_id" value="<?php echo $row['id']; ?>">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" name="update_status" class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                        
                                        <?php if($perizinan->rowCount() == 0): ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                                                <p>Belum ada perizinan dari siswa</p>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto close alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
            
            // Auto show modal if there's error in form submission
            const urlParams = new URLSearchParams(window.location.search);
            if(urlParams.has('error')) {
                // You can implement logic to reopen the relevant modal here
            }
        });
    </script>
</body>
</html>