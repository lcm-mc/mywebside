    <div class="footer">
        © <?= date('Y') ?> <?= htmlspecialchars(getConfig('site_name')) ?> · 与你的日常 便是奇迹！
    </div>

    <script>
        (function() {
            const themeToggle = document.getElementById('themeToggle');
            const html = document.documentElement;

            let currentTheme = localStorage.getItem('theme') || 'light';
            if (currentTheme === 'dark') {
                html.setAttribute('data-theme', 'dark');
                themeToggle.textContent = '☀️ 亮色';
            } else {
                html.removeAttribute('data-theme');
                themeToggle.textContent = '🌓 暗色';
            }

            themeToggle.addEventListener('click', function() {
                const isDark = html.getAttribute('data-theme') === 'dark';
                if (isDark) {
                    html.removeAttribute('data-theme');
                    localStorage.setItem('theme', 'light');
                    themeToggle.textContent = '🌓 暗色';
                } else {
                    html.setAttribute('data-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                    themeToggle.textContent = '☀️ 亮色';
                }
            });
        })();
    </script>
</body>
</html>
