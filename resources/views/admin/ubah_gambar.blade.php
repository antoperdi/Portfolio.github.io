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

  .btn-delete-gallery {
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

  .btn-delete-gallery:hover {
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
    <h3>Foto Profil Utama (Hero)</h3>
    <p class="card-desc">Format yang diizinkan: JPG, JPEG, PNG, WEBP. Maksimal ukuran file: 5 MB.</p>
    
    <div class="preview-container">
      <img id="hero-preview" src="{{ url('/profile/image/hero') }}" alt="Preview Foto Utama" class="preview-image">
    </div>

    <form class="upload-form" data-type="hero" style="width: 100%;">
      <div class="file-input-wrapper">
        <input type="file" class="file-input-hidden image-input" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
        <div class="file-input-label">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="17 8 12 3 7 8"></polyline>
            <line x1="12" y1="3" x2="12" y2="15"></line>
          </svg>
          <span class="file-name-text">Pilih Gambar Hero...</span>
        </div>
      </div>
      
      <button type="submit" class="btn-upload" disabled>
        <span class="spinner-upload"></span>
        <span>Unggah Foto Hero</span>
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

    <form class="upload-form" data-type="about" style="width: 100%;">
      <div class="file-input-wrapper">
        <input type="file" class="file-input-hidden image-input" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
        <div class="file-input-label">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="17 8 12 3 7 8"></polyline>
            <line x1="12" y1="3" x2="12" y2="15"></line>
          </svg>
          <span class="file-name-text">Pilih Gambar Tentang Saya...</span>
        </div>
      </div>
      
      <button type="submit" class="btn-upload" disabled>
        <span class="spinner-upload"></span>
        <span>Unggah Foto About</span>
      </button>
    </form>
  </div>
</div>

<!-- Bagian Panel Pengelolaan Galeri Aktivitas (gallery_me) -->
<div class="panel-card" style="margin-top: 30px; margin-bottom: 30px;">
  <h3 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px; color: var(--accent);">Kelola Galeri Aktivitas</h3>
  <p style="font-size: 0.85rem; color: var(--light); opacity: 0.7; margin-bottom: 25px; line-height: 1.4;">
    Tambahkan foto aktivitas baru secara langsung ke database MySQL (BLOB) atau hapus gambar galeri yang sudah ada.
  </p>

  <!-- Form Unggah Foto Galeri Baru -->
  <form id="upload-gallery-form" style="width: 100%; max-width: 500px; margin: 0 auto 35px auto; text-align: center;">
    <div class="file-input-wrapper">
      <input type="file" class="file-input-hidden" id="gallery-image-input" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" required>
      <div class="file-input-label" id="gallery-file-label">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="17 8 12 3 7 8"></polyline>
          <line x1="12" y1="3" x2="12" y2="15"></line>
        </svg>
        <span id="gallery-file-name-text">Pilih Gambar Galeri Baru...</span>
      </div>
    </div>
    
    <button type="submit" class="btn-upload" id="btn-upload-gallery" disabled style="max-width: 250px; margin: 15px auto 0 auto;">
      <span class="spinner-upload" id="spinner-gallery"></span>
      <span>Tambah ke Galeri</span>
    </button>
  </form>

  <!-- Grid Gambar Galeri yang Terdaftar di Database -->
  <div class="gallery-admin-grid">
    @forelse($galleries as $item)
      <div class="gallery-admin-card" id="gallery-item-{{ $item->id }}">
        <div class="gallery-admin-img-wrapper">
          <img src="{{ url('/gallery/image/' . $item->id) }}" alt="{{ html_escape($item->name) }}">
        </div>
        <div class="gallery-admin-info">
          <div class="gallery-admin-name" title="{{ html_escape($item->name) }}">{{ html_escape($item->name) }}</div>
          <button type="button" class="btn-delete-gallery" data-id="{{ $item->id }}">
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
        Belum ada foto di Galeri Aktivitas. Silakan pilih dan tambahkan foto baru di atas.
      </div>
    @endforelse
  </div>
</div>

<!-- Bagian Panel Pengelolaan Galeri Proyek (projects_gallery) -->
<div class="panel-card" style="margin-top: 30px; margin-bottom: 30px;">
  <h3 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px; color: var(--accent);">Kelola Galeri Proyek (projects_gallery)</h3>
  <p style="font-size: 0.85rem; color: var(--light); opacity: 0.7; margin-bottom: 25px; line-height: 1.4;">
    Tambahkan foto/screenshot proyek baru secara langsung ke database MySQL (BLOB pada tabel <code>projects_gallery</code>) atau hapus gambar yang ada.
  </p>

  <!-- Form Unggah Foto Galeri Proyek Baru -->
  <form id="upload-projects-gallery-form" style="width: 100%; max-width: 500px; margin: 0 auto 35px auto; text-align: center;">
    <div class="file-input-wrapper">
      <input type="file" class="file-input-hidden" id="projects-gallery-image-input" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" required>
      <div class="file-input-label" id="projects-gallery-file-label">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="17 8 12 3 7 8"></polyline>
          <line x1="12" y1="3" x2="12" y2="15"></line>
        </svg>
        <span id="projects-gallery-file-name-text">Pilih Gambar Galeri Proyek Baru...</span>
      </div>
    </div>
    
    <button type="submit" class="btn-upload" id="btn-upload-projects-gallery" disabled style="max-width: 250px; margin: 15px auto 0 auto;">
      <span class="spinner-upload" id="spinner-projects-gallery"></span>
      <span>Tambah ke Galeri Proyek</span>
    </button>
  </form>

  <!-- Grid Gambar Galeri Proyek yang Terdaftar di Database -->
  <div class="gallery-admin-grid">
    @forelse($projectsGalleries as $item)
      <div class="gallery-admin-card" id="projects-gallery-item-{{ $item->id }}">
        <div class="gallery-admin-img-wrapper">
          <img src="{{ url('/projects-gallery/image/' . $item->id) }}" alt="{{ html_escape($item->name) }}">
        </div>
        <div class="gallery-admin-info">
          <div class="gallery-admin-name" title="{{ html_escape($item->name) }}">{{ html_escape($item->name) }}</div>
          <button type="button" class="btn-delete-projects-gallery" data-id="{{ $item->id }}">
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
        Belum ada foto di Galeri Proyek. Silakan pilih dan tambahkan foto baru di atas.
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
    <strong>Informasi Penyimpanan Database:</strong><br>
    Seluruh gambar baru yang Anda unggah melalui form di atas akan disimpan secara langsung di dalam server database MySQL (kolom BLOB pada tabel <code>profile</code>, <code>gallery_me</code>, dan <code>projects_gallery</code>). Web server tidak akan menimbun berkas fisik baru, menjaga data Anda tetap terpusat dan aman.
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
        labelText.text('Pilih Gambar...');
        submitBtn.prop('disabled', true);
      }
    });

    // Proses unggah gambar menggunakan AJAX (FormData) sesuai Rule 5
    $('.upload-form').on('submit', function(e) {
      e.preventDefault();

      const form = $(this);
      const type = form.data('type');
      const submitBtn = form.find('.btn-upload');
      const spinner = form.find('.spinner-upload');
      const btnText = submitBtn.find('span:last-child');
      const fileInput = form.find('.image-input')[0];
      const file = fileInput.files[0];

      if (!file) {
        window.showToast('danger', 'Mohon pilih file gambar terlebih dahulu.');
        return;
      }

      // Buat FormData untuk mengirim file biner
      const formData = new FormData();
      formData.append('image', file);
      formData.append('type', type);

      // Loading state
      submitBtn.prop('disabled', true);
      spinner.show();
      btnText.text('Mengunggah...');

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
          btnText.text('Unggah Foto ' + (type === 'hero' ? 'Hero' : 'About'));
          submitBtn.prop('disabled', true); // Nonaktifkan tombol kembali setelah sukses
          fileInput.value = ''; // Reset input file

          window.showToast('success', response.message);
          
          // Force reload image preview menggunakan timestamp agar cache browser ter-bypass
          const timestamp = new Date().getTime();
          $('#' + type + '-preview').attr('src', "{{ url('/profile/image') }}/" + type + "?" + timestamp);
        },
        error: function(xhr) {
          spinner.hide();
          btnText.text('Unggah Foto ' + (type === 'hero' ? 'Hero' : 'About'));
          submitBtn.prop('disabled', false);

          let errorMessage = 'Gagal mengunggah gambar.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // --- LOGIKA TAMBAHAN UNTUK PENGELOLAAN TABEL gallery_me ---

    // Event listener untuk input file galeri baru
    $('#gallery-image-input').on('change', function() {
      const file = this.files[0];
      const submitBtn = $('#btn-upload-gallery');
      const labelText = $('#gallery-file-name-text');

      if (file) {
        const maxSize = 5 * 1024 * 1024; // 5 MB
        if (file.size > maxSize) {
          window.showToast('danger', 'Ukuran gambar melebihi 5 MB. Silakan pilih gambar lain.');
          this.value = '';
          labelText.text('Pilih Gambar Galeri Baru...');
          submitBtn.prop('disabled', true);
          return;
        }
        labelText.text(file.name);
        submitBtn.prop('disabled', false);
      } else {
        labelText.text('Pilih Gambar Galeri Baru...');
        submitBtn.prop('disabled', true);
      }
    });

    // AJAX submit form tambah foto galeri
    $('#upload-gallery-form').on('submit', function(e) {
      e.preventDefault();

      const form = $(this);
      const submitBtn = $('#btn-upload-gallery');
      const spinner = $('#spinner-gallery');
      const btnText = submitBtn.find('span:last-child');
      const fileInput = $('#gallery-image-input')[0];
      const file = fileInput.files[0];

      if (!file) {
        window.showToast('danger', 'Mohon pilih file gambar terlebih dahulu.');
        return;
      }

      const formData = new FormData();
      formData.append('image', file);

      submitBtn.prop('disabled', true);
      spinner.show();
      btnText.text('Menyimpan...');

      $.ajax({
        url: "{{ url('/portal-admin/ubah-gambar/upload-gallery') }}",
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
          btnText.text('Tambah ke Galeri');
          submitBtn.prop('disabled', true);
          fileInput.value = '';
          $('#gallery-file-name-text').text('Pilih Gambar Galeri Baru...');

          window.showToast('success', response.message);
          
          // Reload halaman secara otomatis dalam 1 detik untuk menyegarkan daftar gambar galeri
          setTimeout(function() {
            location.reload();
          }, 1000);
        },
        error: function(xhr) {
          spinner.hide();
          btnText.text('Tambah ke Galeri');
          submitBtn.prop('disabled', false);

          let errorMessage = 'Gagal menambahkan foto galeri.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // AJAX delete foto galeri
    $(document).on('click', '.btn-delete-gallery', function(e) {
      e.preventDefault();

      const btn = $(this);
      const id = btn.data('id');
      
      if (!confirm('Apakah Anda yakin ingin menghapus foto galeri ini dari database?')) {
        return;
      }

      btn.prop('disabled', true).text('Menghapus...');

      $.ajax({
        url: "{{ url('/portal-admin/ubah-gambar/delete-gallery') }}/" + id,
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
          $(`#gallery-item-${id}`).fadeOut(400, function() {
            $(this).remove();
            // Tampilkan pesan kosong jika semua foto terhapus
            if ($('.gallery-admin-card').length === 0) {
              $('.gallery-admin-grid').html(`
                <div style="grid-column: 1/-1; text-align: center; color: var(--light); opacity: 0.6; padding: 40px 0;">
                  Belum ada foto di Galeri Aktivitas. Silakan pilih dan tambahkan foto baru di atas.
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

          let errorMessage = 'Gagal menghapus foto galeri.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // --- LOGIKA PENGELOLAAN TABEL projects_gallery ---

    // Event listener untuk input file projects_gallery baru
    $('#projects-gallery-image-input').on('change', function() {
      const file = this.files[0];
      const submitBtn = $('#btn-upload-projects-gallery');
      const labelText = $('#projects-gallery-file-name-text');

      if (file) {
        const maxSize = 5 * 1024 * 1024; // 5 MB
        if (file.size > maxSize) {
          window.showToast('danger', 'Ukuran gambar melebihi 5 MB. Silakan pilih gambar lain.');
          this.value = '';
          labelText.text('Pilih Gambar Galeri Proyek Baru...');
          submitBtn.prop('disabled', true);
          return;
        }
        labelText.text(file.name);
        submitBtn.prop('disabled', false);
      } else {
        labelText.text('Pilih Gambar Galeri Proyek Baru...');
        submitBtn.prop('disabled', true);
      }
    });

    // AJAX submit form tambah foto projects_gallery
    $('#upload-projects-gallery-form').on('submit', function(e) {
      e.preventDefault();

      const form = $(this);
      const submitBtn = $('#btn-upload-projects-gallery');
      const spinner = $('#spinner-projects-gallery');
      const btnText = submitBtn.find('span:last-child');
      const fileInput = $('#projects-gallery-image-input')[0];
      const file = fileInput.files[0];

      if (!file) {
        window.showToast('danger', 'Mohon pilih file gambar terlebih dahulu.');
        return;
      }

      const formData = new FormData();
      formData.append('image', file);

      submitBtn.prop('disabled', true);
      spinner.show();
      btnText.text('Menyimpan...');

      $.ajax({
        url: "{{ url('/portal-admin/ubah-gambar/upload-projects-gallery') }}",
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
          btnText.text('Tambah ke Galeri Proyek');
          submitBtn.prop('disabled', true);
          fileInput.value = '';
          $('#projects-gallery-file-name-text').text('Pilih Gambar Galeri Proyek Baru...');

          window.showToast('success', response.message);
          
          // Reload halaman secara otomatis dalam 1 detik untuk menyegarkan daftar gambar
          setTimeout(function() {
            location.reload();
          }, 1000);
        },
        error: function(xhr) {
          spinner.hide();
          btnText.text('Tambah ke Galeri Proyek');
          submitBtn.prop('disabled', false);

          let errorMessage = 'Gagal menambahkan foto galeri proyek.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // AJAX delete foto projects_gallery
    $(document).on('click', '.btn-delete-projects-gallery', function(e) {
      e.preventDefault();

      const btn = $(this);
      const id = btn.data('id');
      
      if (!confirm('Apakah Anda yakin ingin menghapus foto galeri proyek ini dari database?')) {
        return;
      }

      btn.prop('disabled', true).text('Menghapus...');

      $.ajax({
        url: "{{ url('/portal-admin/ubah-gambar/delete-projects-gallery') }}/" + id,
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
          $(`#projects-gallery-item-${id}`).fadeOut(400, function() {
            $(this).remove();
            if ($('.btn-delete-projects-gallery').length === 0) {
              $('#upload-projects-gallery-form').next('.gallery-admin-grid').html(`
                <div style="grid-column: 1/-1; text-align: center; color: var(--light); opacity: 0.6; padding: 40px 0;">
                  Belum ada foto di Galeri Proyek. Silakan pilih dan tambahkan foto baru di atas.
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

          let errorMessage = 'Gagal menghapus foto galeri proyek.';
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
