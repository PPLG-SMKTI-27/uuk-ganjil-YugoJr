<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Sistem Perizinan Siswa'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
            --info: #17a2b8;
            --light: #ecf0f1;
            --dark: #343a40;
        }
        
        /* Sidebar Styles */
        .sidebar {
            background: var(--primary);
            color: white;
            min-height: 100vh;
            padding: 0;
            transition: all 0.3s;
            position: fixed;
            width: 250px;
            z-index: 1000;
        }
        
        .sidebar.collapsed {
            width: 70px;
        }
        
        .sidebar.collapsed .sidebar-brand h4,
        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .sidebar-menu span {
            display: none;
        }
        
        .sidebar.collapsed .sidebar-brand {
            padding: 20px 10px;
        }
        
        .sidebar.collapsed .sidebar-menu a {
            padding: 15px 10px;
            text-align: center;
        }
        
        .sidebar.collapsed .sidebar-menu i {
            margin-right: 0;
            font-size: 1.2rem;
        }
        
        .sidebar-brand {
            padding: 20px;
            background: rgba(0,0,0,0.1);
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
        }
        
        .sidebar-brand h4 {
            margin: 0;
            font-weight: 600;
            font-size: 1.2rem;
        }
        
        .sidebar-brand small {
            opacity: 0.8;
            font-size: 0.8rem;
        }
        
        .toggle-sidebar {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 5px;
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
            position: relative;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: var(--secondary);
            color: white;
            padding-left: 25px;
        }
        
        .sidebar-menu a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--success);
        }
        
        .sidebar-menu i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }
        
        .sidebar-menu .badge {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        /* Main Content Styles */
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
            margin-left: 250px;
            transition: all 0.3s;
        }
        
        .main-content.expanded {
            margin-left: 70px;
        }
        
        /* Navbar Styles */
        .top-navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 0.8rem 1rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: var(--primary);
        }
        
        .user-dropdown .dropdown-toggle {
            border: none;
            background: none;
            color: var(--dark);
        }
        
        .user-dropdown .dropdown-toggle:hover {
            color: var(--secondary);
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--secondary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 8px;
        }
        
        /* Notification Bell */
        .notification-bell {
            position: relative;
            margin-right: 15px;
            cursor: pointer;
        }
        
        .notification-bell .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger);
            border: 2px solid white;
        }
        
        /* Breadcrumb */
        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 0;
        }
        
        .breadcrumb-item a {
            text-decoration: none;
            color: var(--secondary);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar .sidebar-brand h4,
            .sidebar .sidebar-text,
            .sidebar .sidebar-menu span {
                display: none;
            }
            
            .sidebar .sidebar-brand {
                padding: 20px 10px;
            }
            
            .sidebar .sidebar-menu a {
                padding: 15px 10px;
                text-align: center;
            }
            
            .sidebar .sidebar-menu i {
                margin-right: 0;
                font-size: 1.2rem;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }
        
        /* Common Component Styles */
        .stat-card {
            border-radius: 10px;
            border: none;
            transition: transform 0.3s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .badge-pending { background: var(--warning); }
        .badge-approved { background: var(--success); }
        .badge-rejected { background: var(--danger); }
        .badge-info { background: var(--info); }
        .badge-primary { background: var(--primary); }
        
        .btn-primary {
            background: var(--secondary);
            border-color: var(--secondary);
        }
        
        .btn-primary:hover {
            background: #2980b9;
            border-color: #2980b9;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar px-0" id="sidebar">
                <div class="sidebar-brand">
                    <h4><i class="fas fa-user-graduate"></i> Sistem Perizinan</h4>
                    <small class="sidebar-text">
                        <?php 
                        if(isset($_SESSION['role'])) {
                            switch($_SESSION['role']) {
                                case 'admin': echo 'Administrator'; break;
                                case 'wali': echo 'Wali Kelas'; break;
                                case 'murid': echo 'Murid'; break;
                                default: echo 'User';
                            }
                        }
                        ?>
                    </small>
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                
                <ul class="sidebar-menu">
                    <?php if(isset($_SESSION['role'])): ?>
                        <!-- Dashboard Link -->
                        <li>
                            <a href="index.php?action=<?php echo $_SESSION['role']; ?>_dashboard" 
                               class="<?php echo strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active' : ''; ?>">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <!-- Admin Menu -->
                        <?php if($_SESSION['role'] == 'admin'): ?>
                            <li>
                                <a href="index.php?action=admin_users" 
                                   class="<?php echo strpos($_SERVER['REQUEST_URI'], 'users') !== false ? 'active' : ''; ?>">
                                    <i class="fas fa-users"></i>
                                    <span>Manajemen User</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?action=admin_kelas" 
                                   class="<?php echo strpos($_SERVER['REQUEST_URI'], 'kelas') !== false ? 'active' : ''; ?>">
                                    <i class="fas fa-school"></i>
                                    <span>Data Kelas</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?action=admin_laporan" 
                                   class="<?php echo strpos($_SERVER['REQUEST_URI'], 'laporan') !== false ? 'active' : ''; ?>">
                                    <i class="fas fa-chart-bar"></i>
                                    <span>Laporan</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Wali Menu -->
                        <?php if($_SESSION['role'] == 'wali'): ?>
                            <li>
                                <a href="index.php?action=wali_perizinan" 
                                   class="<?php echo strpos($_SERVER['REQUEST_URI'], 'perizinan') !== false ? 'active' : ''; ?>">
                                    <i class="fas fa-clipboard-list"></i>
                                    <span>Kelola Perizinan</span>
                                    <?php 
                                    // Hitung perizinan pending
                                    if(isset($pending_count) && $pending_count > 0): 
                                    ?>
                                    <span class="badge badge-pending"><?php echo $pending_count; ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?action=wali_siswa" 
                                   class="<?php echo strpos($_SERVER['REQUEST_URI'], 'siswa') !== false ? 'active' : ''; ?>">
                                    <i class="fas fa-user-graduate"></i>
                                    <span>Data Siswa</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Murid Menu -->
                        <?php if($_SESSION['role'] == 'murid'): ?>
                            <li>
                                <a href="index.php?action=ajukan_izin" 
                                   class="<?php echo strpos($_SERVER['REQUEST_URI'], 'ajukan_izin') !== false ? 'active' : ''; ?>">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Ajukan Izin</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?action=riwayat_izin" 
                                   class="<?php echo strpos($_SERVER['REQUEST_URI'], 'riwayat') !== false ? 'active' : ''; ?>">
                                    <i class="fas fa-history"></i>
                                    <span>Riwayat Izin</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Common Menu -->
                        <li>
                            <a href="index.php?action=profile" 
                               class="<?php echo strpos($_SERVER['REQUEST_URI'], 'profile') !== false ? 'active' : ''; ?>">
                                <i class="fas fa-user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="index.php?action=logout" 
                               onclick="return confirm('Yakin ingin logout?')">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content px-0" id="mainContent">
                <!-- Top Navbar -->
                <nav class="top-navbar">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div>
                                <span class="navbar-brand">
                                    <?php echo isset($page_title) ? $page_title : 'Dashboard'; ?>
                                </span>
                                <?php if(isset($breadcrumbs)): ?>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb d-inline">
                                        <?php foreach($breadcrumbs as $breadcrumb): ?>
                                            <?php if(isset($breadcrumb['url'])): ?>
                                                <li class="breadcrumb-item">
                                                    <a href="<?php echo $breadcrumb['url']; ?>"><?php echo $breadcrumb['text']; ?></a>
                                                </li>
                                            <?php else: ?>
                                                <li class="breadcrumb-item active"><?php echo $breadcrumb['text']; ?></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ol>
                                </nav>
                                <?php endif; ?>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <!-- Notification Bell -->
                                <div class="notification-bell">
                                    <i class="fas fa-bell fa-lg text-muted"></i>
                                    <span class="badge">3</span>
                                </div>
                                
                                <!-- User Dropdown -->
                                <div class="dropdown user-dropdown">
                                    <button class="btn dropdown-toggle d-flex align-items-center" type="button" 
                                            data-bs-toggle="dropdown">
                                        <div class="user-avatar">
                                            <?php 
                                            if(isset($_SESSION['nama_lengkap'])) {
                                                echo strtoupper(substr($_SESSION['nama_lengkap'], 0, 1));
                                            }
                                            ?>
                                        </div>
                                        <span class="d-none d-md-inline">
                                            <?php echo isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'User'; ?>
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="index.php?action=profile">
                                                <i class="fas fa-user me-2"></i>Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-cog me-2"></i>Settings
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="index.php?action=logout">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                
                <!-- Main Content Area -->
                <div class="container-fluid mt-4">