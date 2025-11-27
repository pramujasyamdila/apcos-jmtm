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
		$search = $this->input->get('search')['value'] ?? '';

		// ambil semua data tree
		$allData = $this->Md_daftar_km->generate_tree_fast($id_kontrak, $add_ke);

		// FILTER DATA (biar search DataTables bekerja)
		if (!empty($search)) {
			$allData = array_filter($allData, function ($row) use ($search) {
				$search = strtolower($search);
				return (isset($row['nama_program']) && strpos(strtolower($row['nama_program']), $search) !== false) ||
					(isset($row['awal']) && strpos(strtolower((string)$row['awal']), $search) !== false) ||
					(isset($row['add_val']) && strpos(strtolower((string)$row['add_val']), $search) !== false);
			});
		}

		$totalFiltered = count($allData);

		// paging manual
		$pagedData = array_slice(array_values($allData), $start, $length);

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $totalFiltered,
			"recordsFiltered" => $totalFiltered,
			"data" => $pagedData
		]);
	}


	public function get_list_adendum()
	{
		$id_kontrak = $this->input->get('id_kontrak');
		$data = $this->Md_daftar_km->get_adendum_by_kontrak($id_kontrak);
		echo json_encode($data);
	}


	public function save_daftar_km()
	{
		$post = json_decode($this->input->raw_input_stream, true);

		if (!$post || !$post['id_kontrak']) {
			echo json_encode(["status" => "error", "msg" => "Data tidak lengkap!"]);
			return;
		}

		$post['detail_json'] = json_encode($post['detail_addendum']);
		$result = $this->Md_daftar_km->run_sp_daftar_km($post);

		$kode = $this->Md_daftar_km->row_kode_daftar_km($post['id_kontrak'], $post['level_daftar_km']);

		$addendum = $this->Md_daftar_km->getDetailByKodeDaftarKM($kode['kode_daftar_km']);
		echo json_encode([
			"status" => "success",
			"msg"    => $result["msg"],
			"detail" => $addendum
		]);
		return;

		echo json_encode(["status" => strtolower($result["STATUS"]), "msg" => $result["msg"]]);
	}

	public function get_rencana_km()
	{
		$post = json_decode($this->input->raw_input_stream, true);

		if (!$post || !isset($post['kode_detail'])) {
			echo json_encode(["status" => false, "msg" => "Parameter tidak valid"]);
			return;
		}

		$data = $this->Md_daftar_km->getRencanaByDetail($post['kode_detail']);

		$data = $this->Md_daftar_km->getRencanaByDetail($post['kode_detail']);

		echo json_encode([
			"status" => true,
			"data" => $data
		]);
	}




	// public function save_daftar_km()
	// {
	// 	$post = json_decode($this->input->raw_input_stream, true);

	// 	if (!$post || !$post['id_kontrak']) {
	// 		echo json_encode(["status" => false, "msg" => "Data tidak lengkap"]);
	// 		return;
	// 	}

	// 	// === CEK SUDAH ADA ===
	// 	if ($this->Md_daftar_km->cekSudahAda($post['id_kontrak'], $post['level_daftar_km']) > 0) {

	// 		echo json_encode([
	// 			"status" => "exist",
	// 			"msg" => "Data untuk Level KM ini sudah pernah disimpan sebelumnya."
	// 		]);
	// 		return;
	// 	}

	// 	// === Generate kode utama ===
	// 	$kode_daftar_km = $this->Md_daftar_km->generateKode("tbl_daftar_km", "kode_daftar_km", "KM-");

	// 	// INSERT MASTER
	// 	$this->Md_daftar_km->insert_main([
	// 		'kode_daftar_km' => $kode_daftar_km,
	// 		'id_kontrak' => $post['id_kontrak'],
	// 		'nomor_kontrak' => $post['nomor_kontrak'],
	// 		'nama_kontrak' => $post['nama_kontrak'] ?? null,
	// 		'tanggal_kontrak' => $post['tanggal_kontrak'],
	// 		'tahun_anggaran' => $post['tahun_anggaran'],
	// 		'add_terupdate' => $post['add_terupdate'],
	// 		'nilai_addendum_terupdate' => $post['nilai_addendum_terupdate'],
	// 		'level_daftar_km' => $post['level_daftar_km'],
	// 		'nama_program_daftar_km' => $post['nama_program'],
	// 	]);

	// 	// === LOOP DETAIL ADDENDUM ===
	// 	foreach ($post['detail_addendum'] as $add) {

	// 		$kode_detail = $this->Md_daftar_km->generateKode("tbl_detail_daftar_km", "kode_detail_daftar_km", "KD-");

	// 		$this->Md_daftar_km->insert_detail([
	// 			'kode_detail_daftar_km' => $kode_detail,
	// 			'kode_daftar_km' => $kode_daftar_km,
	// 			'level' => $post['level_daftar_km'],
	// 			'nama_program' => $post['nama_program'],
	// 			'keterangan_kontrak' => ($add['no'] == 0 ? "Kontrak Awal" : "Addendum " . $add['romawi']),
	// 			'nilai_proyek' => $add['nilai']
	// 		]);

	// 		// Insert 12 bulan
	// 		for ($bulan = 1; $bulan <= 12; $bulan++) {
	// 			$kode_rencana = $this->Md_daftar_km->generateKode(
	// 				"tbl_detail_rencana_km",
	// 				"kode_detail_rencana_km",
	// 				"RN-"
	// 			);

	// 			$this->Md_daftar_km->insert_rencana([
	// 				'kode_detail_rencana_km' => $kode_rencana,
	// 				'kode_detail_daftar_km' => $kode_detail,
	// 				'bulan' => $bulan,
	// 			]);
	// 		}
	// 	}

	// 	// ==== Ambil ulang data addendum untuk dikirim ke frontend ====
	// 	$detail = $this->Md_daftar_km->getDetailByKodeDaftarKM($kode_daftar_km);

	// 	echo json_encode([
	// 		"status" => true,
	// 		"msg" => "Data tersimpan!",
	// 		"kode" => $kode_daftar_km,
	// 		"detail" => $detail   // <-- ini yang dipakai update UI
	// 	]);
	// }
}
