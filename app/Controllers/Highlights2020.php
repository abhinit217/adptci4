<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Highlights2020 extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('user_agent');

		$this->baseurl = base_url();
	}

	public function index()
	{
		// if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
		// 	redirect($this->baseurl);
		// }

		$this->load->view('common/header');
		$this->load->view('key_highlight/key_highlight');
		$this->load->view('common/footer');
	}
}