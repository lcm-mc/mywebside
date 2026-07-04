-- 数据库初始化脚本
-- 创建数据库
CREATE DATABASE IF NOT EXISTS lcm_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lcm_blog;

-- 管理员表
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 博客文章表
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    excerpt TEXT,
    content LONGTEXT NOT NULL,
    tags VARCHAR(500),
    views INT DEFAULT 0,
    status ENUM('draft', 'published') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 网站配置表
CREATE TABLE IF NOT EXISTS site_config (
    id INT AUTO_INCREMENT PRIMARY KEY,
    config_key VARCHAR(50) NOT NULL UNIQUE,
    config_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 插入默认管理员 (密码: admin123)
INSERT INTO admins (username, password, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2UDheYZgzDy', 'lcm_mc@lcm-mc.top');

-- 插入默认配置
INSERT INTO site_config (config_key, config_value) VALUES
('site_name', 'LCM_MC'),
('site_title', 'LCM_MC · 个人站 & 博客'),
('site_description', '喜爱编程、二次元、游戏'),
('email', 'lcm_mc@lcm-mc.top'),
('qq', '2776039192'),
('wechat', 'lcm_mc'),
('whatsapp', 'https://api.whatsapp.com/qr/FP3VXE5E2IXII1'),
('github', 'https://github.com/lcm-mc'),
('youtube', 'https://youtube.com/@LCM_MC-Youtube'),
('bilibili', 'https://space.bilibili.com/3493268817971411'),
('weibo', ''),
('netease_music', '');

-- 插入示例博客文章
INSERT INTO posts (title, excerpt, content, tags, status) VALUES
('云墨笔记 15', '本次更新将代码存储移到了 gitee，并且修复了一些问题', '<p>本次更新将代码存储移到了 gitee，并且修复了一些问题。</p><h3>更新内容</h3><ul><li>代码存储迁移至 Gitee</li><li>修复了若干已知问题</li><li>优化了性能</li></ul><p>感谢大家的支持！</p>', 'Python,云墨笔记,软件', 'published');
