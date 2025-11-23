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
                    <h6><b>Pra-Pengadaan</b></h6>
                    <h2>40</h2>
                    <small>10% from last month</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card tilt p-3 bg-success text-white position-relative">
                    <i class="fa-solid fa-chart-line card-icon"></i>
                    <h6><b>Pengadaan Proyek</b></h6>
                    <h2>61</h2>
                    <small>22% from last month</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card tilt p-3 bg-info text-white position-relative">
                    <i class="fa-solid fa-handshake card-icon"></i>
                    <h6><b>Pelaksanaan Proyek</b></h6>
                    <h2>34</h2>
                    <small>21% from last month</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card tilt p-3 bg-danger text-white position-relative">
                    <i class="fa-solid fa-users card-icon"></i>
                    <h6><b>Pekerjaan Selesai</b></h6>
                    <h2>47</h2>
                    <small>22% from last month</small>
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
            <h5 class="fw-semibold mb-3">Top Proyek</h5>

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