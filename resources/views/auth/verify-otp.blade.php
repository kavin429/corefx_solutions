<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CORE FINANCE LIMITED</title>
  <link rel="icon" type="pics/icon.png" href="{{ asset('pics/icon1.png') }}" />
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
  <div class="signup-wrap">
    <div class="card">
      <h1>Verify Your Email</h1>

      <p>We sent a 6-digit code to <strong>{{ $email }}</strong>. It expires in <span id="countdown"></span></p>

      @if ($errors->any())
      <div class="errors">
        <ul>
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      @if (session('status'))
        <div class="notice">{{ session('status') }}</div>
      @endif

      <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <label>6-digit code</label>
        <input type="text" name="code" inputmode="numeric" maxlength="6" required>
        <button type="submit" class="btn">Verify & Create Account</button>
      </form>

      <form method="POST" action="{{ route('otp.resend') }}" style="margin-top:12px;">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <button type="submit" class="btn alt">Resend Code</button>
      </form>
    </div>
  </div>

  <script>
    // Convert remaining time to integer seconds
    let remaining = Math.floor(Number({{ $remaining }}));
    const el = document.getElementById('countdown');

    (function tick() {
      if (remaining <= 0) {
        el.textContent = 'expired';
        return;
      }
      const m = Math.floor(remaining / 60);
      const s = remaining % 60;
      el.textContent = `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
      remaining--;
      setTimeout(tick, 1000);
    })();
  </script>
</body>
</html>
