// Toggle full menu
  function toggleMenu() {
    document.querySelector("nav").classList.toggle("active");
    document.querySelector(".hamburger").classList.toggle("active");
  }

  // Dropdown toggle on mobile (only one open at a time)
  document.querySelectorAll(".dropdown-toggle").forEach(item => {
    item.addEventListener("click", function(e) {
      if (window.innerWidth <= 900) { // only on mobile
        e.preventDefault();

        // Close all other dropdowns
        document.querySelectorAll(".dropdown").forEach(drop => {
          if (drop !== this.parentElement) {
            drop.classList.remove("open");
          }
        });

        // Toggle the clicked dropdown
        this.parentElement.classList.toggle("open");
      }
    });
  });

  //hero


  const slides = [
    {
      title: "Unleash Your Trading Potential with Confidence",
      text: "Enter a space where opportunities know no limits"
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
  const titleEl = document.getElementById("hero-title");
  const textEl = document.getElementById("hero-text");

  if (titleEl && textEl && slides.length) {
    function showSlide(i) {
      index = (i + slides.length) % slides.length;

      titleEl.classList.remove("zoom-in");
      textEl.classList.remove("zoom-in");
      titleEl.classList.add("zoom-out");
      textEl.classList.add("zoom-out");

      setTimeout(() => {
        titleEl.classList.remove("zoom-out");
        textEl.classList.remove("zoom-out");

        titleEl.textContent = slides[index].title;
        textEl.textContent = slides[index].text;

        titleEl.classList.add("zoom-in");
        textEl.classList.add("zoom-in");
      }, 400);
    }

    setInterval(() => showSlide(index + 1), 3000);
  }

  //header

  window.addEventListener("scroll", function() {
    const header = document.querySelector("header");
    const hero = document.querySelector(".hero");

    // Get hero height
    const heroHeight = hero.offsetHeight;

    if (window.scrollY > heroHeight - 80) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }
  });

  // Reveal elements on scroll

  // Animate counters
  function animateCounter(counter) {
    const target = +counter.getAttribute("data-target");
    const speed = 30; // smaller = faster
    let count = 0;
    const update = () => {
      if (count < target) {
        count += 1;
        counter.innerText = count;
        setTimeout(update, speed);
      } else {
        counter.innerText = target;
      }
    };
    update();
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("show");

        // If it's a stat card, start counter
        if (entry.target.classList.contains("stat-card")) {
          const counter = entry.target.querySelector(".counter");
          if (counter && !counter.classList.contains("done")) {
            animateCounter(counter);
            counter.classList.add("done");
          }
        }

      } else {
        entry.target.classList.remove("show");
        const counter = entry.target.querySelector(".counter");
        if (counter) counter.classList.remove("done");
      }
    });
  }, { threshold: 0.3 });

  document.querySelectorAll('.about-info, .stat-card').forEach(el => observer.observe(el));

  

  // Feature card reveal on scroll
  const featureCards = document.querySelectorAll('.feature-card');

  const revealOnScroll = () => {
    const triggerBottom = window.innerHeight * 0.85;
    featureCards.forEach(card => {
      const cardTop = card.getBoundingClientRect().top;
      if (cardTop < triggerBottom) {
        card.classList.add('show');
      } else {
        card.classList.remove('show'); // re-trigger when scrolling back
      }
    });
  };

  window.addEventListener('scroll', revealOnScroll);
  window.addEventListener('load', revealOnScroll);



