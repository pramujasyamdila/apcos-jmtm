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