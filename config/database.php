<?php
// 数据库配置
define('DB_HOST', 'localhost');
define('DB_NAME', 'lcm_blog');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Cloudflare Turnstile
define('TURNSTILE_SITE_KEY', '0x4AAAAAADv9d1bRTyZkKTZG');
define('TURNSTILE_SECRET_KEY', '0x4AAAAAADv9d8goFQLGTamVlPc63l1pa7c');

// 数据库连接
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}

// 获取站点配置
function getConfig($key) {
    global $pdo;
    static $config = null;
    
    if ($config === null) {
        $stmt = $pdo->query("SELECT config_key, config_value FROM site_config");
        $config = [];
        while ($row = $stmt->fetch()) {
            $config[$row['config_key']] = $row['config_value'];
        }
    }
    
    return $config[$key] ?? '';
}
