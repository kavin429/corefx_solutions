<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Infinity Trade Solutions LTD</title>
  <link rel="icon" type="pics/icon.png" href="{{ asset('pics/Infinity1.png') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">

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
            <img src="{{ asset('pics/Infinity1.png') }}" alt="Infinity Trade Logo" class="logo-img">
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
            <li><a href="{{ route('promotion.show') }}">Promotions</a></li>
            <li><a href="{{ route('contact') }}">Contact Us</a></li>
            <li class="login-btn"><a href="{{ route('login') }}">Log In</a></li>
      </ul>
  </nav>
</header>

<div class="login-root">

  <!-- Manual Login Form -->
  <div class="card" id="manualLogin">
    <h2>Login</h2>
    <div id="error" class="error"></div>
    <form id="loginForm">
      @csrf <!-- important for AJAX -->
      
      <label>Email</label>
      <input type="email" id="email" name="email" placeholder="you@example.com" required>

      <label>Password</label>
      <div class="password-wrapper">
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
        <span id="togglePassword" class="toggle-password">Show</span>
      </div>

      <div class="links">
        <a href="{{ route('forgot-password.show') }}">Forgot Password?</a>
      </div>

      <button type="submit" id="loginBtn">Login</button>
    </form>

    <!-- Extra buttons -->
    <div class="extra-btns">
      <button id="gotoSignup"><i class="fas fa-user-plus"></i> Create New Account</button>
    </div>
  </div>

</div>
 
<!-- Footer -->
<footer class="footer">
  <div class="footer-container">

    <!-- Column 1: Logo + Social -->
    <div class="footer-col footer-brand">
      <img src="{{ asset('pics/Infinity1.png') }}" alt="Tradefx Logo" class="footer-logo">
      <div class="footer-social">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
      </div>
    </div>

    <!-- Column 2 -->
    <div class="footer-col">
      <h4>Trading Products</h4>
      <ul>
        <li><a href="#">Forex</a></li>
        <li><a href="#">Metals</a></li>
        <li><a href="#">Indices</a></li>
        <li><a href="#">Crypto currency</a></li>
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
        <li><a href="#">Platform</a></li>
        <li><a href="#">About us</a></li>
        <li><a href="#">Contact us</a></li>
      </ul>
    </div>

    <!-- Column 5 -->
    <div class="footer-col">
      <h4>Contact Info</h4>
      <ul>
        <li> <i class="fas fa-phone"></i>  +44 20 4577 3834</li>
        <li><i class="fas fa-envelope"></i>  support@infinitytradesolution.com</li>
        <li><i class="fas fa-building"></i>  20-22 Wenlock Road, London, England, N1 7GU</li>
       
      </ul>
    </div>
  </div>

  <!-- Legal -->
  <div class="footer-legal">
    <h3>legal</h3>
    <p> This Website is Owned by Infinity Trade Solutions LTD. The objects of the Company are all subject 
      matters not forbidden by International Business Companies (Amendment and Consolidation).</p>
    <h3>General Risk Warning</h3>
    <p>Trading leveraged products such as Forex and CFDs may not be suitable for all investors as they carry 
      a high degree of risk to your capital. Please ensure that you fully understand the risks involved, taking 
      into account your investments objectives and level of experience, before trading, and if necessary, 
      seek independent advice. Please read the full Risk Disclosure.</p>
    <h3>Risk disclosure</h3>
    <p>Past performance is not indicative of future results. The information on our website is provided for 
      informational purposes only and should not be construed as investment advice. You should seek independent 
      advice before making any investment decisions. Infinity Trade Solutions LTD does not accept clients from 
      the U.S., Afghanistan, Belarus, Burma, Burundi, Central African Republic, China, Congo, Cuba, Egypt, Guinea, 
      Guinea-Bissau, Iraq, Iran, Indonesia, Lebanon, Lesotho, Libya, Mali, Moldova, Nicaragua, 
      Nigeria, North Korea, Pakistan, Russia, Somalia, Sudan, South Sudan, Syria, Tunisia, Turkey, Vanuatu, 
      Venezuela, Yemen, and Zimbabwe. Infinity Trade Solutions LTD may reject any applicant from any 
      jurisdiction at their sole discretion without the requirement to explain the reason why 
      (Terms and conditions).</p>
  </div>

  <!-- Bottom -->
  <div class="footer-bottom">
    <p>© Infinity Trade Solutions LTD - 09711441</p>
    <div class="footer-social">
      <a href="#"><i class="fab fa-facebook-f"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-linkedin-in"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
    </div>
  </div>
</footer>

<!-- Dark Mode Toggle -->
<button id="darkModeToggle" class="dark-toggle">
  🌙
</button>

<script src="{{ asset('js/login.js') }}"></script>

</body>
</html>
