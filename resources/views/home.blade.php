<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Corefx Solutions</title>
  <link rel="icon" type="pics/icon.png" href="pics/Corefx.png" />
  <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" 
rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
<style>
/* ===============================
   🌟 Promotion Popup (FXM Style)
=============================== */
/* Full-page blur when modal is open */
body.modal-open::before {
    content: "";
    position: fixed;
    inset: 0;
    backdrop-filter: blur(8px);
    background: rgba(0,0,0,0.3);
    z-index: 1049;
    pointer-events: none; /* allows clicking only the modal */
    transition: backdrop-filter 0.3s ease, background 0.3s ease;
}

#promoPopupModal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1050;
}

/* --- Modal Dialog --- */
#promoPopupModal .modal-dialog {
    max-width: 650px;
    margin: 0;
}

/* --- Modal Content --- */
#promoPopupModal .modal-content {
    position: relative;
    border: none;
    border-radius: 16px;
    overflow: hidden;
    background: #000;
    padding: 0;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.5);
    animation: fadeInScale 0.4s ease-in-out;
}

/* --- Image --- */
#promoPopupModal .modal-body {
    padding: 0;
    text-align: center;
    position: relative;
}

#promoPopupModal .modal-body img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    border-radius: 16px; /* round popup corners */
}

/* --- Close Button Inside Image --- */
.custom-close {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.6);
    border: none;
    color: #fff;
    font-size: 20px;
    font-weight: bold;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
}

.custom-close:hover {
    background: #a855f7;
    transform: scale(1.1);
}

/* --- Animation --- */
@keyframes fadeInScale {
    0% {
        transform: scale(0.85);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* --- Blur hero section when active --- */
.hero.modal-open-blur {
    filter: blur(5px);
}

/* ===============================
   🌟 Responsive Styles for Promo Popup
=============================== */

/* Small devices: mobile (≤ 576px) */
@media (max-width: 576px) {
    #promoPopupModal {
        width: 95vw;       /* nearly full width */
        height: 85vh;      /* almost full height */
    }

    #promoPopupModal .modal-dialog {
        width: 100%;
        height: 100%;
    }

    #promoPopupModal .modal-content {
        border-radius: 12px;  /* slightly smaller corners for small screens */
    }

    #promoPopupModal .modal-body img {
        border-radius: 12px;
        object-fit: contain;   /* prevent image from being cropped */
    }

    .custom-close {
        top: 6px;
        right: 6px;
        font-size: 18px;
        width: 28px;
        height: 28px;
    }
}

/* Medium devices: tablets (≤ 768px) */
@media (max-width: 768px) {
    #promoPopupModal {
        width: 90vw;
        height: 88vh;
    }

    #promoPopupModal .modal-content {
        border-radius: 14px;
    }

    .custom-close {
        top: 8px;
        right: 8px;
        font-size: 19px;
        width: 30px;
        height: 30px;
    }
}

/* Large devices: small desktops (≤ 992px) */
@media (max-width: 992px) {
    #promoPopupModal {
        width: 80vw;
        height: 80vh;
    }

    #promoPopupModal .modal-content {
        border-radius: 16px;
    }

    .custom-close {
        top: 10px;
        right: 10px;
        font-size: 20px;
        width: 32px;
        height: 32px;
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="custom-close" onclick="closeModal()" aria-label="Close">×</button>

            </div>
            <div class="modal-body">
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
            <!--<li><a href="{{ route('mutualfunds') }}">Mutual Funds</a></li> -->
            <li><a href="{{ route('promotion.show') }}">Promotions</a></li>
            <li><a href="{{ route('contact') }}">Contact Us</a></li>
            <li class="login-btn"><a href="{{ route('login') }}">Log In</a></li>
        </ul>
    </nav>
</header>

<!-- ===== HERO SECTION ===== -->
<section class="hero">

   <div class="hero-content scroll-animate">
<h1 id="hero-title" class="gradient-text">Empower Your Trading Journey to Success</h1>
<p id="hero-text" class="gradient-text-small">Where strategy meets opportunity without limits</p>

    <div class="hero-buttons">
      <a href="{{ route('signup') }}">Get Started</a>
     <!-- <a href="#" id="watchVideoBtn">Watch Video</a> -->
    </div>
  </div>


  <div class="hero-image scroll-animate">
    <img src="{{ asset('pics/test.png') }}" alt="Trading Illustration">
  </div>
</section>

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
  "colorTheme": "dark",
  "locale": "en",
  "largeChartUrl": "",
  "isTransparent": false,
  "showSymbolLogo": true,
  "displayMode": "adaptive"
}
  </script>
