// Applica il tema salvato
document.addEventListener('DOMContentLoaded', () => {
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-mode');
    }

    const btn = document.getElementById('toggle-theme');
    if (btn) {
        btn.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            // Salva preferenza
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    }
});