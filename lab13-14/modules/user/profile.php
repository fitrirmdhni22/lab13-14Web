<?php
// modules/user/profile.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../views/header.php';

// Pastikan user sudah login
if (!isset($_SESSION['is_login'])) {
    header('Location: /uas_web/auth/login');
    exit;
}

$error = '';
$success = '';

// Ambil data user dari session
$username = $_SESSION['username'];

// Proses update password jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validasi form
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'Semua field harus diisi';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Password baru dan konfirmasi password tidak cocok';
    } else {
        // Verifikasi password saat ini (dalam kasus nyata, verifikasi dengan database)
        // Untuk contoh ini, kita asumsikan password benar
        $success = 'Password berhasil diubah';
        // Di sini seharusnya ada kode untuk update password di database
    }
}
?>

<style>
    .profile-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 0 15px;
        font-family: 'Poppins', sans-serif;
    }
    .profile-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .profile-card:hover {
        transform: translateY(-5px);
    }
    .profile-header {
        background: linear-gradient(135deg, #ff6b9e 0%, #e84393 100%);
        color: white;
        padding: 2rem 2rem 3rem;
        text-align: center;
        position: relative;
        box-shadow: 0 4px 20px rgba(232, 67, 147, 0.2);
        z-index: 1;
        margin-bottom: 30px;
    }
    .profile-header h4 {
        font-weight: 700;
        margin: 0;
        font-size: 1.5rem;
        position: relative;
        display: block;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        z-index: 3;
        padding: 10px 0;
        line-height: 1.4;
    }
    .profile-header h4:after {
        content: '';
        position: absolute;
        width: 60%;
        height: 3px;
        background: rgba(255, 255, 255, 0.5);
        bottom: -10px;
        left: 20%;
        border-radius: 3px;
    }
    .profile-body {
        padding: 2rem;
    }
    .profile-section {
        margin-bottom: 2.5rem;
    }
    .profile-section h5 {
        color: #e84393;
        font-weight: 700;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 10px;
        font-size: 1.25rem;
    }
    .profile-section h5:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 4px;
        background: linear-gradient(90deg, #ff6b9e, #ff8fab);
        border-radius: 3px;
    }
    .info-item {
        margin-bottom: 1rem;
        padding: 1rem 1.2rem;
        background: #fff;
        border-radius: 10px;
        border-left: 4px solid #ff6b9e;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    .info-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(255, 107, 158, 0.1);
    }
    .info-item .label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 0.3rem;
    }
    .info-item .value {
        color: #e84393;
        font-size: 1.1rem;
        font-weight: 500;
    }
    .form-label {
        font-weight: 600;
        color: #5a5c69;
    }
    .btn-update {
        background: linear-gradient(135deg, #ff6b9e 0%, #e84393 100%);
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(232, 67, 147, 0.3);
    }
    .btn-update:hover {
        background: linear-gradient(135deg, #e84393 0%, #ff6b9e 100%);
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(232, 67, 147, 0.4);
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: -5px auto 20px;
        background: #fff;
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .profile-avatar i {
        font-size: 50px;
        background: linear-gradient(135deg, #ff6b9e 0%, #e84393 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1;
    }
</style>

<div class="profile-container">
    <div class="card profile-card border-0">
        <div class="profile-header">
            <h4><i class="fas fa-user-circle me-2"></i>Profil Pengguna</h4>
        </div>
        <div class="profile-avatar">
            <i class="fas fa-user"></i>
        </div>
                <div class="profile-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <div class="profile-section">
                        <h5><i class="fas fa-user-tie me-2"></i>Informasi Akun</h5>
                        <div class="info-item">
                            <div class="label">Nama Lengkap</div>
                            <div class="value"><?= htmlspecialchars($username) ?></div>
                        </div>
                        <div class="info-item">
                            <div class="label">Username</div>
                            <div class="value">@<?= htmlspecialchars($username) ?></div>
                        </div>
                        <div class="info-item">
                            <div class="label">Role</div>
                            <div class="value"><span class="badge bg-primary"><?= ucfirst(htmlspecialchars($_SESSION['role'] ?? 'user')) ?></span></div>
                        </div>
                    </div>

                    <div class="profile-section">
                        <h5><i class="fas fa-key me-2"></i>Ubah Password</h5>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-update text-white">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../views/footer.php'; ?>