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

  @if(isset($profile))
  <!-- Kustomisasi Warna Tema Dinamis dari Database (Rule 5, 6, & 19) -->
  <style>
    body {
      background-image: linear-gradient(
        rgba({{ hex_to_rgb($profile->primary_color ?? '#293681') }}, {{ $profile->primary_opacity ?? '0.85' }}), 
        rgba({{ hex_to_rgb($profile->primary_color ?? '#293681') }}, {{ $profile->primary_opacity ?? '0.85' }})
      ), url('{{ asset('foto_pribadi/latar_belakang_portfolio.png') }}') !important;
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
    }

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
  </style>
  @endif
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

    <!-- Kontainer Pesan Error -->
    @if(!$project)
    <div id="error-container" style="text-align: center; padding: 50px 0;">
      <h1 class="project-title-large" style="color: var(--accent); margin-bottom: 20px;">Proyek Tidak Ditemukan</h1>
      <p style="color: var(--light); margin-bottom: 30px;">Maaf, detail informasi proyek yang Anda cari tidak tersedia atau telah dihapus.</p>
      <a href="{{ url('/#portfolio') }}" class="btn btn-primary">Kembali ke Beranda</a>
    </div>
    @else
    <!-- Grid Detail Proyek -->
    <div id="project-detail-content" class="project-detail-grid">

      <!-- Kolom Kiri: Info Utama & Deskripsi Lengkap -->
      <div class="project-main-info">
        <div class="project-banner-wrapper">
          @php
            $isFallback = in_array($project->image_path, ['readme_banner.png', 'IMG_20260226_045149_015.webp', 'halaman login.png']);
            $imageSrc = $isFallback ? asset('foto_pribadi/' . $project->image_path) : asset('storage/' . $project->image_path);
          @endphp
          <img id="project-banner" src="{{ $imageSrc }}" alt="{{ html_escape($project->nama) }}">
        </div>

        <h1 id="project-title" class="project-title-large">{{ html_escape($project->nama) }}</h1>

        <div>
          <h2 class="project-section-title">Deskripsi Proyek</h2>
          <p id="project-description" class="project-description-text" style="margin-top: 15px;">{{ html_escape($project->caption) }}</p>
        </div>

        @if($project->Work_Story)
        <div>
          <h2 class="project-section-title">Cerita Pengerjaan</h2>
          <p id="project-story" class="project-description-text" style="margin-top: 15px;">{{ html_escape($project->Work_Story) }}</p>
        </div>
        @endif

        @if($project->Main_Features)
        <div>
          <h2 class="project-section-title">Fitur Utama</h2>
          <ul id="project-features" class="project-features-list">
            @foreach(explode("\n", $project->Main_Features) as $feature)
              @if(trim($feature) !== '')
                <li class="project-feature-item">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  <span>{{ html_escape(trim($feature)) }}</span>
                </li>
              @endif
            @endforeach
          </ul>
        </div>
        @endif
      </div>

      <!-- Kolom Kanan: Detail Metadata & Tautan Eksternal -->
      <div class="project-sidebar">
        <div class="project-meta-card">

          @if($project->Kategori)
          <div class="meta-item">
            <span class="meta-label">Kategori</span>
            <span id="meta-category" class="meta-value">{{ html_escape($project->Kategori === 'web' ? 'Aplikasi Web' : ($project->Kategori === 'design' ? 'Desain UI/UX' : $project->Kategori)) }}</span>
          </div>
          @endif

          @if($project->Tanggal_Proyek)
          <div class="meta-item">
            <span class="meta-label">Tanggal Proyek</span>
            <span id="meta-date" class="meta-value">{{ html_escape($project->Tanggal_Proyek) }}</span>
          </div>
          @endif

          @if($project->Role)
          <div class="meta-item">
            <span class="meta-label">Peran Saya</span>
            <span id="meta-role" class="meta-value">{{ html_escape($project->Role) }}</span>
          </div>
          @endif

          @if($project->Teknologi)
          <div class="meta-item">
            <span class="meta-label">Teknologi</span>
            <div id="meta-tags" class="project-tags" style="margin-top: 5px;">
              @foreach(explode(',', $project->Teknologi) as $tag)
                @if(trim($tag) !== '')
                  <span class="project-tag">{{ html_escape(trim($tag)) }}</span>
                @endif
              @endforeach
            </div>
          </div>
          @endif

          @if($project->url_demo || $project->url_code)
          <hr style="border: none; border-top: 1px solid rgba(255, 255, 255, 0.08);">

          <div class="project-links-group">
            @if($project->url_demo)
            <a id="link-demo" href="{{ $project->url_demo }}" target="_blank" rel="noopener" class="btn btn-primary btn-project-link">
              Kunjungi Live Demo
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                <polyline points="15 3 21 3 21 9"></polyline>
                <line x1="10" y1="14" x2="21" y2="3"></line>
              </svg>
            </a>
            @endif
            @if($project->url_code)
            <a id="link-repo" href="{{ $project->url_code }}" target="_blank" rel="noopener" class="btn btn-outline btn-project-link">
              Source Code
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path
                  d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                </path>
              </svg>
            </a>
            @endif
          </div>
          @endif

        </div>
      </div>

    </div>
    @endif
  </main>
</body>

</html>
