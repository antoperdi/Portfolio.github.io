@extends('admin.layout')

@section('title', 'Ubah & Tambah Gambar')
@section('header_title', 'Ubah & Tambah Gambar')
@section('header_subtitle', 'Perbarui foto utama (Hero) dan foto Tentang Saya langsung ke server database')

@section('styles')
<style>
  .upload-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 30px;
  }

  .upload-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    box-shadow: var(--box-shadow);
  }

  .upload-card h3 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: var(--accent);
  }

  .upload-card p.card-desc {
    font-size: 0.85rem;
    color: var(--light);
    opacity: 0.7;
    margin-bottom: 25px;
    line-height: 1.4;
  }

  /* Preview frame styling */
  .preview-container {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    border: 3px solid rgba(66, 116, 217, 0.3);
    overflow: hidden;
    position: relative;
    margin-bottom: 25px;
    background: rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
  }

  .preview-container-square {
    border-radius: 16px;
    width: 100%;
    max-width: 280px;
    height: 200px;
  }

  .preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .preview-container:hover .preview-image {
    transform: scale(1.05);
  }

  /* Custom file input styling */
  .file-input-wrapper {
    position: relative;
    width: 100%;
    margin-bottom: 15px;
  }

  .file-input-hidden {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 10;
  }

  .file-input-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px dashed rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 15px;
    color: var(--light);
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    width: 100%;
  }

  .file-input-hidden:hover + .file-input-label {
    background: rgba(255, 255, 255, 0.08);
    border-color: var(--secondary);
    color: var(--white);
  }

  .file-input-hidden:focus + .file-input-label {
    border-color: var(--secondary);
    box-shadow: 0 0 10px rgba(66, 116, 217, 0.3);
  }

  /* Upload button */
  .btn-upload {
    width: 100%;
    background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
    border: none;
    border-radius: 12px;
    padding: 14px;
    font-family: var(--font-main);
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--white);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 15px rgba(66, 116, 217, 0.2);
    transition: all 0.3s ease;
  }

  .btn-upload:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(66, 116, 217, 0.4);
    filter: brightness(1.1);
  }

  .btn-upload:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }

  /* Spinner for upload */
  .spinner-upload {
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: var(--white);
    animation: spin 0.8s linear infinite;
    display: none;
  }

  @keyframes spin {
    to { transform: rotate(360deg); }
  }

  .info-alert {
    background: rgba(149, 204, 221, 0.1);
    border: 1px solid rgba(149, 204, 221, 0.2);
    border-radius: 12px;
    padding: 20px;
    color: var(--light);
    font-size: 0.9rem;
    line-height: 1.5;
    display: flex;
    gap: 15px;
    align-items: flex-start;
  }

  .info-alert svg {
    color: var(--accent);
    flex-shrink: 0;
    margin-top: 2px;
  }

  /* Gallery Admin Grid Styles */
  .gallery-admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
    width: 100%;
  }

  .gallery-admin-card {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid var(--card-border);
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
  }

  .gallery-admin-card:hover {
    border-color: rgba(66, 116, 217, 0.3);
    transform: translateY(-2px);
  }

  .gallery-admin-img-wrapper {
    height: 140px;
    overflow: hidden;
    background: rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .gallery-admin-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .gallery-admin-card:hover .gallery-admin-img-wrapper img {
    transform: scale(1.05);
  }

  .gallery-admin-info {
    padding: 12px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex: 1;
    justify-content: space-between;
  }

  .gallery-admin-name {
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--white);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: left;
  }

  .btn-delete-my-gallery {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.25);
    color: #fca5a5;
    padding: 8px 12px;
    border-radius: 8px;
    font-family: var(--font-main);
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all 0.3s ease;
  }

  .btn-delete-my-gallery:hover {
    background: #ef4444;
    color: var(--white);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
  }
</style>
@endsection

