<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Infinity Trade Solutions LTD</title>
  <link rel="icon" type="pics/icon.png" href="pics/icon.png" />
  <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" 
rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<style>
  /* ===== Promotion Popup Centered in Banner ===== */
#promoPopupModal {
    position: fixed; /* was absolute */
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1050;
}

#promoPopupModal .modal-content {
    border: none;       /* removes border */
    box-shadow: none;   /* optional: remove shadow too */
}



#promoPopupModal .modal-dialog {
    max-width: 450px; /* popup width */
    margin: 0;
}

#promoPopupModal .modal-content {
    
    overflow: hidden;
    padding: 0;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    background-color: black;
    animation: fadeInScale 0.3s ease-in-out;
}

#promoPopupModal .modal-body {
    padding: 0;
    text-align: center;
}

#promoPopupModal .modal-body img {
    width: 100%;
    height: auto;
    
}

/* Modal header */
#promoPopupModal .modal-header {
    display: flex;
    justify-content: flex-end; /* aligns content (like your button) to the right */
    align-items: flex-start;   /* optional: aligns vertically to the top */
           /* adjust padding if needed */
}

/* Close button */
.custom-close {
    font-size: 1rem;
background: #ffffff51;
    border: none;
    border-radius: 10%;
    cursor: pointer;
    transition: background 0.3s;
margin-right: 5px;
padding: 5px;
}


.custom-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

/* Blur only hero section when modal is active */
.hero.modal-open-blur {
    filter: blur(4px);
}

