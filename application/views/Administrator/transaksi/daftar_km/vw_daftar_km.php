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
                                                        <img src="<?php echo base_url();?>/assets/brand/vendors-image.png"
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
<!-- ===================== MODAL FULLSCREEN DETAIL ===================== -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex align-items-center p-2 my-2 text-white rounded shadow-lg"
                    style="background: #36D1DC;  /* fallback for old browsers */
                        background: -webkit-linear-gradient(to right, #5B86E5, #36D1DC);  /* Chrome 10-25, Safari 5.1-6 */
                        background: linear-gradient(to right, #5B86E5, #36D1DC); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */">
                    <i class="fa-regular fa-folder-open fa-xl px-1"></i>
                    &nbsp;&nbsp;
                    <div class="lh-1">
                        <h1 class="h6 mb-0 text-white lh-1">
                            <b>Informasi Detail Data Kontrak Manajemen</b>
                        </h1>
                    </div>
                </div>
                <div class="my-2 p-2 bg-body rounded shadow-lg">
                    <div class="card shadow-lg">
                        <div class="card-header d-flex justify-content-between align-items-center"
                            style="background: #232526;  /* fallback for old browsers */
                                    background: -webkit-linear-gradient(to right, #414345, #232526);  /* Chrome 10-25, Safari 5.1-6 */
                                    background: linear-gradient(to right, #414345, #232526); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */">
                            <div class="flex-grow-1 bd-highlight">
                                <span class="text-white">
                                    <i class="fa-solid fa-address-card fa-lg px-1"></i>
                                    <small>
                                        Form Isian Data Kontrak Manajemen
                                    </small>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item small">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    Informasi Data Kontrak Manajemen Sistem Ter-Filter
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-sm table-bordered align-middle border-dark">
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
                                                                            <span
                                                                                class="badge bg-primary position-absolute top-0 start-0"
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
                                                                            <img src="<?php echo base_url();?>/assets/brand/vendors-image.png"
                                                                                class="card-img-top"
                                                                                style="border-radius: 15px; padding-top: 13px;"
                                                                                alt="image">
                                                                        </div>
                                                                    </td>
                                                                    <td scope="row"
                                                                        class="col-11 align-middle text-start">
                                                                        <div class="table-responsive">
                                                                            <table
                                                                                class="table table-sm table-borderless table-hover">
                                                                                <tbody class="small">
                                                                                    <tr>
                                                                                        <td scope="col"
                                                                                            class="col-3 text-start fw-bold">
                                                                                            Nomor & Date Kontrak
                                                                                        </td>
                                                                                        <td scope="col"
                                                                                            class="col-8 text-start text-muted">
                                                                                            <i
                                                                                                class="fa-solid fa-barcode"></i>
                                                                                            &nbsp;003/GM-OPS1/JMTM/XXI/2025
                                                                                            &nbsp;& &nbsp;<i
                                                                                                class="fa-solid fa-calendar-check"></i>
                                                                                            &nbsp;21 November 2025
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td scope="row"
                                                                                            class="col-3 text-start fw-bold">
                                                                                            Nama Kontrak
                                                                                        </td>
                                                                                        <td scope="row"
                                                                                            class="col-8 text-start text-muted"
                                                                                            colspan=3>
                                                                                            <i
                                                                                                class="fa-solid fa-pen-to-square"></i>
                                                                                            &nbsp;Kontrak Manajemen
                                                                                            Pemenuhan Standar
                                                                                            Pelayanan Minimal di Bidang
                                                                                            Pemeliharaan Jalan
                                                                                            Tol pada Ruas
                                                                                            Jakarta-Cikampek
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td scope="row"
                                                                                            class="col-3 text-start fw-bold">
                                                                                            Tahun Anggaran & Periode Add
                                                                                        </td>
                                                                                        <td scope="row"
                                                                                            class="col-8 text-start text-muted">
                                                                                            <i
                                                                                                class="fa-solid fa-calendar-check"></i>
                                                                                            &nbsp;2025 &nbsp;& &nbsp;<i
                                                                                                class="fa-solid fa-list-ol"></i>
                                                                                            &nbsp;Adendum Ke-1
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td scope="row"
                                                                                            class="col-3 text-start fw-bold">
                                                                                            Level No. & Nama Program
                                                                                        </td>
                                                                                        <td scope="row"
                                                                                            class="col-8 text-start text-muted">
                                                                                            <i
                                                                                                class="fa-solid fa-list-ol"></i>
                                                                                            &nbsp;<b>1.1.1.1</b> &nbsp;&
                                                                                            &nbsp;<i
                                                                                                class="fa-solid fa-pen-to-square"></i>
                                                                                            &nbsp;<b>Kontrak Manajemen
                                                                                                Pemenuhan Standar
                                                                                                Pelayanan
                                                                                                Minimal di Bidang
                                                                                                Pemeliharaan Jalan Tol
                                                                                                pada</b>
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
                                        </div>
                                        <div class="accordion-item small">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseTwo" aria-expanded="true"
                                                    aria-controls="collapseTwo">
                                                    Informasi Detail Rencana Data Kontrak Manajemen
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse show"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="table-responsive">
                                                        <table class="table align-middle">
                                                            <tr>
                                                                <td scope="col" class="text-start text-muted">
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text border-dark">
                                                                                Pilih Kontrak / Add
                                                                            </span>
                                                                            <select id="0"
                                                                                class="form-select border-dark"
                                                                                aria-label="Default select example">
                                                                                <option selected disabled value="0">Open
                                                                                    this select
                                                                                </option>
                                                                                <option value="1">Kontrak</option>
                                                                                <option value="2">Add I</option>
                                                                                <option value="3">Add II</option>
                                                                            </select>
                                                                            <input id="jml_kontrak" type="text"
                                                                                class="form-control border-dark text-end"
                                                                                style="background-color: #dee2e6;"
                                                                                value="Rp 900.000.000" readonly>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <h6 class="border-bottom border-white pb-2 mb-0"></h6>
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-sm table-bordered table-striped align-middle">
                                                            <thead class="table-secondary small text-dark fw-bold">
                                                                <tr>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        Jan
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        Feb
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        Mar
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        Apr
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        Mei
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        Jun
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        Jul
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        Ags
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        Sep
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        Okt
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        Nov
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        Des
                                                                    </th>
                                                                    <th scope="col" class="text-center align-middle"
                                                                        rowspan="2" style="width: 100px;">
                                                                        Total
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        <select id="1"
                                                                            class="form-select form-select-sm border-dark">
                                                                            <option selected disabled value="0">Open

                                                                            </option>
                                                                            <option value="1">Pra-Pengadaan</option>
                                                                            <option value="2">Pengadaan</option>
                                                                            <option value="3">Pelaksanaan</option>
                                                                            <option value="3">Pekerjaan Selesai</option>
                                                                        </select>
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        <select id="2"
                                                                            class="form-select form-select-sm border-dark">
                                                                            <option selected disabled value="0">Open

                                                                            </option>
                                                                            <option value="1">Pra-Pengadaan</option>
                                                                            <option value="2">Pengadaan</option>
                                                                            <option value="3">Pelaksanaan</option>
                                                                            <option value="3">Pekerjaan Selesai</option>
                                                                        </select>
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        <select id="3"
                                                                            class="form-select form-select-sm border-dark">
                                                                            <option selected disabled value="0">Open

                                                                            </option>
                                                                            <option value="1">Pra-Pengadaan</option>
                                                                            <option value="2">Pengadaan</option>
                                                                            <option value="3">Pelaksanaan</option>
                                                                            <option value="3">Pekerjaan Selesai</option>
                                                                        </select>
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        <select id="4"
                                                                            class="form-select form-select-sm border-dark">
                                                                            <option selected disabled value="0">Open

                                                                            </option>
                                                                            <option value="1">Pra-Pengadaan</option>
                                                                            <option value="2">Pengadaan</option>
                                                                            <option value="3">Pelaksanaan</option>
                                                                            <option value="3">Pekerjaan Selesai</option>
                                                                        </select>
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        <select id="5"
                                                                            class="form-select form-select-sm border-dark">
                                                                            <option selected disabled value="0">Open
                                                                            </option>
                                                                            <option value="1">Pra-Pengadaan</option>
                                                                            <option value="2">Pengadaan</option>
                                                                            <option value="3">Pelaksanaan</option>
                                                                            <option value="3">Pekerjaan Selesai</option>
                                                                        </select>
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        <select id="6"
                                                                            class="form-select form-select-sm border-dark">
                                                                            <option selected disabled value="0">Open
                                                                            </option>
                                                                            <option value="1">Pra-Pengadaan</option>
                                                                            <option value="2">Pengadaan</option>
                                                                            <option value="3">Pelaksanaan</option>
                                                                            <option value="3">Pekerjaan Selesai</option>
                                                                        </select>
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        <select id="7"
                                                                            class="form-select form-select-sm border-dark">
                                                                            <option selected disabled value="0">Open
                                                                            </option>
                                                                            <option value="1">Pra-Pengadaan</option>
                                                                            <option value="2">Pengadaan</option>
                                                                            <option value="3">Pelaksanaan</option>
                                                                            <option value="3">Pekerjaan Selesai</option>
                                                                        </select>
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        <select id="8"
                                                                            class="form-select form-select-sm border-dark">
                                                                            <option selected disabled value="0">Open
                                                                            </option>
                                                                            <option value="1">Pra-Pengadaan</option>
                                                                            <option value="2">Pengadaan</option>
                                                                            <option value="3">Pelaksanaan</option>
                                                                            <option value="3">Pekerjaan Selesai</option>
                                                                        </select>
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        <select id="9"
                                                                            class="form-select form-select-sm border-dark">
                                                                            <option selected disabled value="0">Open
                                                                            </option>
                                                                            <option value="1">Pra-Pengadaan</option>
                                                                            <option value="2">Pengadaan</option>
                                                                            <option value="3">Pelaksanaan</option>
                                                                            <option value="3">Pekerjaan Selesai</option>
                                                                        </select>
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        <select id="10"
                                                                            class="form-select form-select-sm border-dark">
                                                                            <option selected disabled value="0">Open
                                                                            </option>
                                                                            <option value="1">Pra-Pengadaan</option>
                                                                            <option value="2">Pengadaan</option>
                                                                            <option value="3">Pelaksanaan</option>
                                                                            <option value="3">Pekerjaan Selesai</option>
                                                                        </select>
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        <select id="11"
                                                                            class="form-select form-select-sm border-dark">
                                                                            <option selected disabled value="0">Open
                                                                            </option>
                                                                            <option value="1">Pra-Pengadaan</option>
                                                                            <option value="2">Pengadaan</option>
                                                                            <option value="3">Pelaksanaan</option>
                                                                            <option value="3">Pekerjaan Selesai</option>
                                                                        </select>
                                                                    </th>
                                                                    <th scope="col" class="text-center"
                                                                        style="width: 80px;">
                                                                        <select id="12"
                                                                            class="form-select form-select-sm border-dark">
                                                                            <option selected disabled value="0">Open
                                                                            </option>
                                                                            <option value="1">Pra-Pengadaan</option>
                                                                            <option value="2">Pengadaan</option>
                                                                            <option value="3">Pelaksanaan</option>
                                                                            <option value="3">Pekerjaan Selesai</option>
                                                                        </select>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="small text-dark">
                                                                <tr>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="1"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text">
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="2"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text">
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="3"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text">
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="4"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text">
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="5"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text">
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="6"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text">
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="7"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text">
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="8"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text">
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="9"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text">
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="10"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text">
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="11"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text">
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="12"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text">
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="total"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="1"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="2"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="3"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="4"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="5"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="6"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="7"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="8"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="9"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="10"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="11"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="12"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                    <td scope="row" class="text-end"
                                                                        style="width: 80px;">
                                                                        <input id="total"
                                                                            class="form-control form-control-sm text-end"
                                                                            type="text"
                                                                            style="background-color: #dee2e6;" readonly>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-danger btn-sm rounded shadow-lg"
                                data-bs-dismiss="modal">
                                <i class="fa-regular fa-rectangle-xmark fa-lg px-1"></i>
                                Tutup Halaman
                            </button>
                            <button id="link-simpan" type="submit" class="btn btn-success btn-sm rounded shadow-lg">
                                <i class="fa-regular fa-floppy-disk fa-lg px-1"></i>
                                Simpan Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===================== END MODAL FULLSCREEN ===================== -->