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
    <link href="http://localhost:8888/new-pcs-jmtm/assets/admin_kintek_slash/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="http://localhost:8888/new-pcs-jmtm/assets/admin_kintek_slash/font/bootstrap-icons.css" rel="stylesheet">
    <link href="http://localhost:8888/new-pcs-jmtm/assets/admin_kintek_slash/css/login_temp.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="http://localhost:8888/new-pcs-jmtm/assets/fontawesome-free/css/all.min.css">

</head>

<body>

    <div class="container-fluid split-container">
        <div class="row h-100">

            <!-- LEFT SIDE (Image + Lottie) -->
            <div class="col-lg-7 left-pane">
                <div class="left-bg"></div>
                <canvas id="ripple-canvas"></canvas>
                <div class="left-overlay"></div>

            </div>

            <!-- RIGHT SIDE (Form) -->
            <div class="col-lg-5 right-pane">
                <div class="login-box">
                    <div class="login-logo text-center mb-3">
                        <img src="http://localhost:8888/new-pcs-jmtm/assets/brand/JMTMLOGOKU.png" alt="Logo"
                            class="img-fluid logo-img">
                    </div>

                    <!-- <h3 class="login-title">Login Portal</h3> -->
                    <br>
                    <form id="loginForm">

                        <!-- USERNAME -->
                        <div class="mb-3 form-floating-icon">
                            <i class="bi bi-person-fill input-icon"></i>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="username" placeholder=" ">
                                <label for="username">Username</label>
                            </div>
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-3 form-floating-icon">
                            <i class="bi bi-shield-lock-fill input-icon"></i>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="password" placeholder=" ">
                                <label for="password">Password</label>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="showPass">
                            <label class="form-check-label" for="showPass">
                                Show Password
                            </label>
                        </div>

                        <a type="submit" class="btn btn-login"
                            href="<?php echo base_url();?>administrator/dashboard/ctrl_dashboard">
                            <i class="fa-solid fa-lock-open fa-xl px-1"></i>
                            Login
                        </a>

                    </form>

                </div>
            </div>

        </div>
    </div>

</body>

</html>
<!-- BOOTSTRAP -->
<script src="<?php echo base_url();?>/assets/admin_kintek_slash/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>/assets/admin_kintek_slash/js/login_temp.js"></script>