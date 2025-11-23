<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outline Floating Input with Icon</title>

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    /* ===== WRAPPER ===== */
    .form-floating-icon {
        position: relative;
    }

    /* ===== ICON STYLE ===== */
    .form-floating-icon .input-icon {
        position: absolute;
        top: 50%;
        left: 14px;
        transform: translateY(-50%);
        font-size: 1.2rem;
        color: #6c757d;
        pointer-events: none;
        z-index: 5;
    }

    .form-floating-icon .input-icon-right {
        position: absolute;
        top: 50%;
        right: 14px;
        transform: translateY(-50%);
        font-size: 1.2rem;
        color: #6c757d;
        cursor: pointer;
        z-index: 5;
    }

    /* ===== INPUT (value text sejajar icon) ===== */
    .form-floating-icon .form-control {
        padding-left: 2.8rem !important;
        padding-top: 0.55rem !important;
        padding-bottom: 0.45rem !important;
        height: 52px;

        border-radius: 10px;
        border: 1.8px solid #ced4da;
        font-size: 0.95rem;
    }

    .form-floating-icon .form-control.right-icon {
        padding-right: 3rem !important;
    }

    /* ===== LABEL NORMAL ===== */
    .form-floating-icon .form-floating label {
        padding-left: 2.8rem !important;
        font-size: 0.92rem;
        color: #6c757d;
    }

    /* ===== FLOATING LABEL (tidak menutupi value text) ===== */
    .form-floating-icon .form-control:focus~label,
    .form-floating-icon .form-control:not(:placeholder-shown)~label {
        transform: scale(0.70) translateY(-1.45rem) translateX(0.35rem);
        opacity: 1 !important;
        color: #6c757d !important;
        background: #fff;
        padding: 0 .3rem !important;
    }

    /* ===== FOCUS EFFECT ===== */
    .form-floating-icon .form-control:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15) !important;
    }
    </style>
</head>

<body class="bg-light p-4">

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Outline Floating Input + Icon</h4>
            </div>

            <div class="card-body">

                <!-- USERNAME -->
                <div class="form-floating-icon mb-4">
                    <i class="bi bi-person input-icon"></i>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" placeholder=" ">
                        <label for="username">Username</label>
                    </div>
                </div>

                <!-- EMAIL -->
                <div class="form-floating-icon mb-4">
                    <i class="bi bi-envelope input-icon"></i>
                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" placeholder=" ">
                        <label for="email">Email</label>
                    </div>
                </div>

                <!-- PASSWORD -->
                <div class="form-floating-icon mb-4">
                    <i class="bi bi-lock input-icon"></i>

                    <i class="bi bi-eye input-icon-right" id="togglePass"></i>

                    <div class="form-floating">
                        <input type="password" class="form-control right-icon" id="password" placeholder=" ">
                        <label for="password">Password</label>
                    </div>
                </div>

                <button class="btn btn-primary w-100">Submit</button>

            </div>
        </div>
    </div>

    <script>
    // SHOW / HIDE PASSWORD
    document.getElementById("togglePass").addEventListener("click", function() {
        const pwd = document.getElementById("password");

        if (pwd.type === "password") {
            pwd.type = "text";
            this.classList.replace("bi-eye", "bi-eye-slash");
        } else {
            pwd.type = "password";
            this.classList.replace("bi-eye-slash", "bi-eye");
        }
    });
    </script>

</body>

</html>