<?php
// Inisialisasi variabel
$error = '';
$success = '';
$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validasi
    if (empty($password) || empty($confirm_password)) {
        $error = 'Semua field harus diisi';
    } elseif ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter';
    } else {
        // Di sini seharusnya ada proses:
        // 1. Verifikasi token
        // 2. Update password di database
        // 3. Hapus token yang sudah digunakan
        
        // Untuk saat ini, kita hanya menampilkan pesan sukses
        $success = 'Password berhasil direset. Silakan login dengan password baru Anda.';
        
        // Redirect ke halaman login setelah 3 detik
        header('Refresh: 3; URL=index.php?page=auth/login');
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - StockFlow</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --pink-primary: #ff6b9e;
            --pink-secondary: #ff8fab;
            --pink-light: #ffd7e1;
            --pink-lighter: #fff0f5;
            --pink-dark: #e84393;
            --pink-darker: #c92a7f;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #fff0f5 0%, #ffd7e1 100%);
            margin: 0;
            padding: 20px;
        }
        
        .reset-container {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(255, 107, 158, 0.15);
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
        }
        
        .reset-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--pink-primary), var(--pink-secondary));
        }
        
        .reset-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .reset-header h1 {
            color: var(--pink-darker);
            margin-bottom: 0.75rem;
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .reset-header p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 16px 14px 45px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }
        
        .form-control:focus {
            border-color: var(--pink-primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 158, 0.2);
            outline: none;
            background-color: white;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        
        .btn-reset {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, var(--pink-primary), var(--pink-secondary));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
            box-shadow: 0 4px 15px rgba(255, 107, 158, 0.3);
        }
        
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 158, 0.4);
        }
        
        .error-message {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 1.5rem;
            padding: 10px;
            background-color: #fde8e8;
            border-radius: 6px;
            font-size: 0.9rem;
        }
        
        .success-message {
            color: #27ae60;
            text-align: center;
            margin-bottom: 1.5rem;
            padding: 10px;
            background-color: #e8f8f0;
            border-radius: 6px;
            font-size: 0.9rem;
        }
        
        .password-requirements {
            font-size: 0.8rem;
            color: #666;
            margin-top: 5px;
            padding-left: 5px;
        }
        
        .back-to-login {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.95rem;
            color: #666;
        }
        
        .back-to-login a {
            color: var(--pink-primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-to-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="reset-header">
            <h1>Reset Password</h1>
            <p>Masukkan password baru Anda</p>
            
            <?php if ($error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
        </div>
        
        <form method="POST" action="" class="reset-form">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            
            <div class="form-group">
                <label for="password">Password Baru</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <div class="password-requirements">
                    <i class="fas fa-info-circle"></i> Minimal 6 karakter
                </div>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password Baru</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            
            <button type="submit" class="btn-reset">
                <i class="fas fa-sync-alt" style="margin-right: 8px;"></i> Reset Password
            </button>
            
            <div class="back-to-login">
                <p>Ingat password? <a href="index.php?page=auth/login">Kembali ke Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
