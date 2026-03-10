<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Corefx Trade Solutions LTD</title>
  <link rel="icon" type="pics/icon.png" href="{{ asset('pics/Corefx1.png') }}"/>


  <link rel="stylesheet" href="{{ asset('css/mutualfunds.css') }}">
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
            <img src="{{ asset('pics/Corefx1.png') }}" alt="Corefx Trade Logo" class="logo-img">
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
            <li><a href="{{ route('mutualfunds') }}">Mutual Funds</a></li>        
        <li><a href="{{ route('promotion.show') }}">Promotions</a></li>
        <li><a href="{{ route('contact') }}">Contact Us</a></li>
        <li class="login-btn"><a href="{{ route('login') }}">Log In</a></li>
    </ul>
  </nav>
</header>

<div class="container1">
    <section class="fund-management-section">
        
        <h1 class="fund-title">
            Corefx Trade Solution Limited – United Kingdom
        </h1>

        <h4 class="fund-subtitle">
            Company Number: 09711441
        </h4>

        <div class="fund-content">

            <p class="fund-paragraph">
                Corefx Trade Solution Limited, incorporated under Companies House UK, is a 
                financial management and consultancy company specializing in global trading 
                solutions across Forex, Metals, Indices, and Cryptocurrencies. With years of 
                market experience and a strong analytical team, we offer a structured and secure 
                Fund Management Scheme designed to help clients grow their capital through 
                professionally managed trading strategies.
            </p>

            <p class="fund-paragraph">
                Our Fund Management Scheme allows investors to participate in the financial 
                markets without requiring deep trading knowledge, time commitment, or technical 
                expertise. Once enrolled, each client receives a dedicated account manager, 
                continuous market monitoring, and a tailored trading plan aligned with the 
                client’s chosen investment tier. All funds remain under the client's ownership, 
                while Corefx Trade Solution executes trades on their behalf using tested 
                market strategies and risk-managed systems.
            </p>

            <p class="fund-paragraph">
                Corefx Trade Solution follows strict compliance with AML (Anti-Money 
                Laundering) and KYC (Know Your Customer) guidelines to ensure safe and 
                legitimate fund handling. Risk disclosure is a core part of the program, and 
                clients acknowledge market risks while benefiting from professional trade 
                execution and market insights.
            </p>

            <p class="fund-paragraph">
                Through our Fund Management Scheme, Corefx Trade Solution aims to provide 
                clients with a simplified, secure, and high-return trading experience backed by 
                expert management, transparent processes, and 24/7 support. Investors can 
                participate confidently, knowing their accounts are handled by professionals 
                dedicated to achieving consistent growth.
            </p>

        </div>
    </section>
</div>

<div class="container">
    <section class="growth-plan-section">

        <h1 class="growth-heading">Growth Income Plan</h1>

        <!-- =======================
             Capital Growth Plan
        ======================== -->
        <h2 class="growth-sub">Capital Growth Plan (4 Months)</h2>
        <p class="growth-note">Your investment will be returned in 4 months.</p>
        <div class="growth-table-wrapper">

        <table class="growth-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Investment</th>
                    <th>Profit / Day</th>
                    <th>Profit / Monthly</th>
                    <th>Profit / 4 Months</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Lite (Premium)</td>
                    <td>$1,000</td>
                    <td>$15</td>
                    <td>$300</td>
                    <td>$1,200</td>
                </tr>
                <tr>
                    <td>Pro</td>
                    <td>$2,500</td>
                    <td>$37.50</td>
                    <td>$750</td>
                    <td>$3,000</td>
                </tr>
            </tbody>
        </table>
</div>
<hr>

        <!-- =======================
             Progressive Growth Plan
        ======================== -->
        <h2 class="growth-sub">Progressive Growth Plan (3 Months)</h2>
        <p class="growth-note">Your investment will be returned in 3 months.</p>
<div class="growth-table-wrapper">
        <table class="growth-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Investment</th>
                    <th>Profit / Day</th>
                    <th>Profit / Monthly</th>
                    <th>Profit / 3 Months</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pro</td>
                    <td>$2,500</td>
                    <td>$50</td>
                    <td>$1,000</td>
                    <td>$3,000</td>
                </tr>
                <tr>
                    <td>Pro (Premium)</td>
                    <td>$10,000</td>
                    <td>$200</td>
                    <td>$4,000</td>
                    <td>$12,000</td>
                </tr>
            </tbody>
        </table>
