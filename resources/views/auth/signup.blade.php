<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CORE FINANCE LIMITED</title>
  <link rel="icon" type="pics/icon.png" href="{{ asset('pics/Corefx.png') }}" />
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icons/7.2.3/css/flag-icons.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>

<!-- ===== HEADER ===== -->
<header>
    <div class="logo">
      <a href="{{ route('home') }}">
            <img src="{{ asset('pics/Corefxlogo.png') }}" alt="Corefx Trade Logo" class="logo-img">
        </a>
    </div>

  <div class="hamburger" onclick="toggleMenu()">
    <span></span>
    <span></span>
    <span></span>
  </div>
 
  <nav>
      <ul class="menu" id="navMenu">
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('about') }}">About Us</a></li>
          <li class="dropdown">
              <a href="#">Trading Products ▾</a>
              <ul class="dropdown-menu">
                  <li><a href="{{ route('forex') }}">Forex</a></li>
                  <li><a href="{{ route('metals') }}">Metals</a></li>
                  <li><a href="{{ route('indices') }}">Indices</a></li>
                  <li><a href="{{ route('crypto') }}">Crypto Currencies</a></li>
              </ul>
          </li>
          <li><a href="{{ route('platform') }}">Platform</a></li>
          <!--<li><a href="{{ route('mutualfunds') }}">Mutual Funds</a></li>-->
            <li><a href="{{ route('promotion.show') }}">Promotions</a></li>
            <li><a href="{{ route('contact') }}">Contact Us</a></li>
            <li class="login-btn"><a href="{{ route('login') }}">Log In</a></li>
      </ul>
  </nav>
</header>

  <div class="signup-wrap">
    <div class="card">

    @error('g-recaptcha-response')
    <span class="text-danger">{{ $message }}</span>
@enderror

      <h1>Create Account</h1>

      
      <form method="POST" action="{{ route('signup.submit') }}" id="signupForm">
        @csrf

        <div class="row">
          <div class="col">
            <label>First name</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" required>
          </div>
          <div class="col">
            <label>Last name</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" required>
          </div>
        </div>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Birth date</label>
        <input type="date" name="birth_date" value="{{ old('birth_date') }}" required>

        <label>Country</label>
        <select id="country" name="country" required></select>

        <label>Phone</label>
          <div class="phone-row">
            <span id="flag" class="fi fi-lk"></span> <!-- default Sri Lanka -->
            <input id="phone_code" name="phone_code" class="code" readonly>
            <input id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required placeholder="">
          </div>


        <div class="row2">
  <div class="col2">
    <label>Password</label>
    <div class="password-wrapper">
      <input type="password" id="password" name="password" required minlength="8">
      <span class="toggle-password" onclick="togglePassword('password', this)">Show</span>
    </div>
  </div>

  <div class="col2">
    <label>Confirm Password</label>
    <div class="password-wrapper">
      <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8">
      <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">Show</span>
    </div>
  </div>
</div>


        <label>Promo code (optional)</label>
        <input type="text" name="promo_code" value="{{ old('promo_code') }}">

        <label class="checkbox">
          <input type="checkbox" name="wants_biometrics" value="1" {{ old('wants_biometrics') ? 'checked' : '' }}>
          <span>Enable biometric login (optional)</span>
        </label>

            <!-- ===== reCAPTCHA ===== 
        <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>



        <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->


        <button type="submit" class="btn" id="signupBtn">Sign Up</button>

        <p class="login-link">
             Already have an account? <a href="{{ route('login') }}">Log In</a>
        </p>

      </form>

      @if ($errors->any())
      <div class="errors"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
      @endif
      @if (session('status')) <div class="notice">{{ session('status') }}</div> @endif

    </div>
  </div>
  <!-- Footer -->
