const manualLogin = document.getElementById('manualLogin');

const togglePasswordEl = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

const loginForm = document.getElementById('loginForm');
const errorDiv = document.getElementById('error');

// Signup
document.getElementById('gotoSignup').onclick = () => {
  window.location.href = '/signup';
};

// Toggle password visibility
togglePasswordEl.onclick = () => {
  passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
  togglePasswordEl.textContent = passwordInput.type === 'password' ? 'Show' : 'Hide';
};

// Manual login submit
loginForm.onsubmit = async (e) => {
  e.preventDefault();
  errorDiv.style.display = 'none';
  errorDiv.textContent = '';

  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;
  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
