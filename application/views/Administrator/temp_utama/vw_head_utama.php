<body>

    <!-- ================== NAVBAR ==================== -->
    <nav class="navbar navbar-dark bg-dark fixed-top px-3">
        <div class="d-flex align-items-center">
            <button id="toggleSidebar" class="btn btn-sm btn-outline-light me-3 border-dark shadow-lg">
                <i class="bi bi-list"></i>
            </button>
            <span class="navbar-brand mb-0 h3">
                <img src="<?php echo base_url(); ?>/assets/brand/jm1.png" width="26" height="26">&nbsp;
                <small>
                    <span class="text-primary">
                        Administrasi Proyek Control Sistem (APCoS)
                    </span>
                </small>
            </span>
        </div>

        <div class="d-flex align-items-center position-relative">

            <!-- NOTIFICATION WITH BADGE -->
            <div class="position-relative me-4" style="cursor:pointer;">
                <i class="bi bi-bell text-white fs-4" id="notifBell"></i>
                <span id="notifBadge" class="notif-badge">3</span>

                <!-- DROPDOWN NOTIFICATION -->
                <div id="notifDropdown" class="notification-dropdown">

                    <div class="notif-item">
                        <i class="fa-solid fa-envelope text-primary"></i>
                        <div>
                            <strong>New Message</strong><br>
                            <small>You received a new message.</small>
                        </div>
                    </div>

                    <div class="notif-item">
                        <i class="fa-solid fa-bell text-warning"></i>
                        <div>
                            <strong>System Alert</strong><br>
                            <small>Server restart scheduled.</small>
                        </div>
                    </div>

                    <div class="notif-item">
                        <i class="fa-solid fa-user-plus text-success"></i>
                        <div>
                            <strong>New User Joined</strong><br>
                            <small>5 minutes ago</small>
                        </div>
                    </div>

                </div>
            </div>


            <!-- USER DROPDOWN NAVBAR -->
            <div class="position-relative" id="userArea" style="cursor:pointer;">
                <img id="userPic" src="<?php echo base_url(); ?>/assets/brand/avatar5.png" class="rounded-circle me-2"
                    width="40" />

                <div id="userDropdown" class="user-dropdown">
                    <div class="item">
                        <i class="fa-solid fa-user text-primary"></i>
                        <span><strong>Ahmad Fikri</strong></span>
                    </div>
                    <div class="item">
                        <i class="fa-solid fa-lock text-warning"></i>
                        <span>Ubah Password</span>
                    </div>
                    <div class="item">
                        <i class="fa-solid fa-right-from-bracket text-danger"></i>
                        <span>Log Out</span>
                    </div>
                </div>
            </div>


        </div>
    </nav>


    <!-- ================== SIDEBAR ==================== -->
    <div id="sidebar">
        <ul class="nav flex-column">

            <li class="nav-item position-relative">
                <a class="nav-link" href="<?php echo base_url(); ?>administrator/dashboard/ctrl_dashboard"
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                    <i class="bi bi-speedometer2"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <!-- UI Elements -->
            <li class="nav-item position-relative">
                <a class="nav-link sidebar-toggle" href="#" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="UI Elements">
                    <i class="bi bi-database"></i>
                    <span class="menu-text">Master Data</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>

                <div class="sidebar-submenu">
                    <a href="#" class="nav-link active">Data 1</a>
                    <a href="#" class="nav-link">Data 2</a>
                    <a href="#" class="nav-link">Data 3</a>
                </div>
            </li>

            <!-- Forms -->
            <li class="nav-item position-relative">
                <a class="nav-link sidebar-toggle" href="#" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Forms">
                    <i class="bi bi-ui-checks-grid"></i>
                    <span class="menu-text">Transaksi</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>

                <div class="sidebar-submenu">
                    <a href="<?php echo base_url(); ?>administrator/transaksi/daftar_km/ctrl_daftar_km"
                        class="nav-link"><small>Daftar KM</small></a>
                    <a href="<?php echo base_url(); ?>administrator/transaksi/daftar_km/ctrl_daftar_program"
                        class="nav-link"><small>Daftar Program</small></a>
                </div>
            </li>

            <!-- Charts -->
            <li class="nav-item position-relative">
                <a class="nav-link sidebar-toggle" href="#" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Charts">
                    <i class="bi bi-boxes"></i>
                    <span class="menu-text">System Config</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>

                <div class="sidebar-submenu">
                    <a href="#" class="nav-link">User Account</a>
                    <a href="#" class="nav-link">User Management</a>
                    <a href="#" class="nav-link">Structure System</a>
                </div>
            </li>

        </ul>

        <!-- ================= SIDEBAR USER BOTTOM ================= -->
        <div id="sidebarUser" class="sidebar-user position-absolute w-100">
            <div class="d-flex align-items-center sidebar-user-btn px-3 py-2" style="cursor:pointer;">
                <img src="<?php echo base_url(); ?>/assets/brand/avatar5.png" class="rounded-circle me-2" width="35">

                <span class="menu-text text-white fw-bold truncate-name">
                    <small>Ahmad Fikri</small>
                </span>

                <i class="bi bi-chevron-up ms-auto text-white menu-text"></i>
            </div>


            <!-- SIDEBAR USER DROPDOWN -->
            <div id="sidebarUserDropdown" class="sidebar-user-dropdown">
                <div class="item">
                    <i class="fa-solid fa-user text-primary"></i>
                    <span><strong>Profile</strong></span>
                </div>
                <div class="item">
                    <i class="fa-solid fa-lock text-warning"></i>
                    <span>Ubah Password</span>
                </div>
                <div class="item">
                    <i class="fa-solid fa-right-from-bracket text-danger"></i>
                    <span>Log Out</span>
                </div>
            </div>
        </div>

    </div>