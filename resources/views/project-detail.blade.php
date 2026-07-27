<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Proyek | Rakhmat Perdianto</title>
  <meta name="description"
    content="Detail lengkap pengerjaan proyek, fitur utama, dan teknologi yang digunakan oleh Rakhmat Perdianto.">

  <!-- Referensi Stylesheet Utama -->
  <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body class="project-detail-body">

  <main class="container">
    <!-- Navigasi Kembali -->
    <nav class="detail-nav">
      <a href="{{ url('/#portfolio') }}" class="btn-back">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"></line>
          <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Portfolio
      </a>
    </nav>

    <!-- Kontainer Pesan Error (Secara default disembunyikan) -->
    <div id="error-container" style="display: none; text-align: center; padding: 50px 0;">
      <h1 class="project-title-large" style="color: var(--accent); margin-bottom: 20px;">Proyek Tidak Ditemukan</h1>
      <p style="color: var(--light); margin-bottom: 30px;">Maaf, detail informasi proyek yang Anda cari tidak tersedia
        atau telah dihapus.</p>
      <a href="{{ url('/#portfolio') }}" class="btn btn-primary">Kembali ke Beranda</a>
    </div>

    <!-- Grid Detail Proyek (Secara default disembunyikan sampai data dimuat) -->
    <div id="project-detail-content" class="project-detail-grid" style="display: none;">

      <!-- Kolom Kiri: Info Utama & Deskripsi Lengkap -->
      <div class="project-main-info">
        <div class="project-banner-wrapper">
          <img id="project-banner" src="" alt="Banner Proyek">
        </div>

        <h1 id="project-title" class="project-title-large"></h1>

        <div>
          <h2 class="project-section-title">Deskripsi Proyek</h2>
          <p id="project-description" class="project-description-text" style="margin-top: 15px;"></p>
        </div>

        <div>
          <h2 class="project-section-title">Cerita Pengerjaan</h2>
          <p id="project-story" class="project-description-text" style="margin-top: 15px;"></p>
        </div>

        <div>
          <h2 class="project-section-title">Fitur Utama</h2>
          <ul id="project-features" class="project-features-list">
            <!-- Diisi dinamis via JS -->
          </ul>
        </div>
      </div>

      <!-- Kolom Kanan: Detail Metadata & Tautan Eksternal -->
      <div class="project-sidebar">
        <div class="project-meta-card">

          <div class="meta-item">
            <span class="meta-label">Kategori</span>
            <span id="meta-category" class="meta-value"></span>
          </div>

          <div class="meta-item">
            <span class="meta-label">Tanggal Proyek</span>
            <span id="meta-date" class="meta-value"></span>
          </div>

          <div class="meta-item">
            <span class="meta-label">Peran Saya</span>
            <span id="meta-role" class="meta-value"></span>
          </div>

          <div class="meta-item">
            <span class="meta-label">Teknologi</span>
            <div id="meta-tags" class="project-tags" style="margin-top: 5px;">
              <!-- Diisi dinamis via JS -->
            </div>
          </div>

          <hr style="border: none; border-top: 1px solid rgba(255, 255, 255, 0.08);">

          <div class="project-links-group">
            <a id="link-demo" href="#" target="_blank" rel="noopener" class="btn btn-primary btn-project-link">
              Kunjungi Live Demo
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                <polyline points="15 3 21 3 21 9"></polyline>
                <line x1="10" y1="14" x2="21" y2="3"></line>
              </svg>
            </a>
            <a id="link-repo" href="#" target="_blank" rel="noopener" class="btn btn-outline btn-project-link">
              Source Code
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path
                  d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                </path>
              </svg>
            </a>
          </div>

        </div>
      </div>

    </div>
  </main>

  <!-- ========================================================================
       LOGIKA JAVASCRIPT DINAMIS TEMPLATE DETAIL
       ======================================================================== -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {

      // 1. Data Proyek Lengkap (Object JavaScript Statis)
      const projectsData = {
        'warkop-qr': {
          title: 'Warkop QR - Sistem Pemesanan & POS Digital',
          category: 'Aplikasi Web',
          banner: "{{ asset('foto_pribadi/readme_banner.png') }}",
          date: 'Maret-Mei 2026',
          role: 'Full Stack Developer',
          description: 'Warkop QR adalah aplikasi web inovatif pemesanan menu mandiri oleh pelanggan berbasis QR Code meja yang langsung terintegrasi secara real-time dengan sistem Point of Sales (POS) kasir. Dirancang khusus untuk warkop modern guna meniadakan antrean pesanan di meja kasir dan meminimalisir kesalahan catat pesanan.',
          fullStory: 'Dalam pengembangan Warkop QR, saya merancang arsitektur backend yang andal menggunakan Laravel 12 dan basis data MySQL. Keamanan serta integritas data dijaga secara ketat melalui penerapan manajemen session dan request validation yang terstruktur. Di sisi frontend, saya mengombinasikan Tailwind CSS dan Alpine.js untuk menghadirkan interaksi asinkronus, sehingga daftar menu dapat termuat secara instan dan seamless di perangkat seluler pelanggan tanpa perlu memuat ulang halaman.',
          features: [
            'Pemesanan Menu Mandiri secara instan via scan QR Code Meja unik.',
            'Dashboard Kasir & Pemantauan dapur dengan status pesanan real-time.',
            'Laporan Keuangan otomatis harian, mingguan, dan bulanan.',
            'Sistem Manajemen Stok Inventaris bahan baku/menu real-time.',
            'Security Alert internal and filter XSS / SQL Injection bawaan Laravel.'
          ],
          tags: ['Laravel 12', 'Vanilla JavaScript', 'Bootstrap', 'PHP', 'MySQL', 'Tailwind CSS'],
          repo: 'https://github.com/antoperdi/warkop_QR'
        },
        'dashboard-finansial': {
          title: 'Dashboard Finansial Modern',
          category: 'Desain UI/UX',
          banner: "{{ asset('foto_pribadi/IMG_20260226_045149_015.webp') }}",
          date: 'Maret-Mei 2026',
          role: 'UI/UX Designer',
          description: 'Rancangan desain antarmuka (UI/UX) dasbor analitik manajemen keuangan korporasi dan personal. Didesain dengan mengutamakan visualisasi data statistik yang bersih, modern, dan mudah dipahami.',
          fullStory: 'Tantangan utama proyek ini adalah menyederhanakan penyajian data transaksi finansial yang padat. Saya melakukan User Research terlebih dahulu untuk menyusun tata letak modular. Menggunakan konsep visual Glassmorphism berpalet warna gelap kontras (#293681 dan #95CCDD) untuk memfokuskan pandangan pengguna pada angka neraca keuangan penting. Seluruh aset didokumentasikan ke dalam Design System yang lengkap.',
          features: [
            'Desain antarmuka Glassmorphism premium gelap modern.',
            'Struktur grid modular yang dapat dipindahkan posisinya (drag & drop UI).',
            'Desain visualisasi diagram lingkaran dan garis interaktif.',
            'Pustaka komponen UI lengkap (Colors, Typography, Icons, Buttons).'
          ],
          tags: ['Figma', 'UI/UX', 'Glassmorphism', 'Design System'],
          demo: 'https://example.com/demo-dashboard',
          repo: 'https://github.com/rakhmat-sam/financial-dashboard-ui'
        },
        'portal-berita': {
          title: 'Sistem Kesehatan Laboratorium UPTD Labkes Kota Pangkalpinang',
          category: 'Aplikasi Web',
          banner: "{{ asset('foto_pribadi/halaman login.png') }}",
          date: 'April - Juli 2026',
          role: 'Frontend Developer',
          description: 'Aplikasi Sistem Informasi Kesehatan Laboratorium UPTD Labkes Kota Pangkalpinang merupakan solusi digital berbasis web yang dirancang untuk mengintegrasikan dan mengoptimalkan seluruh alur pelayanan laboratorium kesehatan masyarakat. Sistem ini mengotomatisasi proses bisnis mulai dari pendaftaran pasien/sampel, validasi spesimen, pemrosesan hasil pemeriksaan medis maupun laboratorium lingkungan, hingga penerbitan Surat Hasil Pemeriksaan (LHP) secara akurat dan efisien. Dengan transparansi data dan tata kelola yang terstruktur, aplikasi ini hadir untuk memangkas waktu tunggu, meminimalisir risiko human error, serta meningkatkan mutu pelayanan publik kesehatan bagi masyarakat Kota Pangkalpinang',
          fullStory: 'Dalam sistem kesehatan laboratorium ini, saya berfokus penuh pada sisi performa muat halaman (Performance Optimization) dan Search Engine Optimization (SEO). Frontend dibangun dengan HTML5 semantik dan Vanilla CSS murni untuk menjaga ukuran berkas agar seminimal mungkin. Saya mengimplementasikan teknik Lazy Loading gambar yang ketat dan pre-fetching link navigasi sehingga skor Core Web Vitals mencapai 98% di Google Lighthouse.',
          features: [
            'Pemuatan berita asinkronus berbasis kategori tanpa reload halaman.',
            'Optimasi SEO on-page: Metadata dinamis, Open Graph, dan JSON-LD Structured Data.',
            'Sistem caching asinkronus client-side untuk memuat halaman secara instan.',
            'Tampilan responsif penuh di berbagai ukuran layar.'
          ],
          tags: ['HTML5', 'JavaScript ES6', 'SEO Optimization'],
          demo: 'https://example.com/demo-portal',
          repo: 'https://github.com/rakhmat-sam/realtime-news-portal'
        }
      };

      // 2. Dapatkan ID proyek dari URL Query Parameter
      const urlParams = new URLSearchParams(window.location.search);
      const projectId = urlParams.get('project');

      const errorContainer = document.getElementById('error-container');
      const detailContent = document.getElementById('project-detail-content');

      // 3. Validasi Parameter URL & Render Data
      if (projectId && projectsData[projectId]) {
        const project = projectsData[projectId];

        // Atur Judul Halaman Dokumen
        document.title = `${project.title} | Rakhmat Perdianto`;

        // Render Data Utama ke DOM
        document.getElementById('project-banner').src = project.banner;
        document.getElementById('project-banner').alt = project.title;
        document.getElementById('project-title').textContent = project.title;
        document.getElementById('project-description').textContent = project.description;
        document.getElementById('project-story').textContent = project.fullStory;

        // Render Metadata Sidebar
        document.getElementById('meta-category').textContent = project.category;
        document.getElementById('meta-date').textContent = project.date;
        document.getElementById('meta-role').textContent = project.role;

        // Render Fitur Utama (List dengan Ikon Centang SVG)
        const featuresList = document.getElementById('project-features');
        featuresList.innerHTML = '';
        project.features.forEach(feature => {
          const li = document.createElement('li');
          li.className = 'project-feature-item';
          li.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>${feature}</span>
          `;
          featuresList.appendChild(li);
        });

        // Render Tag Teknologi
        const tagsContainer = document.getElementById('meta-tags');
        tagsContainer.innerHTML = '';
        project.tags.forEach(tag => {
          const span = document.createElement('span');
          span.className = 'project-tag';
          span.textContent = tag;
          tagsContainer.appendChild(span);
        });

        // Konfigurasi Link Eksternal
        document.getElementById('link-demo').href = project.demo || '#';
        document.getElementById('link-repo').href = project.repo || '#';

        // Tampilkan Konten Detail
        detailContent.style.display = 'grid';
      } else {
        // Tampilkan Konten Error
        errorContainer.style.display = 'block';
      }

    });
  </script>
</body>

</html>
