<?php
// Mulai session
session_start();

// Jika user sudah login, redirect ke dashboard
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit;
}

// Variabel untuk pesan error
$error = '';

// Proses login jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    // Validasi input
    if (empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi!';
    } else {
        // Data user (dalam aplikasi nyata, ini dari database)
        $valid_users = [
            'aca' => 'aca123',
        ];
        
        // Cek kredensial
        if (isset($valid_users[$username]) && $valid_users[$username] === $password) {
            // Login berhasil, simpan username ke session
            $_SESSION['username'] = $username;
            $_SESSION['login_time'] = date('Y-m-d H:i:s');
            
            // Redirect ke dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Username atau password salah!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Flower Market</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .login-box {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 40px var(--shadow-medium);
            max-width: 450px;
            width: 100%;
            border: 2px solid var(--pink-milk);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h1 {
            font-family: 'Dancing Script', cursive;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--gray-dark);
        }
        
        .form-input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid var(--pink-milk);
            border-radius: 50px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: var(--transition);
            box-sizing: border-box;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--baby-blue);
            box-shadow: 0 0 0 3px rgba(135, 206, 235, 0.1);
        }
        
        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #c33;
        }
        
        .login-btn {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--gray-medium);
        }
        
        .login-footer a {
            color: var(--baby-blue);
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        .demo-info {
            background: var(--blue-light);
            padding: 1rem;
            border-radius: 10px;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        
        .demo-info strong {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--gray-dark);
        }
        
        .demo-info code {
            background: white;
            padding: 2px 8px;
            border-radius: 5px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h1 class="text-gradient">🌸 Flower Market</h1>
                <p>Silakan login untuk mengakses dashboard</p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="error-message">
                    ⚠️ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-input" 
                        placeholder="Masukkan username"
                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                        required
                        autofocus
                    >
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Masukkan password"
                        required
                    >
                </div>
                
                <button type="submit" class="btn btn-primary login-btn">
                    Login
                </button>
            </form>
            
            <div class="demo-info">
                <strong>Demo Akun:</strong>
                <div>Username: <code>aca</code> | Password: <code>aca123</code></div>
            </div>
            
            <div class="login-footer">
                <a href="index.php">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>