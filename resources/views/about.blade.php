<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Infinity Trade Solutions LTD</title>
  <link rel="icon" type="pics/icon.png" href="{{ asset('pics/Infinity1.png') }}" />
  <link rel="stylesheet" href="{{ asset('css/about.css') }}">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" 
rel="stylesheet">

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

  <!-- ===== HERO SECTION ===== -->
  <section class="hero">
    <video autoplay muted loop playsinline class="hero-video">
      <source src="pics/cover_video.mp4" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1> <span>Infinity Trade Solutions LTD</span></h1>
      <p>One of the leading financial venture firms revolutionizing online forex trading.</p>
    </div>
  </section>

<!-- ===== WHO WE ARE SECTION ===== -->
<section class="who-section" id="who-we-are">
  <div class="who-container">
    <!-- Left Side Image -->
    <div class="who-image">
      <img src="{{ asset('pics/about1.webp') }}" alt="About Tradefxm">
    </div>

    <!-- Right Side Text -->
    <div class="who-content">
      <h2 class="section-title">Who We Are</h2>
      <p class="who-text">
        Infinity Trade Solutions LTD was founded by a diverse group of financial experts in 2015 with 
        the vision of building a financial platform where every individual can play 
        a crucial role in the forex industry.
      </p>
      <p class="who-text">
        We integrate advanced technology, cryptocurrency trading, and a true ECN 
        pricing model, offering competitive opportunities for traders worldwide.
      </p>

      <!-- Cards -->
      <div class="who-cards">
        <div class="who-card">
          <img src="{{ asset('pics/vission.png') }}" alt="Vision">
          <h3>Our Vision</h3>
          <p>
            To revolutionize forex by delivering innovative investment approaches, 
            competitive spreads, and sustainable opportunities.
          </p>
        </div>
        <div class="who-card">
          <img src="{{ asset('pics/mission1.png') }}" alt="Commitment">
          <h3>Our Commitment</h3>
          <p>
            We focus on customer success by providing advanced tools, learning 
            resources, and up-to-date market analysis for a win-win outcome.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===== HIGHLIGHTS ===== -->
<section class="highlights" id="highlights">
  <div class="container grid-4">
    <div class="card">
      <i class="fas fa-bolt"></i>
      <h3>1m ToB</h3>
      <span>on average across FX instruments</span>
    </div>
    <div class="card">
      <i class="fas fa-chart-line"></i>
      <h3>100 Lots</h3>
      <span>per click trading</span>
    </div>
    <div class="card">
      <i class="fas fa-balance-scale"></i>
      <h3>BBO Pricing</h3>
      <span>Best Bid-Offer</span>
    </div>
    <div class="card">
      <i class="fas fa-server"></i>
      <h3>Free VPS</h3>
      <span>Elite & Pro Accounts</span>
    </div>
    <div class="card">
      <i class="fas fa-shield-alt"></i>
      <h3>Segregated</h3>
      <span>Client accounts</span>
    </div>
  </div>
</section>

<!-- Font Awesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


<!-- ===== HIGHLIGHT CARDS ===== -->
<section class="highlights-section">
  <div class="container grid-cards">

    <!-- Card 1 -->
    <div class="card fade-in">
        <h3>Financial Products</h3>
      <img src="{{ asset('pics/financial.png') }}" alt="Financial Products">
      
      <p>
        We sincerely understand the importance of diversification. To protect our customers from investment risks, 
        we offer seven types of trading products with over 200+ individual securities to trade with. 
        Furthermore, we have integrated Cryptocurrency exchange to our platform. 
        Traders can enjoy trading future generation currencies, along with classical products.
      </p>
    </div>

    <!-- Card 2 -->
    <div class="card fade-in">
        <h3>Customer Satisfaction</h3>
      <img src="{{ asset('pics/customer_service.png') }}" alt="Customer Satisfaction">
      
      <p>
        Earning loyalty and outstanding customer satisfaction is our top priority. 
        We have secured a customer service team that is available 24 hours during Monday to Friday, 
        in case you need any assistance. To improve and enhance our client-facing services, we always welcome 
        incoming opinions and suggestions from you.ve our services.
      </p>
    </div>

    <!-- Card 3 -->
    <div class="card fade-in">
        <h3>Our Professional Team</h3>
      <img src="{{ asset('pics/team.png') }}" alt="Our Team">
      
      <p>
        A diverse group of finance and investment professionals committed to helping 
        our clients achieve success in forex trading. 
        We are a collection of professionals from the finance and investment sectors. 
        We are knowledgeable in all the intricacies of forex trading and we are happy to assist 
        all stakeholders to guarantee the best experiences.
      </p>
    </div>

    <!-- Card 4 -->
    <div class="card fade-in">
             <h3>Technology</h3>
      <img src="{{ asset('pics/technology.png') }}" alt="Technology">
 
      <p>
       We are a forward-thinking forex brokerage that aims to revolutionize the forex industry. 
       We have the finest technology setup for our clients to trade safely and successfully. 
       Our payment system is conducted with reputable third parties, ensuring high-level 
       security when we handle your money. 
       We are constantly striving to explore better solutions that we can add to our business 
       that will benefit you, as well as our company.
      </p>
    </div>

  </div>
