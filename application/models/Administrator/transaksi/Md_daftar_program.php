<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_daftar_program extends CI_Model
{
    private $db_kms;

    public function __construct()
    {
        parent::__construct();
        $this->db_kms = $this->load->database('db_kms', TRUE);
    }

    /** GET parent table with pagination */
    public function get_program_datatable($id_kontrak, $search, $start, $length)
    {
        $this->db_kms->select('*');
        $this->db_kms->from('tbl_detail_program_penyedia_jasa');
        $this->db_kms->where('id_kontrak', $id_kontrak);

        if ($search != "") {
            $this->db_kms->group_start();
            $this->db_kms->like('nama_pekerjaan_program_mata_anggaran', $search);
            $this->db_kms->or_like('mata_anggaran_surat', $search);
            $this->db_kms->or_like('nama_penyedia', $search);
            $this->db_kms->group_end();
        }

        // Clone query for count
        $q = clone $this->db_kms;
        $recordsFiltered = $q->count_all_results('', false);

        $this->db_kms->limit($length, $start);
        $result = $this->db_kms->get()->result_array();

        return [
            'rows' => $result,
            'recordsFiltered' => $recordsFiltered
        ];
    }

    /** Count total rows */
    public function count_all($id_kontrak)
    {
        return $this->db_kms
            ->where('id_kontrak', $id_kontrak)
            ->count_all_results('tbl_detail_program_penyedia_jasa');
    }

    /** GET Sub detail */
    public function get_sub_detail($id_detail_program, $addendum)
    {
        $this->db_kms->select('*');
        $this->db_kms->from('tbl_sub_detail_program_penyedia_jasa');
        $this->db_kms->where('id_detail_program_penyedia_jasa', $id_detail_program);

        if ($addendum == 'kontrak_awal') {
            $this->db_kms->where('addendum_ke', 'kosong');
        }

        return $this->db_kms->get()->result_array();
    }
}
