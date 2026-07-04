<?php
$current_page = 'blog';
require_once __DIR__ . '/includes/header.php';
$page_title = '博客 - ' . getConfig('site_name');

// 分页
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 10;
$offset = ($page - 1) * $per_page;
$total = getPostCount();
$total_pages = ceil($total / $per_page);
$posts = getPosts($per_page, $offset);
?>

<div class="card">
    <h1 class="card-title">📝 博客</h1>
    <p class="card-sub">一些想法、技术笔记与日常</p>
    <hr>

    <?php if (empty($posts)): ?>
        <p style="color: var(--text-muted); text-align: center; padding: 2rem 0;">暂无文章</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div class="blog-item">
                <div class="blog-title">
                    <a href="/post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                </div>
                <div class="blog-meta">
                    <?= formatDate($post['created_at']) ?> · 👁 <?= $post['views'] ?>
                </div>
                <div class="blog-excerpt"><?= htmlspecialchars($post['excerpt']) ?></div>
                <?php if ($post['tags']): ?>
                    <div style="margin-top: 0.3rem;">
                        <?php foreach (parseTags($post['tags']) as $tag): ?>
                            <span class="tag"><?= htmlspecialchars($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if ($total_pages > 1): ?>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>">← 上一页</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <?php if ($i === $page): ?>
            <span class="current"><?= $i ?></span>
        <?php else: ?>
            <a href="?page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1 ?>">下一页 →</a>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
