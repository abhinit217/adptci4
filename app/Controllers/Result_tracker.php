<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Result_tracker extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('user_agent');
		$this->load->model('Usermanagement_model');

		$this->baseurl = base_url();
	}

	public function index(){
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}
		

		$this->db->distinct()->select('ly.*');
		if ($this->session->userdata('role') != 1) {
			$this->db->join('tbl_user_country_crop AS tucc', 'tucc.year_id = ly.year_id');
			$this->db->where('tucc.status', 1);
		}
		$this->db->where('ly.year_status', 1)->order_by('ly.year');
		$year_list = $this->db->get('lkp_year AS ly')->result_array();

		$result = array('year_list' => $year_list);

		$this->load->view('common/header');
		$this->load->view('dashboard/result_tracker_view', $result);
		$this->load->view('common/footer');
	}
	
	public function jsonify($array)
	{
		echo json_encode($array);
		exit();
	}

	public function get_program()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
		}

		$po = array();

		$year = $this->input->post('year');
		if (!$year) {
			$this->jsonify(array(
				'status' => 1,
				'pos' => $po
			));
		}
		
		$purpose = $this->input->post('purpose') ? $this->input->post('purpose') : 'reporting';
		switch ($purpose) {
			case 'reporting':
				// Get pos according to given user and year
				switch ($this->session->userdata('role')) {
					
					case 3:
					case 4:
					case 5:
					case 6:
						$this->db->distinct()->select('lp.*');
						$this->db->join('tbl_user_indicator AS tui', 'tui.lkp_program_id = lp.prog_id');
						$this->db->where('tui.user_id', $this->session->userdata('login_id'));
						$this->db->where('tui.status', 1)->where('tui.year_id', $year);
						$this->db->where('lp.status', 1)->order_by('lp.prog_name');
						$po = $this->db->get('tbl_program AS lp')->result_array();
						break;
				}
				break;

			case 'approval':
				// Get pos according to given user and year
				switch ($this->session->userdata('role')) {
					case 4:
					case 5:
					case 6:
						$this->db->distinct()->select('lp.*');
						$this->db->join('tbl_user_approval_indicator AS tua', 'tua.lkp_program_id = lp.prog_id');
						$this->db->where('tua.user_id', $this->session->userdata('login_id'));
						$this->db->where('tua.status', 1)->where('tua.year_id', $year);
						$this->db->where('lp.status', 1)->order_by('lp.prog_name');
						$po = $this->db->get('tbl_program AS lp')->result_array();
						break;
				}
				break;

			case 'review':
				// Get pos according to given user and year
				switch ($this->session->userdata('role')) {
					case 5:
					case 6:
						$this->db->distinct()->select('lp.*');
						$this->db->join('lkp_po AS lp', 'lp.po_id = rfr.lkp_program_id');
						$this->db->join('tbl_user_review AS tur', 'tur.year_id = rfr.lkp_year');
						$this->db->where('tur.user_id', $this->session->userdata('login_id'));
						if ($crop) $this->db->where('tur.crop_id', $crop);
						if ($country) $this->db->where('tur.country_id', $country);
						$this->db->where('tur.status', 1)->where('tur.year_id', $year);
						$this->db->where('lp.po_status', 1)->order_by('lp.po_name');
						$po = $this->db->get('rpt_form_relation AS rfr')->result_array();
						break;
				}
				break;

			case 'user_uploadinfo':
				// Get pos according to given user and year
				switch ($this->session->userdata('role')) {
					case 4:
					case 5:
					case 6:
						$this->db->distinct()->select('lp.*');
						$this->db->join('tbl_user_indicator AS tui', 'tui.po_id = lp.po_id');
						$this->db->where('tui.status', 1)->where('tui.year_id', $year);
						$this->db->where('lp.po_status', 1)->order_by('lp.po_name');
						$po = $this->db->get('lkp_po AS lp')->result_array();
						break;
				}
				break;

			case 'result_tracker':
				// Get pos according to given user and year
				switch ($this->session->userdata('role')) {
					case 3:
					case 4:
						$this->db->distinct()->select('lp.*');
						$this->db->join('tbl_user_indicator AS tui', 'tui.lkp_program_id = lp.prog_id');
						$this->db->where('tui.user_id', $this->session->userdata('login_id'));
						$this->db->where('tui.status', 1)->where('tui.year_id', $year);
						$this->db->where('lp.status', 1)->order_by('lp.prog_name');
						$po = $this->db->get('tbl_program AS lp')->result_array();
						
						break;

					case 5:
					case 6:
						$this->db->distinct()->select('lp.*');
						$this->db->join('tbl_user_indicator AS tui', 'tui.lkp_program_id = lp.prog_id');
						$this->db->where('tui.user_id', $this->session->userdata('login_id'));
						$this->db->where('tui.status', 1)->where('tui.year_id', $year);
						$this->db->where('lp.status', 1)->order_by('lp.prog_name');
						$po = $this->db->get('tbl_program AS lp')->result_array();
						break;
				}
				// echo $this->db->last_query();exit();
				break;
		}

		$this->jsonify(array(
			'status' => 1,
			'pos' => $po
		));
	}
	
	public function get_clusters()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
		}

		$clusters = array();

		$year = $this->input->post('year');
		$program = $this->input->post('program');
		if (!$year || !$program) {
			$this->jsonify(array(
				'status' => 1,
				'clusters' => $clusters
			));
		}
		
		$purpose = $this->input->post('purpose') ? $this->input->post('purpose') : 'reporting';
		switch ($purpose) {
			case 'reporting':
				// Get pos according to given user and year
				switch ($this->session->userdata('role')) {
					case 1:
						$this->db->select('GROUP_CONCAT(form_id) as clusterids');											
			            $this->db->where('rel.relation_status', 1)->where('rel.form_type', 1);
			            $this->db->where('rel.lkp_program_id', $program)->where('rel.indicator_id IS NULL')->where('lkp_year', $year);
			            $cluster_list = $this->db->get('rpt_form_relation as rel')->row_array();
						$cluster_list_array = explode(",", $cluster_list['clusterids']);

			            $this->db->select('tc.*');
			            $this->db->where('tc.cluster_status', 1)->where_in('tc.cluster_id', $cluster_list_array);
			            $clusters = $this->db->get('tbl_cluster AS tc')->result_array();

					case 3:
					case 4:
					case 5:
					case 6:
						
						// $this->db->select('GROUP_CONCAT(form_id) as clusterids');											
			            // $this->db->where('rel.relation_status', 1)->where('rel.form_type', 1);
			            // $this->db->where('rel.lkp_program_id', $program)->where('rel.lkp_cluster_id IS NULL')->where('rel.indicator_id IS NULL')->where('lkp_year', $year);
			            // $cluster_list = $this->db->get('rpt_form_relation as rel')->row_array();
						$this->db->select('GROUP_CONCAT(DISTINCT(lkp_cluster_id)) as clusterids');
						$this->db->where('tui.user_id', $this->session->userdata('login_id'))->where('tui.lkp_program_id', $program);
						$this->db->where('tui.status', 1)->where('tui.year_id', $year);	
						$cluster_list = $this->db->get('tbl_user_indicator as tui')->row_array();
						// print_r($this->db->last_query());

			            $cluster_list_array = explode(",", $cluster_list['clusterids']);

			            $this->db->select('tc.*');
			            $this->db->where('tc.cluster_status', 1)->where_in('tc.cluster_id', $cluster_list_array);
			            $clusters = $this->db->get('tbl_cluster AS tc')->result_array();
						break;
				}
				break;
		}

		$this->jsonify(array(
			'status' => 1,
			'clusters' => $clusters
		));
	}

	public function get_program_details()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
		}

		// if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 2) {
		if ($this->session->userdata('role') == 2) {
			$this->jsonify(array(
				'status' => 0
			));
		}

		$year = $this->input->post('year');
		$po = $this->input->post('program');
		$cluster = $this->input->post('cluster');
		$indicator = $this->input->post('indicator');

		if (!$po || !$year) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
		}
		
		$data = array(
			'year' => $year,
			'user_programs' => array(),
			'user_clusters' => array(),
			'user_indicators' => array(),
			'user_subindicators' => array()
		);
		$purpose = $this->input->post('purpose') ? $this->input->post('purpose') : 'reporting';
		switch ($purpose) {
			case 'reporting':
				// Get po details according to given user and year
				switch ($this->session->userdata('role')) {
					case 1:
						$cluster_list = array();
						$data['user_programs'] = $po;
						$data['user_clusters'] = explode(",", $this->input->post('cluster'));

						$this->db->select('GROUP_CONCAT(form_id) as indicatorids');											
			            $this->db->where('rel.relation_status', 1)->where('rel.form_type', 2);
			            $this->db->where('rel.lkp_program_id', $po)->where('rel.lkp_cluster_id',$cluster)->where('rel.indicator_id IS NULL')->where('lkp_year', $year);
			            $indicators = $this->db->get('rpt_form_relation as rel')->row_array();
						$data['user_indicators'] = explode(",", $indicators['indicatorids']);

						$this->db->distinct()->select('GROUP_CONCAT(sub_indicator_id) as subindicators');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'));
						$subindicators = $this->db->get('tbl_user_indicator')->row_array();
						$data['user_subindicators'] = explode(",", $subindicators['subindicators']);
						break;
					case 3:
					case 4:
					case 5:
					case 6:
						$cluster_list = array();
						$data['user_programs'] = $po;
						// $data['user_clusters'] = explode(",", $this->input->post('cluster'));
						$data['user_clusters'] =$this->input->post('cluster');
						// $this->db->distinct()->select('GROUP_CONCAT(id) as indicators');
						// $this->db->where('type', 2)->where('status', 1);
						// // $this->db->where('user_id', $this->session->userdata('login_id'));
						// $indicators = $this->db->get('form')->row_array();
						// $data['user_indicators'] = explode(",", $indicators['indicators']);

						/*$this->db->distinct()->select('GROUP_CONCAT(lkp_cluster_id) as clusters');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'));
						$clusters = $this->db->get('tbl_user_indicator')->row_array();
						$data['user_clusters'] = explode(",", $clusters['clusters']);*/
						

						$this->db->distinct()->select('GROUP_CONCAT(indicator_id) as indicators');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'));
						$indicators = $this->db->get('tbl_user_indicator')->row_array();
						$data['user_indicators'] = explode(",", $indicators['indicators']);
						

						$this->db->distinct()->select('GROUP_CONCAT(sub_indicator_id) as subindicators');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'));
						$subindicators = $this->db->get('tbl_user_indicator')->row_array();
						$data['user_subindicators'] = explode(",", $subindicators['subindicators']);
						break;
				}
				break;

			case 'approval':
				// Get po details according to given user and year
				switch ($this->session->userdata('role')) {
					case 4:
					case 5:
					case 6:
						$data['user_programs'] = $po;

						$this->db->distinct()->select('GROUP_CONCAT(lkp_cluster_id) as clusters');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'));
						$clusters = $this->db->get('tbl_user_approval_indicator')->row_array();
						$data['user_clusters'] = explode(",", $clusters['clusters']);

						$this->db->distinct()->select('GROUP_CONCAT(indicator_id) as indicators');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'));
						$indicators = $this->db->get('tbl_user_approval_indicator')->row_array();
						$data['user_indicators'] = explode(",", $indicators['indicators']);

						$this->db->distinct()->select('GROUP_CONCAT(sub_indicator_id) as subindicators');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'));
						$subindicators = $this->db->get('tbl_user_approval_indicator')->row_array();
						$data['user_subindicators'] = explode(",", $subindicators['subindicators']);
						break;
				}
				break;
		}
		$data['purpose'] = $purpose;
		$data['indicator'] = $indicator;
		
		$po_list = $this->Usermanagement_model->user_program_list($data);
		$this->jsonify(array(
			'status' => 1,
			'po_list' => $po_list
		));
	}

	public function get_indicator_list()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
		}

		$po = array();

		$year = $this->input->post('year');
		if (!$year) {
			$this->jsonify(array(
				'status' => 1,
				'pos' => $po
			));
		}
		$this->db->select('f.*');
		$this->db->where('f.status', 1)->like('f.title', 'Indicator ');
		$search_list = $this->db->get('form AS f')->result_array();
		foreach ($search_list as $key => $search) {
			$id = $search['id'];
			$name = $search['title'];
			// $name = substr($search['title'],0,90)."...";
			$po[] = array("id" => $id, "title" => $name);
		}

		$this->jsonify(array(
			'status' => 1,
			'pos' => $po
		));
	}
}