</div>
<!-- TradingView Widget END -->

<!-- ===== VIDEO POPUP MODAL ===== 
<div id="videoPopup" class="video-popup">
  <div class="video-popup-content">
    <span id="closeVideo">&times;</span>
    <iframe id="videoFrame" width="100%" height="400" frameborder="0" allowfullscreen></iframe>
  </div>
</div> -->

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

      <!-- Stats Cards -->
    <div class="about-stats">
      <div class="stat-card green-dark">
        <h3><span class="counter" data-target="95">0</span>%</h3>
        <p>Client Satisfaction</p>
      </div>
      <div class="stat-card green-emerald">
        <h3><span class="counter" data-target="90">0</span>%</h3>
        <p>Transparency</p>
      </div>
      <div class="stat-card green-olive">
        <h3><span class="counter" data-target="85">0</span>%</h3>
        <p>Trading Success</p>
      </div>
    </div>
    
        <!-- Company Image -->
    <div class="about-image">
      <img src="{{ asset('pics/about1.png') }}" alt="About ITrade Solutions LTD">
    </div>


  </div>
 <div class="about-text">
      <h2>About <span>CORE FINANCE LIMITED</span></h2>

<p>
  CORE FINANCE LIMITED is a globally focused trading company delivering innovative 
  financial solutions to individuals, institutions, and businesses. We provide access 
  to a wide range of financial instruments including Forex, Crypto, Metals, and Indices, 
  supported by advanced trading technology and transparent operations.
</p>

<p>
  Our mission is to empower clients to achieve their investment goals through 
  secure platforms, competitive trading conditions, and real-time market insights. 
  We prioritize integrity, performance, and long-term partnerships in the dynamic 
  world of global financial markets.
</p>

<p>
  At CORE FINANCE LIMITED, client satisfaction comes first. Our professional support 
  team is available 24/7 to assist with account management, technical guidance, 
  and trading inquiries — ensuring a smooth and uninterrupted trading experience.
</p>
      <a href="{{ route('about') }}" class="about-btn">More About Us</a>
    </div>

      <!-- Right Side: Features -->

</div>
<div class="circle-container">
  <!-- SVG lines connecting cards -->
  <svg class="connect-lines" width="100%" height="100%">
    <path class="line-top-right" />
    <path class="line-right-bottom" />
    <path class="line-bottom-left" />
    <path class="line-left-top" />
  </svg>

  <!-- Cards -->
  <div class="feature-card top">
    <i class="ti ti-user-check"></i>
    <h3>Experienced</h3>
    <p>Our team of seasoned professionals brings years of expertise to deliver top-notch services and support.</p>
  </div>

  <div class="feature-card right">
    <i class="ti ti-users"></i>
    <h3>Professionals</h3>
    <p>Our dedicated team of skilled experts is committed to providing personalized guidance and analysis.</p>
  </div>

  <div class="feature-card bottom">
    <i class="ti ti-clock"></i>
    <h3>Always Available</h3>
    <p>Our platform offers 24/7 accessibility, ensuring you can trade anytime, anywhere.</p>
  </div>

  <div class="feature-card left">
    <i class="ti ti-shield-lock"></i>
    <h3>We're Responsible</h3>
    <p>We prioritize safety, compliance, and ethical practices, ensuring responsible trading environments.</p>
  </div>
