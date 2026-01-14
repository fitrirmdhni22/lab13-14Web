<?php
// Tampilkan pesan sukses registrasi jika ada
if (isset($_SESSION['registration_success'])) {
    $success = $_SESSION['registration_success'];
    unset($_SESSION['registration_success']); // Hapus session setelah ditampilkan
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses login sederhana
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validasi login - menerima username dan password apa pun
    if (!empty($username) && !empty($password)) {
        $_SESSION['is_login'] = true;
        $_SESSION['username'] = $username;
        
        // Jika username adalah admin, beri role admin, selain itu role user
        $_SESSION['role'] = ($username === 'admin') ? 'admin' : 'user';
        
        // Redirect ke halaman yang sesuai berdasarkan role
        $redirectPage = ($_SESSION['role'] === 'admin') ? 'user/list' : 'user/list';
        header('Location: /uas_web/index.php?page=' . $redirectPage);
        exit;
    } else {
        $error = 'Username dan password tidak boleh kosong';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - StockFlow</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
        
        .login-container {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(255, 107, 158, 0.15);
            width: 100%;
            max-width: 420px;
            position: relative;
            overflow: hidden;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--pink-primary), var(--pink-secondary));
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .login-header h1 {
            color: var(--pink-darker);
            margin-bottom: 0.75rem;
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .login-header p {
            color: #666;
            font-size: 0.95rem;
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
        
        .btn-login {
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
        
        .btn-login:hover {
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
        
        .forgot-password {
            font-size: 0.85rem;
            color: var(--pink-primary);
            text-decoration: none;
            float: right;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .login-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            color: #666;
        }
        
        .login-footer a {
            color: var(--pink-primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem; background: linear-gradient(90deg, #ff6b9e, #ff8fab); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">StockFlow</h1>
            <p style="font-size: 1.1rem; color: #666; margin-bottom: 0; position: relative; display: inline-block;">
                <span style="position: relative; z-index: 1; padding: 0 10px; background: white;">
                    <i class="fas fa-box" style="color: #ff6b9e; margin-right: 8px;"></i>Manajemen Stok Barang Terintegrasi
                </span>
                <span style="position: absolute; bottom: 5px; left: 0; right: 0; height: 8px; background: linear-gradient(90deg, rgba(255,107,158,0.2), rgba(255,143,171,0.2)); border-radius: 4px; z-index: 0;"></span>
            </p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
            </div>
            
            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <label for="password">Password</label>
                    <a href="index.php?page=auth/forgot-password" class="forgot-password">Lupa password?</a>
                </div>
                <div class="input-icon" style="position: relative;">
                    <i class="fas fa-lock" style="z-index: 2;"></i>
                    <i class="fas fa-eye toggle-password" style="position: absolute; left: 40px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #999; z-index: 2;"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required style="padding-left: 70px;">
                </div>
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i> Masuk ke Aplikasi
            </button>
            
            <div class="login-footer">
                Belum punya akun? <a href="index.php?page=auth/register">Daftar Sekarang</a>
                
                <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 8px; text-align: left; font-size: 0.85rem;">
                    <div style="margin-bottom: 10px; font-weight: 600; color: #555; text-align: center;">
                        <i class="fas fa-info-circle" style="color: var(--pink-primary);"></i> Informasi Login
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Login sebagai Admin:</span>
                        <span><strong>Username:</strong> admin | <strong>Password:</strong> admin123</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Login sebagai User:</span>
                        <span><strong>Username:</strong> user | <strong>Password:</strong> user123</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <script>
        // Fungsi untuk toggle password
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('.toggle-password');
            const password = document.querySelector('#password');
            
            togglePassword.addEventListener('click', function() {
                // Toggle tipe input
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // Toggle ikon mata
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>