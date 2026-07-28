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
  });
</script>
@endsection
