<div id="content">
    <div class="container-fluid">
        <!-- ================== Head Page ==================== -->
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
            <i class="fa-solid fa-newspaper fa-bounce fa-2xl"></i>&nbsp;&nbsp;
            <div class="lh-1">
                <h1 class="h6 mb-0 text-white lh-1"><b>Daftar Kontrak Manajemen</b></h1>
                <small>Pada halaman ini... </small>
            </div>
        </div><!-- ================== End Head Page ==================== -->
        <!-- ================== Card Konten ==================== -->
        <div class="card shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background: #373B44;  /* fallback for old browsers */
                                    background: -webkit-linear-gradient(to right, #4286f4, #373B44);  /* Chrome 10-25, Safari 5.1-6 */
                                    background: linear-gradient(to right, #4286f4, #373B44); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */">
                <div class="flex-grow-1 bd-highlight">
                    <span class="text-white">
                        <i class="fa-solid fa-table fa-lg px-1"></i>
                        <small>
                            <strong>
                                Tabel Daftar Kontrak Manajemen Sistem
                            </strong>
                        </small>
                    </span>
                </div>
            </div>
            <!-- ================== Card Body Konten ==================== -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <tr>
                            <td scope="col" class="text-start text-muted">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text border-dark">
                                            <i class="fa-solid fa-square-check fa-lg"></i>
                                        </span>
                                        <input class="form-control border-dark" list="datalistOptions"
                                            id="exampleDataList" placeholder="Ketikan No Kontrak / Tahun Anggaran..."
                                            value="">
                                        <datalist id="datalistOptions">
                                            <option value="No. Kontrak 1 | Area | 2025">
                                            <option value="No. Kontrak 2 | Area | 2025">
                                            <option value="No. Kontrak 3 | Area | 2025">
                                            <option value="No. Kontrak 4 | Area | 2025">
                                            <option value="No. Kontrak 5 | Area | 2025">
                                        </datalist>
                                        <button class="btn btn-outline-info text-dark border-dark" type="button"
                                            id="btn_fillter_prg">
                                            <i class="fa-solid fa-magnifying-glass fa-sm"></i>
                                            <strong>Filter Data</strong>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- ================== Tabel KMS ==================== -->
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item small">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Informasi Data Kontrak Manajemen Sistem Ter-Filter
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered align-middle border-dark">
                                        <thead class="table-secondary text-white">
                                            <tr>
                                                <th scope="col" class="col-1 text-center">
                                                    <small>Nilai Kontrak / Add</small>
                                                </th>
                                                <th scope="col" class="col-11 text-center">
                                                    <small>Keterangan Kontrak</small>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td scope="row" class="col-1 text-center">
                                                    <div class="card shadow-sm position-relative"
                                                        style="width: 150px; border-radius: 12px;">
                                                        <!-- Badge Harga -->
                                                        <span class="badge bg-primary position-absolute top-0 start-0"
                                                            style="
                                                                border-bottom-right-radius: 8px;
                                                                font-size: 0.70rem;
                                                                padding: 6px 10px;
                                                                max-width: 100%;
                                                                white-space: nowrap;
                                                                overflow: hidden;
                                                                text-overflow: ellipsis;
                                                            ">
                                                            <b>Rp 2.000.000.000</b>
                                                        </span>


                                                        <!-- Gambar -->
                                                        <img src="<?php echo base_url(); ?>/assets/brand/vendors-image.png"
                                                            class="card-img-top"
                                                            style="border-radius: 15px; padding-top: 13px;" alt="image">
                                                    </div>
                                                </td>
                                                <td scope="row" class="col-11 align-middle text-start">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-borderless table-hover">
                                                            <tbody class="small">
                                                                <tr>
                                                                    <td scope="col" class="col-3 text-start fw-bold">
                                                                        Nomor & Date Kontrak
                                                                    </td>
                                                                    <td scope="col" class="col-8 text-start text-muted">
                                                                        <i class="fa-solid fa-barcode"></i>
                                                                        &nbsp;003/GM-OPS1/JMTM/XXI/2025 &nbsp;& &nbsp;<i
                                                                            class="fa-solid fa-calendar-check"></i>
                                                                        &nbsp;21 November 2025
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td scope="row" class="col-3 text-start fw-bold">
                                                                        Nama Kontrak
                                                                    </td>
                                                                    <td scope="row" class="col-8 text-start text-muted"
                                                                        colspan=3>
                                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                                        &nbsp;Kontrak Manajemen Pemenuhan Standar
                                                                        Pelayanan Minimal di Bidang Pemeliharaan Jalan
                                                                        Tol pada Ruas Jakarta-Cikampek
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td scope="row" class="col-3 text-start fw-bold">
                                                                        Tahun Anggaran & Periode Add
                                                                    </td>
                                                                    <td scope="row" class="col-8 text-start text-muted">
                                                                        <i class="fa-solid fa-calendar-check"></i>
                                                                        &nbsp;2025 &nbsp;& &nbsp;<i
                                                                            class="fa-solid fa-list-ol"></i>
                                                                        &nbsp;Adendum Ke-1
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- ================== End Tabel KMS ==================== -->
                    <!-- ================== Tabel Detail KMS ==================== -->
                    <h6 class="border-bottom border-white pb-2 mb-0"></h6>
                    <h6 class="border-bottom border-white pb-2 mb-0"></h6>
                    <h6 class="border-bottom border-dark pb-2 mb-0">
                        <i class="fa-solid fa-circle-info px-1"></i>
                        Informasi Detail Tabel Kontrak
                    </h6>
                    <h6 class="border-bottom border-white pb-2 mb-0"></h6>
                    <div class="table-responsive">
                        <table
                            class="table table-sm table-striped table-bordered align-middle border-dark example nowrap"
                            style="width:100%">
                            <thead class=" table-warning text-dark small fw-bold">
                                <tr>
                                    <th scope="col" class="col-1 text-center align-middle">
                                        Level No.
                                    </th>
                                    <th scope="col" class="col-6 text-center align-middle">
                                        Nama Program Pekerjaan
                                    </th>
                                    <th scope="col" class="col-2 text-center align-middle">
                                        Kontrak Awal
                                    </th>
                                    <th scope="col" class="col-2 text-center">
                                        <select id="filterAddKategori"
                                            class="form-select form-select-sm text-center fw-bold">
                                            <option value="Add I">Add I</option>
                                            <option value="Add II">Add II</option>
                                            <option value="Add III">Add III</option>
                                        </select>
                                    </th>
                                    <th scope="col" class="col-1 text-center align-middle">
                                        .:: Aksi ::.
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <td scope="row" class="col-1 text-end">
                                        1
                                    </td>
                                    <td scope="row" class="col-6 text-start text-truncate" style="max-width: 250px;">
                                        Kontrak Manajemen Pemenuhan Standar Pelayanan Minimal di Bidang Pemeliharaan
                                        Jalan Tol pada Ruas Jakarta-Cikampek
                                    </td>
                                    <td scope="row" class="col-2 text-end">
                                        Rp 2.000.000.000
                                    </td>
                                    <td scope="row" class="col-2 text-end">
                                        Rp 1.000.000.000
                                    </td>
                                    <td scope="row" class="col-1 text-center">
                                        <button id="btnTambahAksi" type="button" class="btn btn-secondary btn-sm"
                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="timbulkan aksi tambahan">
                                            <i class="fa-solid fa-square-plus"></i>
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- ================== End Card Body Konten ==================== -->
            <div class="card-footer">

            </div>
        </div><!-- ================== End Card Konten ==================== -->

    </div>
    <br>
</div>