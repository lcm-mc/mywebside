<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

// 删除文章
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: posts.php?deleted=1');
    exit;
}

// 获取所有文章
$posts = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文章管理</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        th {
            background: var(--bg-body);
            font-weight: 600;
            color: var(--text-secondary);
        }
        .status-badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-published {
            background: #d4edda;
            color: #155724;
        }
        .status-draft {
            background: #fff3cd;
            color: #856404;
        }
        .action-links a {
            margin-right: 0.8rem;
        }
        .delete-link {
            color: #c33 !important;
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

    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">文章已删除</div>
    <?php endif; ?>

    <div class="card">
        <h2 class="card-title">📝 文章管理</h2>
        <table>
            <thead>
                <tr>
                    <th>标题</th>
                    <th>状态</th>
                    <th>浏览</th>
                    <th>日期</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= htmlspecialchars($post['title']) ?></td>
                    <td>
                        <span class="status-badge status-<?= $post['status'] ?>">
                            <?= $post['status'] === 'published' ? '已发布' : '草稿' ?>
                        </span>
                    </td>
                    <td><?= $post['views'] ?></td>
                    <td><?= date('Y-m-d', strtotime($post['created_at'])) ?></td>
                    <td class="action-links">
                        <a href="post_edit.php?id=<?= $post['id'] ?>">编辑</a>
                        <a href="/post.php?id=<?= $post['id'] ?>" target="_blank">查看</a>
                        <a href="?delete=<?= $post['id'] ?>" class="delete-link" onclick="return confirm('确定要删除这篇文章吗？')">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
