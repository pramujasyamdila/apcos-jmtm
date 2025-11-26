<script>
    $(document).ready(function() {

        // === LOAD DATALIST ===
        $.ajax({
            url: "<?= base_url('administrator/transaksi/daftar_km/ctrl_daftar_km/get_kontrak_ajax'); ?>",
            type: "GET",
            dataType: "json",
            success: function(data) {

                let datalist = $('#datalistOptions');
                datalist.empty();

                data.forEach(function(item) {
                    let noKontrak = item.no_kontrak ?? "-";
                    let subArea = item.nama_sub_area ?? "-";
                    let tahun = item.tahun_anggaran ?? "-";

                    datalist.append(
                        `<option value="${noKontrak} | ${subArea} | ${tahun}"></option>`
                    );
                });

            }
        });

        // === EVENT TOMBOL FILTER ===
        $("#btn_fillter_prg").on("click", function() {

            let raw = $("#exampleDataList").val();

            if (raw.trim() === "") {
                Swal.fire({
                    icon: "warning",
                    title: "Peringatan",
                    text: "Silakan pilih kontrak dulu!"
                });
                return;
            }

            // Pisah datalist value
            let parts = raw.split(" | ");

            let no_kontrak = parts[0];
            let sub_area = parts[1];
            let tahun = parts[2];

            Swal.fire({
                    title: 'Filter Kontrak?',
                    html: `
                    <div class="text-start">

                        <div class="alert alert-primary py-2 mb-2">
                            <b>No Kontrak:</b><br>
                            <span class="small">${no_kontrak}</span>
                        </div>

                        <div class="alert alert-success py-2 mb-2">
                            <b>Sub Area:</b><br>
                            <span class="small">${sub_area}</span>
                        </div>

                        <div class="alert alert-warning py-2 mb-0">
                            <b>Tahun Anggaran:</b><br>
                            <span class="small">${tahun}</span>
                        </div>

                    </div>
                `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-filter"></i> Filter',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                })
                .then((result) => {

                    if (result.isConfirmed) {

                        // === KIRIM NO_KONTRAK + SUBAREA + TAHUN ===
                        $.ajax({
                            url: "<?= base_url('administrator/transaksi/daftar_km/ctrl_daftar_km/get_kontrak_by_no'); ?>",
                            type: "GET",
                            data: {
                                no_kontrak: no_kontrak,
                                sub_area: sub_area, // tambahan
                                tahun_anggaran: tahun // tambahan
                            },
                            dataType: "json",
                            success: function(res) {

                                let data = res.data;

                                if (!data) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Tidak ditemukan',
                                        text: 'Data kontrak tidak ditemukan!'
                                    });
                                    return;
                                }

                                // ==== FORMAT RUPIAH ====
                                function rupiah(x) {
                                    return new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(x);
                                }

                                function formatTanggalIndo(tgl) {
                                    if (!tgl) return "-";

                                    let months = [
                                        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                                        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                                    ];

                                    let d = new Date(tgl);
                                    let day = String(d.getDate()).padStart(2, '0');
                                    let month = months[d.getMonth()];
                                    let year = d.getFullYear();

                                    return `${day} ${month} ${year}`;
                                }

                                // ==== TENTUKAN ADDENDUM ====
                                let add_ke = (!data.add_ke || data.add_ke === "0") ? 0 : parseInt(data.add_ke);

                                // kondisi add_ke kosong → kontrak awal
                                if (add_ke === 0) {
                                    let ppn_rate = Number("0." + (data.ppn_kontrak_addendum_0 ?? 0));
                                    let nilai = Number(data.pembulatan_kontrak_awal ?? 0);
                                    var total = nilai + (nilai * ppn_rate);
                                    var tanggal_terupdate = data.tahun_kontrak;
                                } else {
                                    // dynamic field
                                    let nilai_field = "pembulatan_nilai_add_" + add_ke;
                                    let ppn_field = "ppn_kontrak_addendum_" + add_ke;

                                    let nilai = Number(data[nilai_field] ?? 0);
                                    let ppn_rate = Number("0." + (data[ppn_field] ?? 0));

                                    var total = nilai + (nilai * ppn_rate);
                                    var tanggal_terupdate = data.tanggal_add;
                                }

                                // ==== MASUKKAN DATA KE ROW ====
                                $("#badge_harga").text(rupiah(total));
                                $("#label_no_kontrak").text(data.no_kontrak);
                                $("#label_tgl_kontrak").text(formatTanggalIndo(tanggal_terupdate));
                                $("#label_nama_kontrak").text(data.nama_kontrak);
                                $("#label_tahun_anggaran").text(data.tahun_anggaran);
                                $("#input_id_kontrak").val(data.id_kontrak);
                                $("#input_nomor_kontrak").val(data.no_kontrak);
                                $("#input_nama_kontrak").val(data.nama_kontrak);
                                $("#input_tanggal_kontrak").val(formatTanggalIndo(tanggal_terupdate));
                                $("#input_tahun_anggaran").val(data.tahun_anggaran);
                                $("#input_add_terupdate").val(add_ke === 0 ? "Kontrak Awal" : "Addendum " + add_ke);
                                $("#input_nilai_addendum_terupdate").val(total);

                                $("#label_adendum").text(
                                    add_ke === 0 ? "Kontrak Awal" : "Adendum Ke-" + add_ke + " (Terupdate)"
                                );

                                // === KONVERTER ANGKA → ROMAWI ===
                                function toRoman(num) {
                                    const romans = [
                                        "", "I", "II", "III", "IV", "V",
                                        "VI", "VII", "VIII", "IX", "X",
                                        "XI", "XII", "XIII", "XIV", "XV",
                                        "XVI", "XVII", "XVIII", "XIX", "XX",
                                        "XXI", "XXII", "XXIII", "XXIV", "XXV"
                                    ];
                                    return romans[num] ?? num;
                                }


                                // === LOAD LIST ADENDUM ===
                                $.ajax({
                                    url: "<?= base_url('administrator/transaksi/daftar_km/ctrl_daftar_km/get_list_adendum'); ?>",
                                    type: "GET",
                                    data: {
                                        id_kontrak: data.id_kontrak
                                    },
                                    dataType: "json",
                                    success: function(res) {
                                        let select = $("#filterAddKategori");
                                        select.empty();
                                        res.forEach(item => {
                                            let rom = toRoman(item.no_adendum);
                                            select.append(`<option value="${item.no_adendum}">Add ${rom}</option>`);
                                        });
                                    }
                                });


                                // destroy dulu sebelum init ulang
                                if ($.fn.DataTable.isDataTable('#mirrorTable')) {
                                    $('#mirrorTable').DataTable().clear().destroy();
                                }

                                let mirrorTable = $('#mirrorTable').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    lengthChange: false,
                                    ordering: true,
                                    responsive: false,
                                    bDestroy: true,
                                    buttons: ['print', 'pdf', 'colvis'],

                                    ajax: {
                                        url: "<?= base_url('administrator/transaksi/daftar_km/ctrl_daftar_km/get_hirarki_kontrak/'); ?>" +
                                            data.id_kontrak + "?add_ke=1",
                                        type: "GET",
                                    },

                                    columnDefs: [{
                                            targets: 0,
                                            className: 'text-center fw-bold'
                                        },
                                        {
                                            targets: 4,
                                            orderable: false
                                        } // aksi tidak sort
                                    ],

                                    columns: [{
                                            data: "nomor"
                                        },
                                        {
                                            data: "nama_program",
                                            render: function(data) {
                                                if (!data) data = "-";
                                                return `
                    <span class="nama-ellipsis"
                        style="display:inline-block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                        data-bs-toggle="tooltip" title="${data}">
                        ${data}
                    </span>`;
                                            }
                                        },
                                        {
                                            data: "awal",
                                            render: $.fn.dataTable.render.number('.', ',', 2, '')
                                        },
                                        {
                                            data: "add_val",
                                            render: $.fn.dataTable.render.number('.', ',', 2, '')
                                        },

                                        {
                                            data: "level",
                                            render: function(data, type, row) {
                                                return `
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary btn-sm btnTambahAksi"
                        data-id-kontrak="${row.id_kontrak ?? ''}"
                        data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Timbulkan aksi tambahan"
                        style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-square-plus"></i>
                    </button>
                </div>`;
                                            }
                                        }
                                    ],

                                    pageLength: 10,
                                    order: [
                                        [0, "asc"]
                                    ],

                                    initComplete: function() {
                                        this.api().buttons().container()
                                            .appendTo($('.col-md-6:eq(0)', this.api().table().container()));

                                        const tooltipTriggerList = [].slice.call(
                                            document.querySelectorAll('[data-bs-toggle="tooltip"]')
                                        );
                                        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
                                    }
                                });

                                // re-init tooltip setiap redraw
                                mirrorTable.on('draw.dt', function() {
                                    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                                        new bootstrap.Tooltip(el);
                                    });
                                });



                                // ==========================
                                // EVENT UNTUK TOMBOL DINAMIS
                                // ==========================

                                // =====================================================
                                //  EVENT: Klik tombol Tambah Aksi (+)
                                // =====================================================
                                $(document).on("click", ".btnTambahAksi", function() {

                                    const btnTambah = this;
                                    const idKontrak = btnTambah.dataset.idKontrak; // ⬅ ambil id_kontrak dari tombol

                                    Swal.fire({
                                        title: 'Aksi Tambahan',
                                        text: 'Apakah Anda ingin menambah Aksi baru?',
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya, tambah',
                                        cancelButtonText: 'Batal',
                                        confirmButtonColor: '#0d6efd',
                                        cancelButtonColor: '#6c757d',
                                    }).then((result) => {

                                        // ❌ Jika user klik "Batal"
                                        if (result.dismiss === Swal.DismissReason.cancel) {

                                            bootstrap.Tooltip.getInstance(btnTambah)?.dispose();

                                            Swal.fire({
                                                icon: 'info',
                                                title: 'Dibatalkan',
                                                timer: 1000,
                                                showConfirmButton: false,
                                            });

                                            return;
                                        }

                                        // ================================
                                        // ✔ USER SETUJU (Klik YA)
                                        // ================================
                                        if (result.isConfirmed) {

                                            const aksiCell = btnTambah.parentElement;

                                            // sembunyikan tombol tambah
                                            btnTambah.style.display = "none";

                                            // ================================
                                            //   BUTTON: DETAIL
                                            // ================================
                                            const btnDetail = document.createElement("button");
                                            btnDetail.className = "btn btn-info btn-sm ms-1 btnDetailAksi";
                                            btnDetail.innerHTML = '<i class="fa-solid fa-circle-info"></i>';
                                            btnDetail.setAttribute("title", "Lihat Detail");
                                            btnDetail.setAttribute("data-id-kontrak", idKontrak);
                                            btnDetail.setAttribute("data-bs-toggle", "tooltip");

                                            // ================================
                                            //   BUTTON: KEMBALI
                                            // ================================
                                            const btnKembali = document.createElement("button");
                                            btnKembali.className = "btn btn-warning btn-sm ms-1";
                                            btnKembali.innerHTML = '<i class="fa-solid fa-rotate-left"></i>';
                                            btnKembali.setAttribute("title", "Kembalikan ke tombol awal");
                                            btnKembali.setAttribute("data-bs-toggle", "tooltip");

                                            aksiCell.appendChild(btnDetail);
                                            aksiCell.appendChild(btnKembali);

                                            // ================================
                                            //   EVENT: KEMBALIKAN
                                            // ================================
                                            btnKembali.addEventListener("click", function() {

                                                bootstrap.Tooltip.getInstance(btnDetail)?.dispose();
                                                bootstrap.Tooltip.getInstance(btnKembali)?.dispose();

                                                btnDetail.remove();
                                                btnKembali.remove();

                                                btnTambah.style.display = "inline-block";

                                                Swal.fire({
                                                    title: "Dikembalikan!",
                                                    text: "Tombol kembali ke kondisi awal.",
                                                    icon: "success",
                                                    timer: 1300,
                                                    showConfirmButton: false
                                                });
                                            });

                                            // re-init tooltip
                                            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                                                new bootstrap.Tooltip(el);
                                            });

                                            Swal.fire({
                                                title: 'Berhasil!',
                                                text: 'Sekarang tombol berubah menjadi Detail & Kembali.',
                                                icon: 'success',
                                                timer: 1500,
                                                showConfirmButton: false
                                            });

                                        }

                                    });

                                });


                                // =====================================================
                                // EVENT: Klik tombol DETAIL
                                // (dibuat terpisah biar bersih & aman untuk DataTables)
                                // =====================================================

                                let detailAddendumFinal = []; // global

                                $(document).on("click", ".btnDetailAksi", function() {

                                    const table = $('#mirrorTable').DataTable();
                                    const rowData = table.row($(this).closest("tr")).data();

                                    if (!rowData) {
                                        Swal.fire("Error", "Data tidak ditemukan!", "error");
                                        return;
                                    }

                                    function formatRupiah(value) {
                                        return new Intl.NumberFormat("id-ID", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        }).format(Number(value) || 0);
                                    }

                                    // =============================
                                    // SET FORM INPUT OTOMATIS
                                    // =============================
                                    $("#input_level_daftar_km").val(rowData.nomor ?? 0);
                                    $("#nama_program").val(rowData.nama_program ?? "-");


                                    // =============================
                                    // LOOPING DATA ADDENDUM
                                    // =============================
                                    let nomorRoman = ["", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
                                    let listAdd = [];

                                    Object.keys(rowData).forEach(key => {
                                        let match = key.match(/^add(\d+)$/);
                                        if (match) {
                                            let no = parseInt(match[1]);
                                            let nilai = Number(rowData[key]) || 0;

                                            if (nilai > 0) listAdd.push({
                                                no,
                                                romawi: nomorRoman[no] ?? no,
                                                nilai
                                            });
                                        }
                                    });

                                    // ⬅⬅ Masukkan KONTRAK AWAL di urutan pertama
                                    listAdd.unshift({
                                        no: 0,
                                        romawi: "",
                                        nilai: Number(rowData.awal) || 0
                                    });

                                    listAdd.sort((a, b) => a.no - b.no);

                                    detailAddendumFinal = listAdd; // ⬅⬅ simpan untuk tombol Simpan nanti


                                    // =============================
                                    // TAMPILKAN DI TABEL MODAL
                                    // =============================
                                    let htmlAdd = `
        <tr class="table-warning fw-bold">
            <td>Kontrak Awal</td>
            <td>${formatRupiah(rowData.awal)}</td>
        </tr>
    `;

                                    listAdd.forEach(item => {
                                        if (item.no > 0) {
                                            htmlAdd += `
                <tr>
                    <td>Add ${item.romawi}</td>
                    <td>${formatRupiah(item.nilai)}</td>
                </tr>
            `;
                                        }
                                    });

                                    $("#detail_add_loop").html(htmlAdd);

                                    $("#modalDetail").modal("show");

                                    let formData = {};

                                    $("form#formDaftarKM input[name]").each(function() {
                                        formData[$(this).attr("name")] = $(this).val();
                                    });

                                    formData.detail_addendum = detailAddendumFinal; // pakai hasil klik detail

                                    console.log("FINAL DATA:", formData);

                                    Swal.fire({
                                        title: "Generate Data...",
                                        html: "Mohon tunggu sebentar...",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    $.ajax({
                                        url: "<?= base_url('administrator/transaksi/daftar_km/ctrl_daftar_km/save_daftar_km'); ?>",
                                        type: "POST",
                                        data: JSON.stringify(formData),
                                        contentType: "application/json",
                                        dataType: "json",
                                        success: function(res) {



                                            // kalau data sudah pernah dibuat → JANGAN munculkan loading
                                            if (res.status === "exist") {
                                                Swal.close();
                                                return;
                                            }

                                            Swal.close(); // tutup loading

                                            Swal.fire({
                                                icon: res.status ? "success" : "warning",
                                                title: res.status ? "Berhasil!" : "Peringatan!",
                                                text: res.msg,
                                                timer: 1000,
                                                showConfirmButton: false
                                            });

                                        },
                                        error: function() {

                                            Swal.close();

                                            Swal.fire({
                                                icon: "error",
                                                title: "Gagal!",
                                                text: "Terjadi kesalahan saat menyimpan data!",
                                                timer: 2500,
                                                showConfirmButton: false
                                            });
                                        }
                                    });
                                });

                                // === FILTER ADENDUM ===
                                $("#filterAddKategori").on("change", function() {

                                    let addKe = $(this).val();

                                    mirrorTable.ajax.url(
                                        "<?= base_url('administrator/transaksi/daftar_km/ctrl_daftar_km/get_hirarki_kontrak/'); ?>" +
                                        data.id_kontrak + "?add_ke=" + addKe
                                    ).load();
                                });
                                mirrorTable.on('draw.dt', function() {
                                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                                    tooltipTriggerList.map(function(el) {
                                        return new bootstrap.Tooltip(el);
                                    });
                                });
                                // setelah DataTable init / draw
                                $('[data-bs-toggle="tooltip"]').tooltip(); // inisialisasi
                                $('#mirrorTable').on('draw.dt', function() {
                                    $('[data-bs-toggle="tooltip"]').tooltip(); // re-init setelah redraw
                                });

                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Tidak dapat mengambil data kontrak!'
                                });
                            }
                        });

                    }

                });

        });

    });
</script>

<script>
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "dotnum-pre": function(a) {
            if (!a) return "000000000000";

            // Split by dot → convert each segment to padded fixed length
            return a.split('.')
                .map(x => ('0000' + x).slice(-4))
                .join('');
        },
        "dotnum-asc": function(a, b) {
            return a < b ? -1 : a > b ? 1 : 0;
        },
        "dotnum-desc": function(a, b) {
            return a < b ? 1 : a > b ? -1 : 0;
        }
    });
</script>