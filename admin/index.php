<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

// 获取统计数据
$total_posts = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
$published_posts = $pdo->query("SELECT COUNT(*) FROM posts WHERE status = 'published'")->fetchColumn();
$draft_posts = $pdo->query("SELECT COUNT(*) FROM posts WHERE status = 'draft'")->fetchColumn();
$total_views = $pdo->query("SELECT SUM(views) FROM posts")->fetchColumn();

// 获取最新文章
$recent_posts = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台</title>
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 1.5rem;
            text-align: center;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 600;
            color: var(--accent);
        }
        .stat-label {
            color: var(--text-muted);
            margin-top: 0.3rem;
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

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= $total_posts ?></div>
            <div class="stat-label">总文章数</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $published_posts ?></div>
            <div class="stat-label">已发布</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $draft_posts ?></div>
            <div class="stat-label">草稿</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $total_views ?></div>
            <div class="stat-label">总浏览量</div>
        </div>
    </div>

    <div class="card">
        <h2 class="card-title">📝 最新文章</h2>
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
                <?php foreach ($recent_posts as $post): ?>
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
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
