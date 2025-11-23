<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ctrl_daftar_km extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form', 'string'));
		$this->load->model('Administrator/Transaksi/Md_daftar_km');
		$this->load->library(array('form_validation'));
		$this->db_kms = $this->load->database('db_kms', TRUE);
	}

	public function index()
	{
		$data['title'] = "DAFTAR KM";
		$this->load->view('Administrator/transaksi/daftar_km/js_header_daftar_km');
		$this->load->view('Administrator/temp_utama/vw_head_utama', $data);
		$this->load->view('Administrator/transaksi/daftar_km/vw_daftar_km', $data);
		$this->load->view('Administrator/temp_utama/vw_foot_utama');
		$this->load->view('Administrator/transaksi/daftar_km/js_footer_daftar_km');
		$this->load->view('Administrator/transaksi/daftar_km/ajax', $data);
	}

	public function get_kontrak_ajax()
	{
		$result = $this->db_kms->get('view_kontrak_sub_area')->result();
		echo json_encode($result);
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

	public function get_hirarki_kontrak($id_kontrak)
	{
		$add_ke = $this->input->get('add_ke') ?? 1;
		$draw   = intval($this->input->get("draw"));
		$start  = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		// ambil semua data tree (tanpa paging)
		$allData = $this->Md_daftar_km->generate_tree_fast($id_kontrak, $add_ke);
		$total   = count($allData);

		// paging manual
		$pagedData = array_slice($allData, $start, $length);

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $total,
			"recordsFiltered" => $total,
			"data" => $pagedData
		]);
	}


	public function get_list_adendum()
	{
		$id_kontrak = $this->input->get('id_kontrak');
		$data = $this->Md_daftar_km->get_adendum_by_kontrak($id_kontrak);
		echo json_encode($data);
	}
}
