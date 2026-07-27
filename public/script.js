document.addEventListener('DOMContentLoaded', () => {

  /* ========================================================================
     1. EFEK MENGETIK OTOMATIS (TYPING EFFECT) - HERO SECTION
     ======================================================================== */
  const typewriterElement = document.querySelector('.typewriter');
  const words = ['Web Developer', 'UI/UX Designer', 'IT Support'];
  let wordIndex = 0;
  let charIndex = 0;
  let isDeleting = false;
  let typingSpeed = 150;

  const typeEffect = () => {
    const currentWord = words[wordIndex];

    if (isDeleting) {
      // Menghapus karakter satu per satu
      typewriterElement.textContent = currentWord.substring(0, charIndex - 1);
      charIndex--;
      typingSpeed = 75; // Kecepatan menghapus lebih cepat
    } else {
      // Menambahkan karakter satu per satu
      typewriterElement.textContent = currentWord.substring(0, charIndex + 1);
      charIndex++;
      typingSpeed = 150; // Kecepatan mengetik normal
    }

    // Jika kata selesai diketik
    if (!isDeleting && charIndex === currentWord.length) {
      typingSpeed = 2000; // Jeda sebelum mulai menghapus kata
      isDeleting = true;
    }
    // Jika kata selesai dihapus
    else if (isDeleting && charIndex === 0) {
      isDeleting = false;
      wordIndex = (wordIndex + 1) % words.length; // Beralih ke kata berikutnya
      typingSpeed = 500; // Jeda sebelum mulai mengetik kata baru
    }

    setTimeout(typeEffect, typingSpeed);
  };

  // Jalankan efek mengetik jika elemen ditemukan
  if (typewriterElement) {
    typeEffect();
  }


  /* ========================================================================
     2. MOBILE MENU TOGGLE (HAMBURGER MENU)
     ======================================================================== */
  const menuToggle = document.querySelector('.menu-toggle');
  const navLinksContainer = document.querySelector('.nav-links');
  const navLinks = document.querySelectorAll('.nav-link');

  if (menuToggle && navLinksContainer) {
    menuToggle.addEventListener('click', () => {
      navLinksContainer.classList.toggle('show');

      // Animasi hamburger menu (baris berputar/berubah silang)
      const spans = menuToggle.querySelectorAll('span');
      if (navLinksContainer.classList.contains('show')) {
        spans[0].style.transform = 'rotate(45deg) translate(6px, 6px)';
        spans[1].style.opacity = '0';
        spans[2].style.transform = 'rotate(-45deg) translate(6px, -7px)';
      } else {
        spans[0].style.transform = 'none';
        spans[1].style.opacity = '1';
        spans[2].style.transform = 'none';
      }
    });

    // Menutup menu jika link navigasi diklik (pada versi mobile)
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        if (navLinksContainer.classList.contains('show')) {
          navLinksContainer.classList.remove('show');

          // Kembalikan tombol hamburger ke bentuk semula
          const spans = menuToggle.querySelectorAll('span');
          spans[0].style.transform = 'none';
          spans[1].style.opacity = '1';
          spans[2].style.transform = 'none';
        }
      });
    });
  }


  /* ========================================================================
     3. INTERSECTION OBSERVER - NAV LINK AKTIF & ANIMASI STAGGER TABEL & PROGRESS SKILL
     ======================================================================== */
  const sections = document.querySelectorAll('section');
  const skillRows = document.querySelectorAll('.skills-table tbody tr');
  const skillProgressBars = document.querySelectorAll('.skill-progress');

  // Konfigurasi observer untuk menandai link menu aktif saat scroll
  const navObserverOptions = {
    root: null,
    rootMargin: '-20% 0px -60% 0px', // Memicu pergantian saat section dominan di tengah layar
    threshold: 0
  };

  const navObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const id = entry.target.getAttribute('id');
        navLinks.forEach(link => {
          if (link.getAttribute('href') === `#${id}`) {
            link.classList.add('active');
          } else {
            link.classList.remove('active');
          }
        });
      }
    });
  }, navObserverOptions);

  sections.forEach(section => {
    navObserver.observe(section);
  });

  // Konfigurasi observer khusus untuk menganimasi baris tabel & progress bar keahlian saat terlihat
  const skillsObserverOptions = {
    root: null,
    threshold: 0.15 // Mulai animasi ketika 15% section keahlian terlihat
  };

  const skillsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // 1. Animasi stagger baris tabel chip
        skillRows.forEach((row, index) => {
          setTimeout(() => {
            row.classList.add('animate');
          }, index * 120); // Efek stagger 120ms
        });

        // 2. Animasi progress bar penguasaan
        skillProgressBars.forEach(bar => {
          const targetWidth = bar.getAttribute('data-width');
          bar.style.width = targetWidth; // Memicu animasi transisi lebar CSS
        });

        // Berhenti mengamati setelah animasi pertama kali terpicu
        skillsObserver.unobserve(entry.target);
      }
    });
  }, skillsObserverOptions);

  const skillsSection = document.getElementById('skills');
  if (skillsSection && (skillRows.length > 0 || skillProgressBars.length > 0)) {
    skillsObserver.observe(skillsSection);
  }


  /* ========================================================================
     4. FILTER PORTFOLIO / PROYEK GALERI
     ======================================================================== */
  const filterButtons = document.querySelectorAll('.filter-btn');
  const portfolioCards = document.querySelectorAll('.portfolio-card');

  filterButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      // Mengubah tombol aktif
      filterButtons.forEach(button => button.classList.remove('active'));
      btn.classList.add('active');

      const filterValue = btn.getAttribute('data-filter');

      portfolioCards.forEach(card => {
        const cardCategory = card.getAttribute('data-category');

        if (filterValue === 'all' || cardCategory === filterValue) {
          card.classList.remove('hide');
          card.classList.add('show');
        } else {
          card.classList.remove('show');
          card.classList.add('hide');
        }
      });
    });
  });


  /* ========================================================================
     5. LIGHTBOX MODAL GALERI FOTO PRIBADI
     ======================================================================== */
  const galleryItems = document.querySelectorAll('.gallery-item');
  const modalOverlay = document.createElement('div');
  modalOverlay.classList.add('modal-overlay');

  // Membangun struktur modal secara dinamis
  modalOverlay.innerHTML = `
    <div class="modal-container">
      <button class="modal-close" aria-label="Close modal">&times;</button>
      <img class="modal-img" src="" alt="Foto Ukuran Penuh">
    </div>
  `;
  document.body.appendChild(modalOverlay);

  const modalImg = modalOverlay.querySelector('.modal-img');
  const modalClose = modalOverlay.querySelector('.modal-close');

  // Event listener untuk membuka modal
  galleryItems.forEach(item => {
    item.addEventListener('click', () => {
      const img = item.querySelector('.gallery-img');
      if (img) {
        modalImg.src = img.src;
        modalImg.alt = img.alt;
        modalOverlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Kunci scroll halaman utama
      }
    });
  });

  // Event listener untuk menutup modal
  const closeModal = () => {
    modalOverlay.classList.remove('active');
    document.body.style.overflow = ''; // Aktifkan kembali scroll halaman utama
    setTimeout(() => {
      modalImg.src = ''; // Bersihkan src setelah transisi selesai
    }, 300);
  };

  modalClose.addEventListener('click', closeModal);
  modalOverlay.addEventListener('click', (e) => {
    if (e.target === modalOverlay) {
      closeModal();
    }
  });

  // Dukungan tombol Esc keyboard untuk menutup modal
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modalOverlay.classList.contains('active')) {
      closeModal();
    }
  });


  /* ========================================================================
     6. FORM VALIDATION & SUBMIT HANDLER KONTAK
     ======================================================================== */
  const contactForm = document.querySelector('.contact-form');

  if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();

      // Mendapatkan nilai input
      const nameInput = contactForm.querySelector('input[type="text"]').value.trim();
      const emailInput = contactForm.querySelector('input[type="email"]').value.trim();
      const messageInput = contactForm.querySelector('textarea').value.trim();

      // Validasi sederhana
      if (!nameInput || !emailInput || !messageInput) {
        alert('Mohon isi semua bidang formulir sebelum mengirim.');
        return;
      }

      // Simulasi pengiriman pesan sukses interaktif
      const submitBtn = contactForm.querySelector('.btn-submit');
      const originalText = submitBtn.innerHTML;

      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Mengirim... <span class="spinner">⌛</span>';

      setTimeout(() => {
        // Tampilkan notifikasi berhasil
        alert(`Terima kasih, ${nameInput}! Pesan Anda telah sukses dikirim. Saya akan segera menghubungi Anda kembali.`);

        // Reset formulir
        contactForm.reset();
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
      }, 1500);
    });
  }

});
