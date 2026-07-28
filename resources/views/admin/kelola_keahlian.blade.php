<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
@extends('admin.layout')

@section('title', 'Kelola Keahlian')
@section('header_title', 'Kelola Keahlian Saya')
@section('header_subtitle', 'Melihat daftar keahlian (skills) yang aktif ditampilkan di halaman portfolio utama')

@section('styles')
<style>
  /* Styling Tabel Premium dan Responsif */
  .table-container {
    width: 100%;
    overflow-x: auto; /* Rule 6: Pengaman agar tabel tidak terpotong pada layar kecil */
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    box-shadow: var(--box-shadow);
    margin-top: 20px;
  }

  .skills-admin-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    color: var(--white);
  }

  .skills-admin-table th,
  .skills-admin-table td {
    padding: 18px 24px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    font-size: 0.95rem;
  }

  .skills-admin-table th {
    background: rgba(255, 255, 255, 0.02);
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 1px;
    color: var(--accent);
  }

  .skills-admin-table tbody tr:hover {
    background: rgba(255, 255, 255, 0.02);
  }

  .skills-admin-table tr:last-child td {
    border-bottom: none;
  }

  .badge-category {
    background: rgba(66, 116, 217, 0.15);
    border: 1px solid rgba(66, 116, 217, 0.3);
    color: var(--secondary);
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
  }

  /* Progress bar kustom mini */
  .level-progress-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 150px;
  }

  .level-percentage {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--light);
    min-width: 35px;
    text-align: right;
  }

  .level-bar-bg {
    flex: 1;
    height: 8px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    overflow: hidden;
  }

  .level-bar-fill {
    height: 100%;
    background: linear-gradient(to right, var(--secondary), var(--accent));
    border-radius: 4px;
  }

  .empty-state {
    text-align: center;
    padding: 40px;
    color: var(--light);
    opacity: 0.7;
    font-style: italic;
  }

  /* Style kustom tombol Tambah Keahlian (seragam dengan .btn-upload) */
  .btn-add-skill-theme {
    background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
    border: none;
    border-radius: 12px;
    padding: 10px 20px;
    font-family: var(--font-main);
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--white);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(66, 116, 217, 0.2);
    transition: all 0.3s ease;
  }

  .btn-add-skill-theme:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(66, 116, 217, 0.4);
    filter: brightness(1.1);
  }

  /* Style tombol Edit di dalam tabel (seragam dengan kelola_proyek) */
  .btn-edit-skill {
    padding: 8px 12px;
    font-size: 0.8rem;
    background: rgba(66, 116, 217, 0.15);
    border: 1px solid rgba(66, 116, 217, 0.25);
    color: #93c5fd;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s;
    height: auto;
    font-family: var(--font-main);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    box-shadow: none;
  }

  .btn-edit-skill:hover {
    background: var(--secondary) !important;
    color: var(--white) !important;
    box-shadow: 0 4px 12px rgba(66, 116, 217, 0.3) !important;
  }

  /* Style tombol Hapus di dalam tabel (seragam dengan kelola_proyek) */
  .btn-delete-skill {
    padding: 8px 12px;
    font-size: 0.8rem;
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.25);
    color: #fca5a5;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s;
    height: auto;
    font-family: var(--font-main);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
  }

  .btn-delete-skill:hover {
    background: #ef4444 !important;
    color: var(--white) !important;
    border-color: #ef4444 !important;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
  }

  /* Style tombol Batal di modal form (seragam dengan kelola_proyek) */
  .btn-cancel-skill {
    padding: 10px 20px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: var(--light);
    border-radius: 8px;
    cursor: pointer;
    font-family: var(--font-main);
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.3s;
  }

  .btn-cancel-skill:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--white);
  }

  /* Style tombol Simpan di modal form (seragam dengan kelola_proyek) */
  .btn-submit-skill-theme {
    padding: 10px 20px;
    background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
    border: none;
    border-radius: 8px;
    color: var(--white);
    font-family: var(--font-main);
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(66, 116, 217, 0.2);
  }

  .btn-submit-skill-theme:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(66, 116, 217, 0.4);
    filter: brightness(1.1);
  }

  /* Modal styling */
  .modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 21, 58, 0.85);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .modal-overlay.open {
    display: flex;
    opacity: 1;
  }

  .modal-content-card {
    width: 100%;
    max-width: 450px;
    background: var(--dark-blue);
    border: 1px solid var(--card-border);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    transform: scale(0.9);
    transition: transform 0.3s ease;
  }

  .modal-overlay.open .modal-content-card {
    transform: scale(1);
  }
</style>
@endsection

