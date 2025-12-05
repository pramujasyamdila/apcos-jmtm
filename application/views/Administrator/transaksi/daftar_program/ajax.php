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


                                // destroy dulu sebelum init ulang
                                if ($.fn.DataTable.isDataTable('#mirrorTable')) {
                                    $('#mirrorTable').DataTable().clear().destroy();
                                }
                                let table = $('#mirrorTable').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    paging: true,
                                    searching: true,
                                    ajax: {
                                        url: "<?= base_url('administrator/transaksi/daftar_km/ctrl_daftar_program/get_nama_program/'); ?>" + data.id_kontrak,
                                        type: "GET"
                                    },
                                    columns: [{
                                            data: 'no',
                                            className: 'text-center'
                                        },
                                        {
                                            data: 'nama',

                                        },
                                        {
                                            data: 'anggaran',
                                            className: 'text-center'
                                        },
                                        {
                                            data: 'penyedia',
                                            className: 'text-center'
                                        },
                                        {
                                            data: 'no_kontrak',
                                            className: 'text-center'
                                        },
                                        {
                                            data: 'nilai',
                                            className: 'text-end fw-bold'
                                        },
                                        {
                                            data: 'aksi',
                                            className: 'text-center'
                                        }
                                    ],
                                    createdRow: function(row, data) {
                                        if (data.no === "") {
                                            $(row).addClass('bg-warning bg-opacity-25');
                                        }
                                    }
                                });


                                // Refresh tooltip on redraw
                                mirrorTable.on('draw', function() {
                                    $('[data-bs-toggle="tooltip"]').tooltip();
                                });

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
                                    Swal.fire({
                                        title: "Generate Data...",
                                        html: "Mohon tunggu sebentar...",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });

                                    function hitungPersen(i) {

                                        // Karena field form pakai 1–12, bukan 0–11
                                        let idx = i + 1;

                                        let nilaiInput = $(`[name="nilai_rencana_${idx}"]`).val();

                                        // Jika user isi 0 → persen tetap 0,00
                                        if (nilaiInput.trim() === "") {
                                            $(`[name="persentase_rencana_${idx}"]`).val("");
                                            return;
                                        }

                                        // convert "5,27" → 5.27 (juta)
                                        let nilaiJuta = parseFloat(
                                            nilaiInput.replace(/\./g, "").replace(",", ".")
                                        );

                                        // Jika NaN, anggap 0
                                        if (isNaN(nilaiJuta)) nilaiJuta = 0;

                                        // convert juta → rupiah
                                        let nilaiRupiah = nilaiJuta * 1000000;

                                        // kontrak dalam rupiah → misal "Rp 28.500.000.000"
                                        let kontrak = parseFloat(
                                            $("#jml_kontrak").val()
                                            .replace(/Rp|\s|\./g, "")
                                            .replace(",", ".")
                                        );

                                        if (isNaN(kontrak) || kontrak <= 0) {
                                            $(`[name="persentase_rencana_${idx}"]`).val("");
                                            return;
                                        }

                                        // hitung persen
                                        let persen = (nilaiRupiah / kontrak) * 100;

                                        // tampilkan dengan koma
                                        $(`[name="persentase_rencana_${idx}"]`).val(
                                            persen.toFixed(2).replace(".", ",")
                                        );
                                    }


                                    function hitungSemuaPersen() {
                                        for (let i = 0; i < 12; i++) {
                                            hitungPersen(i);
                                        }
                                    }



                                    $.ajax({
                                        url: "<?= base_url('administrator/transaksi/daftar_km/ctrl_daftar_km/save_daftar_km'); ?>",
                                        type: "POST",
                                        data: JSON.stringify(formData),
                                        contentType: "application/json",
                                        dataType: "json",
                                        success: function(res) {
                                            if (res.detail) {
                                                window.addendumData = res.detail;
                                                let dropdown = $("#add-kontrak");
                                                dropdown.empty();
                                                dropdown.append(`<option disabled selected value="">Pilih Kontrak / Addendum</option>`);

                                                res.detail.forEach((item, index) => {
                                                    dropdown.append(`<option value="${index}">${item.label}</option>`);
                                                });

                                                function formatRP(v) {
                                                    return "Rp " + v.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                                }
                                                dropdown.off("change").on("change", function() {

                                                    let idx = $(this).val();
                                                    let selected = addendumData[idx];

                                                    // Update input kontrak
                                                    $("#jml_kontrak").val(formatRP(selected.nilai_proyek));

                                                    // ===== AJAX REQUEST KE SERVER UNTUK GET RENCANA BULAN =====
                                                    $.ajax({
                                                        url: "<?= base_url('administrator/transaksi/daftar_km/ctrl_daftar_km/get_rencana_km'); ?>",
                                                        type: "POST",
                                                        data: JSON.stringify({
                                                            kode_detail: selected.kode_daftar_km
                                                        }),
                                                        contentType: "application/json",
                                                        dataType: "json",

                                                        success: function(resMonth) {
                                                            if (resMonth.status) {

                                                                // SET KODE DETAIL
                                                                $('[name="kode_detail_daftar_km_update"]').val(selected.kode_daftar_km);

                                                                // 🔥 INI YANG PENTING – DEFINE BAHWA "bulan" = data bulan dari API
                                                                let bulan = resMonth.data;

                                                                // LIST NAMA BULAN
                                                                let monthMap = [
                                                                    "januari", "februari", "maret", "april", "mei", "juni",
                                                                    "juli", "agustus", "september", "oktober", "november", "desember"
                                                                ];

                                                                monthMap.forEach((nama, i) => {


                                                                    // ================================
                                                                    // KONVERSI RUPIAH → JUTA (FORMAT USER)
                                                                    // ================================
                                                                    let nilaiDB = bulan[nama].nilai_rencana || 0; // SUDAH DALAM JUTA LANGSUNG
                                                                    let nilaiFormatted = nilaiDB.toString().replace(".", ",");


                                                                    // STATUS BULAN
                                                                    let status = bulan[nama].sts_bulan || "0";

                                                                    // UPDATE SELECT STATUS
                                                                    $(`[name="sts_bulan_${i+1}"]`).val(status);

                                                                    // ================================
                                                                    // LOGIKA ENABLE / DISABLE INPUT NILAI
                                                                    // ================================
                                                                    if (status == "3") {

                                                                        // saat PELAKSANAAN → nilai harus DITAMPILKAN dan bisa diedit
                                                                        $(`[name="nilai_rencana_${i+1}"]`)
                                                                            .prop("disabled", false)
                                                                            .css("background-color", "white")
                                                                            .val(nilaiFormatted);

                                                                    } else {

                                                                        // selain pelaksanaan → nilai TETAP DITAMPILKAN tapi readonly
                                                                        $(`[name="nilai_rencana_${i+1}"]`)
                                                                            .prop("disabled", true)
                                                                            .css("background-color", "#e9ecef")
                                                                            .val(nilaiFormatted);

                                                                    }

                                                                    // ================================
                                                                    // PERSENTASE RENCANA KEMBALI DARI DB (APA ADANYA)
                                                                    // ================================
                                                                    let persenDB = bulan[nama].persentase_rencana;

                                                                    if (persenDB !== null && persenDB !== "") {
                                                                        persenDB = persenDB.toString().replace(".", ",");
                                                                    } else {
                                                                        persenDB = "";
                                                                    }

                                                                    $(`[name="persentase_rencana_${i+1}"]`).val(persenDB);

                                                                });

                                                                setTimeout(() => {
                                                                    hitungSemuaPersen();
                                                                }, 50);


                                                            }
                                                        }
                                                    });


                                                });
                                                dropdown.val(res.detail.length - 1).trigger("change");
                                            }
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