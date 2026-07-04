<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $configs = [
        'site_name' => trim($_POST['site_name'] ?? ''),
        'site_title' => trim($_POST['site_title'] ?? ''),
        'site_description' => trim($_POST['site_description'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'qq' => trim($_POST['qq'] ?? ''),
        'wechat' => trim($_POST['wechat'] ?? ''),
        'whatsapp' => trim($_POST['whatsapp'] ?? ''),
        'github' => trim($_POST['github'] ?? ''),
        'youtube' => trim($_POST['youtube'] ?? ''),
        'bilibili' => trim($_POST['bilibili'] ?? ''),
        'weibo' => trim($_POST['weibo'] ?? ''),
        'netease_music' => trim($_POST['netease_music'] ?? ''),
    ];
    
    foreach ($configs as $key => $value) {
        $stmt = $pdo->prepare("UPDATE site_config SET config_value = ? WHERE config_key = ?");
        $stmt->execute([$value, $key]);
    }
    
    $success = '配置已更新';
}

// 获取当前配置
$current_config = [];
$stmt = $pdo->query("SELECT config_key, config_value FROM site_config");
while ($row = $stmt->fetch()) {
    $current_config[$row['config_key']] = $row['config_value'];
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>站点配置</title>
    <link rel="stylesheet" href="/assets/style.css">
    <style>
        .admin-nav {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .admin-nav a {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            color: var(--text-secondary);
        }
        .admin-nav a:hover {
            background: var(--border-color);
            text-decoration: none;
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
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            background: var(--bg-body);
            color: var(--text-primary);
            font-size: 1rem;
        }
        .form-group textarea {
            min-height: 80px;
            resize: vertical;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--accent);
        }
        .form-section {
            margin-bottom: 2rem;
        }
        .form-section h3 {
            margin-bottom: 1rem;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }
        .btn {
            padding: 0.7rem 1.5rem;
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
        .alert {
            padding: 0.8rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-logo">管理后台</div>
        <div class="nav-links">
            <a href="/index.php">查看网站</a>
            <a href="logout.php">退出登录</a>
        </div>
    </nav>

    <div class="admin-nav">
        <a href="index.php">📊 概览</a>
        <a href="posts.php">📝 文章管理</a>
        <a href="post_edit.php">✏️ 写文章</a>
        <a href="config.php">⚙️ 站点配置</a>
    </div>

    <?php if ($success): ?>
        <div class="alert"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="card">
        <h2 class="card-title">⚙️ 站点配置</h2>
        <form method="POST">
            <div class="form-section">
                <h3>基本信息</h3>
                <div class="form-group">
                    <label>站点名称</label>
                    <input type="text" name="site_name" value="<?= htmlspecialchars($current_config['site_name'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>站点标题</label>
                    <input type="text" name="site_title" value="<?= htmlspecialchars($current_config['site_title'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>站点描述</label>
                    <textarea name="site_description"><?= htmlspecialchars($current_config['site_description'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3>联系方式</h3>
                <div class="form-group">
                    <label>邮箱</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($current_config['email'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>QQ</label>
                    <input type="text" name="qq" value="<?= htmlspecialchars($current_config['qq'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>微信</label>
                    <input type="text" name="wechat" value="<?= htmlspecialchars($current_config['wechat'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>WhatsApp 链接</label>
                    <input type="url" name="whatsapp" value="<?= htmlspecialchars($current_config['whatsapp'] ?? '') ?>">
                </div>
            </div>

            <div class="form-section">
                <h3>社交媒体链接</h3>
                <div class="form-group">
                    <label>GitHub</label>
                    <input type="url" name="github" value="<?= htmlspecialchars($current_config['github'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>YouTube</label>
                    <input type="url" name="youtube" value="<?= htmlspecialchars($current_config['youtube'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>BiliBili</label>
                    <input type="url" name="bilibili" value="<?= htmlspecialchars($current_config['bilibili'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>微博</label>
                    <input type="url" name="weibo" value="<?= htmlspecialchars($current_config['weibo'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>网易云音乐</label>
                    <input type="url" name="netease_music" value="<?= htmlspecialchars($current_config['netease_music'] ?? '') ?>">
                </div>
            </div>

            <button type="submit" class="btn">保存配置</button>
        </form>
    </div>
</body>
</html>