</div>
<hr>
        <!-- =======================
             Smart Growth Plan
        ======================== -->
        <h2 class="growth-sub">Smart Growth Plan (2 Months)</h2>
        <p class="growth-note">Your investment will be returned in 2 months.</p>
<div class="growth-table-wrapper">
        <table class="growth-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Investment</th>
                    <th>Profit / Day</th>
                    <th>Profit / Monthly</th>
                    <th>Profit / 2 Months</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pro (Premium)</td>
                    <td>$10,000</td>
                    <td>$300</td>
                    <td>$6,000</td>
                    <td>$12,000</td>
                </tr>
                <tr>
                    <td>VIP</td>
                    <td>$25,000</td>
                    <td>$750</td>
                    <td>$15,000</td>
                    <td>$30,000</td>
                </tr>
            </tbody>
        </table>
</div>
<hr>

        <!-- =======================
             Imperial Growth Plan
        ======================== -->
        <h2 class="growth-sub">Imperial Growth Plan (1 Month)</h2>
        <p class="growth-note">Your investment will be returned in 1 month.</p>
<div class="growth-table-wrapper">
        <table class="growth-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Investment</th>
                    <th>Profit / Day</th>
                    <th>Profit / Monthly</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>VIP</td>
                    <td>$25,000</td>
                    <td>$1,250</td>
                    <td>$25,000</td>
                </tr>
            </tbody>
        </table>
</div>
    </section>
</div>

<section class="income-plan-section">
    <h2 class="income-heading">Corefx Income Plan</h2>

    <!-- Navigation arrows 
    <button class="nav-arrow left-arrow">❮</button>
    <button class="nav-arrow right-arrow">❯</button> -->

    <div class="slides-wrapper">
        <div class="slides-container">

            <!-- Slide 1 -->
            <div class="slide">
                <h3>1st Month</h3>
                <ul>
                    <li><strong>Account equity:</strong> 25,000 USD</li>
                    <li><strong>Profit/day (5%):</strong> 1,250 USD</li>
                    <li><strong>Weekly profit:</strong> 6,250 USD</li>
                    <li><strong>Monthly profit:</strong> 25,000 USD</li>
                    <li><strong>Withdrawable:</strong> 12,500 USD</li>
                    <li><strong>Redeposit:</strong> 12,500 USD</li>
                </ul>
            </div>

            <!-- Slide 2 -->
            <div class="slide">
                <h3>2nd Month</h3>
                <ul>
                    <li><strong>Account equity:</strong> 37,500 USD</li>
                    <li><strong>Profit/day (5%):</strong> 1,875 USD</li>
                    <li><strong>Weekly profit:</strong> 9,375 USD</li>
                    <li><strong>Monthly profit:</strong> 37,500 USD</li>
                    <li><strong>Withdrawable:</strong> 18,750 USD</li>
                </ul>
            </div>

            <!-- Slide 3 -->
            <div class="slide">
                <h3>3rd Month</h3>
                <ul>
                    <li><strong>Account equity:</strong> 56,250 USD</li>
                    <li><strong>Profit/day (5%):</strong> 2,812 USD</li>
                    <li><strong>Weekly profit:</strong> 14,060 USD</li>
                    <li><strong>Monthly profit:</strong> 56,240 USD</li>
                    <li><strong>Withdrawable:</strong> 28,120 USD</li>
                </ul>
            </div>

            <!-- Slide 4 -->
            <div class="slide">
                <h3>4th Month</h3>
                <ul>
                    <li><strong>Account equity:</strong> 84,370 USD</li>
                    <li><strong>Profit/day (5%):</strong> 4,218 USD</li>
                    <li><strong>Weekly profit:</strong> 21,090 USD</li>
                    <li><strong>Monthly profit:</strong> 84,360 USD</li>
                    <li><strong>Withdrawable:</strong> 42,180 USD</li>
                </ul>
            </div>

            <!-- Slide 5 -->
            <div class="slide">
                <h3>5th Month</h3>
                <ul>
                    <li><strong>Account equity:</strong> 126,550 USD</li>
                    <li><strong>Profit/day (5%):</strong> 6,327 USD</li>
                    <li><strong>Weekly profit:</strong> 31,635 USD</li>
                    <li><strong>Monthly profit:</strong> 126,540 USD</li>
                    <li><strong>Withdrawable:</strong> 63,270 USD</li>
                </ul>
            </div>

        </div>
    </div>

    <!-- Dot indicators -->
    <div class="dots"></div>
