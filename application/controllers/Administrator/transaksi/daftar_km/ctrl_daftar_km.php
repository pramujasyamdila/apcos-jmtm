<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ctrl_daftar_km extends CI_Controller
{
	// angga
	public function index()
	{
		$this->load->view('Administrator/transaksi/daftar_km/js_header_daftar_km');
		$this->load->view('Administrator/temp_utama/vw_head_utama');
		$this->load->view('Administrator/transaksi/daftar_km/vw_daftar_km');
		$this->load->view('Administrator/temp_utama/vw_foot_utama');
		$this->load->view('Administrator/transaksi/daftar_km/js_footer_daftar_km');
	}
}