// ===================== PRODUCT CARDS =====================
document.addEventListener("DOMContentLoaded", () => {
  const slider = document.querySelector('#products .products-slider');
  const cards = document.querySelectorAll('#products .product-card');
  const dotsContainer = document.querySelector('#products .slider-dots');
  const section = document.querySelector('#products');

  let prodIndex = 0;
  let startX = 0, isDown = false;

  // ===== Responsive visible cards =====
  function getVisibleCards() {
    return window.innerWidth <= 768 ? 1 : 2;
  }

  // ===== Update dots =====
  function updateDots() {
    const visibleCards = getVisibleCards();
    const total = cards.length - visibleCards + 1;
    dotsContainer.innerHTML = "";
    for (let i = 0; i < total; i++) {
      const dot = document.createElement("span");
      if (i === prodIndex) dot.classList.add("active");
      dot.addEventListener("click", () => {
        prodIndex = i;
        showCards(prodIndex);
      });
      dotsContainer.appendChild(dot);
    }
  }

  // ===== Show cards with animations =====
  function showCards(i) {
    const visibleCards = getVisibleCards();
    const maxIndex = cards.length - visibleCards;
    if (i < 0) prodIndex = maxIndex;
    else if (i > maxIndex) prodIndex = 0;
    else prodIndex = i;

    slider.style.transform = `translateX(-${prodIndex * (105 / visibleCards)}%)`;

    // Animate only visible cards
    cards.forEach((card, idx) => {
      card.classList.remove("show");
      if (idx >= prodIndex && idx < prodIndex + visibleCards) {
        setTimeout(() => {
          card.classList.add("show");

          const img = card.querySelector('.product-img');
          const title = card.querySelector('h3');
          const text = card.querySelector('p');
          const button = card.querySelector('.arrow-link');

          if (img) {
            img.style.transition = "transform 0.6s ease, opacity 0.6s ease";
            img.style.opacity = 0;
            img.style.transform = "scale(0.9)";
            setTimeout(() => {
              img.style.opacity = 1;
              img.style.transform = "scale(1)";
            }, 200);
          }

          if (title) {
            title.style.opacity = 0;
            title.style.transform = "translateY(20px)";
            setTimeout(() => {
              title.style.opacity = 1;
              title.style.transform = "translateY(0)";
            }, 400);
          }

          if (text) {
            text.style.opacity = 0;
            text.style.transform = "translateY(20px)";
            setTimeout(() => {
              text.style.opacity = 1;
              text.style.transform = "translateY(0)";
            }, 600);
          }

          if (button) {
            button.style.opacity = 0;
            button.style.transform = "translateY(20px)";
            setTimeout(() => {
              button.style.opacity = 1;
              button.style.transform = "translateY(0)";
            }, 800);
          }
        }, 200);
      }
    });

    updateDots();
  }

  // ===== Next Slide =====
  function nextSlide() {
    showCards(prodIndex + 1);
  }

  // ===== Prev Slide =====
  function prevSlide() {
    showCards(prodIndex - 1);
  }

  // ===== Mouse Drag =====
  slider.addEventListener('mousedown', (e) => { 
    isDown = true; 
    startX = e.pageX; 
    slider.style.cursor = "grabbing"; 
  });
  slider.addEventListener('mouseup', (e) => { 
    isDown = false; 
    slider.style.cursor = "grab";
    if (startX - e.pageX > 50) nextSlide();
    if (e.pageX - startX > 50) prevSlide();
  });
  slider.addEventListener('mouseleave', () => isDown = false);

  // ===== Touch Swipe =====
  slider.addEventListener('touchstart', (e) => { startX = e.touches[0].clientX; });
  slider.addEventListener('touchend', (e) => {
    if (startX - e.changedTouches[0].clientX > 50) nextSlide();
    if (e.changedTouches[0].clientX - startX > 50) prevSlide();
  });

  // ===== Animate when section is visible =====
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        showCards(prodIndex);
      }
    });
  }, { threshold: 0.3 });
  observer.observe(section);

  // ===== Init =====
  showCards(prodIndex);
  window.addEventListener("resize", () => showCards(0));
});


// Onboading section

document.addEventListener("DOMContentLoaded", () => {
  const steps = document.querySelectorAll(".step");
  const createAccount = document.querySelector("#create-account");
  if (!createAccount || !steps.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        steps.forEach((step, index) => {
          setTimeout(() => step.classList.add("show"), index * 300);
        });
      }
    });
  }, { threshold: 0.1, rootMargin: "0px 0px -10% 0px" });

  observer.observe(createAccount);
});

// plan section
document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".pricing-card");
  if (!cards.length) return;
  const section = document.querySelector("#pricing");

  const revealCards = () => {
    cards.forEach((card, index) => {
      setTimeout(() => card.classList.add("show"), index * 250);
    });
  };

  if ("IntersectionObserver" in window && section) {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          revealCards();
          obs.disconnect();
        }
      });
    }, { threshold: 0.1, rootMargin: "0px 0px -10% 0px" });
    observer.observe(section);
  } else {
    revealCards();
  }

  // Fallback in case observer doesn't fire on first load.
  setTimeout(revealCards, 300);
});


// Meet our clients section

