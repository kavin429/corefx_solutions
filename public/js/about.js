// who we are
document.addEventListener("DOMContentLoaded", () => {
  const whoSection = document.querySelector("#who-we-are");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          whoSection.classList.add("active");
        } else {
          whoSection.classList.remove("active");
        }
      });
    },
    { threshold: 0.3 }
  );

  observer.observe(whoSection);
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


// Reveal Highlights Section on Scroll
const highlightsSection = document.querySelector(".highlights");

  window.addEventListener("scroll", () => {
    const sectionTop = highlightsSection.getBoundingClientRect().top;
    const triggerPoint = window.innerHeight - 100;

    if (sectionTop < triggerPoint) {
      highlightsSection.classList.add("active");
    } else {
      highlightsSection.classList.remove("active"); // remove if you want re-trigger
    }
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

// ------------------------------------
const cards = document.querySelectorAll('.card');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
      } else {
        entry.target.classList.remove('show'); // re-animate every time
      }
    });
  }, { threshold: 0.2 });

  cards.forEach(card => {
    observer.observe(card);
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