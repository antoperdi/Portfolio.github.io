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

  /* Spinner visual loading (Rule 6) */
  .spinner-upload {
    width: 14px;
    height: 14px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: var(--white);
    animation: spin 0.8s linear infinite;
    display: none;
  }

  @keyframes spin {
    to { transform: rotate(360deg); }
  }
</style>
@endsection

@section('content')
<!-- Card Kelola Sosial Media Link (CRUD) -->
<div class="panel-card" style="margin-bottom: 30px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
    <div>
      <h3 style="font-size: 1.3rem; font-weight: 600; color: var(--accent);">Kelola Link Sosial Media</h3>
      <p style="font-size: 0.85rem; color: var(--light); opacity: 0.7; line-height: 1.4;">
        Tambahkan, edit, atau hapus tautan media sosial yang akan tampil di halaman depan portofolio Anda.
      </p>
    </div>
    <button type="button" class="btn-quick" id="btn-add-social" style="border: none; cursor: pointer;">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
      </svg>
      Tambah Link
    </button>
  </div>

  <!-- Form Area (Hidden by default, shown on Add/Edit) -->
  <div id="social-form-wrapper" style="display: none; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 20px; border-radius: 12px; margin-bottom: 25px;">
    <h4 id="social-form-title" style="font-size: 1.05rem; font-weight: 600; margin-bottom: 15px; color: var(--white);">Tambah Link Sosial Media</h4>
    <form id="social-link-form" enctype="multipart/form-data">
      <input type="hidden" id="social_id" name="id">
      
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 15px;">
        <div>
          <label for="social_name" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px;">Nama Media Sosial</label>
          <input type="text" id="social_name" name="name" required style="width: 100%; padding: 10px; background: #12183a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-size: 0.9rem;" placeholder="Contoh: GitHub, LinkedIn">
        </div>
        
        <div>
          <label for="social_url" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px;">URL Tautan</label>
          <input type="text" id="social_url" name="url" required style="width: 100%; padding: 10px; background: #12183a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-size: 0.9rem;" placeholder="https://github.com/username">
        </div>

        <div>
          <label for="social_order" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px;">Urutan Tampil</label>
          <input type="number" id="social_order" name="order_num" required min="0" value="0" style="width: 100%; padding: 10px; background: #12183a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-size: 0.9rem;" placeholder="0">
        </div>
      </div>

      <!-- Icon Section -->
      <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px; align-items: flex-end;">
        <div style="flex: 1; min-width: 220px;">
          <label for="social_predefined_icon" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px;">Pilih Ikon Bawaan</label>
          <select id="social_predefined_icon" name="predefined_icon" style="width: 100%; padding: 10px; background: #12183a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-size: 0.9rem; cursor: pointer;">
            <option value="">-- Unggah ikon kustom di sebelah kanan --</option>
            <option value="foto_pribadi/github.png">GitHub</option>
            <option value="foto_pribadi/linkedin.png">LinkedIn</option>
            <option value="foto_pribadi/instagram.png">Instagram</option>
            <option value="foto_pribadi/youtube.png">YouTube</option>
            <option value="foto_pribadi/email.png">Email</option>
            <option value="foto_pribadi/placeholder.png">Maps/Pin</option>
          </select>
        </div>

        <div style="flex: 1; min-width: 220px;">
          <label for="social_icon_file" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px;">Atau Unggah Ikon Kustom (PNG/SVG/JPG)</label>
          <input type="file" id="social_icon_file" name="icon_file" accept="image/*" style="width: 100%; padding: 8px; background: #12183a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-size: 0.9rem;">
        </div>

        <!-- Preview -->
        <div style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 5px;">
          <img id="icon-preview" src="{{ asset('foto_pribadi/placeholder.png') }}" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
        </div>
      </div>

      <div style="display: flex; gap: 10px;">
        <button type="submit" class="btn-quick" id="btn-save-social" style="border: none; cursor: pointer;">
          <span class="spinner-upload" id="spinner-social" style="width: 14px; height: 14px; margin-right: 5px; display: none;"></span>
          <span id="btn-save-social-text">Simpan</span>
        </button>
        <button type="button" class="btn-quick btn-quick-outline" id="btn-cancel-social" style="border: 1px solid var(--card-border); cursor: pointer;">Batal</button>
      </div>
    </form>
  </div>

  <!-- Table Container with safe overflow-x: auto (Rule 6 & 8) -->
  <div style="overflow-x: auto; width: 100%;">
    <table class="social-admin-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
      <thead>
        <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--accent);">
          <th style="padding: 12px 10px; font-weight: 600; width: 60px;">Ikon</th>
          <th style="padding: 12px 10px; font-weight: 600;">Nama</th>
          <th style="padding: 12px 10px; font-weight: 600;">URL Link</th>
          <th style="padding: 12px 10px; font-weight: 600; width: 100px;">Urutan</th>
          <th style="padding: 12px 10px; font-weight: 600; width: 150px; text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($socialLinks as $link)
          <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
            <td style="padding: 12px 10px; vertical-align: middle;">
              @php
                $isPredefined = str_starts_with($link->icon_path, 'foto_pribadi/');
                $iconUrl = $isPredefined ? asset($link->icon_path) : asset('storage/' . $link->icon_path);
              @endphp
              <div style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.05); border-radius: 8px; padding: 4px;">
                <img src="{{ $iconUrl }}" alt="{{ html_escape($link->name) }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
              </div>
            </td>
            <td style="padding: 12px 10px; font-weight: 500; vertical-align: middle;">{{ html_escape($link->name) }}</td>
            <td style="padding: 12px 10px; vertical-align: middle; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
              <a href="{{ $link->url }}" target="_blank" style="color: var(--secondary); text-decoration: none; font-family: monospace;">{{ html_escape($link->url) }}</a>
            </td>
            <td style="padding: 12px 10px; vertical-align: middle;">
              <span style="background: rgba(149, 204, 221, 0.15); color: var(--accent); padding: 2px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">{{ html_escape($link->order_num) }}</span>
            </td>
            <td style="padding: 12px 10px; text-align: center; vertical-align: middle; white-space: nowrap;">
              <button class="btn-edit-social" data-id="{{ $link->id }}" data-name="{{ html_escape($link->name) }}" data-url="{{ html_escape($link->url) }}" data-order="{{ html_escape($link->order_num) }}" data-icon="{{ html_escape($link->icon_path) }}" style="background: rgba(66, 116, 217, 0.2); border: 1px solid rgba(66, 116, 217, 0.3); color: var(--white); cursor: pointer; padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; margin-right: 5px; font-weight: 600; transition: all 0.2s;">
                Edit
              </button>
              <button class="btn-delete-social" data-id="{{ $link->id }}" data-name="{{ html_escape($link->name) }}" style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; cursor: pointer; padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; transition: all 0.2s;">
                Hapus
              </button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="empty-state" style="padding: 30px; text-align: center; color: var(--light); opacity: 0.5;">
              Belum ada tautan media sosial yang ditambahkan.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Card Kelola Riwayat Pendidikan (CRUD) -->
