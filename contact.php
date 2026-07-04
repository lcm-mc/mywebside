<?php
$current_page = 'contact';
require_once __DIR__ . '/includes/header.php';
$page_title = '联系 - ' . getConfig('site_name');
?>

<div class="card">
    <h1 class="card-title">📬 联系方式</h1>
    <p class="card-sub">欢迎交流，一起聊聊天</p>
    <div style="display: flex; flex-direction: column; gap: 0.6rem; margin-top: 0.8rem;">
        <div class="contact-row">
            <strong>📧 邮箱</strong>
            <a href="mailto:<?= htmlspecialchars(getConfig('email')) ?>"><?= htmlspecialchars(getConfig('email')) ?></a>
        </div>
        <div class="contact-row">
            <strong>🐧 QQ</strong>
            <span><?= htmlspecialchars(getConfig('qq')) ?></span>
        </div>
        <div class="contact-row">
            <strong>💬 微信</strong>
            <span><?= htmlspecialchars(getConfig('wechat')) ?></span>
        </div>
        <?php if (getConfig('whatsapp')): ?>
        <div class="contact-row">
            <strong>📱 WhatsApp</strong>
            <a href="<?= htmlspecialchars(getConfig('whatsapp')) ?>" target="_blank">点击跳转到 WhatsApp</a>
        </div>
        <?php endif; ?>
    </div>
    <hr>
    <h3 style="margin-bottom: 0.2rem;">🌐 社交媒体</h3>
    <div class="social-links">
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
    <p style="margin-top: 0.8rem; color: var(--text-muted);">（部分社交账号链接待完善，欢迎通过邮箱或 QQ 联系）</p>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
