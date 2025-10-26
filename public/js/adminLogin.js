// On page load, check saved mode
window.onload = function () {
    const darkModeEnabled = localStorage.getItem('dark-mode') === 'true';
    if (darkModeEnabled) {
      document.body.classList.add('dark-mode');
      document.querySelector('.dark-mode-toggle').textContent = '☀️';
    }
};

// Dark Mode Button
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    const isDark = document.body.classList.contains('dark-mode');
    localStorage.setItem('dark-mode', isDark);

    const btn = document.querySelector('.dark-mode-toggle');
    btn.textContent = isDark ? '☀️' : '🌙';
}