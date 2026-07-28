<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin Panel') | Rakhmat Perdianto</title>

  <!-- Google Font: Outfit -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #293681;
      --primary-rgb: 41, 54, 129;
      --secondary: #4274D9;
      --secondary-rgb: 66, 116, 217;
      --accent: #95CCDD;
      --accent-rgb: 149, 204, 221;
      --light: #D0E7E6;
      --light-rgb: 208, 231, 230;
      --white: #ffffff;
      --white-rgb: 255, 255, 255;
      --dark-blue: #0f153a;
      --dark-blue-rgb: 15, 21, 58;
      --card-bg: rgba(255, 255, 255, 0.04);
      --card-border: rgba(255, 255, 255, 0.08);
      --font-main: 'Outfit', sans-serif;
      --sidebar-width: 280px;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: var(--font-main);
      background: radial-gradient(circle at center, #1b2668 0%, #0d122b 100%);
      color: var(--white);
      min-height: 100vh;
      display: flex;
      overflow-x: hidden;
    }

    /* Background glows */
    .bg-glow-1, .bg-glow-2 {
      position: fixed;
      width: 450px;
      height: 450px;
      border-radius: 50%;
      background: var(--secondary);
      filter: blur(140px);
      opacity: 0.15;
      z-index: 1;
      pointer-events: none;
    }

    .bg-glow-1 {
      top: -10%;
      right: 10%;
    }

    .bg-glow-2 {
      bottom: -10%;
      left: 10%;
      background: var(--accent);
    }

    /* Admin Layout Grid */
    .admin-wrapper {
      display: flex;
      width: 100%;
      z-index: 5;
      position: relative;
    }

    /* Sidebar Navigation Panel */
    .admin-sidebar {
      width: var(--sidebar-width);
      background: rgba(15, 21, 58, 0.9);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-right: 1px solid var(--card-border);
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      display: flex;
      flex-direction: column;
      padding: 30px 20px;
      z-index: 100;
      transition: transform 0.3s ease;
    }

    .sidebar-brand {
      font-size: 1.6rem;
      font-weight: 800;
      color: var(--white);
      text-decoration: none;
      margin-bottom: 40px;
      padding-left: 10px;
      letter-spacing: -0.5px;
    }

    .sidebar-brand span {
      color: var(--accent);
    }

    .sidebar-menu {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .menu-item a {
      display: flex;
      align-items: center;
      gap: 15px;
      color: var(--light);
      text-decoration: none;
      padding: 14px 18px;
      border-radius: 12px;
      font-weight: 500;
      font-size: 0.98rem;
      transition: all 0.3s ease;
      background: transparent;
      border: 1px solid transparent;
    }

    .menu-item a:hover {
      background: rgba(255, 255, 255, 0.05);
      color: var(--white);
      transform: translateX(4px);
    }

    .menu-item.active a {
      background: linear-gradient(135deg, rgba(66, 116, 217, 0.25) 0%, rgba(41, 54, 129, 0.25) 100%);
      border-color: rgba(66, 116, 217, 0.3);
      color: var(--white);
      box-shadow: 0 4px 15px rgba(66, 116, 217, 0.15);
    }

    .menu-item a svg {
      width: 20px;
      height: 20px;
      opacity: 0.8;
      transition: opacity 0.3s ease;
    }

    .menu-item.active a svg, .menu-item a:hover svg {
      opacity: 1;
    }

    /* Sidebar Footer / User Profile Tag */
    .sidebar-user {
      margin-top: auto;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid var(--card-border);
      border-radius: 12px;
      padding: 15px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--secondary);
      color: var(--white);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 0.95rem;
    }

    .user-info {
      overflow: hidden;
    }

    .user-name {
      font-size: 0.9rem;
      font-weight: 600;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
    }

    .user-role {
      font-size: 0.75rem;
      color: var(--accent);
      opacity: 0.8;
    }

    /* Main Content Area */
    .admin-main {
      flex: 1;
      margin-left: var(--sidebar-width);
      padding: 40px 50px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      transition: margin-left 0.3s ease;
    }

    /* Header Panel */
    .main-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 35px;
    }

    .header-title h2 {
      font-size: 1.8rem;
      font-weight: 700;
      letter-spacing: -0.5px;
    }

    .header-title p {
      color: var(--light);
      font-size: 0.9rem;
      opacity: 0.8;
      margin-top: 4px;
    }

    .mobile-nav-toggle {
      display: none;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--card-border);
      border-radius: 8px;
      color: var(--white);
      padding: 10px;
      cursor: pointer;
      z-index: 101;
    }

    /* Card Panels */
    .panel-card {
      background: var(--card-bg);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid var(--card-border);
      border-radius: 16px;
      padding: 35px;
      box-shadow: var(--box-shadow);
    }

    /* Toast Notification styles */
    .toast-notif {
      position: fixed;
      top: 25px;
      right: 25px;
      padding: 15px 25px;
      border-radius: 12px;
      background: rgba(15, 21, 58, 0.95);
      backdrop-filter: blur(8px);
      border: 1px solid var(--card-border);
      color: var(--white);
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
      display: flex;
      align-items: center;
      gap: 12px;
      transform: translateY(-20px);
      opacity: 0;
      visibility: hidden;
      z-index: 200;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .toast-notif.show {
      transform: translateY(0);
      opacity: 1;
      visibility: visible;
    }

    .toast-success {
      border-left: 4px solid #22c55e;
    }

    .toast-danger {
      border-left: 4px solid #ef4444;
    }

    /* Responsive Configurations */
    @media (max-width: 992px) {
      .admin-main {
        padding: 30px;
      }
    }

    @media (max-width: 768px) {
      .admin-sidebar {
        transform: translateX(-100%);
      }

      .admin-sidebar.open {
        transform: translateX(0);
      }

      .admin-main {
        margin-left: 0;
        padding: 80px 20px 30px 20px;
      }

      .mobile-nav-toggle {
        display: block;
        position: fixed;
        top: 20px;
        left: 20px;
      }

      .main-header {
        margin-bottom: 25px;
      }
    }
  </style>
  @yield('styles')
</head>

<body>
  <div class="bg-glow-1"></div>
  <div class="bg-glow-2"></div>

  <button class="mobile-nav-toggle" id="nav-toggle" aria-label="Toggle Navigation">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="3" y1="12" x2="21" y2="12"></line>
      <line x1="3" y1="6" x2="21" y2="6"></line>
      <line x1="3" y1="18" x2="21" y2="18"></line>
    </svg>
  </button>

  <div class="admin-wrapper">
    <!-- Sidebar Kiri -->
    <aside class="admin-sidebar" id="sidebar">
      <a href="{{ url('/portal-admin/dashboard') }}" class="sidebar-brand">
        Rakhmat<span>.Sam</span>
      </a>

      <ul class="sidebar-menu">
        <li class="menu-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
          <a href="{{ url('/portal-admin/dashboard') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="7" height="9"></rect>
              <rect x="14" y="3" width="7" height="5"></rect>
              <rect x="14" y="12" width="7" height="9"></rect>
              <rect x="3" y="16" width="7" height="5"></rect>
            </svg>
            Dashboard
          </a>
        </li>
        <li class="menu-item {{ Request::is('portal-admin/ubah-gambar') ? 'active' : '' }}">
          <a href="{{ url('/portal-admin/ubah-gambar') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
              <circle cx="8.5" cy="8.5" r="1.5"></circle>
              <polyline points="21 15 16 10 5 21"></polyline>
            </svg>
            Ubah & Tambah Gambar
          </a>
        </li>
        <li class="menu-item {{ Request::is('portal-admin/kelola-proyek') ? 'active' : '' }}">
          <a href="{{ url('/portal-admin/kelola-proyek') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
              <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
            </svg>
            Kelola Project Saya
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ url('/') }}" target="_blank">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="2" y1="12" x2="22" y2="12"></line>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
            </svg>
            Lihat Website
          </a>
        </li>
        <li class="menu-item" style="margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 15px;">
          <a href="{{ url('/portal-admin/logout') }}" style="color: #fca5a5;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
              <polyline points="16 17 21 12 16 7"></polyline>
              <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            Keluar (Logout)
          </a>
        </li>
      </ul>

      <!-- User Info Tag di Bawah Sidebar -->
      <div class="sidebar-user">
        <div class="user-avatar">
          {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <div class="user-info">
          <div class="user-name">{{ html_escape(Auth::user()->name) }}</div>
          <div class="user-role">Administrator</div>
        </div>
      </div>
    </aside>

    <!-- Halaman Konten Kanan -->
    <main class="admin-main">
      <header class="main-header">
        <div class="header-title">
          <h2>@yield('header_title', 'Dashboard')</h2>
          <p>@yield('header_subtitle', 'Selamat datang kembali, admin')</p>
        </div>
      </header>

      <section class="main-content">
        @yield('content')
      </section>
    </main>
  </div>

  <!-- Toast Notification Panel -->
  <div id="toast" class="toast-notif">
    <span id="toast-message"></span>
  </div>

  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <script>
    $(document).ready(function() {
      // Toggle sidebar di layar mobile
      $('#nav-toggle').on('click', function(e) {
        e.stopPropagation();
        $('#sidebar').toggleClass('open');
      });

      // Tutup sidebar jika mengklik di luar area sidebar (mobile)
      $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
          if (!$(e.target).closest('#sidebar').length && !$(e.target).closest('#nav-toggle').length) {
            $('#sidebar').removeClass('open');
          }
        }
      });

      // Fungsi global menampilkan Toast Notification
      window.showToast = function(type, message) {
        const toast = $('#toast');
        toast.removeClass('toast-success toast-danger');
        
        if (type === 'success') {
          toast.addClass('toast-success');
        } else {
          toast.addClass('toast-danger');
        }

        $('#toast-message').text(message);
        toast.addClass('show');

        // Sembunyikan setelah 3 detik
        setTimeout(function() {
          toast.removeClass('show');
        }, 3000);
      };
    });
  </script>
  @yield('scripts')
</body>

</html>