@section('content')
<div class="upload-grid">
  <!-- Kartu Unggah 1: Foto Profil Utama (Hero) -->
  <div class="upload-card">
    <h3>Foto Profil Utama</h3>
    <p class="card-desc">Format yang diizinkan: JPG, JPEG, PNG, WEBP. Maksimal ukuran file: 5 MB.</p>
    
    <div class="preview-container">
      <img id="hero-preview" src="{{ url('/profile/image/hero') }}" alt="Preview Foto Utama" class="preview-image">
    </div>

    <form class="upload-form" data-type="hero" style="width: 100%; text-align: left;">
      <div style="margin-bottom: 15px;">
        <label for="hero-name" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Nama Lengkap <span style="color: var(--accent);">*</span></label>
        <input type="text" id="hero-name" name="name" required value="{{ html_escape($profile->name) }}" placeholder="Masukkan nama lengkap..." style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
      </div>

      <div style="margin-bottom: 15px;">
        <label for="hero-title" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Hero Subtitle <span style="color: var(--accent);">*</span></label>
        <textarea id="hero-title" name="title" required placeholder="Masukkan subtitle hero..." style="width: 100%; height: 80px; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; resize: vertical; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">{{ html_escape($profile->title) }}</textarea>
      </div>

      <div class="file-input-wrapper">
        <input type="file" class="file-input-hidden image-input" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
        <div class="file-input-label">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="17 8 12 3 7 8"></polyline>
            <line x1="12" y1="3" x2="12" y2="15"></line>
          </svg>
          <span class="file-name-text">Pilih Gambar Hero (Opsional)...</span>
        </div>
      </div>
      
      <button type="submit" class="btn-upload" id="btn-submit-hero">
        <span class="spinner-upload"></span>
        <span>Perbarui Profil &amp; Foto Hero</span>
      </button>
    </form>
  </div>

  <!-- Kartu Unggah 2: Foto Tentang Saya (About) -->
  <div class="upload-card">
    <h3>Foto Tentang Saya (About)</h3>
    <p class="card-desc">Format yang diizinkan: JPG, JPEG, PNG, WEBP. Maksimal ukuran file: 5 MB.</p>
    
    <div class="preview-container preview-container-square">
      <img id="about-preview" src="{{ url('/profile/image/about') }}" alt="Preview Foto Tentang Saya" class="preview-image">
    </div>

    <form class="upload-form" data-type="about" style="width: 100%; text-align: left;">
      <div style="margin-bottom: 15px;">
        <label for="about-bio" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Bio Tentang Saya <span style="color: var(--accent);">*</span></label>
        <textarea id="about-bio" name="bio" required placeholder="Masukkan bio tentang saya..." style="width: 100%; height: 80px; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; resize: vertical; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">{{ html_escape($profile->bio) }}</textarea>
      </div>

      <div class="file-input-wrapper">
        <input type="file" class="file-input-hidden image-input" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
        <div class="file-input-label">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="17 8 12 3 7 8"></polyline>
            <line x1="12" y1="3" x2="12" y2="15"></line>
          </svg>
          <span class="file-name-text">Pilih Gambar Tentang Saya (Opsional)...</span>
        </div>
      </div>
      
      <button type="submit" class="btn-upload" id="btn-submit-about">
        <span class="spinner-upload"></span>
        <span>Perbarui Bio &amp; Foto About</span>
      </button>
    </form>
  </div>
</div>

