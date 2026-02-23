<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trinity Global Capital LTD</title>
  <link rel="icon" type="pics/icon.png" href="{{ asset('pics/icony1.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/adminLogin.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow-md w-full flex items-center px-8 py-4">
      <!--<img src="{{ asset('pics/Infinity1.png') }}" alt="Infinity Trade Logo" class="h-12"> --> 
      <span class="brand-title">TRINITY GLOBAL CAPITAL</span>
      <nav>
      <ul class="menu" id="navMenu">
          <li><a href="{{ route('home') }}">Go to Website</a></li>
      </ul>
  </nav>
  </header>

  <!-- Main Login Section -->
  <main class="flex-grow flex items-center justify-center p-4">
      <div class="w-full max-w-md login-card">
          <div class="w-full bg-white shadow-lg rounded-lg p-8">
              <h1 class="text-2xl font-bold mb-6 text-center">Admin Login</h1>

              @if(session('error'))
                  <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                      {{ session('error') }}
                  </div>
              @endif

              <form method="POST" action="{{ route('admin.login.submit') }}">
                  @csrf

                  <div class="mb-4">
                      <label class="block text-gray-700 font-semibold mb-2" for="email">Email</label>
                      <input type="email" name="email" id="email" required
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                  </div>

                  <div class="mb-2">
                      <label class="block text-gray-700 font-semibold mb-2" for="password">Password</label>
                      <input type="password" name="password" id="password" required
                          class="password-input w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                  </div>


                  <!-- Show Password -->
<div class="show-password-container">
    <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()">
    <label for="showPassword">Show Password</label>
</div>

<!-- Remember Me -->
<div class="remember-me-container">
    <input type="checkbox" name="remember" id="remember">
    <label for="remember">Remember Me</label>
</div>


                  <button type="submit"
                      class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                      Login
                  </button>
              </form>

              @error('email')
                  <div class="error-box">
                      {{ $message }}
                  </div>
              @enderror
          </div>
      </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-800 text-gray-300 text-center py-4 mt-auto">
      <p>© Trinity Global Capital LTD - 15669711</p>
  </footer>

  <!-- Dark Mode Floating Button 
  <button class="dark-mode-toggle" onclick="toggleDarkMode()">🌙</button> -->

  <script src="{{ asset('js/adminLogin.js') }}"></script>

  <script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById("password");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
        passwordInput.focus();
    }
  </script>
</body>
</html>
