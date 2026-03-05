const manualLogin = document.getElementById('manualLogin');

const togglePasswordEl = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

const loginForm = document.getElementById('loginForm');
const errorDiv = document.getElementById('error');

// Signup
const gotoSignupBtn = document.getElementById('gotoSignup');
if (gotoSignupBtn) {
  gotoSignupBtn.onclick = () => {
    window.location.href = '/signup';
  };
}

// Toggle password visibility
if (togglePasswordEl && passwordInput) {
  togglePasswordEl.addEventListener('click', () => {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      togglePasswordEl.textContent = 'Hide';
    } else {
      passwordInput.type = 'password';
      togglePasswordEl.textContent = 'Show';
    }
  });
}

// Manual login submit
if (loginForm && errorDiv) {
  loginForm.onsubmit = async (e) => {
    e.preventDefault();
    errorDiv.style.display = 'none';
    errorDiv.textContent = '';

    const emailEl = document.getElementById('email');
    const passwordEl = document.getElementById('password');
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');

    if (!emailEl || !passwordEl || !csrfMeta) {
      errorDiv.textContent = 'Missing required form fields.';
      errorDiv.style.display = 'block';
      return;
    }

    const email = emailEl.value;
    const password = passwordEl.value;
    const token = csrfMeta.getAttribute('content');

    try {
      const res = await fetch(loginForm.action, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json',
        },
        body: JSON.stringify({ email, password })
      });

      const data = await res.json();

      if (res.ok && data.success) {
        window.location.href = data.redirect;
      } else {
        errorDiv.textContent = data.message || 'Invalid credentials';
        errorDiv.style.display = 'block';
      }
    } catch (err) {
      errorDiv.textContent = 'Something went wrong. Please try again.';
      errorDiv.style.display = 'block';
      console.error(err);
    }
  };
}

//------------------------------------

// Toggle full menu
function toggleMenu() {
  const nav = document.querySelector('nav');
  const hamburger = document.querySelector('.hamburger');
  if (nav) nav.classList.toggle('active');
  if (hamburger) hamburger.classList.toggle('active');
}

// Dropdown toggle on mobile (only one open at a time)
document.querySelectorAll('.dropdown-toggle').forEach(item => {
  item.addEventListener('click', function (e) {
    if (window.innerWidth <= 900) {
      e.preventDefault();

      document.querySelectorAll('.dropdown').forEach(drop => {
        if (drop !== this.parentElement) {
          drop.classList.remove('open');
        }
      });

      this.parentElement.classList.toggle('open');
    }
  });
});

// Dark Mode Toggle
const toggleBtn = document.getElementById('darkModeToggle');

if (toggleBtn) {
  if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode');
    toggleBtn.textContent = '??';
  }

  toggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');

    if (document.body.classList.contains('dark-mode')) {
      toggleBtn.textContent = '??';
      localStorage.setItem('theme', 'dark');
    } else {
      toggleBtn.textContent = '??';
      localStorage.setItem('theme', 'light');
    }
  });
}
