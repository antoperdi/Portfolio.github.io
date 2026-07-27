<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin | Rakhmat Perdianto</title>

  <!-- Google Font: Outfit -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #293681;
      --secondary: #4274D9;
      --accent: #95CCDD;
      --light: #D0E7E6;
      --white: #ffffff;
      --dark-blue: #12183a;
      --card-bg: rgba(18, 24, 58, 0.65);
      --font-main: 'Outfit', sans-serif;
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
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
    }

    .glow-1, .glow-2 {
      position: absolute;
      width: 400px;
      height: 400px;
      border-radius: 50%;
      background: var(--secondary);
      filter: blur(140px);
      opacity: 0.2;
      z-index: 1;
      pointer-events: none;
    }

    .glow-1 {
      top: 10%;
      left: 10%;
    }

    .glow-2 {
      bottom: 10%;
      right: 10%;
      background: var(--accent);
    }

    .dashboard-container {
      width: 100%;
      max-width: 650px;
      z-index: 10;
      position: relative;
    }

    .dashboard-card {
      background: var(--card-bg);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
      text-align: center;
    }

    h1 {
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--white);
      margin-bottom: 15px;
    }

    h1 span {
      color: var(--accent);
    }

    p.welcome-text {
      color: var(--light);
      font-size: 1.1rem;
      margin-bottom: 30px;
      opacity: 0.9;
    }

    .info-box {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.06);
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 35px;
      font-size: 0.95rem;
      color: var(--light);
      line-height: 1.6;
    }

    .btn-logout {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.3);
      border-radius: 10px;
      padding: 12px 25px;
      color: #fca5a5;
      font-family: var(--font-main);
      font-size: 0.95rem;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-logout:hover {
      background: rgba(239, 68, 68, 0.25);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(239, 68, 68, 0.2);
    }

    .btn-logout:active {
      transform: translateY(0);
    }
  </style>
</head>

<body>
  <div class="glow-1"></div>
  <div class="glow-2"></div>

  <div class="dashboard-container">
    <div class="dashboard-card">
      <h1>Selamat Datang di <span>Dashboard</span></h1>
      <p class="welcome-text">Halo, {{ html_escape(Auth::user()->name) }}!</p>

      <div class="info-box">
        Halaman login dan sistem autentikasi admin untuk portofolio Anda telah berhasil disiapkan menggunakan <strong>Laravel 12</strong> dan <strong>MySQL</strong>. Ini adalah area dashboard awal tempat Anda nantinya dapat mengelola isi portofolio.
      </div>

      <a href="{{ url('/portal-admin/logout') }}" class="btn-logout">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
        Keluar (Logout)
      </a>
    </div>
  </div>
</body>

</html>