document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelector('.testimonial-track');
  const dots = document.querySelectorAll('.testimonial-dots span');
  if (!cards || dots.length === 0) return; // Safety check

  let index = 0;
  let cardWidth = cards.children[0].offsetWidth + 20; // card width + margin
  let autoSlideInterval;

  function showCard(i) {
    cards.style.transform = `translateX(-${i * cardWidth}px)`;
    dots.forEach(dot => dot.classList.remove('active'));
    dots[i].classList.add('active');
  }

  // Click on dots
  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      index = i;
      showCard(index);
      resetAutoSlide();
    });
  });

  // ==========================
  // Auto slide every 5 seconds
  // ==========================
  function autoSlide() {
    index = (index + 1) % cards.children.length;
    showCard(index);
  }

  function resetAutoSlide() {
    clearInterval(autoSlideInterval);
    autoSlideInterval = setInterval(autoSlide, 5000);
  }

  autoSlideInterval = setInterval(autoSlide, 5000);

  // ==========================
  // Touch / Mouse drag support
  // ==========================
  let isDragging = false;
  let startX = 0;
  let currentTranslate = 0;

  cards.addEventListener('touchstart', dragStart);
  cards.addEventListener('touchmove', dragMove);
  cards.addEventListener('touchend', dragEnd);

  cards.addEventListener('mousedown', dragStart);
  cards.addEventListener('mousemove', dragMove);
  cards.addEventListener('mouseup', dragEnd);
  cards.addEventListener('mouseleave', dragEnd);

  function dragStart(e) {
    isDragging = true;
    startX = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
    clearInterval(autoSlideInterval); // stop auto-slide while dragging
  }

  function dragMove(e) {
    if (!isDragging) return;
    const x = e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
    const delta = x - startX;
    cards.style.transform = `translateX(${-index * cardWidth + -delta}px)`;
  }

  function dragEnd(e) {
    if (!isDragging) return;
    isDragging = false;
    const x = e.type.includes('mouse') ? e.pageX : (e.changedTouches ? e.changedTouches[0].clientX : startX);
    const delta = x - startX;

    if (delta < -50 && index < cards.children.length - 1) index++; // swipe left
    if (delta > 50 && index > 0) index--; // swipe right

    showCard(index);
    resetAutoSlide();
  }
});

// faq section

const faqItems = document.querySelectorAll(".faq-item");

faqItems.forEach(item => {
  const question = item.querySelector(".faq-question");
  const icon = item.querySelector(".faq-icon");

  question.addEventListener("click", () => {
    // close all others
    faqItems.forEach(i => {
      if (i !== item) {
        i.classList.remove("active");
        i.querySelector(".faq-icon").textContent = "+";
      }
    });

    // toggle current
    item.classList.toggle("active");
    icon.textContent = item.classList.contains("active") ? "−" : "+";
  });
});


document.addEventListener("DOMContentLoaded", () => {
  const faqImage = document.querySelector(".faq-image");
  const faqItems = document.querySelectorAll(".faq-item");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // animate image
        faqImage.classList.add("active");

        // stagger animation for faq items
        faqItems.forEach((item, index) => {
          setTimeout(() => {
            item.classList.add("show");
          }, index * 200); // 200ms delay between each card
        });
      } else {
        // reset when leaving section
        faqImage.classList.remove("active");
        faqItems.forEach(item => item.classList.remove("show"));
      }
    });
  }, { threshold: 0.3 }); // triggers when 30% visible

  observer.observe(document.querySelector("#faq"));
});

//card

document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector(".partner-track");

  // Duplicate logos dynamically for seamless infinite loop
  track.innerHTML += track.innerHTML;

  // Pause on hover
  track.addEventListener("mouseenter", () => {
    track.classList.add("paused");
  });

  track.addEventListener("mouseleave", () => {
    track.classList.remove("paused");
  });

  // Pause on click (toggle)
  track.addEventListener("click", () => {
    track.classList.toggle("paused");
  });
});


// Dark Mode Toggle
const toggleBtn = document.getElementById("darkModeToggle");

if (toggleBtn) {

  // Check saved theme
  if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark-mode");
    toggleBtn.textContent = "☀️";
  }

  toggleBtn.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
      toggleBtn.textContent = "☀️";
      localStorage.setItem("theme", "dark");
    } else {
      toggleBtn.textContent = "🌙";
      localStorage.setItem("theme", "light");
    }
  });

}

//up button 

// Back to Top Button
const backToTop = document.getElementById("backToTop");

if (backToTop) {

  window.addEventListener("scroll", () => {
    if (window.scrollY > 300) {
      backToTop.classList.add("show");
    } else {
      backToTop.classList.remove("show");
    }
  });

  backToTop.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  });

}


// ---------------------------------------------------------

const watchBtn = document.getElementById("watchVideoBtn");
const popup = document.getElementById("videoPopup");
const videoFrame = document.getElementById("videoFrame");
const closeVideo = document.getElementById("closeVideo");

const videoURL = "https://www.youtube.com/embed/xHU5MHuUSKI?autoplay=1&mute=1";

if (watchBtn && popup && videoFrame && closeVideo) {
  watchBtn.addEventListener("click", (e) => {
    e.preventDefault();
    popup.style.display = "flex";
    setTimeout(() => {
      videoFrame.src = videoURL;
    }, 300);
  });

  closeVideo.addEventListener("click", () => {
    popup.style.display = "none";
    videoFrame.src = "";
  });

  popup.addEventListener("click", (e) => {
    if (e.target === popup) {
      popup.style.display = "none";
      videoFrame.src = "";
    }
  });
}