</div>
  </div>
  <script>
    // JavaScript to dynamically connect lines between cards
const container = document.querySelector('.circle-container');
const lines = {
  topRight: document.querySelector('.line-top-right'),
  rightBottom: document.querySelector('.line-right-bottom'),
  bottomLeft: document.querySelector('.line-bottom-left'),
  leftTop: document.querySelector('.line-left-top'),
};

function connectCards() {
  const top = document.querySelector('.feature-card.top').getBoundingClientRect();
  const right = document.querySelector('.feature-card.right').getBoundingClientRect();
  const bottom = document.querySelector('.feature-card.bottom').getBoundingClientRect();
  const left = document.querySelector('.feature-card.left').getBoundingClientRect();
  const svgRect = container.getBoundingClientRect();

  function setCurve(line, start, end) {
    const x1 = start.x - svgRect.left;
    const y1 = start.y - svgRect.top;
    const x2 = end.x - svgRect.left;
    const y2 = end.y - svgRect.top;

    const midX = (x1 + x2) / 2;
    const midY = (y1 + y2) / 2;
    const dx = x2 - x1;
    const dy = y2 - y1;
    const dist = Math.hypot(dx, dy) || 1;

    const nx = -dy / dist;
    const ny = dx / dist;
    const curveStrength = Math.min(70, Math.max(28, dist * 0.12));

    const cx = midX + nx * curveStrength;
    const cy = midY + ny * curveStrength;

    line.setAttribute('d', `M ${x1} ${y1} Q ${cx} ${cy} ${x2} ${y2}`);
  }

  setCurve(lines.topRight, {x: top.left + top.width/2, y: top.top + top.height/2}, {x: right.left + right.width/2, y: right.top + right.height/2});
  setCurve(lines.rightBottom, {x: right.left + right.width/2, y: right.top + right.height/2}, {x: bottom.left + bottom.width/2, y: bottom.top + bottom.height/2});
  setCurve(lines.bottomLeft, {x: bottom.left + bottom.width/2, y: bottom.top + bottom.height/2}, {x: left.left + left.width/2, y: left.top + left.height/2});
  setCurve(lines.leftTop, {x: left.left + left.width/2, y: left.top + left.height/2}, {x: top.left + top.width/2, y: top.top + top.height/2});
}

