<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Infinity Trade Solutions LTD</title>
  <link rel="icon" type="pics/icon.png" href="pics/icon.png" />
  <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
<link rel="stylesheet" href="{{ asset('css/promotion.css') }}">

</head>
<body>

<!-- ===== HEADER ===== -->
<header>
    <div class="logo">
      <h2>Infinity Trade</h2>
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

<!-- ======= Contact Section ======= -->
<section class="contact-page container">
    <h1 class="text-center mb-5 fw-bold text-dark">Contact Us</h1>

    <div class="row g-5 align-items-start">
        <!-- Contact Info -->
        <div class="col-lg-5">
            <div class="contact-info">
                <h4>Get In Touch</h4>
                <p><i class="bi bi-telephone-fill text-purple me-2"></i> +44 20 4577 3834</p>
                <p><i class="bi bi-envelope-fill text-purple me-2"></i> supports@tforexm.com</p>
                <hr>
                <h5 class="fw-semibold text-dark mt-3">Our Office</h5>
                <p><strong>London Office:</strong><br>20–22 Wenlock Road, London, England, N1 7GU</p>
            </div>
        </div>

        <!-- Google Map -->
        <div class="col-lg-7">
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19886.201933556358!2d-0.09907737266598415!3d51.53336487061505!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761ca7f12ed8e1%3A0x6b1ad56e537b9029!2s20-22%20Wenlock%20Rd%2C%20London%20N1%207GU%2C%20UK!5e0!3m2!1sen!2suk!4v1697050060000!5m2!1sen!2suk" 
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</section>


    <!-- ======= Footer ======= -->
<!-- Footer -->
<footer class="footer">
  <div class="footer-container">

    <!-- Column 1: Logo + Social -->
    <div class="footer-col footer-brand">
      <!-- <img src="" alt="Tradefx Logo" class="footer-logo"> -->
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
        <li><a href="#pricing">Micro</a></li>
        <li><a href="#pricing">Classic</a></li>
        <li><a href="#pricing">Premium</a></li>
        <li><a href="#pricing">Professional</a></li>
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
        <li> <i class="fas fa-phone"></i>  +44 20 4577 3834</li>
        <li><i class="fas fa-envelope"></i>  supports@tforexm.com</li>
        <li><i class="fas fa-building"></i>  20-22 Wenlock Road, London, England, N1 7GU</li>
        <!--<li><i class="fas fa-globe"></i>  57Q9+6MF - Business Bay - Dubai - UAE</li> -->
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
      the U.S., Afghanistan, Belarus, Burma, Burundi, Central African Republic, China, Congo, Cuba, Egypt, 
      Guinea, Guinea-Bissau, Iraq, Iran, Indonesia, Lebanon, Lesotho, Libya, Malaysia, Maldives, Mali, Moldova, 
      Nicaragua, Nigeria, North Korea, Pakistan, Russia, Somalia, Sudan, South Sudan, Syria, Tunisia, Turkey, 
      Vanuatu, Venezuela, Yemen, and Zimbabwe. Infinity Trade Solutions LTD may reject any applicant from any 
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

<!-- Back to Top Button -->
<button id="backToTop" class="back-to-top">
  ↑
</button>

<script src="{{ asset('js/platform.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
