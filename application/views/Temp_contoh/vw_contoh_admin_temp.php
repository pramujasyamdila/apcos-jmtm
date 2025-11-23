<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard | APCoS</title>

    <!-- Favicons -->
    <link href="<?php echo base_url(); ?>/assets/Landing-home/img/jm1.png" rel="icon">
    <link href="<?php echo base_url(); ?>/assets/Landing-home/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Bootstrap 5 CSS -->
    <link href="<?php echo base_url();?>/assets/admin_kintek_slash/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="<?php echo base_url();?>/assets/admin_kintek_slash/font/bootstrap-icons.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/fontawesome-free/css/all.min.css">
    <!-- Custome CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/admin_kintek_slash/css/card_hoaver_anime.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/admin_kintek_slash/css/global_template.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/admin_kintek_slash/css/saas_bs5.css">
</head>

<body>

    <!-- ================== NAVBAR ==================== -->
    <nav class="navbar navbar-dark bg-dark fixed-top px-3">
        <div class="d-flex align-items-center">
            <button id="toggleSidebar" class="btn btn-outline-light me-3">
                <i class="bi bi-list"></i>
            </button>
            <span class="navbar-brand mb-0 h1">Admin Kintek Slash</span>
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
                <img id="userPic" src="<?php echo base_url();?>/assets/brand/avatar5.png" class="rounded-circle me-2"
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
                <a class="nav-link sidebar-toggle"
                    href="http://localhost:8888/new-pcs-jmtm/Admin_template/Template_utama/Admin_utama"
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                    <i class="bi bi-speedometer2"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <!-- UI Elements -->
            <li class="nav-item position-relative">
                <a class="nav-link sidebar-toggle" href="#" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="UI Elements">
                    <i class="bi bi-layers"></i>
                    <span class="menu-text">UI Elements</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>

                <div class="sidebar-submenu">
                    <a href="#" class="nav-link active">Buttons</a>
                    <a href="#" class="nav-link">Cards</a>
                    <a href="#" class="nav-link">Icons</a>
                </div>
            </li>

            <!-- Forms -->
            <li class="nav-item position-relative">
                <a class="nav-link sidebar-toggle" href="#" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Forms">
                    <i class="bi bi-ui-checks-grid"></i>
                    <span class="menu-text">Forms</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>

                <div class="sidebar-submenu">
                    <a href="#" class="nav-link">Form Elements</a>
                    <a href="#" class="nav-link">Validation</a>
                </div>
            </li>

            <!-- Charts -->
            <li class="nav-item position-relative">
                <a class="nav-link sidebar-toggle" href="#" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Charts">
                    <i class="bi bi-bar-chart-line"></i>
                    <span class="menu-text">Charts</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>

                <div class="sidebar-submenu">
                    <a href="#" class="nav-link">Chart.js</a>
                    <a href="#" class="nav-link">ApexCharts</a>
                </div>
            </li>

        </ul>

        <!-- ================= SIDEBAR USER BOTTOM ================= -->
        <div id="sidebarUser" class="sidebar-user position-absolute w-100">
            <div class="d-flex align-items-center sidebar-user-btn px-3 py-2" style="cursor:pointer;">
                <img src="<?php echo base_url();?>/assets/brand/avatar5.png" class="rounded-circle me-2" width="35">
                <span class="menu-text text-white fw-bold">Ahmad Fikri</span>
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


    <!-- ================== CONTENT ==================== -->
    <div id="content">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4 class="fw-bold">Selamat Datang, User Administrator</h4>
                <div id="dateTime" class="text-muted fw-semibold" style="font-size: 15px;"></div>
            </div>
            <div id="weatherInfo" class="text-muted fw-semibold mb-3" style="font-size: 14px;">
                Mendapatkan lokasi...
            </div>

            <div class="d-flex align-items-center p-3 my-2 text-white rounded shadow-lg"
                style="background: #8E0E00;  /* fallback for old browsers */
                    background: -webkit-linear-gradient(to right, #1F1C18, #8E0E00);  /* Chrome 10-25, Safari 5.1-6 */
                    background: linear-gradient(to right, #1F1C18, #8E0E00); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */">
                <i class="fa-solid fa-gauge-high fa-bounce fa-2xl"></i>&nbsp;&nbsp;
                <div class="lh-1">
                    <h1 class="h6 mb-0 text-white lh-1"><b>Dashboard</b></h1>
                    <small>Pada halaman ini berisikan rangkuman informasi grafik dan Informasi Grafis </small>
                </div>
            </div>
            <br>

            <!-- STAT CARDS -->
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card tilt p-3 bg-primary text-white position-relative">
                        <i class="fa-solid fa-calendar-check card-icon"></i>
                        <h6>Today's Bookings</h6>
                        <h2>4006</h2>
                        <small>+10% from last month</small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card tilt p-3 bg-success text-white position-relative">
                        <i class="fa-solid fa-chart-line card-icon"></i>
                        <h6>Total Bookings</h6>
                        <h2>61,344</h2>
                        <small>+22% from last month</small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card tilt p-3 bg-info text-white position-relative">
                        <i class="fa-solid fa-handshake card-icon"></i>
                        <h6>Meetings</h6>
                        <h2>34,040</h2>
                        <small>+2% from last month</small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card tilt p-3 bg-danger text-white position-relative">
                        <i class="fa-solid fa-users card-icon"></i>
                        <h6>Clients</h6>
                        <h2>47,033</h2>
                        <small>+0.22% from last month</small>
                    </div>
                </div>
            </div>


            <!-- CHART KIRI – KANAN -->
            <div class="row mt-4">

                <div class="col-md-6">
                    <div class="card p-3">
                        <h5 class="fw-semibold mb-3">Area Chart</h5>
                        <div class="chart-container">
                            <canvas id="areaChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card p-3">
                        <h5 class="fw-semibold mb-3">Bar Chart</h5>
                        <div class="chart-container">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>




            <!-- TABLE -->
            <div class="card mt-4 p-3">
                <h5 class="fw-semibold mb-3">Top Products</h5>

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Search Engine Marketing</td>
                                <td>$362</td>
                                <td>21 Sep 2023</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            <tr>
                                <td>Display Ads</td>
                                <td>$551</td>
                                <td>28 Sep 2023</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>Email Marketing</td>
                                <td>$289</td>
                                <td>14 Oct 2023</td>
                                <td><span class="badge bg-danger">Failed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
    </div>
    <!-- FOOTER -->
    <footer class="content-footer">
        <div class="footer-inner">
            <strong>© 2025 Admin Kintek Slash</strong>, Design By: BS-5.3 - Kintekindo.Net
        </div>
    </footer>
    <!-- BOOTSTRAP + CHART JS -->
    <script src="<?php echo base_url();?>/assets/admin_kintek_slash/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>/assets/admin_kintek_slash/js/chart.js"></script>
    <script src="<?php echo base_url();?>/assets/admin_kintek_slash/js/chartjs_custome.js"></script>
    <script src="<?php echo base_url();?>/assets/admin_kintek_slash/js/date_time.js"></script>
    <script src="<?php echo base_url();?>/assets/admin_kintek_slash/js/global_element.js"></script>
    <script src="<?php echo base_url();?>/assets/admin_kintek_slash/js/tilt_parallax.js"></script>