@section('content')
<div class="panel-card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
    <div>
      <h3 style="font-size: 1.3rem; font-weight: 600; color: var(--accent); margin-bottom: 5px;">Daftar Keahlian Saya</h3>
      <p style="font-size: 0.85rem; color: var(--light); opacity: 0.7;">Berikut adalah daftar keahlian yang bersumber langsung dari tabel database <strong>skills</strong>.</p>
    </div>
    
    <!-- Tombol Tambah Keahlian -->
    <button type="button" class="btn-add-skill-theme" id="btn-add-skill">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
      </svg>
      <span>Tambah Keahlian</span>
    </button>
  </div>

  <!-- Kontainer Tabel dengan Overflow Guard (Rule 6 & 8) -->
  <div class="table-container">
    <table class="skills-admin-table">
      <thead>
        <tr>
          <th style="width: 80px;">No</th>
          <th>Nama Keahlian</th>
          <th>Kategori</th>
          <th>Tingkat Penguasaan</th>
          <th style="width: 200px; text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($skills as $index => $skill)
        <tr>
          <!-- Escaping keluaran di View (Rule 14 & 19) -->
          <td style="font-weight: 600; color: var(--light);">{{ $index + 1 }}</td>
          <td style="font-weight: 500;">{{ html_escape($skill->name) }}</td>
          <td>
            <span class="badge-category">{{ html_escape($skill->category) }}</span>
          </td>
          <td>
            <div class="level-progress-wrapper">
              <div class="level-bar-bg">
                <div class="level-bar-fill" style="width: {{ intval($skill->percentage) }}%;"></div>
              </div>
              <span class="level-percentage">{{ html_escape($skill->percentage) }}%</span>
            </div>
          </td>
          <td style="text-align: center;">
            <div style="display: flex; gap: 10px; justify-content: center;">
              <button type="button" class="btn-edit-skill" data-id="{{ $skill->id }}" data-name="{{ $skill->name }}" data-category="{{ $skill->category }}" data-percentage="{{ $skill->percentage }}">
                Edit
              </button>
              <button type="button" class="btn-delete-skill" data-id="{{ $skill->id }}">
                Hapus
              </button>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="empty-state">
            Belum ada data keahlian yang terdaftar di database.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Dialog Form Keahlian (Rule 5 & 6) -->