// Run on load and on resize
window.addEventListener('load', connectCards);
window.addEventListener('resize', connectCards);
    </script>
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
      
      <h3>Forex</h3>
      <p>The foreign exchange market (Forex) is the largest and most liquid market in the world, 
        open 24 hours a day, five days a week.</p>
      <a href="{{ route('forex') }}" class="arrow-link">Learn More</a>
    </div>
    <div class="product-card">
      
      <h3>Metals</h3>
      <p>Precious metals like gold, silver, platinum, and palladium 
        are considered safe-haven assets, widely used by traders.</p>
      <a href="{{ route('metals') }}" class="arrow-link">Learn More</a>
    </div>
    <div class="product-card">
      
      <h3>Indices</h3>
      <p>Stock market indices represent the performance of groups of leading companies 
        across global economies. Popular indices like S&P 500, NASDAQ, and FTSE provide exposure.</p>
      <a href="{{ route('indices') }}" class="arrow-link">Learn More</a>
    </div>
    <div class="product-card">
      
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
        <p>Sign up and open your live trading account with Core Finance LTD.</p>
      </div>
    </div>
    <div class="step right">
      <div class="step-number">2</div>
      <div class="step-content">
        <h3>Verify</h3>
        <p>Upload your documents to verify your account with Core Finance LTD.</p>
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
    <article class="pricing-card @if($loop->last) highlight-card @endif">
      <div class="price">${{ number_format($plan->price, 0) }}</div>
      <h3>{{ $plan->name }}</h3>
      <ul>
        <li>Leverage {{ $plan->leverage }}</li>
        <li>Min lot size {{ $plan->min_lot_size }}</li>
        <li>Starting from {{ $plan->starting_pips }} pips</li>
        <li>{{ $plan->swap }}</li>
        <li>Commission {{ $plan->commission }}%</li>
        <li>{{ $plan->spread }}</li>
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

 


  <div class="testimonial-wrapper">

  <div class="testimonial-container">
    <div class="testimonial-track">

      <!-- Card 1 -->
      <div class="testimonial-card">
        <div class="client-top">
          <img src="{{ asset('pics/client2.jpg') }}" alt="Daniel Thompson">
          <h4>Daniel Thompson</h4>
          <span class="location">London, United Kingdom</span>
          <div class="stars">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-half-o"></i>
          </div>
        </div>
        <p>
          CORE FINANCE LIMITED delivers exceptional trading conditions. 
          The execution speed is impressive, and the analytics tools help 
          me make informed decisions. It’s a reliable platform for serious traders.
        </p>
      </div>

      <!-- Card 2 -->
      <div class="testimonial-card">
        <div class="client-top">
          <img src="{{ asset('pics/client.webp') }}" alt="Fatima Hassan">
          <h4>Fatima Hassan</h4>
          <span class="location">Doha, Qatar</span>
          <div class="stars">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
          </div>
        </div>
        <p>
          The platform is very user-friendly and secure. 
          Deposits and withdrawals are processed smoothly, 
          and customer support is available whenever I need help.
        </p>
      </div>

      <!-- Card 3 -->
      <div class="testimonial-card">
        <div class="client-top">
          <img src="{{ asset('pics/client3.webp') }}" alt="Rahul Mehta">
          <h4>Rahul Mehta</h4>
          <span class="location">Chennai, India</span>
          <div class="stars">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-half-o"></i>
            <i class="fa fa-star-o"></i>
          </div>
        </div>
        <p>
          I appreciate the transparency and advanced charting tools. 
          The mobile trading experience is smooth, and I can monitor 
          markets anytime without issues.
        </p>
      </div>

      <!-- Card 4 -->
      <div class="testimonial-card">
        <div class="client-top">
          <img src="{{ asset('pics/client1.avif') }}" alt="Olivia Martinez">
          <h4>Olivia Martinez</h4>
          <span class="location">Madrid, Spain</span>
          <div class="stars">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
          </div>
        </div>
        <p>
          Trading with CORE FINANCE LIMITED has been a great experience. 
          The interface is modern, execution is reliable, and 
          I feel confident managing my investments here.
        </p>
      </div>

    </div>
  </div>
</div>
</section>

<!-- Place this where you want the ticker -->
<div class="tradingview-widget-container">
  <div id="tv-tape"></div>
  <div class="tradingview-widget-copyright">
    <a href="https://www.tradingview.com/markets/" target="_blank" rel="noopener nofollow">
    </a>
  </div>
</div>



<section id="faq">

  <div class="faq-wrapper">

    <!-- Full Width FAQ -->
    <div class="faq-container full-width">
      <h2>Most Common <span>FAQs</span></h2>

      <!-- FAQ Item -->
      <div class="faq-item active">
        <button class="faq-question">
          What Is CFD Trading?
          <span class="faq-icon">&#9650;</span> <!-- ▲ -->
        </button>
        <div class="faq-answer">
          <p>
  A Contract for Difference (CFD) is a financial derivative that allows traders to speculate on the price movements of various assets — such as forex, stocks, indices, commodities, and cryptocurrencies — without actually owning the underlying asset.

  Instead of purchasing the asset itself, you enter into an agreement with a broker to exchange the difference in the asset’s price between the time the contract is opened and when it is closed.

  CFDs allow traders to profit in both rising and falling markets by taking either a <strong>long position</strong> (buy) if they expect the price to increase, or a <strong>short position</strong> (sell) if they expect the price to decrease. <br/><br/>

  One of the key advantages of CFD trading is the use of <strong>leverage</strong>, which enables traders to control larger positions with a smaller amount of capital. However, while leverage can increase potential profits, it also significantly increases the level of risk.

  CFDs are popular among traders because they offer flexibility, access to global markets, fast execution, and the ability to hedge existing investments. Proper risk management strategies such as stop-loss and take-profit orders are strongly recommended when trading CFDs.