<footer class="footer">
  <div class="footer-container">

    <!-- Column 1: Logo + Social -->
    <div class="footer-col footer-brand">
     <img src="{{ asset('pics/Corefxlogo.png') }}" alt="Tradefx Logo" class="footer-logo">
      <div class="footer-social">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
       
      </div>
    </div>

    <!-- Column 2 -->
    <div class="footer-col">
      <h4>Trading Products</h4>
      <ul>
        <li><a href="{{ route('forex') }}">Forex</a></li>
        <li><a href="{{ route('metals') }}">Metals</a></li>
        <li><a href="{{ route('indices') }}">Indices</a></li>
        <li><a href="{{ route('crypto') }}">Crypto currency</a></li>
      </ul>
    </div>

    <!-- Column 3 -->
    <div class="footer-col">
      <h4>Account Types</h4>
      <ul>
        <li><a href="#pricing">Elite</a></li>
        <li><a href="#pricing">Pro</a></li>
        <li><a href="#pricing">VIP</a></li>
        <li><a href="#pricing">Raw</a></li>
      </ul>
    </div>

    <!-- Column 4 -->
    <div class="footer-col">
      <h4>Others</h4>
      <ul>
        <li><a href="{{ route('platform') }}">Platform</a></li>
        <li><a href="{{ route('about') }}">About us</a></li>
        <li><a href="{{ route('promotion.show') }}">Promotions</a></li>
        <li><a href="{{ route('contact') }}">Contact us</a></li>
      </ul>
    </div>

    <!-- Column 5 -->
    <div class="footer-col">
      <h4>Contact Info</h4>
      <ul>
        <li> <i class="fas fa-phone"></i>  +61 861 865 931</li>
        <li><i class="fas fa-envelope"></i>  support@corefinanceltd.com</li>
        <li><i class="fas fa-building"></i>  9 Scott Court, 50 Silverthorne Road, London, United Kingdom, SW8 3HD</li>
        <!--<li><i class="fas fa-globe"></i>  57Q9+6MF - Business Bay - Dubai - UAE</li> -->
      </ul>
    </div>
  </div>

  <!-- Legal -->
 <div class="footer-legal">
  <div class="legal-titles">
    <h3 class="legal-title" data-target="legal-desc">Legal</h3>
    <h3 class="legal-title" data-target="risk-warning-desc">General Risk Warning</h3>
    <h3 class="legal-title" data-target="risk-disclosure-desc">Risk Disclosure</h3>
  </div>

  <div class="legal-desc-container">
    <p id="legal-desc" class="legal-desc">
      This Website is Owned by <strong>CORE FINANCE LIMITED</strong>.  
      The objects of the Company are all subject matters not forbidden by International Business Companies 
      (Amendment and Consolidation).
    </p>

    <p id="risk-warning-desc" class="legal-desc">
      Trading leveraged products such as Forex and CFDs may not be suitable for all investors as 
      they carry a high degree of risk to your capital. Please ensure that you fully understand 
      the risks involved, taking into account your investments objectives and level of experience, 
      before trading, and if necessary, seek independent advice. Please read the full Risk Disclosure.
    </p>

    <p id="risk-disclosure-desc" class="legal-desc">
      Past performance is not indicative of future results. The information on our website is provided 
      for informational purposes only and should not be construed as investment advice. 
      You should seek independent advice before making any investment decisions. <strong>CORE FINANCE LIMITED</strong>
      does not accept clients from the U.S., Afghanistan, Belarus, Burma, Burundi, Central African Republic, 
      China, Congo, Cuba, Egypt, Guinea, Guinea-Bissau, Iraq, Iran, Indonesia, Lebanon, Lesotho, Libya, 
      Mali, Moldova, Nicaragua, Nigeria, North Korea, Pakistan, Russia, Somalia, Sudan, South Sudan, 
      Syria, Tunisia, Turkey, Vanuatu, Venezuela, Yemen, and Zimbabwe. <strong>CORE FINANCE LIMITED</strong>
      may reject any applicant from any jurisdiction at their sole discretion without the requirement to 
      explain the reason why (Terms and conditions).
    </p>
  </div>
</div>

  <!-- Bottom -->
  <div class="footer-bottom">
    <p>© CORE FINANCE LIMITED - 10956602</p>
    <section class="partner-section">
      <div class="partner-slider">
        <div class="partner-track">
          <img src="{{ asset('pics/c1.png') }}" alt="Trading Icon 3">
          <img src="{{ asset('pics/c2.png') }}" alt="Trading Icon 3">
          <img src="{{ asset('pics/c3.png') }}" alt="Trading Icon 3">
          <img src="{{ asset('pics/c4.png') }}" alt="Trading Icon 3">
          <img src="{{ asset('pics/c5.png') }}" alt="Trading Icon 3">
          <img src="{{ asset('pics/c1.png') }}" alt="Trading Icon 3">
          <img src="{{ asset('pics/c2.png') }}" alt="Trading Icon 3">
          <img src="{{ asset('pics/c3.png') }}" alt="Trading Icon 3">
          <img src="{{ asset('pics/c4.png') }}" alt="Trading Icon 3">
          <img src="{{ asset('pics/c5.png') }}" alt="Trading Icon 3">
        </div>
      </div>
    </section>
  </div>
  
</footer>
<script>
const titles = document.querySelectorAll('.legal-title');
const descriptions = document.querySelectorAll('.legal-desc');

titles.forEach(title => {
  title.addEventListener('click', () => {
    const targetId = title.dataset.target;
    const desc = document.getElementById(targetId);

    const isActive = title.classList.contains('active');

    // close all first
    titles.forEach(t => t.classList.remove('active'));
    descriptions.forEach(d => {
      d.style.display = 'none';
    });

    // open clicked one only
    if (!isActive) {
      title.classList.add('active');
      if (desc) desc.style.display = 'block';
    }
  });
});
</script>

<!-- Dark Mode Toggle 
<button id="darkModeToggle" class="dark-toggle">
  🌙
</button> -->


  <script src="{{ asset('js/signup.js') }}"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>
</html>

