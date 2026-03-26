<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CoreFX Solutions</title>
  <link rel="icon" type="pics/icon.png" href="{{ asset('pics/Corefx.png') }}" />
  <link rel="stylesheet" href="{{ asset('css/forex.css') }}">
   
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
            <!--<li><a href="{{ route('mutualfunds') }}">Mutual Funds</a></li>   -->         
            <li><a href="{{ route('promotion.show') }}">Promotions</a></li>
            <li><a href="{{ route('contact') }}">Contact Us</a></li>
            <li class="login-btn"><a href="{{ route('login') }}">Log In</a></li>
            

        </ul>
    </nav>

</header>     

<!-- ===== PAGE WRAPPER CARD ===== -->
<div class="page-card">



  <!-- ===== HERO SECTION ===== -->
  <section class="hero">
    <video autoplay muted loop playsinline class="hero-video">
      <source src="{{ asset('pics/Forex1.mp4') }}" type="video/mp4">
    </video>
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>Metals Trading</h1>
      <p>Unlock the world’s largest financial market</p>
    </div>
  </section>

  <!-- ===== PRODUCT DESCRIPTION ===== -->
  <section class="product-description fade-section">
    <div class="container">
      <h2>METALS</h2>
      <p>
        Precious metals are a financial instrument that is widely 
        used to diversify the portfolios and to hedge against economic 
        downturns or inflations. Gold has an intrinsic value that is hardly 
        affected by the devaluation of the economy, hence it is usually known 
        as the ‘safe haven’. When there is an economic recession or political 
        tension, there is a tendency to go long on gold. We provide four different types of metals 
        (Silver, Gold, Palladium, and Platinum) for clients to trade.
    </p>
    </div>
  </section>

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
        <li><i class="fas fa-envelope"></i>  support@corefxsolutions.com</li>
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
      This Website is Owned by <strong>CoreFX Solutions</strong>.  
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
      You should seek independent advice before making any investment decisions. <strong>CoreFX Solutions</strong>
      does not accept clients from the U.S., Afghanistan, Belarus, Burma, Burundi, Central African Republic, 
      China, Congo, Cuba, Egypt, Guinea, Guinea-Bissau, Iraq, Iran, Indonesia, Lebanon, Lesotho, Libya, 
      Mali, Moldova, Nicaragua, Nigeria, North Korea, Pakistan, Russia, Somalia, Sudan, South Sudan, 
      Syria, Tunisia, Turkey, Vanuatu, Venezuela, Yemen, and Zimbabwe. <strong>CoreFX Solutions</strong>
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

<!-- Back to Top Button -->
<button id="backToTop" class="back-to-top">
  ↑
</button>


<script src="{{ asset('js/products.js') }}"></script>
<script src="{{ asset('js/test.js') }}"></script>

<!--Start of Tawk.to Script
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/691d584acbe5561957e7e179/1jada1p7f';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->

</body>
</html>

