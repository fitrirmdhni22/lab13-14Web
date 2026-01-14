<?php
// header.php - structure only, title set by modules
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manajemen Barang</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Bootstrap JS Bundle dengan Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/uas_web/assets/css/style.css">
    
    <style>
        :root {
            --pink-primary: #ff6b9e;
            --pink-secondary: #ff8fab;
            --pink-light: #ffd7e1;
            --pink-lighter: #fff0f5;
            --pink-dark: #e84393;
            --pink-darker: #c92a7f;
        }
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<?php if (isset($_SESSION['is_login'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-pink">
    <div class="container">
        <a class="navbar-brand" href="index.php">Manajemen Barang</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <?php if (isset($_SESSION['is_login'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=user/profile">
                            <i class="fas fa-user me-1"></i> Profil
                        </a>
                    </li>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=user/list">
                                <i class="fas fa-users me-1"></i> Kelola Pengguna
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <?php if (isset($_SESSION['is_login'])): ?>
                <div class="d-flex align-items-center">
                    <span class="navbar-text me-3 d-none d-sm-inline">
                        <i class="fas fa-user-circle me-1"></i> 
                        <span class="text-white"><?= htmlspecialchars($_SESSION['username']) ?></span>
                        <small class="text-white-50 ms-1">(<?= htmlspecialchars($_SESSION['role']) ?>)</small>
                    </span>
                    
                    <a href="index.php?page=auth/logout" 
                       class="btn btn-outline-light btn-sm" 
                       onclick="return confirm('Yakin ingin logout?')">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php endif; ?>

<div class="container main-content">