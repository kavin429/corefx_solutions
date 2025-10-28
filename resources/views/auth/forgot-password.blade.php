<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Infinity Trade Solutions LTD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>

    html, body {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  overscroll-behavior: none; /* Disable mobile rubber-band scroll */
  touch-action: pan-y; /* Allow only vertical scroll */
}
    /* ==========================
       Forgot Password Page (Purple Theme)
    ========================== */

    /* General */
    body {
      font-family: "Exo 2", sans-serif;
      background: linear-gradient(135deg, #f5f0ff, #ede6fa);
      color: #3b2a5a;
      transition: all 0.3s ease;
    }

    body.dark-mode {
    background: linear-gradient(135deg, #1e1e2f, #2a143d);
    color: #e4e4e7;
}



    /* Card */
    .card {
      border: none;
      border-radius: 12px;
      background: #ffffff;
      box-shadow: 0 4px 12px rgba(75, 0, 130, 0.15);
      transition: all 0.3s ease;
    }

    body.dark-mode .card {
      background: #2b2b3c;
      box-shadow: 0 4px 12px rgba(0,0,0,0.5);
    }

    /* Heading */
    .card h3 {
      font-weight: 600;
      color: #4b2a82;
    }

    body.dark-mode .card h3 {
      color: #d9bfff;
    }

    /* Labels */
    .form-label {
      font-weight: 500;
      color: #3b2a5a;
    }

    body.dark-mode .form-label {
      color: #ccc;
    }

    /* Input Fields */
    .form-control {
      border: 1px solid #d0bdf4;
      border-radius: 8px;
      padding: 0.6rem 0.75rem;
      font-size: 0.95rem;
      transition: all 0.3s ease-in-out;
      background: #fff;
      color: #3b2a5a;
    }

    .form-control:focus {
      border-color: #7d3cff;
      box-shadow: 0 0 6px rgba(125, 60, 255, 0.3);
    }

    body.dark-mode .form-control {
      background: #3a3a4c;
      color: #e0e0e0;
      border-color: #555;
    }

    /* Error Text */
    .text-danger.small {
      font-size: 0.85rem;
      margin-top: 0.25rem;
    }

    /* Button */
    .btn-primary {
      background: linear-gradient(135deg, #7d3cff, #5a1d9e);
      border: none;
      border-radius: 8px;
      padding: 0.6rem;
      font-weight: 500;
      transition: background 0.3s ease-in-out;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #6c2ddb, #4b1b8f);
    }

    body.dark-mode .btn-primary {
      background: linear-gradient(135deg, #9c6fff, #7d52c2);
    }

    /* Alert */
    .alert-success {
      background: #e9d7ff;
      border: 1px solid #c7aaff;
      color: #4b1b8f;
      border-radius: 8px;
      font-weight: 500;
    }

    body.dark-mode .alert-success {
      background: #4b2a82;
      border-color: #7d3cff;
      color: #fff;
    }

    /* Links */
    .card a {
      color: #6a3dbb;
      text-decoration: none;
      font-weight: 500;
    }

    .card a:hover {
      text-decoration: underline;
      color: #4b1b8f;
    }

    body.dark-mode .card a {
      color: #bfa1ff;
    }

    body.dark-mode .card a:hover {
      color: #e0c3ff;
    }
    /* Floating Dark Mode Toggle */
.dark-toggle {
  position: fixed;
  right: 20px;
  bottom: 20px;   /* stays at bottom */
  background: #111;
  color: #fff;
  border: none;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  font-size: 22px;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  transition: all 0.3s ease;
  z-index: 1200;
}

.dark-toggle:hover {
  background: #333;
  transform: scale(1.1);
}

  </style>
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="min-height:100vh;">
  <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
    <h3 class="text-center mb-4">Forgot Password</h3>

    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('forgot-password.send') }}">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
               name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
          <div class="text-danger small">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
    </form>

    <div class="mt-3 text-center">
      <a href="/login">← Go Back</a>
    </div>
  </div>

  <!-- Dark Mode Toggle -->
<button id="darkModeToggle" class="dark-toggle">
  🌙
</button>

  <!-- Optional Dark Mode Toggle Script -->
  <script>
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
  </script>
</body>
</html>
