<?php
$current_page = 'about';
$page_title = '关于 - ' . getConfig('site_name');
require_once __DIR__ . '/includes/header.php';
?>

<div class="card">
    <h1 class="card-title">💡 关于这个站点</h1>
    <p style="color: var(--text-secondary);">
        个人网站 + 博客，使用 PHP + MySQL 构建<br>
        前端采用简洁的卡片式设计，支持亮色/暗色主题切换
    </p>
    <hr>
    <h3 style="margin-bottom: 0.5rem;">🛠️ 技术栈</h3>
    <ul style="color: var(--text-secondary); padding-left: 1.5rem; line-height: 2;">
        <li><strong>后端：</strong>PHP + PDO</li>
        <li><strong>数据库：</strong>MySQL</li>
        <li><strong>前端：</strong>HTML5 + CSS3 + 原生 JavaScript</li>
        <li><strong>特性：</strong>响应式设计、亮/暗主题、文章管理后台</li>
    </ul>
    <hr>
    <h3 style="margin-bottom: 0.5rem;">📝 关于博客</h3>
    <p style="color: var(--text-secondary);">
        这里记录我的想法、技术笔记与日常。分享编程经验、项目更新和个人思考。
    </p>
    <hr>
    <h3 style="margin-bottom: 0.5rem;">🎯 兴趣</h3>
    <p style="color: var(--text-secondary);">
        <?= htmlspecialchars(getConfig('site_description')) ?>
    </p>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