<!-- Bagian Panel Pengelolaan My Gallery (my_galleries) -->
<div class="panel-card" style="margin-top: 30px; margin-bottom: 30px;">
  <h3 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px; color: var(--accent);">Kelola Galeri Aktivitas &amp; Background</h3>
  <p style="font-size: 0.85rem; color: var(--light); opacity: 0.7; margin-bottom: 25px; line-height: 1.4;">
    Kelola gambar dari tabel <code>my_galleries</code>. Anda dapat mengunggah gambar baru, menyetelnya sebagai latar belakang (body background) halaman portofolio utama, dan mengatur apakah gambar tersebut tampil di bagian Galeri Aktivitas di halaman depan.
  </p>

  <!-- Form Unggah Foto My Gallery Baru -->
  <form id="upload-my-gallery-form" style="width: 100%; max-width: 500px; margin: 0 auto 35px auto; text-align: left;">
    <div style="margin-bottom: 15px;">
      <label for="my-gallery-title" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Judul / Nama Gambar <span style="color: var(--accent);">*</span></label>
      <input type="text" id="my-gallery-title" name="title" required placeholder="Masukkan judul gambar..." style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
    </div>

    <div style="margin-bottom: 15px;">
      <label for="my-gallery-caption" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Keterangan / Deskripsi (Opsional)</label>
      <textarea id="my-gallery-caption" name="caption" placeholder="Masukkan deskripsi gambar jika ada..." style="width: 100%; height: 80px; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; resize: vertical; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'"></textarea>
    </div>

    <div style="margin-bottom: 15px; display: flex; flex-direction: column; gap: 8px;">
      <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--light); font-weight: 500; cursor: pointer; user-select: none;">
        <input type="checkbox" id="my-gallery-is-background" name="is_background" style="width: 16px; height: 16px; cursor: pointer;">
        <span>Jadikan Background Halaman Utama</span>
      </label>
      <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--light); font-weight: 500; cursor: pointer; user-select: none;">
        <input type="checkbox" id="my-gallery-is-active" name="is_active" checked style="width: 16px; height: 16px; cursor: pointer;">
        <span>Tampilkan di Galeri Aktivitas</span>
      </label>
    </div>

    <div class="file-input-wrapper">
      <input type="file" class="file-input-hidden" id="my-gallery-image-input" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" required>
      <div class="file-input-label" id="my-gallery-file-label">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="17 8 12 3 7 8"></polyline>
          <line x1="12" y1="3" x2="12" y2="15"></line>
        </svg>
        <span id="my-gallery-file-name-text">Pilih Gambar Galeri...</span>
      </div>
    </div>
    
    <button type="submit" class="btn-upload" id="btn-upload-my-gallery" disabled style="max-width: 250px; margin: 15px auto 0 auto;">
      <span class="spinner-upload" id="spinner-my-gallery"></span>
      <span>Tambah Gambar</span>
    </button>
  </form>

  <!-- Grid Gambar My Gallery yang Terdaftar di Database -->
  <div class="gallery-admin-grid">
    @forelse($myGalleries as $item)
      <div class="gallery-admin-card" id="my-gallery-item-{{ $item->id }}">
        <div class="gallery-admin-img-wrapper">
          <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ html_escape($item->title) }}">
        </div>
        <div class="gallery-admin-info">
          <div class="gallery-admin-name" title="{{ html_escape($item->title) }}">{{ html_escape($item->title) }}</div>
          @if($item->caption)
            <div style="font-size: 0.75rem; color: var(--light); opacity: 0.6; text-align: left; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 32px; line-height: 1.2;" title="{{ html_escape($item->caption) }}">
              {{ html_escape($item->caption) }}
            </div>
          @endif
          
          <!-- Opsi Checkbox/Checklist Status Latar Belakang & Galeri Aktivitas (Rule 5 & 14) -->
          <div style="display: flex; flex-direction: column; gap: 6px; margin: 8px 0; text-align: left; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 8px;">
            <label style="display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: var(--light); cursor: pointer; user-select: none;">
              <input type="checkbox" class="toggle-gallery-status" data-id="{{ $item->id }}" data-field="is_background" {{ $item->is_background ? 'checked' : '' }} style="width: 14px; height: 14px; cursor: pointer;">
              <span style="{{ $item->is_background ? 'color: var(--accent); font-weight: 500;' : '' }}">Jadikan Background</span>
            </label>
            <label style="display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: var(--light); cursor: pointer; user-select: none;">
              <input type="checkbox" class="toggle-gallery-status" data-id="{{ $item->id }}" data-field="is_active" {{ $item->is_active ? 'checked' : '' }} style="width: 14px; height: 14px; cursor: pointer;">
              <span style="{{ $item->is_active ? 'color: var(--white);' : 'opacity: 0.5;' }}">Galeri Aktivitas</span>
            </label>
          </div>

          <button type="button" class="btn-delete-my-gallery" data-id="{{ $item->id }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
            Hapus
          </button>
        </div>
      </div>
    @empty
      <div style="grid-column: 1/-1; text-align: center; color: var(--light); opacity: 0.6; padding: 40px 0;">
        Belum ada foto di My Gallery. Silakan masukkan judul, pilih foto, dan tambahkan foto baru.
      </div>
    @endforelse
  </div>
