<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infinity Trade Solutions LTD</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/adminLogin.css') }}">
    
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="w-full max-w-md login-card">
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
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

                <!-- ✅ Show Password Checkbox -->
                <div class="show-password-container mb-4">
                    <input type="checkbox" id="showPassword" class="show-password-checkbox" onclick="togglePasswordVisibility()">
                    <label for="showPassword" class="show-password-label">Show Password</label>
                </div>

                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <label for="remember" class="text-gray-700">Remember Me</label>
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

    <!-- Dark Mode Floating Button -->
    <button class="dark-mode-toggle" onclick="toggleDarkMode()">🌙</button>

    <script src="{{ asset('js/adminLogin.js') }}"></script>

    <!-- ✅ Small JS for Show Password -->
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById("password");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
        passwordInput.focus(); // 👈 ensures styles reapply instantly
    }
</script>

</body>
</html>