<div id="skill-modal" class="modal-overlay">
  <div class="modal-content-card">
    <h3 id="modal-title" style="font-size: 1.25rem; font-weight: 600; color: var(--accent); margin-bottom: 20px;">Tambah Keahlian Baru</h3>
    
    <form id="skill-form">
      <input type="hidden" id="skill-id" name="id">
      
      <div style="margin-bottom: 20px;">
        <label for="skill-name" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 8px; font-weight: 500;">Nama Keahlian</label>
        <input type="text" id="skill-name" required placeholder="Contoh: Laravel, React, UI Design" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; outline: none;">
      </div>

      <div style="margin-bottom: 20px;">
        <label for="skill-category" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 8px; font-weight: 500;">Kategori</label>
        <select id="skill-category" required style="width: 100%; padding: 12px; background: #12183a; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; cursor: pointer; outline: none;">
          <option value="">-- Pilih Kategori --</option>
          <option value="Programming & Design">Programming & Design</option>
          <option value="Framework & Database">Framework & Database</option>
          <option value="Tools & OS">Tools & OS</option>
          <option value="Lainnya">Lainnya</option>
        </select>
        <!-- Kolom input kustom jika memilih Kategori Lainnya -->
        <input type="text" id="skill-category-custom" placeholder="Tulis kategori baru..." style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: var(--white); font-family: var(--font-main); font-size: 0.9rem; margin-top: 10px; display: none; outline: none;">
      </div>

      <div style="margin-bottom: 25px;">
        <label for="skill-percentage" style="display: block; font-size: 0.85rem; color: var(--light); margin-bottom: 8px; font-weight: 500;">
          Tingkat Penguasaan: <strong id="percentage-label">85%</strong>
        </label>
        <div style="display: flex; align-items: center; gap: 15px;">
          <input type="range" id="skill-percentage" min="0" max="100" step="5" value="85" style="flex: 1; accent-color: var(--accent); cursor: pointer; height: 6px; border-radius: 3px; background: rgba(255,255,255,0.15);">
          <span id="percentage-num" style="font-size: 0.9rem; color: var(--light); min-width: 35px; text-align: right; font-weight: 600;">85%</span>
        </div>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 12px;">
        <button type="button" id="btn-close-modal" class="btn-cancel-skill">
          Batal
        </button>
        <button type="submit" id="btn-submit-skill" class="btn-submit-skill-theme">
          <span class="spinner-upload" id="spinner-submit" style="width: 14px; height: 14px; margin-right: 5px;"></span>
          <span id="submit-text">Simpan</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Tampilkan input kustom jika memilih "Lainnya"
    $('#skill-category').on('change', function() {
      if ($(this).val() === 'Lainnya') {
        $('#skill-category-custom').show().prop('required', true);
      } else {
        $('#skill-category-custom').hide().prop('required', false).val('');
      }
    });

    // Menutup modal form
    function closeModal() {
      const modal = $('#skill-modal');
      modal.removeClass('open');
      setTimeout(function() {
        modal.hide();
      }, 300);
    }

    // Membuka modal form
    function openModal() {
      const modal = $('#skill-modal');
      modal.show();
      setTimeout(function() {
        modal.addClass('open');
      }, 50);
    }

    // Event Buka Modal Tambah Keahlian
    $('#btn-add-skill').on('click', function() {
      $('#modal-title').text('Tambah Keahlian Baru');
      $('#skill-id').val('');
      $('#skill-name').val('');
      $('#skill-category').val('').trigger('change');
      $('#skill-category-custom').val('');
      $('#skill-percentage').val(85).trigger('input');
      $('#submit-text').text('Simpan');
      openModal();
    });

    // Event Buka Modal Edit Keahlian
    $('.btn-edit-skill').on('click', function() {
      const id = $(this).data('id');
      const name = $(this).data('name');
      const category = $(this).data('category');
      const percentage = $(this).data('percentage');

      $('#modal-title').text('Sunting Keahlian');
      $('#skill-id').val(id);
      $('#skill-name').val(name);

      // Sinkronisasi Kategori Dropdown / Kustom
      const hasOption = $('#skill-category option[value="' + category + '"]').length > 0;
      if (hasOption) {
        $('#skill-category').val(category).trigger('change');
      } else {
        $('#skill-category').val('Lainnya').trigger('change');
        $('#skill-category-custom').val(category);
      }

      $('#skill-percentage').val(percentage).trigger('input');
      $('#submit-text').text('Simpan Perubahan');
      openModal();
    });

    // Event Tutup Modal via Tombol Batal
    $('#btn-close-modal').on('click', function() {
      closeModal();
    });

    // Event Tutup Modal via Klik Latar Belakang Overlay
    $('#skill-modal').on('click', function(e) {
      if (e.target === this) {
        closeModal();
      }
    });

    // Update Angka Slider range real-time
    $('#skill-percentage').on('input', function() {
      const val = $(this).val();
      $('#percentage-label').text(val + '%');
      $('#percentage-num').text(val + '%');
    });

    // Submit Form AJAX Simpan Keahlian (Rule 5)
    $('#skill-form').on('submit', function(e) {
      e.preventDefault();

      const id = $('#skill-id').val();
      const name = $('#skill-name').val();
      let category = $('#skill-category').val();
      if (category === 'Lainnya') {
        category = $('#skill-category-custom').val();
      }
      const percentage = $('#skill-percentage').val();

      const btn = $('#btn-submit-skill');
      const spinner = $('#spinner-submit');
      const btnText = $('#submit-text');

      btn.prop('disabled', true);
      spinner.css('display', 'inline-block');
      btnText.text('Menyimpan...');

      $.ajax({
        url: "{{ url('/portal-admin/kelola-keahlian/simpan') }}",
        type: "POST",
        data: {
          id: id,
          name: name,
          category: category,
          percentage: percentage,
          _token: csrfToken
        },
        dataType: "json",
        success: function(response) {
          spinner.hide();
          btn.prop('disabled', false);
          closeModal();
          window.showToast('success', response.message);

          // Reload halaman asinkron dengan jeda 1 detik agar toast terbaca
          setTimeout(function() {
            location.reload();
          }, 1000);
        },
        error: function(xhr) {
          spinner.hide();
          btn.prop('disabled', false);
          btnText.text(id ? 'Simpan Perubahan' : 'Simpan');

          let errorMessage = 'Gagal menyimpan data keahlian.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
          }
          window.showToast('danger', errorMessage);
        }
      });
    });

    // Event AJAX Delete Keahlian (Rule 5 & 15)
    $('.btn-delete-skill').on('click', function() {
      const id = $(this).data('id');

      if (!confirm('Apakah Anda yakin ingin menghapus keahlian ini secara permanen?')) {
        return;
      }

      const btn = $(this);
      btn.prop('disabled', true).text('...');

      $.ajax({
        url: "{{ url('/portal-admin/kelola-keahlian/delete') }}/" + id,
        type: "DELETE",
        data: {
          _token: csrfToken
        },
        dataType: "json",
        success: function(response) {
          window.showToast('success', response.message);

          // Hapus baris tabel secara visual dengan efek transisi smooth
          btn.closest('tr').fadeOut(400, function() {
            $(this).remove();
            
            // Jika tabel kosong, tampilkan baris kosong bawaan
            if ($('.skills-admin-table tbody tr').length === 0) {
              $('.skills-admin-table tbody').append(
                '<tr><td colspan="5" class="empty-state">Belum ada data keahlian yang terdaftar di database.</td></tr>'
              );
            }
          });
        },
        error: function(xhr) {
          btn.prop('disabled', false).text('Hapus');
          let errorMessage = 'Gagal menghapus data keahlian.';
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