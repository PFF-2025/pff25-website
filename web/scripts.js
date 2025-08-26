function toggleMobileMenu() {
  document.getElementById('mobile-menu').classList.toggle('open');
}

// Countdown Timer
window.addEventListener("load", function () {
  initializeCountdown();
  initializeFaqSearch();
});

function initializeFaqSearch() {
  // FAQ-Suche mit Teilwort- und Mehrwort-Suche
  document.getElementById('faq-search').addEventListener('input', function (e) {
    const query = e.target.value.trim().toLowerCase();
    const terms = query.split(/\s+/).filter(Boolean);

    document.querySelectorAll('#faq-list .faq').forEach(function (faq) {
      const title = faq.querySelector('h2').textContent.toLowerCase();
      const content = faq.querySelector('.ck-content').textContent.toLowerCase();
      const text = title + ' ' + content;

      // Alle Suchbegriffe müssen im Text vorkommen
      const matches = terms.every(term => text.includes(term));
      faq.style.display = matches || !query ? '' : 'none';
    });
  });
}

function initializeCountdown() {
  const targetDate = new Date("2025-08-29T16:00:00"); // Local time
  const countdownEl = document.getElementById("countdown");
  if (!countdownEl) return;

  function updateCountdown() {
    const now = new Date();
    const diff = targetDate - now;

    if (diff <= 0) {
      countdownEl.style.display = "none";
      return;
    }

    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
    const minutes = Math.floor((diff / (1000 * 60)) % 60);
    const seconds = Math.floor((diff / 1000) % 60);

    document.getElementById("days").textContent = String(days).padStart(2, '0');
    document.getElementById("hours").textContent = String(hours).padStart(2, '0');
    document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
    document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');
  }

  updateCountdown(); // Initialize immediately
  setInterval(updateCountdown, 1000);
}


