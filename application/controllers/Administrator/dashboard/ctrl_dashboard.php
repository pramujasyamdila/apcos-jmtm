<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ctrl_dashboard extends CI_Controller
{
	// angga
	public function index()
	{
		$this->load->view('Administrator/dashboard/js_header_dashboard');
		$this->load->view('Administrator/temp_utama/vw_head_utama');
		$this->load->view('Administrator/dashboard/vw_dashboard');
		$this->load->view('Administrator/temp_utama/vw_foot_utama');
		$this->load->view('Administrator/dashboard/js_footer_dashboard');
	}
}