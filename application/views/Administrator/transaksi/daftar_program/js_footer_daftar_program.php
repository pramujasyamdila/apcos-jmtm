<!-- Jquery -->
<script src="<?= base_url(); ?>assets/template-custom/js/jquery-3.7.0.js"></script>

<!-- Bootstrap -->
<script src="<?= base_url('assets/admin_kintek_slash/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/admin_kintek_slash/js/date_time.js') ?>"></script>
<script src="<?= base_url('assets/admin_kintek_slash/js/global_element.js') ?>"></script>

<!-- DataTables Core -->
<script src="<?= base_url(); ?>assets/template-custom/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/template-custom/js/dataTables.bootstrap5.min.js"></script>


<!-- DataTables Responsive -->
<script src="<?= base_url(); ?>assets/template-custom/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/template-custom/js/responsive.bootstrap5.min.js"></script>


<!-- DataTables Buttons -->
<script src="<?= base_url(); ?>assets/template-custom/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/template-custom/js/buttons.bootstrap5.min.js"></script>

<script src="<?= base_url(); ?>assets/template-custom/js/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/template-custom/js/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/template-custom/js/vfs_fonts.js"></script>

<script src="<?= base_url(); ?>assets/template-custom/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/template-custom/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/template-custom/js/buttons.colVis.min.js"></script>


<!-- DataTables Init -->
<script src="<?= base_url(); ?>assets/template-custom/js/data_table5.js"></script>

