<?php
$current_page = 'blog';
require_once __DIR__ . '/includes/header.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: /blog.php');
    exit;
}

$post = getPost($id);
if (!$post) {
    header('Location: /blog.php');
    exit;
}

incrementViews($id);
$page_title = $post['title'] . ' - ' . getConfig('site_name');
?>

<div class="card">
    <h1 class="card-title"><?= htmlspecialchars($post['title']) ?></h1>
    <div class="blog-meta">
        📅 <?= formatDate($post['created_at']) ?>
        · 👁 <?= $post['views'] ?> 次阅读
        <?php if ($post['updated_at'] !== $post['created_at']): ?>
            · ✏️ 最后修改 <?= formatDate($post['updated_at']) ?>
        <?php endif; ?>
    </div>
    <?php if ($post['tags']): ?>
        <div style="margin: 0.5rem 0;">
            <?php foreach (parseTags($post['tags']) as $tag): ?>
                <span class="tag"><?= htmlspecialchars($tag) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <hr>
    <div class="post-content">
        <?= $post['content'] ?>
    </div>
</div>

<div style="text-align: center; margin: 1.5rem 0;">
    <a href="/blog.php" style="padding: 0.5rem 1.5rem; border: 1px solid var(--border-color); border-radius: var(--radius);">← 返回博客</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
