<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = '请填写用户名和密码';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = '用户名或密码错误';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员登录</title>
    <link rel="stylesheet" href="/assets/style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.3rem;
            color: var(--text-secondary);
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            background: var(--bg-body);
            color: var(--text-primary);
            font-size: 1rem;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--accent);
        }
        .btn {
            width: 100%;
            padding: 0.7rem;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn:hover {
            background: var(--accent-hover);
        }
        .error {
            background: #fee;
            color: #c33;
            padding: 0.5rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            border: 1px solid #fcc;
        }
    </style>
</head>
<body>
    <div class="card login-card">
        <h1 class="card-title">🔐 管理员登录</h1>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>用户名</label>
                <input type="text" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label>密码</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">登录</button>
        </form>
        <p style="margin-top: 1rem; text-align: center; color: var(--text-muted); font-size: 0.9rem;">
            <a href="/index.php">← 返回首页</a>
        </p>
    </div>
</body>
</html>
