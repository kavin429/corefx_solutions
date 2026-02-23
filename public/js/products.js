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


// ANIMATION

const sections = document.querySelectorAll(".fade-section");

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add("show");
    } else {
      entry.target.classList.remove("show"); // fade out again when leaving
    }
  });
}, { threshold: 0.15 });

sections.forEach((section) => {
  observer.observe(section);
});


// forest
const hamburger = document.querySelector('.forex-header .hamburger');
const nav = document.querySelector('.forex-header nav');

hamburger.addEventListener('click', () => {
  hamburger.classList.toggle('active');
  nav.classList.toggle('active');
});
