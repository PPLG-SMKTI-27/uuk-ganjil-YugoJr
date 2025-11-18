<?php
$page_title = "Dashboard Admin";
$breadcrumbs = [
    ['text' => 'Dashboard']
];

ob_start();
?>
<div class="row">
    <div class="col-12">
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
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard Administrator
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h4>Selamat Datang, <?php echo $_SESSION['nama_lengkap']; ?>!</h4>
                        <p class="text-muted">Ini adalah panel administrator sistem perizinan siswa.</p>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <!-- User Statistics -->
                    <div class="col-md-3 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6>Total Users</h6>
                                        <h3><?php echo $user_stats['total'] ?? 0; ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6>Murid</h6>
                                        <h3><?php echo $user_stats['murid'] ?? 0; ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-user-graduate fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6>Wali Kelas</h6>
                                        <h3><?php echo $user_stats['wali'] ?? 0; ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6>Admin</h6>
                                        <h3><?php echo $user_stats['admin'] ?? 0; ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-user-shield fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Kelas Statistics -->
                    <div class="col-md-4 mb-3">
                        <div class="card bg-dark text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6>Total Kelas</h6>
                                        <h3><?php echo $kelas_stats['total_kelas'] ?? 0; ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-school fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6>Kelas dengan Wali</h6>
                                        <h3><?php echo $kelas_stats['kelas_berwali'] ?? 0; ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-user-check fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6>Kelas tanpa Wali</h6>
                                        <h3><?php echo $kelas_stats['kelas_tanpa_wali'] ?? 0; ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-user-times fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Perizinan Statistics -->
                    <div class="col-md-3 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6>Total Perizinan</h6>
                                        <h3><?php echo $perizinan_stats['total'] ?? 0; ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clipboard-list fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6>Pending</h6>
                                        <h3><?php echo $perizinan_stats['pending'] ?? 0; ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6>Disetujui</h6>
                                        <h3><?php echo $perizinan_stats['disetujui'] ?? 0; ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6>Ditolak</h6>
                                        <h3><?php echo $perizinan_stats['ditolak'] ?? 0; ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-times-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Data -->
                <div class="row">
                    <!-- Recent Users -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-users me-2"></i>User Terbaru
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $count = 0;
                                            while($row = $recent_users->fetch(PDO::FETCH_ASSOC)): 
                                                if($count >= 5) break;
                                                $count++;
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php 
                                                        switch($row['role']) {
                                                            case 'admin': echo 'warning'; break;
                                                            case 'wali': echo 'info'; break;
                                                            case 'murid': echo 'success'; break;
                                                            default: echo 'secondary';
                                                        }
                                                    ?>">
                                                        <?php echo ucfirst($row['role']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                                            </tr>
                                            <?php endwhile; ?>
                                            
                                            <?php if($count == 0): ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-3">
                                                    Belum ada data user
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <a href="index.php?action=admin_users" class="btn btn-sm btn-outline-primary">
                                        Lihat Semua User
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Perizinan -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-clipboard-list me-2"></i>Perizinan Terbaru
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Siswa</th>
                                                <th>Wali</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $count = 0;
                                            while($row = $recent_perizinan->fetch(PDO::FETCH_ASSOC)): 
                                                if($count >= 5) break;
                                                $count++;
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
                                                <td><?php echo htmlspecialchars($row['nama_wali']); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php 
                                                        switch($row['status']) {
                                                            case 'pending': echo 'warning'; break;
                                                            case 'disetujui': echo 'success'; break;
                                                            case 'ditolak': echo 'danger'; break;
                                                            default: echo 'secondary';
                                                        }
                                                    ?>">
                                                        <?php echo ucfirst($row['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                            </tr>
                                            <?php endwhile; ?>
                                            
                                            <?php if($count == 0): ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-3">
                                                    Belum ada data perizinan
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

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-bolt me-2"></i>Quick Actions
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <a href="index.php?action=admin_users" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-users me-1"></i> Kelola User
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <a href="index.php?action=admin_kelas" class="btn btn-outline-success w-100">
                                            <i class="fas fa-school me-1"></i> Kelola Kelas
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <a href="#" class="btn btn-outline-info w-100">
                                            <i class="fas fa-chart-bar me-1"></i> Laporan
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <a href="#" class="btn btn-outline-warning w-100">
                                            <i class="fas fa-cog me-1"></i> Settings
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
});
</script>
<?php
$content = ob_get_clean();
include 'app/views/layouts/header.php';
echo $content;
include 'app/views/layouts/footer.php';
?>