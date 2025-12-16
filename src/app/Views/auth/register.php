<?php
// filepath: app/Views/auth/register.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Tracking App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-container {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
        }
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .register-header h1 {
            color: #333;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .register-header p {
            color: #666;
            font-size: 0.95rem;
        }
        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
        }
        .form-control {
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .btn-register {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1.05rem;
            transition: transform 0.3s;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .invalid-feedback {
            display: block;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1><i class="fas fa-running"></i> Register</h1>
            <p>Daftar untuk mulai tracking aktivitas training Anda</p>
        </div>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?= base_url('register/store') ?>">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="username" class="form-label">
                    <i class="fas fa-user me-1"></i> Username
                </label>
                <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                       id="username" name="username" value="<?= old('username') ?>" 
                       placeholder="Pilih username unik" required>
                <?php if (isset($errors['username'])): ?>
                    <div class="invalid-feedback"><?= $errors['username'] ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-1"></i> Email
                </label>
                <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                       id="email" name="email" value="<?= old('email') ?>" 
                       placeholder="email@example.com" required>
                <?php if (isset($errors['email'])): ?>
                    <div class="invalid-feedback"><?= $errors['email'] ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-1"></i> Password
                </label>
                <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                       id="password" name="password" 
                       placeholder="Minimal 6 karakter" required>
                <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback"><?= $errors['password'] ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-4">
                <label for="password_confirm" class="form-label">
                    <i class="fas fa-lock me-1"></i> Konfirmasi Password
                </label>
                <input type="password" class="form-control <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                       id="password_confirm" name="password_confirm" 
                       placeholder="Ketik ulang password" required>
                <?php if (isset($errors['password_confirm'])): ?>
                    <div class="invalid-feedback"><?= $errors['password_confirm'] ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-register">
                <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
            </button>
        </form>
        
        <div class="login-link">
            Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>