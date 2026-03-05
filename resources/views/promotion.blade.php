<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORE FINANCE LIMITED</title>
    <link rel="icon" type="pics/icon.png" href="{{ asset('pics/Trinitylogo1.png') }}" />

    <!-- âœ… Add this line -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/promotion.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <!-- ===== HEADER ===== -->
    <header>
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('pics/Trinitylogo.png') }}" alt="Infinity Trade Logo" class="logo-img">
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
                    <a href="#">Trading Products &#9662;</a>
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

    <div class="container1">

        <!-- Section 1 -->
        @php
        $bannerPromotions = $promotions->filter(fn($p) => $p->poster_large)->values();
        @endphp

        @if($bannerPromotions->isNotEmpty())
        <div class="container-fluid py-4 custom-container2" id="bannerSection">
            <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">

                {{-- âœ… Carousel Indicators (Dots) --}}
                @if($bannerPromotions->count() > 1)
                <div class="carousel-indicators">
                    @foreach($bannerPromotions as $key => $promo)
                    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="{{ $key }}"
                        @if($key==0) class="active" aria-current="true" @endif
                        aria-label="Slide {{ $key + 1 }}"></button>
                    @endforeach
                </div>
                @endif

                <div class="carousel-inner">
                    @foreach($bannerPromotions as $key => $promo)
                    <div class="carousel-item @if($key==0) active @endif">
                        <img src="{{ asset('storage/' . $promo->poster_large) }}"
                            class="d-block w-100 rounded banner-img"
                            alt="{{ $promo->title }}">

                        {{-- âœ… Show description only if available --}}
                        @if(!empty($promo->description))
                        <p class="promo-description">{{ $promo->description }}</p>
                        @endif
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


        <!-- Section 2 -->
        @php
        $largePosters = $promotions->filter(fn($p) => $p->poster_medium)->values();
        @endphp

        @if($largePosters->isNotEmpty())
        <div class="container-fluid py-4 custom-container1" id="bannerSection">
            <div class="row justify-content-center g-4">
                @foreach($largePosters as $promo)
                @if($largePosters->count() === 1)
                <!-- Single image layout: image left, text right -->
                <div class="col-12 d-flex flex-column flex-md-row align-items-center justify-content-center text-center text-md-start single-promo">
                    <div class="col-md-6">
                        <img src="{{ asset('storage/' . $promo->poster_medium) }}"
                            class="img-fluid rounded shadow-sm promo-image"
                            alt="{{ $promo->title }}">
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0 promo-text">
                        <h3 class="promo-title">{{ $promo->title }}</h3>
                        @if(!empty($promo->description))
                        <p class="promo-description">{{ $promo->description }}</p>
                        @endif
                    </div>
                </div>
                @else
                <!-- Multiple images layout -->
                <div class="col-12 
                            @if($largePosters->count() == 2) col-md-6 
                            @elseif($largePosters->count() >= 3) col-md-4 
                            @endif text-center">
                    <img src="{{ asset('storage/' . $promo->poster_medium) }}"
                        class="img-fluid rounded shadow-sm promo-image"
                        alt="{{ $promo->title }}">
                    @if(!empty($promo->description))
                    <p class="promo-description mt-2">{{ $promo->description }}</p>
                    @endif
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endif


        <!-- Section 3 -->

        @php
        $smallPosters = $promotions->filter(fn($p) => $p->poster_small)->values();
        $count = $smallPosters->count();
        @endphp

        @if($smallPosters->isNotEmpty())
        <div class="container-fluid py-4 custom-container1" id="bannerSection">
            <div class="row poster-grid poster-count-{{ $count }}">
                @foreach($smallPosters as $promo)
                <div class="col poster-item text-center mb-4">
                    <img src="{{ asset('storage/' . $promo->poster_small) }}"
                        class="img-fluid rounded shadow-sm"
                        alt="{{ $promo->title }}">

                    @if(!empty($promo->description))
                    <p class="promo-description mt-2">{{ $promo->description }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif


        <!-- Section 2: XMedium Posters -->
        @php
        $xMediumPosters = $promotions->filter(fn($p) => $p->poster_xmedium)->values();
        @endphp

        @if($xMediumPosters->isNotEmpty())
        <div class="container-fluid py-4 custom-container1" id="xMediumPostersSection">
            <div class="row justify-content-center g-4">
                @foreach($xMediumPosters as $promo)
                @if($xMediumPosters->count() === 1)
                <!-- Single image layout: text left, image right -->
                <div class="col-12 d-flex flex-column flex-md-row align-items-center justify-content-center text-center text-md-start single-promo">
                    <div class="col-md-6 mt-3 mt-md-0 promo-text text-md-start">
                        <h3 class="promo-title">{{ $promo->title }}</h3>
                        @if(!empty($promo->description))
                        <p class="promo-description">{{ $promo->description }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('storage/' . $promo->poster_xmedium) }}"
                            class="img-fluid rounded shadow-sm promo-image"
                            alt="{{ $promo->title }}">
                    </div>
                </div>
                @else
                <!-- Multiple images layout -->
                <div class="col-12 
                            @if($xMediumPosters->count() == 2) col-md-6 
                            @elseif($xMediumPosters->count() >= 3) col-md-4 
                            @endif text-center">
                    <img src="{{ asset('storage/' . $promo->poster_xmedium) }}"
                        class="img-fluid rounded shadow-sm promo-image"
                        alt="{{ $promo->title }}">
                    @if(!empty($promo->description))
                    <p class="promo-description mt-2">{{ $promo->description }}</p>
                    @endif
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endif

    </div>
    <!-- Footer -->
    <footer class="footer">
      <div class="footer-container">

        <!-- Column 1: Logo + Social -->
        <div class="footer-col footer-brand">
         <img src="{{ asset('pics/Trinitylogo.png') }}" alt="Tradefx Logo" class="footer-logo">
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
        <p>&copy; CORE FINANCE LIMITED - 10956602</p>
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

        titles.forEach(t => t.classList.remove('active'));
        descriptions.forEach(d => {
          d.style.display = 'none';
        });

        if (!isActive) {
          title.classList.add('active');
          if (desc) desc.style.display = 'block';
        }
      });
    });
    </script>


    <!-- Dark Mode Toggle 
<button id="darkModeToggle" class="dark-toggle">
  ðŸŒ™
</button> -->

    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top">&#8593;</button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Show popup automatically if available
        document.addEventListener('DOMContentLoaded', function() {
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
            const sections = [{
                    id: 'bannerSection',
                    triggered: false
                },
                {
                    id: 'largePostersSection',
                    triggered: false
                },
                {
                    id: 'smallPostersSection',
                    triggered: false
                }
            ];

            function triggerConfetti(section) {
                confetti({
                    particleCount: 300,
                    spread: 170,
                    origin: {
                        y: 0.6
                    },
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

    <style>
        /* âœ¨ Description Style */
        .promo-description {
            text-align: center;
            color: #000000ff;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            margin-top: 10px;
            max-width: 950px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
            transition: opacity 0.5s ease-in-out;
        }

        body.dark-mode .promo-description {
            color: #fbfbfbff;
        }

        /* ===== Responsive Poster Grid ===== */
        .promo-image {
            width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .promo-image:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* Poster description styling */
        .promo-description {
            font-size: 0.95rem;
            color: #555;
        }

        /* Responsive spacing */
        @media (max-width: 768px) {

            #largePostersSection .col-md-6,
            #largePostersSection .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>

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
</script>-->
    <!--End of Tawk.to Script-->

</body>

</html>