</section>



    <!-- Partner Section -->
  <section class="partner-section">
 <!-- Partner Logos Slider -->
  <div class="partner-slider">
    <div class="partner-track">
        <!-- Logos (duplicate for infinite loop) -->
        <img src="https://www.tradegloballtd.com/assets/images/logos3/ethereum.png" alt="Ethereum">
        <img src="https://www.tradegloballtd.com/assets/images/logos3/onramp.png" alt="Onramp">
        <img src="https://www.tradegloballtd.com/assets/images/logos3/upi.png" alt="UPI">
        <img src="https://www.tradegloballtd.com/assets/images/logos3/usdt.png" alt="USDT">
        <img src="https://www.tradegloballtd.com/assets/images/logos3/visa.png" alt="Visa">
        <img src="https://www.tradegloballtd.com/assets/images/logos3/mastercard.png" alt="Mastercard">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal">  

      </div>
    </div>

  <!-- Bottom Cave -->
  <div class="cave-bottom">
</section>

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
        <li> <i class="fas fa-phone"></i>  +44 74 4143 0900</li>
        <li><i class="fas fa-envelope"></i>  support@infinitytradesolution.com</li>
        <li><i class="fas fa-building"></i>  20-22 Wenlock Road, London, England, N1 7GU</li>
        <!--<li><i class="fas fa-globe"></i>  57Q9+6MF - Business Bay - Dubai - UAE</li> -->
      </ul>
    </div>
  </div>

  <!-- Legal -->
  <div class="footer-legal">
    <h3>legal</h3>
    <p> This Website is Owned by Infinity Trade Solutions LTD. 
      The objects of the Company are all subject matters not forbidden by International Business Companies 
      (Amendment and Consolidation).</p>
    <h3>General Risk Warning</h3>
    <p>Trading leveraged products such as Forex and CFDs may not be suitable for all investors as they carry 
      a high degree of risk to your capital. Please ensure that you fully understand the risks involved, 
      taking into account your investments objectives and level of experience, before trading, and if necessary, 
      seek independent advice. Please read the full Risk Disclosure.</p>
    <h3>Risk disclosure</h3>
    <p>Past performance is not indicative of future results. The information on our website is provided 
      for informational purposes only and should not be construed as investment advice. 
      You should seek independent advice before making any investment decisions. Infinity Trade Solutions LTD 
      does not accept clients from the U.S., Afghanistan, Belarus, Burma, Burundi, Central African Republic, 
      China, Congo, Cuba, Egypt, Guinea, Guinea-Bissau, Iraq, Iran, Indonesia, Lebanon, Lesotho, Libya,
      Mali, Moldova, Nicaragua, Nigeria, North Korea, Pakistan, Russia, Somalia, Sudan, South Sudan, 
      Syria, Tunisia, Turkey, Vanuatu, Venezuela, Yemen, and Zimbabwe. Infinity Trade Solutions LTD 
      may reject any applicant from any jurisdiction at their sole discretion without the requirement 
      to explain the reason why (Terms and conditions).</p>
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


<script src="{{ asset('js/about.js') }}"></script>


</body>
</html>
