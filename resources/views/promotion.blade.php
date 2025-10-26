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

    <link rel="stylesheet" href="{{ asset('css/promotion.css') }}">

</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

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

<div class="container1">
@php
    $bannerPromotions = $promotions->filter(fn($p) => $p->poster_large)->values();
@endphp

@if($bannerPromotions->isNotEmpty())
<div class="container py-4 custom-container1" id="bannerSection">
    <!--  <h2 class="text-center mb-5">Featured Promotion</h2>-->

    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($bannerPromotions as $key => $promo)
            <div class="carousel-item @if($key==0) active @endif">
                <img src="{{ asset('storage/' . $promo->poster_large) }}" 
                     class="d-block w-100 rounded" 
                     alt="{{ $promo->title }}">
            </div>
            @endforeach
        </div>
        @if($bannerPromotions->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        @endif
    </div>
</div>
@endif
<hr>

@php
    $largePosters = $promotions->filter(fn($p) => $p->poster_medium)->values();
@endphp

@if($largePosters->isNotEmpty())
<div class="container py-4 custom-container2" id="largePostersSection">
   <!-- <h2 class="text-center mb-5">Large Posters</h2> -->

    <div id="largePosterCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($largePosters as $key => $promo)
            <div class="carousel-item @if($key==0) active @endif text-center">
                <img src="{{ asset('storage/' . $promo->poster_medium) }}" 
                     class="img-fluid rounded d-inline-block" 
                     alt="{{ $promo->title }}">
            </div>
            @endforeach
        </div>
        @if($largePosters->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#largePosterCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#largePosterCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        @endif
    </div>
</div>
@endif
<hr>

@php
    $smallPosters = $promotions->filter(fn($p) => $p->poster_small)->values();
@endphp

@if($smallPosters->isNotEmpty())
<div class="container py-4 custom-container3" id="smallPostersSection">
   <!-- <h2 class="text-center mb-5">Other Promotions</h2> -->

    <div id="smallPosterCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner text-center">
            @foreach($smallPosters as $key => $promo)
            <div class="carousel-item @if($key==0) active @endif">
                <img src="{{ asset('storage/' . $promo->poster_small) }}" 
                     class="img-fluid rounded d-inline-block" 
                     alt="{{ $promo->title }}">
            </div>
            @endforeach
        </div>
        @if($smallPosters->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#smallPosterCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#smallPosterCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        @endif
    </div>
</div>
@endif

</div>




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
    <p> This Website is Owned by Infinity Trade Solutions LTD Limited. The objects of the Company are all subject 
        matters not forbidden by International Business Companies (Amendment and Consolidation).</p>
    <h3>General Risk Warning</h3>
    <p>Trading leveraged products such as Forex and CFDs may not be suitable for all investors as they carry 
        a high degree of risk to your capital. Please ensure that you fully understand the risks involved, 
        taking into account your investments objectives and level of experience, before trading, 
        and if necessary, seek independent advice. Please read the full Risk Disclosure.</p>
    <h3>Risk disclosure</h3>
    <p>Past performance is not indicative of future results. The information on our website is provided for 
        informational purposes only and should not be construed as investment advice. You should seek independent 
        advice before making any investment decisions. Infinity Trade Solutions LTD does not accept clients 
        from the U.S., Afghanistan, Belarus, Burma, Burundi, Central African Republic, China, Congo, Cuba, Egypt, 
        Guinea, Guinea-Bissau, Iraq, Iran, Indonesia, Lebanon, Lesotho, Libya, Malaysia, Maldives, Mali, Moldova, 
        Nicaragua, Nigeria, North Korea, Pakistan, Russia, Somalia, Sudan, South Sudan, Syria, Tunisia, Turkey, 
        Vanuatu, Venezuela, Yemen, and Zimbabwe. Infinity Trade Solutions LTD may reject any applicant from any 
        jurisdiction at their sole discretion without the requirement to explain the reason why (Terms and conditions).</p>
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

<!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        // Show popup automatically if available
        document.addEventListener('DOMContentLoaded', function () {
            const modalEl = document.getElementById('promoPopupModal');
            if (modalEl) {
                const promoModal = new bootstrap.Modal(modalEl);
                promoModal.show();
            }

            // Simple scroll animation
            const elements = document.querySelectorAll('[data-aos]');
            const onScroll = () => {
                elements.forEach(el => {
                    const rect = el.getBoundingClientRect();
                    if (rect.top < window.innerHeight - 100) {
                        el.classList.add('aos-animate');
                    }
                });
            };
            window.addEventListener('scroll', onScroll);
            onScroll();
        });

    </script>

    <script>

    document.addEventListener('DOMContentLoaded', () => {
    const sections = [
        {id: 'bannerSection', triggered: false},
        {id: 'largePostersSection', triggered: false},
        {id: 'smallPostersSection', triggered: false}
    ];

    function triggerConfetti(section) {
        confetti({
            particleCount: 300,
            spread: 170,
            origin: { y: 0.6 },
            colors: ['#FFD700', '#FF69B4', '#00BFFF', '#ADFF2F', '#FF4500']
        });
        section.triggered = true;
    }

    function checkSections() {
        sections.forEach(section => {
            if (!section.triggered) {
                const el = document.getElementById(section.id);
                if (el) {
                    const rect = el.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom >= 0) {
                        triggerConfetti(section);
                    }
                }
            }
        });
    }

    window.addEventListener('scroll', checkSections);
    checkSections(); // check on load
});

</script>

<script src="{{ asset('js/platform.js') }}"></script>
    
</body>
</html>
