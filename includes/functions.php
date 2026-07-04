<?php
// 公共函数

// 获取文章列表
function getPosts($limit = 10, $offset = 0) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE status = 'published' ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// 获取文章总数
function getPostCount() {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM posts WHERE status = 'published'");
    return $stmt->fetchColumn();
}

// 获取单篇文章
function getPost($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND status = 'published'");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// 增加浏览量
function incrementViews($id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE posts SET views = views + 1 WHERE id = ?");
    $stmt->execute([$id]);
}

// 格式化日期
function formatDate($date) {
    return date('Y.m.d · H:i', strtotime($date));
}

// 解析标签
function parseTags($tags) {
    if (empty($tags)) return [];
    return array_map('trim', explode(',', $tags));
}

// 生成摘要
function generateExcerpt($content, $length = 100) {
    $text = strip_tags($content);
    if (mb_strlen($text) > $length) {
        return mb_substr($text, 0, $length) . '...';
    }
    return $text;
}

// 检查登录状态
function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

// 要求登录
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}
