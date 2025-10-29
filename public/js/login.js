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

//------------------------------------

// Toggle full menu
  function toggleMenu() {
    document.querySelector("nav").classList.toggle("active");
    document.querySelector(".hamburger").classList.toggle("active");
  }

  // Dropdown toggle on mobile (only one open at a time)
  document.querySelectorAll(".dropdown-toggle").forEach(item => {
    item.addEventListener("click", function(e) {
      if (window.innerWidth <= 900) { // only on mobile
        e.preventDefault();

        // Close all other dropdowns
        document.querySelectorAll(".dropdown").forEach(drop => {
          if (drop !== this.parentElement) {
            drop.classList.remove("open");
          }
        });

        // Toggle the clicked dropdown
        this.parentElement.classList.toggle("open");
      }
    });
  });

  // Dark Mode Toggle
const toggleBtn = document.getElementById("darkModeToggle");

// Check saved theme
if (localStorage.getItem("theme") === "dark") {
  document.body.classList.add("dark-mode");
  toggleBtn.textContent = "☀️";
}

toggleBtn.addEventListener("click", () => {
  document.body.classList.toggle("dark-mode");

  if (document.body.classList.contains("dark-mode")) {
    toggleBtn.textContent = "☀️";
    localStorage.setItem("theme", "dark");
  } else {
    toggleBtn.textContent = "🌙";
    localStorage.setItem("theme", "light");
  }
});

