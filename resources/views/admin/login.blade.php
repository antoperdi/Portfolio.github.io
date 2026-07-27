<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Portal Masuk Admin | Rakhmat Perdianto</title>

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
      overflow-x: hidden;
      position: relative;
    }

    /* Background decorative glow elements */
    .glow-1, .glow-2 {
      position: absolute;
      width: 350px;
      height: 350px;
      border-radius: 50%;
      background: var(--secondary);
      filter: blur(130px);
      opacity: 0.25;
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

    .login-container {
      width: 100%;
      max-width: 440px;
      z-index: 10;
      position: relative;
    }

    /* Card styling with premium glassmorphism */
    .login-card {
      background: var(--card-bg);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 16px;
      padding: 40px 35px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }

    .login-header {
      text-align: center;
      margin-bottom: 35px;
    }

    .login-header h2 {
      font-size: 2rem;
      font-weight: 700;
      color: var(--white);
      margin-bottom: 10px;
      letter-spacing: -0.5px;
    }

    .login-header h2 span {
      color: var(--accent);
    }

    .login-header p {
      color: var(--light);
      font-size: 0.95rem;
      opacity: 0.8;
    }

    .form-group {
      margin-bottom: 22px;
      position: relative;
    }

    .form-group label {
      display: block;
      font-size: 0.9rem;
      font-weight: 500;
      color: var(--light);
      margin-bottom: 8px;
    }

    /* Customized styled inputs */
    .form-control {
      width: 100%;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 10px;
      padding: 12px 16px;
      font-family: var(--font-main);
      font-size: 1rem;
      color: var(--white);
      outline: none;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      background: rgba(255, 255, 255, 0.08);
      border-color: var(--secondary);
      box-shadow: 0 0 12px rgba(66, 116, 217, 0.4);
    }

    /* Alert styles with premium feel */
    .alert {
      padding: 12px 16px;
      border-radius: 10px;
      font-size: 0.9rem;
      margin-bottom: 22px;
      display: none;
      align-items: center;
      gap: 10px;
      line-height: 1.4;
      animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
      from {
        transform: translateY(-10px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .alert-danger {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.3);
      color: #fca5a5;
    }

    .alert-success {
      background: rgba(34, 197, 94, 0.15);
      border: 1px solid rgba(34, 197, 94, 0.3);
      color: #86efac;
    }

    .btn-submit {
      width: 100%;
      background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
      border: none;
      border-radius: 10px;
      padding: 14px;
      font-family: var(--font-main);
      font-size: 1rem;
      font-weight: 600;
      color: var(--white);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(66, 116, 217, 0.3);
      margin-top: 10px;
    }

    .btn-submit:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(66, 116, 217, 0.45);
      filter: brightness(1.1);
    }

    .btn-submit:active:not(:disabled) {
      transform: translateY(0);
    }

    .btn-submit:disabled {
      opacity: 0.65;
      cursor: not-allowed;
    }

    .back-home {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--light);
      text-decoration: none;
      font-size: 0.88rem;
      margin-top: 25px;
      opacity: 0.7;
      transition: opacity 0.3s ease, color 0.3s ease;
      width: 100%;
      justify-content: center;
    }

    .back-home:hover {
      opacity: 1;
      color: var(--accent);
    }

    /* Loader Spinner */
    .spinner {
      width: 18px;
      height: 18px;
      border: 2.5px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: var(--white);
      animation: spin 0.8s linear infinite;
      display: none;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    /* Footer styling */
    .login-footer {
      text-align: center;
      margin-top: 25px;
      font-size: 0.8rem;
      color: var(--light);
      opacity: 0.5;
    }
  </style>
</head>

<body>
  <div class="glow-1"></div>
  <div class="glow-2"></div>

  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <h2>Rakhmat<span>.Sam</span></h2>
        <p>Silakan masuk ke panel admin</p>
      </div>

      <!-- Alert Notifikasi -->
      <div id="alert-box" class="alert">
        <span id="alert-message"></span>
      </div>

      <!-- Form Login -->
      <form id="login-form">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" class="form-control" placeholder="Masukkan username admin..." required autocomplete="username" autofocus>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" class="form-control" placeholder="Masukkan password..." required autocomplete="current-password">
        </div>

        <button type="submit" id="btn-submit" class="btn-submit">
          <span class="spinner" id="btn-spinner"></span>
          <span id="btn-text">Masuk Sekarang</span>
        </button>
      </form>

      <a href="{{ url('/') }}" class="back-home">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"></line>
          <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Beranda
      </a>
    </div>

    <div class="login-footer">
      &copy; 2026 Rakhmat.Sam &bull; Secure Backend Portal
    </div>
  </div>

  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <script>
    $(document).ready(function() {
      // Dapatkan CSRF Token dari Meta Tag
      const csrfToken = $('meta[name="csrf-token"]').attr('content');

      // Interaksi Form Login menggunakan AJAX (Sesuai Aturan 5)
      $('#login-form').on('submit', function(e) {
        e.preventDefault();

        const username = $('#username').val().trim();
        const password = $('#password').val();

        // Validasi client-side sederhana
        if (!username || !password) {
          showAlert('danger', 'Mohon isi username dan password dengan benar.');
          return;
        }

        // Tampilkan State Loading
        setLoading(true);
        hideAlert();

        // AJAX Request ke Endpoint Autentikasi
        $.ajax({
          url: "{{ url('/portal-admin/login') }}",
          type: "POST",
          data: {
            username: username,
            password: password
          },
          headers: {
            'X-CSRF-TOKEN': csrfToken
          },
          dataType: "json",
          success: function(response) {
            // Tampilkan Pesan Sukses
            showAlert('success', response.message);
            
            // Redirect ke dashboard setelah jeda 1.2 detik agar animasi selesai
            setTimeout(function() {
              window.location.href = response.redirect;
            }, 1200);
          },
          error: function(xhr) {
            setLoading(false);
            let errorMessage = 'Gagal memproses permintaan login.';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
              errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 429) {
              errorMessage = 'Terlalu banyak percobaan masuk. Silakan tunggu 1 menit.';
            }

            showAlert('danger', errorMessage);
          }
        });
      });

      // Fungsi untuk Menampilkan Alert
      function showAlert(type, message) {
        const alertBox = $('#alert-box');
        alertBox.removeClass('alert-danger alert-success');
        
        if (type === 'danger') {
          alertBox.addClass('alert-danger');
        } else {
          alertBox.addClass('alert-success');
        }

        $('#alert-message').text(message);
        alertBox.css('display', 'flex');
      }

      // Fungsi untuk Menyembunyikan Alert
      function hideAlert() {
        $('#alert-box').hide();
      }

      // Fungsi untuk Mengatur Status Tombol Loading
      function setLoading(isLoading) {
        const btnSubmit = $('#btn-submit');
        const btnSpinner = $('#btn-spinner');
        const btnText = $('#btn-text');

        if (isLoading) {
          btnSubmit.prop('disabled', true);
          btnSpinner.show();
          btnText.text('Memverifikasi...');
        } else {
          btnSubmit.prop('disabled', false);
          btnSpinner.hide();
          btnText.text('Masuk Sekarang');
        }
      }
    });
  </script>
</body>

</html>
