// Sidebar toggle
const sidebarToggle = document.getElementById('sidebar-toggle');
const sidebar = document.getElementById('sidebar');

sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});

// Elements
const themeToggle = document.getElementById('theme-toggle');
const body = document.body;

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', () => {
    const theme = localStorage.getItem('theme');
    if (theme === 'dark') {
        body.classList.add('dark-mode');
        themeToggle.classList.remove('bi-moon');
        themeToggle.classList.add('bi-sun');
    } else {
        body.classList.remove('dark-mode');
        themeToggle.classList.remove('bi-sun');
        themeToggle.classList.add('bi-moon');
    }
});

// Toggle theme on click
themeToggle.addEventListener('click', () => {
    body.classList.toggle('dark-mode');

    if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
        themeToggle.classList.remove('bi-moon');
        themeToggle.classList.add('bi-sun');
    } else {
        localStorage.setItem('theme', 'light');
        themeToggle.classList.remove('bi-sun');
        themeToggle.classList.add('bi-moon');
    }
});

 