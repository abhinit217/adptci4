<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helper extends CI_Controller
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

		$purpose = $this->input->post('purpose') ? $this->input->post('purpose') : 'reporting';
		switch ($purpose) {
			case 'reporting':
				$joinTable = 'tbl_user_country_crop';
				break;

			case 'approval':
				$joinTable = 'tbl_user_approval_country_crop';
				break;

			case 'review':
				$joinTable = 'tbl_user_review';
				break;
		}

		// Get countries according to given user and year
		if($purpose == 'monitoring_evaluation'){
			$this->db->distinct()->select('lc.*');
			$this->db->join('lkp_country_crop AS lcc', 'lcc.country_id = lc.country_id');
			$this->db->where('lcc.status', 1)->where('lcc.year_id', $year);
			$this->db->where('lc.status', 1)->order_by('lc.country_name');
			$country = $this->db->get('lkp_country AS lc')->result_array();
		}else{
			switch ($this->session->userdata('role')) {
				case 1:
				case 2:
					$this->db->distinct()->select('lc.*');
					$this->db->join('lkp_country_crop AS lcc', 'lcc.country_id = lc.country_id');
					$this->db->where('lcc.status', 1)->where('lcc.year_id', $year);
					$this->db->where('lc.status', 1)->order_by('lc.country_name');
					$country = $this->db->get('lkp_country AS lc')->result_array();
					break;

				case 3:
				case 4:
				case 5:
				case 6:
					$this->db->distinct()->select('lc.*');
					$this->db->join($joinTable . ' AS tucc', 'tucc.country_id = lc.country_id');
					$this->db->where('tucc.status', 1)->where('tucc.year_id', $year);
					$this->db->where('tucc.user_id', $this->session->userdata('login_id'));
					$this->db->where('lc.status', 1)->order_by('lc.country_name');
					$country = $this->db->get('lkp_country AS lc')->result_array();
					break;
			}
		}
		$selected = 0;
		if ($this->session->has_userdata('dash_country') && $this->session->userdata('dash_country') != '')
			$selected  = $this->session->userdata('dash_country');
		$result = array(
			'status' => 1,
			'countries' => $country,
			'selected' => $selected
		);

		if(isset($_POST['search_user'])){
			$user_id = $this->input->post('search_user');
			$type = $this->input->post('type');
			if($type == 'approval'){
				$table_name = "tbl_user_approval_indicator";
			}else{
				$table_name = "tbl_user_indicator";
			}

			$this->db->distinct();
			$this->db->select('GROUP_CONCAT(cc.country_id) as country_ids');
			$this->db->join('lkp_country as cou', 'cou.country_id = cc.country_id');
			$this->db->join('lkp_crop as crop', 'crop.crop_id = cc.crop_id');
			$this->db->where('user_id', $user_id);
			$this->db->where('cc.status', 1);
			switch ($type) {
				case 'approval':
					$user_countryinfo = $this->db->get('tbl_user_approval_country_crop as cc')->row_array();
					break;

				case 'review':
					$user_countryinfo = $this->db->get('tbl_user_review as cc')->row_array();
					break;
				
				default:
					$user_countryinfo = $this->db->get('tbl_user_country_crop as cc')->row_array();
					break;
			}
			$result['user_countryinfo'] = explode(",", $user_countryinfo['country_ids']);
		}
		$this->jsonify($result);
	}
	public function get_crop()
	{
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
		$purpose = $this->input->post('purpose') ? $this->input->post('purpose') : 'reporting';
		switch ($purpose) {
			case 'reporting':
				$joinTable = 'tbl_user_country_crop';
				break;

			case 'approval':
				$joinTable = 'tbl_user_approval_country_crop';
				break;

			case 'review':
				$joinTable = 'tbl_user_review';
				break;
		}

		// Get crops according to given user and year
		if($purpose == 'monitoring_evaluation'){
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
		}else{
			switch ($this->session->userdata('role')) {
				case 1:
				case 2:
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
					break;

				case 3:
				case 4:
				case 5:
				case 6:
					$this->db->distinct()->select('lc.*')->from('lkp_crop AS lc');
					$this->db->join($joinTable . ' AS tucc', 'tucc.crop_id = lc.crop_id');
					if ($country) {
						if(is_array($country)) $this->db->where_in('tucc.country_id', $country);
						else $this->db->where('tucc.country_id', $country);
					}
					$this->db->where('tucc.year_id', $year)->where('tucc.status', 1);
					$this->db->where('tucc.user_id', $this->session->userdata('login_id'));
					$this->db->where('lc.crop_status', 1)->order_by('lc.crop_name');
					$crop = $this->db->get()->result_array();
					break;
			}
		}
		$selected = 0;
		if ($this->session->has_userdata('dash_crop') && $this->session->userdata('dash_crop') != '')
			$selected  = $this->session->userdata('dash_crop');

		$result = array(
			'status' => 1,
			'crops' => $crop,
			'selected' => $selected,
		);

		if(isset($_POST['search_user'])){
			$user_id = $this->input->post('search_user');
			$type = $this->input->post('type');
			if($type == 'approval'){
				$table_name = "tbl_user_approval_indicator";
			}else{
				$table_name = "tbl_user_indicator";
			}

			$this->db->distinct();
			$this->db->select('cc.country_id, cc.crop_id, cou.country_name, crop.crop_name');
			$this->db->join('lkp_country as cou', 'cou.country_id = cc.country_id');
			$this->db->join('lkp_crop as crop', 'crop.crop_id = cc.crop_id');
			$this->db->where('user_id', $user_id);
			$this->db->where('cc.status', 1);
			switch ($type) {
				case 'approval':
					$user_cropinfo = $this->db->get('tbl_user_approval_country_crop as cc')->result_array();
					break;

				case 'review':
					$user_cropinfo = $this->db->get('tbl_user_review as cc')->result_array();
					break;
				
				default:
					$user_cropinfo = $this->db->get('tbl_user_country_crop as cc')->result_array();
					break;
			}
			$result['user_cropinfo'] = $user_cropinfo;
		}
		$this->jsonify($result);
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

		if (!$po || !$year) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
		}
		
		$data = array(
			'year' => $year,
			'type' => 'report',
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
					case 3:
					case 4:
					case 5:
					case 6:
						$cluster_list = array();
						$data['user_programs'] = $po;
						$data['user_clusters'] = explode(",", $this->input->post('cluster'));
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
						$this->db->where('year_id', $year)->where('status', 1)->where_in('lkp_cluster_id', $this->input->post('cluster'));
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
						$this->db->where('lkp_cluster_id', $cluster);
						$clusters = $this->db->get('tbl_user_approval_indicator')->row_array();
						$data['user_clusters'] = explode(",", $clusters['clusters']);

						$this->db->distinct()->select('GROUP_CONCAT(indicator_id) as indicators');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'));
						$this->db->where('lkp_cluster_id', $cluster);
						$indicators = $this->db->get('tbl_user_approval_indicator')->row_array();
						$data['user_indicators'] = explode(",", $indicators['indicators']);

						$this->db->distinct()->select('GROUP_CONCAT(sub_indicator_id) as subindicators');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'));
						$this->db->where('lkp_cluster_id', $cluster);
						$subindicators = $this->db->get('tbl_user_approval_indicator')->row_array();
						$data['user_subindicators'] = explode(",", $subindicators['subindicators']);
						break;
				}
				break;
		}
		$data['purpose'] = $purpose;
		
		$po_list = $this->Usermanagement_model->user_program_list_d($data);
		$this->jsonify(array(
			'status' => 1,
			'po_list' => $po_list,
			'year' => $year
		));
	}

	public function get_po_details_counter()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
		}

		$user_role = $this->session->userdata('role');
		if ($user_role == 1 || $user_role == 2) {
			$this->jsonify(array(
				'status' => 0
			));
		}

		$po = $this->input->post('po');
		$year = $this->input->post('year');
		$crop = $this->input->post('crop');
		$country = $this->input->post('country');
		if (!$po || !$year) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
		}
		
		$user_indicators = array();
		$user_subindicators = array();
		$purpose = $this->input->post('purpose') ? $this->input->post('purpose') : 'reporting';
		switch ($purpose) {
			case 'reporting':
				// Get po details according to given user and year
				switch ($this->session->userdata('role')) {
					case 3:
					case 4:
					case 5:
					case 6:
						$data['user_pos'] = $po;

						// Get all Indicators
						$this->db->distinct()->select('GROUP_CONCAT(indicator_id) as indicators');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'))->where('lkp_program_id', $po);
						$indicators = $this->db->get('tbl_user_indicator')->row_array();
						$user_indicators = explode(",", $indicators['indicators']);

						// Get all Sub-Indicators
						$this->db->distinct()->select('GROUP_CONCAT(sub_indicator_id) as subindicators');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'))->where('lkp_program_id', $po);
						$subindicators = $this->db->get('tbl_user_indicator')->row_array();
						$user_subindicators = explode(",", $subindicators['subindicators']);
						break;
				}
				break;

			case 'approval':
				// Get po details according to given user and year
				switch ($this->session->userdata('role')) {
					case 4:
					case 5:
					case 6:
						$data['user_pos'] = $po;

						// Get all Indicators
						$this->db->distinct()->select('GROUP_CONCAT(indicator_id) as indicators');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'))->where('lkp_program_id', $po);
						$indicators = $this->db->get('tbl_user_approval_indicator')->row_array();
						$user_indicators = explode(",", $indicators['indicators']);

						// Get all Sub-Indicators
						$this->db->distinct()->select('GROUP_CONCAT(sub_indicator_id) as subindicators');
						$this->db->where('year_id', $year)->where('status', 1);
						$this->db->where('user_id', $this->session->userdata('login_id'))->where('lkp_program_id', $po);
						$subindicators = $this->db->get('tbl_user_approval_indicator')->row_array();
						$user_subindicators = explode(",", $subindicators['subindicators']);
						break;
				}
				break;
			

			case 'review':
				// Get po details according to given user and year
				switch ($this->session->userdata('role')) {
					case 4:
					case 5:
					case 6:
						$data['user_pos'] = $po;

						$this->db->select('form_id');
						$this->db->where('rel.relation_status', 1)->where('rel.form_type', 1);
						$this->db->where('rel.lkp_program_id', $po)->where('rel.output_id IS NULL');
						$this->db->where('rel.indicator_id IS NULL')->where('lkp_year', $year);
						$output_list = $this->db->get('rpt_form_relation as rel')->result_array();

						$user_indicators = array();
						$user_subindicators = array();

						foreach ($output_list as $key => $output) {
							// Get all Indicators
							$this->db->select('GROUP_CONCAT(form_id) as indicators');
							$this->db->where('rel.relation_status', 1)->where('rel.form_type', 2);
							$this->db->where('rel.lkp_program_id', $po)->where('output_id', $output['form_id']);
							$this->db->where('rel.indicator_id IS NULL')->where('lkp_year', $year);
							$indicators = $this->db->get('rpt_form_relation as rel')->row_array();
							$user_indicators_temp = explode(",", $indicators['indicators']);
							$user_indicators = array_merge($user_indicators, $user_indicators_temp);

							// Get all Sub-Indicators
							$this->db->select('GROUP_CONCAT(form_id) as subindicators');
							$this->db->where('rel.relation_status', 1)->where('rel.form_type', 3);
							$this->db->where('rel.lkp_program_id', $po)->where('output_id', $output['form_id']);
							$this->db->where('lkp_year', $year)->where_in('rel.indicator_id', $user_indicators);
							$subindicators = $this->db->get('rpt_form_relation as rel')->row_array();
							$user_subindicators_temp = explode(",", $subindicators['subindicators']);
							$user_subindicators = array_merge($user_subindicators, $user_subindicators_temp);
						}
						$user_indicators = array_unique($user_indicators);
						$user_indicators = array_values($user_indicators);
						$user_subindicators = array_unique($user_subindicators);
						$user_subindicators = array_values($user_subindicators);
						break;
				}
				break;
		}
		
		foreach ($user_indicators as $key => $value) {
			$user_indicators[$key] = array();
			$user_indicators[$key]['id'] = $value;

			// Saved
			$this->db->where('year_id', $year);
			$this->db->where('form_id', $value)->where('status', 1);
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			$this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_indicators[$key]['saved'] = $this->db->get('ic_form_data')->num_rows();

			// Pending Approval
			$this->db->where('year_id', $year);
			$this->db->where('form_id', $value)->where('status', 2);
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			$this->db->where('year_id', $year);
			$user_indicators[$key]['pending'] = $this->db->get('ic_form_data')->num_rows();

			// Approved
			$this->db->where('year_id', $year);
			$this->db->where('form_id', $value)->where('status', 3);
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			$this->db->where('year_id', $year);
			$user_indicators[$key]['approved'] = $this->db->get('ic_form_data')->num_rows();

			// Rejected (new feature)
			$this->db->where('year_id', $year);
			$this->db->where('form_id', $value)->where('status', 4);
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			$this->db->where('year_id', $year);
			$user_indicators[$key]['rejected'] = $this->db->get('ic_form_data')->num_rows();

			// Query Pending
			$this->db->where('year_id', $year);
			$this->db->where('form_id', $value)->where('query_status', 1);
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			$this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_indicators[$key]['query_pen'] = $this->db->get('ic_form_data')->num_rows();

			// Query Responded
			$this->db->where('year_id', $year);
			$this->db->where('form_id', $value)->where('query_status', 2);
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			$this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_indicators[$key]['query_res'] = $this->db->get('ic_form_data')->num_rows();

			// Submitted
			$this->db->where('year_id', $year);
			$this->db->where('form_id', $value)->where('status', 2);
			// $this->db->where('form_id', $value)->where(array(
			// 	'status >=' => 2,
			// 	'status <' <= 3
			// ));
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			$this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_indicators[$key]['submitted'] = $this->db->get('ic_form_data')->num_rows();
		}
		
		foreach ($user_subindicators as $skey => $value) {
			$user_subindicators[$skey] = array();
			$user_subindicators[$skey]['id'] = $value;

			// Saved
			$this->db->where('form_id', $value)->where('status', 1);
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			// $this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_subindicators[$skey]['saved'] = $this->db->get('ic_form_data')->num_rows();

			// Pending Approval
			$this->db->where('form_id', $value)->where('status', 2);
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			// $this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_subindicators[$skey]['pending'] = $this->db->get('ic_form_data')->num_rows();

			// Approved
			$this->db->where('form_id', $value)->where('status', 3);
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			// $this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_subindicators[$skey]['approved'] = $this->db->get('ic_form_data')->num_rows();

			// Query Pending
			$this->db->where('form_id', $value)->where('query_status', 1);
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			// $this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_subindicators[$skey]['query_pen'] = $this->db->get('ic_form_data')->num_rows();

			// Query Responded
			$this->db->where('form_id', $value)->where('query_status', 2);
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			// $this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_subindicators[$skey]['query_res'] = $this->db->get('ic_form_data')->num_rows();

			// Submitted
			$this->db->where('form_id', $value)->where('status', 2);
			// $this->db->where('form_id', $value)->where(array(
			// 	'status >=' => 2,
			// 	'status <' => 4
			// ));
			if ($purpose == 'reporting') {
				$this->db->where('user_id', $this->session->userdata('login_id'));
			}
			// $this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_subindicators[$skey]['submitted'] = $this->db->get('ic_form_data')->num_rows();
		}

		$this->jsonify(array(
			'status' => 1,
			'indicators' => $user_indicators,
			'subindicators' => $user_subindicators
		));
	}

	public function jsonify($array)
	{
		echo json_encode($array);
		exit();
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

			case 'approval':
				// Get pos according to given user and year
				switch ($this->session->userdata('role')) {
					case 3:
					case 4:
					case 5:
					case 6:
						$this->db->select('GROUP_CONCAT(DISTINCT(lkp_cluster_id)) as clusterids');
						$this->db->where('tui.user_id', $this->session->userdata('login_id'))->where('tui.lkp_program_id', $program);
						$this->db->where('tui.status', 1)->where('tui.year_id', $year);	
						$cluster_list = $this->db->get('tbl_user_approval_indicator as tui')->row_array();
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
	/* view data details start*/
	public function get_viewdata_details()
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

		if (!$po || !$year) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
		}
		
		$data = array(
			'year' => $year,
			'type' => 'view',
			'user_programs' => array(),
			'user_clusters' => array(),
			'user_indicators' => array(),
			'user_subindicators' => array()
		);
		$purpose = $this->input->post('purpose') ? $this->input->post('purpose') : 'reporting';
		switch ($purpose) {
			case 'reporting':
				// Get po details according to given user and year
				$cluster_list = array();
						$data['user_programs'] = $po;
						$data['user_clusters'] = explode(",", $this->input->post('cluster'));
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
						$this->db->where('year_id', $year)->where('status', 1)->where_in('lkp_cluster_id', $this->input->post('cluster'));
						// $this->db->where('user_id', $this->session->userdata('login_id'));
						$indicators = $this->db->get('tbl_user_indicator')->row_array();
						$data['user_indicators'] = explode(",", $indicators['indicators']);
						

						$this->db->distinct()->select('GROUP_CONCAT(sub_indicator_id) as subindicators');
						$this->db->where('year_id', $year)->where('status', 1);
						// $this->db->where('user_id', $this->session->userdata('login_id'));
						$subindicators = $this->db->get('tbl_user_indicator')->row_array();
						$data['user_subindicators'] = explode(",", $subindicators['subindicators']);
				break;

			case 'approval':
				// Get po details according to given user and year
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
		$data['purpose'] = $purpose;
		
		$po_list = $this->Usermanagement_model->user_program_list_d($data);
		$this->jsonify(array(
			'status' => 1,
			'po_list' => $po_list
		));
	}

	public function get_viewdata_details_counter()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
		}

		$user_role = $this->session->userdata('role');
		if ($user_role == 1 || $user_role == 2) {
			$this->jsonify(array(
				'status' => 0
			));
		}

		$po = $this->input->post('po');
		$year = $this->input->post('year');
		$crop = $this->input->post('crop');
		$country = $this->input->post('country');
		if (!$po || !$year) {
			$this->jsonify(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
		}
		
		$user_indicators = array();
		$user_subindicators = array();
		$purpose = $this->input->post('purpose') ? $this->input->post('purpose') : 'reporting';
		switch ($purpose) {
			case 'reporting':
				// Get po details according to given user and year
				$data['user_pos'] = $po;
				// Get all Indicators
				$this->db->distinct()->select('GROUP_CONCAT(indicator_id) as indicators');
				$this->db->where('year_id', $year)->where('status', 1);
				$this->db->where('user_id', $this->session->userdata('login_id'))->where('lkp_program_id', $po);
				$indicators = $this->db->get('tbl_user_indicator')->row_array();
				$user_indicators = explode(",", $indicators['indicators']);

				// Get all Sub-Indicators
				$this->db->distinct()->select('GROUP_CONCAT(sub_indicator_id) as subindicators');
				$this->db->where('year_id', $year)->where('status', 1);
				$this->db->where('user_id', $this->session->userdata('login_id'))->where('lkp_program_id', $po);
				$subindicators = $this->db->get('tbl_user_indicator')->row_array();
				$user_subindicators = explode(",", $subindicators['subindicators']);
				break;

			case 'approval':
				// Get po details according to given user and year
				$data['user_pos'] = $po;
				// Get all Indicators
				$this->db->distinct()->select('GROUP_CONCAT(indicator_id) as indicators');
				$this->db->where('year_id', $year)->where('status', 1);
				$this->db->where('user_id', $this->session->userdata('login_id'))->where('po_id', $po);
				$indicators = $this->db->get('tbl_user_approval_indicator')->row_array();
				$user_indicators = explode(",", $indicators['indicators']);

				// Get all Sub-Indicators
				$this->db->distinct()->select('GROUP_CONCAT(sub_indicator_id) as subindicators');
				$this->db->where('year_id', $year)->where('status', 1);
				$this->db->where('user_id', $this->session->userdata('login_id'))->where('po_id', $po);
				$subindicators = $this->db->get('tbl_user_approval_indicator')->row_array();
				$user_subindicators = explode(",", $subindicators['subindicators']);
				break;

			case 'review':
				// Get po details according to given user and year
				$data['user_pos'] = $po;
				$this->db->select('form_id');
				$this->db->where('rel.relation_status', 1)->where('rel.form_type', 1);
				$this->db->where('rel.lkp_program_id', $po)->where('rel.output_id IS NULL');
				$this->db->where('rel.indicator_id IS NULL')->where('lkp_year', $year);
				$output_list = $this->db->get('rpt_form_relation as rel')->result_array();

				$user_indicators = array();
				$user_subindicators = array();

				foreach ($output_list as $key => $output) {
					// Get all Indicators
					$this->db->select('GROUP_CONCAT(form_id) as indicators');
					$this->db->where('rel.relation_status', 1)->where('rel.form_type', 2);
					$this->db->where('rel.lkp_program_id', $po)->where('output_id', $output['form_id']);
					$this->db->where('rel.indicator_id IS NULL')->where('lkp_year', $year);
					$indicators = $this->db->get('rpt_form_relation as rel')->row_array();
					$user_indicators_temp = explode(",", $indicators['indicators']);
					$user_indicators = array_merge($user_indicators, $user_indicators_temp);

					// Get all Sub-Indicators
					$this->db->select('GROUP_CONCAT(form_id) as subindicators');
					$this->db->where('rel.relation_status', 1)->where('rel.form_type', 3);
					$this->db->where('rel.lkp_program_id', $po)->where('output_id', $output['form_id']);
					$this->db->where('lkp_year', $year)->where_in('rel.indicator_id', $user_indicators);
					$subindicators = $this->db->get('rpt_form_relation as rel')->row_array();
					$user_subindicators_temp = explode(",", $subindicators['subindicators']);
					$user_subindicators = array_merge($user_subindicators, $user_subindicators_temp);
				}
				$user_indicators = array_unique($user_indicators);
				$user_indicators = array_values($user_indicators);
				$user_subindicators = array_unique($user_subindicators);
				$user_subindicators = array_values($user_subindicators);
				break;
		}
		
		foreach ($user_indicators as $key => $value) {
			$user_indicators[$key] = array();
			$user_indicators[$key]['id'] = $value;

			// Saved
			$this->db->where('form_id', $value)->where('status', 1);
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			$this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_indicators[$key]['saved'] = $this->db->get('ic_form_data')->num_rows();

			// Pending Approval
			$this->db->where('form_id', $value)->where('status', 2);
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			$this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_indicators[$key]['pending'] = $this->db->get('ic_form_data')->num_rows();

			// Approved
			$this->db->where('form_id', $value)->where('status', 3);
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			$this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			
			$user_indicators[$key]['approved'] = $this->db->get('ic_form_data')->num_rows();
			// Rejected
			$this->db->where('form_id', $value)->where('status', 4);
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			$this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_indicators[$key]['rejected'] = $this->db->get('ic_form_data')->num_rows();

			// Query Pending
			$this->db->where('form_id', $value)->where('query_status', 1);
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			$this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_indicators[$key]['query_pen'] = $this->db->get('ic_form_data')->num_rows();

			// Query Responded
			$this->db->where('form_id', $value)->where('query_status', 2);
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			$this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_indicators[$key]['query_res'] = $this->db->get('ic_form_data')->num_rows();

			// Submitted
			$this->db->where('form_id', $value)->where('status', 2);
			// $this->db->where('form_id', $value)->where(array(
			// 	'status >=' => 2,
			// 	'status <' <= 3
			// ));
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			$this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_indicators[$key]['submitted'] = $this->db->get('ic_form_data')->num_rows();
		}
		
		foreach ($user_subindicators as $skey => $value) {
			$user_subindicators[$skey] = array();
			$user_subindicators[$skey]['id'] = $value;

			// Saved
			$this->db->where('form_id', $value)->where('status', 1);
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			// $this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_subindicators[$skey]['saved'] = $this->db->get('ic_form_data')->num_rows();

			// Pending Approval
			$this->db->where('form_id', $value)->where('status', 2);
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			// $this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_subindicators[$skey]['pending'] = $this->db->get('ic_form_data')->num_rows();

			// Approved
			$this->db->where('form_id', $value)->where('status', 3);
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			// $this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_subindicators[$skey]['approved'] = $this->db->get('ic_form_data')->num_rows();

			// Query Pending
			$this->db->where('form_id', $value)->where('query_status', 1);
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			// $this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_subindicators[$skey]['query_pen'] = $this->db->get('ic_form_data')->num_rows();

			// Query Responded
			$this->db->where('form_id', $value)->where('query_status', 2);
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			// $this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_subindicators[$skey]['query_res'] = $this->db->get('ic_form_data')->num_rows();

			// Submitted
			$this->db->where('form_id', $value)->where('status', 2);
			// $this->db->where('form_id', $value)->where(array(
			// 	'status >=' => 2,
			// 	'status <' => 3
			// ));
			// if ($purpose == 'reporting') {
			// 	$this->db->where('user_id', $this->session->userdata('login_id'));
			// }
			// $this->db->where('year_id', $year);
			// if ($crop) $this->db->where('crop_id', $crop);
			// if ($country) $this->db->where('country_id', $country);
			$user_subindicators[$skey]['submitted'] = $this->db->get('ic_form_data')->num_rows();
		}

		$this->jsonify(array(
			'status' => 1,
			'indicators' => $user_indicators,
			'subindicators' => $user_subindicators
		));
	}
	/* view data details end */
}
