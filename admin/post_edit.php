<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

$id = intval($_GET['id'] ?? 0);
$post = null;

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch();
    if (!$post) {
        header('Location: posts.php');
        exit;
    }
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $tags = trim($_POST['tags'] ?? '');
    $status = $_POST['status'] ?? 'published';
    
    if (empty($title) || empty($content)) {
        $error = '标题和内容不能为空';
    } else {
        if ($id > 0) {
            // 更新文章
            $stmt = $pdo->prepare("UPDATE posts SET title=?, excerpt=?, content=?, tags=?, status=? WHERE id=?");
            $stmt->execute([$title, $excerpt, $content, $tags, $status, $id]);
            $success = '文章已更新';
        } else {
            // 新建文章
            $stmt = $pdo->prepare("INSERT INTO posts (title, excerpt, content, tags, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $excerpt, $content, $tags, $status]);
            $id = $pdo->lastInsertId();
            $success = '文章已创建';
            
            // 重新获取文章数据
            $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
            $stmt->execute([$id]);
            $post = $stmt->fetch();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id > 0 ? '编辑文章' : '写文章' ?></title>
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
            margin-bottom: 1.2rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            color: var(--text-secondary);
            font-weight: 500;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            background: var(--bg-body);
            color: var(--text-primary);
            font-size: 1rem;
            font-family: inherit;
        }
        .form-group textarea {
            min-height: 400px;
            resize: vertical;
            font-family: 'Courier New', monospace;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--accent);
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
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
        .btn-secondary {
            background: var(--text-muted);
        }
        .btn-secondary:hover {
            background: var(--text-secondary);
        }
        .alert {
            padding: 0.8rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .button-group {
            display: flex;
            gap: 0.8rem;
            margin-top: 1rem;
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

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="card">
        <h2 class="card-title"><?= $id > 0 ? '✏️ 编辑文章' : '✏️ 写文章' ?></h2>
        <form method="POST">
            <div class="form-group">
                <label>标题 *</label>
                <input type="text" name="title" value="<?= htmlspecialchars($post['title'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label>摘要</label>
                <input type="text" name="excerpt" value="<?= htmlspecialchars($post['excerpt'] ?? '') ?>" placeholder="文章摘要，留空则自动生成">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>标签（用逗号分隔）</label>
                    <input type="text" name="tags" value="<?= htmlspecialchars($post['tags'] ?? '') ?>" placeholder="例如: PHP,博客,技术">
                </div>
                <div class="form-group">
                    <label>状态</label>
                    <select name="status">
                        <option value="published" <?= ($post['status'] ?? '') === 'published' ? 'selected' : '' ?>>已发布</option>
                        <option value="draft" <?= ($post['status'] ?? '') === 'draft' ? 'selected' : '' ?>>草稿</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>内容（支持 HTML）*</label>
                <textarea name="content" required><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn"><?= $id > 0 ? '更新文章' : '创建文章' ?></button>
                <a href="posts.php" class="btn btn-secondary">取消</a>
                <?php if ($id > 0): ?>
                    <a href="/post.php?id=<?= $id ?>" target="_blank" class="btn btn-secondary">查看文章</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</body>
</html>