<script src="<?= base_url(); ?>assets/template-custom/js/sweetalert2@11.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Tooltip
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(t => new bootstrap.Tooltip(t));

        document.getElementById("btnTambahAksi").addEventListener("click", function() {

            const btnTambah = this; // simpan tombol awal

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

                // ❌ Jika batal → tooltip tombol tambah must dispose
                if (result.dismiss === Swal.DismissReason.cancel) {

                    bootstrap.Tooltip.getInstance(btnTambah)?.dispose();

                    // optional notifikasi
                    Swal.fire({
                        icon: 'info',
                        title: 'Dibatalkan',
                        timer: 1000,
                        showConfirmButton: false,
                    });

                    return;
                }

                // ============================== 
                // IF CONFIRMED = YA, TAMBAHKAN
                // ==============================
                if (result.isConfirmed) {

                    const aksiCell = btnTambah.parentElement;

                    // hilangkan tombol tambah
                    btnTambah.style.display = "none";

                    // === BUTTON DETAIL ===
                    const btnDetail = document.createElement("button");
                    btnDetail.className = "btn btn-info btn-sm ms-1";
                    btnDetail.innerHTML = '<i class="fa-solid fa-circle-info"></i>';
                    btnDetail.setAttribute("data-bs-toggle", "tooltip");
                    btnDetail.setAttribute("title", "Lihat Detail");

                    // === BUTTON KEMBALI ===
                    const btnKembali = document.createElement("button");
                    btnKembali.className = "btn btn-warning btn-sm ms-1";
                    btnKembali.innerHTML = '<i class="fa-solid fa-rotate-left"></i>';
                    btnKembali.setAttribute("data-bs-toggle", "tooltip");
                    btnKembali.setAttribute("title", "Kembalikan ke tombol awal");

                    aksiCell.appendChild(btnDetail);
                    aksiCell.appendChild(btnKembali);

                    // === FUNGSI: BUKA MODAL FULLSCREEN ===
                    btnDetail.addEventListener("click", function() {
                        let modal = new bootstrap.Modal(document.getElementById(
                            "modalDetail"));
                        modal.show();
                    });

                    // === FUNGSI KEMBALI ===
                    btnKembali.addEventListener("click", function() {

                        // dispose tooltips
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

                    // RE-INIT TOOLTIP
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

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const table = document.querySelector('#modalDetail table.table-sm.table-bordered.table-striped');
        if (!table) return;

        // =====================
        // ELEMENT UTAMA
        // =====================
        const monthSelects = table.querySelectorAll('thead tr:nth-child(2) select');
        const rowNilai = table.querySelector('tbody tr:nth-of-type(1)');
        const rowPersen = table.querySelector('tbody tr:nth-of-type(2)');

        const nilaiInputs = rowNilai.querySelectorAll('td input');
        const persenInputs = rowPersen.querySelectorAll('td input');
        const totalInput = table.querySelector('tbody tr:nth-child(1) input#total');

        const kontrakInput = document.querySelector('#jml_kontrak');

        // ============================
        // KONVERSI FORMAT INDONESIA → NUMBER
        // ============================
        function toNumberIDR(v) {
            if (!v) return 0;

            return parseFloat(
                v.replace(/Rp/gi, "") // buang Rp
                .replace(/\s/g, "") // buang spasi
                .replace(/\./g, "") // buang ribuan
                .replace(",", ".") // koma → titik
            ) || 0;
        }

        // ============================
        // FORMAT ANGKA → 1.200,55
        // ============================
        function formatNumber(val) {
            if (val === "") return "";

            val = val.replace(/\./g, "");
            let parts = val.split(",");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return parts.join(",");
        }

        // ============================
        // HITUNG TOTAL BARIS 1
        // ============================
        function hitungTotal() {
            let total = 0;

            nilaiInputs.forEach(input => {
                if (input.id === "total" || input.disabled || input.value === "") return;

                let v = input.value.replace(/\./g, "").replace(",", ".");
                total += parseFloat(v);
            });

            totalInput.value = total.toLocaleString("id-ID", {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            });
        }

        // ============================
        // HITUNG PERSENTASE (SATUAN JUTA)
        // ============================
        function hitungPersen(i) {
            let nilaiJuta = toNumberIDR(nilaiInputs[i].value); // contoh: 5.000,50 → 5000.50
            let kontrak = toNumberIDR(kontrakInput.value); // Rp 900.000.000 → 900000000

            if (!nilaiJuta || !kontrak) {
                persenInputs[i].value = "";
                return;
            }

            // Konversi JUTA → RUPIAH
            let nilaiRupiah = nilaiJuta * 1000000;

            // Rumus persen
            let persen = (nilaiRupiah / kontrak) * 100;

            persenInputs[i].value = persen.toLocaleString("id-ID", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            console.log(
                "=== HITUNG PERSEN ===",
                "\nIndex:", i,
                "\nInput juta:", nilaiJuta,
                "\nNilai rupiah:", nilaiRupiah,
                "\nKontrak:", kontrak,
                "\nPersen:", persenInputs[i].value
            );
        }

        // ============================
        // DISABLE SEMUA INPUT AWAL
        // ============================
        nilaiInputs.forEach(input => {
            if (input.id !== "total") {
                input.setAttribute("disabled", true);
                input.style.backgroundColor = "#e9ecef";
                input.value = "";
            }
        });

        // ============================
        // SELECT → ENABLE / DISABLE INPUT
        // ============================
        monthSelects.forEach((selectEl, index) => {
            selectEl.addEventListener("change", function() {

                let inp = nilaiInputs[index];

                if (this.value == "3") {
                    inp.removeAttribute("disabled");
                    inp.style.backgroundColor = "white";
                } else {
                    inp.setAttribute("disabled", true);
                    inp.style.backgroundColor = "#e9ecef";
                    inp.value = "";
                    persenInputs[index].value = "";
                }

                hitungTotal();
                hitungPersen(index);
            });
        });

        // ============================
        // INPUT NILAI (format jutaan)
        // ============================
        nilaiInputs.forEach((input, index) => {

            if (input.id === "total") return;

            input.addEventListener("input", function() {

                if (input.disabled) {
                    input.value = "";
                    return;
                }

                // izinkan angka + koma
                let val = input.value.replace(/[^0-9,]/g, "");

                let parts = val.split(",");
                if (parts.length > 2) val = parts[0] + "," + parts[1];

                // max 2 digit di belakang koma
                if (parts[1] && parts[1].length > 2) {
                    parts[1] = parts[1].substring(0, 2);
                    val = parts.join(",");
                }

                input.value = formatNumber(val);

                hitungTotal();
                hitungPersen(index);
            });
        });

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const table = document.querySelector('#modalDetail table.table-sm.table-bordered.table-striped');
        if (!table) return;

        const monthSelects = table.querySelectorAll('thead tr:nth-child(2) select');
        const rowNilai = table.querySelector('tbody tr:nth-of-type(1)');
        const rowPersen = table.querySelector('tbody tr:nth-of-type(2)');

        const nilaiTDs = rowNilai.querySelectorAll('td');
        const persenTDs = rowPersen.querySelectorAll('td');

        const nilaiInputs = rowNilai.querySelectorAll('input');

        // ============================
        // FUNGSI MERGE
        // ============================
        function mergePraPengadaan() {

            // reset semua kolom agar kembali normal
            nilaiTDs.forEach(td => {
                td.style.display = "";
                td.removeAttribute("colspan");
            });

            persenTDs.forEach(td => {
                td.style.display = "";
                td.removeAttribute("colspan");
            });

            let start = -1; // awal blok pra-pengadaan
            let count = 0; // total kolom beruntun

            monthSelects.forEach((sel, idx) => {

                if (sel.value == "1") {
                    // mulai blok
                    if (start === -1) start = idx;
                    count++;
                } else {
                    // selesai blok
                    if (count >= 2) {
                        applyMerge(start, count);
                    }
                    start = -1;
                    count = 0;
                }

            });

            // check di akhir loop
            if (count >= 2) {
                applyMerge(start, count);
            }
        }

        // ============================
        // MENERAPKAN MERGER
        // ============================
        function applyMerge(start, count) {

            console.log("Merge kolom:", start, "sampai", start + count - 1);

            // Kolom yang akan ditampilkan hanya yang pertama
            const tdNilaiAwal = nilaiTDs[start];
            const tdPersenAwal = persenTDs[start];

            tdNilaiAwal.colSpan = count;
            tdPersenAwal.colSpan = count;

            // Kolom lain disembunyikan
            for (let i = start + 1; i < start + count; i++) {
                nilaiTDs[i].style.display = "none";
                persenTDs[i].style.display = "none";

                // Kosongkan inputnya
                nilaiInputs[i].value = "";
            }
        }

        // ============================
        // PANTAU PERUBAHAN SELECT
        // ============================
        monthSelects.forEach(sel => {
            sel.addEventListener("change", function() {
                mergePraPengadaan();
            });
        });

    });
</script>