/* Popup animation */
@keyframes fadeInScale {
    0% {
        transform: scale(0.8);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}


</style>

</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>


<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Promotion Popup Modal -->
@if($popup = \App\Models\Promotion::where('popup_enabled', true)->latest()->first())
<div class="modal fade" id="promoPopupModal" tabindex="-1" aria-labelledby="promoPopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0">
                <button type="button" class="custom-close" onclick="closeModal()" aria-label="Close">×</button>

            </div>
            <div class="modal-body p-0 text-center">
                @if($popup->popup_image)
                    <img src="{{ asset('storage/'.$popup->popup_image) }}" class="img-fluid" alt="Promotion">
                @endif
            </div>
        </div>
    </div>
</div>
@endif

<!-- ===== HEADER ===== -->
<header>
    <div class="logo">
      <h2><a href="{{ route('home') }}">Infinity Trade</a></h2></a>
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

  <div class="trading-shapes">
    <span></span><span></span><span></span><span></span><span></span>
    <span></span><span></span><span></span><span></span><span></span>
    <span></span><span></span><span></span><span></span><span></span>
    <span></span><span></span><span></span><span></span><span></span>
    <span></span><span></span><span></span><span></span><span></span>
  </div>

  <div class="hero-content scroll-animate">
    <h1 id="hero-title" class="gradient-text">Access The Unlimited Leverage</h1>
    <p id="hero-text" class="gradient-text-small">Enter the world of limitless possibilities</p>

    <div class="hero-buttons">
      <a href="{{ route('signup') }}">Get Started</a>
      <a href="#" id="watchVideoBtn">Watch Video</a>
    </div>
  </div>

  <div class="hero-image scroll-animate">
    <img src="{{ asset('pics/cover4.png') }}" alt="Trading Illustration">
  </div>
</section>

<!-- ===== VIDEO POPUP MODAL ===== -->
<div id="videoPopup" class="video-popup">
  <div class="video-popup-content">
    <span id="closeVideo">&times;</span>
    <iframe id="videoFrame" width="100%" height="400" frameborder="0" allowfullscreen></iframe>
  </div>
</div>

<!-- ========== ABOUT US SECTION ========== -->
<section class="about">

  <div class="about-coins">
    <img src="{{ asset('pics/img1.png') }}" alt="coin">
    <img src="{{ asset('pics/img2.png') }}" alt="coin">
    <img src="{{ asset('pics/img3.png') }}" alt="coin">
 
 
  </div>

  <div class="about-container">
    <!-- Left Side: Company Info -->
<div class="about-info">
  <div class="about-grid">
    
    <!-- Company Image -->
    <div class="about-image">
      <img src="{{ asset('pics/about1.webp') }}" alt="About ITrade Solutions LTD">
    </div>
    
    <!-- Content -->
    <div class="about-text">
      <h2>About <span>Infinity Trade Solutions</span></h2>
      <p>
        Infinity Trade Solutions LTD is a leading trading company offering innovative solutions for individuals, 
        institutions, and businesses worldwide. We provide diverse financial instruments, 
        advanced technology, and transparent services to empower clients in achieving their 
        investment goals. With a focus on customer support and a commitment to excellence, 
        Infinity Trade Solutions LTD is your trusted partner in the dynamic world of trading.
      </p>
      <p>
        Infinity Trade Solutions LTD is committed to providing exceptional customer service. 
        Our dedicated support team 
        is available 24/7 to assist clients with any queries, technical issues, or account-related 
        matters. We ensure prompt and personalized support, allowing you to focus on your trading 
        strategies without interruptions.
      </p>
      <a href="{{ route('about') }}" class="about-btn">More About Us</a>
    </div>

    <!-- Stats Cards -->
    <div class="about-stats">
      <div class="stat-card black show">
        <h3><span class="counter" data-target="95">0</span>%</h3>
        <p>Client Satisfaction</p>
      </div>
      <div class="stat-card blue show">
        <h3><span class="counter" data-target="90">0</span>%</h3>
        <p>Transparency</p>
      </div>
      <div class="stat-card purple show">
        <h3><span class="counter" data-target="85">0</span>%</h3>
        <p>Trading Success</p>
      </div>
    </div>

  </div>
</div>


    <!-- Right Side: Features -->
    <div class="about-features">
      <div class="feature-card">
        <i class="fas fa-user-tie"></i>
        <h3>Experienced</h3>
        <p>Our team of seasoned professionals brings years 
          of expertise to deliver top-notch services and support.</p>
      </div>
      <div class="feature-card">
        <i class="fas fa-users"></i>
        
        <h3>Professionals</h3>
        <p>Our dedicated team of skilled experts is 
          committed to providing personalized guidance and analysis.</p>
      </div>
      <div class="feature-card">
        <i class="fas fa-clock"></i>
        <h3>Always Available</h3>
        <p>Our platform offers 24/7 accessibility, ensuring you can trade anytime, anywhere.</p>
      </div>
      <div class="feature-card">
        <i class="fas fa-shield-alt"></i>
        <h3>We're Responsible</h3>
        <p>We prioritize safety, compliance, and ethical practices, ensuring responsible trading environments.</p>
      </div>
    </div>
  </div>
</section>

<section id="products">

   <!-- Floating Background Coins -->
   <!-- Floating Background Trading Images -->
  <div class="products-bg">
   <img src="{{ asset('pics/coin4 (1).png') }}" alt="Trading Icon 1">
   <img src="{{ asset('pics/coin5 (2).png') }}" alt="Trading Icon 2">
   <img src="{{ asset('pics/coin6 (3).png') }}" alt="Trading Icon 3">

  </div>

  <h2>Trading <span>Products</span></h2>
  <div class="products-slider">
    <div class="product-card">
      <img src="{{ asset('pics/forex.png') }}" class="product-img" alt="Product 1"> 
      <h3>Forex</h3>
      <p>The foreign exchange market (Forex) is the largest and most liquid market in the world, 
        open 24 hours a day, five days a week.</p>
      <a href="{{ route('forex') }}" class="arrow-link">Learn More</a>
    </div>
    <div class="product-card">
      <img src="{{ asset('pics/matel.png') }}" class="product-img" alt="Product 2">
      <h3>Metals</h3>
      <p>Precious metals like gold, silver, platinum, and palladium 
        are considered safe-haven assets, widely used by traders.</p>
      <a href="{{ route('metals') }}" class="arrow-link">Learn More</a>
    </div>
    <div class="product-card">
      <img src="{{ asset('pics/indices.png') }}" class="product-img" alt="Indices Product">
      <h3>Indices</h3>
      <p>Stock market indices represent the performance of groups of leading companies 
        across global economies. Popular indices like S&P 500, NASDAQ, and FTSE provide exposure.</p>
      <a href="{{ route('indices') }}" class="arrow-link">Learn More</a>
    </div>
    <div class="product-card">
      <img src="{{ asset('pics/crypto.png') }}" class="product-img" alt="product 4">
      <h3>Crypto Currency</h3>
      <p>Cryptocurrencies are decentralized digital assets built on blockchain technology. 
        Popular coins like Bitcoin, and Ripple are known for high volatility and growth potential.</p>
      <a href="{{ route('crypto') }}" class="arrow-link">Learn More</a>
    </div>
    
    <!-- more cards -->
  </div>
  <div class="slider-dots"></div>
</section>


<!-- Onboarding Steps -->
<section id="create-account">
   <h2>Get Started <span> in Minutes</span></h2>
  <div class="steps-wrapper">
    <div class="step left">
      <div class="step-number">1</div>
      <div class="step-content">
        <h3>Create Account</h3>
        <p>Sign up and open your live trading account with Infinity Trade Solutions LTD.</p>
      </div>
    </div>
    <div class="step right">
      <div class="step-number">2</div>
      <div class="step-content">
        <h3>Verify</h3>
        <p>Upload your documents to verify your account with Infinity Trade Solutions LTD.</p>
      </div>
    </div>
    <div class="step left">
      <div class="step-number">3</div>
      <div class="step-content">
        <h3>Invest</h3>
        <p>Log in and fund your account to start investing.</p>
      </div>
    </div>
    <div class="step right">
      <div class="step-number">4</div>
      <div class="step-content">
        <h3>Trade</h3>
        <p>Enjoy hassle-free trading on multiple financial products.</p>
      </div>
    </div>
    <div class="step left">
      <div class="step-number">5</div>
      <div class="step-content">
        <h3>Withdraw</h3>
        <p>Withdraw your profit safe and securely.</p>
      </div>
    </div>
  </div>
</section>


<!-- Pricing / Account Types -->
<section id="pricing">
  <div class="pricing-container">
    <h2>Our <span>Plans</span></h2>
    <div class="pricing-grid">

      @foreach($plans as $plan)
        <article class="pricing-card">
          <div class="price">${{ number_format($plan->price, 0) }}</div>
          <h3>{{ $plan->name }}</h3>
          <ul>
            <li>Leverage {{ $plan->leverage }}</li>
            <li>Min lot size {{ $plan->min_lot_size }}</li>
            <li>Starting from {{ $plan->starting_pips }} pips</li>
            <li>{{ $plan->swap }}</li>
            <li>Commission {{ $plan->commission }}</li>
          </ul>
          <a href="{{ route('login') }}" class="btn">Choose plan</a>
        </article>
      @endforeach

    </div>
  </div>
</section>

<!-- Meet Our Client Section-->
<section id="testimonials">
  <div class="section-header">
    <h2>Meet Our <span>Clients</span></h2>
    <a href="{{ route('login') }}" class="btn">Be Our Client</a>
  </div>

  <!-- Dots Navigation -->
<div class="testimonial-dots">
  <span class="active"></span>
  <span></span>
  <span></span>
  <span></span>
</div>


  <div class="testimonial-wrapper">

    <!-- Track -->
    <div class="testimonial-container">
      <div class="testimonial-track">
        <!-- Card 1 -->
        <div class="testimonial-card">
          <p>I admire Infinity Trade Solutions LTD’s combination of tools and support. 
            Trading is fast, deposits and withdrawals are hassle-free, and transparency builds trust. 
            It truly feels like a safe and professional environment for long-term trading success and growth.
            <div class="client-info">
            <img src="{{ asset('pics/profile2.jpg') }}" alt="Client">
            <div>
              <h4>Fatima Al Mansoori</h4>
              <span>Abu Dhabi, UAE</span>
            </div>
           
          </div>
        </div>

        

        <!-- Card 2 -->
        <div class="testimonial-card">
          <p>As a beginner, I learned quickly with Infinity Trade Solutions LTD. 
            The platform is simple yet powerful, and support is always professional. 
            Trading feels smooth, and I trust them completely. 
            Infinity Trade Solutions LTD gave me confidence to grow steadily as a trader.</p>
          <div class="client-info">
            <img src="{{ asset('pics/profile1.jpg') }}" alt="Client">
            <div>
              <h4>Aisha Rahman</h4>
              <span>Dubai, UAE</span>
            </div>
          
          </div>
        </div>

        <!-- Card 3 -->
        <div class="testimonial-card">
          <p>Infinity Trade Solutions LTD offers advanced tools and a simple interface that make trading easier. 
            The mobile-friendly design helps me monitor trades anytime. With fast execution, 
            and strong security, I feel safe while trading on this platform.</p>
          <div class="client-info">
            <img src="{{ asset('pics/profile3.jpg') }}" alt="Client">
            <div>
              <h4>Ravi Menon</h4>
              <span>Kochi, India</span>
            </div>
           
          </div>
        </div>

        <!-- Add more cards as needed -->
        <div class="testimonial-card">
          <p>I’ve been trading with Infinity Trade Solutions LTD for months and love the reliability. 
            The platform is transparent, withdrawals are smooth, and support is responsive. 
            It has built my confidence and made trading a stress-free and rewarding experience.</p>
          <div class="client-info">
            <img src="{{ asset('pics/profile.jpg') }}" alt="Client">
            <div>
              <h4>Sathya Priya</h4>
              <span>Mumbai, India</span>
            </div>
          
          </div>
        </div>

        <!-- Card 1 -->
        <div class="testimonial-card">
          <p>I admire Infinity Trade Solutions LTD’s combination of tools and support. 
            Trading is fast, deposits and withdrawals are hassle-free, and transparency builds trust. 
            It truly feels like a safe and professional environment for long-term trading success and growth.
            <div class="client-info">
            <img src="{{ asset('pics/profile2.jpg') }}" alt="Client">
            <div>
              <h4>Fatima Al Mansoori</h4>
              <span>Abu Dhabi, UAE</span>
            </div>
           
          </div>
        </div>

        <!-- Card 2 -->
        <div class="testimonial-card">
          <p>As a beginner, I learned quickly with Infinity Trade Solutions LTD. 
            The platform is simple yet powerful, and support is always professional. 
            Trading feels smooth, and I trust them completely. 
            Infinity Trade Solutions LTD gave me confidence to grow steadily as a trader.</p>
          <div class="client-info">
            <img src="{{ asset('pics/profile1.jpg') }}" alt="Client">
            <div>
              <h4>Aisha Rahman</h4>
              <span>Dubai, UAE</span>
            </div>
          
          </div>
        </div>

        


      </div>
    </div>
  </div>
</section>

<section id="faq">

<!-- Place this where you want the ticker -->
<div class="tradingview-widget-container">
  <div id="tv-tape"></div>
  <div class="tradingview-widget-copyright">
    <a href="https://www.tradingview.com/markets/" target="_blank" rel="noopener nofollow">
    </a>
  </div>
</div>

<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <div class="tradingview-widget-copyright">
    <a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank">
      </a></div>
  <script type="text/javascript" 
  src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
  {
  "symbols": [
    {
      "proName": "FOREXCOM:SPXUSD",
      "title": "S&P 500 Index"
    },
    {
      "proName": "FOREXCOM:NSXUSD",
      "title": "US 100 Cash CFD"
    },
    {
      "proName": "FX_IDC:EURUSD",
      "title": "EUR to USD"
    },
    {
      "proName": "BITSTAMP:BTCUSD",
      "title": "Bitcoin"
    },
    {
      "proName": "BITSTAMP:ETHUSD",
      "title": "Ethereum"
    }
  ],
  "colorTheme": "light",
  "locale": "en",
  "largeChartUrl": "",
  "isTransparent": false,
  "showSymbolLogo": true,
  "displayMode": "adaptive"
}
  </script>
</div>
<!-- TradingView Widget END -->



  <div class="faq-floating">
    <img src="{{ asset('pics/faq1.png') }}" alt="">
    <img src="{{ asset('pics/faq2.png') }}" alt="">
    <img src="{{ asset('pics/faq3.png') }}" alt="">
  </div>

  <div class="faq-wrapper">
    
    <!-- Left Side FAQ -->
    <div class="faq-container">
      <h2>Most Common <span>FAQs</span></h2>

      <!-- FAQ Item -->
      <div class="faq-item active">
        <button class="faq-question">
          What Are CFD's?
          <span class="faq-icon">−</span>
        </button>
        <div class="faq-answer">
          <p>
            Contract for Difference (CFD) is a derivative financial instrument that allows you to
            speculate on the price movements of assets without owning them. You can profit from
            rising and falling markets by taking long or short positions.
          </p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          What Trading Platform Do You Offer?
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-answer">
          <p>
            We provide a secure, user-friendly trading platform with advanced tools for both
            beginners and professionals.
          </p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          How Do I Open A Trading Account?
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-answer">
          <p>
            Opening an account is simple: complete registration, verify your ID, and fund your
            account.
          </p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          What Is Online Trading, How It Work?
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-answer">
          <p>
            Online trading lets you buy/sell financial instruments over the internet with instant
            market access.
          </p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          What Risk Management Tools Are Available?
          <span class="faq-icon">+</span>
        </button>
        <div class="faq-answer">
          <p>
            We offer stop-loss, take-profit, and trailing stop orders to protect your capital and
            lock in profits.
          </p>
        </div>
      </div>
    </div>

    <!-- Right Side Image -->
    <div class="faq-image">
      <img src="{{ asset('pics/faq (2).png') }}" alt="FAQ Illustration">
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
      <!--<img src="" alt="Tradefx Logo" class="footer-logo">-->
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
    <p> This Website is Owned by Infinity Trade Solutions LTD. 
      The objects of the Company are all subject matters not forbidden by International Business Companies 
      (Amendment and Consolidation).</p>
    <h3>General Risk Warning</h3>
    <p>Trading leveraged products such as Forex and CFDs may not be suitable for all investors as 
      they carry a high degree of risk to your capital. Please ensure that you fully understand 
      the risks involved, taking into account your investments objectives and level of experience, 
      before trading, and if necessary, seek independent advice. Please read the full Risk Disclosure.</p>
    <h3>Risk disclosure</h3>
    <p>Past performance is not indicative of future results. The information on our website is provided 
      for informational purposes only and should not be construed as investment advice. 
      You should seek independent advice before making any investment decisions. Infinity Trade Solutions LTD 
      does not accept clients from the U.S., Afghanistan, Belarus, Burma, Burundi, Central African Republic, 
      China, Congo, Cuba, Egypt, Guinea, Guinea-Bissau, Iraq, Iran, Indonesia, Lebanon, Lesotho, Libya, Malaysia, 
      Maldives, Mali, Moldova, Nicaragua, Nigeria, North Korea, Pakistan, Russia, Somalia, Sudan, South Sudan, 
      Syria, Tunisia, Turkey, Vanuatu, Venezuela, Yemen, and Zimbabwe. Infinity Trade Solutions LTD 
      may reject any applicant from any jurisdiction at their sole discretion without the requirement to 
      explain the reason why (Terms and conditions).</p>
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


<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const modalEl = document.getElementById('promoPopupModal');
    const hero = document.querySelector('.hero');
    let confettiInterval;

    // Function to show the modal
    function showModal() {
        modalEl.style.display = "flex"; // show modal
        modalEl.classList.add('show');
        hero.classList.add('modal-open-blur');
        document.body.style.overflow = 'hidden'; // disable background scroll

        // Start continuous confetti
        confettiInterval = setInterval(() => {
            confetti({
                particleCount: 20 + Math.floor(Math.random() * 5),
                spread: 200,
                origin: { x: Math.random(), y: 0.5 },
                gravity: 0.5
            });
        }, 200);
    }

    // Function to close modal
    window.closeModal = function() {
        modalEl.style.display = "none"; // hide modal
        modalEl.classList.remove('show');
        hero.classList.remove('modal-open-blur');
        document.body.style.overflow = ''; // restore scroll

        if(confettiInterval) clearInterval(confettiInterval);
    }

    // Show modal on page load
    if(modalEl) showModal();
});
</script>


<script src="{{ asset('js/test.js') }}"></script>
</body>
</html>
