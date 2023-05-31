<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url');

		$baseurl = base_url();
		$this->load->model('Auth_model');
		// $session_allowed = $this->Auth_model->match_account_activity();
		// if(!$session_allowed) redirect($baseurl.'auth/logout');
	}
	
	public function index(){
	    $this->load->view('product_admin/index');
	    $this->load->view('product_admin/header');
	    $this->load->view('product_admin/footer');	
	}
	public function jsonify($data)
	{
		echo(json_encode($data));
		exit();
	}

	public function export_data(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		 $this->load->model('Reports_model');
		 $survey_id = $this->uri->segment(3);
		if($survey_id == '' || $survey_id == NULL ){
			show_404();
		}
		$survey_fields = $this->Reports_model->export_survey_details($survey_id);
		$title = $this->Reports_model->export_survey_title($survey_id);
		$data['survey_id']= $survey_id;
		$data['survey_fields']= $survey_fields;
		$survey_data = $this->Reports_model->export_survey_data($data);
		
		

		$this->jsonify(array(
			'status' => 1,
			'title' => $title,
			'surveydata' => $survey_data,
			'survey_fields' => $survey_fields
		));

	}

	public function indicators(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		 $this->load->model('Reports_model');

		$this->load->model('Reports_model');
		$result['components']= $this->Reports_model->all_components();
		$result["status"]="1";
		$result = $this->security->xss_clean($result);
		$this->load->view('header');
		$this->load->view('reports/indicators', $result);
		$this->load->view('footer');
	}

	public function activity(){
		// echo '<pre>';print_r($this->session->userdata);exit;
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}

		$this->load->model('Reports_model');
		$components= $this->Reports_model->all_components();

		$this->load->model('Reports_model');
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$cid = $this->input->post('component');
		} else {
			$cid = $components[0]['component_id'];
		}
		$all_activity = $this->Reports_model->all_surveys($cid);
		$result = array('all_activity' => $all_activity);
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			echo json_encode($result);
			exit();
		}

		
	}

	public function view_activitydata()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			$curent_page = $this->uri->segment(4);
			$total_records_per_page = $this->uri->segment(5);

			if($survey_id == '' || $survey_id == NULL ){
				show_404();
			}
			if($curent_page == '' || $curent_page == NULL ){
				$curent_page = 1;
			}
			if($total_records_per_page == '' || $total_records_per_page == NULL ){
				$total_records_per_page = 100;
			}

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);

			$result['editable'] = true;
			$data['survey_id']= $survey_id;
			$data['curent_page']= $curent_page;
			$data['total_records_per_page']= $total_records_per_page;
			 $result['survey_data'] = $this->Reports_model->survey_data($data);
			 $result['total_records'] = $this->Reports_model->survey_data_records($survey_id);
			 $result['country_list'] = $this->Reports_model->country_list();
			 $result['compact_list'] = $this->Reports_model->compact_list();
			 $result['actual_list'] = $this->Reports_model->actual_list();
			 $result['quarter_list'] = $this->Reports_model->quarter_list();
			 $result['geographicscope_list'] = $this->Reports_model->geographicscope_list();
			 $result['innovation_platform_list'] = $this->Reports_model->innovation_platform_list();
			 $result['technology_type_list'] = $this->Reports_model->technology_type_list();
			$result['technology_deployed_list'] = $this->Reports_model->technology_deployed_list();
			$result['technology_varieties_list'] = $this->Reports_model->technology_varieties_list();
			$result['toolkit_list'] = $this->Reports_model->toolkit_list();
			 $result['year_list'] = $this->Reports_model->year_list();
			//  $result['curent_page'] = $curent_page;
			 $result['index_start'] = ($total_records_per_page*$curent_page)-$total_records_per_page;
			$result = $this->security->xss_clean($result);
			$this->load->view('header');
			$this->load->view('reports/view_surveydata', $result);
			$this->load->view('footer');
		}
	}

	public function edit_surveydata()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			if($survey_id == '' || $survey_id == NULL ){
				show_404();
			}

			$record_id = $this->uri->segment(4);
			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_fields($survey_id);

			$data['survey_id'] = $survey_id;
			$data['record_id'] = $record_id;
			$result['survey_data'] = $this->Reports_model->survey_data_by_id($data);
			$data['survey_id'] = $survey_id;
			$data['record_id'] = $record_id;
			$result['survey_data1'] = $this->Reports_model->survey_data_by_id_1($data);
			$data['survey_id'] = $survey_id;
			$data['record_id'] = $record_id;
			// $result['survey_groupdata'] = $this->Reports_model->survey_groupdata_by_id($data);
			// echo "<pre>";
			// print_r($result['survey_data1']);exit();
			$result = $this->security->xss_clean($result);
			$this->load->view('header');
			$this->load->view('reports/edit_surveydata', $result);
			$this->load->view('footer');
		}
	}

	public function survey_update()	{
		$baseurl = base_url();
		date_default_timezone_set("UTC");		
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}
		$data_id=$this->input->post('data_id');
		$record_id=$this->uri->segment(4);
		// print_r($data_id);exit;
		
		// echo "<script>console.log('dataID: '".$data_id.")</script>";
		// echo '<pre>';print_r($_POST);exit;

		$user_id = $this->session->userdata('login_id');		
		// $form_id = $this->input->post('form_id');
		$form_id = $this->uri->segment(3);
		$survey_table= "survey".$this->uri->segment(3);
		$survey_group_table= "survey".$this->uri->segment(3)."_groupdata";
		
		$insert_array = array();
		$datetime = date('Y-m-d H:i:s');

		$this->db->select('field_id');
		$this->db->where('type', 'group')->where('form_id',  $form_id)->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();
		// print_r($_POST);exit();
		if($check_group_fields > 0){
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id)->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$get_group_fields_array = array();

			foreach ($get_group_id_array as $key => $group) {
    			$this->db->select('child_id');
	        	$this->db->where('field_id', $group)->where('status', 1)->where('form_id', $form_id);
	        	$group_field = $this->db->get('form_field')->row_array();

	        	$current_group_fields = explode(",", $group_field['child_id']);

	        	foreach ($current_group_fields as $key => $c_group) {
	        		array_push($get_group_fields_array, $c_group);
	        	}
    		}			

			$this->db->select('field_id');
			$this->db->where_not_in('field_id', $get_group_fields_array)->where('status', 1)->where('form_id', $form_id);
			$non_group_fields = $this->db->get('form_field')->result_array();
			
			foreach ($non_group_fields as $key => $value) {
				$fieldkey = "field_".$value['field_id'];
				$multi_value = array();
				
				if(isset($_POST[$fieldkey])){
					
					if(is_array($_POST[$fieldkey])){
						foreach ($_POST[$fieldkey] as $multiplevalue) {
							array_push($multi_value, $multiplevalue);
						}
						$insert_array[$fieldkey] = implode('&#44;', $multi_value);
						/*json_encode($multi_value, JSON_UNESCAPED_UNICODE);*/
					}else{
						if($_POST[$fieldkey] == ''){
							// $insert_array[$fieldkey] = NULL;
						}else{
							
							$insert_array[$fieldkey] = $_POST[$fieldkey];
						}
					}
				}else{
					// $insert_array[$fieldkey] = NULL;
				}
				
			}
			
		}else{			
			foreach ($_POST as $key => $field) {
				$multi_value = array();
				if(is_array($field)){
					foreach ($field as $value) {
						array_push($multi_value, $value);
					}
					$insert_array[$key] = implode('&#44;', $multi_value);
					/*json_encode($multi_value, JSON_UNESCAPED_UNICODE)*/
				}else{
					if($field == ''){
						// $insert_array[$key] = NULL;
					}else{
						$insert_array[$key] = $field;
					}
				}
			}
		}
		//$insert_array['form_data'] = json_encode($dataarray, JSON_UNESCAPED_UNICODE);
		// $insert_array['user_id'] = $user_id;
		$insert_array['datetime'] = $datetime;
		$insert_array['ip_address'] = $this->input->ip_address();
		// $insert_array['status'] = 1;
		
		$query = $this->db->where('id', $record_id)->update($survey_table, $insert_array);

		if($query) {
			if($check_group_fields > 0){
				$this->db->select('GROUP_CONCAT(field_id) as field_ids');
				$this->db->where('type', 'group')->where('form_id',  $form_id)->where('status', 1);
				$get_group_id = $this->db->get('form_field')->row_array();

				$get_group_id_array = explode(",", $get_group_id['field_ids']);
				foreach ($get_group_id_array as $groupkey => $groupid) {
					$this->db->select('child_id');
	        		$this->db->where('field_id', $groupid)->where('status', 1)->where('form_id', $form_id);
	        		$get_fields_bygroupid = $this->db->get('form_field')->row_array();

					$get_fields_bygroupid_array = explode(",", $get_fields_bygroupid['child_id']);

					$first_field = "field_".$get_fields_bygroupid_array[0];
						if(isset($_POST[$first_field])){
							// foreach ($_POST[$first_field] as $fieldskey => $value) {
								foreach ($_POST['group_id'] as $groupkey => $group_id) {
									if(isset($group_id) && $group_id != ""){
										// echo $group_id;
										$groupdata = array();
										$field_array = array();

										foreach ($get_fields_bygroupid_array as $key => $fieldvalue) {
											$group_field_key = "field_".$fieldvalue;
											if(isset($_POST[$group_field_key][$groupkey])){
												$multi_value = array();
												if(is_array($_POST[$group_field_key][$groupkey])){
													foreach ($_POST[$group_field_key][$groupkey] as $multivalue) {
														array_push($multi_value, $multivalue);
													}
													$field_array[$group_field_key] = implode('&#44;', $multi_value);
													
												}else{
													$field_array[$group_field_key] = $_POST[$group_field_key][$groupkey];
												}
											}else{
												$field_array[$group_field_key] = "N/A";
											}									
										}

										$groupdata['data'] = json_encode($field_array, JSON_UNESCAPED_UNICODE);
										$groupdata['datetime'] = $datetime;
										$groupdata['ip_address'] = $this->input->ip_address();
										// $groupdata['status'] = 1;

										$groupquery = $this->db->where('data_id', $data_id)->where('group_id', $group_id)->update($survey_group_table, $groupdata);
										// echo $this->db->last_query();
									}else{
										// echo "no group id";
										$groupdata = array();
										//id	group_id	data_id	groupfield_id	data	user_id	datetime	ip_address	status	
										$groupdata['group_id'] = time().$groupkey.$groupkey.'-'.$this->session->userdata('login_id');
										$groupdata['data_id'] = $data_id;
										// $groupdata['form_id'] = $insert_array['form_id'];
										$groupdata['user_id'] = $insert_array['user_id'];
										$groupdata['groupfield_id'] = $groupid;
										
										$field_array = array();
			
										foreach ($get_fields_bygroupid_array as $key => $fieldvalue) {
											$group_field_key = "field_".$fieldvalue;
											if(isset($_POST[$group_field_key][$groupkey])){
												$multi_value = array();
												if(is_array($_POST[$group_field_key][$groupkey])){
													foreach ($_POST[$group_field_key][$groupkey] as $multivalue) {
														array_push($multi_value, $multivalue);
													}
													$field_array[$group_field_key] = implode('&#44;', $multi_value);
													
												}else{
													$field_array[$group_field_key] = $_POST[$group_field_key][$groupkey];
												}
											}else{
												$field_array[$group_field_key] = "N/A";
											}									
										}
			
										$groupdata['data'] = json_encode($field_array, JSON_UNESCAPED_UNICODE);
										$groupdata['datetime'] = $datetime;
										$groupdata['ip_address'] = $this->input->ip_address();
										// $groupdata['status'] = 1;

										
										$groupquery = $this->db->insert($survey_group_table, $groupdata);

									}
								}
								// print_r($groupdata);
							// }
						}
					// }
				}

				// exit();
			}
			//Insert uploaded images in db
			if(isset($_FILES['survey_images'])) {
				foreach ($_FILES['survey_images']['name'] as $key => $si) {
					if($_FILES['survey_images']['size'][$key] > 0) {
						//Upload Image
						$file_name = $_FILES['survey_images']['name'][$key];
						$ext = pathinfo($file_name, PATHINFO_EXTENSION);
						$file = $file_name;
						// $file = uniqid().$key.$this->session->userdata('login_id').'.'.$ext;
						$file_size = $_FILES['survey_images']['size'][$key];

						if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'uploads/survey/');
						$imgurl = UPLOAD_DIR . $file;

						$filename = $_FILES["survey_images"]["tmp_name"][$key];
						$file_directory = "uploads/survey/";
						if($filename) {
							if(move_uploaded_file($filename, $file_directory . $file)){
								$this->db->select('data_id');
	        					$this->db->where('data_id', $data_id)->where('status', 1);
	        					$check_record = $this->db->get('ic_data_file')->row_array();
								 if(isset($check_record['data_id'])){
									$surv_image_data = array(
										'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
										'form_id' => $this->uri->segment(3),
										'user_id' => $this->session->userdata('login_id'),
										'file_name' => $file,
										'file_type' => 'document',
										'created_date' => $datetime,
										'ip_address' => $this->input->ip_address(),
										'status' => 1
									);
									$this->db->where('data_id', $data_id)->update('ic_data_file', $surv_image_data);

								 }else{
									$surv_image_data = array(
										'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
										'data_id' => $data_id,
										'form_id' => $this->uri->segment(3),
										'user_id' => $this->session->userdata('login_id'),
										'file_name' => $file,
										'file_type' => 'document',
										'created_date' => $datetime,
										'ip_address' => $this->input->ip_address(),
										'status' => 1
									);
									$this->db->insert('ic_data_file', $surv_image_data);
								}
							}
						}
					}
				}
			}
			if($check_group_fields > 0){
				$gp_status = 1;
			}else{
				$gp_status = 0;
			}

			$ajax_message = 'Data updated successfully.';
			echo json_encode(array(
				'status' => 1,
				'group_status' => $gp_status,
				'msg' => $ajax_message
			));
			exit();
		} else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}
	}
	

	public function get_details_for_edit()
	{
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);

		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';
			echo json_encode($result);
			exit();
		}

		if(!$this->input->post('id')
		|| !$this->input->post('field_id')) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';
			echo json_encode($result);
			exit();
		}
		$survey_id= $this->uri->segment(3);

		$this->load->model('Reports_model');
		$result['survey_data'] = $this->Reports_model->survey_data_details($this->input->post('id'), $survey_id);
		$result['field_details'] = $this->Reports_model->field_details($this->input->post('field_id'), $result['survey_data']);

		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}

	public function get_details_for_edited()
	{
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);

		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';
			echo json_encode($result);
			exit();
		}

		if(!$this->input->post('id')
		|| !$this->input->post('field_id')) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';
			echo json_encode($result);
			exit();
		}
		$survey_id= $this->uri->segment(3);

		$this->load->model('Reports_model');
		$result['survey_data'] = $this->Reports_model->survey_data_details_edit($this->input->post('id'), $survey_id);
		$result['field_details'] = $this->Reports_model->field_details($this->input->post('field_id'), $result['survey_data']);

		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}


	public function edit_formdata()
	{
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);

		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';
			echo json_encode($result);
			exit();
		}

		if(!$this->input->post('id')
		|| !$this->input->post('field')) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';
			echo json_encode($result);
			exit();
		}

		$survey_id = $this->uri->segment(3);
		$record_id = $this->input->post('id');

		$this->load->model('Reports_model');
		$survey_data = $this->Reports_model->survey_data_details($this->input->post('id'), $survey_id);
		$field_details = $this->Reports_model->field_details($this->input->post('field'), $survey_data);
		// if(!$survey_data || !$field_details) {
		// 	$result['status'] = 0;
		// 	$result['msg'] = 'Invalid request. Please refresh the page and try again.';
		// 	echo json_encode($result);
		// 	exit();
		// }

		$newKey = 'field_'.$field_details['field_id'];
		$newValueOrg = $this->input->post($newKey);
		$newValue = $this->input->post($newKey);
		if(is_array($newValue)) {
			$newValue = implode('&#44;', $newValue);
		}

		$survey_table= "survey".$this->uri->segment(3);
		$log = array();
		date_default_timezone_set('UTC');
		$currentDateTime = date('Y-m-d H:i:s');

		//Cehck if newValue is empty or not
		//Modify form_data accordingly
		if(strlen($newValue) > 0) {
			$log['new_value'] =$newValue;
			$log['editedby'] = $this->session->userdata('login_id');
			$log['editedfor'] = $survey_data['user_id'];
			$log['table_name'] = $survey_table;
			$log['table_row_id'] = $record_id;
			$log['table_field_name'] = $newKey;
			$log['old_value'] = $survey_data[$newKey];
			$log['new_value'] = $newValue;
			$log['edited_reason'] = $this->input->post('reason');
			$log['updated_date'] = $currentDateTime;
			$log['ip_address'] = $this->input->ip_address();
			$log['log_status'] = 1;
		} else if(strlen($newValue) == 0) {
			$newValue=="";
		}

		
		
		//Check if log has new value then prepare complete log
		if(isset($log['new_value'])) {
			$this->db->where('id', $record_id)->update($survey_table, array($newKey => $newValue));
			$this->db->insert('ic_log', $log);
		}
		$result['status'] = 1;
		$result['msg'] = 'Data updated successfully.';
		$result['field_value'] = strlen($newValue) == 0 ? 'N/A' : $newValue;
		echo json_encode($result);
		exit();
	}

	public function add_report(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		 $this->load->model('Reports_model');

		$this->load->model('Reports_model');
		$result['components']= $this->Reports_model->all_components();
		$result["status"]="1";
		$result = $this->security->xss_clean($result);
		$this->load->view('header');
		$this->load->view('reports/add_indicators', $result);
		$this->load->view('footer');
	}

	public function indicators_list(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}

		$this->load->model('Reports_model');
		$components= $this->Reports_model->all_components();

		$this->load->model('Reports_model');
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$cid = $this->input->post('component');
		} else {
			$cid = $components[0]['component_id'];
		}
		$all_activity = $this->Reports_model->all_surveys($cid);
		$result = array('all_activity' => $all_activity);
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			echo json_encode($result);
			exit();
		}

		
	}

	public function upload_report()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			if($survey_id == '' || $survey_id == NULL ){
				show_404();
			}

			$record_id = $this->uri->segment(4);
			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_fields($survey_id);
			
			$result = $this->security->xss_clean($result);
			$this->load->view('header');
			$this->load->view('reports/upload_report', $result);
			$this->load->view('footer');
		}
	}

	public function groupdata_delete(){
		$baseurl = base_url();
		$surveyid = $this->uri->segment(3);
		$data_id = $this->uri->segment(4);
		$group_field_id = $this->uri->segment(5);
		$group_id = $this->uri->segment(6);
		$status = $this->uri->segment(7);
		$survey_group_table= "ic_form_group_data";
		// $this->load->model('Reports_model');
		$this->db->query('delete from '.$survey_group_table.' where group_id="'.$group_id.'"');
		$dt = $this->db->last_query();
		redirect($baseurl.'reports/edit_groupdata_info/'.$surveyid.'/'.$data_id.'/'.$group_field_id.'/'.$status);
	}

	public function report_upload()	{
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
		// $form_id = $this->input->post('form_id');
		$form_id = $this->uri->segment(3);
		$survey_table= "survey".$this->uri->segment(3);
		$survey_group_table= "survey".$this->uri->segment(3)."_groupdata";
		$insert_array = array();
		$dataarray = array();
		$time = time();
		$datetime = date('Y-m-d H:i:s');

		if($form_id == 17){
			if(isset($_POST['field_1118'])){
				$compact_id = $_POST['field_250'];
				$otherText = $_POST['field_1118'];

				$this->db->select('*');
				$this->db->where('toolkit_name', $otherText)->where('compact_id', $compact_id)->where('status', 1);
				$check_fields = $this->db->get('tbl_toolkit')->result_array();
				
				if(isset($check_fields)){
					$toolkit_array = array();
					$toolkit_array['compact_id'] = $compact_id;
					$toolkit_array['toolkit_name'] = $otherText;
					$newTool = $this->db->insert('tbl_toolkit', $toolkit_array);
				}else{
					// already exists;
				}
				
			}

		}

		$this->db->select('field_id');
		$this->db->where('type', 'group')->where('form_id',  $form_id)->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();
		
		if($check_group_fields > 0){
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id)->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$get_group_fields_array = array();

			foreach ($get_group_id_array as $key => $group) {
    			$this->db->select('child_id');
	        	$this->db->where('field_id', $group)->where('status', 1)->where('form_id', $form_id);
	        	$group_field = $this->db->get('form_field')->row_array();

	        	$current_group_fields = explode(",", $group_field['child_id']);

	        	foreach ($current_group_fields as $key => $c_group) {
	        		array_push($get_group_fields_array, $c_group);
	        	}
    		}			

			$this->db->select('field_id');
			$this->db->where_not_in('field_id', $get_group_fields_array)->where('status', 1)->where('form_id', $form_id);
			$non_group_fields = $this->db->get('form_field')->result_array();

			foreach ($non_group_fields as $key => $value) {
				$fieldkey = "field_".$value['field_id'];
				$multi_value = array();
				if(isset($_POST[$fieldkey])){
					if(is_array($_POST[$fieldkey])){
						foreach ($_POST[$fieldkey] as $multiplevalue) {
							array_push($multi_value, $multiplevalue);
						}
						$insert_array[$fieldkey] = implode('&#44;', $multi_value);
						/*json_encode($multi_value, JSON_UNESCAPED_UNICODE);*/
					}else{
						if($_POST[$fieldkey] == ''){
							$insert_array[$fieldkey] = NULL;
						}else{
							$insert_array[$fieldkey] = $_POST[$fieldkey];
						}
					}
				}else{
					$insert_array[$fieldkey] = NULL;
				}
			}
		}else{			
			foreach ($_POST as $key => $field) {
				$multi_value = array();
				if(is_array($field)){
					foreach ($field as $value) {
						array_push($multi_value, $value);
					}
					$insert_array[$key] = implode('&#44;', $multi_value);
					/*json_encode($multi_value, JSON_UNESCAPED_UNICODE)*/
				}else{
					if($field == ''){
						$insert_array[$key] = NULL;
					}else{
						$insert_array[$key] = $field;
					}
				}
			}
		}
		//$insert_array['form_data'] = json_encode($dataarray, JSON_UNESCAPED_UNICODE);
		$insert_array['user_id'] = $user_id;
		$insert_array['datetime'] = $datetime;
		$insert_array['ip_address'] = $this->input->ip_address();
		$insert_array['status'] = 2;
		$t=time();
		$insert_array['data_id'] = $t."-".$user_id;
		
		$query = $this->db->insert($survey_table, $insert_array);
		if($query) {
			// add more group data commented
			if($check_group_fields > 0){
				foreach ($get_group_id_array as $groupkey => $groupid) {
					$this->db->select('child_id');
	        		$this->db->where('field_id', $groupid)->where('status', 1)->where('form_id', $form_id);
	        		$get_fields_bygroupid = $this->db->get('form_field')->row_array();

					$get_fields_bygroupid_array = explode(",", $get_fields_bygroupid['child_id']);

					$first_field = "field_".$get_fields_bygroupid_array[0];

					if(isset($_POST[$first_field])){
						foreach ($_POST[$first_field] as $fieldskey => $value) {
							$groupdata = array();
							//id	group_id	data_id	groupfield_id	data	user_id	datetime	ip_address	status	
							$groupdata['group_id'] = time().$groupkey.$fieldskey.'-'.$this->session->userdata('login_id');
							$groupdata['data_id'] = $insert_array['data_id'];
							// $groupdata['form_id'] = $insert_array['form_id'];
							$groupdata['user_id'] = $insert_array['user_id'];
							$groupdata['groupfield_id'] = $groupid;
							
							$field_array = array();

							foreach ($get_fields_bygroupid_array as $key => $fieldvalue) {
								$group_field_key = "field_".$fieldvalue;
								if(isset($_POST[$group_field_key][$fieldskey])){
									$multi_value = array();
									if(is_array($_POST[$group_field_key][$fieldskey])){
										foreach ($_POST[$group_field_key][$fieldskey] as $multivalue) {
											array_push($multi_value, $multivalue);
										}
										$field_array[$group_field_key] = implode('&#44;', $multi_value);
										
									}else{
										$field_array[$group_field_key] = $_POST[$group_field_key][$fieldskey];
									}
								}else{
									$field_array[$group_field_key] = "N/A";
								}									
							}

							$groupdata['data'] = json_encode($field_array, JSON_UNESCAPED_UNICODE);
							$groupdata['datetime'] = $datetime;
							$groupdata['ip_address'] = $this->input->ip_address();
							$groupdata['status'] = 2;
							
							$groupquery = $this->db->insert($survey_group_table, $groupdata);
							
						}
					}
				}
				
			}

			//Insert uploaded images in db
			if(isset($_FILES['survey_images'])) {
				foreach ($_FILES['survey_images']['name'] as $key => $si) {
					if($_FILES['survey_images']['size'][$key] > 0) {
						//Upload Image
						$file_name = $_FILES['survey_images']['name'][$key];
						$ext = pathinfo($file_name, PATHINFO_EXTENSION);
						$file = $file_name;
						// $file = uniqid().$key.$this->session->userdata('login_id').'.'.$ext;
						$file_size = $_FILES['survey_images']['size'][$key];

						if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'uploads/survey/');
						$imgurl = UPLOAD_DIR . $file;

						$filename = $_FILES["survey_images"]["tmp_name"][$key];
						$file_directory = "uploads/survey/";
						if($filename) {
							if(move_uploaded_file($filename, $file_directory . $file)){
								$surv_image_data = array(
									'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
									'data_id' => $insert_array['data_id'],
									'form_id' => $this->uri->segment(3),
									'user_id' => $this->session->userdata('login_id'),
									'file_name' => $file,
									'file_type' => 'document',
									'created_date' => $datetime,
									'ip_address' => $this->input->ip_address(),
									'status' => 1
								);
								$this->db->insert('ic_data_file', $surv_image_data);
							}
						}
					}
				}
			}

			$ajax_message = 'Data Inserted successfully. You can now add more data.';
			echo json_encode(array(
				'status' => 1,
				'msg' => $ajax_message
			));
			exit();
		} else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}
	}

	public function groupdata_upload()	{
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

		$form_id = $this->uri->segment(3);
		$data_id = $this->uri->segment(4);
		$status = $this->uri->segment(5);
		$survey_table= "survey".$this->uri->segment(3);
		$survey_group_table= "ic_form_group_data";
		$insert_array = array();
		$datetime = date('Y-m-d H:i:s');

		$this->db->select('field_id');
		$this->db->where('type', 'group')->where('form_id',  $form_id)->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		// var_dump($check_group_fields);exit;
		
		if($check_group_fields > 0){


			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id)->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			foreach ($get_group_id_array as $groupkey => $groupid) {
				$this->db->select('child_id');
				$this->db->where('field_id', $groupid)->where('status', 1)->where('form_id', $form_id);
				$get_fields_bygroupid = $this->db->get('form_field')->row_array();

				$get_fields_bygroupid_array = explode(",", $get_fields_bygroupid['child_id']);

				$first_field = "field_".$get_fields_bygroupid_array[0];

				if(isset($_POST[$first_field])){
					foreach ($_POST[$first_field] as $fieldskey => $value) {
						$groupdata = array();
						//id	group_id	data_id	groupfield_id	data	user_id	datetime	ip_address	status	
						$groupdata['group_id'] = time().$groupkey.$fieldskey.'-'.$this->session->userdata('login_id');
						$groupdata['data_id'] = $data_id;
						$groupdata['user_id'] = $user_id;
						$groupdata['groupfield_id'] = $groupid;
						
						$field_array = array();

						foreach ($get_fields_bygroupid_array as $key => $fieldvalue) {
							$group_field_key = "field_".$fieldvalue;
							if(isset($_POST[$group_field_key][$fieldskey])){
								$multi_value = array();
								if(is_array($_POST[$group_field_key][$fieldskey])){
									foreach ($_POST[$group_field_key][$fieldskey] as $multivalue) {
										array_push($multi_value, $multivalue);
									}
									$field_array[$group_field_key] = implode('&#44;', $multi_value);
									
								}else{
									$field_array[$group_field_key] = $_POST[$group_field_key][$fieldskey];
								}
							}else{
								$field_array[$group_field_key] = "N/A";
							}									
						}

						$groupdata['formgroup_data'] = json_encode($field_array, JSON_UNESCAPED_UNICODE);
						$groupdata['reg_date_time'] = $datetime;
						$groupdata['ip_address'] = $this->input->ip_address();
						$groupdata['status'] = $status;
						
						$groupquery = $this->db->insert($survey_group_table, $groupdata);
						
					}
				}
			}
			if($groupquery) {
				$ajax_message = 'Data Inserted successfully. You can now add more data.';
				echo json_encode(array(
					'status' => 1,
					'msg' => $ajax_message
				));
				exit();
			} else {
				echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
				exit();
			}
		}else{	
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();	
		}
		
	}

	public function groupdata_excel_upload()	{
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

		$form_id = $this->uri->segment(3);
		$data_id = $this->uri->segment(4);
		$groupid= $this->uri->segment(5);
		$status= $this->uri->segment(6);
		$survey_group_table= "ic_form_group_data";
		$insert_array = array();
		$datetime = date('Y-m-d H:i:s');

		//load Excel library
		$this->load->library('excel');
		$this->db->select('inline');
		$this->db->where('type', 'uploadgroupdata_excel')->where('inline',$groupid);
		$this->db->where('form_id', $form_id);
		$this->db->where('status', 1);
		$excel_groupids = $this->db->get('form_field')->row_array();

		$this->db->select('field_id');
		$this->db->where('type', 'group')->where('form_id',  $form_id)->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		// var_dump($check_group_fields);exit;
		
		if($check_group_fields > 0){


			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('field_id', $groupid)->where('form_id',  $form_id)->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			foreach ($get_group_id_array as $groupkey => $groupid) {
				$this->db->select('child_id');
				$this->db->where('field_id', $groupid)->where('status', 1)->where('form_id', $form_id);
				$get_fields_bygroupid = $this->db->get('form_field')->row_array();

				$get_fields_bygroupid_array = explode(",", $get_fields_bygroupid['child_id']);
				

				$first_field = "field_".$get_fields_bygroupid_array[0];

				if(isset($_FILES['uploadexcel_data']) && $_FILES['uploadexcel_data']['name'] != '' ){
					$file_info = pathinfo($_FILES['uploadexcel_data']['name']);
					$file_directory = "upload/survey/";
					$new_file_name = uniqid().$this->session->userdata('login_id').".". $file_info["extension"];
					if(move_uploaded_file($_FILES['uploadexcel_data']["tmp_name"], $file_directory . $new_file_name)){
						$file_type	= PHPExcel_IOFactory::identify($file_directory . $new_file_name);
						$objReader	= PHPExcel_IOFactory::createReader($file_type);
						$objPHPExcel = $objReader->load($file_directory . $new_file_name);
						$column = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
	
						// if($column != 'K'){
						// 	unlink($file_directory.''.$new_file_name);
						// 	echo json_encode(array('status' => 0, 'csrfName' => $this->security->get_csrf_token_name(), 'csrfHash' => $this->security->get_csrf_hash(), 'msg' => 'Invalid number of columns in the excel choosen.'));
						// 	exit();
						// }
					}else{
						echo "not moved";
						die();
					}
					$excel_column_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z');

					$directory = "upload/survey/";

					$group_table_name = "ic_form_group_data";

					$file_type	= PHPExcel_IOFactory::identify($directory . $new_file_name);
					$objReader	= PHPExcel_IOFactory::createReader($file_type);
					$objPHPExcel = $objReader->load($directory . $new_file_name);
					$column = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
					$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); 

					$sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					$excelmulti_value = array();
					foreach($sheet_data as $ekey => $data){
						if($ekey > 1){
							$groupdata['group_id'] = time().$groupkey.$ekey.'-'.$this->session->userdata('login_id');
							$groupdata['data_id'] = $data_id;
							$groupdata['form_id'] = $form_id;
							$groupdata['user_id'] = $user_id;
							$groupdata['groupfield_id'] = $groupid;
							// $groupdata['groupfield_id'] = $excel_groupids['field_id'];
							$groupdata['dataupload_type'] = 'excel';

							$field_array = array();

							foreach ($get_fields_bygroupid_array as $gkey => $fieldvalue) {
								$group_field_key = "field_".$fieldvalue;
								$column_value= $data[$excel_column_array[$gkey]];
								if($column_value=='')
									$column_value='NA';
								$field_array[$group_field_key] = $column_value;
							}

							$groupdata['formgroup_data'] = json_encode($field_array, JSON_UNESCAPED_UNICODE);
							$groupdata['reg_date_time'] = $datetime;
							$groupdata['ip_address'] = $this->input->ip_address();
							$groupdata['status'] = $status;

							$surv_group_data = $this->security->xss_clean($groupdata);
							$groupquery = $this->db->insert($group_table_name, $surv_group_data);
						}
					}
				}
			}
			if($groupquery) {
				$ajax_message = 'Data Inserted successfully. You can now add more data.';
				echo json_encode(array(
					'status' => 1,
					'msg' => $ajax_message
				));
				exit();
			} else {
				echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
				exit();
			}
		}else{	
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();	
		}
		
	}

	public function approvals()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			$curent_page = $this->uri->segment(4);
			$total_records_per_page = $this->uri->segment(5);
			if($survey_id == '' || $survey_id == NULL ){
				show_404();
			}
			if($curent_page == '' || $curent_page == NULL ){
				$curent_page = 1;
			}
			if($total_records_per_page == '' || $total_records_per_page == NULL ){
				$total_records_per_page = 100;
			}

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_approval_details($survey_id);
			$result['editable'] = true;

			$data['survey_id']= $survey_id;
			$data['curent_page']= $curent_page;
			$data['total_records_per_page']= $total_records_per_page;
			 $result['survey_data'] = $this->Reports_model->survey_approvel_data($data);
			 $result['total_records'] = $this->Reports_model->survey_approvel_records($survey_id);
			 $result['country_list'] = $this->Reports_model->country_list();
			 $result['compact_list'] = $this->Reports_model->compact_list();
			 $result['actual_list'] = $this->Reports_model->actual_list();
			 $result['quarter_list'] = $this->Reports_model->quarter_list();
			 $result['geographicscope_list'] = $this->Reports_model->geographicscope_list();
			 $result['innovation_platform_list'] = $this->Reports_model->innovation_platform_list();
			 $result['technology_type_list'] = $this->Reports_model->technology_type_list();
			$result['technology_deployed_list'] = $this->Reports_model->technology_deployed_list();
			$result['technology_varieties_list'] = $this->Reports_model->technology_varieties_list();
			$result['toolkit_list'] = $this->Reports_model->toolkit_list();
			 $result['year_list'] = $this->Reports_model->year_list();
			 $result['index_start'] = ($total_records_per_page*$curent_page)-$total_records_per_page;
			//  print_r($result);exit();
			$result = $this->security->xss_clean($result);
			$this->load->view('header');
			$this->load->view('reports/view_approvals', $result);
			$this->load->view('footer');
		}
	}

	public function under_review()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			$curent_page = $this->uri->segment(4);
			$total_records_per_page = $this->uri->segment(5);
			if($survey_id == '' || $survey_id == NULL ){
				show_404();
			}
			if($curent_page == '' || $curent_page == NULL ){
				$curent_page = 1;
			}
			if($total_records_per_page == '' || $total_records_per_page == NULL ){
				$total_records_per_page = 100;
			}

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_approval_details($survey_id);
			$result['editable'] = true;

			$data['survey_id']= $survey_id;
			$data['curent_page']= $curent_page;
			$data['total_records_per_page']= $total_records_per_page;
			 $result['survey_data'] = $this->Reports_model->survey_approvel_data($data);
			 $result['total_records'] = $this->Reports_model->survey_approvel_records($survey_id);
			 $result['country_list'] = $this->Reports_model->country_list();
			 $result['compact_list'] = $this->Reports_model->compact_list();
			 $result['actual_list'] = $this->Reports_model->actual_list();
			 $result['quarter_list'] = $this->Reports_model->quarter_list();
			 $result['geographicscope_list'] = $this->Reports_model->geographicscope_list();
			 $result['innovation_platform_list'] = $this->Reports_model->innovation_platform_list();
			 $result['technology_type_list'] = $this->Reports_model->technology_type_list();
			$result['technology_deployed_list'] = $this->Reports_model->technology_deployed_list();
			$result['technology_varieties_list'] = $this->Reports_model->technology_varieties_list();
			$result['toolkit_list'] = $this->Reports_model->toolkit_list();
			 $result['year_list'] = $this->Reports_model->year_list();
			 $result['index_start'] = ($total_records_per_page*$curent_page)-$total_records_per_page;
			//   print_r($result);exit();
			$result = $this->security->xss_clean($result);
			$this->load->view('header');
			$this->load->view('reports/under_review', $result);
			$this->load->view('footer');
		}
	}

	public function edit_groupdata_info(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			$data_id = $this->uri->segment(4);
			$group_field_id = $this->uri->segment(5);
			$status = $this->uri->segment(6);

			$data = array(
				'survey_id' => $survey_id,
				'data_id' => $data_id,
				'group_field_id' => $group_field_id,
				'status' => $status
			);

			$this->load->model('Reports_model');
			
			$result = $this->Reports_model->survey_fields($data);

			$group_info = $this->Reports_model->group_info($data);
			$headquarter_list = $this->Reports_model->headquarter_list();
			$country_list = $this->Reports_model->country_list();
			$excel_u_status = $this->Reports_model->excel_u_status($data);
			
			// $result['group_info'] = array('group_info' => $group_info,'survey_data' => $survey_data);
			$result['group_info'] = $group_info;
			$result['headquarter_list'] = $headquarter_list;
			$result['country_list'] = $country_list;
			$result['excel_u_status'] = $excel_u_status;
			$result['survey_id'] = $survey_id;
			$result['group_field_id'] = $group_field_id;

			$this->load->view('common/header');
			$this->load->view('reporting/edit_groupdata_info', $result);
			$this->load->view('common/footer');
		}
	}
	public function get_group_details_for_edit()
	{
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);

		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';
			echo json_encode($result);
			exit();
		}

		if(!$this->input->post('group_id')
		|| !$this->input->post('field_id')) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';
			echo json_encode($result);
			exit();
		}

		$this->load->model('Reports_model');
		$survey_id = $this->input->post('survey_id');
		$group_id = $this->input->post('group_id');
		$field_id = $this->input->post('field_id');
		$data = array(
			'survey_id' => $survey_id,
			'group_id' => $group_id,
			'field_id' => $field_id
		);
		$result['group_data'] = $this->Reports_model->group_info_details($data);
		$result['field_details'] = $this->Reports_model->group_field_details($data);

		$result['status'] = 1;
		echo json_encode($result);
		exit();
	}
	public function edit_groupdata()
	{
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);

		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';
			echo json_encode($result);
			exit();
		}

		if(!$this->input->post('group')
		|| !$this->input->post('field_id')) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';
			echo json_encode($result);
			exit();
		}

		$this->load->model('Reports_model');

		$survey_id = $this->input->post('survey_id');
		$group_id = $this->input->post('group');
		$field_id = $this->input->post('field_id');
		$survey_group_table= "ic_form_group_data";
		$data = array(
			'survey_id' => $survey_id,
			'group_id' => $group_id,
			'field_id' => $field_id
		);
		$group_data = $this->Reports_model->group_info_details($data);
		$field_details = $this->Reports_model->group_field_details($data);
		if(!$group_data || !$field_details) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again.';
			echo json_encode($result);
			exit();
		}

		$newKey = 'field_'.$field_details['field_id'];
		$newValueOrg = $this->input->post($newKey);
		$newValue = $this->input->post($newKey);
		if(is_array($newValue)) {
			$newValue = implode('&#44;', $newValue);
		}

		//Convert string data to array
		$form_data = (array)json_decode($group_data['formgroup_data']);
		$log = array();

		//Cehck if newValue is empty or not
		//Modify form_data accordingly
		if(strlen($newValue) > 0) {
			if(is_array($newValueOrg)) {
				$form_data[$newKey] = $newValue;
				$log['new_value'] = json_encode(array($newKey => json_encode($newValueOrg)));
			} else {
				$form_data[$newKey] = $newValue;
				$log['new_value'] = json_encode(array($newKey => $newValue));
			}
		} else if(strlen($newValue) == 0) {
			$form_data[$newKey] = NULL;
			$log['new_value'] = json_encode(array($newKey => NULL));
		}

		date_default_timezone_set('UTC');
		$currentDateTime = date('Y-m-d H:i:s');

		//Check if log has new value then prepare complete log
		if(isset($log['new_value'])) {
			// $log['editedby'] = $this->session->userdata('login_id');
			// $log['editedfor'] = $group_data['user_id'];
			// $log['table_name'] = 'ic_form_group_data';
			// $log['table_row_id'] = $group_data['group_id'];
			// $log['table_field_name'] = 'formgroup_data';
			// $log['old_value'] = $group_data['formgroup_data'];
			// $log['edited_reason'] = $this->input->post('reason');
			// $log['updated_date'] = $currentDateTime;
			// $log['ip_address'] = $this->input->ip_address();
			// $log['log_status'] = 1;

			//Update ic_form_group_data
			$this->db->where('group_id', $group_data['group_id'])->update($survey_group_table, array(
				'formgroup_data' => json_encode($form_data)
			));

			//Insert log
			// $this->db->insert('ic_log', $log);
		}

		$result['status'] = 1;
		$result['msg'] = 'Data updated successfully.';
		$result['field_value'] = strlen($newValue) == 0 ? 'N/A' : $newValue;
		echo json_encode($result);
		exit();
	}

	public function groupdata_info(){
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			$data_id = $this->uri->segment(4);
			$status = $this->uri->segment(5);

			$data = array(
				'survey_id' => $survey_id,
				'data_id' => $data_id,
				'status' => $status
			);

			$this->load->model('Reports_model');

			$group_info = $this->Reports_model->group_info($data);

			$result = array('group_info' => $group_info);

			$this->load->view('header');
			$this->load->view('reports/groupdata_info', $result);
			$this->load->view('footer');
		}
	}

	public function verify_data(){
		$baseurl = base_url();
		$result = array(
			'csrfHash' => $this->security->get_csrf_hash(),
			'csrfName' => $this->security->get_csrf_token_name()
		);

		if($this->session->userdata('login_id') == '') {
			$result['session_err'] = 1;
			$result['msg'] = 'Session Expired! Please login again to continue.';
			echo json_encode($result);
			exit();
		}

		$status = $this->input->post('status');
		if(!isset($status) || strlen($status) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 1.';
			echo json_encode($result);
			exit();
		}

		$ids = $this->input->post('check');
		if(!$ids || count($ids) == 0) {
			$result['status'] = 0;
			$result['msg'] = 'Invalid request. Please refresh the page and try again 2.';
			echo json_encode($result);
			exit();
		}
		$survey_id = $this->uri->segment(3);
		$survey_table = 'survey'.$survey_id;
		$survey_grouptable = 'survey'.$survey_id.'_groupdata';
		foreach ($ids as $id) {
			date_default_timezone_set('UTC');
			$currentDateTime = date('Y-m-d H:i:s');
			if($this->input->post('status') == 0){
				$status = 0;
			}else{
				$status = 1;
				
			}
			//Prepare verification data
			$verification = array(
				'verified_status' => $this->input->post('status'),
				'verified_id' => $this->session->userdata('login_id'),
				'verified_date' => $currentDateTime,
				'status' => $status
			);
			//Update table
			$query = $this->db->where('id', $id)->update($survey_table, $verification);
			if($query){
				$this->db->select('data_id');
				$this->db->where('id', $id);
				$record_status = $this->db->get($survey_table)->row_array();
				$gverification = array(
					'status' => $status
				);
				if ($this->db->table_exists($survey_grouptable))
				{
					$group_query = $this->db->where('data_id', $record_status['data_id'])->update($survey_grouptable, $gverification);
				}
				if($this->input->post('status') == 1){
					$this->actual_count_update(); 
				}
			}
			
		}

		$result['status'] = 1;
		$result['msg'] = 'Data verified successfully.';
		$result['verified_by'] = $this->session->userdata('name');
		echo json_encode($result);
		exit();
	}

	public function actual_count_update(){
		$this->db->distinct();
		$this->db->select('ft.*,tci.comind_id');
		$this->db->from('form AS ft');
		$this->db->join('tbl_component_indicator AS tci', 'tci.indicator_id = ft.id');
		$this->db->where('ft.status', 1);
		$surveys = $this->db->order_by('tci.comind_id', 'ASC')->get('')->result_array();

		foreach($surveys as $skey => $survey){
			if($survey['id'] != 68){
				$this->db->where('form_id', $survey['id'])->where('status', 1);
				$field = $this->db->where('label', 'Actual count')->get('form_field')->row_array();
			}else{
				$this->db->where('form_id', $survey['id'])->where('status', 1);
				$field = $this->db->where('label', 'Amount leveraged (USD million)')->get('form_field')->row_array();
			}
			if(!is_null($field)) {
				$column = 'field_'.$field['field_id'];
				$survey_table = 'survey'.$survey['id'];
				switch ($survey['id']) {
					case '6':
					case '8':
					case '9':
					case '10':
					case '39':
					case '40':	
					case '41':
					case '45':
					case '49':
					case '56':
					case '57':
					case '58':
					case '59':
					case '60':
					// case '62':
					// case '63':
					case '68':
					case '19':
					case '20':
					case '21':
					case '22':
					case '23':
					case '24':
					case '38':
					case '53':
					case '54':
					case '55':
					case '61':
					case '13':
					// case '26':
					case '65':
					case '44':
					// case '16':
					// case '18':
					case '48':
					// case '25':
					case '32':
						$this->db->select('*');
						$result_list = $this->db->where('status', 1)->get($survey_table)->result_array();

						$this->db->distinct();
						$this->db->select('*');
						$field_list = $this->db->where('survey_id', $survey['id'])->where('status', 1)->get('tbl_actual_fields')->result_array();
						foreach($result_list as $key => $value){
							$field_count = 0;
							$insert_array = array();
							foreach($field_list as $fkey => $field_value){
								$temp = 0;
								$column_count = $field_value['field_id'];
								$temp = intval($value[$column_count]);
								$field_count = $field_count+$temp;

							}
							
							$insert_array[$column] = $field_count;
							// $insert_array[$column] = 0;
							$this->db->where('id', $value['id'])->update($survey_table, $insert_array);
						}
						break;
					case '46':
						$this->db->select('*');
						$result_list = $this->db->where('status', 1)->get($survey_table)->result_array();

						$this->db->distinct();
						$this->db->select('*');
						$field_list = $this->db->where('survey_id', $survey['id'])->where('status', 1)->get('tbl_actual_fields')->result_array();
						foreach($result_list as $key => $value){
							if($value['field_1105'] == '18 to 35 years'){
								$field_count = 0;
								$insert_array = array();
								foreach($field_list as $fkey => $field_value){
									$temp = 0;
									$column_count = $field_value['field_id'];
									$temp = intval($value[$column_count]);
									$field_count = $field_count+$temp;
								}
								$insert_array[$column] = $field_count;
								$this->db->where('id', $value['id'])->update($survey_table, $insert_array);
							}else{
								$insert_array = array();
								$insert_array[$column] = 0;
								$this->db->where('id', $value['id'])->update($survey_table, $insert_array);
							}
						}
						break;
					case '14':
					case '16':
					case '18':
					case '25':
					case '26':
						$this->db->select('*');
						$result_list = $this->db->where('status', 1)->get($survey_table)->result_array();

						$this->db->distinct();
						$this->db->select('*');
						$field_list = $this->db->where('survey_id', $survey['id'])->where('status', 1)->get('tbl_actual_fields')->result_array();
						$survey_group_table = 'survey'.$survey['id'].'_groupdata';
						foreach($result_list as $key => $value){
							$data_id = $value['data_id'];
							$field_count = 0;
							$insert_array = array();
							$this->db->select('data');
							$groupdata_result_list = $this->db->where('data_id', $data_id)->where('status', 1)->get($survey_group_table)->result_array();
							foreach($groupdata_result_list as $key => $gvalue){
								$form_groupdata = (array)json_decode($gvalue['data']);
								foreach($field_list as $fkey => $field_value){
									$column_field = $field_value['field_id'];
									if(isset($form_groupdata[$column_field])){
										$temp = 0;
										$temp = intval($form_groupdata[$column_field]);
										$field_count = $field_count+$temp;
									}
								}
							}
							$insert_array[$column] = $field_count;
							$this->db->where('id', $value['id'])->update($survey_table, $insert_array);
						}
						break;
					default:
						$this->db->select('*');
						$result_list = $this->db->where('status', 1)->get($survey_table)->result_array();
						foreach($result_list as $dkey => $value1){
							$insert_array = array();
							$insert_array[$column] = 1;
							$this->db->where('id', $value1['id'])->update($survey_table, $insert_array);
						}
						break;

				}
			}
			
		}
		// echo "data updated successfully";
	}

	public function reject()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			$curent_page = $this->uri->segment(4);
			$total_records_per_page = $this->uri->segment(5);
			if($survey_id == '' || $survey_id == NULL ){
				show_404();
			}
			if($curent_page == '' || $curent_page == NULL ){
				$curent_page = 1;
			}
			if($total_records_per_page == '' || $total_records_per_page == NULL ){
				$total_records_per_page = 100;
			}

			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_details($survey_id);
			$result['editable'] = true;
			$data['survey_id']= $survey_id;
			$data['curent_page']= $curent_page;
			$data['total_records_per_page']= $total_records_per_page;
			$result['survey_data'] = $this->Reports_model->survey_rejected_data($data);
			$result['total_records'] = $this->Reports_model->survey_rejected_records($survey_id);
			$result['country_list'] = $this->Reports_model->country_list();
			$result['compact_list'] = $this->Reports_model->compact_list();
			$result['actual_list'] = $this->Reports_model->actual_list();
			$result['quarter_list'] = $this->Reports_model->quarter_list();
			$result['geographicscope_list'] = $this->Reports_model->geographicscope_list();
			$result['innovation_platform_list'] = $this->Reports_model->innovation_platform_list();
			$result['technology_type_list'] = $this->Reports_model->technology_type_list();
			$result['technology_deployed_list'] = $this->Reports_model->technology_deployed_list();
			$result['technology_varieties_list'] = $this->Reports_model->technology_varieties_list();
			$result['toolkit_list'] = $this->Reports_model->toolkit_list();
			$result['year_list'] = $this->Reports_model->year_list();
			$result['index_start'] = ($total_records_per_page*$curent_page)-$total_records_per_page;
			$result = $this->security->xss_clean($result);
			$this->load->view('header');
			$this->load->view('reports/view_rejected', $result);
			$this->load->view('footer');
		}
	}

	public function rejecteddata_edit()
	{
		if(($this->session->userdata('login_id') == '')) {
			$baseurl = base_url();
			redirect($baseurl);
		}else{
			$survey_id = $this->uri->segment(3);
			if($survey_id == '' || $survey_id == NULL ){
				show_404();
			}

			$record_id = $this->uri->segment(4);
			$this->load->model('Reports_model');
			$result = $this->Reports_model->survey_fields($survey_id);

			$data['survey_id'] = $survey_id;
			$data['record_id'] = $record_id;
			$result['survey_data'] = $this->Reports_model->survey_data_by_id($data);
			$result['survey_data1'] = $this->Reports_model->survey_data_by_id_1($data);
			
			//print_r($result);exit;
			$result = $this->security->xss_clean($result);
			$this->load->view('header');
			$this->load->view('reports/rejecteddata_edit', $result);
			$this->load->view('footer');
		}
	}

	public function rejecteddata_update()	{
		//var_dump("hello");die();
		$baseurl = base_url();
		date_default_timezone_set("UTC");		
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}
		// $data_id=$this->input->post('data_id');
		$record_id=$this->uri->segment(4);
		
		// echo "<script>console.log('dataID: '".$data_id.")</script>";
		// echo '<pre>';print_r($_POST);exit;
		$data_id=$this->input->post('data_id');
		$user_id = $this->session->userdata('login_id');		
		$form_id = $this->uri->segment(3);
		$survey_table= "survey".$this->uri->segment(3);
		$survey_group_table= "survey".$this->uri->segment(3)."_groupdata";
		
		$insert_array = array();
		$dataarray = array();
		$time = time();
		$datetime = date('Y-m-d H:i:s');

		$this->db->select('field_id');
		$this->db->where('type', 'group')->where('form_id',  $form_id)->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		if($check_group_fields > 0){
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $form_id)->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$get_group_fields_array = array();

			foreach ($get_group_id_array as $key => $group) {
    			$this->db->select('child_id');
	        	$this->db->where('field_id', $group)->where('status', 1)->where('form_id', $form_id);
	        	$group_field = $this->db->get('form_field')->row_array();

	        	$current_group_fields = explode(",", $group_field['child_id']);

	        	foreach ($current_group_fields as $key => $c_group) {
	        		array_push($get_group_fields_array, $c_group);
	        	}
    		}			

			$this->db->select('field_id');
			$this->db->where_not_in('field_id', $get_group_fields_array)->where('status', 1)->where('form_id', $form_id);
			$non_group_fields = $this->db->get('form_field')->result_array();

			foreach ($non_group_fields as $key => $value) {
				$fieldkey = "field_".$value['field_id'];
				$multi_value = array();
				if(isset($_POST[$fieldkey])){
					if(is_array($_POST[$fieldkey])){
						foreach ($_POST[$fieldkey] as $multiplevalue) {
							array_push($multi_value, $multiplevalue);
						}
						$insert_array[$fieldkey] = implode('&#44;', $multi_value);
						/*json_encode($multi_value, JSON_UNESCAPED_UNICODE);*/
					}else{
						if($_POST[$fieldkey] == ''){
							$insert_array[$fieldkey] = NULL;
						}else{
							$insert_array[$fieldkey] = $_POST[$fieldkey];
						}
					}
				}else{
					$insert_array[$fieldkey] = NULL;
				}
			}
		}else{			
			foreach ($_POST as $key => $field) {
				$multi_value = array();
				if(is_array($field)){
					foreach ($field as $value) {
						array_push($multi_value, $value);
					}
					$insert_array[$key] = implode('&#44;', $multi_value);
					/*json_encode($multi_value, JSON_UNESCAPED_UNICODE)*/
				}else{
					if($field == ''){
						$insert_array[$key] = NULL;
					}else{
						$insert_array[$key] = $field;
					}
				}
			}
		}
		//$insert_array['form_data'] = json_encode($dataarray, JSON_UNESCAPED_UNICODE);
		// $insert_array['user_id'] = $user_id;
		$insert_array['datetime'] = $datetime;
		$insert_array['ip_address'] = $this->input->ip_address();
		$insert_array['status'] = 2;
		$insert_array['verified_status'] = NULL;

		

		$query = $this->db->where('id', $record_id)->update($survey_table, $insert_array);

		if($query) {
			if($check_group_fields > 0){
				$this->db->select('GROUP_CONCAT(field_id) as field_ids');
				$this->db->where('type', 'group')->where('form_id',  $form_id)->where('status', 1);
				$get_group_id = $this->db->get('form_field')->row_array();

				$get_group_id_array = explode(",", $get_group_id['field_ids']);
				foreach ($get_group_id_array as $groupkey => $groupid) {
					$this->db->select('child_id');
	        		$this->db->where('field_id', $groupid)->where('status', 1)->where('form_id', $form_id);
	        		$get_fields_bygroupid = $this->db->get('form_field')->row_array();

					$get_fields_bygroupid_array = explode(",", $get_fields_bygroupid['child_id']);

					$first_field = "field_".$get_fields_bygroupid_array[0];
						if(isset($_POST[$first_field])){
							// foreach ($_POST[$first_field] as $fieldskey => $value) {
								foreach ($_POST['group_id'] as $groupkey => $group_id) {
									if(isset($group_id) && $group_id != ""){
										// echo $group_id;
										$groupdata = array();
										$field_array = array();

										foreach ($get_fields_bygroupid_array as $key => $fieldvalue) {
											$group_field_key = "field_".$fieldvalue;
											if(isset($_POST[$group_field_key][$groupkey])){
												$multi_value = array();
												if(is_array($_POST[$group_field_key][$groupkey])){
													foreach ($_POST[$group_field_key][$groupkey] as $multivalue) {
														array_push($multi_value, $multivalue);
													}
													$field_array[$group_field_key] = implode('&#44;', $multi_value);
													
												}else{
													$field_array[$group_field_key] = $_POST[$group_field_key][$groupkey];
												}
											}else{
												$field_array[$group_field_key] = "N/A";
											}									
										}

										$groupdata['data'] = json_encode($field_array, JSON_UNESCAPED_UNICODE);
										$groupdata['datetime'] = $datetime;
										$groupdata['ip_address'] = $this->input->ip_address();
										$groupdata['status'] = 2;

										$groupquery = $this->db->where('data_id', $data_id)->where('group_id', $group_id)->update($survey_group_table, $groupdata);
										// echo $this->db->last_query();
									}else{
										// echo "no group id";
										$groupdata = array();
										//id	group_id	data_id	groupfield_id	data	user_id	datetime	ip_address	status	
										$groupdata['group_id'] = time().$groupkey.$groupkey.'-'.$this->session->userdata('login_id');
										$groupdata['data_id'] = $data_id;
										// $groupdata['form_id'] = $insert_array['form_id'];
										$groupdata['user_id'] = $insert_array['user_id'];
										$groupdata['groupfield_id'] = $groupid;
										
										$field_array = array();
			
										foreach ($get_fields_bygroupid_array as $key => $fieldvalue) {
											$group_field_key = "field_".$fieldvalue;
											if(isset($_POST[$group_field_key][$groupkey])){
												$multi_value = array();
												if(is_array($_POST[$group_field_key][$groupkey])){
													foreach ($_POST[$group_field_key][$groupkey] as $multivalue) {
														array_push($multi_value, $multivalue);
													}
													$field_array[$group_field_key] = implode('&#44;', $multi_value);
													
												}else{
													$field_array[$group_field_key] = $_POST[$group_field_key][$groupkey];
												}
											}else{
												$field_array[$group_field_key] = "N/A";
											}									
										}
			
										$groupdata['data'] = json_encode($field_array, JSON_UNESCAPED_UNICODE);
										$groupdata['datetime'] = $datetime;
										$groupdata['ip_address'] = $this->input->ip_address();
										$groupdata['status'] = $insert_array['status'];

										
										$groupquery = $this->db->insert($survey_group_table, $groupdata);

									}
								}
								// print_r($groupdata);
							// }
						}else{
							$groupdata = array();
							$groupdata['status'] = 2;
							$groupquery = $this->db->where('data_id', $data_id)->update($survey_group_table, $groupdata);
							
						}
					// }
				}

				// exit();
			}

			//Insert uploaded images in db
			if(isset($_FILES['survey_images'])) {
				foreach ($_FILES['survey_images']['name'] as $key => $si) {
					if($_FILES['survey_images']['size'][$key] > 0) {
						//Upload Image
						$file_name = $_FILES['survey_images']['name'][$key];
						$ext = pathinfo($file_name, PATHINFO_EXTENSION);
						$file = $file_name;
						// $file = uniqid().$key.$this->session->userdata('login_id').'.'.$ext;
						$file_size = $_FILES['survey_images']['size'][$key];

						if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'uploads/survey/');
						$imgurl = UPLOAD_DIR . $file;

						$filename = $_FILES["survey_images"]["tmp_name"][$key];
						$file_directory = "uploads/survey/";
						if($filename) {
							if(move_uploaded_file($filename, $file_directory . $file)){
								$this->db->select('data_id');
	        					$this->db->where('data_id', $insert_array['data_id'])->where('status', 1);
	        					$check_record = $this->db->get('ic_data_file')->row_array();
								 if(isset($check_record['data_id'])){
									$surv_image_data = array(
										'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
										'form_id' => $this->uri->segment(3),
										'user_id' => $this->session->userdata('login_id'),
										'file_name' => $file,
										'file_type' => 'document',
										'created_date' => $datetime,
										'ip_address' => $this->input->ip_address(),
										'status' => 1
									);
									$this->db->where('data_id', $insert_array['data_id'])->update('ic_data_file', $surv_image_data);

								 }else{
									$surv_image_data = array(
										'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
										'data_id' => $insert_array['data_id'],
										'form_id' => $this->uri->segment(3),
										'user_id' => $this->session->userdata('login_id'),
										'file_name' => $file,
										'file_type' => 'document',
										'created_date' => $datetime,
										'ip_address' => $this->input->ip_address(),
										'status' => 1
									);
									$this->db->insert('ic_data_file', $surv_image_data);
								}
							}
						}
					}
				}
			}

			if($check_group_fields > 0){
				$gp_status = 1;
			}else{
				$gp_status = 0;
			}

			$ajax_message = 'Data updated successfully.';
			echo json_encode(array(
				'status' => 1,
				'group_status' => $gp_status,
				'msg' => $ajax_message
			));
			exit();
		} else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}
	}

	public function check_childfields(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
		}

		$field_id = $_POST['field_id'];
		$field_value = $_POST['field_value'];
		$survey_id = $_POST['survey_id'];

		$table = "survey".$survey_id;

		if(is_array($field_value)){
			$child_string = '';

			foreach ($field_value as $key => $value) {
				$this->db->where('form_id', $survey_id)->where('parent_id', $field_id)->like('parent_value', $value)->where('status', 1)->order_by('slno');
				$get_child_list = $this->db->get('form_field')->result_array();

				if(count($get_child_list) > 0){

					foreach ($get_child_list as $dkey => $d_field) {
						$option_vals = explode("&#44;", $d_field['parent_value']);

						if(!in_array($value, $option_vals)){
							unset($get_child_list[$dkey]);
						}

						if(in_array($value, $option_vals)){
							if($child_string != ''){
								$child_string .= ",".$d_field['field_id'];
							}else{
								$child_string .= $d_field['field_id'];
							}
						}
					}
				}
			}

			$child_string_array = explode(",", $child_string);

			$this->db->where('form_id', $survey_id)->where_in('field_id', $child_string_array);
			$this->db->where('status', 1)->order_by('slno');
			$get_child_list_array = $this->db->get('form_field')->result_array();

			foreach ($get_child_list_array as $key => $field) {
				switch ($field['type']) {
					case 'select':
					case 'radio-group':
					case 'checkbox-group':
						$this->db->where('field_id', $field['field_id'])->where('status', 1)->order_by('order_by');
						$get_child_list_array[$key]['options'] = $this->db->get('form_field_multiple')->result_array();
						break;
					
					case 'group':
						$this->db->where('parent_id', $field['field_id'])->where('parent_value IS NULL')->where('status', 1);
						$this->db->order_by('slno');
						$survey_groupfields = $this->db->get('form_field')->result_array();

						foreach ($survey_groupfields as $gkey => $groupfield) {
							switch ($groupfield['type']) {
								case 'select':
								case 'radio-group':
								case 'checkbox-group':
									$this->db->select('*');
									$this->db->where('field_id', $groupfield['field_id'])->where('status', 1);
									$this->db->order_by('order_by');
									$survey_groupfields[$gkey]['options'] = $this->db->get('form_field_multiple')->result_array();
									break;
							}

							$this->db->where('parent_id', $groupfield['field_id'])->where('status', 1);
							$check_child_fields = $this->db->get('form_field')->num_rows();

							$survey_groupfields[$gkey]['child_count']  = $check_child_fields;
						}

						$get_child_list_array[$key]['groupfields'] = $survey_groupfields;
						break;
				}

				$childfield = "field_".$field['field_id'];
				if(isset($_POST['record_id']) && ($_POST['record_id'] != '')){
					$get_child_field_value = $this->db->select($childfield)->where('id', $_POST['record_id'])->get($table)->row_array();

					$get_child_list_array[$key]['value'] = $get_child_field_value[$childfield];
				}else{
					$get_child_list_array[$key]['value'] = "";
				}

				$this->db->select('field_id');
				$this->db->where('parent_id', $field['field_id'])->where('status', 1)->order_by('slno');
				$get_child_list_array[$key]['check_child_fields'] = $this->db->get('form_field')->num_rows();
			}

			if(count($get_child_list_array) > 0){
				$get_child_list_array = array_values($get_child_list_array);
			}else{
				$get_child_list_array = array();
			}

			$result = array('status' => 1, 'child_field' => $get_child_list_array);
		}else{
			$this->db->where('parent_id', $field_id)->where('form_id', $survey_id)->like('parent_value', $field_value)->where('status', 1)->order_by('slno');
			$get_child_fields = $this->db->get('form_field')->result_array();
			foreach ($get_child_fields as $key => $field) {
				switch ($field['type']) {
					case 'select':
					case 'radio-group':
					case 'checkbox-group':
						$this->db->where('field_id', $field['field_id'])->where('status', 1)->order_by('order_by');
						$get_child_fields[$key]['options'] = $this->db->get('form_field_multiple')->result_array();
						break;

					case 'lkp_country':
						$this->db->select('country_id, name, code');
						$this->db->order_by('name');
						$options = $this->db->where('status', 1)->get('lkp_country')->result_array();

						$get_child_fields[$key]['options'] = $options;
						break;

					case 'group':
						$this->db->where('parent_id', $field['field_id'])->where('parent_value IS NULL')->where('status', 1);
						$this->db->order_by('slno');
						$survey_groupfields = $this->db->get('form_field')->result_array();

						foreach ($survey_groupfields as $gkey => $groupfield) {
							switch ($groupfield['type']) {
								case 'select':
								case 'radio-group':
								case 'checkbox-group':
									$this->db->select('*');
									$this->db->where('field_id', $groupfield['field_id'])->where('status', 1);
									$this->db->order_by('order_by');
									$survey_groupfields[$gkey]['options'] = $this->db->get('form_field_multiple')->result_array();
									break;
							}

							$this->db->where('parent_id', $groupfield['field_id'])->where('status', 1);
							$check_child_fields = $this->db->get('form_field')->num_rows();

							$survey_groupfields[$gkey]['child_count']  = $check_child_fields;
						}

						$get_child_fields[$key]['groupfields'] = $survey_groupfields;
						break;
					case 'project_countries':
						$this->db->select('location');
						$this->db->where('proj_id', $this->input->post('project_id'));
						$project_country = $this->db->get('rpt_project_location')->row_array();

						$location_info = json_decode($project_country['location'], true);

						$this->db->select('*');
						$this->db->where_in('country_id', $location_info['country'])->where('status', 1);
						$this->db->order_by('name');
						$project_country_list = $this->db->get('lkp_country')->result_array();

						$get_child_fields[$key]['options'] = $project_country_list;					
						break;
				}

				$get_child_fields[$key]['value'] = "";				

				$this->db->select('field_id');
				$this->db->where('parent_id', $field['field_id'])->where('status', 1)->order_by('slno');
				$get_child_fields[$key]['check_child_fields'] = $this->db->get('form_field')->num_rows();
				
				$option_vals = explode("&#44;", $field['parent_value']);
				if(!in_array($field_value, $option_vals)){
					unset($get_child_fields[$key]);
				}
			}
			$get_child_fields = array_values($get_child_fields);

			$result = array('status' => 1, 'child_field' => $get_child_fields);
		}

		echo json_encode($result);
		exit();	
	}

	public function get_tech_type()
	{
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
		}else{
			$compact_id = $this->input->post('compact_id');
			// $compact_id = $data['compact_id'];
			$this->load->model('Reports_model');
			$result['tech_type_list'] = $this->Reports_model->get_tech_types($compact_id);
			$result['toolkit_list'] = $this->Reports_model->get_toolkit_type($compact_id);
			$result['status'] = 1;

			echo json_encode($result);
			exit();
		}
	}

	public function get_tech_deployed()
	{
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
		}else{
			$this->load->model('Reports_model');
			$compact_id = $this->input->post('compact_id');
			$tech_type_id = $this->input->post('tech_type_id');
			$data['tech_type_id'] = $tech_type_id;
			$data['compact_id'] = $compact_id;
			$result['tech_deployed_list'] = $this->Reports_model->get_tech_deployes($data);
			$result['status'] = 1;
			echo json_encode($result);
			exit();
		}
	}
	public function get_tech_deploye_type()
	{
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
		}else{
			$this->load->model('Reports_model');
			$compact_id = $this->input->post('compact_id');
			$data['compact_id'] = $compact_id;
			$result['tech_deploye_type_list'] = $this->Reports_model->get_tech_deployes_type($data);
			$result['status'] = 1;
			echo json_encode($result);
			exit();
		}
	}

	public function get_tech_verities()
	{
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
		}else{
			$this->load->model('Reports_model');
			$tech_deployed_id = $this->input->post('tech_deployed_id');
			$compact_id = $this->input->post('compact_id');
			$tech_type_id = $this->input->post('tech_type_id');
			$data['tech_type_id'] = $tech_type_id;
			$data['compact_id'] = $compact_id;
			$data['tech_deployed_id'] = $tech_deployed_id;
			$result['tech_verities_list'] = $this->Reports_model->get_tech_verities($data);
			$result['status'] = 1;
			echo json_encode($result);
			exit();
		}
	}

	// download excel

	public function download_excel(){
		$baseurl = base_url();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}
		 $this->load->model('Reports_model');

		$this->load->model('Reports_model');
		// $result['components']= $this->Reports_model->all_components();
		
		$result['compacts_list']= $this->Reports_model->user_compact_list();
		$result['years']= $this->Reports_model->year_list();
		$result['quarters']= $this->Reports_model->quarter_list();
		$result["status"]="1";
		$result = $this->security->xss_clean($result);
		$this->load->view('header');
		$this->load->view('reports/download_excel', $result);
		$this->load->view('footer');
	}
	public function get_filterdata(){
		$baseurl = base_url();
		$result = array();
		if(($this->session->userdata('login_id') == '')) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				echo json_encode(array(
					'status' => 0,
					'msg' => 'Session Expired! Please login again to continue.'
				));
				exit();
			} else {
				redirect($baseurl);
			}
		}else{
			$compact_id = $this->input->post('compact_id');
			$year_id = $this->input->post('year_id');
			$quarter_id = $this->input->post('quarter_id');
			
			$data = array(
				'compact_id' => $compact_id,
				'year_id' => $year_id,
				'quarter_id' => $quarter_id
			);
			$this->load->model('Reports_model');
			$result['compact_data'] = $this->Reports_model->compact_data($data);
		}
		 $result['status'] = 1;
		 echo json_encode($result);
		 exit();
		
	}
}