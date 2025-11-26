<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | APCoS-JMTM</title>

    <!-- Favicons -->
    <link href="<?php echo base_url(); ?>/assets/Landing-home/img/jm1.png" rel="icon">
    <link href="<?php echo base_url(); ?>/assets/Landing-home/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Bootstrap 5 CSS -->
    <link href="<?php echo base_url(); ?>assets/admin_kintek_slash/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="<?php echo base_url(); ?>assets/admin_kintek_slash/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/fontawesome-free/css/all.min.css" rel="stylesheet">

    <!-- Login Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/admin_kintek_slash/css/login_temp.css" rel="stylesheet">

    <!-- Cloudflare Turnstile -->
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

</head>

<body>

    <div class="container-fluid split-container">
        <div class="row h-100">

            <!-- LEFT SIDE -->
            <div class="col-lg-7 left-pane">
                <div class="left-bg"></div>
                <canvas id="ripple-canvas"></canvas>
                <div class="left-overlay"></div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-5 right-pane">
                <div class="login-box">

                    <!-- Logo -->
                    <div class="login-logo text-center mb-3">
                        <img src="<?php echo base_url(); ?>assets/brand/JMTMLOGOKU.png" alt="Logo"
                            class="img-fluid logo-img">
                    </div>

                    <br>

                    <!-- ============= FORM LOGIN ============= -->
                    <form id="loginForm">

                        <!-- NIP -->
                        <div class="mb-3 form-floating-icon">
                            <i class="bi bi-person-badge input-icon"></i>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nip" placeholder=" ">
                                <label for="nip">NIP</label>
                            </div>
                        </div>

                        <!-- USERNAME -->
                        <div class="mb-3 form-floating-icon">
                            <i class="bi bi-person-fill-lock input-icon"></i>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="username" placeholder=" ">
                                <label for="username">User Name</label>
                            </div>
                        </div>

                        <!-- BUTTON PROSES OTP -->
                        <button type="button" class="btn btn-login w-100" id="btnProsesOTP">
                            <i class="fa-solid fa-lock-open fa-xl px-1"></i>
                            Proses OTP
                        </button>
                    </form>

                    <!-- ============= FORM OTP ============= -->
                    <div id="otpForm" class="mt-4" style="display: none;">

                        <!-- OTP INPUT -->
                        <div class="mb-3 form-floating-icon">
                            <i class="bi bi-shield-lock input-icon"></i>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="otp_code" placeholder=" ">
                                <label for="otp_code">Masukkan Kode OTP</label>
                            </div>
                        </div>

                        <!-- TURNSTILE CAPTCHA -->
                        <div class="cf-turnstile mt-3" data-sitekey="0x4AAAAAAxxxxxxxxxxxxxxxxxxxxxxxx"
                            data-theme="light">
                        </div>

                        <!-- BUTTON VERIFIKASI -->
                        <button class="btn btn-success w-100" id="btnVerifyOTP">
                            <i class="fa-solid fa-circle-check px-1"></i>
                            Verifikasi OTP
                        </button>

                        <!-- BUTTON KEMBALI -->
                        <button class="btn btn-outline-secondary w-100 mt-3" id="btnKembali">
                            <i class="fa-solid fa-arrow-left px-1"></i>
                            Kembali ke Login
                        </button>

                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- JS -->
    <script src="<?php echo base_url(); ?>assets/admin_kintek_slash/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin_kintek_slash/js/login_temp.js"></script>

    <!-- SCRIPT LOGIN + OTP -->
    <script>
    const loginForm = document.getElementById("loginForm");
    const otpForm = document.getElementById("otpForm");

    // Klik Proses OTP → Tampilkan form OTP
    document.getElementById("btnProsesOTP").addEventListener("click", function() {
        loginForm.style.display = "none";
        otpForm.style.display = "block";
    });

    // Klik Kembali → Tampilkan form Login
    document.getElementById("btnKembali").addEventListener("click", function() {
        otpForm.style.display = "none";
        loginForm.style.display = "block";
    });

    // Verifikasi OTP + CAPTCHA
    document.getElementById("btnVerifyOTP").addEventListener("click", function() {

        let otp = document.getElementById("otp_code").value;
        let turnstileToken = turnstile.getResponse();

        if (otp === "") {
            alert("OTP wajib diisi!");
            return;
        }

        // if (!turnstileToken) {
        //     alert("Silakan centang verifikasi Not Robot (Cloudflare).");
        //     return;
        // }

        // Jika lolos OTP + CAPTCHA
        window.location.href = "<?php echo base_url(); ?>administrator/dashboard/ctrl_dashboard";
    });
    </script>

</body>

</html>