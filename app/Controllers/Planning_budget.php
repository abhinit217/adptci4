<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Planning_budget extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('user_agent');

		$this->baseurl = base_url();

		$this->load->model('Planning_budget_model');
	}

	public function index()
	{
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$this->db->distinct()->select('ly.*');
		if ($this->session->userdata('role') != 1) {
			$this->db->join('tbl_user_planning AS tucc', 'tucc.year_id = ly.year_id');
			$this->db->where('tucc.status', 1);
		}
		$this->db->where('ly.year_status', 1)->order_by('ly.year');
		$year_list = $this->db->get('lkp_year AS ly')->result_array();

		$result = array('year_list' => $year_list);

		$this->load->view('common/header');
		$this->load->view('planning_budget/dashboard', $result);
		$this->load->view('common/footer');
	}

	public function upload_targetdata(){
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$form_id = $this->uri->segment('3');
		$year_id = $this->uri->segment('4');
		$country_id = $this->uri->segment('5');
		$crop_id = $this->uri->segment('6');

		$this->db->select('*')->where('id', $form_id)->where('status', 1);
		$form_details = $this->db->get('form')->row_array();
		$crop_name = $this->db->select('*')->where('crop_id', $crop_id)->where('crop_status', 1)->get('lkp_crop')->row_array();
		$country_name = $this->db->select('*')->where('country_id', $country_id)->where('status', 1)->get('lkp_country')->row_array();
		$year_name = $this->db->select('*')->where('year_id', $year_id)->where('year_status', 1)->get('lkp_year')->row_array();

		$this->db->where('indicator_id', $this->uri->segment('3'));
		$this->db->where('year_id', $this->uri->segment('4'));
		$this->db->where('country_id', $this->uri->segment('5'));
		$this->db->where('crop_id', $this->uri->segment('6'));
		$this->db->where('status', 2);
		$this->db->where('nothingto_report !=', 1);
		$this->db->order_by('added_datetime', 'DESC');
		$get_indicator_data = $this->db->get('ic_planning_data')->row_array();

		//get 2020 target
		$get_2020_target = $this->db->select('sum(target) as target')->where('indicator_id_2020', $form_id)->where('year_id', 1)->where('country', $country_id)->where('crop', $crop_id)->where('status', 1)->get('tbl_indicator_target')->row_array();
		$target_2020 = ($get_2020_target == NULL) ? 'N/A' : $get_2020_target['target'];

		//get 2020 actual
		$planning_filterdata = array(
			'year_id' => 1,
			'country_id' => $country_id,
			'crop_id' => $crop_id,
			'form_id' => $form_id,
		);
		$get_2020_actual = $this->Planning_budget_model->get_2020_actual($planning_filterdata);

		$result = array('get_indicator_data' => $get_indicator_data, 'form_details' => $form_details, 'country_name' => $country_name['country_name'], 'crop_name' => $crop_name['crop_name'], 'year_name' => $year_name['year'], 'target_2020' => ($target_2020 == NULL) ? 'N/A' : $target_2020, 'actual_2020' => $get_2020_actual);

		$this->db->where('status', 2)->where('indicator_id', $this->uri->segment('3'));
		$this->db->where('year_id', $year_id)->where('country_id', $country_id)->where('crop_id', $crop_id)->where('user_id', $this->session->userdata('login_id'))->where('nothingto_report', 1);
		$result['nothingto_report'] = $this->db->get('ic_planning_data')->num_rows();

		$this->load->view('common/header');
		$this->load->view('planning_budget/submit_targetdata', $result);	
		$this->load->view('common/footer');
	}

	public function upload_activitydata(){
		if ($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL) {
			redirect($this->baseurl);
		}

		$form_id = $this->uri->segment('3');
		$year_id = $this->uri->segment('4');
		$country_id = $this->uri->segment('5');
		$crop_id = $this->uri->segment('6');

		if(!$form_id || !$year_id || !$country_id || !$crop_id){
			show_404();
		}

		$this->db->select('*')->where('id', $form_id)->where('status', 1);
		$form_details = $this->db->get('form')->row_array();
		$crop_name = $this->db->select('*')->where('crop_id', $crop_id)->where('crop_status', 1)->get('lkp_crop')->row_array();
		$country_name = $this->db->select('*')->where('country_id', $country_id)->where('status', 1)->get('lkp_country')->row_array();
		$year_name = $this->db->select('*')->where('year_id', $year_id)->where('year_status', 1)->get('lkp_year')->row_array();

		$this->db->where('activity_id', $this->uri->segment('3'));
		$this->db->where('year_id', $this->uri->segment('4'));
		$this->db->where('country_id', $this->uri->segment('5'));
		$this->db->where('crop_id', $this->uri->segment('6'));
		$this->db->where('status', 2);
		$this->db->where('nothingto_report !=', 1);
		$this->db->order_by('insert_date', 'DESC');
		$get_activity_data = $this->db->get('ic_subactivity_data')->result_array();
		foreach ($get_activity_data as $key => $value) {
			$get_activity_data[$key]['countribution_data'] = $this->db->where('subactivty_id', $value['id'])->where('status', 2)->get('ic_subactivity_contribution_data')->result_array();

			$get_activity_data[$key]['output_data'] = $this->db->where('subactivty_id', $value['id'])->where('status', 2)->get('ic_subactivity_output_data')->result_array();
		}

		$result = array('form_details' => $form_details, 'get_activity_data' => $get_activity_data, 'country_name' => $country_name['country_name'], 'crop_name' => $crop_name['crop_name'], 'year_name' => $year_name['year']);

		$this->db->where('status', 2)->where('activity_id', $this->uri->segment('3'));
		$this->db->where('year_id', $year_id)->where('country_id', $country_id)->where('crop_id', $crop_id)->where('user_id', $this->session->userdata('login_id'))->where('nothingto_report', 1);
		$result['nothingto_report'] = $this->db->get('ic_subactivity_data')->num_rows();

		$this->load->view('common/header');
		$this->load->view('planning_budget/upload_activitydata', $result);	
		$this->load->view('common/footer');
	}

	public function submit_targetdata(){
		$baseurl = base_url();
		date_default_timezone_set("UTC");
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		$user_id = $this->session->userdata('login_id');
		$user_role = $this->session->userdata('role');
		$year_val = $this->input->post('year_val');
		$country_val = $this->input->post('country_val');
		$crop_val = $this->input->post('crop_val');
		$submit_type = $this->input->post('submit_type');
		$form_id = $this->input->post('form_id');

		$form_details = $this->db->where('id', $form_id)->get('form')->row_array();

		switch ($submit_type) {
			case 'save':
				$status = 1;
				break;

			case 'submit':
				$status = 2;
				break;
		}

		if(isset($_POST['indicator_comment'])){
			$comment = $_POST['indicator_comment'];
		}else{
			$comment = NULL;
		}

		$time = time();
		$datetime = date('Y-m-d H:i:s');

		//check data already submitted by any user

		$this->db->where('indicator_id', $form_id);
		$this->db->where('year_id', $year_val);
		$this->db->where('country_id', $country_val);
		$this->db->where('crop_id', $crop_val);
		$this->db->where('status', 2);
		$get_indicator_data = $this->db->get('ic_planning_data')->row_array();

		if($get_indicator_data == NULL){
			$insert_array = array();
			$insert_array['indicator_id'] = $form_id;
			$insert_array['year_id'] = $year_val;
			$insert_array['country_id'] = $country_val;
			$insert_array['crop_id'] = $crop_val;
			$insert_array['name'] = $this->input->post('personname');
			$insert_array['email_id'] = $this->input->post('personemailid');
			$insert_array['designation'] = $this->input->post('persondesignation');
			$insert_array['remarks'] = $this->input->post('remarks');
			$insert_array['target_val'] = $this->input->post('target');
			$insert_array['user_id'] = $this->session->userdata('login_id');
			$insert_array['added_datetime'] = $datetime;
			$insert_array['ip_address'] = $this->input->ip_address();
			$insert_array['status'] = $status;
			$query = $this->db->insert('ic_planning_data', $insert_array);
		}else{
			$insert_array = array();
			$insert_array['name'] = $this->input->post('personname');
			$insert_array['email_id'] = $this->input->post('personemailid');
			$insert_array['designation'] = $this->input->post('persondesignation');
			$insert_array['remarks'] = $this->input->post('remarks');
			$insert_array['target_val'] = $this->input->post('target');
			$insert_array['user_id'] = $this->session->userdata('login_id');
			$insert_array['status'] = $status;

			$this->db->where('indicator_id', $form_id);
			$this->db->where('year_id', $year_val);
			$this->db->where('country_id', $country_val);
			$this->db->where('crop_id', $crop_val);
			$this->db->where('status', 2);
			$query = $this->db->update('ic_planning_data', $insert_array);
		}
		if($query) {
			switch ($submit_type) {
				case 'save':
					$ajax_message = 'Data saved successfully.';
					break;

				case 'submit':
					$ajax_message = 'Data submitted successfully.';
					break;
			}
			echo json_encode(array(
				'status' => 1,
				'msg' => $ajax_message
			));
		} else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
		}
		exit();
	}

	public function submit_activitydata(){
		$baseurl = base_url();
		date_default_timezone_set("UTC");
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		$user_id = $this->session->userdata('login_id');
		$user_role = $this->session->userdata('role');
		$year_val = $this->input->post('year_val');
		$country_val = $this->input->post('country_val');
		$crop_val = $this->input->post('crop_val');
		$submit_type = $this->input->post('submit_type');
		$form_id = $this->input->post('form_id');

		$form_details = $this->db->where('id', $form_id)->get('form')->row_array();

		switch ($submit_type) {
			case 'save':
				$status = 1;
				break;

			case 'submit':
				$status = 2;
				break;
		}

		if(isset($_POST['indicator_comment'])){
			$comment = $_POST['indicator_comment'];
		}else{
			$comment = NULL;
		}

		$time = time();
		$datetime = date('Y-m-d H:i:s');

		$insert_array = array();
		$insert_array['activity_id'] = $form_id;
		$insert_array['year_id'] = $year_val;
		$insert_array['country_id'] = $country_val;
		$insert_array['crop_id'] = $crop_val;
		$insert_array['sub_activity'] = $this->input->post('sub_activityname');
		$insert_array['sub_activity_budget'] = $this->input->post('budget');
		$insert_array['partners'] = $this->input->post('partner');
		$insert_array['remarks'] = $this->input->post('remarks');
		$insert_array['personname'] = $this->input->post('personname');
		$insert_array['persondesignation'] = $this->input->post('persondesignation');
		$insert_array['personemailid'] = $this->input->post('personemail');
		$insert_array['user_id'] = $this->session->userdata('login_id');
		$insert_array['insert_date'] = $datetime;
		$insert_array['ip_address'] = $this->input->ip_address();
		$insert_array['status'] = $status;
		$query = $this->db->insert('ic_subactivity_data', $insert_array);
		if($query) {
			$insert_id = $this->db->insert_id();
			foreach ($_POST['subactivitycontribution'] as $key => $value) {
				$contributioninsert_array = array();
				$contributioninsert_array['subactivty_id'] = $insert_id;
				$contributioninsert_array['contribution'] = $_POST['subactivitycontribution'][$key];
				$contributioninsert_array['contributionsource'] = $_POST['subactivitycontributionsource'][$key];
				$contributioninsert_array['user_id'] = $this->session->userdata('login_id');
				$contributioninsert_array['insert_date'] = $datetime;
				$contributioninsert_array['ip_address'] = $this->input->ip_address();
				$contributioninsert_array['status'] = $status;
				$query = $this->db->insert('ic_subactivity_contribution_data', $contributioninsert_array);
			}

			foreach ($_POST['subactivityouput'] as $key => $value) {
				$contributioninsert_array = array();
				$contributioninsert_array['subactivty_id'] = $insert_id;
				$contributioninsert_array['subactivity_output'] = $_POST['subactivityouput'][$key];
				$contributioninsert_array['user_id'] = $this->session->userdata('login_id');
				$contributioninsert_array['insert_date'] = $datetime;
				$contributioninsert_array['ip_address'] = $this->input->ip_address();
				$contributioninsert_array['status'] = $status;
				$query = $this->db->insert('ic_subactivity_output_data', $contributioninsert_array);
			}

			switch ($submit_type) {
				case 'save':
					$ajax_message = 'Data saved successfully.';
					break;

				case 'submit':
					$ajax_message = 'Data submitted successfully.';
					break;
			}
			echo json_encode(array(
				'status' => 1,
				'msg' => $ajax_message
			));
		} else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
		}
		exit();
	}

	public function deleteUserActivityData(){
		$baseurl = base_url();
		
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'session_err' => 1,
				'msg' => 'Session Expired! Please login again to continue.',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
			));
			exit();
		}

		if(!$this->input->post('subactivityid')) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Invalid requestttttt. Please refresh the page and try again.',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
			));
			exit();
		}
		$subactivityid = $this->input->post('subactivityid');
		if(strlen($subactivityid) == 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Invalid request. Please refresh the page and try again.',
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
			));
			exit();
		}

		//delete project theme indicators rpt_project_theme_indicator
		$data_act = array(
			'status' => 0
		);
		$this->db->where('activity_id', $this->input->post('activity_id'));
		$this->db->where('id', $this->input->post('subactivityid'));
		$act_query = $this->db->update('ic_subactivity_data', $data_act);
		if($act_query){

			//delete contributions
			$data_act_contribution = array(
				'status' => 0
			);
			$this->db->where('subactivty_id', $this->input->post('subactivityid'));
			$act_contribution_query = $this->db->update('ic_subactivity_contribution_data', $data_act_contribution);

			//delete outputs
			$data_act_output = array(
				'status' => 0
			);
			$this->db->where('subactivty_id', $this->input->post('subactivityid'));
			$act_output_query = $this->db->update('ic_subactivity_output_data', $data_act_output);

			echo json_encode(
				array(
					'msg' => 'Activity data deleted Successfully',
					'status' => 1,
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
				)
			);
			exit();
		}else{
			echo json_encode(
				array(
					'msg'=>'Sorry! Please try after sometime.',
					'status' => 0,
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash()
				)
			);
			exit();
		}
	}

	public function nothingto_report_target(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
			exit();
		}
		date_default_timezone_set("UTC");
		$user_id = $this->session->userdata('login_id');
		$user_role = $this->session->userdata('role');

		$insert_array = array(
			'year_id' => $this->input->post('year_val'),
			'country_id' => $this->input->post('country_val'),
			'crop_id' => $this->input->post('crop_val'),
			'indicator_id' => $this->input->post('form_id'),
			'nothingto_report' => 1,
			'user_id' => $this->session->userdata('login_id'),
			'added_datetime' => date('Y-m-d H:i:s'),
			'ip_address' =>  $this->input->ip_address(),
			'status' => NULL
		);
		$insert_array['status'] = 2;
		$table_query = $this->db->insert('ic_planning_data', $insert_array);

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

	public function removenothingto_report_target(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
			exit();
		}
		date_default_timezone_set("UTC");
		$user_id = $this->session->userdata('login_id');

		$country_id = $this->input->post('country_val');
		$crop_id = $this->input->post('crop_val');

		$check_data = $this->db->where('crop_id', $crop_id)->where('country_id', $country_id)->where('year_id', $this->input->post('year_val'))->where('user_id', $this->session->userdata('login_id'))->where('status', 2)->where('indicator_id', $this->input->post('form_id'))->where('nothingto_report', 1)->get('ic_planning_data')->num_rows();
		if($check_data == 0){
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}

		$updatedata = array(
			'status' => 0,
		);
		$this->db->where('crop_id', $crop_id)->where('country_id', $country_id)->where('year_id', $this->input->post('year_val'))->where('user_id', $this->session->userdata('login_id'))->where('status', 2)->where('indicator_id', $this->input->post('form_id'))->where('nothingto_report', 1);
		$table_query = $this->db->update('ic_planning_data', $updatedata);

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

	//activity nothing to report
	public function nothingto_report_activity(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
			exit();
		}
		date_default_timezone_set("UTC");
		$user_id = $this->session->userdata('login_id');
		$user_role = $this->session->userdata('role');

		$insert_array = array(
			'year_id' => $this->input->post('year_val'),
			'country_id' => $this->input->post('country_val'),
			'crop_id' => $this->input->post('crop_val'),
			'activity_id' => $this->input->post('form_id'),
			'nothingto_report' => 1,
			'user_id' => $this->session->userdata('login_id'),
			'insert_date' => date('Y-m-d H:i:s'),
			'ip_address' =>  $this->input->ip_address(),
			'status' => NULL
		);
		$insert_array['status'] = 2;
		$table_query = $this->db->insert('ic_subactivity_data', $insert_array);

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

	public function removenothingto_report_activity(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
			exit();
		}
		date_default_timezone_set("UTC");
		$user_id = $this->session->userdata('login_id');

		$country_id = $this->input->post('country_val');
		$crop_id = $this->input->post('crop_val');

		$check_data = $this->db->where('crop_id', $crop_id)->where('country_id', $country_id)->where('year_id', $this->input->post('year_val'))->where('user_id', $this->session->userdata('login_id'))->where('status', 2)->where('activity_id', $this->input->post('form_id'))->where('nothingto_report', 1)->get('ic_subactivity_data')->num_rows();
		if($check_data == 0){
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}

		$updatedata = array(
			'status' => 0,
		);
		$this->db->where('crop_id', $crop_id)->where('country_id', $country_id)->where('year_id', $this->input->post('year_val'))->where('user_id', $this->session->userdata('login_id'))->where('status', 2)->where('activity_id', $this->input->post('form_id'))->where('nothingto_report', 1);
		$table_query = $this->db->update('ic_subactivity_data', $updatedata);

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

	public function insertUpdatedData(){
		$baseurl = base_url();		
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'session_err' => 1,
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		$updateData = array();
		foreach ($_POST as $key => $field) {
			if($key != 'form_id' && $key != 'recordid' && $key != 'outputrecordid' && $key != 'contributionrecordid' && $key != 'datatype'){
				$updateData[$key] = $field;
			}
		}
		if($this->input->post('datatype') == 'activity'){
			$tablename = 'ic_subactivity_data';
			$this->db->where('id', $this->input->post('recordid'));
			$this->db->where('status !=', 0);
			$updatequery = $this->db->update($tablename, $updateData);
		}
		if($this->input->post('datatype') == 'contribution'){
			$tablename = 'ic_subactivity_contribution_data';
			$this->db->where('id', $this->input->post('contributionrecordid'));
			$this->db->where('subactivty_id', $this->input->post('recordid'));
			$this->db->where('status !=', 0);
			$updatequery = $this->db->update($tablename, $updateData);
		}
		if($this->input->post('datatype') == 'output'){
			$tablename = 'ic_subactivity_output_data';
			$this->db->where('id', $this->input->post('outputrecordid'));
			$this->db->where('subactivty_id', $this->input->post('recordid'));
			$this->db->where('status !=', 0);
			$updatequery = $this->db->update($tablename, $updateData);
		}

		if(!$updatequery){
			echo json_encode(array(
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'msg'=>'Sorry! Please try after sometime.',
				'status' => 0
			));
			exit();
		}else{
			echo json_encode(array(
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'msg'=>'Data Updated Successfully.',
				'status' => 1
			));
			exit();
		}
	}
}