</div>



<div class="info-alert">
  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="12" cy="12" r="10"></circle>
    <line x1="12" y1="16" x2="12" y2="12"></line>
    <line x1="12" y1="8" x2="12.01" y2="8"></line>
  </svg>
  <div>
    <strong>Informasi Penyimpanan Database & Penyimpanan Lokal:</strong><br>
    Gambar baru yang Anda unggah melalui form di atas akan disimpan baik di server database MySQL (kolom BLOB pada tabel <code>profile</code>) atau disimpan di dalam disk penyimpanan lokal web server (tabel <code>my_galleries</code>) demi mendukung performa dan skalabilitas aplikasi.
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Memicu preview instan lokal saat memilih file gambar (Client-side interactivity)
    $('.image-input').on('change', function(e) {
      const file = this.files[0];
      const form = $(this).closest('.upload-form');
      const submitBtn = form.find('.btn-upload');
      const labelText = form.find('.file-name-text');
      const type = form.data('type');
      const previewImg = $('#' + type + '-preview');

      if (file) {
        // Cek ukuran file di sisi client (maksimal 5MB sesuai instruksi user)
        const maxSize = 5 * 1024 * 1024; // 5 MB
        if (file.size > maxSize) {
          window.showToast('danger', 'Ukuran gambar melebihi 5 MB. Silakan pilih gambar lain.');
          this.value = ''; // Reset input
          labelText.text('Pilih Gambar...');
          submitBtn.prop('disabled', true);
          return;
        }

        // Tampilkan nama file
        labelText.text(file.name);
        submitBtn.prop('disabled', false);

        // Render preview instan menggunakan FileReader API
        const reader = new FileReader();
        reader.onload = function(event) {
          previewImg.attr('src', event.target.result);
        };
        reader.readAsDataURL(file);
      } else {
        if (type === 'hero') {
          labelText.text('Pilih Gambar Hero (Opsional)...');
        } else if (type === 'about') {
          labelText.text('Pilih Gambar Tentang Saya (Opsional)...');
        } else {
          labelText.text('Pilih Gambar...');
          submitBtn.prop('disabled', true);
        }
      }
    });

    // Proses unggah gambar / update profil menggunakan AJAX (FormData) sesuai Rule 5
    $('.upload-form').on('submit', function(e) {
      e.preventDefault();

      const form = $(this);
      const type = form.data('type');
      const submitBtn = form.find('.btn-upload');
      const spinner = form.find('.spinner-upload');
      const btnText = submitBtn.find('span:last-child');
      const fileInput = form.find('.image-input')[0];
      const file = fileInput.files[0];

      if (!file && type !== 'hero' && type !== 'about') {
        window.showToast('danger', 'Mohon pilih file gambar terlebih dahulu.');
        return;
      }

      // Buat FormData untuk mengirim data
      const formData = new FormData();
      if (file) {
        formData.append('image', file);
      }
      formData.append('type', type);

      if (type === 'hero') {
        formData.append('name', $('#hero-name').val());
        formData.append('title', $('#hero-title').val());
      } else if (type === 'about') {
        formData.append('bio', $('#about-bio').val());
      }

      // Loading state
      submitBtn.prop('disabled', true);
      spinner.show();
      btnText.text('Menyimpan...');

      $.ajax({
        url: "{{ url('/portal-admin/ubah-gambar/upload') }}",
        type: "POST",
        data: formData,
        contentType: false, // Wajib false untuk kirim biner file
        processData: false, // Wajib false agar jQuery tidak mengonversi ke query string
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        dataType: "json",
        success: function(response) {
          spinner.hide();
          btnText.text(type === 'hero' ? 'Perbarui Profil & Foto Hero' : 'Perbarui Bio & Foto About');
          if (type !== 'hero' && type !== 'about') {
            submitBtn.prop('disabled', true); // Nonaktifkan kembali untuk non-hero/non-about
          } else {
            submitBtn.prop('disabled', false); // Tetap aktif untuk hero & about agar bisa submit teks kembali
          }
          fileInput.value = ''; // Reset input file
          if (type === 'hero') {
            form.find('.file-name-text').text('Pilih Gambar Hero (Opsional)...');
          } else if (type === 'about') {
            form.find('.file-name-text').text('Pilih Gambar Tentang Saya (Opsional)...');
          } else {
            form.find('.file-name-text').text('Pilih Gambar...');
          }

          window.showToast('success', response.message);
          
          // Force reload image preview menggunakan timestamp agar cache browser ter-bypass
          if (file) {
            const timestamp = new Date().getTime();
            $('#' + type + '-preview').attr('src', "{{ url('/profile/image') }}/" + type + "?" + timestamp);
          }
        },
        error: function(xhr) {
          spinner.hide();
          btnText.text(type === 'hero' ? 'Perbarui Profil & Foto Hero' : 'Perbarui Bio & Foto About');
          submitBtn.prop('disabled', false);

          let errorMessage = 'Gagal memperbarui profil.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // --- LOGIKA TAMBAHAN UNTUK PENGELOLAAN TABEL gallery_me ---

    // Event listener untuk input file galeri baru


    // Event listener untuk input file my_gallery baru
    $('#my-gallery-image-input').on('change', function() {
      const file = this.files[0];
      const submitBtn = $('#btn-upload-my-gallery');
      const labelText = $('#my-gallery-file-name-text');

      if (file) {
        const maxSize = 5 * 1024 * 1024; // 5 MB
        if (file.size > maxSize) {
          window.showToast('danger', 'Ukuran gambar melebihi 5 MB. Silakan pilih gambar lain.');
          this.value = '';
          labelText.text('Pilih Gambar My Gallery...');
          submitBtn.prop('disabled', true);
          return;
        }
        labelText.text(file.name);
        submitBtn.prop('disabled', false);
      } else {
        labelText.text('Pilih Gambar My Gallery...');
        submitBtn.prop('disabled', true);
      }
    });

    // AJAX submit form tambah foto my_gallery (Rule 5)
    $('#upload-my-gallery-form').on('submit', function(e) {
      e.preventDefault();

      const form = $(this);
      const submitBtn = $('#btn-upload-my-gallery');
      const spinner = $('#spinner-my-gallery');
      const btnText = submitBtn.find('span:last-child');
      const fileInput = $('#my-gallery-image-input')[0];
      const file = fileInput.files[0];
      const title = $('#my-gallery-title').val();
      const caption = $('#my-gallery-caption').val();

      if (!file) {
        window.showToast('danger', 'Mohon pilih file gambar terlebih dahulu.');
        return;
      }
      if (!title) {
        window.showToast('danger', 'Mohon isi judul gambar terlebih dahulu.');
        return;
      }

      const formData = new FormData();
      formData.append('image', file);
      formData.append('title', title);
      formData.append('caption', caption);
      
      // Mengirimkan status checkbox/checklist
      if ($('#my-gallery-is-background').is(':checked')) {
        formData.append('is_background', '1');
      }
      if ($('#my-gallery-is-active').is(':checked')) {
        formData.append('is_active', '1');
      }

      submitBtn.prop('disabled', true);
      spinner.show();
      btnText.text('Menyimpan...');

      $.ajax({
        url: "{{ url('/portal-admin/ubah-gambar/upload-my-gallery') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        dataType: "json",
        success: function(response) {
          spinner.hide();
          btnText.text('Tambah Gambar');
          submitBtn.prop('disabled', true);
          fileInput.value = '';
          $('#my-gallery-title').val('');
          $('#my-gallery-caption').val('');
          $('#my-gallery-is-background').prop('checked', false);
          $('#my-gallery-is-active').prop('checked', true);
          $('#my-gallery-file-name-text').text('Pilih Gambar Galeri...');

          window.showToast('success', response.message);
          
          // Reload halaman secara otomatis dalam 1 detik untuk menyegarkan daftar gambar
          setTimeout(function() {
            location.reload();
          }, 1000);
        },
        error: function(xhr) {
          spinner.hide();
          btnText.text('Tambah Gambar');
          submitBtn.prop('disabled', false);

          let errorMessage = 'Gagal menambahkan foto ke Galeri.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // AJAX update status checkbox (is_active / is_background) (Rule 5 & 14)
    $(document).on('change', '.toggle-gallery-status', function() {
      const checkbox = $(this);
      const id = checkbox.data('id');
      const field = checkbox.data('field');
      const isChecked = checkbox.is(':checked') ? 1 : 0;
      const originalState = !isChecked; // Simpan status sebelumnya jika gagal

      checkbox.prop('disabled', true);

      $.ajax({
        url: "{{ url('/portal-admin/ubah-gambar/update-my-gallery-status') }}/" + id,
        type: "POST",
        data: {
          field: field,
          value: isChecked,
          _token: csrfToken
        },
        dataType: "json",
        success: function(response) {
          checkbox.prop('disabled', false);
          window.showToast('success', response.message);

          if (field === 'is_background') {
            if (isChecked === 1) {
              // Jika ini dicentang, hilangkan centang is_background lain secara visual
              $('.toggle-gallery-status[data-field="is_background"]').each(function() {
                const other = $(this);
                if (other.data('id') !== id) {
                  other.prop('checked', false);
                  other.next('span').css({'color': '', 'font-weight': ''});
                }
              });
              // Sorot teks checkbox yang dicentang
              checkbox.next('span').css({'color': 'var(--accent)', 'font-weight': '500'});
            } else {
              checkbox.next('span').css({'color': '', 'font-weight': ''});
            }
          } else if (field === 'is_active') {
            if (isChecked === 1) {
              checkbox.next('span').css({'color': 'var(--white)', 'opacity': '1'});
            } else {
              checkbox.next('span').css({'color': '', 'opacity': '0.5'});
            }
          }
        },
        error: function(xhr) {
          checkbox.prop('disabled', false);
          checkbox.prop('checked', originalState); // Kembalikan ke status awal
          
          let errorMessage = 'Gagal memperbarui status.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // AJAX delete foto my_gallery
    $(document).on('click', '.btn-delete-my-gallery', function(e) {
      e.preventDefault();

      const btn = $(this);
      const id = btn.data('id');
      
      if (!confirm('Apakah Anda yakin ingin menghapus foto My Gallery ini dari database dan penyimpanan?')) {
        return;
      }

      btn.prop('disabled', true).text('Menghapus...');

      $.ajax({
        url: "{{ url('/portal-admin/ubah-gambar/delete-my-gallery') }}/" + id,
        type: "POST",
        data: {
          _method: 'DELETE'
        },
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        dataType: "json",
        success: function(response) {
          window.showToast('success', response.message);
          // Hapus kartu gambar dari DOM secara visual dengan efek fadeOut
          $(`#my-gallery-item-${id}`).fadeOut(400, function() {
            $(this).remove();
            if ($('.btn-delete-my-gallery').length === 0) {
              $('#upload-my-gallery-form').next('.gallery-admin-grid').html(`
                <div style="grid-column: 1/-1; text-align: center; color: var(--light); opacity: 0.6; padding: 40px 0;">
                  Belum ada foto di My Gallery. Silakan masukkan judul, pilih foto, dan tambahkan foto baru.
                </div>
              `);
            }
          });
        },
        error: function(xhr) {
          btn.prop('disabled', false).html(`
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
            Hapus
          `);

          let errorMessage = 'Gagal menghapus foto My Gallery.';
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
