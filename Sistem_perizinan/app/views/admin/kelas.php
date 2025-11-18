<?php
$page_title = "Manajemen Kelas";
$breadcrumbs = [
    ['text' => 'Dashboard', 'url' => 'index.php?action=admin_dashboard'],
    ['text' => 'Data Kelas']
];

ob_start();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-school me-2"></i>Data Kelas
                </h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKelasModal">
                    <i class="fas fa-plus me-1"></i>Tambah Kelas
                </button>
            </div>
            <div class="card-body">
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

                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h6>Total Kelas</h6>
                                <h3><?php echo $stats['total_kelas']; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h6>Kelas dengan Wali</h6>
                                <h3><?php echo $stats['kelas_berwali']; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h6>Kelas tanpa Wali</h6>
                                <h3><?php echo $stats['kelas_tanpa_wali']; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Kelas -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Kelas</th>
                                <th>Wali Kelas</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while($row = $kelas->fetch(PDO::FETCH_ASSOC)): 
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                                <td>
                                    <?php if($row['nama_wali_kelas']): ?>
                                        <?php echo htmlspecialchars($row['nama_wali_kelas']); ?>
                                    <?php else: ?>
                                        <span class="text-muted">Belum ada wali kelas</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editKelasModal"
                                            data-id="<?php echo $row['id']; ?>"
                                            data-nama="<?php echo htmlspecialchars($row['nama_kelas']); ?>"
                                            data-wali="<?php echo $row['wali_kelas_id']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete_kelas" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            
                            <?php if($kelas->rowCount() == 0): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-school fa-3x mb-3"></i>
                                    <p>Belum ada data kelas</p>
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

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="tambahKelasModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="index.php?action=admin_kelas">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kelas Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label">Nama Kelas *</label>
                        <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required>
                    </div>
                    <div class="mb-3">
                        <label for="wali_kelas_id" class="form-label">Wali Kelas</label>
                        <select class="form-select" id="wali_kelas_id" name="wali_kelas_id">
                            <option value="">Pilih Wali Kelas</option>
                            <?php while($wali = $available_wali->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $wali['id']; ?>">
                                <?php echo htmlspecialchars($wali['nama_lengkap']); ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                        <small class="form-text text-muted">Opsional - bisa ditambahkan nanti</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="create_kelas" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kelas -->
<div class="modal fade" id="editKelasModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="index.php?action=admin_kelas">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_nama_kelas" class="form-label">Nama Kelas *</label>
                        <input type="text" class="form-control" id="edit_nama_kelas" name="nama_kelas" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_wali_kelas_id" class="form-label">Wali Kelas</label>
                        <select class="form-select" id="edit_wali_kelas_id" name="wali_kelas_id">
                            <option value="">Pilih Wali Kelas</option>
                            <?php 
                            // Reset pointer untuk available_wali
                            $available_wali->execute();
                            while($wali = $available_wali->fetch(PDO::FETCH_ASSOC)): 
                            ?>
                            <option value="<?php echo $wali['id']; ?>">
                                <?php echo htmlspecialchars($wali['nama_lengkap']); ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="update_kelas" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit modal
    const editModal = document.getElementById('editKelasModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const wali = button.getAttribute('data-wali');
            
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama_kelas').value = nama;
            document.getElementById('edit_wali_kelas_id').value = wali;
        });
    }
    
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