</section>

<section class="pro-account-summary">
  <div class="summary-card">
    <div class="summary-header">
      <h2>Pro Account Summary</h2>
      <span class="account-amount">$25,000 (USD)</span>
    </div>
    <h4 class="summary-sub">Corefx Income Plan – Corefx Trade Solution LTD</h4>

    <ul class="summary-points">
      <li><i class="fas fa-wallet"></i> <strong>Deposit Amount:</strong> 25,000 USD</li>
      <li><i class="fas fa-chart-line"></i> <strong>1st Month Return:</strong> 12,500 USD</li>
      <li><i class="fas fa-coins"></i> <strong>Monthly Growth:</strong> Each month, the return increases by 6,250 USD, 9,370 USD, 14,060 USD, 21,090 USD, and so on.</li>
      <li><i class="fas fa-clock"></i> <strong>Investment Recovery:</strong> Within 2 months, your full investment amount will be returned.</li>
      <li><i class="fas fa-trophy"></i> <strong>Plan Type:</strong> Corefx Income Plan – designed for steady monthly growth and sustainable profit accumulation.</li>
      <li><i class="fas fa-check-circle"></i> <strong>Key Benefit:</strong> Continuous monthly income even after your initial investment is recovered.</li>
    </ul>
  </div>
</section>