</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          What Trading Platform Do You Offer?
          <span class="faq-icon">&#9660;</span> <!-- ▼ -->
        </button>
        <div class="faq-answer">
          <p>
  We offer a powerful and secure multi-asset trading platform designed to meet the needs of both beginner and professional traders. Our platform provides real-time market data, advanced charting tools, and a wide range of technical indicators to help you analyze market movements with precision.

  Traders can access multiple asset classes including Forex, commodities, indices, stocks, and cryptocurrencies — all from a single intuitive interface. The platform supports instant trade execution, flexible order types (market, limit, stop-loss, take-profit), and customizable trading layouts.

  <br/> <br/>Our system is built with high-level encryption technology to ensure maximum security of your funds and personal data. It is accessible via desktop, web browser, and mobile devices, allowing you to trade anytime, anywhere.

  Whether you are just starting your trading journey or managing advanced strategies, our platform provides the performance, stability, and tools required to trade with confidence.
</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          How Do I Open A Trading Account?
          <span class="faq-icon">&#9660;</span>
        </button>
        <div class="faq-answer">
          <p>
  Opening a trading account with us is a simple and secure process. First, complete the online registration form by providing your basic personal information. Once registered, you will need to verify your identity by submitting valid identification documents (such as a passport or national ID) and proof of address, in compliance with regulatory requirements.

  After verification is approved, you can fund your account using one of our secure payment methods, including bank transfer, credit/debit card, or supported online payment systems. Once your deposit is confirmed, you can access the trading platform, explore available markets, and begin trading immediately.

  Our support team is available to assist you throughout the entire onboarding process to ensure a smooth and hassle-free experience.
</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          What Is Online Trading, How It Work?
          <span class="faq-icon">&#9660;</span>
        </button>
        <div class="faq-answer">
          <p>
  Online trading is the process of buying and selling financial instruments such as Forex, stocks, commodities, indices, and cryptocurrencies through an internet-based trading platform. Instead of contacting a broker by phone, traders can access global markets instantly using a computer or mobile device.

  The process works by placing buy (long) or sell (short) orders based on your market analysis and trading strategy. When you open a trade, you speculate on the price movement of an asset. If the market moves in your favor, you can close the trade to realize a profit. If it moves against you, a loss may occur.

  Modern trading platforms provide real-time pricing, advanced charting tools, risk management features, and instant execution to help traders make informed decisions efficiently.
</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          What Risk Management Tools Are Available?
          <span class="faq-icon">&#9660;</span>
        </button>
        <div class="faq-answer">
          <p>
  We provide a comprehensive range of risk management tools to help traders protect their capital and manage market exposure effectively. These tools include Stop-Loss orders, which automatically close a trade at a predetermined loss level, and Take-Profit orders, which secure profits once a target price is reached.

  Additionally, Trailing Stop orders allow traders to lock in profits dynamically as the market moves in their favor. Margin monitoring tools and real-time account analytics are also available to help you maintain control over your risk levels.

  While these tools are designed to support disciplined trading, we strongly encourage traders to apply proper risk management strategies and never risk more than they can afford to lose.
</p>
        </div>
      </div>

    </div>

  </div>
</section>


<script>
  const faqItems = document.querySelectorAll(".faq-item");

  faqItems.forEach(item => {
    const question = item.querySelector(".faq-question");

    question.addEventListener("click", () => {

      faqItems.forEach(i => {
        if (i !== item) {
          i.classList.remove("active");
          i.querySelector(".faq-icon").innerHTML = "▼";
        }
      });

      item.classList.toggle("active");

      const icon = item.querySelector(".faq-icon");
      icon.innerHTML = item.classList.contains("active") ? "▲" : "▼";
    });
  });
</script>
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

