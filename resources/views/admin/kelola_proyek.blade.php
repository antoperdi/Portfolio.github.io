@extends('admin.layout')

@section('title', 'Kelola Project Saya')
@section('header_title', 'Kelola Project Saya')
@section('header_subtitle', 'Kelola daftar proyek portofolio Anda langsung dari server database')

@section('styles')
<style>
  /* Form styling matching the website style */
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

  .gallery-admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
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
    height: 150px;
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
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    justify-content: space-between;
    flex: 1;
  }

  .gallery-admin-name {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--white);
    text-align: left;
  }

  .btn-delete-project {
    padding: 8px 12px;
    font-size: 0.8rem;
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.25);
    color: #fca5a5;
    width: 50%;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s;
    height: auto;
    font-family: var(--font-main);
  }

  .btn-delete-project:hover {
    background: #ef4444;
    color: var(--white);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
  }
</style>
@endsection

@section('content')
<!-- Bagian Panel Pengelolaan Project Saya (Project_Saya) -->
<div class="panel-card">
  <h3 id="form-project-title" style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px; color: var(--accent);">Kelola Project Saya (Project_Saya)</h3>
  <p style="font-size: 0.85rem; color: var(--light); opacity: 0.7; margin-bottom: 25px; line-height: 1.4;">
    Kelola daftar proyek Anda yang tampil di beranda depan dan halaman detail proyek. Gambar proyek akan disimpan ke penyimpanan lokal (disk storage) dan datanya dicatat ke tabel <code>Project_Saya</code>.
  </p>

  <!-- Form Unggah / Edit Proyek Baru -->
  <form id="project-form" style="width: 100%; max-width: 800px; margin: 0 auto 35px auto; text-align: left;">
    <input type="hidden" id="project-id" name="id">
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 15px;">
      <div>
        <label for="project-nama" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Nama Proyek <span style="color: var(--accent);">*</span></label>
        <input type="text" id="project-nama" name="nama" required placeholder="Masukkan nama proyek..." style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
      </div>
      <div>
        <label for="project-kategori" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Kategori <span style="color: var(--accent);">*</span></label>
        <select id="project-kategori" name="Kategori" required style="width: 100%; padding: 12px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
          <option value="web">Aplikasi Web</option>
          <option value="design">Desain UI/UX</option>
        </select>
      </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 15px;">
      <div>
        <label for="project-tanggal" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Tanggal/Periode Proyek <span style="color: var(--accent);">*</span></label>
        <input type="text" id="project-tanggal" name="Tanggal_Proyek" required placeholder="Contoh: Maret - Mei 2026" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
      </div>
      <div>
        <label for="project-role" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Peran Saya <span style="color: var(--accent);">*</span></label>
        <input type="text" id="project-role" name="Role" required placeholder="Contoh: Full Stack Developer" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
      </div>
      <div>
        <label for="project-teknologi" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Teknologi <span style="color: var(--accent);">*</span></label>
        <input type="text" id="project-teknologi" name="Teknologi" required placeholder="Pisahkan dengan koma: Laravel, MySQL, JS" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
      </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 15px;">
      <div>
        <label for="project-demo" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Live Demo URL (Opsional)</label>
        <input type="url" id="project-demo" name="url_demo" placeholder="https://example.com" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
      </div>
      <div>
        <label for="project-code" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Source Code URL / Link Tujuan <span style="color: var(--accent);">*</span></label>
        <input type="url" id="project-code" name="url_code" required placeholder="https://github.com/user/repo" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
      </div>
    </div>

    <div style="margin-bottom: 15px;">
      <label for="project-caption" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Deskripsi Singkat Proyek <span style="color: var(--accent);">*</span></label>
      <textarea id="project-caption" name="caption" required placeholder="Masukkan penjelasan singkat tentang proyek ini..." style="width: 100%; height: 60px; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; resize: vertical; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'"></textarea>
    </div>

    <div style="margin-bottom: 15px;">
      <label for="project-story" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Cerita Pengerjaan Proyek <span style="color: var(--accent);">*</span></label>
      <textarea id="project-story" name="Work_Story" required placeholder="Masukkan cerita bagaimana proyek ini dikerjakan, tantangan, dan penyelesaiannya..." style="width: 100%; height: 100px; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; resize: vertical; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'"></textarea>
    </div>

    <div style="margin-bottom: 15px;">
      <label for="project-features" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 6px; font-weight: 500;">Fitur Utama <span style="color: var(--accent);">*</span></label>
      <textarea id="project-features" name="Main_Features" required placeholder="Tuliskan fitur utama per baris (tekan Enter untuk membuat poin fitur baru)..." style="width: 100%; height: 100px; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none; resize: vertical; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--secondary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'"></textarea>
    </div>

    <div class="file-input-wrapper">
      <input type="file" class="file-input-hidden" id="project-image-input" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" required>
      <div class="file-input-label" id="project-file-label">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
          <polyline points="17 8 12 3 7 8"></polyline>
          <line x1="12" y1="3" x2="12" y2="15"></line>
        </svg>
        <span id="project-file-name-text">Pilih Gambar Sampul Proyek...</span>
      </div>
    </div>
    
    <div style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
      <button type="submit" class="btn-upload" id="btn-submit-project" disabled style="max-width: 250px;">
        <span class="spinner-upload" id="spinner-project"></span>
        <span>Tambah Proyek Baru</span>
      </button>
      <button type="button" id="btn-cancel-project" class="btn-delete-project" style="display: none; max-width: 150px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); color: var(--light); margin: 0; border-radius: 8px;">
        Batal Edit
      </button>
    </div>
  </form>

  <!-- Grid/Tabel Proyek yang Terdaftar -->
  <h4 style="font-size: 1.1rem; font-weight: 600; margin-top: 40px; margin-bottom: 20px; color: var(--white); text-align: left;">Daftar Proyek Aktif</h4>
  <div class="gallery-admin-grid">
    @forelse($projects as $item)
      <div class="gallery-admin-card" id="project-item-{{ $item->id }}">
        <div class="gallery-admin-img-wrapper">
          @php
            $isFallback = in_array($item->image_path, ['readme_banner.png', 'IMG_20260226_045149_015.webp', 'halaman login.png']);
            $imageSrc = $isFallback ? asset('foto_pribadi/' . $item->image_path) : asset('storage/' . $item->image_path);
          @endphp
          <img src="{{ $imageSrc }}" alt="{{ html_escape($item->nama) }}">
        </div>
        <div class="gallery-admin-info">
          <div style="text-align: left;">
            <div class="gallery-admin-name" style="font-size: 0.95rem; font-weight: 600; white-space: normal; overflow: visible; text-overflow: clip; height: auto;" title="{{ html_escape($item->nama) }}">{{ html_escape($item->nama) }}</div>
            <div style="font-size: 0.8rem; color: var(--accent); margin-top: 4px; margin-bottom: 6px;">Kategori: {{ html_escape($item->Kategori === 'web' ? 'Aplikasi Web' : 'Desain UI/UX') }}</div>
            <p style="font-size: 0.75rem; color: var(--light); opacity: 0.7; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 32px; line-height: 1.3; margin: 0;">{{ html_escape($item->caption) }}</p>
          </div>
          
          <div style="display: flex; gap: 8px; margin-top: 10px; width: 100%;">
            <button type="button" class="btn-edit-project btn-upload" data-id="{{ $item->id }}" data-json="{{ json_encode($item) }}" style="padding: 8px 12px; font-size: 0.8rem; background: rgba(66, 116, 217, 0.15); border: 1px solid rgba(66, 116, 217, 0.25); color: #93c5fd; width: 50%; box-shadow: none; height: auto; border-radius: 8px;">
              Edit
            </button>
            <button type="button" class="btn-delete-project" data-id="{{ $item->id }}">
              Hapus
            </button>
          </div>
        </div>
      </div>
    @empty
      <div style="grid-column: 1/-1; text-align: center; color: var(--light); opacity: 0.6; padding: 40px 0;">
        Belum ada proyek terdaftar. Silakan gunakan form di atas untuk menambahkan proyek baru.
      </div>
    @endforelse
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Mengubah form menjadi edit mode
    $(document).on('click', '.btn-edit-project', function() {
      const btn = $(this);
      const data = btn.data('json');

      $('#project-id').val(data.id);
      $('#project-nama').val(data.nama);
      $('#project-kategori').val(data.Kategori);
      $('#project-tanggal').val(data.Tanggal_Proyek);
      $('#project-role').val(data.Role);
      $('#project-teknologi').val(data.Teknologi);
      $('#project-demo').val(data.url_demo);
      $('#project-code').val(data.url_code);
      $('#project-caption').val(data.caption);
      $('#project-story').val(data.Work_Story);
      $('#project-features').val(data.Main_Features);

      // Gambar tidak wajib diunggah ketika edit
      $('#project-image-input').prop('required', false);
      $('#project-file-name-text').text('Pilih Gambar Sampul Baru (Opsional)...');

      // Teks tombol & UI edit mode
      $('#form-project-title').text('Edit Proyek: ' + data.nama);
      $('#btn-submit-project span:last-child').text('Simpan Perubahan Proyek');
      $('#btn-submit-project').prop('disabled', false);
      $('#btn-cancel-project').show();

      // Scroll halus ke form
      $('html, body').animate({
        scrollTop: $("#project-form").offset().top - 100
      }, 500);
    });

    // Batalkan edit mode
    $('#btn-cancel-project').on('click', function() {
      $('#project-form')[0].reset();
      $('#project-id').val('');
      $('#project-image-input').prop('required', true);
      $('#project-file-name-text').text('Pilih Gambar Sampul Proyek...');

      $('#form-project-title').text('Kelola Project Saya (Project_Saya)');
      $('#btn-submit-project span:last-child').text('Tambah Proyek Baru');
      $('#btn-submit-project').prop('disabled', true);
      $(this).hide();
    });

    // Menangani perubahan input file proyek
    $('#project-image-input').on('change', function() {
      const file = this.files[0];
      const submitBtn = $('#btn-submit-project');
      const labelText = $('#project-file-name-text');

      if (file) {
        const maxSize = 5 * 1024 * 1024; // 5 MB
        if (file.size > maxSize) {
          window.showToast('danger', 'Ukuran gambar melebihi 5 MB. Silakan pilih gambar lain.');
          this.value = '';
          labelText.text('Pilih Gambar Sampul Proyek...');
          if (!$('#project-id').val()) {
            submitBtn.prop('disabled', true);
          }
          return;
        }
        labelText.text(file.name);
        submitBtn.prop('disabled', false);
      } else {
        if (!$('#project-id').val()) {
          labelText.text('Pilih Gambar Sampul Proyek...');
          submitBtn.prop('disabled', true);
        }
      }
    });

    // Mengaktifkan submit button jika fields lain berubah (ketika edit)
    $('#project-form input, #project-form textarea, #project-form select').on('input change', function() {
      if ($('#project-id').val() || $('#project-image-input')[0].files[0]) {
        $('#btn-submit-project').prop('disabled', false);
      }
    });

    // AJAX submit form tambah/edit proyek
    $('#project-form').on('submit', function(e) {
      e.preventDefault();

      const form = $(this);
      const submitBtn = $('#btn-submit-project');
      const spinner = $('#spinner-project');
      const btnText = submitBtn.find('span:last-child');
      const fileInput = $('#project-image-input')[0];
      const file = fileInput.files[0];

      const formData = new FormData(this);

      submitBtn.prop('disabled', true);
      spinner.show();
      btnText.text('Menyimpan...');

      $.ajax({
        url: "{{ url('/portal-admin/kelola-proyek/upload') }}",
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
          btnText.text($('#project-id').val() ? 'Simpan Perubahan Proyek' : 'Tambah Proyek Baru');
          submitBtn.prop('disabled', false);

          window.showToast('success', response.message);
          
          // Reload halaman secara otomatis dalam 1 detik untuk menyegarkan daftar proyek
          setTimeout(function() {
            location.reload();
          }, 1000);
        },
        error: function(xhr) {
          spinner.hide();
          btnText.text($('#project-id').val() ? 'Simpan Perubahan Proyek' : 'Tambah Proyek Baru');
          submitBtn.prop('disabled', false);

          let errorMessage = 'Gagal menyimpan data proyek.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // AJAX delete proyek
    $(document).on('click', '.btn-delete-project', function(e) {
      e.preventDefault();

      const btn = $(this);
      const id = btn.data('id');
      
      if (!confirm('Apakah Anda yakin ingin menghapus proyek ini secara permanen dari database dan penyimpanan?')) {
        return;
      }

      btn.prop('disabled', true).text('Menghapus...');

      $.ajax({
        url: "{{ url('/portal-admin/kelola-proyek/delete') }}/" + id,
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
          // Hapus kartu proyek dari DOM secara visual dengan efek fadeOut
          $(`#project-item-${id}`).fadeOut(400, function() {
            $(this).remove();
            if ($('.btn-delete-project').length === 0) {
              $('.gallery-admin-grid').html(`
                <div style="grid-column: 1/-1; text-align: center; color: var(--light); opacity: 0.6; padding: 40px 0;">
                  Belum ada proyek terdaftar. Silakan gunakan form di atas untuk menambahkan proyek baru.
                </div>
              `);
            }
          });
        },
        error: function(xhr) {
          btn.prop('disabled', false).text('Hapus');

          let errorMessage = 'Gagal menghapus proyek.';
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