<section id="legal">

  <div class="legal-wrapper">

    <div class="legal-container">
      <h2>LEGAL TERMS & CONDITIONS – FUND MANAGEMENT PLAN <br>(FOREX TRADING)</h2>
      <h3>Corefx Trade Solution Limited (Company No. 09711441, United Kingdom)</h3>

      <!-- 1. Definitions -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 1. Definitions
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p><strong>“Company”</strong> refers to Corefx Trade Solution Limited.</p> <br>
          <p><strong>“Client”</strong> refers to the individual or entity participating in the fund management plan.</p> <br>
          <p><strong>“Funds”</strong> refer to the capital deposited by the Client for trading purposes.</p> <br>
          <p><strong>“Trading Account”</strong> refers to the account held in the Client’s name used for executing trades.</p> <br>
          <p><strong>“Fund Management Plan”</strong> refers to the trading services offered by the Company under pre-agreed terms.</p>
        </div>
      </div>

      <!-- 2. Scope of Service -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 2. Scope of Service
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p>The Company provides professional fund management services for Forex, Metals, Indices, and Cryptocurrency markets.</p><br>
          <p>The Company shall trade on behalf of the Client strictly for investment and market growth purposes.</p><br>
          <p>The Company may provide signals, analysis, and trading strategies as part of account management.</p>
        </div>
      </div>

      <!-- 3. Client Acknowledgements -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 3. Client Acknowledgements
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p>The Client acknowledges that Forex trading carries high financial risk, including the potential loss of capital.</p> <br>
          <p>The Client confirms that they fully understand the risks and voluntarily participate.</p> <br>
          <p>The Client acknowledges that past performance does not guarantee future returns.</p> <br>
          <p>The Client must ensure all funds deposited are legally obtained and compliant with AML regulations.</p>
        </div>
      </div>

      <!-- 4. Capital & Profit Structure -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 4. Capital & Profit Structure
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p>All capital deposited remains the property of the Client.</p> <br>
          <p>Profit percentages, payout schedules, plan durations, and withdrawal rules shall be disclosed prior to account activation.</p> <br>
          <p>Profits will be credited based on the plan selected by the Client (e.g., Daily, Monthly, End of Term).</p> <br>
          <p>The Company does not guarantee fixed returns unless specifically stated under a promotional or structured plan.</p>
        </div>
      </div>

      <!-- 5. Trading Authority -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 5. Trading Authority
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p>By participating in the Fund Management Plan, the Client grants the Company limited trading authorization to execute buy/sell orders on their behalf.</p><br>
          <p>The Company will not have access to withdraw or transfer the Client’s funds unless explicitly authorized by the Client.</p> <br>
          <p>Trading decisions remain solely at the discretion of the Company’s analysts and fund managers.</p>
        </div>
      </div>

      <!-- 6. Withdrawals & Payouts -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 6. Withdrawals & Payouts
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p>The Client may request withdrawals based on the terms of their specific plan.</p> <br>
          <p>Withdrawals may be subject to processing time and compliance checks.</p> <br>
          <p>Early termination or withdrawal during an active plan may result in penalties or forfeiture of promotional profits.</p> <br>
          <p>Company reserves the right to delay withdrawals during extreme market volatility or technical disruptions.</p>
        </div>
      </div>

      <!-- 7. Fees & Charges -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 7. Fees & Charges
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p>Management fees, service charges, spreads, or performance fees will be disclosed in advance.</p> <br>
          <p>The Company may deduct applicable fees from profits or the trading account based on the agreement.</p> <br>
          <p>The Company is not responsible for third-party charges, including bank fees, crypto network fees, or conversion charges.</p>
        </div>
      </div>

      <!-- 8. Compliance & Regulations -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 8. Compliance & Regulations
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p>Client funds must comply with Anti-Money Laundering (AML) and Know Your Customer (KYC) requirements.</p> <br>
          <p>The Company reserves the right to request identity documents, source-of-funds proof, or any relevant details.</p> <br>
          <p>The Client acknowledges that Forex trading services may not be regulated in all jurisdictions.</p>
        </div>
      </div>

      <!-- 9. Liability Limitation -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 9. Liability Limitation
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p>The Company shall not be held liable for trading losses due to:</p>
          <ul>
            <li>Market volatility</li>
            <li>Economic events</li>
            <li>System failures</li>
            <li>Force majeure events</li>
            <li>Broker platform issues</li>
          </ul> <br>
          <p>The Company’s total liability shall not exceed the amount of management fees paid by the Client.</p>
        </div>
      </div>

      <!-- 10. Termination of Agreement -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 10. Termination of Agreement
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p>Either party may terminate the agreement with written notice.</p> <br>
          <p>Upon termination, all open trades may be closed immediately unless otherwise agreed.</p> <br>
          <p>The Client will receive their remaining capital minus applicable fees or losses.</p>
        </div>
      </div>

      <!-- 11. Confidentiality -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 11. Confidentiality
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p>All client information shall remain confidential and used solely for service delivery.</p> <br>
          <p>The Company may disclose information if required by law enforcement or legal authorities.</p>
        </div>
      </div>

      <!-- 12. Governing Law -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 12. Governing Law
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p>This agreement shall be governed by and interpreted under the laws of the United Kingdom.</p>
        </div>
      </div>

      <!-- 13. Acceptance -->
      <div class="legal-item">
        <button class="legal-question">
          <i class="fa-solid fa-gavel"></i> 13. Acceptance
          <span class="legal-icon">+</span>
        </button>
        <div class="legal-answer">
          <p>By activating a trading account or depositing funds, the Client confirms acceptance of these terms and conditions.</p>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- Footer -->
