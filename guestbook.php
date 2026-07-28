<?php
$current_page = 'guestbook';
require_once __DIR__ . '/includes/header.php';
$page_title = '留言板 - ' . getConfig('site_name');

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isRateLimited('guestbook_' . getClientIP(), 5, 60)) {
        $error_message = '留言过于频繁，请稍后再试。';
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if ($name === '' || $content === '') {
            $error_message = '昵称和留言内容不能为空。';
        } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = '邮箱格式不正确。';
        } else {
            if (addMessage($name, $email, $content, getClientIP())) {
                $success_message = '留言已发布，感谢你的支持！';
            } else {
                $error_message = '留言保存失败，请稍后再试。';
            }
        }
    }
}

$messages = getMessages(20);
?>

<div class="card">
    <h1 class="card-title">💬 留言板</h1>
    <p class="card-sub">留下你的想法、建议或问候，大家都能看到。</p>
    <hr>

    <?php if ($success_message): ?>
        <div class="alert success"><?= htmlspecialchars($success_message) ?></div>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <div class="alert error"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form method="post" class="guestbook-form">
        <div class="form-row">
            <label for="name">昵称</label>
            <input type="text" id="name" name="name" maxlength="50" required placeholder="请输入昵称">
        </div>
        <div class="form-row">
            <label for="email">邮箱（可选）</label>
            <input type="email" id="email" name="email" maxlength="100" placeholder="用于回复联系">
        </div>
        <div class="form-row">
            <label for="content">留言内容</label>
            <textarea id="content" name="content" rows="5" maxlength="1000" required placeholder="说点什么吧..."></textarea>
        </div>
        <button type="submit" class="submit-btn">发布留言</button>
    </form>
</div>

<div class="card">
    <h2 class="card-title" style="font-size: 1.3rem;">最近留言</h2>
    <?php if (empty($messages)): ?>
        <p class="text-muted" style="padding: 1rem 0;">还没有留言，欢迎成为第一个留下想法的人。</p>
    <?php else: ?>
        <div class="guestbook-list">
            <?php foreach ($messages as $message): ?>
                <div class="guestbook-item">
                    <div class="guestbook-head">
                        <strong><?= htmlspecialchars($message['name']) ?></strong>
                        <span><?= formatDate($message['created_at']) ?></span>
                    </div>
                    <div class="guestbook-content">
                        <?= nl2br(htmlspecialchars($message['content'])) ?>
                    </div>
                    <?php if (!empty($message['email'])): ?>
                        <div class="guestbook-email">邮箱：<?= htmlspecialchars($message['email']) ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