<div class="panel-card" style="margin-bottom: 30px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
    <div>
      <h3 style="font-size: 1.3rem; font-weight: 600; color: var(--accent);">Kelola Riwayat Pendidikan</h3>
      <p style="font-size: 0.85rem; color: var(--light); opacity: 0.7; line-height: 1.4;">
        Tambahkan, edit, atau hapus riwayat pendidikan Anda yang akan tampil di halaman depan portofolio.
      </p>
    </div>
    <button type="button" class="btn-quick" id="btn-add-education" style="border: none; cursor: pointer;">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
      </svg>
      Tambah Pendidikan
    </button>
  </div>

  <!-- Form Area (Hidden by default, shown on Add/Edit) -->
  <div id="education-form-wrapper" style="display: none; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 20px; border-radius: 12px; margin-bottom: 25px;">
    <h4 id="education-form-title" style="font-size: 1.05rem; font-weight: 600; margin-bottom: 15px; color: var(--white);">Tambah Riwayat Pendidikan</h4>
    <form id="education-link-form">
      <input type="hidden" id="education_id" name="id">
      
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 15px;">
        <div>
          <label for="education_degree" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px;">Gelar / Jenjang</label>
          <input type="text" id="education_degree" name="degree" required style="width: 100%; padding: 10px; background: #12183a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-size: 0.9rem;" placeholder="Contoh: S1, SMK, SMA">
        </div>
        
        <div>
          <label for="education_major" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px;">Jurusan / Bidang Studi</label>
          <input type="text" id="education_major" name="major" required style="width: 100%; padding: 10px; background: #12183a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-size: 0.9rem;" placeholder="Contoh: Teknik Informatika, IPA">
        </div>

        <div>
          <label for="education_institution" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px;">Nama Instansi / Sekolah</label>
          <input type="text" id="education_institution" name="institution" required style="width: 100%; padding: 10px; background: #12183a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-size: 0.9rem;" placeholder="Contoh: Universitas Atma Luhur">
        </div>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
        <div>
          <label for="education_period" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px;">Periode Pendidikan</label>
          <input type="text" id="education_period" name="period" required style="width: 100%; padding: 10px; background: #12183a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-size: 0.9rem;" placeholder="Contoh: 2022 - 2026">
        </div>

        <div>
          <label for="education_url" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px;">Website Sekolah / Kampus (Opsional)</label>
          <input type="text" id="education_url" name="url" style="width: 100%; padding: 10px; background: #12183a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-size: 0.9rem;" placeholder="Contoh: https://www.atmaluhur.ac.id/">
        </div>
      </div>

      <div style="display: flex; gap: 10px;">
        <button type="submit" class="btn-quick" id="btn-save-education" style="border: none; cursor: pointer;">
          <span class="spinner-upload" id="spinner-education" style="width: 14px; height: 14px; margin-right: 5px; display: none;"></span>
          <span id="btn-save-education-text">Simpan</span>
        </button>
        <button type="button" class="btn-quick btn-quick-outline" id="btn-cancel-education" style="border: 1px solid var(--card-border); cursor: pointer;">Batal</button>
      </div>
    </form>
  </div>

  <!-- Table Container with safe overflow-x: auto (Rule 6 & 8) -->
  <div style="overflow-x: auto; width: 100%;">
    <table class="education-admin-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
      <thead>
        <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--accent);">
          <th style="padding: 12px 10px; font-weight: 600;">Jenjang & Jurusan</th>
          <th style="padding: 12px 10px; font-weight: 600;">Instansi / Sekolah</th>
          <th style="padding: 12px 10px; font-weight: 600; width: 120px;">Periode</th>
          <th style="padding: 12px 10px; font-weight: 600;">Website</th>
          <th style="padding: 12px 10px; font-weight: 600; width: 150px; text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($educationsList as $edu)
          <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
            <td style="padding: 12px 10px; font-weight: 500; vertical-align: middle;">
              <span style="color: var(--white); font-weight: 600;">{{ html_escape($edu->degree) }}</span> - {{ html_escape($edu->major) }}
            </td>
            <td style="padding: 12px 10px; vertical-align: middle;">{{ html_escape($edu->institution) }}</td>
            <td style="padding: 12px 10px; vertical-align: middle;">{{ html_escape($edu->period) }}</td>
            <td style="padding: 12px 10px; vertical-align: middle; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
              @if($edu->url)
                <a href="{{ $edu->url }}" target="_blank" style="color: var(--secondary); text-decoration: none; font-family: monospace;">{{ html_escape($edu->url) }}</a>
              @else
                <span style="color: var(--light); opacity: 0.4; font-style: italic;">Tidak ada</span>
              @endif
            </td>
            <td style="padding: 12px 10px; text-align: center; vertical-align: middle; white-space: nowrap;">
              <button class="btn-edit-education" data-id="{{ $edu->id }}" data-degree="{{ html_escape($edu->degree) }}" data-major="{{ html_escape($edu->major) }}" data-institution="{{ html_escape($edu->institution) }}" data-period="{{ html_escape($edu->period) }}" data-url="{{ html_escape($edu->url) }}" style="background: rgba(66, 116, 217, 0.2); border: 1px solid rgba(66, 116, 217, 0.3); color: var(--white); cursor: pointer; padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; margin-right: 5px; font-weight: 600; transition: all 0.2s;">
                Edit
              </button>
              <button class="btn-delete-education" data-id="{{ $edu->id }}" data-institution="{{ html_escape($edu->institution) }}" style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; cursor: pointer; padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; transition: all 0.2s;">
                Hapus
              </button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="empty-state-edu" style="padding: 30px; text-align: center; color: var(--light); opacity: 0.5;">
              Belum ada riwayat pendidikan yang ditambahkan.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Ringkasan Statistik -->
