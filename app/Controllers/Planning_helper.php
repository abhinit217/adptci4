<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Planning_helper extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('user_agent');
		$this->load->model('UsermanagementPlanning_model');

		$this->baseurl = base_url();
	}

	public function get_country()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
		}

		$country = array();

		$year = $this->input->post('year');
		if (!$year) {
			$this->jsonify(array(
				'status' => 1,
				'countries' => $country
			));
		}

		if(isset($_POST['search_user'])){
			// Get countries according to given user and year
			$this->db->distinct()->select('lc.*');
			$this->db->join('lkp_country_crop AS lcc', 'lcc.country_id = lc.country_id');
			$this->db->where('lcc.status', 1)->where('lcc.year_id', $year);
			$this->db->where('lc.status', 1)->order_by('lc.country_name');
			$country = $this->db->get('lkp_country AS lc')->result_array();
			
			$selected = 0;
			if ($this->session->has_userdata('dash_country') && $this->session->userdata('dash_country') != '')
				$selected  = $this->session->userdata('dash_country');
		}else{
			// Get countries according to given user and year
			$this->db->distinct()->select('lc.*');
			$this->db->join('tbl_user_planning AS tucc', 'tucc.country_id = lc.country_id');
			$this->db->where('tucc.status', 1)->where('tucc.year_id', $year);
			$this->db->where('tucc.user_id', $this->session->userdata('login_id'));
			$this->db->where('lc.status', 1)->order_by('lc.country_name');
			$country = $this->db->get('lkp_country AS lc')->result_array();
			
			$selected = 0;
			if ($this->session->has_userdata('dash_country') && $this->session->userdata('dash_country') != '')
				$selected  = $this->session->userdata('dash_country');
		}

		$result = array(
			'status' => 1,
			'countries' => $country,
			'selected' => $selected
		);

		
		$this->jsonify($result);
	}

	public function get_crop(){
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
		}

		$crop = array();

		$year = $this->input->post('year');
		$country = $this->input->post('country');
		if (!$year) {
			$this->jsonify(array(
				'status' => 1,
				'crops' => $crop
			));
		}
		$this->session->set_userdata('dash_country', $country);

		if(isset($_POST['search_user'])){
			// Get crops according to given user and year
			$this->db->distinct()->select('lc.*, lcou.country_id, lcou.country_name')->from('lkp_crop AS lc');
			$this->db->join('lkp_country_crop AS lcc', 'lcc.crop_id = lc.crop_id');
			$this->db->join('lkp_country AS lcou', 'lcc.country_id = lcou.country_id');
			if ($country) {
				if(is_array($country)) $this->db->where_in('lcc.country_id', $country);
				else $this->db->where('lcc.country_id', $country);
			}
			$this->db->where('lcc.year_id', $year)->where('lcc.status', 1);
			$this->db->where('lc.crop_status', 1)->order_by('lc.crop_name');
			$crop = $this->db->get()->result_array();
			
			$selected = 0;
			if ($this->session->has_userdata('dash_crop') && $this->session->userdata('dash_crop') != '')
				$selected  = $this->session->userdata('dash_crop');
		}else{
			// Get crops according to given user and year
			$this->db->distinct()->select('lc.*')->from('lkp_crop AS lc');
			$this->db->join('tbl_user_planning AS tucc', 'tucc.crop_id = lc.crop_id');
			if ($country) {
				if(is_array($country)) $this->db->where_in('tucc.country_id', $country);
				else $this->db->where('tucc.country_id', $country);
			}
			$this->db->where('tucc.year_id', $year)->where('tucc.status', 1);
			$this->db->where('tucc.user_id', $this->session->userdata('login_id'));
			$this->db->where('lc.crop_status', 1)->order_by('lc.crop_name');
			$crop = $this->db->get()->result_array();
			
			$selected = 0;
			if ($this->session->has_userdata('dash_crop') && $this->session->userdata('dash_crop') != '')
				$selected  = $this->session->userdata('dash_crop');

		}			

		$result = array(
			'status' => 1,
			'crops' => $crop,
			'selected' => $selected,
		);
		$this->jsonify($result);
	}

	public function get_po(){
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
		}

		$po = array();

		$country = $this->input->post('country');
		$crop = $this->input->post('crop');
		$year = $this->input->post('year');
		if (!$year) {
			$this->jsonify(array(
				'status' => 1,
				'pos' => $po
			));
		}
		if ($crop != '')
			$this->session->set_userdata('dash_crop', $crop);

		$this->db->distinct()->select('lp.*');
		$this->db->where('lp.po_status', 1)->order_by('lp.po_name');
		$pos = $this->db->get('lkp_po AS lp')->result_array();
		foreach ($pos as $key => $po) {
			$this->db->where('user_id', $this->input->post('search_user'));
			$this->db->where('status', 1)->where('year_id', $year);
			$this->db->where('po_id', $po['po_id']);
			if ($country) {
				if(is_array($country)) $this->db->where_in('country_id', $country);
				else $this->db->where('country_id', $country);
			}
			if ($crop) {
				if(is_array($crop)) $this->db->where_in('crop_id', $crop);
				else $this->db->where('crop_id', $crop);
			}
			$assigned = $this->db->get('tbl_user_planning')->num_rows();
			$pos[$key]['assigned'] = $assigned;
		}

		$this->jsonify(array(
			'status' => 1,
			'pos' => $pos
		));
	}

	public function getUserAssignedPos(){
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
		}

		$country = $this->input->post('country');
		$crop = $this->input->post('crop');
		$year = $this->input->post('year');

		$this->db->select('GROUP_CONCAT(distinct po_id) as po_ids');
		$this->db->where('year_id', $year)->where('status', 1);
		$this->db->where('country_id', $country);
		$this->db->where('crop_id', $crop);
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$userpos = $this->db->get('tbl_user_planning')->row_array();
		$user_outputs = explode(",", $userpos['po_ids']);

		$this->db->distinct()->select('lp.*');
		$this->db->where_in('lp.po_id', $user_outputs);
		$this->db->where('lp.po_status', 1)->order_by('lp.po_name');
		$pos = $this->db->get('lkp_po AS lp')->result_array();

		$this->jsonify(array(
			'status' => 1,
			'pos' => $pos
		));
	}

	public function get_po_details(){
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
		}

		if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 2) {
			$this->jsonify(array(
				'status' => 0
			));
		}

		$po = $this->input->post('po');
		$year = $this->input->post('year');
		$country = $this->input->post('country');
		$crop = $this->input->post('crop');
		if (!$po || !$year) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
		}
		if ($crop != '')
			$this->session->set_userdata('dash_crop', $crop);
		$data = array(
			'year' => $year,
			'user_pos' => array(),
			'user_outputs' => array(),
			'user_indicators' => array(),
			'user_subindicators' => array()
		);

		$purpose = $this->input->post('purpose') ? $this->input->post('purpose') : 'reporting';
		switch ($this->session->userdata('role')) {
			case 3:
			case 4:
			case 5:
			case 6:
				$data['user_pos'] = $po;

				$this->db->distinct()->select('GROUP_CONCAT(output_id) as outputs');
				$this->db->where('year_id', $year)->where('status', 1);
				$this->db->where('user_id', $this->session->userdata('login_id'));
				// ->where('indicator_id IS NULL')->where('sub_indicator_id IS NULL');
				$outputs = $this->db->get('tbl_user_indicator')->row_array();
				$data['user_outputs'] = explode(",", $outputs['outputs']);

				$this->db->distinct()->select('GROUP_CONCAT(indicator_id) as indicators');
				$this->db->where('year_id', $year)->where('status', 1);
				$this->db->where('user_id', $this->session->userdata('login_id'));
				// ->where('sub_indicator_id IS NULL');
				$indicators = $this->db->get('tbl_user_indicator')->row_array();
				$data['user_indicators'] = explode(",", $indicators['indicators']);

				$this->db->distinct()->select('GROUP_CONCAT(sub_indicator_id) as subindicators');
				$this->db->where('year_id', $year)->where('status', 1);
				$this->db->where('user_id', $this->session->userdata('login_id'));
				$subindicators = $this->db->get('tbl_user_indicator')->row_array();
				$data['user_subindicators'] = explode(",", $subindicators['subindicators']);
				break;
		}
		$data['purpose'] = $purpose;
		$data['year'] = $year;
		$data['country'] = $country;
		$data['crop'] = $crop;
		$po_list = $this->UsermanagementPlanning_model->user_po_list($data);
		$this->jsonify(array(
			'status' => 1,
			'po_list' => $po_list
		));
	}

	public function jsonify($array)
	{
		echo json_encode($array);
		exit();
	}
}
