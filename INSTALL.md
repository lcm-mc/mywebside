# LCM_MC 个人博客 - 安装说明

## 项目结构
```
d:\Myside\
├── index.php              # 首页
├── blog.php               # 博客列表页
├── post.php               # 文章详情页
├── about.php              # 关于页面
├── contact.php            # 联系页面
├── database.sql           # 数据库初始化脚本
├── config/
│   └── database.php       # 数据库配置
├── includes/
│   ├── header.php         # 公共头部
│   ├── footer.php         # 公共底部
│   └── functions.php      # 公共函数
├── assets/
│   └── style.css          # 样式文件
└── admin/
    ├── login.php          # 管理员登录
    ├── index.php          # 后台首页
    ├── posts.php          # 文章管理
    ├── post_edit.php      # 编辑文章
    ├── config.php         # 站点配置
    └── logout.php         # 退出登录
```

## 安装步骤

### 1. 配置 Web 服务器
确保你的系统已安装 PHP 和 MySQL，并配置好 Web 服务器（Apache/Nginx）。

### 2. 导入数据库
```bash
# 登录 MySQL
mysql -u root -p

# 执行初始化脚本
source d:/Myside/database.sql
```

或者使用 phpMyAdmin：
1. 访问 phpMyAdmin
2. 导入 `database.sql` 文件

### 3. 配置数据库连接
编辑 `config/database.php`，修改数据库连接信息：
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'lcm_blog');
define('DB_USER', 'root');      // 修改为你的数据库用户名
define('DB_PASS', '');          // 修改为你的数据库密码
```

### 4. 设置 Web 服务器

#### Apache 配置示例
```apache
<VirtualHost *:80>
    ServerName lcm-blog.local
    DocumentRoot "d:/Myside"
    
    <Directory "d:/Myside">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### PHP 内置服务器（仅用于测试）
```bash
cd d:\Myside
php -S localhost:8000
```

然后访问：http://localhost:8000

### 5. 访问网站

**前台页面：**
- 首页：http://localhost/
- 博客：http://localhost/blog.php
- 关于：http://localhost/about.php
- 联系：http://localhost/contact.php

**后台管理：**
- 管理后台：http://localhost/admin/login.php
- 默认账号：`admin`
- 默认密码：`admin123`

⚠️ **重要：首次登录后请立即修改密码！**

## 功能特性

### 前台功能
- ✅ 响应式设计，支持移动端
- ✅ 亮色/暗色主题切换
- ✅ 博客文章列表（分页）
- ✅ 文章详情页（浏览量统计）
- ✅ 标签显示
- ✅ 个人信息展示
- ✅ 社交媒体链接
- ✅ 联系方式页面

### 后台功能
- ✅ 管理员登录/登出
- ✅ 文章管理（增删改查）
- ✅ 文章状态（已发布/草稿）
- ✅ 标签管理
- ✅ 浏览量统计
- ✅ 站点配置管理（可修改个人信息、社交链接等）

## 数据库表结构

### admins - 管理员表
- id: 主键
- username: 用户名
- password: 密码（bcrypt 加密）
- email: 邮箱
- created_at: 创建时间

### posts - 文章表
- id: 主键
- title: 标题
- excerpt: 摘要
- content: 内容（HTML）
- tags: 标签（逗号分隔）
- views: 浏览量
- status: 状态（published/draft）
- created_at: 创建时间
- updated_at: 更新时间

### site_config - 站点配置表
- id: 主键
- config_key: 配置键
- config_value: 配置值
- updated_at: 更新时间

## 修改密码

在后台登录后，可以通过以下方式修改密码：

1. 直接在数据库中执行：
```sql
UPDATE admins SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2UDheYZgzDy' WHERE username = 'admin';
-- 这将密码设置为 admin123
```

2. 或者创建一个新的密码哈希：
```php
<?php echo password_hash('你的新密码', PASSWORD_DEFAULT); ?>
```
然后更新数据库中的 password 字段。

## 安全建议

1. 首次登录后立即修改默认密码
2. 在生产环境中，确保数据库密码足够复杂
3. 定期备份数据库
4. 启用 HTTPS
5. 限制后台访问 IP（可选）

## 技术栈

- **后端**: PHP 7.4+ / 8.x
- **数据库**: MySQL 5.7+ / 8.x
- **前端**: HTML5 + CSS3 + 原生 JavaScript
- **特性**: PDO、Session、响应式设计

## 常见问题

### Q: 无法连接数据库
A: 检查 `config/database.php` 中的数据库配置是否正确，确保 MySQL 服务已启动。

### Q: 页面显示空白
A: 开启 PHP 错误显示，在 `php.ini` 中设置 `display_errors = On`。

### Q: 后台无法登录
A: 检查数据库是否正确导入，确认 admins 表中有默认管理员记录。

## 许可证

本项目仅供个人使用。

---

**作者**: LCM_MC  
**版本**: 1.0.0  
**日期**: 2026-07-04