<div class="stats-grid">
  <!-- <div class="stat-card">
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
  </div> -->

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

<!-- Panel Kustomisasi Warna Tema (Rule 5 & 6) -->
<div class="panel-card" style="margin-top: 30px; margin-bottom: 30px;">
  <h3 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px; color: var(--accent);">Kustomisasi Warna Tema Portofolio</h3>
  <p style="font-size: 0.85rem; color: var(--light); opacity: 0.7; margin-bottom: 25px; line-height: 1.4;">
    Sesuaikan skema warna pada halaman utama portfolio Anda dan halaman detail proyek. Perubahan warna akan langsung diterapkan secara instan menggunakan variabel CSS kustom.
  </p>

  <form id="theme-color-form" style="width: 100%; text-align: left;">
    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 25px;">
      <!-- Warna Utama -->
      <div style="flex: 1; min-width: 180px;">
        <label for="primary_color" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 8px; font-weight: 500;">Warna Utama (Primary)</label>
        <div style="display: flex; align-items: center; gap: 10px;">
          <input type="color" id="primary_color" name="primary_color" value="{{ $profile->primary_color ?? '#293681' }}" style="width: 45px; height: 45px; border: none; border-radius: 8px; cursor: pointer; background: none;">
          <input type="text" id="primary_color_text" value="{{ $profile->primary_color ?? '#293681' }}" style="flex: 1; padding: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; text-transform: uppercase;" placeholder="#293681">
        </div>
      </div>

      <!-- Warna Sekunder -->
      <div style="flex: 1; min-width: 180px;">
        <label for="secondary_color" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 8px; font-weight: 500;">Warna Sekunder (Secondary)</label>
        <div style="display: flex; align-items: center; gap: 10px;">
          <input type="color" id="secondary_color" name="secondary_color" value="{{ $profile->secondary_color ?? '#4274D9' }}" style="width: 45px; height: 45px; border: none; border-radius: 8px; cursor: pointer; background: none;">
          <input type="text" id="secondary_color_text" value="{{ $profile->secondary_color ?? '#4274D9' }}" style="flex: 1; padding: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; text-transform: uppercase;" placeholder="#4274D9">
        </div>
      </div>

      <!-- Warna Aksen -->
      <div style="flex: 1; min-width: 180px;">
        <label for="accent_color" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 8px; font-weight: 500;">Warna Sorotan (Accent)</label>
        <div style="display: flex; align-items: center; gap: 10px;">
          <input type="color" id="accent_color" name="accent_color" value="{{ $profile->accent_color ?? '#95CCDD' }}" style="width: 45px; height: 45px; border: none; border-radius: 8px; cursor: pointer; background: none;">
          <input type="text" id="accent_color_text" value="{{ $profile->accent_color ?? '#95CCDD' }}" style="flex: 1; padding: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; text-transform: uppercase;" placeholder="#95CCDD">
        </div>
      </div>

      <!-- Warna Navigator -->
      <div style="flex: 1; min-width: 180px;">
        <label for="navigator_color" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 8px; font-weight: 500;">Warna Navigator (Header & Footer)</label>
        <div style="display: flex; align-items: center; gap: 10px;">
          <input type="color" id="navigator_color" name="navigator_color" value="{{ $profile->navigator_color ?? '#293681' }}" style="width: 45px; height: 45px; border: none; border-radius: 8px; cursor: pointer; background: none;">
          <input type="text" id="navigator_color_text" value="{{ $profile->navigator_color ?? '#293681' }}" style="flex: 1; padding: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; text-transform: uppercase;" placeholder="#293681">
        </div>
      </div>
    </div>

    <!-- Baris Kedua: Pengatur Transparansi Background (Warna Utama) -->
    <div style="margin-bottom: 30px; max-width: 500px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 20px; border-radius: 12px;">
      <label for="primary_opacity" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 12px; font-weight: 500;">
        Transparansi Overlay Background Halaman Utama: <strong id="primary_opacity_value">{{ intval(($profile->primary_opacity ?? 0.85) * 100) }}%</strong>
      </label>
      <div style="display: flex; align-items: center; gap: 15px;">
        <input type="range" id="primary_opacity" name="primary_opacity" min="0" max="1" step="0.05" value="{{ $profile->primary_opacity ?? 0.85 }}" style="flex: 1; accent-color: var(--accent); cursor: pointer; height: 6px; border-radius: 3px; background: rgba(255,255,255,0.15);">
        <span id="primary_opacity_num" style="font-size: 0.85rem; color: var(--light); min-width: 35px; text-align: right; font-weight: 600;">{{ $profile->primary_opacity ?? '0.85' }}</span>
      </div>
      <small style="display: block; font-size: 0.75rem; color: var(--light); opacity: 0.5; margin-top: 8px;">
        *Geser ke kanan untuk membuat overlay semakin tebal (solid), geser ke kiri untuk semakin transparan.
      </small>
    </div>

    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
      <button type="submit" class="btn-quick" id="btn-save-colors" style="border: none; cursor: pointer; height: auto;">
        <span class="spinner-upload" id="spinner-colors" style="width: 14px; height: 14px; margin-right: 5px;"></span>
        <span>Simpan Warna</span>
      </button>
      <button type="button" class="btn-quick btn-quick-outline" id="btn-reset-colors" style="border: 1px solid var(--card-border); cursor: pointer;">
        <span class="spinner-upload" id="spinner-reset" style="width: 14px; height: 14px; margin-right: 5px;"></span>
        <span>Reset Default</span>
      </button>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Sinkronisasi input color picker dengan input text
    $('#primary_color').on('input', function() {
      $('#primary_color_text').val($(this).val());
    });
    $('#primary_color_text').on('input', function() {
      const val = $(this).val();
      if(/^#[0-9A-F]{6}$/i.test(val)) {
        $('#primary_color').val(val);
      }
    });

    $('#secondary_color').on('input', function() {
      $('#secondary_color_text').val($(this).val());
    });
    $('#secondary_color_text').on('input', function() {
      const val = $(this).val();
      if(/^#[0-9A-F]{6}$/i.test(val)) {
        $('#secondary_color').val(val);
      }
    });

    $('#accent_color').on('input', function() {
      $('#accent_color_text').val($(this).val());
    });
    $('#accent_color_text').on('input', function() {
      const val = $(this).val();
      if(/^#[0-9A-F]{6}$/i.test(val)) {
        $('#accent_color').val(val);
      }
    });

    $('#navigator_color').on('input', function() {
      $('#navigator_color_text').val($(this).val());
    });
    $('#navigator_color_text').on('input', function() {
      const val = $(this).val();
      if(/^#[0-9A-F]{6}$/i.test(val)) {
        $('#navigator_color').val(val);
      }
    });

    // Update label angka transparansi saat range digeser
    $('#primary_opacity').on('input', function() {
      const val = $(this).val();
      $('#primary_opacity_value').text(Math.round(val * 100) + '%');
      $('#primary_opacity_num').text(val);
    });

    // Submit form simpan warna via AJAX (Rule 5)
    $('#theme-color-form').on('submit', function(e) {
      e.preventDefault();

      const primary = $('#primary_color').val();
      const secondary = $('#secondary_color').val();
      const accent = $('#accent_color').val();
      const navigator = $('#navigator_color').val();
      const opacity = $('#primary_opacity').val();

      const btn = $('#btn-save-colors');
      const spinner = $('#spinner-colors');
      const btnText = btn.find('span:last-child');

      btn.prop('disabled', true);
      spinner.css('display', 'inline-block');
      btnText.text('Menyimpan...');

      $.ajax({
        url: "{{ url('/portal-admin/dashboard/update-colors') }}",
        type: "POST",
        data: {
          primary_color: primary,
          secondary_color: secondary,
          accent_color: accent,
          navigator_color: navigator,
          primary_opacity: opacity,
          _token: csrfToken
        },
        dataType: "json",
        success: function(response) {
          spinner.hide();
          btnText.text('Simpan Warna');
          btn.prop('disabled', false);
          window.showToast('success', response.message);
        },
        error: function(xhr) {
          spinner.hide();
          btnText.text('Simpan Warna');
          btn.prop('disabled', false);

          let errorMessage = 'Gagal menyimpan warna tema.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // Reset warna tema ke default
    $('#btn-reset-colors').on('click', function() {
      if(!confirm('Apakah Anda yakin ingin meriset skema warna kembali ke pengaturan bawaan CSS?')) {
        return;
      }

      const btn = $(this);
      const spinner = $('#spinner-reset');
      const btnText = btn.find('span:last-child');

      btn.prop('disabled', true);
      spinner.css('display', 'inline-block');
      btnText.text('Mereset...');

      $.ajax({
        url: "{{ url('/portal-admin/dashboard/update-colors') }}",
        type: "POST",
        data: {
          reset: 1,
          _token: csrfToken
        },
        dataType: "json",
        success: function(response) {
          spinner.hide();
          btnText.text('Reset Default');
          btn.prop('disabled', false);

          // Reset input ke warna fallback
          $('#primary_color').val('#293681');
          $('#primary_color_text').val('#293681');
          $('#secondary_color').val('#4274D9');
          $('#secondary_color_text').val('#4274D9');
          $('#accent_color').val('#95CCDD');
          $('#accent_color_text').val('#95CCDD');
          $('#navigator_color').val('#293681');
          $('#navigator_color_text').val('#293681');
          $('#primary_opacity').val(0.85);
          $('#primary_opacity_value').text('85%');
          $('#primary_opacity_num').text('0.85');

          window.showToast('success', response.message);
        },
        error: function(xhr) {
          spinner.hide();
          btnText.text('Reset Default');
          btn.prop('disabled', false);

          let errorMessage = 'Gagal meriset warna tema.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // Event Handler untuk CRUD Sosial Media
    const placeholderIcon = "{{ asset('foto_pribadi/placeholder.png') }}";

    // Ubah pratinjau ikon saat pilihan dropdown bawaan diganti
    $('#social_predefined_icon').on('change', function() {
      const val = $(this).val();
      if (val) {
        $('#icon-preview').attr('src', "{{ url('/') }}/" + val);
        // Reset file input agar tidak bentrok
        $('#social_icon_file').val('');
      } else {
        $('#icon-preview').attr('src', placeholderIcon);
      }
    });

    // Ubah pratinjau ikon saat file kustom diunggah
    $('#social_icon_file').on('change', function() {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          $('#icon-preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
        // Reset dropdown bawaan agar tidak bentrok
        $('#social_predefined_icon').val('');
      } else {
        // Jika dibatalkan, kembalikan ke dropdown bawaan jika ada
        const predefined = $('#social_predefined_icon').val();
        if (predefined) {
          $('#icon-preview').attr('src', "{{ url('/') }}/" + predefined);
        } else {
          $('#icon-preview').attr('src', placeholderIcon);
        }
      }
    });

    // Buka form tambah
    $('#btn-add-social').on('click', function() {
      $('#social-form-title').text('Tambah Link Sosial Media Baru');
      $('#social_id').val('');
      $('#social_name').val('');
      $('#social_url').val('');
      $('#social_order').val('0');
      $('#social_predefined_icon').val('').trigger('change');
      $('#social_icon_file').val('');
      $('#icon-preview').attr('src', placeholderIcon);
      $('#btn-save-social-text').text('Simpan');
      $('#social-form-wrapper').slideDown(300);
      $('html, body').animate({
        scrollTop: $('#social-form-wrapper').offset().top - 100
      }, 500);
    });

    // Edit link sosial media
    $('.btn-edit-social').on('click', function() {
      const id = $(this).data('id');
      const name = $(this).data('name');
      const url = $(this).data('url');
      const order = $(this).data('order');
      const icon = $(this).data('icon');

      $('#social-form-title').text('Ubah Link Sosial Media');
      $('#social_id').val(id);
      $('#social_name').val(name);
      $('#social_url').val(url);
      $('#social_order').val(order);
      $('#social_icon_file').val('');

      if (icon && icon.startsWith('foto_pribadi/')) {
        $('#social_predefined_icon').val(icon);
        $('#icon-preview').attr('src', "{{ url('/') }}/" + icon);
      } else {
        $('#social_predefined_icon').val('');
        if (icon) {
          $('#icon-preview').attr('src', "{{ asset('storage') }}/" + icon);
        } else {
          $('#icon-preview').attr('src', placeholderIcon);
        }
      }

      $('#btn-save-social-text').text('Simpan Perubahan');
      $('#social-form-wrapper').slideDown(300);
      $('html, body').animate({
        scrollTop: $('#social-form-wrapper').offset().top - 100
      }, 500);
    });

    // Batal
    $('#btn-cancel-social').on('click', function() {
      $('#social-form-wrapper').slideUp(300);
    });

    // Submit form AJAX untuk Simpan/Edit (Rule 5)
    $('#social-link-form').on('submit', function(e) {
      e.preventDefault();

      const btn = $('#btn-save-social');
      const spinner = $('#spinner-social');
      const btnText = $('#btn-save-social-text');
      const id = $('#social_id').val();

      btn.prop('disabled', true);
      spinner.show();
      btnText.text('Menyimpan...');

      // Menggunakan FormData karena mendukung unggah berkas biner
      const formData = new FormData(this);
      formData.append('_token', csrfToken);

      $.ajax({
        url: "{{ url('/portal-admin/social-links/simpan') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(response) {
          spinner.hide();
          btn.prop('disabled', false);
          btnText.text(id ? 'Simpan Perubahan' : 'Simpan');
          $('#social-form-wrapper').slideUp(300);
          window.showToast('success', response.message);

          // Muat ulang halaman dalam 1 detik agar data terupdate di tabel
          setTimeout(function() {
            location.reload();
          }, 1000);
        },
        error: function(xhr) {
          spinner.hide();
          btn.prop('disabled', false);
          btnText.text(id ? 'Simpan Perubahan' : 'Simpan');

          let errorMessage = 'Gagal menyimpan link sosial media.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // Delete AJAX link sosial media (Rule 5 & 15)
    $('.btn-delete-social').on('click', function() {
      const id = $(this).data('id');
      const name = $(this).data('name');

      if (!confirm('Apakah Anda yakin ingin menghapus link sosial media "' + name + '" secara permanen?')) {
        return;
      }

      const btn = $(this);
      btn.prop('disabled', true).text('...');

      $.ajax({
        url: "{{ url('/portal-admin/social-links/delete') }}/" + id,
        type: "DELETE",
        data: {
          _token: csrfToken
        },
        dataType: "json",
        success: function(response) {
          window.showToast('success', response.message);

          // Sembunyikan baris dengan transisi smooth
          btn.closest('tr').fadeOut(400, function() {
            $(this).remove();
            
            // Tampilkan empty state jika tabel kosong
            if ($('.social-admin-table tbody tr').length === 0) {
              $('.social-admin-table tbody').append(
                '<tr><td colspan="5" class="empty-state" style="padding: 30px; text-align: center; color: var(--light); opacity: 0.5;">Belum ada tautan media sosial yang ditambahkan.</td></tr>'
              );
            }
          });
        },
        error: function(xhr) {
          btn.prop('disabled', false).text('Hapus');
          let errorMessage = 'Gagal menghapus link sosial media.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // Event Handler untuk CRUD Riwayat Pendidikan
    // Buka form tambah pendidikan
    $('#btn-add-education').on('click', function() {
      $('#education-form-title').text('Tambah Riwayat Pendidikan Baru');
      $('#education_id').val('');
      $('#education_degree').val('');
      $('#education_major').val('');
      $('#education_institution').val('');
      $('#education_period').val('');
      $('#education_url').val('');
      $('#btn-save-education-text').text('Simpan');
      $('#education-form-wrapper').slideDown(300);
      $('html, body').animate({
        scrollTop: $('#education-form-wrapper').offset().top - 100
      }, 500);
    });

    // Buka form edit pendidikan
    $('.btn-edit-education').on('click', function() {
      const id = $(this).data('id');
      const degree = $(this).data('degree');
      const major = $(this).data('major');
      const institution = $(this).data('institution');
      const period = $(this).data('period');
      const url = $(this).data('url');

      $('#education-form-title').text('Ubah Riwayat Pendidikan');
      $('#education_id').val(id);
      $('#education_degree').val(degree);
      $('#education_major').val(major);
      $('#education_institution').val(institution);
      $('#education_period').val(period);
      $('#education_url').val(url);
      $('#btn-save-education-text').text('Simpan Perubahan');
      $('#education-form-wrapper').slideDown(300);
      $('html, body').animate({
        scrollTop: $('#education-form-wrapper').offset().top - 100
      }, 500);
    });

    // Batal edit/tambah pendidikan
    $('#btn-cancel-education').on('click', function() {
      $('#education-form-wrapper').slideUp(300);
    });

    // Submit form AJAX untuk Simpan/Edit Pendidikan (Rule 5)
    $('#education-link-form').on('submit', function(e) {
      e.preventDefault();

      const btn = $('#btn-save-education');
      const spinner = $('#spinner-education');
      const btnText = $('#btn-save-education-text');
      const id = $('#education_id').val();

      btn.prop('disabled', true);
      spinner.show();
      btnText.text('Menyimpan...');

      $.ajax({
        url: "{{ url('/portal-admin/education/simpan') }}",
        type: "POST",
        data: {
          id: id,
          degree: $('#education_degree').val(),
          major: $('#education_major').val(),
          institution: $('#education_institution').val(),
          period: $('#education_period').val(),
          url: $('#education_url').val(),
          _token: csrfToken
        },
        dataType: "json",
        success: function(response) {
          spinner.hide();
          btn.prop('disabled', false);
          btnText.text(id ? 'Simpan Perubahan' : 'Simpan');
          $('#education-form-wrapper').slideUp(300);
          window.showToast('success', response.message);

          // Muat ulang halaman dalam 1 detik agar data terupdate di tabel
          setTimeout(function() {
            location.reload();
          }, 1000);
        },
        error: function(xhr) {
          spinner.hide();
          btn.prop('disabled', false);
          btnText.text(id ? 'Simpan Perubahan' : 'Simpan');

          let errorMessage = 'Gagal menyimpan riwayat pendidikan.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // Delete AJAX riwayat pendidikan (Rule 5 & 15)
    $('.btn-delete-education').on('click', function() {
      const id = $(this).data('id');
      const institution = $(this).data('institution');

      if (!confirm('Apakah Anda yakin ingin menghapus riwayat pendidikan di "' + institution + '" secara permanen?')) {
        return;
      }

      const btn = $(this);
      btn.prop('disabled', true).text('...');

      $.ajax({
        url: "{{ url('/portal-admin/education/delete') }}/" + id,
        type: "DELETE",
        data: {
          _token: csrfToken
        },
        dataType: "json",
        success: function(response) {
          window.showToast('success', response.message);

          // Sembunyikan baris dengan transisi smooth
          btn.closest('tr').fadeOut(400, function() {
            $(this).remove();
            
            // Tampilkan empty state jika tabel kosong
            if ($('.education-admin-table tbody tr').length === 0) {
              $('.education-admin-table tbody').append(
                '<tr><td colspan="5" class="empty-state-edu" style="padding: 30px; text-align: center; color: var(--light); opacity: 0.5;">Belum ada riwayat pendidikan yang ditambahkan.</td></tr>'
              );
            }
          });
        },
        error: function(xhr) {
          btn.prop('disabled', false).text('Hapus');
          let errorMessage = 'Gagal menghapus riwayat pendidikan.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });
  });
</script>
@endsection
