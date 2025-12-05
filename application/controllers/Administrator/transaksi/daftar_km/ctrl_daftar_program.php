<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ctrl_daftar_program extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form', 'string'));
        $this->load->model('Administrator/Transaksi/Md_daftar_program');
        $this->load->library(array('form_validation'));
        $this->db_kms = $this->load->database('db_kms', TRUE);
    }

    public function index()
    {
        $data['title'] = "DAFTAR PROGRAM";
        $this->load->view('Administrator/transaksi/daftar_program/js_header_daftar_program');
        $this->load->view('Administrator/temp_utama/vw_head_utama', $data);
        $this->load->view('Administrator/transaksi/daftar_program/vw_daftar_program', $data);
        $this->load->view('Administrator/temp_utama/vw_foot_utama');
        $this->load->view('Administrator/transaksi/daftar_program/js_footer_daftar_program');
        $this->load->view('Administrator/transaksi/daftar_program/ajax', $data);
    }

    public function get_kontrak_by_no()
    {
        $no_kontrak     = $this->input->get('no_kontrak');
        $sub_area       = $this->input->get('sub_area');        // tambahan
        $tahun_anggaran = $this->input->get('tahun_anggaran');  // tambahan
        $this->db_kms->where('no_kontrak', $no_kontrak);
        $row = $this->db_kms->get('view_kontrak_sub_area_full')->row();
        echo json_encode([
            "params" => [
                "no_kontrak" => $no_kontrak,
                "sub_area" => $sub_area,
                "tahun_anggaran" => $tahun_anggaran
            ],
            "data" => $row
        ]);
    }

    public function get_nama_program($id_kontrak)
    {
        $draw   = intval($this->input->get("draw"));
        $start  = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $search = $this->input->get("search")["value"] ?? "";
        $result = $this->Md_daftar_program->get_program_datatable($id_kontrak, $search, $start, $length);
        $output = [];
        $no     = $start + 1;

        foreach ($result['rows'] as $row) {

            $subRows = $this->Md_daftar_program->get_sub_detail(
                $row['id_detail_program_penyedia_jasa'],
                $row['addendum_kontrak_penyedia_terpilih']
            );
            $aksi = '<button class="btn btn-sm btn-primary btnTambahAksi" data-id-kontrak="' . $row['id_detail_program_penyedia_jasa'] . '" data-bs-toggle="tooltip" title="Tambah Aksi"><i class="fa-solid fa-plus"></i></button>';
            // ---- Parent Row ----
            $output[] = [
                "no"        => "<b>$no</b>",
                "nama_program"      => "<b>{$row['nama_pekerjaan_program_mata_anggaran']}</b>",
                "anggaran"  => $row['mata_anggaran_surat'] ?: '-',
                "penyedia"  => $row['nama_penyedia'] ?: '-',
                "no_kontrak" => $row['no_surat_kontrak'] ?: '-',
                "nilai"     => number_format(($row['total_kontrak'] ?? 0), 2, ',', '.'),
                "aksi"      => $aksi
            ];

            // ---- Sub Rows ----
            foreach ($subRows as $sub) {

                $nilai_sub = isset($row['addendum_kontrak_penyedia_terpilih']) && $row['addendum_kontrak_penyedia_terpilih'] !== 'kontrak_awal'
                    ? $sub['nilai_sub_kontrak_penyedia_addendum_' . $row['addendum_kontrak_penyedia_terpilih']]
                    : $sub['nilai_sub_kontrak_penyedia'];

                $output[] = [
                    "no"        => "",
                    "nama_sub"      => '<span style="padding-left:25px">↳ ' . $sub['nama_program_mata_anggaran'] . '</span>',
                    "anggaran"  => "",
                    "penyedia"  => "",
                    "no_kontrak" => "",
                    "nilai"     => "Rp " . number_format($nilai_sub, 2, ',', '.'),
                    "aksi"      => ""
                ];
            }

            $no++;
        }

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $this->Md_daftar_program->count_all($id_kontrak),
            "recordsFiltered" => $result['recordsFiltered'],
            "data" => $output
        ]);
    }
}
