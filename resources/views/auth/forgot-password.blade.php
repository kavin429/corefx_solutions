<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CoreFX Solutions</title>
  <link rel="icon" type="pics/icon.png" href="{{ asset('pics/icon1.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    html, body {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      overscroll-behavior: none;
      touch-action: pan-y;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #006832, #155840 , #013120);
      color: #3b2a5a;
      transition: all 0.3s ease;
    }

    .card {
      border: none;
      border-radius: 12px;
      background: #ffffff28;
      box-shadow: 0 4px 12px rgba(75, 0, 130, 0.15);
      transition: all 0.3s ease;
    }

    .card h3 {
      font-weight: 600;
      color: #a7ffdc;
    }

    .form-label {
      font-weight: 500;
      color: #ffffff;
    }

    .form-control {
      border: 1px solid #bdf4e7;
      border-radius: 8px;
      padding: 0.6rem 0.75rem;
      font-size: 0.95rem;
      transition: all 0.3s ease-in-out;
      background: #ffffff15;
      color: #e4e2e8;
    }

    .form-control:focus {
      border-color: #3cff80;
      box-shadow: 0 0 6px rgba(60, 255, 115, 0.3);
    }

    .text-danger.small {
      font-size: 0.85rem;
      margin-top: 0.25rem;
    }

    .btn-primary {
      background: linear-gradient(135deg, #3cffc1, #489e1d);
      border: none;
      border-radius: 8px;
      padding: 0.6rem;
      font-weight: 500;
      transition: background 0.3s ease-in-out;
    }

    .alert-success {
      background: #d7ffee;
      border: 1px solid #aaffd0;
      color: #0b5233;
      border-radius: 8px;
      font-weight: 500;
    }

    .card a {
      color: #3dbb86;
      text-decoration: none;
      font-weight: 500;
    }

    .card a:hover {
      text-decoration: underline;
      color: #4b8f1b;
    }

  </style>
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="min-height:100vh;">

  <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
    <h3 class="text-center mb-4">Forgot Password</h3>

    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @php
        $email = old('email');
        $canReset = true;
        $secondsLeft = 0;

        if ($email && Cache::has('password_reset_'.$email)) {
            $secondsLeft = Cache::get('password_reset_'.$email) - time();
            $canReset = $secondsLeft <= 0;
        }
    @endphp

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

      <button type="submit" class="btn btn-primary w-100" @if(!$canReset) disabled @endif>
        @if($canReset)
            Send Reset Link
        @else
            Please wait {{ $secondsLeft }} seconds
        @endif
      </button>
    </form>

    <div class="mt-3 text-center">
      <a href="/login">← Go Back</a>
    </div>
  </div>

  <!-- Dark Mode Toggle
  <button id="darkModeToggle" class="dark-toggle">🌙</button>  -->

  @if(!$canReset)
  <script>
  let seconds = {{ $secondsLeft }};
  const btn = document.querySelector('button[type="submit"]');

  const interval = setInterval(() => {
      if (seconds <= 0) {
          btn.disabled = false;
          btn.textContent = 'Send Reset Link';
          clearInterval(interval);
      } else {
          btn.textContent = `Please wait ${seconds} seconds`;
          seconds--;
      }
  }, 1000);
  </script>
  @endif

  <!-- Dark Mode Toggle Script -->
  <script>
    const toggleBtn = document.getElementById("darkModeToggle");

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
