<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('user_agent');

		$this->baseurl = base_url();

		$this->load->model('Usermanagement_model');
		$this->load->model('Dashboard_model');
		$currentPage = $this->router->fetch_method();

		// if($currentPage == 'data_approval') {
		// 	//reporting status checking
		// 	$this->db->select('status');
		// 	$this->db->from('tbl_approval_user');
		// 	$this->db->where('user_id', $this->session->userdata('login_id'));
		// 	$userstatus = $this->db->get()->row_array();
			
		// 	if(!is_null($userstatus) && $userstatus['status'] == 0 && $currentPage != 'block') {
		// 		// Block approval
		// 		redirect($baseurl.'dashboard/block_approval');
		// 	}
		// }
	}

	public function block_approval(){
		$this->load->view('common/header');
		$this->load->view('common/block_approval');
		$this->load->view('common/footer');
	}

	public function index()
	{
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
		$this->load->view('dashboard/dashboard', $result);
		$this->load->view('common/footer');
	}

	public function sdg()
	{
		$this->load->view('common/header');
		$this->load->view('dashboard/sdg');
		$this->load->view('common/footer');
	}
	public function overview()
	{
		$this->load->view('common/header');
		$this->load->view('dashboard/overview');
		$this->load->view('common/footer');
	}
	public function overview_details()
	{
		$this->load->view('common/header');
		$this->load->view('dashboard/overview_details');
		$this->load->view('common/footer');
	}

	public function non_research()
	{
		$this->load->view('common/header');
		$this->load->view('dashboard/non_research');
		$this->load->view('common/footer');
	}

	public function performance()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}
		$this->db->distinct()->select('ly.*');
		if ($this->session->userdata('role') != 1) {
			// $this->db->join('tbl_user_country_crop AS tucc', 'tucc.year_id = ly.year_id');
			// $this->db->where('tucc.status', 1);
		}
		$this->db->where('ly.year_status', 1)->order_by('ly.year');
		$year_list = $this->db->get('lkp_year AS ly')->result_array();
		$role = $this->session->userdata('role');
		$result = array('year_list' => $year_list,'role' =>$role);
		$this->load->view('common/header');
		$this->load->view('dashboard/performance_rt', $result);
		$this->load->view('common/footer');
	}

	public function launch()
	{
		//$this->load->view('common/header');
		$this->load->view('dashboard/launch');
		//$this->load->view('common/footer');
	}

	public function projectmanagement()
	{
		$this->load->view('common/header');
		$this->load->view('dashboard/projectmanagement');
		$this->load->view('common/footer');
	}

	public function approval()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$this->db->distinct()->select('ly.*');
		if ($this->session->userdata('role') != 1) {
			$this->db->join('tbl_user_approval_country_crop AS tua', 'tua.year_id = ly.year_id');
			$this->db->where('tua.status', 1);
		}
		$this->db->where('ly.year_status', 1)->order_by('ly.year');
		$year_list = $this->db->get('lkp_year AS ly')->result_array();

		$result = array('year_list' => $year_list);

		$this->load->view('common/header');
		$this->load->view('dashboard/approval', $result);
		$this->load->view('common/footer');
	}

	public function review()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$this->db->distinct()->select('ly.*');
		if ($this->session->userdata('role') != 1) {
			$this->db->join('tbl_user_review AS tur', 'tur.year_id = ly.year_id');
			$this->db->where('tur.status', 1);
		}
		$this->db->where('ly.year_status', 1)->order_by('ly.year');
		$year_list = $this->db->get('lkp_year AS ly')->result_array();

		$result = array('year_list' => $year_list);

		$this->load->view('common/header');
		$this->load->view('dashboard/review', $result);
		$this->load->view('common/footer');
	}

	public function data_approval()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$this->db->distinct()->select('ly.*');
		if ($this->session->userdata('role') != 1) {
			$this->db->join('tbl_user_review AS tur', 'tur.year_id = ly.year_id');
			$this->db->where('tur.status', 1);
		}
		$this->db->where('ly.year_status', 1)->order_by('ly.year');
		$year_list = $this->db->get('lkp_year AS ly')->result_array();

		$result = array('year_list' => $year_list);

		$this->load->view('common/header');
		$this->load->view('dashboard/data_approval', $result);
		$this->load->view('common/footer');
	}

	public function get_indicatorsdata_toapprove()
	{
		$baseurl = base_url();
		if ($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		$form_id = $this->input->post('form_id');
		$country = $this->input->post('country');
		$crop = $this->input->post('crop');
		$year_val = $this->input->post('year_val');
		$user_type = $this->session->userdata('role');

		$result['title'] = $this->db->where('id', $form_id)->get('form')->row_array();

		$this->db->select('field_id')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_form_fields_count = $this->db->get('form_field')->num_rows();

		$this->db->select('*');
		$this->db->where('cluster_status', 1);
		$lkp_cluster = $this->db->get('tbl_cluster')->result_array();

		$result['form_fieldscount'] = $check_form_fields_count;
		$result['lkp_cluster'] = $lkp_cluster;

		if ($result['form_fieldscount'] > 0) {
			$tablename = "ic_form_data";

			$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$check_group_fields_indicator = $this->db->get('form_field')->num_rows();

			if ($check_group_fields_indicator > 0) {
				$this->db->select('GROUP_CONCAT(field_id) as field_ids')->where('type', 'group')->where('form_id',  $form_id);
				$this->db->where('status', 1);
				$get_group_id = $this->db->get('form_field')->row_array();

				$get_group_id_array = explode(",", $get_group_id['field_ids']);

				$this->db->select('child_id');
				$this->db->where('form_id',  $form_id);
				$this->db->where_in('field_id', $get_group_id_array);
				$this->db->where('status', 1);
				$get_group_fields = $this->db->get('form_field')->result_array();

				$get_group_fields_array = array();

				foreach ($get_group_fields as $key => $value) {
					$field_array = explode(",", $value['child_id']);

					foreach ($field_array as $key => $field) {
						array_push($get_group_fields_array, $field);
					}
				}

				$this->db->select('field_id, label, type');
				$this->db->where('status', 1)->where('form_id',  $form_id);
				$this->db->where_not_in('field_id', $get_group_fields_array);
				$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
				$this->db->order_by('slno');
				$indicator_fields = $this->db->get('form_field')->result_array();

				$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, cr.crop_name, c.country_name');
				$this->db->from('' . $tablename . ' as sur');
				$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
				$this->db->join('lkp_year as y', 'sur.year_id = y.year_id');
				$this->db->join('lkp_rperiod as rp', 'sur.rperiod_id = rp.rperiod_id');
				$this->db->join('lkp_country as c', 'sur.country_id = c.country_id');
				$this->db->join('lkp_crop as cr', 'sur.crop_id = cr.crop_id');
				$this->db->where('sur.status', 2);
				$this->db->where('form_id', $form_id);
				$this->db->where('sur.year_id', $year_val);
				$this->db->order_by('sur.reg_date_time', 'desc');
				$indicator_field_data = $this->db->get()->result_array();
				foreach ($indicator_field_data as $dkey => $data) {
					$group_table = "ic_form_group_data";

					$this->db->where('data_id', $data['data_id']);
					// $this->db->where('status', 2);
					$indicator_field_data[$dkey]['groupdata'] = $this->db->get($group_table)->result_array();
				}

				$group_array = array();

				foreach ($get_group_id_array as $groupkey => $groupid) {
					$this->db->select('field_id, label, child_id')->where('form_id', $form_id)->where('field_id', $groupid)->where('status', 1);
					$group_info = $this->db->get('form_field')->row_array();

					$group_fields = explode(",", $group_info['child_id']);

					$group_array[$groupkey]['group_lable'] = $group_info;

					$this->db->where_in('field_id', $group_fields)->where('status', 1)->order_by('slno');
					$group_array[$groupkey]['group_fields'] = $this->db->get('form_field')->result_array();
				}

				$result['indicator_fields'] = $indicator_fields;
				$result['indicator_field_data'] = $indicator_field_data;
				$result['group_array'] = $group_array;
			} else {
				$this->db->select('field_id, label, type');
				$this->db->where('status', 1)->where('form_id',  $form_id)->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
				$this->db->order_by('slno');
				$indicator_fields = $this->db->get('form_field')->result_array();

				$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, cr.crop_name, c.country_name');
				$this->db->from('' . $tablename . ' as sur');
				$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
				$this->db->join('lkp_year as y', 'sur.year_id = y.year_id');
				$this->db->join('lkp_rperiod as rp', 'sur.rperiod_id = rp.rperiod_id');
				$this->db->join('lkp_country as c', 'sur.country_id = c.country_id');
				$this->db->join('lkp_crop as cr', 'sur.crop_id = cr.crop_id');
				$this->db->where('sur.status', 2);
				$this->db->where('form_id', $form_id);
				$this->db->where('sur.year_id', $year_val);
				$this->db->order_by('sur.reg_date_time', 'desc');
				$indicator_field_data = $this->db->get()->result_array();

				$result['indicator_fields'] = $indicator_fields;
				$result['indicator_field_data'] = $indicator_field_data;
			}
		}

		$result['status'] = 1;

		echo json_encode($result);
		exit();
	}

	public function form_data()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$tablename = "ic_form_data";
		$year_id = $this->uri->segment(3);
		/*$country_id = $this->uri->segment(4);
		$crop_id = $this->uri->segment(5);*/
		$form_id = $this->uri->segment(4);
		$datatype = $this->uri->segment(5);
		$user_dataid = $this->uri->segment(6);
		$user_id = $this->session->userdata('login_id');
		$program_id = $this->uri->segment(7);

		$user_role = $this->session->userdata('role');

		if ($year_id == '' || $form_id == '' || $datatype == '') {
			show_404();
		}

		$this->db->select('relation_id');
		$this->db->where('lkp_year', $year_id)->where('form_type', $form_id)->where('relation_status', 1);
		$check_form = $this->db->get('rpt_form_relation')->num_rows();

		if ($check_form = 0) {
			show_404();
		}
		$this->db->select('*');
		$this->db->where('status', 1);
		$lkp_country = $this->db->get('lkp_country')->result_array();
		$this->db->select('*');
		$this->db->where('cluster_status', 1);
		$lkp_cluster = $this->db->get('tbl_cluster')->result_array();

		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		if ($check_group_fields > 0) {
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('child_id');
			$this->db->where('form_id',  $form_id);
			$this->db->where_in('field_id', $get_group_id_array);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->result_array();

			$get_group_fields_array = array();

			foreach ($get_group_fields as $key => $value) {
				$field_array = explode(",", $value['child_id']);

				foreach ($field_array as $key => $field) {
					array_push($get_group_fields_array, $field);
				}
			}

			$this->db->select('field_id, label, type, subtype, multiple');
			$this->db->where('status', 1)->where('form_id',  $form_id)->where('parent_id IS NULL')->where('parent_value IS NULL');
			$this->db->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(up.first_name, " ", up.last_name) as useaprrname, y.year as yearname, rp.rperiod_name as rpname, c.country_name as cname, cr.crop_name as crname');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('lkp_year as y', 'sur.year_id = y.year_id');
			$this->db->join('lkp_rperiod as rp', 'sur.rperiod_id = rp.rperiod_id');
			$this->db->join('lkp_country as c', 'sur.country_id = c.country_id');
			$this->db->join('lkp_crop as cr', 'sur.crop_id = cr.crop_id');
			// $this->db->join('lkp_sdg as sdg', 'sur.sdg_id = sdg.sdg_id');
			// $this->db->join('ic_data_file as df', 'sur.data_id = df.data_id','left');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			if($datatype != 4){
			$this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			}else{
			$this->db->join('tbl_users as up', 'sur.rejected_by = up.user_id','left');
			}
			if ($user_role == 3) {
				$this->db->where('sur.user_id', $user_id);
			}
			switch ($datatype) {
				case '2':
					// $this->db->where_in('sur.status', array(2, 3));
					$this->db->where_in('sur.status', 2);
					break;
				case '4':
					$this->db->where('sur.status', 4);
					break;

				case 'pending_approval':
					$this->db->where('sur.status', 2);
					break;

				default:
					$this->db->where('sur.status', $datatype);
					break;
			}
			if ($user_dataid != '') {
				$this->db->where('sur.user_id', $user_dataid);
			}
			// $this->db->where('year_id', $year_id);
			$this->db->where('sur.form_id', $form_id);
			$this->db->where('sur.year_id', $year_id);
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();
			

			$group_table = "ic_form_group_data";

			foreach ($form_data as $dkey => $data) {
				//newly added SDG data geting into formadata lsit array
				$sdg_ids_array = explode(",", $data['sdg_id']);
				$sdg_sub_ids_array = explode(",", $data['sdg_sub_id']);
				$this->db->select('*');
				$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				$form_data[$dkey]['sdg_list'] = $this->db->get('lkp_sdg')->result_array();
				$this->db->select('*');
				$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				$form_data[$dkey]['sdg_sub_list'] = $this->db->get('lkp_sdg_sub')->result_array();
				// $sql = $this->db->last_query();
				$file_list_array = array();
				$this->db->select('*');
				$this->db->where('data_id', $data['data_id'])->where('status', 1);
				$file_list_array = $this->db->get('ic_data_file')->result_array();
				$form_data[$dkey]['file_list_array'] = $file_list_array;
				$file_list_array = array();
				$this->db->select('*');
				$this->db->where('data_id', $data['data_id'])->where('status', 1);
				$file_list_array = $this->db->get('ic_data_file')->result_array();
				$form_data[$dkey]['file_list_array'] = $file_list_array;

				$this->db->where('data_id', $data['data_id']);
				switch ($datatype) {
					case '2':
						$this->db->where_in('status', array(2, 3, 4));
						break;
					case '4':
						$this->db->where('status', 4);
						break;
					case 'pending_approval':
						$this->db->where('status', 2);
						break;

					default:
						$this->db->where('status', $datatype);
						break;
				}
				$form_data[$dkey]['groupdata'] = $this->db->get($group_table)->result_array();
			}

			$group_array = array();

			foreach ($get_group_id_array as $groupkey => $groupid) {
				$this->db->select('field_id, label, child_id');
				$this->db->where('field_id', $groupid)->where('status', 1);
				$group_info = $this->db->get('form_field')->row_array();

				$group_fields = explode(",", $group_info['child_id']);

				$group_array[$groupkey]['group_lable'] = $group_info;
				$group_array[$groupkey]['group_field_id'] = $groupid;

				$this->db->select('*');
				$this->db->where_in('field_id', $group_fields)->where('status', 1)->order_by('slno');
				$group_array[$groupkey]['group_fields'] = $this->db->get('form_field')->result_array();
			}

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data, 'group_array' => $group_array, 'lkp_country' => $lkp_country);

			$result['group_table'] = $group_table;
		} else {
			$this->db->select('field_id, label, type, subtype');
			// $this->db->where('status', 1)->where('form_id',  $form_id)->where('parent_id IS NULL')->where('parent_value IS NULL');
			$this->db->where('status', 1)->where('form_id',  $form_id);
			$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(up.first_name, " ", up.last_name) as useaprrname, y.year as yearname, rp.rperiod_name as rpname, c.country_name as cname, cr.crop_name as crname');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('lkp_year as y', 'sur.year_id = y.year_id');
			$this->db->join('lkp_rperiod as rp', 'sur.rperiod_id = rp.rperiod_id');
			$this->db->join('lkp_country as c', 'sur.country_id = c.country_id');
			$this->db->join('lkp_crop as cr', 'sur.crop_id = cr.crop_id');
			// $this->db->join('lkp_sdg as sdg', 'sur.sdg_id = sdg.sdg_id');
			// $this->db->join('ic_data_file as df', 'sur.data_id = df.data_id','left');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			if($datatype != 4){
			$this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			}else{
			$this->db->join('tbl_users as up', 'sur.rejected_by = up.user_id','left');
			}
			// $this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			if ($user_role == 3) {
				$this->db->where('sur.user_id', $user_id);
			}
			switch ($datatype) {
				case '2':
					// $this->db->where_in('sur.status', array(2, 3));
					$this->db->where_in('sur.status', 2);
					break;
				case '4':
					$this->db->where('sur.status', 4);
					break;

				case 'pending_approval':
					$this->db->where('sur.status', 2);
					break;

				default:
					$this->db->where('sur.status', $datatype);
					break;
			}
			// $this->db->where('year_id', $year_id);
			$this->db->where('sur.form_id', $form_id);
			$this->db->where('sur.year_id', $year_id);
			if ($user_dataid != '') {
				$this->db->where('sur.user_id', $user_dataid);
			}
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();
			// $str = $this->db->last_query();
			// echo $str;
			// exit;
			foreach ($form_data as $dkey => $data) {
				//newly added SDG data geting into formadata lsit array
				// $sdg_ids_array = explode(",", $data['sdg_id']);
				// if($data['sdg_id']!= NULL || $data['sdg_id']!= ""){
				// 	$this->db->select('GROUP_CONCAT(sdg_name) as sdg_names');
				// 	$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				// 	$sdg_data = $this->db->get('lkp_sdg')->row_array();
				// 	$form_data[$dkey]['sdgname'] = $sdg_data['sdg_names'];
				// }else{
				// 	$form_data[$dkey]['sdgname'] = "N/A";
				// }
				// $sdg_sub_ids_array = explode(",", $data['sdg_sub_id']);
				// if($data['sdg_sub_id']!= NULL || $data['sdg_sub_id']!= ""){
				// 	$this->db->select('GROUP_CONCAT(sdg_sub_name) as sdg_sub_names');
				// 	$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				// 	$sdg_sub_data = $this->db->get('lkp_sdg_sub')->row_array();
				// 	$form_data[$dkey]['sdg_sub_name'] = $sdg_sub_data['sdg_sub_names'];
				// }else{
				// 	$form_data[$dkey]['sdg_sub_name'] = "N/A";
				// }
				$sdg_ids_array = explode(",", $data['sdg_id']);
				$sdg_sub_ids_array = explode(",", $data['sdg_sub_id']);
				$this->db->select('*');
				$this->db->order_by('slno');
				$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				$form_data[$dkey]['sdg_list'] = $this->db->get('lkp_sdg')->result_array();
				$this->db->select('*');
				$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				$form_data[$dkey]['sdg_sub_list'] = $this->db->get('lkp_sdg_sub')->result_array();
				// $sql = $this->db->last_query();
				$file_list_array = array();
				$this->db->select('*');
				$this->db->where('data_id', $data['data_id'])->where('status', 1);
				$file_list_array = $this->db->get('ic_data_file')->result_array();
				$form_data[$dkey]['file_list_array'] = $file_list_array;
			}

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data, 'lkp_country' => $lkp_country, 'lkp_cluster' => $lkp_cluster);
		}

		$this->db->select('*');
		$this->db->where('id', $form_id);
		$result['title'] = $this->db->get('form')->row_array();
		$result['form_id'] = $form_id;

		$result['tablename'] = $tablename;

		$this->load->view('common/header');
		$this->load->view('dashboard/form_data', $result);
		$this->load->view('common/footer');
	}
	public function approved_form_data()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$tablename = "ic_form_data";
		$year_id = $this->uri->segment(3);
		/*$country_id = $this->uri->segment(4);
		$crop_id = $this->uri->segment(5);*/
		$form_id = $this->uri->segment(4);
		$datatype = $this->uri->segment(5);
		$user_dataid = $this->uri->segment(6);
		$user_id = $this->session->userdata('login_id');
		$program_id = $this->uri->segment(7);

		$user_role = $this->session->userdata('role');

		if ($year_id == '' || $form_id == '' || $datatype == '') {
			show_404();
		}

		$this->db->select('relation_id');
		$this->db->where('lkp_year', $year_id)->where('form_type', $form_id)->where('relation_status', 1);
		$check_form = $this->db->get('rpt_form_relation')->num_rows();

		if ($check_form = 0) {
			show_404();
		}

		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		if ($check_group_fields > 0) {
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('child_id');
			$this->db->where('form_id',  $form_id);
			$this->db->where_in('field_id', $get_group_id_array);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->result_array();

			$get_group_fields_array = array();

			foreach ($get_group_fields as $key => $value) {
				$field_array = explode(",", $value['child_id']);

				foreach ($field_array as $key => $field) {
					array_push($get_group_fields_array, $field);
				}
			}

			$this->db->select('field_id, label, type, subtype');
			// $this->db->where('status', 1)->where('form_id',  $form_id)->where('parent_id IS NULL')->where('parent_value IS NULL');
			$this->db->where('status', 1)->where('form_id',  $form_id);
			$this->db->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(up.first_name, " ", up.last_name) as useaprrname, y.year as yearname, rp.rperiod_name as rpname, c.country_name as cname, cr.crop_name as crname');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('lkp_year as y', 'sur.year_id = y.year_id');
			$this->db->join('lkp_rperiod as rp', 'sur.rperiod_id = rp.rperiod_id');
			$this->db->join('lkp_country as c', 'sur.country_id = c.country_id');
			$this->db->join('lkp_crop as cr', 'sur.crop_id = cr.crop_id');
			// $this->db->join('lkp_sdg as sdg', 'sur.sdg_id = sdg.sdg_id');
			// $this->db->join('ic_data_file as df', 'sur.data_id = df.data_id','left');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			if($datatype != 4){
			$this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			}else{
			$this->db->join('tbl_users as up', 'sur.rejected_by = up.user_id','left');
			}
			if ($user_role == 3) {
				$this->db->where('sur.user_id', $user_id);
			}
			switch ($datatype) {
				case '2':
					$this->db->where_in('sur.status', array(2, 3));
					break;
				case '4':
					$this->db->where('sur.status', 4);
					break;

				case 'pending_approval':
					$this->db->where('sur.status', 2);
					break;

				default:
					$this->db->where('sur.status', $datatype);
					break;
			}
			// if ($user_dataid != '') {
			// 	$this->db->where('sur.user_id', $user_dataid);
			// }
			$this->db->where('sur.year_id', $year_id);
			$this->db->where('sur.form_id', $form_id);
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();
			

			$group_table = "ic_form_group_data";

			foreach ($form_data as $dkey => $data) {
				//newly added SDG data geting into formadata lsit array
				$sdg_ids_array = explode(",", $data['sdg_id']);
				$sdg_sub_ids_array = explode(",", $data['sdg_sub_id']);
				$this->db->select('*');
				$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				$form_data[$dkey]['sdg_list'] = $this->db->get('lkp_sdg')->result_array();
				$this->db->select('*');
				$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				$form_data[$dkey]['sdg_sub_list'] = $this->db->get('lkp_sdg_sub')->result_array();
				// $sql = $this->db->last_query();
				$file_list_array = array();
				$this->db->select('*');
				$this->db->where('data_id', $data['data_id'])->where('status', 1);
				$file_list_array = $this->db->get('ic_data_file')->result_array();
				$form_data[$dkey]['file_list_array'] = $file_list_array;
				$file_list_array = array();
				$this->db->select('*');
				$this->db->where('data_id', $data['data_id'])->where('status', 1);
				$file_list_array = $this->db->get('ic_data_file')->result_array();
				$form_data[$dkey]['file_list_array'] = $file_list_array;

				$this->db->where('data_id', $data['data_id']);
				switch ($datatype) {
					case '2':
						$this->db->where_in('status', array(2, 3, 4));
						break;
					case '4':
						$this->db->where('status', 4);
						break;
					case 'pending_approval':
						$this->db->where('status', 2);
						break;

					default:
						$this->db->where('status', $datatype);
						break;
				}
				$form_data[$dkey]['groupdata'] = $this->db->get($group_table)->result_array();
			}

			$group_array = array();

			foreach ($get_group_id_array as $groupkey => $groupid) {
				$this->db->select('field_id, label, child_id');
				$this->db->where('field_id', $groupid)->where('status', 1);
				$group_info = $this->db->get('form_field')->row_array();

				$group_fields = explode(",", $group_info['child_id']);

				$group_array[$groupkey]['group_lable'] = $group_info;

				$this->db->select('*');
				$this->db->where_in('field_id', $group_fields)->where('status', 1)->order_by('slno');
				$group_array[$groupkey]['group_fields'] = $this->db->get('form_field')->result_array();
			}

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data, 'group_array' => $group_array);

			$result['group_table'] = $group_table;
		} else {
			$this->db->select('field_id, label, type, subtype');
			// $this->db->where('status', 1)->where('form_id',  $form_id)->where('parent_id IS NULL')->where('parent_value IS NULL');
			$this->db->where('status', 1)->where('form_id',  $form_id);
			$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(up.first_name, " ", up.last_name) as useaprrname, y.year as yearname, rp.rperiod_name as rpname, c.country_name as cname, cr.crop_name as crname');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('lkp_year as y', 'sur.year_id = y.year_id');
			$this->db->join('lkp_rperiod as rp', 'sur.rperiod_id = rp.rperiod_id');
			$this->db->join('lkp_country as c', 'sur.country_id = c.country_id');
			$this->db->join('lkp_crop as cr', 'sur.crop_id = cr.crop_id');
			// $this->db->join('lkp_sdg as sdg', 'sur.sdg_id = sdg.sdg_id');
			// $this->db->join('ic_data_file as df', 'sur.data_id = df.data_id','left');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			if($datatype != 4){
			$this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			}else{
			$this->db->join('tbl_users as up', 'sur.rejected_by = up.user_id','left');
			}
			// $this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			if ($user_role == 3) {
				$this->db->where('sur.user_id', $user_id);
			}
			switch ($datatype) {
				case '2':
					$this->db->where_in('sur.status', array(2, 3));
					break;
				case '4':
					$this->db->where('sur.status', 4);
					break;

				case 'pending_approval':
					$this->db->where('sur.status', 2);
					break;

				default:
					$this->db->where('sur.status', $datatype);
					break;
			}
			$this->db->where('sur.year_id', $year_id);
			$this->db->where('sur.form_id', $form_id);
			// if ($user_dataid != '') {
			// 	$this->db->where('sur.user_id', $user_dataid);
			// }
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();
			// $str = $this->db->last_query();
			// echo $str;
			// exit;
			foreach ($form_data as $dkey => $data) {
				//newly added SDG data geting into formadata lsit array
				// $sdg_ids_array = explode(",", $data['sdg_id']);
				// if($data['sdg_id']!= NULL || $data['sdg_id']!= ""){
				// 	$this->db->select('GROUP_CONCAT(sdg_name) as sdg_names');
				// 	$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				// 	$sdg_data = $this->db->get('lkp_sdg')->row_array();
				// 	$form_data[$dkey]['sdgname'] = $sdg_data['sdg_names'];
				// }else{
				// 	$form_data[$dkey]['sdgname'] = "N/A";
				// }
				// $sdg_sub_ids_array = explode(",", $data['sdg_sub_id']);
				// if($data['sdg_sub_id']!= NULL || $data['sdg_sub_id']!= ""){
				// 	$this->db->select('GROUP_CONCAT(sdg_sub_name) as sdg_sub_names');
				// 	$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				// 	$sdg_sub_data = $this->db->get('lkp_sdg_sub')->row_array();
				// 	$form_data[$dkey]['sdg_sub_name'] = $sdg_sub_data['sdg_sub_names'];
				// }else{
				// 	$form_data[$dkey]['sdg_sub_name'] = "N/A";
				// }
				$sdg_ids_array = explode(",", $data['sdg_id']);
				$sdg_sub_ids_array = explode(",", $data['sdg_sub_id']);
				$this->db->select('*');
				$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				$form_data[$dkey]['sdg_list'] = $this->db->get('lkp_sdg')->result_array();
				$this->db->select('*');
				$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				$form_data[$dkey]['sdg_sub_list'] = $this->db->get('lkp_sdg_sub')->result_array();
				// $sql = $this->db->last_query();
				$file_list_array = array();
				$this->db->select('*');
				$this->db->where('data_id', $data['data_id'])->where('status', 1);
				$file_list_array = $this->db->get('ic_data_file')->result_array();
				$form_data[$dkey]['file_list_array'] = $file_list_array;
			}

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data);
		}

		$this->db->select('*');
		$this->db->where('id', $form_id);
		$result['title'] = $this->db->get('form')->row_array();
		$result['form_id'] = $form_id;

		$result['tablename'] = $tablename;

		$this->load->view('common/header');
		$this->load->view('dashboard/approved_form_data', $result);
		$this->load->view('common/footer');
	}

	public function form_data_rejected()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$tablename = "ic_form_data";
		$year_id = $this->uri->segment(3);
		/*$country_id = $this->uri->segment(4);
		$crop_id = $this->uri->segment(5);*/
		$form_id = $this->uri->segment(4);
		$datatype = $this->uri->segment(5);
		$user_dataid = $this->uri->segment(6);
		$user_id = $this->session->userdata('login_id');
		$program_id = $this->uri->segment(7);

		$user_role = $this->session->userdata('role');

		if ($year_id == '' || $form_id == '' || $datatype == '') {
			show_404();
		}

		$this->db->select('relation_id');
		$this->db->where('lkp_year', $year_id)->where('form_type', $form_id)->where('relation_status', 1);
		$check_form = $this->db->get('rpt_form_relation')->num_rows();

		if ($check_form = 0) {
			show_404();
		}

		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		if ($check_group_fields > 0) {
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('child_id');
			$this->db->where('form_id',  $form_id);
			$this->db->where_in('field_id', $get_group_id_array);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->result_array();

			$get_group_fields_array = array();

			foreach ($get_group_fields as $key => $value) {
				$field_array = explode(",", $value['child_id']);

				foreach ($field_array as $key => $field) {
					array_push($get_group_fields_array, $field);
				}
			}

			$this->db->select('field_id, label, type, subtype');
			// $this->db->where('status', 1)->where('form_id',  $form_id)->where('parent_id IS NULL')->where('parent_value IS NULL');
			$this->db->where('status', 1)->where('form_id',  $form_id);
			$this->db->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(up.first_name, " ", up.last_name) as useaprrname, y.year as yearname, rp.rperiod_name as rpname, c.country_name as cname, cr.crop_name as crname');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('lkp_year as y', 'sur.year_id = y.year_id');
			$this->db->join('lkp_rperiod as rp', 'sur.rperiod_id = rp.rperiod_id');
			$this->db->join('lkp_country as c', 'sur.country_id = c.country_id');
			$this->db->join('lkp_crop as cr', 'sur.crop_id = cr.crop_id');
			// $this->db->join('lkp_sdg as sdg', 'sur.sdg_id = sdg.sdg_id');
			// $this->db->join('ic_data_file as df', 'sur.data_id = df.data_id','left');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			if($datatype != 4){
			$this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			}else{
			$this->db->join('tbl_users as up', 'sur.rejected_by = up.user_id','left');
			}
			if ($user_role == 3) {
				$this->db->where('sur.user_id', $user_id);
			}
			switch ($datatype) {
				case '2':
					$this->db->where_in('sur.status', array(2, 3));
					break;
				case '4':
					$this->db->where('sur.status', 4);
					break;

				case 'pending_approval':
					$this->db->where('sur.status', 2);
					break;

				default:
					$this->db->where('sur.status', $datatype);
					break;
			}
			// if ($user_dataid != '') {
			// 	$this->db->where('sur.user_id', $user_dataid);
			// }
			$this->db->where('sur.year_id', $year_id);
			$this->db->where('sur.form_id', $form_id);
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();
			

			$group_table = "ic_form_group_data";

			foreach ($form_data as $dkey => $data) {
				//newly added SDG data geting into formadata lsit array
				$sdg_ids_array = explode(",", $data['sdg_id']);
				$sdg_sub_ids_array = explode(",", $data['sdg_sub_id']);
				$this->db->select('*');
				$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				$form_data[$dkey]['sdg_list'] = $this->db->get('lkp_sdg')->result_array();
				$this->db->select('*');
				$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				$form_data[$dkey]['sdg_sub_list'] = $this->db->get('lkp_sdg_sub')->result_array();
				// $sql = $this->db->last_query();
				$file_list_array = array();
				$this->db->select('*');
				$this->db->where('data_id', $data['data_id'])->where('status', 1);
				$file_list_array = $this->db->get('ic_data_file')->result_array();
				$form_data[$dkey]['file_list_array'] = $file_list_array;
				$file_list_array = array();
				$this->db->select('*');
				$this->db->where('data_id', $data['data_id'])->where('status', 1);
				$file_list_array = $this->db->get('ic_data_file')->result_array();
				$form_data[$dkey]['file_list_array'] = $file_list_array;

				$this->db->where('data_id', $data['data_id']);
				switch ($datatype) {
					case '2':
						$this->db->where_in('status', array(2, 3, 4));
						break;
					case '4':
						$this->db->where('status', 4);
						break;
					case 'pending_approval':
						$this->db->where('status', 2);
						break;

					default:
						$this->db->where('status', $datatype);
						break;
				}
				$form_data[$dkey]['groupdata'] = $this->db->get($group_table)->result_array();
			}

			$group_array = array();

			foreach ($get_group_id_array as $groupkey => $groupid) {
				$this->db->select('field_id, label, child_id');
				$this->db->where('field_id', $groupid)->where('status', 1);
				$group_info = $this->db->get('form_field')->row_array();

				$group_fields = explode(",", $group_info['child_id']);

				$group_array[$groupkey]['group_lable'] = $group_info;

				$this->db->select('*');
				$this->db->where_in('field_id', $group_fields)->where('status', 1)->order_by('slno');
				$group_array[$groupkey]['group_fields'] = $this->db->get('form_field')->result_array();
			}

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data, 'group_array' => $group_array);

			$result['group_table'] = $group_table;
		} else {
			$this->db->select('field_id, label, type, subtype');
			// $this->db->where('status', 1)->where('form_id',  $form_id)->where('parent_id IS NULL')->where('parent_value IS NULL');
			$this->db->where('status', 1)->where('form_id',  $form_id);
			$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(up.first_name, " ", up.last_name) as useaprrname, y.year as yearname, rp.rperiod_name as rpname, c.country_name as cname, cr.crop_name as crname');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('lkp_year as y', 'sur.year_id = y.year_id');
			$this->db->join('lkp_rperiod as rp', 'sur.rperiod_id = rp.rperiod_id');
			$this->db->join('lkp_country as c', 'sur.country_id = c.country_id');
			$this->db->join('lkp_crop as cr', 'sur.crop_id = cr.crop_id');
			// $this->db->join('lkp_sdg as sdg', 'sur.sdg_id = sdg.sdg_id');
			// $this->db->join('ic_data_file as df', 'sur.data_id = df.data_id','left');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			if($datatype != 4){
			$this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			}else{
			$this->db->join('tbl_users as up', 'sur.rejected_by = up.user_id','left');
			}
			// $this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			if ($user_role == 3) {
				$this->db->where('sur.user_id', $user_id);
			}
			switch ($datatype) {
				case '2':
					$this->db->where_in('sur.status', array(2, 3));
					break;
				case '4':
					$this->db->where('sur.status', 4);
					break;

				case 'pending_approval':
					$this->db->where('sur.status', 2);
					break;

				default:
					$this->db->where('sur.status', $datatype);
					break;
			}
			$this->db->where('sur.year_id', $year_id);
			$this->db->where('sur.form_id', $form_id);
			// if ($user_dataid != '') {
			// 	$this->db->where('sur.user_id', $user_dataid);
			// }
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();
			// $str = $this->db->last_query();
			// echo $str;
			// exit;
			foreach ($form_data as $dkey => $data) {
				//newly added SDG data geting into formadata lsit array
				// $sdg_ids_array = explode(",", $data['sdg_id']);
				// if($data['sdg_id']!= NULL || $data['sdg_id']!= ""){
				// 	$this->db->select('GROUP_CONCAT(sdg_name) as sdg_names');
				// 	$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				// 	$sdg_data = $this->db->get('lkp_sdg')->row_array();
				// 	$form_data[$dkey]['sdgname'] = $sdg_data['sdg_names'];
				// }else{
				// 	$form_data[$dkey]['sdgname'] = "N/A";
				// }
				// $sdg_sub_ids_array = explode(",", $data['sdg_sub_id']);
				// if($data['sdg_sub_id']!= NULL || $data['sdg_sub_id']!= ""){
				// 	$this->db->select('GROUP_CONCAT(sdg_sub_name) as sdg_sub_names');
				// 	$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				// 	$sdg_sub_data = $this->db->get('lkp_sdg_sub')->row_array();
				// 	$form_data[$dkey]['sdg_sub_name'] = $sdg_sub_data['sdg_sub_names'];
				// }else{
				// 	$form_data[$dkey]['sdg_sub_name'] = "N/A";
				// }
				$sdg_ids_array = explode(",", $data['sdg_id']);
				$sdg_sub_ids_array = explode(",", $data['sdg_sub_id']);
				$this->db->select('*');
				$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				$form_data[$dkey]['sdg_list'] = $this->db->get('lkp_sdg')->result_array();
				$this->db->select('*');
				$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				$form_data[$dkey]['sdg_sub_list'] = $this->db->get('lkp_sdg_sub')->result_array();
				// $sql = $this->db->last_query();
				$file_list_array = array();
				$this->db->select('*');
				$this->db->where('data_id', $data['data_id'])->where('status', 1);
				$file_list_array = $this->db->get('ic_data_file')->result_array();
				$form_data[$dkey]['file_list_array'] = $file_list_array;
			}

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data);
		}

		$this->db->select('*');
		$this->db->where('id', $form_id);
		$result['title'] = $this->db->get('form')->row_array();
		$result['form_id'] = $form_id;

		$result['tablename'] = $tablename;

		$this->load->view('common/header');
		$this->load->view('dashboard/form_data_rejected', $result);
		$this->load->view('common/footer');
	}

	public function update_formdata()
	{
		$baseurl = base_url();
		date_default_timezone_set("UTC");
		if ($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		$user_id = $this->session->userdata('login_id');
		$user_role = $this->session->userdata('role');

		$recordid = $this->input->post('recordid');
		$form_id = $this->input->post('form_id');
		$formtype = $this->input->post('formtype');

		$time = time();
		$datetime = date('Y-m-d H:i:s');

		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		$insert_array = array();
		$dataarray = array();

		if ($check_group_fields > 0) {
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();
			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where_in('parent_id', $get_group_id_array)->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->row_array();
			$get_group_fields_array = explode(",", $get_group_fields['field_ids']);

			$this->db->select('field_id');
			$this->db->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('status', 1)->where('form_id',  $form_id)->where('type !=', 'group')->where('type !=', 'header')->where('type !=', 'uploadgroupdata_excel');
			$non_group_fields = $this->db->get('form_field')->result_array();

			foreach ($non_group_fields as $key => $value) {
				$fieldkey = "field_" . $value['field_id'];
				$multi_value = array();
				if (isset($_POST[$fieldkey])) {
					if (is_array($_POST[$fieldkey])) {
						foreach ($_POST[$fieldkey] as $multiplevalue) {
							array_push($multi_value, $multiplevalue);
						}
						$dataarray[$fieldkey] = implode('&#44;', $multi_value);
					} else {
						if ($_POST[$fieldkey] == '') {
							$dataarray[$fieldkey] = NULL;
						} else {
							$dataarray[$fieldkey] = $_POST[$fieldkey];
						}
					}
				} else {
					$dataarray[$fieldkey] = NULL;
				}
			}
		} else {
			foreach ($_POST as $key => $field) {
				if ($key != 'form_id' && $key != 'recordid') {
					$multi_value = array();
					if (is_array($field)) {
						foreach ($field as $value) {
							array_push($multi_value, $value);
						}
						$dataarray[$key] = implode('&#44;', $multi_value);
					} else {
						if ($field == '') {
							$dataarray[$key] = NULL;
						} else {
							$dataarray[$key] = $field;
						}
					}
				}
			}
		}
		$insert_array['form_data'] = json_encode($dataarray, JSON_UNESCAPED_UNICODE);
		if ($formtype == 'save') {
			//user submitting his own save data
			$insert_array['status'] = 1;
		} else {
			//edit and approve data either level 2 or level 3
			if ($formtype == 'edit_and_approve' && ($user_role == 4 || $user_role == 5)) {
				$insert_array['status'] = 3;
			}
		}

		if(isset($_POST['indicator_comment'])){
			$insert_array['comment'] = $_POST['indicator_comment'];
		}

		$this->db->where('data_id', $this->input->post('recordid'));
		$query = $this->db->update('ic_form_data', $insert_array);
		if ($query) {
			if ($check_group_fields > 0) {
				foreach ($get_group_id_array as $groupkey => $groupid) {
					$group_table_name = "ic_form_group_data";

					$this->db->select('child_id');
					$this->db->where('field_id', $groupid)->where('form_id',  $form_id);
					$this->db->where('status', 1);
					$get_fields_bygroupid = $this->db->get('form_field')->row_array();

					$get_fields_bygroupid_array = explode(",", $get_fields_bygroupid['child_id']);
					$first_field = "field_" . $get_fields_bygroupid_array[0] . "";
					if (isset($_POST[$first_field])) {
						foreach ($_POST[$first_field] as $fieldskey => $value) {
							$groupdata = array();
							$group_data_array = array();

							if (isset($_POST['id'][$fieldskey])) {
								foreach ($get_fields_bygroupid_array as $key => $fieldvalue) {
									$group_field_key = "field_" . $fieldvalue;
									$multi_value = array();
									if (isset($_POST[$group_field_key][$fieldskey])) {
										if (is_array($_POST[$group_field_key][$fieldskey])) {
											foreach ($_POST[$group_field_key][$fieldskey] as $multivalue) {
												array_push($multi_value, $multivalue);
											}
											$group_data_array[$group_field_key] = implode('&#44;', $multi_value);
										} else {
											$group_data_array[$group_field_key] = $_POST[$group_field_key][$fieldskey];
										}
									} else {
										$group_data_array[$group_field_key] = NULL;
									}
								}
								$groupdata['formgroup_data'] = json_encode($group_data_array, JSON_UNESCAPED_UNICODE);
								if ($formtype == 'save' && ($user_role == 3)) {
									//user submitting his own save data
									$groupdata['status'] = 1;
								} else {
									//edit and approve data either level 2 or level 3
									if ($formtype == 'edit_and_approve' && ($user_role == 4 || $user_role == 5)) {
										$groupdata['status'] = 3;
									}
								}
								$this->db->where('group_id', $_POST['id'][$fieldskey])->where('data_id', $this->input->post('recordid'));
								$this->db->where('groupfield_id', $groupid);
								$groupquery = $this->db->update('ic_form_group_data', $groupdata);
							}
						}
					}
				}
			}


			echo json_encode(array(
				'status' => 1,
				'msg' => 'Data edited successfully.'
			));
			exit();
		} else {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Sorry! Something went wrong, please try after some time'
			));
			exit();
		}
	}


	public function delete_groupdata()
	{
		$baseurl = base_url();
		if ($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}
		date_default_timezone_set("UTC");

		$recordid = $this->input->post('recordid');
		$group_recordid = $this->input->post('group_recordid');
		$group_table = $this->input->post('group_table');
		$gdata_id = $this->input->post('gdata_id');

		$gcount = $this->db->select('COUNT(*) as count')->where('data_id', $this->input->post('gdata_id'))->where('status !=', 0)->get($group_table)->row_array();

		$getold_value = $this->db->select('status')->where('group_id', $this->input->post('group_recordid'))->get($group_table)->row_array();

		if (isset($_POST['reason'])) {
			$reason = $this->input->post('reason');
		} else {
			$reason = 'Deleted by the user';
		}

		$update_grouptabledata = array(
			'status' => 0
		);
		//$this->db->where('group_id', $this->input->post('group_recordid'))->where('status', $this->input->post('recordid'));
		$this->db->where('group_id', $this->input->post('group_recordid'))->where('status !=', 0);
		$grouptable_query = $this->db->update($group_table, $update_grouptabledata);

		if ($grouptable_query) {

			$grouptable_name = 'ic_form_data';
			$update_array1 = array(
				'status' => 0
			);

			if ($gcount['count'] == 1) {
				$this->db->where('data_id', $gdata_id)->where('status !=', 0);
				$groupq = $this->db->update($grouptable_name, $update_array1);
			}


			$insert_log_array = array(
				'editedby' => $this->session->userdata('login_id'),
				'editedfor' => NULL,
				'table_name' => $group_table,
				'table_row_id' => $this->input->post('group_recordid'),
				'table_field_name' => 'status',
				'old_value' => $getold_value['status'],
				'new_value' => 0,
				'edited_reason' => $reason,
				'updated_date' => date('Y-m-d H:i:s'),
				'ip_address' => $this->input->ip_address(),
				'log_status' => 1
			);

			$query = $this->db->insert('ic_log', $insert_log_array);

			if (!$query) {
				$result = array('status' => 0, 'msg' => 'Data updated Successfully and went wrong with log');
			} else {
				if ($gcount['count'] == 1) {
					echo json_encode(array('status' => 1, 'reload' => 1, 'msg' => 'Group data deleted successfully'));
				} else {
					echo json_encode(array('status' => 1, 'msg' => 'Group data deleted successfully'));
				}
				exit();
			}
		} else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}
	}

	public function delete_data()
	{
		$baseurl = base_url();
		if ($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}
		date_default_timezone_set("UTC");

		$recordid = $this->input->post('recordid');
		$reason = $this->input->post('reason');
		$tablename = "ic_form_data";
		$grouptable_name = "ic_form_group_data";

		$this->db->select('*');
		$this->db->where('data_id', $recordid)->where('status !=', 0);
		$get_olddata = $this->db->get($tablename)->row_array();

		if ($get_olddata == NULL) {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}

		$update_array = array(
			'status' => 0
		);
		$this->db->where('data_id', $recordid)->where('status !=', 0);
		$table_query = $this->db->update($tablename, $update_array);
		if ($table_query) {
			if ($grouptable_name != NULL) {
				$this->db->where('data_id', $recordid)->where('status !=', 0);
				$grouptable_query = $this->db->update($grouptable_name, $update_array);

				$log_array = array(
					'editedby' => $this->session->userdata('login_id'),
					'editedfor' => $this->session->userdata('login_id'),
					'table_name' => $tablename,
					'table_row_id' => $recordid,
					'table_field_name' => 'status',
					'old_value' => $get_olddata['status'],
					'new_value' => 0,
					'edited_reason' => $reason,
					'updated_date' => date('Y-m-d H:i:s'),
					'ip_address' => $this->input->ip_address(),
					'log_status' => 1
				);

				$approval_query = $this->db->insert('ic_log', $log_array);

				if ($approval_query) {
					echo json_encode(array(
						'status' => 1,
						'msg' => 'Data deleted successfully.'
					));
					exit();
				} else {
					echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong with log, please try after some time'));
					exit();
				}
			} else {
				$log_array = array(
					'editedby' => $this->session->userdata('login_id'),
					'editedfor' => $this->session->userdata('login_id'),
					'table_name' => $tablename,
					'table_row_id' => $recordid,
					'table_field_name' => 'status',
					'old_value' => $get_olddata['status'],
					'new_value' => 0,
					'edited_reason' => $reason,
					'updated_date' => date('Y-m-d H:i:s'),
					'ip_address' => $this->input->ip_address(),
					'log_status' => 1
				);

				$approval_query = $this->db->insert('ic_log', $log_array);

				if ($approval_query) {
					echo json_encode(array(
						'status' => 1,
						'msg' => 'Data deleted successfully.'
					));
					exit();
				} else {
					echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong with log, please try after some time'));
					exit();
				}
			}
		} else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}
	}

	public function approve_data()
	{
		$baseurl = base_url();
		if ($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}
		date_default_timezone_set("UTC");

		$recordid = $this->input->post('recordid');
		$form_id = $this->input->post('form_id');
		$user_type = $this->session->userdata('role');

		if ($user_type != 4 && $user_type != 5 && $user_type != 6) {
			show_404();
		}

		$update_statusto = 3;

		$tablename = "ic_form_data";
		$grouptable_name = "ic_form_group_data";

		$update_array = array(
			'status' => $update_statusto
		);

		$get_userid = $this->db->select('user_id, form_id')->where('data_id', $recordid)->get('ic_form_data')->row_array();

		$this->db->where('data_id', $recordid)->where('status !=', 0);
		$table_query = $this->db->update($tablename, $update_array);
		if ($table_query) {
			if ($grouptable_name != NULL) {
				$this->db->where('data_id', $recordid)->where('status !=', 0);
				$grouptable_query = $this->db->update($grouptable_name, $update_array);

				$approval_info = array(
					'approve' => 1,
					'approve_by' => $this->session->userdata('login_id'),
					'approve_date' => date('Y-m-d H:i:s')
				);
				$this->db->where('data_id', $recordid);
				$approval_query = $this->db->update('ic_form_data', $approval_info);

				if ($approval_query) {
					$user_info = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where('user_id', $get_userid['user_id'])->get('tbl_users')->row_array();
					$form_details = $this->db->where('id', $get_userid['form_id'])->get('form')->row_array();
					$emaildetails = $this->db->where('status', 1)->get('emailconfiguration_details')->row_array();

					if (ENVIRONMENT != 'development') {

						$config = array(
							'protocol' => 'smtp',
							'smtp_host' => 'ssl://smtp.googlemail.com',
							'smtp_port' => 465,
							'smtp_user' => $emaildetails['email_id'], // change it to yours
							'smtp_pass' => $emaildetails['password'], // change it to yours
							'mailtype' => 'html',
							'charset' => 'iso-8859-1',
							'wordwrap' => TRUE
						);

						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('mandeaticrisat@gmail.com', 'MPRO');
						$this->email->to($user_info['email_id']);
						$this->email->subject('Indicator approval');
						$this->email->set_mailtype("html");
						$this->email->message("Dear " . $user_info['first_name'] . " " . $user_info['last_name'] . " ,<br/><br/><b>" . $this->session->userdata('name') . "</b> has approved the data submitted by you for <b>" . $form_details['title'] . "</b>.<br/><br/>You can also visit MTP Reporting  and know the approval status of your data.<br/><br/>Regards,<br/>MTP team");
						if (!$this->email->send()) {
							show_error($this->email->print_debugger());
						}
					}

					echo json_encode(array(
						'status' => 1,
						'msg' => 'Data approved successfully.'
					));
					exit();
				} else {
					echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
					exit();
				}
			} else {
				$approval_info = array(
					'approve' => 1,
					'approve_by' => $this->session->userdata('login_id'),
					'approve_date' => date('Y-m-d H:i:s')
				);
				$this->db->where('data_id', $recordid);
				$approval_query = $this->db->update('ic_form_data', $approval_info);

				if ($approval_query) {
					$user_info = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where('user_id', $get_userid['user_id'])->get('tbl_users')->row_array();
					$form_details = $this->db->where('id', $get_userid['form_id'])->get('form')->row_array();
					$emaildetails = $this->db->where('status', 1)->get('emailconfiguration_details')->row_array();
					if (ENVIRONMENT != 'development') {
						$config = array(
							'protocol' => 'smtp',
							'smtp_host' => 'ssl://smtp.googlemail.com',
							'smtp_port' => 465,
							'smtp_user' => $emaildetails['email_id'], // change it to yours
							'smtp_pass' => $emaildetails['password'], // change it to yours
							'mailtype' => 'html',
							'charset' => 'iso-8859-1',
							'wordwrap' => TRUE
						);

						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('mandeaticrisat@gmail.com', 'MPRO');
						$this->email->to($user_info['email_id']);
						$this->email->subject('Indicator approval');
						$this->email->set_mailtype("html");
						$this->email->message("Dear " . $user_info['first_name'] . " " . $user_info['last_name'] . " ,<br/><br/><b>" . $this->session->userdata('name') . "</b> has approved the data submitted by you for <b>" . $form_details['title'] . "</b>.<br/><br/>You can also visit MTP Reporting and know the approval status of your data.<br/><br/>Regards,<br/>MTP team");
						if (!$this->email->send()) {
							show_error($this->email->print_debugger());
						}
					}
					echo json_encode(array(
						'status' => 1,
						'msg' => 'Data approved successfully.'
					));
					exit();
				} else {
					echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
					exit();
				}
			}
		} else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}
	}
	public function reject_data()
	{
		$baseurl = base_url();
		if ($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}
		date_default_timezone_set("UTC");

		$recordid = $this->input->post('recordid');
		$form_id = $this->input->post('form_id');
		$user_type = $this->session->userdata('role');

		if ($user_type != 4 && $user_type != 5 && $user_type != 6) {
			show_404();
		}

		$update_statusto = 4;

		$tablename = "ic_form_data";
		$grouptable_name = "ic_form_group_data";

		$update_array = array(
			'status' => $update_statusto
		);

		$get_userid = $this->db->select('user_id, form_id')->where('data_id', $recordid)->get('ic_form_data')->row_array();

		$this->db->where('data_id', $recordid)->where('status !=', 0);
		$table_query = $this->db->update($tablename, $update_array);
		if ($table_query) {
			if ($grouptable_name != NULL) {
				$this->db->where('data_id', $recordid)->where('status !=', 0);
				$grouptable_query = $this->db->update($grouptable_name, $update_array);

				$reject_info = array(
					'reject' => 1,
					'rejected_by' => $this->session->userdata('login_id'),
					'rejected_date' => date('Y-m-d H:i:s')
				);
				$this->db->where('data_id', $recordid);
				$reject_query = $this->db->update('ic_form_data', $reject_info);

				if ($reject_query) {
					$user_info = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where('user_id', $get_userid['user_id'])->get('tbl_users')->row_array();
					$form_details = $this->db->where('id', $get_userid['form_id'])->get('form')->row_array();
					$emaildetails = $this->db->where('status', 1)->get('emailconfiguration_details')->row_array();

					if (ENVIRONMENT != 'development') {

						$config = array(
							'protocol' => 'smtp',
							'smtp_host' => 'ssl://smtp.googlemail.com',
							'smtp_port' => 465,
							'smtp_user' => $emaildetails['email_id'], // change it to yours
							'smtp_pass' => $emaildetails['password'], // change it to yours
							'mailtype' => 'html',
							'charset' => 'iso-8859-1',
							'wordwrap' => TRUE
						);

						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('mandeaticrisat@gmail.com', 'MPRO');
						$this->email->to($user_info['email_id']);
						$this->email->subject('Indicator reject');
						$this->email->set_mailtype("html");
						$this->email->message("Dear " . $user_info['first_name'] . " " . $user_info['last_name'] . " ,<br/><br/><b>" . $this->session->userdata('name') . "</b> has rejected the data submitted by you for <b>" . $form_details['title'] . "</b>.<br/><br/>You can also visit MTP Reporting  and know the rejected status of your data.<br/><br/>Regards,<br/>MTP team");
						if (!$this->email->send()) {
							show_error($this->email->print_debugger());
						}
					}

					echo json_encode(array(
						'status' => 1,
						'msg' => 'Data rejected successfully.'
					));
					exit();
				} else {
					echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
					exit();
				}
			} else {
				$reject_info = array(
					'reject' => 1,
					'rejected_by' => $this->session->userdata('login_id'),
					'rejected_date' => date('Y-m-d H:i:s')
				);
				$this->db->where('data_id', $recordid);
				$reject_query = $this->db->update('ic_form_data', $reject_info);

				if ($reject_query) {
					$user_info = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where('user_id', $get_userid['user_id'])->get('tbl_users')->row_array();
					$form_details = $this->db->where('id', $get_userid['form_id'])->get('form')->row_array();
					$emaildetails = $this->db->where('status', 1)->get('emailconfiguration_details')->row_array();
					if (ENVIRONMENT != 'development') {
						$config = array(
							'protocol' => 'smtp',
							'smtp_host' => 'ssl://smtp.googlemail.com',
							'smtp_port' => 465,
							'smtp_user' => $emaildetails['email_id'], // change it to yours
							'smtp_pass' => $emaildetails['password'], // change it to yours
							'mailtype' => 'html',
							'charset' => 'iso-8859-1',
							'wordwrap' => TRUE
						);

						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('mandeaticrisat@gmail.com', 'MPRO');
						$this->email->to($user_info['email_id']);
						$this->email->subject('Indicator reject');
						$this->email->set_mailtype("html");
						$this->email->message("Dear " . $user_info['first_name'] . " " . $user_info['last_name'] . " ,<br/><br/><b>" . $this->session->userdata('name') . "</b> has rejected the data submitted by you for <b>" . $form_details['title'] . "</b>.<br/><br/>You can also visit MTP Reporting and know the reject status of your data.<br/><br/>Regards,<br/>MTP team");
						if (!$this->email->send()) {
							show_error($this->email->print_debugger());
						}
					}
					echo json_encode(array(
						'status' => 1,
						'msg' => 'Data rejected successfully.'
					));
					exit();
				} else {
					echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
					exit();
				}
			}
		} else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}
	}

	public function edit_andapprovedata()
	{
		date_default_timezone_set("UTC");
		$baseurl = base_url();
		if ($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		$user_id = $this->session->userdata('login_id');
		$user_type = $this->session->userdata('role');

		$recordid = $this->input->post('recordid');
		$form_id = $this->input->post('form_id');


		$this->db->where('form_id', $form_id);
		$this->db->order_by('slno')->where('status', 1);
		$indicator_fields = $this->db->get('form_field')->result_array();
		// echo $this->db->last_query();
		// die();
		foreach ($indicator_fields as $ifkey => $indicatorfield) {
			switch ($indicatorfield['type']) {
				case 'select':
				case 'radio-group':
				case 'checkbox-group':
					$this->db->where('field_id', $indicatorfield['field_id'])->where('status', 1);
					$this->db->order_by('options_order');
					$indicator_fields[$ifkey]['options'] = $this->db->get('form_field_multiple')->result_array();
					break;

				case 'lkp_country':
					$this->db->select('country_id, country_name,country_code');
					$this->db->order_by('country_id');
					$options = $this->db->where('status', 1)->get('lkp_country')->result_array();
					$indicator_fields[$ifkey]['options'] = $options;
					break;

				case 'lkp_trait':
					$this->db->select('*');
					$this->db->where('trait_status', 1);
					// $this->db->order_by('trait_id');
					$indicator_fields[$ifkey]['options'] = $this->db->get('lkp_trait')->result_array();

					$this->db->where('parent_id', $indicatorfield['field_id'])->where('status', 1);
					$icheck_child_fields = $this->db->get('form_field')->num_rows();

					$indicator_fields[$ifkey]['child_count']  = $icheck_child_fields;
					break;

				case 'lkp_trait2':
					$this->db->select('*');
					$this->db->where('trait2_status', 1);
					// $this->db->order_by('trait2_id');
					$indicator_fields[$ifkey]['options'] = $this->db->get('lkp_trait2')->result_array();

					$this->db->where('parent_id', $indicatorfield['field_id'])->where('status', 1);
					$icheck_child_fields = $this->db->get('form_field')->num_rows();

					$indicator_fields[$ifkey]['child_count']  = $icheck_child_fields;
					break;

				case 'group':
					$this->db->where('parent_id', $indicatorfield['field_id'])->where('parent_value', NULL)->where('status', 1);
					$this->db->order_by('slno');
					$survey_groupfields = $this->db->get('form_field')->result_array();
					foreach ($survey_groupfields as $gkey => $field) {
						switch ($field['type']) {
							case 'select':
							case 'radio-group':
							case 'checkbox-group':
								$this->db->where('field_id', $field['field_id'])->where('status', 1);
								$this->db->order_by('options_order');
								$survey_groupfields[$gkey]['options'] = $this->db->get('form_field_multiple')->result_array();
								break;
							case 'lkp_trait':
								$this->db->select('*');
								$this->db->where('trait_status', 1);
								// $this->db->order_by('trait_id');
								$survey_groupfields[$gkey]['options'] = $this->db->get('lkp_trait')->result_array();
								break;
							case 'lkp_trait2':
								$this->db->select('*');
								$this->db->where('trait2_status', 1);
								// $this->db->order_by('trait2_id');
								$survey_groupfields[$gkey]['options'] = $this->db->get('lkp_trait2')->result_array();
								break;
							case 'lkp_country':
								$this->db->select('country_id, country_name,country_code');
								$this->db->order_by('country_id');
								$survey_groupfields[$gkey]['options'] = $this->db->where('status', 1)->get('lkp_country')->result_array();
								break;
							case 'lkp_headquarter':
								$this->db->select('*');
								$this->db->where('headquarter_status', 1);
								// $this->db->order_by('headquarter_id');
								$survey_groupfields[$gkey]['options'] = $this->db->get('lkp_headquarter')->result_array();
								break;
						}

						$this->db->where('parent_id', $field['field_id'])->where('status', 1);
						$check_child_fields = $this->db->get('form_field')->num_rows();

						$survey_groupfields[$gkey]['child_count']  = $check_child_fields;
					}

					$indicator_fields[$ifkey]['groupfields'] = $survey_groupfields;
					break;
			}
		}
		$this->db->where('data_id', $recordid);
		switch ($user_type) {
			case 4:
				$this->db->where('status!=', 0);
			//$this->db->where_in('status', array(2,3));
				break;

			case 5:
				$this->db->where('status!=', 0);
				break;
		}
		$get_tabledata = $this->db->get('ic_form_data')->row_array();

		$result = array('indicator_fields' => $indicator_fields, 'get_tabledata' => $get_tabledata, 'status' => 1);

		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		if ($check_group_fields > 0) {
			$this->db->where('data_id', $recordid);
			switch ($user_type) {
				case 4:
					$this->db->where('status!=',0);
					//$this->db->where_in('status', array(2,3));
					break;

				case 5:
					$this->db->where('status!=', 0);
					break;
			}
			$this->db->where('status !=', 0);
			$get_grouptabledata = $this->db->get('ic_form_group_data')->result_array();

			$result['get_grouptabledata'] = $get_grouptabledata;
		}

		echo json_encode($result);
		exit();
	}

	public function edit_formdata()
	{
		$baseurl = base_url();
		date_default_timezone_set("UTC");
		if ($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		$user_id = $this->session->userdata('login_id');
		$user_role = $this->session->userdata('role');

		$recordid = $this->input->post('recordid');
		$form_id = $this->input->post('form_id');
		$formtype = $this->input->post('formtype');
		$lresponded = $this->input->post('lresponded');

		$time = time();
		$datetime = date('Y-m-d H:i:s');

		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		$insert_array = array();
		$dataarray = array();

		if ($check_group_fields > 0) {
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();
			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where_in('parent_id', $get_group_id_array)->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->row_array();
			$get_group_fields_array = explode(",", $get_group_fields['field_ids']);

			$this->db->select('field_id');
			$this->db->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('status', 1)->where('form_id',  $form_id)->where('type !=', 'group')->where('type !=', 'header')->where('type !=', 'uploadgroupdata_excel');
			$non_group_fields = $this->db->get('form_field')->result_array();

			foreach ($non_group_fields as $key => $value) {
				$fieldkey = "field_" . $value['field_id'];
				$multi_value = array();
				if (isset($_POST[$fieldkey])) {
					if (is_array($_POST[$fieldkey])) {
						foreach ($_POST[$fieldkey] as $multiplevalue) {
							array_push($multi_value, $multiplevalue);
						}
						$dataarray[$fieldkey] = implode('&#44;', $multi_value);
					} else {
						if ($_POST[$fieldkey] == '') {
							$dataarray[$fieldkey] = NULL;
						} else {
							$dataarray[$fieldkey] = $_POST[$fieldkey];
						}
					}
				} else {
					$dataarray[$fieldkey] = NULL;
				}
			}
		} else {
			foreach ($_POST as $key => $field) {
				if ($key != 'form_id' && $key != 'recordid' && $key != 'indicator_comment') {
					$multi_value = array();
					if (is_array($field)) {
						foreach ($field as $value) {
							array_push($multi_value, $value);
						}
						$dataarray[$key] = implode('&#44;', $multi_value);
					} else {
						if ($field == '') {
							$dataarray[$key] = NULL;
						} else {
							$dataarray[$key] = $field;
						}
					}
				}
			}
		}
		$insert_array['form_data'] = json_encode($dataarray, JSON_UNESCAPED_UNICODE);
		if ($formtype == 'save' || $formtype == 'edit') {
			//user submitting his own save data
			if($user_role == 4 || $user_role == 5 || $user_role == 6){
				$insert_array['status'] = 3;
			}else{
				$insert_array['status'] = 2;
			}
			// if ($lresponded == 1) {
			// 	$insert_array['query_status'] = 2;
			// }
		} else {
			//edit and approve data either level 2 or level 3
			if ($formtype == 'edit_and_approve' && ($user_role == 4 || $user_role == 5 || $user_role == 6)) {
				$insert_array['status'] = 3;
			}
		}

		if(isset($_POST['indicator_comment'])){
			$insert_array['comment'] = $_POST['indicator_comment'];
		}

		$this->db->where('data_id', $this->input->post('recordid'));
		$query = $this->db->update('ic_form_data', $insert_array);
		if ($query) {
			if ($check_group_fields > 0) {
				foreach ($get_group_id_array as $groupkey => $groupid) {
					$group_table_name = "ic_form_group_data";

					$this->db->select('child_id');
					$this->db->where('field_id', $groupid)->where('form_id',  $form_id);
					$this->db->where('status', 1);
					$get_fields_bygroupid = $this->db->get('form_field')->row_array();

					$get_fields_bygroupid_array = explode(",", $get_fields_bygroupid['child_id']);
					$first_field = "field_" . $get_fields_bygroupid_array[0] . "";
					if (isset($_POST[$first_field])) {
						foreach ($_POST[$first_field] as $fieldskey => $value) {
							$groupdata = array();
							$group_data_array = array();

							if (isset($_POST['id'][$fieldskey])) {
								foreach ($get_fields_bygroupid_array as $key => $fieldvalue) {
									$group_field_key = "field_" . $fieldvalue;
									$multi_value = array();
									if (isset($_POST[$group_field_key][$fieldskey])) {
										if (is_array($_POST[$group_field_key][$fieldskey])) {
											foreach ($_POST[$group_field_key][$fieldskey] as $multivalue) {
												array_push($multi_value, $multivalue);
											}
											$group_data_array[$group_field_key] = implode('&#44;', $multi_value);
										} else {
											$group_data_array[$group_field_key] = $_POST[$group_field_key][$fieldskey];
										}
									} else {
										$group_data_array[$group_field_key] = NULL;
									}
								}
								$groupdata['formgroup_data'] = json_encode($group_data_array, JSON_UNESCAPED_UNICODE);
								if ($formtype == 'save' || $formtype == 'edit') {
									//user submitting his own save data
									//$groupdata['status'] = 2;
									if($user_role == 4 || $user_role == 5 || $user_role == 6){
										$groupdata['status'] = 3;
									}else{
										$groupdata['status'] = 2;
									}
									/*if ($lresponded == 1) {
										$groupdata['query_status'] = 2;
									}*/
								} else {
									//edit and approve data either level 2 or level 3
									if ($formtype == 'edit_and_approve' && ($user_role == 4 || $user_role == 5 || $user_role == 6)) {
										$groupdata['status'] = 3;
									}
								}
								$this->db->where('group_id', $_POST['id'][$fieldskey])->where('data_id', $this->input->post('recordid'));
								$this->db->where('groupfield_id', $groupid);
								$groupquery = $this->db->update('ic_form_group_data', $groupdata);
							}
						}
					}
				}
			}

			//edit and approve data either level 2 or level 3
			if ($formtype == 'edit_and_approve' && ($user_role == 4 || $user_role == 5)) {
				$approval_info = array(
					'approve' => 1,
					'approve_by' => $this->session->userdata('login_id'),
					'approve_date' => date('Y-m-d H:i:s')
				);
				$this->db->where('data_id', $recordid);
				$approval_query = $this->db->update('ic_form_data', $approval_info);

				if (!$approval_query) {
					echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong with approval, please try after some time'));
					exit();
				}

				echo json_encode(array(
					'status' => 1,
					'msg' => 'Data approved successfully.'
				));
				exit();
			}

			echo json_encode(array(
				'status' => 1,
				'msg' => 'Data edited successfully.'
			));
			exit();
		} else {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Sorry! Something went wrong, please try after some time'
			));
			exit();
		}
	}

	public function send_back()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
			exit();
		}

		$id = $this->input->post('id');
		$query = $this->input->post('query');
		if (!$id || strlen($id) == 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}

		$validation_error = array('status' => 1, 'errors' => array());
		if (!$query || strlen($query) === 0) {
			$validation_error['status'] = 0;
			$validation_error['errors']['query'] = 'Query is mandatory.';
		} else if (strlen($query) > 5000) {
			$validation_error['status'] = 0;
			$validation_error['errors']['query'] = 'Query must be within 5000 characters.';
		}

		if ($validation_error['status'] == 0) {
			echo json_encode($validation_error);
			exit();
		}
		date_default_timezone_set("UTC");

		// Get record details
		$details = $this->db->where('data_id', $id)->get('ic_form_data')->row_array();

		// Insert query
		$this->db->insert('ic_data_query', array(
			'data_id' => $id,
			'query' => $query,
			'sent_by' => $this->session->userdata('login_id'),
			'sent_to' => $details['user_id'],
			'query_datetime' => date('Y-m-d H:i:s'),
			'ip_address' => $this->input->ip_address(),
			'status' => 1
		));

		$query_array = array(
			'query_status' => 1
		);
		$this->db->where('data_id', $id);
		$this->db->update('ic_form_data', $query_array);

		$get_userid = $this->db->select('user_id, form_id, reg_date_time')->where('data_id', $id)->get('ic_form_data')->row_array();
		$user_info = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where('user_id', $get_userid['user_id'])->get('tbl_users')->row_array();
		$form_details = $this->db->where('id', $get_userid['form_id'])->get('form')->row_array();
		$emaildetails = $this->db->where('status', 1)->get('emailconfiguration_details')->row_array();
		if (ENVIRONMENT != 'development') {
			$config = array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => $emaildetails['email_id'], // change it to yours
				'smtp_pass' => $emaildetails['password'], // change it to yours
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);

			$subject = "Query received from" . $this->session->userdata('name');

			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('mandeaticrisat@gmail.com', 'MPRO');
			$this->email->to($user_info['email_id']);
			$this->email->subject($subject);
			$this->email->set_mailtype("html");
			$this->email->message("Dear " . $user_info['first_name'] . " " . $user_info['last_name'] . " ,<br/><br/><b>" . $this->session->userdata('name') . "</b> has sent you a query regarding the data submitted by you for <b>" . $form_details['title'] . "</b> on " . $get_userid['reg_date_time'] . ".<br/><br/>Please visit the MPRO AVISA Reporting 2020 platform to view the query.<br/><br/>You can either respond to the query by providing an explanation or you can edit your data if required and submit again.<br/><br/>Regards,<br/>MPRO team");
			if (!$this->email->send()) {
				show_error($this->email->print_debugger());
			}
		}
		echo json_encode(array(
			'status' => 1,
			'msg' => 'Data sent back to user with you query.'
		));
		exit();
	}
	public function send_back_monitoring()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
			exit();
		}

		$id = $this->input->post('id');
		$query = $this->input->post('query');
		if (!$id || strlen($id) == 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}

		$validation_error = array('status' => 1, 'errors' => array());
		if (!$query || strlen($query) === 0) {
			$validation_error['status'] = 0;
			$validation_error['errors']['query'] = 'Query is mandatory.';
		} else if (strlen($query) > 5000) {
			$validation_error['status'] = 0;
			$validation_error['errors']['query'] = 'Query must be within 5000 characters.';
		}

		if ($validation_error['status'] == 0) {
			echo json_encode($validation_error);
			exit();
		}
		date_default_timezone_set("UTC");

		// Get record details
		$details = $this->db->where('data_id', $id)->get('ic_form_data')->row_array();

		// Prepare user's list
		// Added user who approved data
		$users_to_sendback = array();
		if(!in_array($details['approve_by'], $users_to_sendback)) array_push($users_to_sendback, $details['approve_by']);
		
		// Get all level 3 Users
		// Who has been assigned
		// The same Year, Country, Crop
		$this->db->select('tu.user_id')->from('tbl_users AS tu');
		$this->db->join('tbl_user_review AS tur', 'tur.user_id = tu.user_id');
		$this->db->where('tur.status', 1)->where('tur.year_id', $details['year_id']);
		$this->db->where('tur.country_id', $details['country_id'])->where('tur.crop_id', $details['crop_id']);
		$lvl3users = $this->db->where('tu.status', 1)->where('tu.role_id', 5)->get()->result_array();
		foreach ($lvl3users as $key => $user) {
			if(!in_array($user['user_id'], $users_to_sendback)) array_push($users_to_sendback, $user['user_id']);
		}
		
		// Insert query for Send Back
		// foreach ($users_to_sendback as $key => $value) {
		// 	$this->db->insert('ic_data_query', array(
		// 		'data_id' => $id,
		// 		'query' => $query,
		// 		'sent_by' => $this->session->userdata('login_id'),
		// 		'sent_to' => $value,
		// 		'query_datetime' => date('Y-m-d H:i:s'),
		// 		'ip_address' => $this->input->ip_address(),
		// 		'status' => 1
		// 	));
		// }
		$this->db->insert('ic_data_query', array(
			'data_id' => $id,
			'query' => $query,
			'sent_by' => $this->session->userdata('login_id'),
			'sent_to' => $details['user_id'],
			'query_datetime' => date('Y-m-d H:i:s'),
			'ip_address' => $this->input->ip_address(),
			'status' => 1
		));

		$query_array = array(
			'query_status' => 1
		);
		$this->db->where('data_id', $id);
		$this->db->update('ic_form_data', $query_array);

		$this->db->select('email_id, first_name, last_name')->where('status', 1);
		$all_user_info = $this->db->where_in('user_id', $users_to_sendback)->get('tbl_users')->result_array();
		$form_details = $this->db->where('id', $details['form_id'])->get('form')->row_array();
		$emaildetails = $this->db->where('status', 1)->get('emailconfiguration_details')->row_array();
		if (ENVIRONMENT != 'development') {
			$config = array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => $emaildetails['email_id'], // change it to yours
				'smtp_pass' => $emaildetails['password'], // change it to yours
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);

			$subject = "Query received from" . $this->session->userdata('name');

			foreach ($all_user_info as $key => $user_info) {
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->from('mandeaticrisat@gmail.com', 'MPRO');
				$this->email->to($user_info['email_id']);
				$this->email->subject($subject);
				$this->email->set_mailtype("html");
				$this->email->message("Dear " . $user_info['first_name'] . " " . $user_info['last_name'] . " ,<br/><br/><b>" . $this->session->userdata('name') . "</b> has sent you a query regarding the data submitted by you for <b>" . $form_details['title'] . "</b> on " . $get_userid['reg_date_time'] . ".<br/><br/>Please visit the MPRO AVISA Reporting 2020 platform to view the query.<br/><br/>You can either respond to the query by providing an explanation or you can edit your data if required and submit again.<br/><br/>Regards,<br/>MPRO team");
				if (!$this->email->send()) {
					show_error($this->email->print_debugger());
				}
			}
		}
		echo json_encode(array(
			'status' => 1,
			'msg' => 'Data sent back to user with you query.'
		));
		exit();
	}
	public function send_back_result_tracker()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
			exit();
		}

		$id = $this->input->post('id');
		$query = $this->input->post('query');
		if (!$id || strlen($id) == 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}

		$validation_error = array('status' => 1, 'errors' => array());
		if (!$query || strlen($query) === 0) {
			$validation_error['status'] = 0;
			$validation_error['errors']['query'] = 'Query is mandatory.';
		} else if (strlen($query) > 5000) {
			$validation_error['status'] = 0;
			$validation_error['errors']['query'] = 'Query must be within 5000 characters.';
		}

		if ($validation_error['status'] == 0) {
			echo json_encode($validation_error);
			exit();
		}
		date_default_timezone_set("UTC");

		// Get record details
		$details = $this->db->where('data_id', $id)->get('resulttracker_reviews')->row_array();

		// Insert query
		$this->db->insert('resulttracker_query', array(
			'data_id' => $id,
			'query' => $query,
			'sent_by' => $this->session->userdata('login_id'),
			'sent_to' => $details['user_id'],
			'query_datetime' => date('Y-m-d H:i:s'),
			'ip_address' => $this->input->ip_address(),
			'status' => 1
		));

		$query_array = array(
			'query_status' => 1
		);
		$this->db->where('data_id', $id);
		$this->db->update('resulttracker_reviews', $query_array);

		$get_userid = $this->db->select('user_id, form_id, reg_date_time')->where('data_id', $id)->get('resulttracker_reviews')->row_array();
		$user_info = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where('user_id', $get_userid['user_id'])->get('tbl_users')->row_array();
		$form_details = $this->db->where('id', $get_userid['form_id'])->get('form')->row_array();
		$emaildetails = $this->db->where('status', 1)->get('emailconfiguration_details')->row_array();
		if (ENVIRONMENT != 'development') {
			$config = array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => $emaildetails['email_id'], // change it to yours
				'smtp_pass' => $emaildetails['password'], // change it to yours
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);

			$subject = "Query received from" . $this->session->userdata('name');

			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('mandeaticrisat@gmail.com', 'MPRO');
			$this->email->to($user_info['email_id']);
			$this->email->subject($subject);
			$this->email->set_mailtype("html");
			$this->email->message("Dear " . $user_info['first_name'] . " " . $user_info['last_name'] . " ,<br/><br/><b>" . $this->session->userdata('name') . "</b> has sent you a query regarding the data submitted by you for <b>" . $form_details['title'] . "</b> on " . $get_userid['reg_date_time'] . " in Result Tracker.<br/><br/>Please visit the MPRO AVISA Reporting 2020 platform to view the query.<br/><br/>You can either respond to the query by providing an explanation or you can edit your data if required and submit again.<br/><br/>Regards,<br/>MPRO team");
			if (!$this->email->send()) {
				show_error($this->email->print_debugger());
			}
		}
		echo json_encode(array(
			'status' => 1,
			'msg' => 'Data sent back to user with you query.'
		));
		exit();
	}

	public function query_data()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$tablename = "ic_form_data";
		$year_id = $this->uri->segment(3);
		$country_id = $this->uri->segment(4);
		$crop_id = $this->uri->segment(5);
		$form_id = $this->uri->segment(6);
		$datatype = $this->uri->segment(7);
		$user_id = $this->session->userdata('login_id');

		$user_role = $this->session->userdata('role');

		if ($year_id == '' || $form_id == '' || $datatype == '') {
			show_404();
		}

		$this->db->select('relation_id');
		$this->db->where('lkp_year', $year_id)->where('form_type', $form_id)->where('relation_status', 1);
		$check_form = $this->db->get('rpt_form_relation')->num_rows();

		if ($check_form = 0) {
			show_404();
		}

		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		if ($check_group_fields > 0) {
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('child_id');
			$this->db->where('form_id',  $form_id);
			$this->db->where_in('field_id', $get_group_id_array);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->result_array();

			$get_group_fields_array = array();

			foreach ($get_group_fields as $key => $value) {
				$field_array = explode(",", $value['child_id']);

				foreach ($field_array as $key => $field) {
					array_push($get_group_fields_array, $field);
				}
			}

			$this->db->select('field_id, label, type, subtype');
			$this->db->where('status', 1)->where('form_id',  $form_id);
			$this->db->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('type !=', 'group')->where('type !=', 'header')->where('type !=', 'uploadgroupdata_excel');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(up.first_name, " ", up.last_name) as useaprrname, lc.crop_name, lcou.country_name');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			$this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			$this->db->join('lkp_crop AS lc', 'sur.crop_id = lc.crop_id');
			$this->db->join('lkp_country AS lcou', 'sur.country_id = lcou.country_id');
			if ($user_role == 3) {
				$this->db->where('sur.user_id', $user_id);
			}
			//$this->db->where_in('sur.status', array(2, 3));
			$this->db->where('sur.query_status', $datatype);
			$this->db->where('year_id', $year_id);
			$this->db->where('sur.country_id', $country_id);
			$this->db->where('sur.crop_id', $crop_id);
			$this->db->where('form_id', $form_id);
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();

			$group_table = "ic_form_group_data";

			foreach ($form_data as $dkey => $data) {
				$this->db->where('data_id', $data['data_id']);
				$this->db->where_in('status', array(2,3));
				$form_data[$dkey]['groupdata'] = $this->db->get($group_table)->result_array();
			}

			$group_array = array();

			foreach ($get_group_id_array as $groupkey => $groupid) {
				$this->db->select('field_id, label, child_id');
				$this->db->where('field_id', $groupid)->where('status', 1);
				$group_info = $this->db->get('form_field')->row_array();

				$group_fields = explode(",", $group_info['child_id']);

				$group_array[$groupkey]['group_lable'] = $group_info;

				$this->db->select('*');
				$this->db->where_in('field_id', $group_fields)->where('status', 1)->order_by('slno');
				$group_array[$groupkey]['group_fields'] = $this->db->get('form_field')->result_array();
			}

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data, 'group_array' => $group_array);

			$result['group_table'] = $group_table;
		} else {
			$this->db->select('field_id, label, type, subtype');
			$this->db->where('status', 1)->where('form_id',  $form_id)->where('type !=', 'group')->where('type !=', 'header')->where('type !=', 'uploadgroupdata_excel');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, lc.crop_name, lcou.country_name');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			$this->db->join('lkp_crop AS lc', 'sur.crop_id = lc.crop_id');
			$this->db->join('lkp_country AS lcou', 'sur.country_id = lcou.country_id');
			if ($user_role == 3) {
				$this->db->where('sur.user_id', $user_id);
			}
			//$this->db->where_in('sur.status', array(2, 3));
			$this->db->where('sur.query_status', $datatype);
			$this->db->where('year_id', $year_id);
			$this->db->where('sur.country_id', $country_id);
			$this->db->where('sur.crop_id', $crop_id);
			$this->db->where('form_id', $form_id);
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data);
		}

		$this->db->select('*');
		$this->db->where('id', $form_id);
		$result['title'] = $this->db->get('form')->row_array();
		$result['form_id'] = $form_id;

		$result['tablename'] = $tablename;

		$this->load->view('common/header');
		$this->load->view('dashboard/query_data', $result);
		$this->load->view('common/footer');
	}

	public function get_query_list()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
			exit();
		}

		$data_id = $this->input->post('data_id');
		if (!$data_id || strlen($data_id) == 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}

		// Get data details
		$details = $this->db->where('data_id', $data_id)->get('ic_form_data');
		if ($details->num_rows() === 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}

		$details = $details->row_array();
		// Get all queries of data
		$this->db->select('tu.first_name, tu.last_name, idq.*');
		$this->db->join('tbl_users AS tu', 'tu.user_id = idq.sent_by');
		$this->db->where('idq.status', 1)->where('idq.data_id', $data_id);
		$queries = $this->db->get('ic_data_query AS idq')->result_array();

		echo json_encode(array(
			'status' => 1,
			'details' => $details,
			'queries' => $queries
		));
		exit();
	}
	public function get_result_tracker_query_list()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
			exit();
		}

		$data_id = $this->input->post('data_id');
		if (!$data_id || strlen($data_id) == 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}

		// Get data details
		$details = $this->db->where('data_id', $data_id)->get('resulttracker_reviews');
		if ($details->num_rows() === 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}

		$details = $details->row_array();
		// Get all queries of data
		$this->db->select('tu.first_name, tu.last_name, rq.*');
		$this->db->join('tbl_users AS tu', 'tu.user_id = rq.sent_by');
		$this->db->where('rq.status', 1)->where('rq.data_id', $data_id);
		$queries = $this->db->get('resulttracker_query AS rq')->result_array();

		echo json_encode(array(
			'status' => 1,
			'details' => $details,
			'queries' => $queries
		));
		exit();
	}

	public function respond_query()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
			exit();
		}

		$id = $this->input->post('id');
		$query = $this->input->post('query');
		if (!$id || strlen($id) == 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}

		// Get data details
		$details = $this->db->where('data_id', $id)->get('ic_form_data');
		if ($details->num_rows() === 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}

		$details = $details->row_array();

		$validation_error = array('status' => 1, 'errors' => array());
		if (!$query || strlen($query) === 0) {
			$validation_error['status'] = 0;
			$validation_error['errors']['query'] = 'Query is mandatory.';
		} else if (strlen($query) > 5000) {
			$validation_error['status'] = 0;
			$validation_error['errors']['query'] = 'Query must be within 5000 characters.';
		}

		if ($validation_error['status'] == 0) {
			echo json_encode($validation_error);
			exit();
		}
		date_default_timezone_set("UTC");

		// Insert query
		$insertQuery =  array(
			'data_id' => $id,
			'query' => $query,
			'sent_by' => $this->session->userdata('login_id'),
			// 'sent_to' => $details['user_id'],
			'query_datetime' => date('Y-m-d H:i:s'),
			'ip_address' => $this->input->ip_address(),
			'status' => 1
		);
		$this->db->insert('ic_data_query', $insertQuery);

		if ($details['user_id'] == $this->session->userdata('login_id')) {
			$query_array = array(
				'query_status' => 2
			);
		} else {
			$query_array = array(
				'query_status' => 1
			);
		}
		$this->db->where('data_id', $id);
		$this->db->update('ic_form_data', $query_array);

		// Get user details
		$user = $this->db->where('user_id', $this->session->userdata('login_id'))->get('tbl_users')->row_array();
		$insertQuery['first_name'] = $user['first_name'];
		$insertQuery['last_name'] = $user['last_name'];

		echo json_encode(array(
			'status' => 1,
			'query' => $insertQuery,
			'msg' => 'Responded successfully.'
		));
		exit();
	}
	public function respond_result_tracker_query()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
			exit();
		}

		$id = $this->input->post('id');
		$query = $this->input->post('query');
		if (!$id || strlen($id) == 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}

		// Get data details
		$details = $this->db->where('data_id', $id)->get('resulttracker_reviews');
		if ($details->num_rows() === 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}

		$details = $details->row_array();

		$validation_error = array('status' => 1, 'errors' => array());
		if (!$query || strlen($query) === 0) {
			$validation_error['status'] = 0;
			$validation_error['errors']['query'] = 'Query is mandatory.';
		} else if (strlen($query) > 5000) {
			$validation_error['status'] = 0;
			$validation_error['errors']['query'] = 'Query must be within 5000 characters.';
		}

		if ($validation_error['status'] == 0) {
			echo json_encode($validation_error);
			exit();
		}
		date_default_timezone_set("UTC");

		// Insert query
		$insertQuery =  array(
			'data_id' => $id,
			'query' => $query,
			'sent_by' => $this->session->userdata('login_id'),
			// 'sent_to' => $details['user_id'],
			'query_datetime' => date('Y-m-d H:i:s'),
			'ip_address' => $this->input->ip_address(),
			'status' => 1
		);
		$this->db->insert('resulttracker_query', $insertQuery);

		if ($details['user_id'] == $this->session->userdata('login_id')) {
			$query_array = array(
				'query_status' => 2
			);
		} else {
			$query_array = array(
				'query_status' => 1
			);
		}
		$this->db->where('data_id', $id);
		$this->db->update('resulttracker_reviews', $query_array);

		// Get user details
		$user = $this->db->where('user_id', $this->session->userdata('login_id'))->get('tbl_users')->row_array();
		$insertQuery['first_name'] = $user['first_name'];
		$insertQuery['last_name'] = $user['last_name'];

		echo json_encode(array(
			'status' => 1,
			'query' => $insertQuery,
			'msg' => 'Responded successfully.'
		));
		exit();
	}

	public function user_uploadinfo(){
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
		$this->load->view('dashboard/user_uploadinfo', $result);
		$this->load->view('common/footer');
	}

	public function get_useruploadinfo()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
			exit();
		}

		$country = $this->input->post('country');
		$crop = $this->input->post('crop');
		$year = $this->input->post('year');
		$po_id = $this->input->post('po_id');

		$this->db->select('GROUP_CONCAT(form_id) as ids');
		$this->db->where_in('form_type', array(2,3))->where('relation_status', 1)->where('lkp_po_id', $po_id);
		$form_ids = $this->db->get('rpt_form_relation')->row_array();

		$form_ids_arrays = explode(",", $form_ids['ids']);
		
		$this->db->distinct();
		$this->db->select('user.user_id, user.first_name, user.last_name, user.email_id, user.role_id');
		$this->db->from('tbl_user_country_crop as ucc');
		$this->db->join('tbl_users as user', 'user.user_id = ucc.user_id');
		$this->db->where('ucc.year_id', $year)->where('ucc.status', 1)->where('user.status',1);
		if($country != 'all'){
			$this->db->where('ucc.country_id', $country);
		}
		if($crop != 'all'){
			$this->db->where('ucc.crop_id', $crop);
		}
		$user_list = $this->db->get()->result_array();

		foreach ($user_list as $key => $user) {
			$this->db->distinct();
			$this->db->select('indicator_id');
			$this->db->where('po_id', $po_id)->where('indicator_id IS NOT NULL')->where('status', 1)->where('year_id', $year)->where('user_id', $user['user_id']);
			$user_assignedindicators = $this->db->get('tbl_user_indicator')->num_rows();

			$this->db->select('id');
			$this->db->where('po_id', $po_id)->where('sub_indicator_id IS NOT NULL')->where('status', 1)->where('year_id', $year)->where('user_id', $user['user_id']);
			$user_assignedsubindicators = $this->db->get('tbl_user_indicator')->num_rows();

			$user_list[$key]['user_assignedindicators'] = $user_assignedindicators;
			$user_list[$key]['user_assignedsubindicators'] = $user_assignedsubindicators;

			$user_list[$key]['user_assignedindicators_count'] = $user_assignedindicators + $user_assignedsubindicators;

			$this->db->select('data_id');
			$this->db->where('year_id', $year)->where('status', 1)->where('user_id', $user['user_id'])->where_in('form_id', $form_ids_arrays);
			if($country != 'all'){
                $this->db->where('country_id', $country);
            }
            if($crop != 'all'){
                $this->db->where('crop_id', $crop);
            }
			$user_list[$key]['user_savecount'] = $this->db->get('ic_form_data')->num_rows();

			$this->db->select('data_id');
			$this->db->where('year_id', $year)->where('status', 2)->where('user_id', $user['user_id'])->where_in('form_id', $form_ids_arrays);
			if($country != 'all'){
                $this->db->where('country_id', $country);
            }
            if($crop != 'all'){
                $this->db->where('crop_id', $crop);
            }
			$user_list[$key]['user_submittedcount'] = $this->db->get('ic_form_data')->num_rows();

			$this->db->select('data_id');
			$this->db->where('year_id', $year)->where('status', 3)->where('user_id', $user['user_id'])->where_in('form_id', $form_ids_arrays);
			if($country != 'all'){
                $this->db->where('country_id', $country);
            }
            if($crop != 'all'){
                $this->db->where('crop_id', $crop);
            }
			$user_list[$key]['user_approvedcount'] = $this->db->get('ic_form_data')->num_rows();

			$this->db->select('data_id');
			$this->db->where('year_id', $year)->where('status !=', 0)->where('user_id', $user['user_id'])->where_in('form_id', $form_ids_arrays);
			if($country != 'all'){
                $this->db->where('country_id', $country);
            }
            if($crop != 'all'){
                $this->db->where('crop_id', $crop);
            }
			$user_list[$key]['user_uploadcount'] = $this->db->get('ic_form_data')->num_rows();

			//unique indicators reported
			$this->db->distinct();
			$this->db->select('form_id');
			$this->db->where('year_id', $year)->where_not_in('status', array(0,1))->where('user_id', $user['user_id'])->where_in('form_id', $form_ids_arrays);
			if($country != 'all'){
                $this->db->where('country_id', $country);
            }
            if($crop != 'all'){
                $this->db->where('crop_id', $crop);
            }
			$user_list[$key]['unique_indicatorsreported'] = $this->db->get('ic_form_data')->num_rows();
		}

		echo json_encode(array(
			'status' => 1,
			'user_list' => $user_list			
		));
		exit();
	}

	public function get_indicatorwisecount()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
			exit();
		}

		$country = $this->input->post('country');
		$crop = $this->input->post('crop');
		$year = $this->input->post('year');
		$po_id = $this->input->post('po_id');

		$data = array(
			'country' => $country,
			'crop' => $crop,
			'year' => $year,
			'po_id' => $po_id
		);

		if(isset($_POST['user_id'])){
			$user_id = $this->input->post('user_id');
			$data['user_id'] = $user_id;
		}

		$outputs = $this->Dashboard_model->monitoring_evauation($data);

        echo json_encode(array(
			'status' => 1,
			'outputs' => $outputs			
		));
		exit();
	}

	public function monitoring_evaluation()
	{
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
		$this->load->view('dashboard/monitoring_evaluation', $result);
		$this->load->view('common/footer');
	}

	public function display_data()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$tablename = "ic_form_data";
		$year_id = $this->uri->segment(3);
		$country_id = $this->uri->segment(4);
		$crop_id = $this->uri->segment(5);
		$form_id = $this->uri->segment(6);
		$datatype = $this->uri->segment(7);
		$user_id = $this->uri->segment(8);

		if ($year_id == '' || $country_id == '' || $crop_id == '' || $form_id == '' || $datatype == '') {
			show_404();
		}

		$this->db->select('relation_id');
		$this->db->where('lkp_year', $year_id)->where('form_type', $form_id)->where('relation_status', 1);
		$check_form = $this->db->get('rpt_form_relation')->num_rows();

		if ($check_form = 0) {
			show_404();
		}

		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		if ($check_group_fields > 0) {
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('child_id');
			$this->db->where('form_id',  $form_id);
			$this->db->where_in('field_id', $get_group_id_array);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->result_array();

			$get_group_fields_array = array();

			foreach ($get_group_fields as $key => $value) {
				$field_array = explode(",", $value['child_id']);

				foreach ($field_array as $key => $field) {
					array_push($get_group_fields_array, $field);
				}
			}

			$this->db->select('field_id, label, type, subtype');
			$this->db->where('status', 1)->where('form_id',  $form_id);
			$this->db->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(up.first_name, " ", up.last_name) as useaprrname, lc.crop_name, lcou.country_name');
			//$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, lc.crop_name, lcou.country_name');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			$this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			$this->db->join('lkp_crop AS lc', 'sur.crop_id = lc.crop_id');
			$this->db->join('lkp_country AS lcou', 'sur.country_id = lcou.country_id');
			switch ($datatype) {
				case '2':
					$this->db->where_in('sur.status', array(2, 3));
					break;

				case 'pending_approval':
					$this->db->where('sur.status', 2);
					break;

				default:
					$this->db->where('sur.status', $datatype);
					break;
			}
			$this->db->where('year_id', $year_id);
			if($country_id != 'all'){
				$this->db->where('sur.country_id', $country_id);
			}
			if($crop_id != 'all'){
				$this->db->where('sur.crop_id', $crop_id);
			}
			if($user_id != ''){
				$this->db->where('sur.user_id', $user_id);
			}
			$this->db->where('form_id', $form_id);
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();

			$group_table = "ic_form_group_data";

			foreach ($form_data as $dkey => $data) {
				$this->db->where('data_id', $data['data_id']);
				switch ($datatype) {
					case '2':
						$this->db->where_in('status', array(2, 3));
						break;

					case 'pending_approval':
						$this->db->where('status', 2);
						break;

					default:
						$this->db->where('status', $datatype);
						break;
				}
				$form_data[$dkey]['groupdata'] = $this->db->get($group_table)->result_array();
			}

			$group_array = array();

			foreach ($get_group_id_array as $groupkey => $groupid) {
				$this->db->select('field_id, label, child_id');
				$this->db->where('field_id', $groupid)->where('status', 1);
				$group_info = $this->db->get('form_field')->row_array();

				$group_fields = explode(",", $group_info['child_id']);

				$group_array[$groupkey]['group_lable'] = $group_info;

				$this->db->select('*');
				$this->db->where_in('field_id', $group_fields)->where('status', 1)->order_by('slno');
				$group_array[$groupkey]['group_fields'] = $this->db->get('form_field')->result_array();
			}

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data, 'group_array' => $group_array);

			$result['group_table'] = $group_table;
		} else {
			$this->db->select('field_id, label, type, subtype');
			$this->db->where('status', 1)->where('form_id',  $form_id)->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(up.first_name, " ", up.last_name) as useaprrname, lc.crop_name, lcou.country_name');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			$this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			$this->db->join('lkp_crop AS lc', 'sur.crop_id = lc.crop_id');
			$this->db->join('lkp_country AS lcou', 'sur.country_id = lcou.country_id');
			switch ($datatype) {
				case '2':
					$this->db->where_in('sur.status', array(2, 3));
					break;

				case 'pending_approval':
					$this->db->where('sur.status', 2);
					break;

				default:
					$this->db->where('sur.status', $datatype);
					break;
			}
			$this->db->where('year_id', $year_id);
			if($country_id != 'all'){
				$this->db->where('sur.country_id', $country_id);
			}
			if($crop_id != 'all'){
				$this->db->where('sur.crop_id', $crop_id);
			}
			if($user_id != ''){
				$this->db->where('sur.user_id', $user_id);
			}
			$this->db->where('form_id', $form_id);
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data);
		}

		$this->db->select('*');
		$this->db->where('id', $form_id);
		$result['title'] = $this->db->get('form')->row_array();
		$result['form_id'] = $form_id;

		$result['tablename'] = $tablename;

		$this->load->view('common/header');
		$this->load->view('dashboard/form_data_monitoring', $result);
		$this->load->view('common/footer');
	}

	public function displayquery_data()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$tablename = "ic_form_data";
		$year_id = $this->uri->segment(3);
		$country_id = $this->uri->segment(4);
		$crop_id = $this->uri->segment(5);
		$form_id = $this->uri->segment(6);
		$datatype = $this->uri->segment(7);
		$user_id = $this->uri->segment(8);

		if ($year_id == '' || $country_id == '' || $crop_id == '' || $form_id == '' || $datatype == '') {
			show_404();
		}

		$this->db->select('relation_id');
		$this->db->where('lkp_year', $year_id)->where('form_type', $form_id)->where('relation_status', 1);
		$check_form = $this->db->get('rpt_form_relation')->num_rows();

		if ($check_form = 0) {
			show_404();
		}

		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		if ($check_group_fields > 0) {
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('child_id');
			$this->db->where('form_id',  $form_id);
			$this->db->where_in('field_id', $get_group_id_array);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->result_array();

			$get_group_fields_array = array();

			foreach ($get_group_fields as $key => $value) {
				$field_array = explode(",", $value['child_id']);

				foreach ($field_array as $key => $field) {
					array_push($get_group_fields_array, $field);
				}
			}

			$this->db->select('field_id, label, type, subtype');
			$this->db->where('status', 1)->where('form_id',  $form_id);
			$this->db->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(up.first_name, " ", up.last_name) as useaprrname, lc.crop_name, lcou.country_name');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			$this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			$this->db->join('lkp_crop AS lc', 'sur.crop_id = lc.crop_id');
			$this->db->join('lkp_country AS lcou', 'sur.country_id = lcou.country_id');
			$this->db->where('sur.query_status', $datatype);
			$this->db->where('year_id', $year_id);
			if($country_id != 'all'){
				$this->db->where('sur.country_id', $country_id);
			}
			if($crop_id != 'all'){
				$this->db->where('sur.crop_id', $crop_id);
			}
			if($user_id != ''){
				$this->db->where('sur.user_id', $user_id);
			}
			$this->db->where('form_id', $form_id);
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();

			$group_table = "ic_form_group_data";

			foreach ($form_data as $dkey => $data) {
				$this->db->where('data_id', $data['data_id']);
				$this->db->where_in('status', array(2,3));
				$form_data[$dkey]['groupdata'] = $this->db->get($group_table)->result_array();
			}

			$group_array = array();

			foreach ($get_group_id_array as $groupkey => $groupid) {
				$this->db->select('field_id, label, child_id');
				$this->db->where('field_id', $groupid)->where('status', 1);
				$group_info = $this->db->get('form_field')->row_array();

				$group_fields = explode(",", $group_info['child_id']);

				$group_array[$groupkey]['group_lable'] = $group_info;

				$this->db->select('*');
				$this->db->where_in('field_id', $group_fields)->where('status', 1)->order_by('slno');
				$group_array[$groupkey]['group_fields'] = $this->db->get('form_field')->result_array();
			}

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data, 'group_array' => $group_array);

			$result['group_table'] = $group_table;
		} else {
			$this->db->select('field_id, label, type, subtype');
			$this->db->where('status', 1)->where('form_id',  $form_id)->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, lc.crop_name, lcou.country_name');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			$this->db->join('lkp_crop AS lc', 'sur.crop_id = lc.crop_id');
			$this->db->join('lkp_country AS lcou', 'sur.country_id = lcou.country_id');
			$this->db->where('sur.query_status', $datatype);
			$this->db->where('year_id', $year_id);
			if($country_id != 'all'){
				$this->db->where('sur.country_id', $country_id);
			}
			if($crop_id != 'all'){
				$this->db->where('sur.crop_id', $crop_id);
			}
			if($user_id != ''){
				$this->db->where('sur.user_id', $user_id);
			}
			$this->db->where('form_id', $form_id);
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data);
		}

		$this->db->select('*');
		$this->db->where('id', $form_id);
		$result['title'] = $this->db->get('form')->row_array();
		$result['form_id'] = $form_id;

		$result['tablename'] = $tablename;

		$this->load->view('common/header');
		$this->load->view('dashboard/query_data', $result);
		$this->load->view('common/footer');
	}

	//result tracker
	public function result_tracker(){
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
		$this->load->view('dashboard/result_tracker', $result);
		$this->load->view('common/footer');
	}

	public function calculate_result_tracker(){
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
			exit();
		}

		$country = $this->input->post('country');
		$crop = $this->input->post('crop');
		$year = $this->input->post('year');
		$po_id = $this->input->post('po_id');

		$data = array(
			'country' => $country,
			'crop' => $crop,
			'year' => $year,
			'po_id' => $po_id
		);

		if(isset($_POST['user_id'])){
			$user_id = $this->input->post('user_id');
			$data['user_id'] = $user_id;
		}

		$outputs = $this->Dashboard_model->calculate_result_tracker($data);

		$result = array(
			'status' => 1,
			'outputs' => $outputs			
		);

		if ($this->session->userdata('role') != 4 || $this->session->userdata('role') != 5) {
			$get_userindicator_list = $this->db->select('GROUP_CONCAT(indicator_id) as ids')->where('user_id', $this->session->userdata('login_id'))->where('year_id', $year)->where('po_id', $po_id)->where('status', 1)->get('tbl_user_resulttrack_indicator')->row_array();

			$result['userindicator_list'] = explode(",", $get_userindicator_list['ids']);
		}

        echo json_encode($result);
		exit();
	}

	public function downloadall_pos_resulttracker(){
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		require(APPPATH .'third_party/PHPExcel.php');
	   	require(APPPATH .'third_party/PHPExcel/Writer/Excel2007.php');

	   	$year_id = $this->uri->segment(3);
	   	if($year_id == ''){
	   		show_404();
	   	}

	   	$this->db->select('GROUP_CONCAT(DISTINCT country_id) as countryids, GROUP_CONCAT(DISTINCT crop_id) as cropids');
	   	$this->db->where('year_id', $year_id)->where('status', 1);
	   	$unique_countries = $this->db->get('lkp_country_crop')->row_array();

	   	$po_ids = $this->db->select('GROUP_CONCAT(po_id) as poids')->where('po_status', 1)->get('lkp_po')->row_array();

	   	/*$country = explode(',', $unique_countries['countryids']);
		$crop = explode(',', $unique_countries['cropids']);
		$year = $year_id;*/

		$country = $this->input->post('country');
		$crop = $this->input->post('crop');
		$year = $this->input->post('year');

		$po_id = explode(',', $po_ids['poids']);

		$data = array(
			'country' => $country,
			'crop' => $crop,
			'year' => $year,
			'po_id' => $po_id
		);

		$outputs = $this->Dashboard_model->calculate_result_tracker($data);

	   	$objPHPExcel = new PHPExcel();

	   	$objPHPExcel->getProperties()->setCreator("");
	   	$objPHPExcel->getProperties()->setLastModifiedBy("");
	   	$objPHPExcel->getProperties()->setTitle("");
	   	$objPHPExcel->getProperties()->setSubject("");
	   	$objPHPExcel->getProperties()->setDescription("");

	   	$objPHPExcel->setActiveSheetIndex(0);

	   	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'INDICATOR');
	   	/*$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'PROGRESS (%)');*/
	   	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'TARGET');
	   	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'ACTUAL');
	   	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'VARIANCE');

	   	/*$style = array(
	   		'alignment' => array(
	   			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	   		)
	   	);*/

	   	$row = 2;
	   	foreach ($outputs as $key => $output) {
	   		/*$sheet->getStyle("A1:B5")->applyFromArray($style);*/
	   		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $output['title']);
	   		$row++;
	   		if (count($output['indicator_list']) > 0) {
	   			foreach ($output['indicator_list'] as $key => $indicator) {
	   				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $indicator['title']);
					
					$variance_pre = 0;
					if($indicator['target_val'] == 0){
						$variance_pre = ($indicator['actual_val']/1)*100; 
					}else{
						$variance_pre = ($indicator['actual_val']/$indicator['target_val'])*100;
					}	
					/*$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, strval(round($variance_pre)));*/
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, strval($indicator['target_val']));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, strval($indicator['actual_val']));
						
					$variance = 0;
					$variance = $indicator['actual_val'] - $indicator['target_val'];

					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, strval(round($variance)));
					$row++;
				};
			};
	   	}

	   	$filename= "Export data.xlsx";
	   	$objPHPExcel->getActiveSheet()->setTitle('Result Tracker');
	   	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	   	header('Content-Disposition: attachment;filename="'.$filename.'"');
	   	header('Cache-Control: max-age=0');

	   	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	   	$objWriter->save('php://output');
	}

	//result tracker report
	public function add_resulttracker_report(){
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
			exit();
		}

		$country = $this->input->post('country');
		$crop = $this->input->post('crop');
		$year = $this->input->post('year');
		$form_id = $this->input->post('form_id');

		if(is_array($crop) || is_array($country)){
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Please select only one country and crop.'
			));
			exit();
		}

		$this->db->where('form_id', $form_id);
		$this->db->where('country_id', $country);
		$this->db->where('crop_id', $crop);
		$this->db->where('year_id', $year);
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$get_resulttracker_report = $this->db->get('resulttracker_reviews')->row_array();

		$get_form_details = $this->db->select('title')->where('id', $form_id)->get('form')->row_array();

		echo json_encode(array(
			'status' => 1,
			'get_resulttracker_report' => $get_resulttracker_report,
			'get_form_details' => $get_form_details
		));
		exit();
	}

	public function submit_resulttracker_report(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
			exit();
		}
		date_default_timezone_set("UTC");
		$time = time();
		$user_id = $this->session->userdata('login_id');

		$country = $this->input->post('country_id');
		$crop = $this->input->post('crop_id');
		$year = $this->input->post('year_id');
		$form_id = $this->input->post('form_id');

		$comment = $this->input->post('comment');
		if(str_word_count($comment) > 150) {
			echo json_encode(array('status' => 0, 'msg' => 'Report must be within 150 words.'));
			exit();
		}

		$check_data = $this->db->where('form_id', $form_id)->where('crop_id', $crop)->where('country_id', $country)->where('year_id', $year)->where('user_id', $this->session->userdata('login_id'))->where('status', 1)->get('resulttracker_reviews')->num_rows();

		if($check_data > 0){
			$updatedata = array(
				'report' => $this->input->post('comment'),
			);
			$this->db->where('form_id', $form_id)->where('crop_id', $crop)->where('country_id', $country)->where('year_id', $year)->where('user_id', $this->session->userdata('login_id'))->where('status', 1);
			$table_query = $this->db->update('resulttracker_reviews', $updatedata);
		}else{
			$insert_array = array(
				'data_id' => $time.'-'.$this->session->userdata('login_id'),
				'form_id' => $form_id,
				'year_id' => $year,
				'country_id' => $country,
				'crop_id' => $crop,
				'user_id' => $this->session->userdata('login_id'),
				'report' => $this->input->post('comment'),
				'reg_date_time' => date('Y-m-d H:i:s'),
				'ip_address' =>  $this->input->ip_address(),
				'status' => 1
			);
			$table_query = $this->db->insert('resulttracker_reviews', $insert_array);
		}

		if($table_query){
			echo json_encode(array(
				'status' => 1,
				'msg' => 'Submitted successfully.'
			));
			exit();
		}else{
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}
	}
	public function update_resulttracker_report(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
			exit();
		}
		date_default_timezone_set("UTC");
		$time = time();
		$user_id = $this->session->userdata('login_id');

		$country = $this->input->post('country_id');
		$crop = $this->input->post('crop_id');
		$year = $this->input->post('year_id');
		$form_id = $this->input->post('form_id');
		$data_id = $this->input->post('data_id');

		$comment = $this->input->post('comment');
		if(str_word_count($comment) > 150) {
			echo json_encode(array('status' => 0, 'msg' => 'Report must be within 150 words.'));
			exit();
		}

		$check_data = $this->db->where('form_id', $form_id)->where('crop_id', $crop)->where('country_id', $country)->where('year_id', $year)->where('data_id', $data_id)->where('status', 1)->get('resulttracker_reviews')->num_rows();

		if($check_data == 0){
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong. Please refresh the page and try again.'));
			exit();
		}

		$updatedata = array(
			'report' => $this->input->post('comment'),
		);
		$this->db->where('form_id', $form_id)->where('crop_id', $crop)->where('country_id', $country)->where('year_id', $year)->where('data_id', $data_id)->where('status', 1);
		$table_query = $this->db->update('resulttracker_reviews', $updatedata);

		if($table_query){
			echo json_encode(array(
				'status' => 1,
				'msg' => 'Data Updated successfully.'
			));
			exit();
		}else{
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}
	}

	public function view_resulttracker_report_page(){
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			// echo json_encode(array(
			// 	'status' => 0,
			// 	'msg' => 'Your session has ended. Please refrersh the page and try again.'
			// ));
			// exit();
			redirect($this->baseurl);
		}

		// $country = $this->input->post('country');
		// $crop = $this->input->post('crop');
		// $year = $this->input->post('year');
		// $form_id = $this->input->post('form_id');

		// $country = $this->input->post('country');
		// $crop = $this->input->post('crop');
		// $year = $this->input->post('year');
		// $form_id = $this->input->post('form_id');

		$form_id = $this->uri->segment(3);
		$year = $this->uri->segment(4);
		$country = $this->uri->segment(5);
		$crop = $this->uri->segment(6);

		if(!$form_id || !$year || !$country || !$crop) show_404();
		// if(is_array($crop) || is_array($country)){
		// 	if(count($crop) > 1 || count($country) > 1){
		// 		echo json_encode(array(
		// 			'status' => 0,
		// 			'msg' => 'Please select only one country and crop.'
		// 		));
		// 		exit();
		// 	}
		// }

		$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, lc.crop_name, lcou.country_name');
		$this->db->from('resulttracker_reviews as sur');
		$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
		$this->db->join('lkp_crop AS lc', 'sur.crop_id = lc.crop_id');
		$this->db->join('lkp_country AS lcou', 'sur.country_id = lcou.country_id');
		$this->db->where('form_id', $form_id);
		// if(is_array($crop)){
		// 	$this->db->where_in('sur.crop_id', $crop);
		// }else{
			$this->db->where('sur.crop_id', $crop);
		// }
		// if(is_array($country)){
		// 	$this->db->where_in('sur.country_id', $country);
		// }else{
			$this->db->where('sur.country_id', $country);
		// }
		
		$this->db->where('sur.year_id', $year);
		$get_resulttracker_report = $this->db->get()->result_array();

		$get_form_details = $this->db->select('title')->where('id', $form_id)->get('form')->row_array();

		$result = array(
			'get_resulttracker_report' => $get_resulttracker_report,
			'get_form_details' => $get_form_details,
			'form_id' => $form_id,
			'country' => $country,
			'year' => $year,
			'crop' => $crop
		);

		// echo json_encode(array(
		// 	'status' => 1,
		// 	'get_resulttracker_report' => $get_resulttracker_report,
		// 	'get_form_details' => $get_form_details
		// ));
		// exit();
		$this->load->view('common/header');
		$this->load->view('dashboard/view_resulttracker_report_page', $result);
		$this->load->view('common/footer');
	}
	public function view_resulttracker_report(){
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Your session has ended. Please refrersh the page and try again.'
			));
			exit();
		}

		$country = $this->input->post('country');
		$crop = $this->input->post('crop');
		$year = $this->input->post('year');
		$form_id = $this->input->post('form_id');

		if(is_array($crop) || is_array($country)){
			if(count($crop) > 1 || count($country) > 1){
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Please select only one country and crop.'
				));
				exit();
			}
		}

		$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, lc.crop_name, lcou.country_name');
		$this->db->from('resulttracker_reviews as sur');
		$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
		$this->db->join('lkp_crop AS lc', 'sur.crop_id = lc.crop_id');
		$this->db->join('lkp_country AS lcou', 'sur.country_id = lcou.country_id');
		$this->db->where('form_id', $form_id);
		if(is_array($crop)){
			$this->db->where_in('sur.crop_id', $crop);
		}else{
			$this->db->where('sur.crop_id', $crop);
		}
		if(is_array($country)){
			$this->db->where_in('sur.country_id', $country);
		}else{
			$this->db->where('sur.country_id', $country);
		}
		
		$this->db->where('sur.year_id', $year);
		$get_resulttracker_report = $this->db->get()->result_array();

		$get_form_details = $this->db->select('title')->where('id', $form_id)->get('form')->row_array();

		$result = array(
			'get_resulttracker_report' => $get_resulttracker_report,
			'get_form_details' => $get_form_details
		);

		echo json_encode(array(
			'status' => 1,
			'get_resulttracker_report' => $get_resulttracker_report,
			'get_form_details' => $get_form_details
		));
		exit();
	}

	/* view data start for role id 6 */
	public function viewdata()
	{
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
		$this->load->view('dashboard/viewdata', $result);
		$this->load->view('common/footer');
	}

	public function view_form_data()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$tablename = "ic_form_data";
		$year_id = $this->uri->segment(3);
		/*$country_id = $this->uri->segment(4);
		$crop_id = $this->uri->segment(5);*/
		$form_id = $this->uri->segment(4);
		$datatype = $this->uri->segment(5);
		// $user_dataid = $this->uri->segment(6);
		$user_id = $this->session->userdata('login_id');
		$program_id = $this->uri->segment(7);

		$user_role = $this->session->userdata('role');

		if ($year_id == '' || $form_id == '' || $datatype == '') {
			show_404();
		}

		$this->db->select('relation_id');
		$this->db->where('lkp_year', $year_id)->where('form_type', $form_id)->where('relation_status', 1);
		$check_form = $this->db->get('rpt_form_relation')->num_rows();

		if ($check_form = 0) {
			show_404();
		}
		$this->db->select('*');
		$this->db->where('status', 1);
		$lkp_country = $this->db->get('lkp_country')->result_array();

		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		if ($check_group_fields > 0) {
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('child_id');
			$this->db->where('form_id',  $form_id);
			$this->db->where_in('field_id', $get_group_id_array);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->result_array();

			$get_group_fields_array = array();

			foreach ($get_group_fields as $key => $value) {
				$field_array = explode(",", $value['child_id']);

				foreach ($field_array as $key => $field) {
					array_push($get_group_fields_array, $field);
				}
			}

			$this->db->select('field_id, label, type, subtype, multiple');
			// $this->db->where('status', 1)->where('form_id',  $form_id)->where('parent_id IS NULL')->where('parent_value IS NULL');
			$this->db->where('status', 1)->where('form_id',  $form_id);
			$this->db->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(up.first_name, " ", up.last_name) as useaprrname, y.year as yearname, rp.rperiod_name as rpname, c.country_name as cname, cr.crop_name as crname');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('lkp_year as y', 'sur.year_id = y.year_id');
			$this->db->join('lkp_rperiod as rp', 'sur.rperiod_id = rp.rperiod_id');
			$this->db->join('lkp_country as c', 'sur.country_id = c.country_id');
			$this->db->join('lkp_crop as cr', 'sur.crop_id = cr.crop_id');
			// $this->db->join('lkp_sdg as sdg', 'sur.sdg_id = sdg.sdg_id');
			// $this->db->join('ic_data_file as df', 'sur.data_id = df.data_id','left');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			// $this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			if($datatype != 4){
				$this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
				}else{
				$this->db->join('tbl_users as up', 'sur.rejected_by = up.user_id','left');
				}
			if ($user_role == 3) {
				$this->db->where('sur.user_id', $user_id);
			}
			switch ($datatype) {
				case '2':
					$this->db->where_in('sur.status', array(2));
					// $this->db->where_in('sur.status', array(2, 3));
					break;

				case 'pending_approval':
					$this->db->where('sur.status', 2);
					break;

				default:
					$this->db->where('sur.status', $datatype);
					break;
			}
			// if ($user_dataid != '') {
			// 	$this->db->where('sur.user_id', $user_dataid);
			// }
			$this->db->where('sur.year_id', $year_id);
			$this->db->where('sur.form_id', $form_id);
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();

			$group_table = "ic_form_group_data";

			foreach ($form_data as $dkey => $data) {
				//newly added SDG data geting into formadata lsit array
				$sdg_ids_array = explode(",", $data['sdg_id']);
				$sdg_sub_ids_array = explode(",", $data['sdg_sub_id']);
				$this->db->select('*');
				$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				$form_data[$dkey]['sdg_list'] = $this->db->get('lkp_sdg')->result_array();
				$this->db->select('*');
				$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				$form_data[$dkey]['sdg_sub_list'] = $this->db->get('lkp_sdg_sub')->result_array();
				// $sql = $this->db->last_query();
				$file_list_array = array();
				$this->db->select('*');
				$this->db->where('data_id', $data['data_id'])->where('status', 1);
				$file_list_array = $this->db->get('ic_data_file')->result_array();
				$form_data[$dkey]['file_list_array'] = $file_list_array;
				$file_list_array = array();
				$this->db->select('*');
				$this->db->where('data_id', $data['data_id'])->where('status', 1);
				$file_list_array = $this->db->get('ic_data_file')->result_array();
				$form_data[$dkey]['file_list_array'] = $file_list_array;

				$this->db->where('data_id', $data['data_id']);
				switch ($datatype) {
					case '2':
						// $this->db->where_in('status', array(2));
						$this->db->where_in('status', array(2, 3,4));
						break;

					case 'pending_approval':
						$this->db->where('status', 2);
						break;

					default:
						$this->db->where('status', $datatype);
						break;
				}
				$form_data[$dkey]['groupdata'] = $this->db->get($group_table)->result_array();
			}

			$group_array = array();

			foreach ($get_group_id_array as $groupkey => $groupid) {
				$this->db->select('field_id, label, child_id, multiple');
				$this->db->where('field_id', $groupid)->where('status', 1);
				$group_info = $this->db->get('form_field')->row_array();

				$group_fields = explode(",", $group_info['child_id']);

				$group_array[$groupkey]['group_lable'] = $group_info;

				$this->db->select('*');
				$this->db->where_in('field_id', $group_fields)->where('status', 1)->order_by('slno');
				$group_array[$groupkey]['group_fields'] = $this->db->get('form_field')->result_array();
			}

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data, 'group_array' => $group_array, 'lkp_country' => $lkp_country);

			$result['group_table'] = $group_table;
		} else {
			$this->db->select('field_id, label, type, subtype, multiple');
			// $this->db->where('status', 1)->where('form_id',  $form_id)->where('parent_id IS NULL')->where('parent_value IS NULL');
			$this->db->where('status', 1)->where('form_id',  $form_id);
			$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, CONCAT(up.first_name, " ", up.last_name) as useaprrname, y.year as yearname, rp.rperiod_name as rpname, c.country_name as cname, cr.crop_name as crname');
			$this->db->from('' . $tablename . ' as sur');
			$this->db->join('lkp_year as y', 'sur.year_id = y.year_id');
			$this->db->join('lkp_rperiod as rp', 'sur.rperiod_id = rp.rperiod_id');
			$this->db->join('lkp_country as c', 'sur.country_id = c.country_id');
			$this->db->join('lkp_crop as cr', 'sur.crop_id = cr.crop_id');
			// $this->db->join('lkp_sdg as sdg', 'sur.sdg_id = sdg.sdg_id');
			// $this->db->join('ic_data_file as df', 'sur.data_id = df.data_id','left');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			if($datatype != 4){
			$this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			}else{
			$this->db->join('tbl_users as up', 'sur.rejected_by = up.user_id','left');
			}
			// $this->db->join('tbl_users as up', 'sur.approve_by = up.user_id','left');
			if ($user_role == 3) {
				$this->db->where('sur.user_id', $user_id);
			}
			switch ($datatype) {
				case '2':
					$this->db->where_in('sur.status', array(2));
					// $this->db->where_in('sur.status', array(2, 3));
					break;

				case 'pending_approval':
					$this->db->where('sur.status', 2);
					break;

				default:
					$this->db->where('sur.status', $datatype);
					break;
			}
			$this->db->where('sur.year_id', $year_id);
			$this->db->where('sur.form_id', $form_id);
			// if ($user_dataid != '') {
			// 	$this->db->where('sur.user_id', $user_dataid);
			// }
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();
			foreach ($form_data as $dkey => $data) {
				//newly added SDG data geting into formadata lsit array
				// $sdg_ids_array = explode(",", $data['sdg_id']);
				// if($data['sdg_id']!= NULL || $data['sdg_id']!= ""){
				// 	$this->db->select('GROUP_CONCAT(sdg_name) as sdg_names');
				// 	$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				// 	$sdg_data = $this->db->get('lkp_sdg')->row_array();
				// 	$form_data[$dkey]['sdgname'] = $sdg_data['sdg_names'];
				// }else{
				// 	$form_data[$dkey]['sdgname'] = "N/A";
				// }
				// $sdg_sub_ids_array = explode(",", $data['sdg_sub_id']);
				// if($data['sdg_sub_id']!= NULL || $data['sdg_sub_id']!= ""){
				// 	$this->db->select('GROUP_CONCAT(sdg_sub_name) as sdg_sub_names');
				// 	$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				// 	$sdg_sub_data = $this->db->get('lkp_sdg_sub')->row_array();
				// 	$form_data[$dkey]['sdg_sub_name'] = $sdg_sub_data['sdg_sub_names'];
				// }else{
				// 	$form_data[$dkey]['sdg_sub_name'] = "N/A";
				// }
				$sdg_ids_array = explode(",", $data['sdg_id']);
				$sdg_sub_ids_array = explode(",", $data['sdg_sub_id']);
				$this->db->select('*');
				$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				$form_data[$dkey]['sdg_list'] = $this->db->get('lkp_sdg')->result_array();
				$this->db->select('*');
				$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				$form_data[$dkey]['sdg_sub_list'] = $this->db->get('lkp_sdg_sub')->result_array();
				// $sql = $this->db->last_query();
				$file_list_array = array();
				$this->db->select('*');
				$this->db->where('data_id', $data['data_id'])->where('status', 1);
				$file_list_array = $this->db->get('ic_data_file')->result_array();
				$form_data[$dkey]['file_list_array'] = $file_list_array;
			}

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data, 'lkp_country' => $lkp_country);
		}

		$this->db->select('*');
		$this->db->where('id', $form_id);
		$result['title'] = $this->db->get('form')->row_array();
		$result['form_id'] = $form_id;

		$result['tablename'] = $tablename;

		$this->load->view('common/header');
		$this->load->view('dashboard/view_form_data', $result);
		$this->load->view('common/footer');
	}
	
	public function download_data()
	{
		$form_id = $this->input->post('form_id');
		
		$this->load->model('Reporting_model');
		$this->db->select('*');
		$this->db->where('status', 1);
		$lkp_country = $this->db->get('lkp_country')->result_array();
		$this->load->model('Reporting_model');
		$this->db->select('*');
		$this->db->where('id', $form_id)->where('status', 1);
		$form_title_list = $this->db->get('form')->row_array();
		$form_title = $form_title_list['title'];
		$group_fields = array();
		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();
		$get_group_id_array = array();
		$group_status="No";
		$get_m_group_fields_array = array();
		$get_m_group_fields_array['group_ids'] = array();
        if ($check_group_fields > 0) {
			$group_status="Yes";
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('child_id');
			$this->db->where('form_id',  $form_id);
			$this->db->where_in('field_id', $get_group_id_array);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->result_array();

			$get_group_fields_array = array();

			foreach ($get_group_fields as $key => $value) {
				$field_array = explode(",", $value['child_id']);

				foreach ($field_array as $key => $field) {
					array_push($get_group_fields_array, $field);
				}
			}
			$this->db->select('child_id');
			$this->db->where('form_id',  $form_id);
			$this->db->where_in('parent_id', $get_group_fields_array);
			$this->db->where('status', 1);
			$get_group_child_fields = $this->db->get('form_field')->result_array();

			$this->db->select('field_id, label, type, subtype');
			$this->db->where('status', 1)->where('form_id',  $form_id);
			$this->db->where_in('field_id', $get_group_fields_array);
			$this->db->order_by('slno');
			$group_fields = $this->db->get('form_field')->result_array();
			// if ($check_group_fields > 1) {
				foreach ($get_group_id_array as $gfr_key => $gfr_records_val) {
					$get_m_group_fields_array['group_ids'] =$get_group_id_array;
					$this->db->select('child_id');
					$this->db->where('form_id',  $form_id);
					$this->db->where('field_id', $gfr_records_val);
					$this->db->where('status', 1);
					$get_group_fields = $this->db->get('form_field')->result_array();
					foreach ($get_group_fields as $key => $value) {
						$field_array = explode(",", $value['child_id']);
						foreach ($field_array as $key => $field) {
							// $get_m_group_fields_array[$gfr_key][$gfr_records_val]= $field_array;
						}
						$get_m_group_fields_array[$gfr_records_val]['child_fileds_'.$key]= $field_array;
					}
				}
			// }
		}
		$this->db->select('field_id, label, type, subtype, multiple');
		$this->db->where('status', 1)->where('form_id',  $form_id);
		if(isset($get_group_fields_array)){
			$this->db->where_not_in('field_id', $get_group_fields_array);
		}
		$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
		$this->db->order_by('slno');
		$form_fields = $this->db->get('form_field')->result_array();		

		$this->db->select('*');
		// $this->db->where('form_id', $form_id)->where_in('status', [2,3]);
		$this->db->where_not_in('status', [0,1]);
		$this->db->where('form_id', $form_id);
		$records_list = $this->db->get('ic_form_data')->result_array();
		$records_json_array = array();
		$grecords_json_array = array();
		$g_record_details =array();

		foreach ($records_list as $r_key => $records_val) {
			$records_f_value_array = array();
			$data_id=$records_val['data_id'];
			$records_val_json = array();
			$records_f_array = array();
			$records_val_json = json_decode($records_val['form_data'], true);
			//getting record detials
			$data = array(
				// 'Year' => $outputs = $this->Reporting_model->get_year_name_byId($records_val['year_id']),
				// 'Reporting Period' => $this->Reporting_model->get_year_name_byId($records_val['rperiod_id']),
				'year_id' => $records_val['year_id'],
				'rp_id' => $records_val['rperiod_id'],
				'country_id' => $records_val['country_id'],
				'crop_id' => $records_val['crop_id'],
				'status' => $records_val['status'],
				'user_id' => $records_val['user_id'],
				'reg_date_time' => $records_val['reg_date_time'],
				'approved_by' => $records_val['approve_by'],
				'approved_date' => $records_val['approve_date'],
				'rejected_by' => $records_val['rejected_by'],
				'rejected_date' => $records_val['rejected_date'],
				'nothing_to_report' => $records_val['nothingto_report'],
				'data_id' => $data_id
			);
			$record_details =  $this->Reporting_model->get_details_byIds($data);

			//getting field wise record data and updating in array
			foreach ($form_fields as $ff_key => $filed_val) {
				$rfield_id ="field_".$filed_val['field_id'];
				$rfield_name =$filed_val['label'];
				switch ($filed_val['type']) {
					case 'header':
						//nothing skipping column
						break;
					case 'lkp_country':
						$lkpdata= "";
						if($filed_val['multiple']) {
							$lkp_str_arr = explode("&#44;", $records_val_json[$rfield_id]);
							foreach ($lkp_str_arr as $lkp_str_key => $str_country) {
								foreach ($lkp_country as $lkp_key => $country) {
									if($country['country_id'] == $str_country){
										$lkpdata = $lkpdata ." ".$country['country_name'].",";
									}
								}
							}
						}else{
							foreach ($lkp_country as $lkp_key => $country) {
								if($country['country_id'] == $records_val_json[$rfield_id]){
									$lkpdata = $country['country_name'];
								}
							}
						}
						$record_details += [$rfield_name => $lkpdata];
						break;

					// case 'lkp_headquarter':
					// 	$lkpdata= "";
					// 	if($filed_val['multiple']) {
					// 		$lkp_str_arr = explode("&#44;", $records_val_json[$rfield_id]);
					// 		foreach ($lkp_str_arr as $lkp_str_key => $str_country) {
					// 			foreach ($lkp_country as $lkp_key => $country) {
					// 				if($country['country_id'] == $str_country){
					// 					$lkpdata = $lkpdata ." ".$country['country_name'].",";
					// 				}
					// 			}
					// 		}
					// 	}else{
					// 		foreach ($lkp_country as $lkp_key => $country) {
					// 			if($country['country_id'] == $records_val_json[$rfield_id]){
					// 				$lkpdata = $country['country_name'];
					// 			}
					// 		}
					// 	}
					// 	$record_details += [$rfield_name => $lkpdata];
					// 	break;
	
					default:
						if(isset($records_val_json[$rfield_id])){
							$record_details += [$rfield_name => $records_val_json[$rfield_id]];
						}else{
							$record_details += [$rfield_name => ' '];
						}
						break;
				}
			}

			$sdg_list_data = array();
            if($records_val['sdg_id']!=0){
				//get sdg name list with ids
				$sdg_ids_array = explode(",", $records_val['sdg_id']);
				$sdg_sub_ids_array = explode(",", $records_val['sdg_sub_id']);
				$sdg_list_a= array();
				$sdgs_list_a= array();
				$this->db->select('*');
				$this->db->where_in('sdg_id', $sdg_ids_array)->where('sdg_status', 1);
				$sdg_list = $this->db->get('lkp_sdg')->result_array();
				foreach ($sdg_list as $sdg_key => $sdg_records_val) {
					array_push($sdg_list_a, $sdg_records_val['sdg_name']);
				}
				$sdg_list_names = implode(",", $sdg_list_a);
				$this->db->select('*');
				$this->db->where_in('sdg_sub_id', $sdg_sub_ids_array)->where('sdg_sub_status', 1);
				$sdg_sub_list = $this->db->get('lkp_sdg_sub')->result_array();
				foreach ($sdg_sub_list as $sdgs_key => $sdgs_records_val) {
					array_push($sdgs_list_a, $sdgs_records_val['sdg_sub_name']);
				}
				$sdgs_list_names = implode(",", $sdgs_list_a);
				$sdg_list_data = array(
					'SDG List' => $sdg_list_names,
					'SDG Sub List' => $sdgs_list_names
				);
				$result = array_merge($record_details,$records_f_array,$sdg_list_data);
			}else{
				$result = array_merge($record_details,$records_f_array);
			}
			
			array_push($records_json_array, $result);
			
			
			if ($check_group_fields > 0) {
				
				// $this->db->select('*');
				// // $this->db->where('form_id', $form_id)->where_in('status', [2,3]);
				// $this->db->where('status !=', 0);
				// $this->db->where('form_id', $form_id)->where('data_id', $data_id);
				// $grecords_list = $this->db->get('ic_form_group_data')->result_array();
				// foreach ($grecords_list as $gr_key => $grecords_val) {
				// 	$grecords_val_json = json_decode($grecords_val['formgroup_data'], true);
				// 	$grecords_val_json += ['data_id' => $data_id];
				// 	//need to add  data_id in group dtat array
				// 	array_push($grecords_json_array, $grecords_val_json);
				// }
				$d_g_record_details =array();
				foreach ($get_group_id_array as $gfr_key => $gfr_records_val) { //groups array
					
					$get_m_group_fields_array['group_ids'] =$get_group_id_array;
					$this->db->select('child_id');
					$this->db->where('form_id',  $form_id);
					$this->db->where('field_id', $gfr_records_val);
					$this->db->where('status', 1);
					$get_group_fields = $this->db->get('form_field')->row_array();
					$field_array = explode(",", $get_group_fields['child_id']);

					$this->db->select('*');
					// $this->db->where('form_id', $form_id)->where_in('status', [2,3]);
					$this->db->where_not_in('status', [0,1]);
					$this->db->where('form_id', $form_id)->where('groupfield_id', $gfr_records_val);
					$grecords_list = $this->db->get('ic_form_group_data')->result_array();
					$g_w_record_details =array();
					foreach ($grecords_list as $gr_key => $grecords_val) {
						$grecords_val_json = json_decode($grecords_val['formgroup_data'], true);
						$g_f_record_details =array();
						$g_f_record_details += ['Data Id' => $grecords_val['data_id']];
						foreach ($field_array as $key => $field) { //one group child ids loop
							$rfield_id ="field_".$field;
							$this->db->select('field_id, label, type, subtype, multiple');
							$this->db->where('status', 1)->where('form_id',  $form_id)->where('field_id',  $field);
							$g_form_fields = $this->db->get('form_field')->row_array();
							// $g_record_details[$gfr_records_val][$key]= "N/A";
							
							// foreach ($g_form_fields as $ff_key => $filed_val) {
								$rfield_id ="field_".$g_form_fields['field_id'];
								$rfield_name =$g_form_fields['label'];
								switch ($g_form_fields['type']) {
									case 'header':
										//nothing skipping column
										break;
									case 'lkp_country':
										$lkpdata= "";
										if($g_form_fields['multiple']) {
											$lkp_str_arr = explode("&#44;", $records_val_json[$rfield_id]);
											foreach ($lkp_str_arr as $lkp_str_key => $str_country) {
												foreach ($lkp_country as $lkp_key => $country) {
													if($country['country_id'] == $str_country){
														$lkpdata = $lkpdata ." ".$country['country_name'].",";
													}
												}
											}
										}else{
											foreach ($lkp_country as $lkp_key => $country) {
												if($country['country_id'] == $records_val_json[$rfield_id]){
													$lkpdata = $country['country_name'];
												}
											}
										}
										$g_f_record_details += [$g_form_fields['label'] => $lkpdata];
										break;
				
									// case 'lkp_headquarter':
									// 	$lkpdata= "";
									// 	if($g_form_fields['multiple']) {
									// 		$lkp_str_arr = explode("&#44;", $records_val_json[$rfield_id]);
									// 		foreach ($lkp_str_arr as $lkp_str_key => $str_country) {
									// 			foreach ($lkp_country as $lkp_key => $country) {
									// 				if($country['country_id'] == $str_country){
									// 					$lkpdata = $lkpdata ." ".$country['country_name'].",";
									// 				}
									// 			}
									// 		}
									// 	}else{
									// 		foreach ($lkp_country as $lkp_key => $country) {
									// 			if($country['country_id'] == $records_val_json[$rfield_id]){
									// 				$lkpdata = $country['country_name'];
									// 			}
									// 		}
									// 	}
									// 	$record_details += [$rfield_name => $lkpdata];
									// 	break;
					
									default:
										if(isset($grecords_val_json[$rfield_id])){
											// $g_record_details[$gfr_records_val][$gr_key][$key] = [$g_form_fields['label'] => $grecords_val_json[$rfield_id]];
											$g_f_record_details += [$g_form_fields['label'] => $grecords_val_json[$rfield_id]];
										}else{
											// $g_record_details[$gfr_records_val][$gr_key][$key] = [$g_form_fields['label'] => ""];
											$g_f_record_details += [$g_form_fields['label'] => ""];
										}
										break;
								}
							// }
						}//one group child ids loop
						// $get_m_group_fields_array[$gfr_records_val]['child_fileds_'.$key]= $field_array;
						array_push($g_w_record_details, $g_f_record_details);
					}//
					array_push($d_g_record_details, $g_w_record_details);
				}
				array_push($g_record_details, $d_g_record_details);
			}
		}
		
		// array_push($g_record_details, $d_g_record_details);
		
		if ($check_group_fields > 0) {
			echo json_encode(array(
				'status' => 1,
				'form_id' => $form_id,
				'form_title' => $form_title,
				'form_fields' => $form_fields,
				'json_data' => $records_json_array,
				'group_status' => $group_status,
				'group_ids' => $get_group_id_array,
				'm_groups_data' => $get_m_group_fields_array ,
				'g_json_data' => $d_g_record_details,
				'form_g_fields' => $group_fields,
			));
		}else{
			echo json_encode(array(
				'status' => 1,
				'form_id' => $form_id,
				'form_title' => $form_title,
				'groups_data' => $get_group_id_array,
				'json_data' => $records_json_array,
				'g_json_data' => $grecords_json_array,
				'form_fields' => $form_fields,
				'form_g_fields' => $group_fields,
			));
		}
		exit();
	}
	
	/* view data end for role id 6 */
}