<!-- Back to Top Button -->
<button id="backToTop" class="back-to-top">
  ↑
</button>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const modalEl = document.getElementById('promoPopupModal');

    function showModal() {
        modalEl.style.display = "flex";
        modalEl.classList.add('show');
        document.body.classList.add('modal-open'); // enables blur
        document.body.style.overflow = 'hidden'; // prevent scrolling
    }

    window.closeModal = function() {
        modalEl.style.display = "none";
        modalEl.classList.remove('show');
        document.body.classList.remove('modal-open'); // remove blur
        document.body.style.overflow = ''; // restore scrolling
    }

    if(modalEl) showModal();
});

</script>



<script src="{{ asset('js/test.js') }}"></script>
<script>
function toggleMenu() {
  const header = document.querySelector("header");
  const nav = header ? header.querySelector("nav") : null;
  const hamburger = header ? header.querySelector(".hamburger") : null;
  if (!nav || !hamburger) return;

  nav.classList.toggle("active");
  hamburger.classList.toggle("active");
}

document.addEventListener("DOMContentLoaded", function () {
  const header = document.querySelector("header");
  if (!header) return;

  const nav = header.querySelector("nav");
  const hamburger = header.querySelector(".hamburger");
  if (!nav || !hamburger) return;

  // Close mobile menu when a nav link is selected.
  nav.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", function () {
      nav.classList.remove("active");
      hamburger.classList.remove("active");
    });
  });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const counters = document.querySelectorAll(".stat-card .counter");
  if (!counters.length) return;

  function runCounter(counter) {
    if (counter.dataset.done === "1") return;
    counter.dataset.done = "1";

    const target = Number(counter.getAttribute("data-target")) || 0;
    let current = 0;
    const step = Math.max(1, Math.ceil(target / 80));

    const tick = () => {
      current += step;
      if (current < target) {
        counter.textContent = current;
        requestAnimationFrame(tick);
      } else {
        counter.textContent = target;
      }
    };

    counter.textContent = "0";
    tick();
  }

  const cards = document.querySelectorAll(".stat-card");
  if ("IntersectionObserver" in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const counter = entry.target.querySelector(".counter");
          if (counter) runCounter(counter);
        }
      });
    }, { threshold: 0.1 });

    cards.forEach((card) => io.observe(card));
  } else {
    counters.forEach(runCounter);
  }

  // Backup trigger for first render
  setTimeout(() => counters.forEach(runCounter), 300);
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  if (window.__heroSliderRunning) return;
  window.__heroSliderRunning = true;

  const titleEl = document.getElementById("hero-title");
  const textEl = document.getElementById("hero-text");
  if (!titleEl || !textEl) return;

  const slides = [
    {
      title: "Empower Your Trading Journey to Success",
      text: "Where strategy meets opportunity without limits"
    },
    {
      title: "Trade Smarter, Build Stronger Every Day",
      text: "Advanced tools and live insights crafted for your success"
    },
    {
      title: "Begin Your Journey to Financial Independence",
      text: "Join a global network of motivated traders"
    }
  ];

  let index = 0;
  const animateTo = (nextIndex) => {
    titleEl.classList.remove("zoom-in");
    textEl.classList.remove("zoom-in");
    titleEl.classList.add("zoom-out");
    textEl.classList.add("zoom-out");

    setTimeout(() => {
      index = nextIndex % slides.length;
      titleEl.classList.remove("zoom-out");
      textEl.classList.remove("zoom-out");
      titleEl.textContent = slides[index].title;
      textEl.textContent = slides[index].text;
      titleEl.classList.add("zoom-in");
      textEl.classList.add("zoom-in");
    }, 400);
  };

  setInterval(() => animateTo(index + 1), 3000);
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const steps = document.querySelectorAll("#create-account .step");
  if (!steps.length) return;

  steps.forEach((step, i) => {
    setTimeout(() => step.classList.add("show"), i * 200);
  });
});
</script>

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
</script>
End of Tawk.to Script-->

</body>
</html>
