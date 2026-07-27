@extends('admin.layout')

@section('title', 'Dashboard Utama')
@section('header_title', 'Dashboard Ringkasan')
@section('header_subtitle', 'Selamat datang kembali di panel administrasi portofolio Anda')

@section('styles')
<style>
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1-fraction));
    gap: 25px;
    margin-bottom: 40px;
  }

  .stat-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.3s ease;
  }

  .stat-card:hover {
    background: rgba(255, 255, 255, 0.05);
    transform: translateY(-3px);
    border-color: rgba(66, 116, 217, 0.3);
  }

  .stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: rgba(66, 116, 217, 0.15);
    color: var(--secondary);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .stat-icon svg {
    width: 24px;
    height: 24px;
  }

  .stat-info {
    flex: 1;
  }

  .stat-value {
    font-size: 1.6rem;
    font-weight: 700;
    line-height: 1.2;
  }

  .stat-label {
    font-size: 0.85rem;
    color: var(--light);
    opacity: 0.7;
    margin-top: 3px;
  }

  .welcome-panel {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  .welcome-panel h3 {
    font-size: 1.4rem;
    color: var(--accent);
  }

  .welcome-panel p {
    color: var(--light);
    line-height: 1.6;
    font-size: 1rem;
  }

  .quick-links {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    margin-top: 15px;
  }

  .btn-quick {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--secondary);
    color: var(--white);
    text-decoration: none;
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(66, 116, 217, 0.2);
  }

  .btn-quick:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(66, 116, 217, 0.35);
    filter: brightness(1.1);
  }

  .btn-quick-outline {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--card-border);
    color: var(--white);
  }

  .btn-quick-outline:hover {
    background: rgba(255, 255, 255, 0.08);
  }
</style>
@endsection

@section('content')
<!-- Ringkasan Statistik -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
        <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"></path>
      </svg>
    </div>
    <div class="stat-info">
      <div class="stat-value">{{ $stats['education_count'] ?? 0 }}</div>
      <div class="stat-label">Riwayat Pendidikan</div>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
      </svg>
    </div>
    <div class="stat-info">
      <div class="stat-value">{{ $stats['experience_count'] ?? 0 }}</div>
      <div class="stat-label">Pengalaman Kerja</div>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polygon points="12 2 22 8.5 22 15.5 12 22 2 15.5 2 8.5 12 2"></polygon>
        <line x1="12" y1="22" x2="12" y2="12"></line>
        <line x1="12" y1="12" x2="22" y2="8.5"></line>
        <line x1="12" y1="12" x2="2" y2="8.5"></line>
      </svg>
    </div>
    <div class="stat-info">
      <div class="stat-value">{{ $stats['skill_count'] ?? 0 }}</div>
      <div class="stat-label">Keahlian (Skills)</div>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
      </svg>
    </div>
    <div class="stat-info">
      <div class="stat-value">{{ $stats['message_count'] ?? 0 }}</div>
      <div class="stat-label">Pesan Masuk</div>
    </div>
  </div>
</div>

<!-- Panel Selamat Datang -->
<div class="panel-card">
  <div class="welcome-panel">
    <h3>Halo, {{ html_escape(Auth::user()->name) }}!</h3>
    <p>
      Melalui panel ini, Anda dapat mengelola seluruh konten yang akan ditampilkan di halaman portofolio utama Anda. 
      Saat ini, basis data Anda sudah terhubung menggunakan <strong>Laravel 12</strong> & <strong>MySQL</strong>.
    </p>
    <p>
      Silakan gunakan menu navigasi di sebelah kiri untuk memperbarui data Anda. Anda bisa memulai dengan memilih menu <strong>"Ubah & Tambah Gambar"</strong> untuk memperbarui visualisasi halaman beranda portofolio Anda secara asinkron tanpa reload.
    </p>
    
    <div class="quick-links">
      <a href="{{ url('/portal-admin/ubah-gambar') }}" class="btn-quick">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
          <circle cx="8.5" cy="8.5" r="1.5"></circle>
          <polyline points="21 15 16 10 5 21"></polyline>
        </svg>
        Ubah & Tambah Gambar
      </a>
      <a href="{{ url('/') }}" target="_blank" class="btn-quick btn-quick-outline">
        Lihat Halaman Portofolio
      </a>
    </div>
  </div>
</div>
@endsection