<footer class="footer">
  <div class="footer-container">

    <!-- Column 1: Logo + Social -->
    <div class="footer-col footer-brand">
    <img src="{{ asset('pics/Corefx1.png') }}" alt="Tradefx Logo" class="footer-logo">
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
        <li><i class="fas fa-envelope"></i>  support@Corefxtradesolution.com</li>
        <li><i class="fas fa-building"></i>  20-22 Wenlock Road, London, England, N1 7GU</li>
        <!--<li><i class="fas fa-globe"></i>  57Q9+6MF - Business Bay - Dubai - UAE</li> -->
      </ul>
    </div>
  </div>

  <!-- Legal -->
  <div class="footer-legal">
    <h3>legal</h3>
    <p> This Website is Owned by Corefx Trade Solutions LTD Limited. The objects of the Company are all subject 
        matters not forbidden by International Business Companies (Amendment and Consolidation).</p>
    <h3>General Risk Warning</h3>
    <p>Trading leveraged products such as Forex and CFDs may not be suitable for all investors as they carry 
        a high degree of risk to your capital. Please ensure that you fully understand the risks involved, 
        taking into account your investments objectives and level of experience, before trading, 
        and if necessary, seek independent advice. Please read the full Risk Disclosure.</p>
    <h3>Risk disclosure</h3>
    <p>Past performance is not indicative of future results. The information on our website is provided for 
        informational purposes only and should not be construed as investment advice. You should seek independent 
        advice before making any investment decisions. Corefx Trade Solutions LTD does not accept clients 
        from the U.S., Afghanistan, Belarus, Burma, Burundi, Central African Republic, China, Congo, Cuba, Egypt, 
        Guinea, Guinea-Bissau, Iraq, Iran, Indonesia, Lebanon, Lesotho, Libya, Mali, Moldova, 
        Nicaragua, Nigeria, North Korea, Pakistan, Russia, Somalia, Sudan, South Sudan, Syria, Tunisia, Turkey, 
        Vanuatu, Venezuela, Yemen, and Zimbabwe. Corefx Trade Solutions LTD may reject any applicant from any 
        jurisdiction at their sole discretion without the requirement to explain the reason why (Terms and conditions).</p>
  </div>

  <!-- Bottom -->
  <div class="footer-bottom">
    <p>© Corefx Trade Solutions LTD - 09711441</p>
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



<!--Start of Tawk.to Script-->
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
<!--End of Tawk.to Script-->

<script>
    const container = document.querySelector(".slides-container");
const dotsContainer = document.querySelector(".dots");
const slides = document.querySelectorAll(".slide");
const leftArrow = document.querySelector(".left-arrow");
const rightArrow = document.querySelector(".right-arrow");

let currentIndex = 0;

// Create dots
slides.forEach((_, i) => {
    const dot = document.createElement("span");
    if (i === 0) dot.classList.add("active");
    dot.addEventListener("click", () => {
        scrollToSlide(i);
    });
    dotsContainer.appendChild(dot);
});

// Scroll to a specific slide
function scrollToSlide(index) {
    const slide = slides[index];
    container.scrollTo({
        left: slide.offsetLeft - container.offsetLeft,
        behavior: "smooth"
    });
    currentIndex = index;
    updateDots();
}

// Update active dot
function updateDots() {
    dotsContainer.querySelectorAll("span").forEach((d, i) => {
        d.classList.toggle("active", i === currentIndex);
    });
}

// Arrow navigation
//rightArrow.addEventListener("click", () => {
//    if (currentIndex < slides.length - 1) {
//        currentIndex++;
//        scrollToSlide(currentIndex);
//    }
// });

// leftArrow.addEventListener("click", () => {
//    if (currentIndex > 0) {
//        currentIndex--;
//        scrollToSlide(currentIndex);
//    }
// });

// Update current slide on manual scroll
container.addEventListener("scroll", () => {
    const scrollLeft = container.scrollLeft;
    let closestIndex = 0;
    let closestDistance = Corefx;

    slides.forEach((slide, index) => {
        const distance = Math.abs(slide.offsetLeft - container.offsetLeft - scrollLeft);
        if (distance < closestDistance) {
            closestDistance = distance;
            closestIndex = index;
        }
    });

    if (closestIndex !== currentIndex) {
        currentIndex = closestIndex;
        updateDots();
    }
});

// Optional: animate cards on first load
window.addEventListener("load", () => {
    slides.forEach((slide, i) => {
        setTimeout(() => slide.classList.add("show"), i * 150);
    });
});

const legalItems = document.querySelectorAll(".legal-item");

legalItems.forEach(item => {
  const question = item.querySelector(".legal-question");
  question.addEventListener("click", () => {
    item.classList.toggle("active");
    legalItems.forEach(other => {
      if (other !== item) other.classList.remove("active");
    });
  });
});

</script>


<script src="{{ asset('js/platform.js') }}"></script>

</body>
</html>
