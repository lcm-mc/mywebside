<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
session_start();

$site_name = getConfig('site_name');
$site_title = getConfig('site_title');
$current_page = $current_page ?? 'home';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? $site_title) ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-logo"><?= htmlspecialchars($site_name) ?></div>
        <div class="nav-links">
            <a href="/index.php" class="<?= $current_page === 'home' ? 'active' : '' ?>">首页</a>
            <a href="/blog.php" class="<?= $current_page === 'blog' ? 'active' : '' ?>">博客</a>
            <a href="/about.php" class="<?= $current_page === 'about' ? 'active' : '' ?>">关于</a>
            <a href="/contact.php" class="<?= $current_page === 'contact' ? 'active' : '' ?>">联系</a>
            <button class="theme-toggle" id="themeToggle">🌓 主题</button>
        </div>
    </nav>
