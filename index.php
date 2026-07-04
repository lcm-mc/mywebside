<?php
$current_page = 'home';
require_once __DIR__ . '/includes/header.php';
$page_title = getConfig('site_title');

// 获取最新文章
$latest_posts = getPosts(5, 0);
?>

<div class="card">
    <h1 class="card-title">👋 你好，我是 <?= htmlspecialchars(getConfig('site_name')) ?></h1>
    <p style="font-size: 1.05rem; color: var(--text-secondary);">
        <?= htmlspecialchars(getConfig('site_description')) ?>
    </p>
    <hr>
    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">📧 邮箱</span>
            <span class="info-value"><?= htmlspecialchars(getConfig('email')) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">🐧 QQ</span>
            <span class="info-value"><?= htmlspecialchars(getConfig('qq')) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">💬 微信</span>
            <span class="info-value"><?= htmlspecialchars(getConfig('wechat')) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">📱 WhatsApp</span>
            <span class="info-value">
                <?php if (getConfig('whatsapp')): ?>
                    <a href="<?= htmlspecialchars(getConfig('whatsapp')) ?>" target="_blank">点击跳转</a>
                <?php else: ?>
                    未设置
                <?php endif; ?>
            </span>
        </div>
    </div>
    <div class="social-links mt-1">
        <?php if (getConfig('github')): ?>
            <a href="<?= htmlspecialchars(getConfig('github')) ?>" target="_blank">🐙 GitHub</a>
        <?php endif; ?>
        <?php if (getConfig('youtube')): ?>
            <a href="<?= htmlspecialchars(getConfig('youtube')) ?>" target="_blank">▶️ YouTube</a>
        <?php endif; ?>
        <?php if (getConfig('bilibili')): ?>
            <a href="<?= htmlspecialchars(getConfig('bilibili')) ?>" target="_blank">📺 BiliBili</a>
        <?php endif; ?>
        <?php if (getConfig('weibo')): ?>
            <a href="<?= htmlspecialchars(getConfig('weibo')) ?>" target="_blank">📱 微博</a>
        <?php endif; ?>
        <?php if (getConfig('netease_music')): ?>
            <a href="<?= htmlspecialchars(getConfig('netease_music')) ?>" target="_blank">🎵 网易云</a>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($latest_posts)): ?>
<div class="card">
    <h2 class="card-title">📝 最新文章</h2>
    <?php foreach ($latest_posts as $post): ?>
        <div class="blog-item">
            <div class="blog-title">
                <a href="/post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a>
            </div>
            <div class="blog-meta"><?= formatDate($post['created_at']) ?> · 👁 <?= $post['views'] ?></div>
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
    <div style="margin-top: 1rem; text-align: right;">
        <a href="/blog.php">查看所有文章 →</a>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
