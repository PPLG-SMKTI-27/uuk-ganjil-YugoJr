<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Murid - Sistem Perizinan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
            --light: #ecf0f1;
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
        
        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .stat-card {
            border-radius: 10px;
            border: none;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card.pending { border-left: 4px solid var(--warning); }
        .stat-card.approved { border-left: 4px solid var(--success); }
        .stat-card.rejected { border-left: 4px solid var(--danger); }
        .stat-card.total { border-left: 4px solid var(--secondary); }
        
        .badge-pending { background: var(--warning); }
        .badge-approved { background: var(--success); }
        .badge-rejected { background: var(--danger); }
        
        .quick-action {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            border: 2px dashed #e9ecef;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .quick-action:hover {
            border-color: var(--secondary);
            background: #f8f9ff;
        }
        
        .status-pending { border-left: 4px solid var(--warning); }
        .status-approved { border-left: 4px solid var(--success); }
        .status-rejected { border-left: 4px solid var(--danger); }
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
                        <a href="index.php?action=murid_dashboard" class="active">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=ajukan_izin">
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
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <span class="navbar-brand">Dashboard Murid</span>
                        <div class="d-flex">
                            <span class="navbar-text me-3">
                                <i class="fas fa-user me-1"></i> <?php echo $_SESSION['nama_lengkap']; ?>
                            </span>
                            <span class="navbar-text">
                                <i class="fas fa-calendar me-1"></i> <?php echo date('d F Y'); ?>
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
                    
                    <!-- Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card stat-card total h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="card-title text-muted">Total Izin</h6>
                                                    <h3 class="text-primary"><?php echo $stats['total']; ?></h3>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fas fa-clipboard-list fa-2x text-primary"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="card stat-card pending h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="card-title text-muted">Pending</h6>
                                                    <h3 class="text-warning"><?php echo $stats['pending']; ?></h3>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fas fa-clock fa-2x text-warning"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="card stat-card approved h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="card-title text-muted">Disetujui</h6>
                                                    <h3 class="text-success"><?php echo $stats['disetujui']; ?></h3>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="card stat-card rejected h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="card-title text-muted">Ditolak</h6>
                                                    <h3 class="text-danger"><?php echo $stats['ditolak']; ?></h3>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fas fa-times-circle fa-2x text-danger"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <a href="index.php?action=ajukan_izin" class="text-decoration-none">
                                <div class="quick-action h-100">
                                    <i class="fas fa-paper-plane fa-3x text-primary mb-3"></i>
                                    <h5>Ajukan Izin Keluar</h5>
                                    <p class="text-muted">Klik untuk mengajukan izin keluar sekolah</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Recent Perizinan -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-history me-2"></i>Riwayat Perizinan Terbaru
                                    </h5>
                                    <a href="index.php?action=ajukan_izin" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i> Ajukan Izin Baru
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Wali Kelas</th>
                                                    <th>Tanggal</th>
                                                    <th>Jam Keluar</th>
                                                    <th>Alasan</th>
                                                    <th>Status</th>
                                                    <th>Tanggal Ajuan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $count = 0;
                                                while($row = $perizinan->fetch(PDO::FETCH_ASSOC)): 
                                                    if($count >= 5) break;
                                                    $count++;
                                                ?>
                                                <tr class="<?php echo 'status-' . $row['status']; ?>">
                                                    <td><?php echo htmlspecialchars($row['nama_wali']); ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                                    <td><?php echo date('H:i', strtotime($row['jam_keluar'])); ?></td>
                                                    <td>
                                                        <span title="<?php echo htmlspecialchars($row['alasan']); ?>">
                                                            <?php echo strlen($row['alasan']) > 30 ? substr($row['alasan'], 0, 30) . '...' : $row['alasan']; ?>
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
                                                </tr>
                                                <?php endwhile; ?>
                                                
                                                <?php if($count == 0): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-4">
                                                        <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                                                        <p>Belum ada riwayat perizinan</p>
                                                        <a href="index.php?action=ajukan_izin" class="btn btn-primary">
                                                            <i class="fas fa-plus me-1"></i> Ajukan Izin Pertama
                                                        </a>
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
        });
    </script>
</body>
</html>