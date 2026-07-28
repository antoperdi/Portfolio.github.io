<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rakhmat Perdianto | Portfolio Premium</title>
  <meta name="description"
    content="Portfolio Web Profesional Rakhmat Perdianto - Web Developer & UI/UX Designer dengan fokus pada pembuatan website interaktif, responsif, dan bernilai seni tinggi.">

  <!-- Referensi Stylesheet -->
  <link rel="stylesheet" href="{{ asset('style.css') }}">

  <!-- Gaya Latar Belakang Kustom Dinamis (Warna Utama & Transparansi) (Rule 5, 6 & 19) -->
  <style>
    body {
      background-image: linear-gradient(
        rgba({{ hex_to_rgb($profile->primary_color ?? '#293681') }}, {{ $profile->primary_opacity ?? '0.85' }}), 
        rgba({{ hex_to_rgb($profile->primary_color ?? '#293681') }}, {{ $profile->primary_opacity ?? '0.85' }})
      ), url("{{ isset($backgroundImage) ? asset('storage/' . $backgroundImage->image_path) : asset('foto_pribadi/latar_belakang_portfolio.png') }}") !important;
    }
  </style>

  <!-- Kustomisasi Warna Tema Dinamis dari Database (Rule 5, 6, & 19) -->
  <style>
    :root {
      @if(!empty($profile->primary_color))
        --primary: {{ $profile->primary_color }};
        --primary-rgb: {{ hex_to_rgb($profile->primary_color) }};
      @endif
      @if(!empty($profile->secondary_color))
        --secondary: {{ $profile->secondary_color }};
        --secondary-rgb: {{ hex_to_rgb($profile->secondary_color) }};
      @endif
      @if(!empty($profile->accent_color))
        --accent: {{ $profile->accent_color }};
        --accent-rgb: {{ hex_to_rgb($profile->accent_color) }};
      @endif
      @if(!empty($profile->navigator_color))
        --navigator: {{ $profile->navigator_color }};
        --navigator-rgb: {{ hex_to_rgb($profile->navigator_color) }};
      @else
        --navigator: {{ $profile->primary_color ?? '#293681' }};
        --navigator-rgb: {{ hex_to_rgb($profile->primary_color ?? '#293681') }};
      @endif
    }

    /* Aplikasi Dinamis Warna Navigator (Rule 6) */
    .navbar {
      background: rgba(var(--navigator-rgb), 0.85) !important;
    }
    footer {
      background-color: rgba(var(--navigator-rgb), 0.5) !important;
    }
    @media (max-width: 768px) {
      .nav-links {
        background-color: var(--navigator) !important;
      }
    }
  </style>
</head>

