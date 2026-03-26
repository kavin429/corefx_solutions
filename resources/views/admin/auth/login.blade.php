<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>CoreFX Solutions</title>
  <link rel="icon" type="image/png" href="{{ asset('pics/icon1.png') }}" />
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    .admin-login-page {
      min-height: 100vh;
      min-height: 100svh;
      display: flex;
      flex-direction: column;
    }

    .admin-login-page * {
      box-sizing: border-box;
    }

    .admin-login-page nav {
      position: static;
      display: block;
      width: auto;
      background: transparent;
      backdrop-filter: none;
      animation: none;
    }

    .admin-login-page .menu {
      display: flex;
      flex-direction: row;
      gap: 16px;
    }

    .admin-login-page .menu li a {
      padding: 0;
      border-bottom: 0;
    }

    .admin-login-page .login-root {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding-top: 120px;
      padding-bottom: 32px;
      padding-left: 16px;
      padding-right: 16px;
      min-height: 0;
    }

    .admin-login-page .login-root .card {
      width: min(100%, 500px);
      margin: 0 auto;
      margin-top: 0;
      padding: clamp(1rem, 3vw, 2.25rem);
    }

    .admin-login-page input,
    .admin-login-page button,
    .admin-login-page .password-wrapper {
      width: 100%;
      max-width: 100%;
    }

    .admin-login-page .links {
      margin: 6px 0 10px;
    }

    .admin-login-page .remember-inline {
      display: flex;
      align-items: center;
      gap: 8px;
      margin: 0;
      color: #efeeee;
    }

    .admin-login-page .remember-inline input {
      width: 16px;
      height: 16px;
      margin: 0;
    }

    .admin-login-page .admin-footer {
      background: rgba(1, 7, 7, 0.85);
      color: #d7f5f2;
      line-height: 1.2;
    }

    .admin-login-page .admin-footer p {
      margin: 0;
      font-size: 13px;
      text-align: center;
    }

    @media (max-width: 1200px) {
      .admin-login-page nav {
        display: block !important;
        position: static;
        width: auto;
      }

      .admin-login-page .menu {
        flex-direction: row;
        gap: 12px;
      }

      .admin-login-page .menu li a {
        padding: 0;
        border-bottom: 0;
      }
    }

    @media (max-width: 540px) {
      .admin-login-page .login-root {
        padding-top: 96px;
        padding-bottom: 20px;
      }

      .admin-login-page .login-root .card {
        padding: 16px;
      }
    }
  </style>
</head>
<body class="admin-login-page">

<header>
  <div class="logo">
    <a href="{{ route('home') }}">
      <img src="{{ asset('pics/Corefxlogo.png') }}" alt="Corefx Trade Logo" class="logo-img">
    </a>
  </div>

  <nav>
    <ul class="menu" id="navMenu">
      <li>
        <a href="{{ route('home') }}">
          <img src="{{ asset('pics/icon1.png') }}" alt="" aria-hidden="true">
          Go to Website
        </a>
      </li>
    </ul>
  </nav>
</header>

<div class="login-root">
  <div class="card" id="manualLogin">
    <h2>Admin Login</h2>

    @if(session('error'))
      <div class="error" style="display:block;">
        {{ session('error') }}
      </div>
    @endif

    @error('email')
      <div class="error" style="display:block;">
        {{ $message }}
      </div>
    @enderror

    <form method="POST" action="{{ route('admin.login.submit') }}">
      @csrf

      <label for="email">Email</label>
      <input type="email" name="email" id="email" placeholder="admin@example.com" required>

      <label for="password">Password</label>
      <div class="password-wrapper">
        <input type="password" name="password" id="password" placeholder="Enter your password" required>
        <span id="togglePassword" class="toggle-password" onclick="togglePasswordVisibility()">Show</span>
      </div>

      <div class="links">
        <label class="remember-inline">
          <input type="checkbox" name="remember" id="remember">
          Remember Me
        </label>
      </div>

      <button type="submit" id="loginBtn">Login</button>
    </form>
  </div>
</div>

<footer class="admin-footer">
  <p>© CORE FINANCE LIMITED - 10956602</p>
</footer>

<script>
  function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const toggle = document.getElementById("togglePassword");
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
    if (toggle) {
      toggle.textContent = passwordInput.type === "password" ? "Show" : "Hide";
    }
    passwordInput.focus();
  }
</script>
</body>
</html>