<body>

  <!-- ========================================================================
       HEADER / NAVIGATION BAR
       ======================================================================== -->
  <header class="navbar">
    <div class="container nav-container">
      <a href="#hero" class="nav-brand">Rakhmat<span>.Sam</span></a>

      <button class="menu-toggle" aria-label="Toggle navigation menu">
        <span></span>
        <span></span>
        <span></span>
      </button>

      <nav class="nav-links">
        <a href="#hero" class="nav-link active">Home</a>
        <a href="#about" class="nav-link">Tentang</a>
        <a href="#skills" class="nav-link">Keahlian</a>
        <a href="#portfolio" class="nav-link">Portofolio</a>
        <a href="#gallery" class="nav-link">Galeri</a>
        <a href="#contact" class="nav-link">Kontak</a>
      </nav>
    </div>
  </header>

  <main>
    <!-- ========================================================================
         HERO SECTION
         ======================================================================== -->
    <section id="hero" class="hero-section">
      <div class="hero-bg-glow-1"></div>
      <div class="hero-bg-glow-2"></div>

      <div class="container hero-content">
        <div class="hero-text">
          <span class="hero-greeting">Selamat Datang Di Portfolio Saya</span>
          <h1 class="hero-title">Halo, Saya<br>{{ html_escape($profile->name) }}</h1>

          <div class="hero-type-wrapper">
            <span class="typewriter"></span>
          </div>

          <p class="hero-subtitle">
            {{ html_escape($profile->title) }}
          </p>

          <div class="btn-group">
            <a href="#portfolio" class="btn btn-primary">
              Lihat Karya
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
            <a href="#contact" class="btn btn-outline">Hubungi Saya</a>
          </div>
        </div>

        <div class="hero-image-container">
          <div class="hero-image-wrapper">
            <!-- Foto Pribadi Utama -->
            <img src="{{ url('/profile/image/hero') }}" alt="{{ html_escape($profile->name) }} - Foto Utama" class="hero-image" loading="eager">
          </div>
          <div class="hero-image-card-accent"></div>
        </div>
      </div>
    </section>

    <!-- ========================================================================
         ABOUT ME SECTION
         ======================================================================== -->
    <section id="about" class="section">
      <div class="container">
        <h2 class="section-title">Tentang Saya</h2>

        <div class="about-grid">
          <div class="about-img-wrapper">
            <!-- Foto Pribadi Pendukung 1 -->
            <img src="{{ url('/profile/image/about') }}" alt="{{ html_escape($profile->name) }} - Foto Tentang Saya"
              class="about-image" loading="lazy">
          </div>

          <div class="about-details">
            <p class="about-desc">
              {{ html_escape($profile->bio) }}
            </p>

            <div class="info-cards">
              @foreach($educations as $edu)
              <div class="info-card">
                <div class="info-card-icon">
                  <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"></path>
                  </svg>
                </div>
                <h4>Pendidikan</h4>
                <p>{{ html_escape($edu->degree) }} {{ html_escape($edu->major) }}<br>{{ html_escape($edu->institution) }} ({{ html_escape($edu->period) }})</p>
                <div class="card-action-links">
                  <a href="https://www.atmaluhur.ac.id/" target="_blank" rel="noopener" class="btn-card-action">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round">
                      <circle cx="12" cy="12" r="10"></circle>
                      <line x1="2" y1="12" x2="22" y2="12"></line>
                      <path
                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                      </path>
                    </svg>
                    Web Kampus
                  </a>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ========================================================================
         SKILLS SECTION
         ======================================================================== -->
    <section id="skills" class="section">
      <div class="container">
        <h2 class="section-title">Keahlian Saya</h2>

        <div class="skills-table-wrapper">
          <table class="skills-table">
            <thead>
              <tr>
                <th>Kategori</th>
                <th>Teknologi / Tool</th>
              </tr>
            </thead>
            <tbody>
              @foreach($groupedSkills as $category => $skillNames)
              <tr>
                <td class="skill-category">{{ html_escape($category) }}</td>
                <td class="skill-tools">
                  @foreach($skillNames as $name)
                  <span class="skill-badge">{{ html_escape($name) }}</span>
                  @endforeach
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Sub-bagian 2: Tingkat Penguasaan & Kemampuan (Progress Bar kustom) -->
        <h3 class="skills-subtitle"
          style="margin-top: 50px; margin-bottom: 25px; font-size: 1.6rem; text-align: center; color: var(--accent); font-weight: 600;">
          Tingkat Penguasaan &amp; Kemampuan</h3>

        <div class="skills-progress-grid">
          @foreach($skills as $skill)
          <div class="skill-item">
            <div class="skill-info">
              <span>{{ html_escape($skill->name) }}</span>
              <span>{{ html_escape($skill->percentage) }}%</span>
            </div>
            <div class="skill-bar">
              <div class="skill-progress" data-width="{{ html_escape($skill->percentage) }}%"></div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- ========================================================================
         PORTFOLIO SECTION
         ======================================================================== -->
    <section id="portfolio" class="section">
      <div class="container">
        <h2 class="section-title">Project Saya</h2>

        <!-- Tombol Penyaring Kategori -->
        <div class="filter-container">
          <button class="filter-btn active" data-filter="all">Semua</button>
          <button class="filter-btn" data-filter="web">Aplikasi Web</button>
          <button class="filter-btn" data-filter="design">Desain UI/UX</button>
        </div>

        <!-- Grid Portofolio Wrapper dengan Overflow Aman -->
        <div class="portfolio-grid-wrapper">
          <div class="portfolio-grid">
            @forelse($projects as $project)
              <a href="{{ url('/project-detail?project=' . $project->id) }}" class="portfolio-card show" data-category="{{ html_escape($project->Kategori) }}">
                <div class="portfolio-img-wrapper">
                  @php
                    $isFallback = in_array($project->image_path, ['readme_banner.png', 'IMG_20260226_045149_015.webp', 'halaman login.png']);
                    $imageSrc = $isFallback ? asset('foto_pribadi/' . $project->image_path) : asset('storage/' . $project->image_path);
                  @endphp
                  <img src="{{ $imageSrc }}" alt="{{ html_escape($project->nama) }}" loading="lazy">
                </div>
                <div class="portfolio-info">
                  <h3>{{ html_escape($project->nama) }}</h3>
                  <p>{{ html_escape($project->caption) }}</p>
                  <div class="project-tags">
                    @foreach(explode(',', $project->Teknologi) as $tag)
                      @if(trim($tag) !== '')
                        <span class="project-tag">{{ html_escape(trim($tag)) }}</span>
                      @endif
                    @endforeach
                  </div>
                </div>
              </a>
            @empty
              <div style="grid-column: 1/-1; text-align: center; color: var(--light); opacity: 0.6; padding: 40px 0;">
                Belum ada proyek yang dipublikasikan.
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </section>

    <!-- ========================================================================
         GALLERY SECTION (Foto Pribadi Tambahan & Interaktif)
         ======================================================================== -->
    <section id="gallery" class="section">
      <div class="container">
        <h2 class="section-title">Galeri Aktivitas</h2>
 
        <div class="gallery-grid-wrapper">
          <div class="gallery-grid">
            @forelse($myGalleries as $item)
              <!-- Gambar Galeri Dinamis dari Database -->
              <div class="gallery-item">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ html_escape($item->title) }}" class="gallery-img" loading="lazy">
                <div class="gallery-overlay">
                  <p>{{ html_escape($item->title) }}</p>
                  @if($item->caption)
                    <span style="font-size: 0.75rem; color: var(--light); opacity: 0.8; display: block; margin-top: 5px;">{{ html_escape($item->caption) }}</span>
                  @endif
                </div>
              </div>
            @empty
              <!-- Galeri 1 Fallback -->
              <div class="gallery-item">
                <img src="{{ asset('foto_pribadi/IMG_20250705_055235_450.webp') }}" alt="Fokus Kerja di Ruang Kreatif" class="gallery-img" loading="lazy">
                <div class="gallery-overlay">
                  <p>Fokus Kerja di Ruang Kreatif</p>
                </div>
              </div>
 
              <!-- Galeri 2 Fallback -->
              <div class="gallery-item">
                <img src="{{ asset('foto_pribadi/IMG_20260226_045149_015.webp') }}" alt="Menyusun Konsep Desain Antarmuka" class="gallery-img" loading="lazy">
                <div class="gallery-overlay">
                  <p>Menyusun Konsep Desain Antarmuka</p>
                </div>
              </div>
 
              <!-- Galeri 3 Fallback -->
              <div class="gallery-item">
                <img src="{{ asset('foto_pribadi/IMG_20260315_021228_744.webp') }}" alt="Eksperimen Pemrograman Berkelanjutan" class="gallery-img" loading="lazy">
                <div class="gallery-overlay">
                  <p>Eksperimen Pemrograman Berkelanjutan</p>
                </div>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </section>

    <!-- ========================================================================
         CONTACT SECTION
         ======================================================================== -->
    <section id="contact" class="section">
      <div class="container">
        <h2 class="section-title">Hubungi Saya</h2>

        <div class="contact-grid">
          <div class="contact-info">
            <h3 class="contact-info-title">Ada Proyek Menarik?<br>Mari Kolaborasi!</h3>
            <p class="contact-info-desc">
              Pintu saya selalu terbuka untuk mendiskusikan peluang proyek baru, merancang solusi digital kreatif, atau sekadar bertukar pikiran seputar perkembangan teknologi web.
            </p>

            <div class="contact-details">
              <div class="contact-detail-item">
                <img src="{{ asset('foto_pribadi/email.png') }}" alt="Email" width="20" height="20" style="object-fit: contain;">
                <div class="contact-detail-text">
                  <a href="mailto:{{ html_escape($profile->email) }}" class="contact-detail-text">
                    <h5>E-mail Saya</h5>
                    <p>{{ html_escape($profile->email) }}</p>
                  </a>
                </div>
              </div>

              <div class="contact-detail-item">
                <div class="contact-detail-icon">
                  <img src="{{ asset('foto_pribadi/placeholder.png') }}" alt="Lokasi" width="20" height="20" style="object-fit: contain;">
                </div>
                <div class="location-links">
                  <a href="https://maps.app.goo.gl/MPfGCjgRLdBZgHBcA?g_st=ac" class="contact-detail-text">
                    <h5>Lokasi</h5>
                    <p>{{ html_escape($profile->address) }}</p>
                  </a>
                </div>
              </div>
            </div>

            <!-- Sosial Media Link -->
            <div class="social-links">
              <a href="https://github.com/" class="social-icon" aria-label="GitHub">
                <img src="{{ asset('foto_pribadi/github.png') }}" alt="Github" width="20" height="20" style="object-fit: contain;">
              </a>
              <a href="#" class="social-icon" aria-label="LinkedIn">
                <img src="{{ asset('foto_pribadi/linkedin.png') }}" alt="Linkedin" width="20" height="20" style="object-fit: contain;">
              </a>
              <a href="https://www.instagram.com/rhqmat_?igsh=MWM5MGdmaTc5aG1kMA==" class="social-icon" aria-label="Instagram">
                <img src="{{ asset('foto_pribadi/instagram.png') }}" alt="Instagram" width="20" height="20" style="object-fit: contain;">
              </a>
              <a href="https://youtube.com/@rakhmatperdianto7616?si=sywZYvvMX5NpZPnY" class="social-icon" aria-label="Youtube">
                <img src="{{ asset('foto_pribadi/youtube.png') }}" alt="Youtube" width="20" height="20" style="object-fit: contain;">
              </a>
            </div>
          </div>

          <div class="contact-form-wrapper">
            <form class="contact-form">
              <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" class="form-control" placeholder="Masukkan nama Anda..." required>
              </div>

              <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" class="form-control" placeholder="Masukkan email Anda..." required>
              </div>

              <div class="form-group">
                <label for="message">Pesan Anda</label>
                <textarea id="message" class="form-control" placeholder="Tuliskan pesan atau detail proyek Anda di sini..." required></textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-submit">Kirim Pesan</button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- ========================================================================
       FOOTER
       ======================================================================== -->
  <footer>
    <div class="container footer-content">
      <p class="footer-text">&copy; 2026 <span>Rakhmat.Sam</span></p>
      <p class="footer-text">Dibuat dengan ❤️ &amp; Dedikasi Tinggi</p>
    </div>
  </footer>

  <!-- Referensi Script JS -->
  <script src="{{ asset('script.js') }}"></script>
</body>

</html>
