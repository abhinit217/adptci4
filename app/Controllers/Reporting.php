<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporting extends CI_Controller {
	
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

	public function block($type = null){
		$this->load->view('common/header');
		$this->load->view('common/block_reporting', array('type' => $type));
		$this->load->view('common/footer');
	}

	public function upload_data(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$result= array();
		//getting common lkp data from tables start from here
		$this->db->select('*');
		$this->db->where('level_m_status', 1);
		$result['lkp_level_measurement'] = $this->db->get('lkp_level_measurement')->result_array();
		$this->db->select('*');
		$this->db->where('year_status', 1);
		$result['lkp_year_list'] = $this->db->get('lkp_year')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->order_by('slno');
		$result['lkp_country_list'] = $this->db->get('lkp_country')->result_array();
		$this->db->select('*');
		$this->db->where('county_status', 1);
		$this->db->order_by('county_name');
		$result['lkp_county_list'] = $this->db->get('lkp_county')->result_array();
		$this->db->select('*');
		$this->db->where('dimensions_status', 1);
		$result['lkp_dimensions_list'] = $this->db->get('lkp_dimensions')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$result['lkp_user_list'] = $this->db->get('tbl_users')->row_array();
		
		//getting common lkp data from tables end upto here

		$this->load->view('common/header');
		$this->load->view('reporting/upload_data', $result);		
		$this->load->view('common/footer');
	}

	public function upload_data_bulk(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$result= array();
		//getting common lkp data from tables start from 
		$measure_level_id =0;
		// if(!empty($this->input->post('measure_level_id'))){
		if(!empty($this->uri->segment('3'))){
			$measure_level_id = $this->uri->segment('3');
		}
		$this->db->select('*');
		$this->db->where('level_m_status', 1);
		$result['lkp_level_measurement'] = $this->db->get('lkp_level_measurement')->result_array();
		$this->db->select('*');
		$this->db->where('year_status', 1);
		$result['lkp_year_list'] = $this->db->get('lkp_year')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->order_by('slno');
		$result['lkp_country_list'] = $this->db->get('lkp_country')->result_array();
		$this->db->select('*');
		$this->db->where('county_status', 1);
		$this->db->order_by('county_name');
		$result['lkp_county_list'] = $this->db->get('lkp_county')->result_array();
		$this->db->select('*');
		$this->db->where('dimensions_status', 1);
		$result['lkp_dimensions_list'] = $this->db->get('lkp_dimensions')->result_array();
		$this->db->select('*');
		$this->db->where('sub_dimensions_status', 1);
		$result['lkp_sub_dimensions_list'] = $this->db->get('lkp_sub_dimensions')->result_array();
		$this->db->select('*');
		$this->db->where('categories_status', 1);
		$result['lkp_categories_list'] = $this->db->get('lkp_categories')->result_array();
		$result['measure_level_id'] = $measure_level_id;

		// $this->db->select('*');
		// $this->db->where('relation_status', 1);
		// $result['lkp_indicators_list'] = $this->db->get('rpt_form_relation')->result_array();
		
		$this->db->select('rfr.*,f.title,f.description,lm.level_m_name,lmu.m_unit_name');
		$this->db->join('lkp_level_measurement as lm', 'rfr.lkp_level_measurement = lm.level_m_id');
		$this->db->join('lkp_m_units as lmu', 'rfr.lkp_measurement_unit = lmu.m_unit_id');
		$this->db->join('form as f', 'rfr.indicator_id = f.id');
		$this->db->where('rfr.relation_status', 1);
		if($measure_level_id >0){
			$this->db->where('rfr.lkp_level_measurement', $measure_level_id);
		}
		$this->db->order_by('rfr.lkp_dimension_id,rfr.lkp_subdimension_id,rfr.lkp_category_id');
		$result['lkp_indicators_list'] = $this->db->get('rpt_form_relation as rfr')->result_array();

		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$result['lkp_user_list'] = $this->db->get('tbl_users')->row_array();
		
		//getting common lkp data from tables end upto here

		$this->load->view('common/header');
		$this->load->view('reporting/upload_data_bulk', $result);		
		$this->load->view('common/footer');
	}

	public function bulk_preview(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$result= array();
		$measure_level_id =0;
		$year =0;
		$country =0;
		$county =0;
		// if(!empty($this->input->post('measure_level_id'))){
		if(!empty($this->uri->segment('3'))){
			$measure_level_id = $this->uri->segment('3');
		}
		if(!empty($this->uri->segment('4'))){
			$year = $this->uri->segment('4');
		}
		if(!empty($this->uri->segment('5'))){
			$country = $this->uri->segment('5');
		}
		if(!empty($this->uri->segment('6'))){
			$county = $this->uri->segment('6');
		}
		
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$result['lkp_user_list'] = $this->db->get('tbl_users')->row_array();
		if(isset($result['lkp_user_list'])){
			$country_id=$result['lkp_user_list']['country_id'];
		}else{
			$country_id=1;
		}
		$result['country_id'] = $country_id;
		if(isset($result['lkp_user_list'])){
			$county_id=$result['lkp_user_list']['county_id'];
		}else{
			$county_id=1;
		}
		$result['county_id'] = $county_id;
		$this->db->select('*');
		$this->db->where('level_m_status', 1);
		$result['lkp_level_measurement'] = $this->db->get('lkp_level_measurement')->result_array();
		$this->db->select('*');
		$this->db->where('year_status', 1);
		$result['lkp_year_list'] = $this->db->get('lkp_year')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->order_by('slno');
		$result['lkp_country_list'] = $this->db->get('lkp_country')->result_array();
		$this->db->select('*');
		$this->db->where('county_status', 1);
		$this->db->order_by('county_name');
		$result['lkp_county_list'] = $this->db->get('lkp_county')->result_array();
		$this->db->select('*');
		$this->db->where('dimensions_status', 1);
		$result['lkp_dimensions_list'] = $this->db->get('lkp_dimensions')->result_array();
		$this->db->select('*');
		$this->db->where('sub_dimensions_status', 1);
		$result['lkp_sub_dimensions_list'] = $this->db->get('lkp_sub_dimensions')->result_array();
		$this->db->select('*');
		$this->db->where('categories_status', 1);
		$result['lkp_categories_list'] = $this->db->get('lkp_categories')->result_array();
		$this->db->select('rfr.*,f.title,f.description,lm.level_m_name,lmu.m_unit_name');
		$this->db->join('lkp_level_measurement as lm', 'rfr.lkp_level_measurement = lm.level_m_id');
		$this->db->join('lkp_m_units as lmu', 'rfr.lkp_measurement_unit = lmu.m_unit_id');
		$this->db->join('form as f', 'rfr.indicator_id = f.id');
		// $this->db->join('ic_form_data_a as fd', 'fd.form_id = f.id');
		$this->db->where('rfr.relation_status', 1);
		if($measure_level_id >0){
			$this->db->where('rfr.lkp_level_measurement', $measure_level_id);
		}
		$this->db->order_by('rfr.lkp_dimension_id,rfr.lkp_subdimension_id,rfr.lkp_category_id');
		$result['lkp_indicators_list'] = $this->db->get('rpt_form_relation as rfr')->result_array();
		$form_id_array =array();
		foreach ($result['lkp_indicators_list'] as $key => $value) {
			array_push($form_id_array,$value['indicator_id']);
		}
		$this->db->select('ifd.*,idf.file_name');
		$this->db->join('ic_data_file as idf', 'ifd.data_id = idf.data_id');
		$this->db->where_in('ifd.form_id', $form_id_array);
		$this->db->where_in('ifd.year_id', $year);
		$this->db->where_in('ifd.country_id', $country);
		if($measure_level_id !=1){
			$this->db->where_in('ifd.county_id', $county);
		}
		$this->db->where_in('ifd.status', [1,2]);
		$ic_form_data_a = $this->db->get('ic_form_data_a as ifd')->result_array();
		$form_id_data_array =array();
		foreach ($ic_form_data_a as $key => $data) {
			$form_id_data_array[$data['form_id']][0]=$data['actual_value'];
			$form_id_data_array[$data['form_id']][1]=$data['data_source'];
			$form_id_data_array[$data['form_id']][2]=$data['remarks'];
			// $form_id_data_array[$data['form_id']][3]=base_url()."upload/survey/".$data['file_name'];
			$form_id_data_array[$data['form_id']][3]=$data['file_name'];
		}
		// print_r($this->db->last_query());exit();
		// var_dump($form_id_data_array);exit();
		$result['form_id_array'] = $form_id_array;
		$result['form_id_data_array'] = $form_id_data_array;
		$result['measure_level_id'] = $measure_level_id;
		$result['year'] = $year;
		$result['country'] = $country;
		$result['county'] = $county;
		
		
		// print_r($this->uri->segment('3'));exit();
		//getting common lkp data from tables end upto here
		// $this->load->flash("test");
		// $this->session->set_flashdata('response',"Data Inserted Successfully");
		$this->load->view('common/header');
		$this->load->view('reporting/bulk_preview', $result);		
		$this->load->view('common/footer');
	}

	public function insert_bulk_indicatordata(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$time = time();
		$count=0;
		$datetime = date('Y-m-d H:i:s');
		$tablename="ic_form_data_a";
		$measure_level_id = $this->input->post('measure_level');
		$year_val = $this->input->post('year');
		$country_val = $this->input->post('country');
		if($measure_level_id==1){
			$county_val = 0;
		}else{
			$county_val = $this->input->post('county');
		}
		$this->db->select('rfr.*');
		$this->db->join('form as f', 'rfr.indicator_id = f.id');
		$this->db->where('rfr.relation_status', 1);
		if($measure_level_id >0){
			$this->db->where('rfr.lkp_level_measurement', $measure_level_id);
		}
		$this->db->order_by('rfr.lkp_dimension_id,rfr.lkp_subdimension_id,rfr.lkp_category_id');
		$indicators_list = $this->db->get('rpt_form_relation as rfr')->result_array();
		foreach ($indicators_list as $key => $indicator) {
			$count++;
			$actual_val=0;
			$indicator_id = $indicator['indicator_id'];
			$dimension_val = $this->input->post($indicator['indicator_id'].'_dimensions_id');
			$subdimension_val = $this->input->post($indicator['indicator_id'].'_subdimensions_id');
			$category_val = $this->input->post($indicator['indicator_id'].'_category_id');
			$actual_val = $this->input->post($indicator['indicator_id'].'_actual');
			$data_source = $this->input->post($indicator['indicator_id'].'_d_source');
			$data_sets = $this->input->post($indicator['indicator_id'].'_data_sets');
			$remarks = $this->input->post($indicator['indicator_id'].'_remarks');
			$insert_array =array();
			$time=$time+10;
			$insert_array['data_id'] = $time.'-'.$this->session->userdata('login_id');
			$insert_array['form_id']=$indicator_id;
			$insert_array['measurement_level']=$measure_level_id;
			$insert_array['year_id']=$year_val;
			$insert_array['country_id']=$country_val;
			$insert_array['county_id']=$county_val;
			$insert_array['dimension_id']=$dimension_val;
			$insert_array['sub_dimension_id']=$subdimension_val;
			$insert_array['category_id']=$category_val;
			$insert_array['actual_value']=$actual_val;
			$insert_array['data_source']=$data_source;
			$insert_array['data_sets']=$data_sets;
			$insert_array['remarks']=$remarks;
			$insert_array['reg_date_time']=$datetime;
			$insert_array['user_id']=$this->session->userdata('login_id');
			if($this->session->userdata('role')==1){
				$insert_array['status']=3;  // For Admin submited record auto approval
			}else{
				$insert_array['status']=2; // for tother users submited only
			}
			$record_status =0;
			$this->db->select('*');
			$this->db->where_in('form_id', $indicator_id);
			$this->db->where_in('year_id', $year_val);
			$this->db->where_in('country_id', $country_val);
			$this->db->where_in('county_id', $county_val);
			$this->db->where_in('status', [1,2,3,4]);
			$ic_form_data_a_rset = $this->db->get('ic_form_data_a')->result_array();
			foreach ($ic_form_data_a_rset as $key => $rdata) {
				//get existing record details
				$record_status =$rdata['status'];
				$insert_array['data_id']=$rdata['data_id'];
				$record_id=$rdata['id'];
			}
			if($actual_val!="" || $actual_val!=0){ //check wether in form this indicator value
				if($record_status==2 || $record_status==3){
					//if already records exists updated record
					$surv_update_data =array();
					$surv_update_data['measurement_level']=$measure_level_id;
					$surv_update_data['actual_value']=$actual_val;
					$surv_update_data['data_source']=$data_source;
					$surv_update_data['data_sets']=$data_sets;
					$surv_update_data['remarks']=$remarks;
					$surv_update_data['reg_date_time']=$datetime;
					// $query = $this->db->where('data_id', $insert_array['data_id'])->update('ic_form_data_a', $surv_update_data);
					$query = $this->db->where('id', $record_id)->update('ic_form_data_a', $surv_update_data);
					// print_r($this->db->last_query());exit();
				}
				if($record_status==0){
					//if record doesint exists insert new record
					$query = $this->db->insert($tablename, $insert_array);
					// print_r($this->db->last_query());exit();
				}
				if($query){
					// Insert uploaded images / files in db		
								// $indicator_id.'_d_sets';
					$data_set_field_name=$indicator_id.'_d_sets';
					if(isset($_FILES[$data_set_field_name])) {
						// foreach ($_FILES[$data_set_field_name]['name'] as $key => $si) {
							if($_FILES[$data_set_field_name]['size'] > 0) {
								//Upload Image
								$file_name = $_FILES[$data_set_field_name]['name'];
								$ext = pathinfo($file_name, PATHINFO_EXTENSION);
								// $file = $file_name;
								$file = uniqid().$key.$this->session->userdata('login_id').'.'.$ext;
								$path_parts = pathinfo($_FILES[$data_set_field_name]['name']);
								$extension = $path_parts['extension'];
								$file_type="image";
								if($extension=='pdf'|| $extension=='docx'|| $extension=='doc'){
									$file_type="document";
								}else{
									$file_type="image";
								}
								$file_size = $_FILES[$data_set_field_name]['size'];
	
								if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'upload/survey/');
								$imgurl = UPLOAD_DIR . $file;
	
								$filename = $_FILES[$data_set_field_name]["tmp_name"];
								$file_directory = "upload/survey/";
								if($filename) {
									if(move_uploaded_file($filename, $file_directory . $file)){
										$this->db->select('data_id');
										$this->db->where('data_id', $insert_array['data_id'])->where('status', 1);
										$check_record = $this->db->get('ic_data_file')->row_array();
										 if(isset($check_record['data_id'])){
											$surv_image_data = array(
												'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
												'form_id' => $indicator_id,
												'user_id' => $this->session->userdata('login_id'),
												'file_name' => $file,
												'file_type' => $file_type,
												'created_date' => $datetime,
												'ip_address' => $this->input->ip_address(),
												'status' => 1
											);
											$this->db->where('data_id', $insert_array['data_id'])->update('ic_data_file', $surv_image_data);
	
										 }else{
											$surv_image_data = array(
												'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
												'data_id' => $insert_array['data_id'],
												'form_id' => $indicator_id,
												'user_id' => $this->session->userdata('login_id'),
												'file_name' => $file,
												'file_type' => $file_type,
												'created_date' => $datetime,
												'ip_address' => $this->input->ip_address(),
												'status' => 1
											);
											$this->db->insert('ic_data_file', $surv_image_data);
										}
									}
								}
							}
						// }
					}
					$query_status=1;
				}else{
					$query_status=0;
				}
			}

			
		}
		
		if($query_status==1){
			// $result['measure_level_id'] = $measure_level_id;
			// $result['year'] = $year_val;
			// $result['country'] = $country_val;
			// $result['county'] = $county_val;
			// $this->load->view('common/header');
			// $this->load->view('reporting/bulk_preview', $result);		
			// $this->load->view('common/footer');
			// redirect('/reporting/bulk_preview/'.$measure_level_id.'/'.$year_val.'/'.$country_val.'/'.$county_val.'/5');
			echo json_encode(array(
				'status' => 1,
				'msg' => 'Submitted successfully.'
			));
		}else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
		}
		exit();
	}


	public function c_dashboard(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$result= array();
		if(!empty($this->uri->segment('3')) && $this->session->userdata('role')==1){
			$result['country_id'] = $this->uri->segment('3');
		}else{
			$this->db->select('*');
			$this->db->where('status', 1);
			$this->db->where('user_id', $this->session->userdata('login_id'));
			$result['lkp_user_list'] = $this->db->get('tbl_users')->row_array();
			if(isset($result['lkp_user_list'])){
				$country_id=$result['lkp_user_list']['country_id'];
			}else{
				$country_id=1;
			}
			$result['country_id'] = $country_id;
			if(isset($result['lkp_user_list'])){
				$county_id=$result['lkp_user_list']['county_id'];
			}else{
				$county_id=1;
			}
			$result['county_id'] = $county_id;
		}
		
		// print_r($this->uri->segment('3'));exit();
		//getting common lkp data from tables end upto here

		$this->load->view('common/header');
		$this->load->view('dashboard/c_dashboard', $result);		
		$this->load->view('common/footer');
	}

	public function comparisons(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$result= array();
		if(!empty($this->uri->segment('3'))){
			$result['country_id'] = $this->uri->segment('3');
		}else{
			$this->db->select('*');
			$this->db->where('status', 1);
			$this->db->where('user_id', $this->session->userdata('login_id'));
			$result['lkp_user_list'] = $this->db->get('tbl_users')->row_array();
			if(isset($result['lkp_user_list'])){
				$country_id=$result['lkp_user_list']['country_id'];
			}else{
				$country_id=1;
			}
			$result['country_id'] = $country_id;
		}
		
		// print_r($this->uri->segment('3'));exit();
		//getting common lkp data from tables end upto here

		$this->load->view('common/header');
		$this->load->view('dashboard/comparisons', $result);		
		$this->load->view('common/footer');
	}

	public function edit_data(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$record_id = $this->uri->segment('3');
		// $indicator_id = $this->uri->segment('4');
		$result= array();
		//getting common lkp data from tables start from here
		$this->db->select('*');
		$this->db->where('year_status', 1);
		$result['lkp_year_list'] = $this->db->get('lkp_year')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->order_by('slno');
		$result['lkp_country_list'] = $this->db->get('lkp_country')->result_array();
		
		$this->db->select('*');
		$this->db->where('dimensions_status', 1);
		$result['lkp_dimensions_list'] = $this->db->get('lkp_dimensions')->result_array();
		$this->db->select('*');
		$this->db->where('status', 2);
		$this->db->where('id', $record_id);
		$result['lkp_form_data'] = $this->db->get('ic_form_data_a')->result_array();
		$result['record_id'] =$record_id;
		$result['indicator_id'] =$result['lkp_form_data'][0]['form_id'];
		$this->db->select('*');
		$this->db->where('county_status', 1);
		$this->db->where('country_id', $result['lkp_form_data'][0]['country_id']);
		$result['lkp_county_list'] = $this->db->get('lkp_county')->result_array();
		// print_r($result['lkp_form_data']);exit();

		//getting common lkp data from tables end upto here

		$this->load->view('common/header');
		$this->load->view('reporting/edit_data', $result);		
		$this->load->view('common/footer');
	}

	public function view_data(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$result= array();
		//getting common lkp data from tables start from here
		$this->db->select('*');
		$this->db->where('year_status', 1);
		$result['lkp_year_list'] = $this->db->get('lkp_year')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->order_by('slno');
		$result['lkp_country_list'] = $this->db->get('lkp_country')->result_array();
		$this->db->select('*');
		$this->db->where('county_status', 1);
		$result['lkp_county_list'] = $this->db->get('lkp_county')->result_array();
		$this->db->select('*');
		$this->db->where('dimensions_status', 1);
		$result['lkp_dimensions_list'] = $this->db->get('lkp_dimensions')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$result['lkp_user_list'] = $this->db->get('tbl_users')->row_array();
		if(isset($result['lkp_user_list']['country_id'])){
			$country_id=$result['lkp_user_list']['country_id'];
		}else{
			$country_id=1;
		}
		$result['country_id'] = $country_id;
		//getting common lkp data from tables end upto here

		$this->load->view('common/header');
		$this->load->view('reporting/view_data', $result);		
		$this->load->view('common/footer');
	}
	public function view_data_user(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$result= array();
		//getting common lkp data from tables start from here
		$this->db->select('*');
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$this->db->where('status', 1);
		$tbl_users = $this->db->get('tbl_users')->result_array();
		$this->db->select('*');
		$this->db->where('year_status', 1);
		$result['lkp_year_list'] = $this->db->get('lkp_year')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->order_by('slno');
		$result['lkp_country_list'] = $this->db->get('lkp_country')->result_array();
		$this->db->select('*');
		$this->db->where('county_status', 1);
		$result['lkp_county_list'] = $this->db->get('lkp_county')->result_array();

		$this->db->select('*');
		$this->db->where('dimensions_status', 1);
		$result['lkp_dimensions_list'] = $this->db->get('lkp_dimensions')->result_array();

		// $this->db->select('distinct(rfr.indicator_id), fd.actual_value, f.*');
		// $this->db->join('rpt_form_relation AS rfr', 'rfr.indicator_id = f.id');
		// $this->db->join('ic_form_data_a AS fd', 'fd.form_id = rfr.indicator_id');
		// $this->db->where('f.status', 1);
		// $this->db->where('fd.status', 2);
		// $this->db->where('rfr.lkp_country_id', $tbl_users[0]['country_id']);
		// $result['lkp_indicator_list'] = $this->db->get('form AS f')->result_array();
		// print_r($this->db->last_query());exit();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$result['lkp_user_list'] = $this->db->get('tbl_users')->row_array();
		if(isset($result['lkp_user_list']['country_id'])){
			$country_id=$result['lkp_user_list']['country_id'];
		}else{
			$country_id=1;
		}
		$result['country_id'] = $country_id;
		//getting common lkp data from tables end upto here

		$this->load->view('common/header');
		$this->load->view('reporting/view_data_user', $result);		
		$this->load->view('common/footer');
	}

	public function get_dimensions_user(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$measure_level = $this->input->post('measure_level');
		if(!empty($measure_level)){
		$this->db->select('distinct(rfr.lkp_dimension_id),dm.*');
		}else{
			$this->db->select('dm.*');
		}
		$this->db->where('dm.dimensions_status', 1);
		if(!empty($measure_level)){
			$this->db->join('rpt_form_relation as rfr','dm.dimensions_id = rfr.lkp_dimension_id');
			$this->db->where('rfr.lkp_level_measurement', $measure_level);
		}
		$result['lkp_dimensions_list'] = $this->db->get('lkp_dimensions as dm')->result_array();
		// $this->db->select('*');
		// $this->db->where('dimensions_status', 1);
		// $result['lkp_dimensions_list'] = $this->db->get('lkp_dimensions')->result_array();
		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}

	public function get_subdimensions_user(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$dimensions_id = $this->input->post('dimensions_id');
		$measure_level = $this->input->post('measure_level');
		if(!empty($measure_level)){
		$this->db->select('distinct(rfr.lkp_subdimension_id),sd.*');
		}else{
			$this->db->select('sd.*');
		}
		$this->db->where('sd.sub_dimensions_status', 1);
		$this->db->where('sd.dimensions_id', $dimensions_id);
		if(!empty($measure_level)){
			$this->db->join('rpt_form_relation as rfr','sd.sub_dimensions_id = rfr.lkp_subdimension_id');
			$this->db->where('rfr.lkp_level_measurement', $measure_level);
		}
		$result['lkp_sub_dimensions_list'] = $this->db->get('lkp_sub_dimensions as sd')->result_array();
		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}

	public function get_category_user(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$sub_dimensions_id = $this->input->post('sub_dimensions_id');
		$measure_level = $this->input->post('measure_level');
		if(!empty($measure_level)){
		$this->db->select('distinct(rfr.lkp_category_id),ct.*');
		}else{
			$this->db->select('ct.*');
		}
		$this->db->where('ct.categories_status', 1);
		$this->db->where('ct.sub_dimensions_id', $sub_dimensions_id);
		if(!empty($measure_level)){
			$this->db->join('rpt_form_relation as rfr','ct.categories_id = rfr.lkp_category_id');
			$this->db->where('rfr.lkp_level_measurement', $measure_level);
		}
		$result['lkp_categories_list'] = $this->db->get('lkp_categories as ct')->result_array();

		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}

	public function get_indicator_data_user(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$indicator_id = $this->input->post('indicator_id');
		$user_country = $this->input->post('user_country');
		$user_id = $this->session->userdata('login_id');

		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->where('user_id', $user_id);
		$result['lkp_users_list'] = $this->db->get('tbl_users')->result_array();

		$this->db->select('icd.*,y.year,ctr.country_name,cty.county_name');
		$this->db->join('lkp_year as y', 'icd.year_id = y.year_id');
		$this->db->join('lkp_country as ctr', 'icd.country_id = ctr.country_id');
		$this->db->join('lkp_county as cty', 'icd.county_id = cty.county_id');
		$this->db->join('rpt_form_relation as rpt', 'rpt.indicator_id = icd.form_id');
		if($this->session->userdata('role')==6){
			$this->db->where('icd.country_id', $user_country);
		}
		$this->db->where_in('icd.status', [2,3,4]);
		$this->db->where('icd.form_id', $indicator_id);
		$this->db->where('icd.country_id', $result['lkp_users_list'][0]['country_id']);
		$this->db->where('icd.county_id', $result['lkp_users_list'][0]['county_id']);
		$result['lkp_indicator_data_list'] = $this->db->get('ic_form_data_a as icd')->result_array();

		if($result['lkp_indicator_data_list']){
			foreach ($result['lkp_indicator_data_list'] as $key => $value) {
				$this->db->select('*');
				$this->db->where('status', 1);
				$this->db->where('data_id', $value['data_id']);
				$result['lkp_query_list'] = $this->db->get('ic_data_query')->result_array();
				$query_status=0;
				if($result['lkp_query_list']){
					$query_status=1;
				}
				// 
				$result['lkp_indicator_data_list'][$key]['query_status']= $query_status;
			}
				
		}


		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}

	public function verify_data(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$record_id = $this->uri->segment('3');
		$result= array();
		$this->db->select('*');
		$this->db->where('id', $record_id);
		$this->db->where_in('status', [2,3,0]);
		$result['data_list'] = $this->db->get('ic_form_data_a')->result_array();
		$data_id=$result['data_list'][0]['data_id'];

		//getting common lkp data from tables start from here
		if($result['data_list']){

			$this->db->select('year');
			$this->db->where('year_id', $result['data_list'][0]['year_id']);
			$this->db->where('year_status', 1);
			$lkp_year_list = $this->db->get('lkp_year')->result_array();
			$lkp_year_name =$lkp_year_list[0]['year'];
			
			$this->db->select('dimensions_name');
			$this->db->where('dimensions_id', $result['data_list'][0]['dimension_id']);
			$this->db->where('dimensions_status', 1);
			$lkp_dimensions_list = $this->db->get('lkp_dimensions')->result_array();
			$lkp_dimensions_name =$lkp_dimensions_list[0]['dimensions_name'];

			$this->db->select('sub_dimensions_name');
			$this->db->where('sub_dimensions_id', $result['data_list'][0]['sub_dimension_id']);
			$this->db->where('sub_dimensions_status', 1);
			$lkp_sub_dimensions_list = $this->db->get('lkp_sub_dimensions')->result_array();
			$lkp_sub_dimensions_name =$lkp_sub_dimensions_list[0]['sub_dimensions_name'];

			$this->db->select('categories_name');
			$this->db->where('categories_id', $result['data_list'][0]['category_id']);
			$this->db->where('categories_status', 1);
			$lkp_categories_list = $this->db->get('lkp_categories')->result_array();
			$lkp_categories_name =$lkp_categories_list[0]['categories_name'];

			$this->db->select('title');
			$this->db->where('id', $result['data_list'][0]['form_id']);
			$this->db->where('status', 1);
			$lkp_indicator_list = $this->db->get('form')->result_array();
			$lkp_indicator_name =$lkp_indicator_list[0]['title'];

			$this->db->select('country_name');
			$this->db->where('country_id', $result['data_list'][0]['country_id']);
			$this->db->where('status', 1);
			$lkp_country_list = $this->db->get('lkp_country')->result_array();
			$lkp_country_name =$lkp_country_list[0]['country_name'];

			$this->db->select('county_name');
			$this->db->where('county_id', $result['data_list'][0]['county_id']);
			$this->db->where('county_status', 1);
			$lkp_county_list = $this->db->get('lkp_county')->result_array();
			$lkp_county_name =$lkp_county_list[0]['county_name'];

			$lkp_acutal_value =$result['data_list'][0]['actual_value'];

			$this->db->select('tu.first_name, tu.last_name, idq.*');
			$this->db->join('tbl_users AS tu', 'tu.user_id = idq.sent_by');
			$this->db->where('idq.status', 1)->where('idq.data_id', $data_id);
			$queries = $this->db->get('ic_data_query AS idq')->result_array();
			
			

			// print_r($this->db->last_query());exit();
		}else{
			$lkp_year_name ="N/A";
			$lkp_dimensions_name ="N/A";
			$lkp_sub_dimensions_name ="N/A";
			$lkp_categories_name ="N/A";
			$lkp_indicator_name ="N/A";
			$lkp_country_name ="N/A";
			$lkp_county_name ="N/A";
			$lkp_acutal_value ="";
			$queries ="";
		}
		
		$result['lkp_year_name'] = $lkp_year_name;
		$result['lkp_dimensions_name'] = $lkp_dimensions_name;
		$result['lkp_sub_dimensions_name'] = $lkp_sub_dimensions_name;
		$result['lkp_categories_name'] = $lkp_categories_name;
		$result['lkp_indicator_name'] = $lkp_indicator_name;
		$result['lkp_country_name'] = $lkp_country_name;
		$result['lkp_county_name'] = $lkp_county_name;
		$result['lkp_acutal_value'] = $lkp_acutal_value;
		$result['queries'] = $queries;
		$result['record_id'] = $record_id;
		$result['data_id'] = $data_id;
		$user = $this->db->where('user_id', $this->session->userdata('login_id'))->get('tbl_users')->row_array();
		$result['first_name'] = $user['first_name'];
		$result['last_name'] = $user['last_name'];
		$result['role_id'] = $user['role_id'];
		
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$result['lkp_user_list'] = $this->db->get('tbl_users')->row_array();
		if(isset($result['lkp_user_list']['country_id'])){
			$country_id=$result['lkp_user_list']['country_id'];
		}else{
			$country_id=1;
		}
		$result['country_id'] = $country_id;
		
		// print_r($this->db->last_query());exit();
		//getting common lkp data from tables end upto here

		$this->load->view('common/header');
		$this->load->view('reporting/verify_data', $result);		
		$this->load->view('common/footer');
	}

	public function send_back(){
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
		$details = $this->db->where('data_id', $id)->get('ic_form_data_a')->row_array();

		// Insert query
		// $this->db->insert('ic_data_query', array(
		// 	'data_id' => $id,
		// 	'query' => $query,
		// 	'sent_by' => $this->session->userdata('login_id'),
		// 	'sent_to' => $details['user_id'],
		// 	'query_datetime' => date('Y-m-d H:i:s'),
		// 	'ip_address' => $this->input->ip_address(),
		// 	'status' => 1
		// ));
		$insertQuery =  array(
			'data_id' => $id,
			'query' => $query,
			'sent_by' => $this->session->userdata('login_id'),
			'sent_to' => $details['user_id'],
			'query_datetime' => date('Y-m-d H:i:s'),
			'ip_address' => $this->input->ip_address(),
			'status' => 1
		);
		$this->db->insert('ic_data_query', $insertQuery);

		$query_array = array(
			'query_status' => 1
		);
		$this->db->where('data_id', $id);
		$this->db->update('ic_form_data_a', $query_array);

		// $get_userid = $this->db->select('user_id, form_id, reg_date_time')->where('data_id', $id)->get('ic_form_data')->row_array();
		// $user_info = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where('user_id', $get_userid['user_id'])->get('tbl_users')->row_array();
		// $form_details = $this->db->where('id', $get_userid['form_id'])->get('form')->row_array();
		// $emaildetails = $this->db->where('status', 1)->get('emailconfiguration_details')->row_array();
		// if (ENVIRONMENT != 'development') {
		// 	$config = array(
		// 		'protocol' => 'smtp',
		// 		'smtp_host' => 'ssl://smtp.googlemail.com',
		// 		'smtp_port' => 465,
		// 		'smtp_user' => $emaildetails['email_id'], // change it to yours
		// 		'smtp_pass' => $emaildetails['password'], // change it to yours
		// 		'mailtype' => 'html',
		// 		'charset' => 'iso-8859-1',
		// 		'wordwrap' => TRUE
		// 	);

		// 	$subject = "Query received from" . $this->session->userdata('name');

		// 	$this->load->library('email', $config);
		// 	$this->email->set_newline("\r\n");
		// 	$this->email->from('mandeaticrisat@gmail.com', 'MPRO');
		// 	$this->email->to($user_info['email_id']);
		// 	$this->email->subject($subject);
		// 	$this->email->set_mailtype("html");
		// 	$this->email->message("Dear " . $user_info['first_name'] . " " . $user_info['last_name'] . " ,<br/><br/><b>" . $this->session->userdata('name') . "</b> has sent you a query regarding the data submitted by you for <b>" . $form_details['title'] . "</b> on " . $get_userid['reg_date_time'] . ".<br/><br/>Please visit the MPRO AVISA Reporting 2020 platform to view the query.<br/><br/>You can either respond to the query by providing an explanation or you can edit your data if required and submit again.<br/><br/>Regards,<br/>MPRO team");
		// 	if (!$this->email->send()) {
		// 		show_error($this->email->print_debugger());
		// 	}
		// }

		// Get user details
		$user = $this->db->where('user_id', $this->session->userdata('login_id'))->get('tbl_users')->row_array();
		$insertQuery['first_name'] = $user['first_name'];
		$insertQuery['last_name'] = $user['last_name'];

		echo json_encode(array(
			'status' => 1,
			'query' => $insertQuery,
			'msg' => 'Responded successfully.'
		));
		// echo json_encode(array(
		// 	'status' => 1,
		// 	'msg' => 'Data sent back to user with you query.'
		// ));
		exit();
	}
	public function respond_query()	{
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
				'msg' => '1Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}

		// Get data details
		$details = $this->db->where('data_id', $id)->get('ic_form_data_a');
		if ($details->num_rows() == 0) {
			echo json_encode(array(
				'status' => 0,
				'msg' => '2Some problem occured. Please refresh the page and try again.'
			));
			exit();
		}
		// print_r($this->db->last_query());exit();
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
			'sent_to' => $details['user_id'],
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
		$this->db->update('ic_form_data_a', $query_array);

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

	public function approve_data(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$time = time();
		$tablename="ic_form_data_a";
		$record_id = $this->input->post('record_id');
		$insert_array =array();
		$insert_array['status']=3;
		// print_r($user_id);exit();

		$query = $this->db->where('id', $record_id)->update($tablename, $insert_array);
		// print_r($this->db->last_query());exit();
		if($query){
			echo json_encode(array(
				'status' => 1,
				'msg' => 'Record Approved successfully.'
			));
		}else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
		}
		
		exit();
	}

	public function reject_data(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$time = time();
		$tablename="ic_form_data_a";
		$record_id = $this->input->post('record_id');
		$insert_array =array();
		$insert_array['status']=4;
		// print_r($user_id);exit();

		$query = $this->db->where('id', $record_id)->update($tablename, $insert_array);
		// print_r($this->db->last_query());exit();
		if($query){
			echo json_encode(array(
				'status' => 1,
				'msg' => 'Record Rejected successfully.'
			));
		}else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
		}
		
		exit();
	}

	public function user_management(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$result= array();
		//getting common lkp data from tables start from here
		// $this->db->select('*');
		// $this->db->where('status', 1);
		// $result['tbl_users_list'] = $this->db->get('tbl_users')->result_array();
		$this->db->select('*');
		$this->db->where('county_status', 1);
		$result['lkp_county_list'] = $this->db->get('lkp_county')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->order_by('slno');
		$result['lkp_country_list'] = $this->db->get('lkp_country')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$result['tbl_role_list'] = $this->db->get('tbl_role')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->where('user_id', $this->session->userdata('login_id'));
		$result['lkp_user_list'] = $this->db->get('tbl_users')->row_array();

		$this->db->select('tu.*,ctry.country_name,cty.county_name');
		$this->db->join('lkp_country as ctry', 'tu.country_id = ctry.country_id' ,'left');
		$this->db->join('lkp_county as cty', 'tu.county_id = cty.county_id' ,'left');
		$this->db->where('tu.status', 1);
		$this->db->where('tu.role_id !=', 1);
		if($this->session->userdata('role') ==6){
			$this->db->where('tu.role_id ', 5);
			$this->db->where('tu.country_id', $result['lkp_user_list']['country_id']);
		}
		$result['tbl_users_list'] = $this->db->get('tbl_users as tu')->result_array();
		// print_r($this->db->last_query());exit();

		$this->load->view('common/header');
		$this->load->view('reporting/user_management', $result);		
		$this->load->view('common/footer');
	}

	public function user_mapping(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$result= array();
		$user_id = $this->uri->segment('3');
		$role_id = $this->uri->segment('4');
		$user_name = $this->uri->segment('5');
		
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->order_by('slno');
		$result['lkp_country_list'] = $this->db->get('lkp_country')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->where('role_id', $role_id);
		$result['tbl_role_list'] = $this->db->get('tbl_role')->row_array();
		
		$result['user_id'] = $user_id;
		$result['role_id'] = $role_id;
		$result['user_name'] = $user_name;
		$result['role_name'] = $result['tbl_role_list']['role_description'];

		$this->db->select('tu.*');
		$this->db->where('tu.status', 1);
		$this->db->where('tu.user_id', $user_id);
		$result['tbl_users_list'] = $this->db->get('tbl_users as tu')->row_array();

		$this->db->select('tu.*');
		$this->db->where('tu.status', 1);
		$this->db->where('tu.user_id', $this->session->userdata('login_id'));
		$result['tbl_login_user'] = $this->db->get('tbl_users as tu')->row_array();
		// print_r($result['tbl_login_user']['role_id']);exit();
		$this->load->view('common/header');
		$this->load->view('reporting/user_mapping', $result);		
		$this->load->view('common/footer');
	}

	public function update_user_country(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$time = time();
		$tablename="tbl_users";
		$user_id = $this->input->post('user_id');
		$country_id = $this->input->post('country_id');
		$county_id = $this->input->post('county_id');
		$insert_array =array();
		$insert_array['country_id']=$country_id;
		$insert_array['county_id']=$county_id;
		// print_r($insert_array);exit();

		$query = $this->db->where('user_id', $user_id)->update($tablename, $insert_array);
		// print_r($this->db->last_query());exit();
		if($query){
			echo json_encode(array(
				'status' => 1,
				'msg' => 'Submitted successfully.'
			));
			$this->user_management();
		}else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
		}
		
		exit();
	}

	public function get_user_data_popup_modal(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$user_id = $this->input->post('user_id');
		// print_r($user_id);exit();

		$this->db->select('tu.*,ctry.country_name,cty.county_name');
		$this->db->join('lkp_country as ctry','ctry.country_id = tu.country_id');
		$this->db->join('lkp_county as cty','cty.county_id = tu.county_id');
		$this->db->where('tu.status', 1);
		$this->db->where('tu.user_id', $user_id);
		$result['user_data_list'] = $this->db->get('tbl_users as tu')->result_array();
		// print_r($this->db->last_query());exit();
		if($user_id){
			echo json_encode(array(
				'status' => 1,
				'result' => $result,
				'msg' => 'Got data successfully.'
			));
			$this->user_management();
		}else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
		}
		
		exit();
	}

	public function common_dashboard(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$result= array();
		
		$this->load->view('common/header');
		$this->load->view('reporting/common_dashboard', $result);		
		$this->load->view('common/footer');
	}

	public function common_comparisons(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$result= array();
		
		$this->load->view('common/header');
		$this->load->view('reporting/common_comparisons', $result);		
		$this->load->view('common/footer');
	}

	public function get_countys(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$country_id = $this->input->post('country_id');
		$role_id = $this->input->post('role_id');
		$this->db->select('tu.*');
		$this->db->where('tu.status', 1);
		$this->db->where('tu.user_id', $this->session->userdata('login_id'));
		$tbl_login_user = $this->db->get('tbl_users as tu')->row_array();
		$this->db->select('*');
		$this->db->where('county_status', 1);
		$this->db->where('country_id', $country_id);
		if(isset($tbl_login_user['county_id']) && $this->session->userdata('role')==5){
			$this->db->where('county_id', $tbl_login_user['county_id']);
		}
		$this->db->order_by('county_name');
		$result['lkp_county_list'] = $this->db->get('lkp_county')->result_array();
		// print_r($this->db->last_query());exit();
		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}
	
	

	public function get_subdimensions(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$dimensions_id = $this->input->post('dimensions_id');
		$this->db->select('sd.*');
		$this->db->where('sd.sub_dimensions_status', 1);
		$this->db->where('sd.dimensions_id', $dimensions_id);
		$result['lkp_sub_dimensions_list'] = $this->db->get('lkp_sub_dimensions as sd')->result_array();
		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}

	public function upload_get_dimensions(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$measure_level = $this->input->post('measure_level');
		if(!empty($measure_level)){
		$this->db->select('distinct(rfr.lkp_dimension_id),dm.*');
		}else{
			$this->db->select('dm.*');
		}
		$this->db->where('dm.dimensions_status', 1);
		if(!empty($measure_level)){
			$this->db->join('rpt_form_relation as rfr','dm.dimensions_id = rfr.lkp_dimension_id');
			$this->db->where('rfr.lkp_level_measurement', $measure_level);
		}
		$result['lkp_dimensions_list'] = $this->db->get('lkp_dimensions as dm')->result_array();
		// $this->db->select('*');
		// $this->db->where('dimensions_status', 1);
		// $result['lkp_dimensions_list'] = $this->db->get('lkp_dimensions')->result_array();
		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}

	public function upload_get_subdimensions(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$dimensions_id = $this->input->post('dimensions_id');
		$measure_level = $this->input->post('measure_level');
		if(!empty($measure_level)){
		$this->db->select('distinct(rfr.lkp_subdimension_id),sd.*');
		}else{
			$this->db->select('sd.*');
		}
		$this->db->where('sd.sub_dimensions_status', 1);
		$this->db->where('sd.dimensions_id', $dimensions_id);
		if(!empty($measure_level)){
			$this->db->join('rpt_form_relation as rfr','sd.sub_dimensions_id = rfr.lkp_subdimension_id');
			$this->db->where('rfr.lkp_level_measurement', $measure_level);
		}
		$result['lkp_sub_dimensions_list'] = $this->db->get('lkp_sub_dimensions as sd')->result_array();
		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}

	public function upload_get_category(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$sub_dimensions_id = $this->input->post('sub_dimensions_id');
		$measure_level = $this->input->post('measure_level');
		if(!empty($measure_level)){
		$this->db->select('distinct(rfr.lkp_category_id),ct.*');
		}else{
			$this->db->select('ct.*');
		}
		$this->db->where('ct.categories_status', 1);
		$this->db->where('ct.sub_dimensions_id', $sub_dimensions_id);
		if(!empty($measure_level)){
			$this->db->join('rpt_form_relation as rfr','ct.categories_id = rfr.lkp_category_id');
			$this->db->where('rfr.lkp_level_measurement', $measure_level);
		}
		$result['lkp_categories_list'] = $this->db->get('lkp_categories as ct')->result_array();

		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}
	public function get_category(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$sub_dimensions_id = $this->input->post('sub_dimensions_id');
		$this->db->select('*');
		$this->db->where('categories_status', 1);
		$this->db->where('sub_dimensions_id', $sub_dimensions_id);
		$result['lkp_categories_list'] = $this->db->get('lkp_categories')->result_array();

		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}

	public function get_indicators(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$category_id = $this->input->post('category_id');
		$measure_level_id = $this->input->post('measure_level_id');
		$this->db->select('*');
		$this->db->where('relation_status', 1);
		$this->db->where('lkp_category_id', $category_id);
		if($measure_level_id >0){
			$this->db->where('lkp_level_measurement', $measure_level_id);
		}
		$result['lkp_indicators_list'] = $this->db->get('rpt_form_relation')->result_array();

		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}

	public function get_indicators_list(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$measure_level_id = 0;
		$measure_level_id = $this->input->post('measure_level_id');
		$this->db->select('*');
		$this->db->where('relation_status', 1);
		if($measure_level_id >0){
			$this->db->where('lkp_level_measurement', $measure_level_id);
		}
		$result['lkp_indicators_list'] = $this->db->get('rpt_form_relation')->result_array();

		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}

	public function get_indicators_details(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$indicator_id = $this->input->post('indicator_id');
		$measure_level = $this->input->post('measure_level');
		$year = $this->input->post('year_id');
		$country_id = $this->input->post('country_id');
		$county_id = $this->input->post('county_id');
		// $this->db->select('*');
		// $this->db->where_in('query_status', [2,3]);
		// $this->db->where('form_id', $indicator_id);
		// $result['lkp_indicator_data_list'] = $this->db->get('ic_form_data_a')->result_array();

		$this->db->select('rfr.*,f.title,f.description,d.dimensions_name,d.dimensions_id,sd.sub_dimensions_name,sd.sub_dimensions_id,ct.categories_name,ct.categories_id,lmu.m_unit_name');
		$this->db->join('lkp_dimensions as d', 'rfr.lkp_dimension_id = d.dimensions_id');
		$this->db->join('lkp_sub_dimensions as sd', 'rfr.lkp_subdimension_id = sd.sub_dimensions_id');
		$this->db->join('lkp_categories as ct', 'rfr.lkp_category_id = ct.categories_id');
		$this->db->join('lkp_m_units as lmu', 'rfr.lkp_measurement_unit = lmu.m_unit_id');
		$this->db->join('form as f', 'rfr.indicator_id = f.id');
		$this->db->where('rfr.relation_status', 1);
		$this->db->where('rfr.indicator_id', $indicator_id);
		$result['lkp_indicator_data_list'] = $this->db->get('rpt_form_relation as rfr')->result_array();
		// print_r($result['lkp_indicator_data_list'][0]['categories_id']);exit();
		$status=0;
		$this->db->select('ifd.*,idf.file_name');
		$this->db->join('ic_data_file as idf', 'ifd.data_id = idf.data_id');
		$this->db->where('ifd.form_id', $indicator_id);
		$this->db->where('ifd.measurement_level', $measure_level);
		$this->db->where('ifd.year_id', $year);
		$this->db->where('ifd.country_id', $country_id);
		$this->db->where('ifd.county_id', $county_id);
		$this->db->where_in('ifd.status', [1,2]);
		$ic_form_data_a = $this->db->get('ic_form_data_a as ifd')->result_array();
		// print_r($this->db->last_query());exit();
		foreach ($ic_form_data_a as $key => $data) {
			$result['actual_value']=$data['actual_value'];
			$result['ds_file_name']=$data['file_name'];
			$result['data_source']=$data['data_source'];
			$result['remarks']=$data['remarks'];
			$status=1;
		}
		if($status==0){
			$result['actual_value']="";
			$result['data_source']="";
			$result['remarks']="";
		}
		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}

	public function insert_indicatordata(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$measure_level_id = $this->input->post('measure_level');
		$time = time();
		$tablename="ic_form_data_a";
		$actual_val=0;
		$datetime = date('Y-m-d H:i:s');
		$indicator_id = $this->input->post('indicator_id');
		$year_val = $this->input->post('year_val');
		$country_val = $this->input->post('country_val');
		$county_val = $this->input->post('county_val');
		$dimension_val = $this->input->post('dimension_val');
		$subdimension_val = $this->input->post('subdimension_val');
		$category_val = $this->input->post('category_val');
		$actual_val = $this->input->post('actual_val');
		$data_source = $this->input->post('data_source');
		$data_sets = $this->input->post('data_sets');
		$remarks = $this->input->post('remarks');
		$insert_array =array();
		$insert_array['data_id'] = $time.'-'.$this->session->userdata('login_id');
		$insert_array['form_id']=$indicator_id;
		$insert_array['measurement_level']=$measure_level_id;
		$insert_array['year_id']=$year_val;
		$insert_array['country_id']=$country_val;
		$insert_array['county_id']=$county_val;
		$insert_array['dimension_id']=$dimension_val;
		$insert_array['sub_dimension_id']=$subdimension_val;
		$insert_array['category_id']=$category_val;
		$insert_array['actual_value']=$actual_val;
		$insert_array['data_source']=$data_source;
		$insert_array['data_sets']=$data_sets;
		$insert_array['remarks']=$remarks;
		$insert_array['reg_date_time']=$datetime;
		$insert_array['user_id']=$this->session->userdata('login_id');
		$record_status =0;
		$this->db->select('*');
		$this->db->where_in('form_id', $indicator_id);
		$this->db->where_in('year_id', $year_val);
		$this->db->where_in('country_id', $country_val);
		$this->db->where_in('county_id', $county_val);
		$this->db->where_in('status', [1,2,3,4]);
		$ic_form_data_a_rset = $this->db->get('ic_form_data_a')->result_array();
		foreach ($ic_form_data_a_rset as $key => $rdata) {
			//get existing record details
			$record_status =$rdata['status'];
			$insert_array['data_id']=$rdata['data_id'];
			$record_id=$rdata['id'];
		}
		if($record_status==2 || $record_status==3){
			//if record already exists update record
			//if already records exists updated record
			$surv_update_data =array();
			$surv_update_data['measurement_level']=$measure_level_id;
			$surv_update_data['actual_value']=$actual_val;
			$surv_update_data['data_source']=$data_source;
			$surv_update_data['data_sets']=$data_sets;
			$surv_update_data['remarks']=$remarks;
			$surv_update_data['reg_date_time']=$datetime;
			// $query = $this->db->where('data_id', $insert_array['data_id'])->update('ic_form_data_a', $surv_update_data);
			$query = $this->db->where('id', $record_id)->update('ic_form_data_a', $surv_update_data);
		}
		if($record_status==0){
			//new record insert
			if($this->session->userdata('role')==1){
				$insert_array['status']=3;  // For Admin submited record auto approval
			}else{
				$insert_array['status']=2; // for tother users submited only
			}

			$query = $this->db->insert($tablename, $insert_array);
		}

		if($query){
			//Insert uploaded data source  files in db	and server				
			if(isset($_FILES['data_sets'])) {
				// foreach ($_FILES['data_sets']['name'] as $key => $si) {
					if($_FILES['data_sets']['size'] > 0) {
						//Upload Image
						
						$file_name = $_FILES['data_sets']['name'];
						$ext = pathinfo($file_name, PATHINFO_EXTENSION);
						// $file = $file_name;
						$file = uniqid().$key.$this->session->userdata('login_id').'.'.$ext;
						// print_r("I am called");
						// print_r($file);
						// exit();
						$path_parts = pathinfo($_FILES['data_sets']['name']);
						$extension = $path_parts['extension'];
						$file_type="image";
						if($extension=='pdf'|| $extension=='docx'|| $extension=='doc'){
							$file_type="document";
						}else{
							$file_type="image";
						}
						$file_size = $_FILES['data_sets']['size'];

						if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'upload/survey/');
						$imgurl = UPLOAD_DIR . $file;

						$filename = $_FILES["data_sets"]["tmp_name"];
						$file_directory = "upload/survey/";
						if($filename) {
							if(move_uploaded_file($filename, $file_directory . $file)){
								$this->db->select('data_id');
								$this->db->where('data_id', $insert_array['data_id'])->where('status', 1);
								$check_record = $this->db->get('ic_data_file')->row_array();
								 if(isset($check_record['data_id'])){
									$surv_image_data = array(
										'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
										'form_id' => $indicator_id,
										'user_id' => $this->session->userdata('login_id'),
										'file_name' => $file,
										'file_type' => $file_type,
										'created_date' => $datetime,
										'ip_address' => $this->input->ip_address(),
										'status' => 1
									);
									$this->db->where('data_id', $insert_array['data_id'])->update('ic_data_file', $surv_image_data);

								 }else{
									$surv_image_data = array(
										'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
										'data_id' => $insert_array['data_id'],
										'form_id' => $indicator_id,
										'user_id' => $this->session->userdata('login_id'),
										'file_name' => $file,
										'file_type' => $file_type,
										'created_date' => $datetime,
										'ip_address' => $this->input->ip_address(),
										'status' => 1
									);
									$this->db->insert('ic_data_file', $surv_image_data);
								}
							}
						}
					}
				// }
			}
			echo json_encode(array(
				'status' => 1,
				'msg' => 'Submitted successfully.'
			));
		}else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
		}
		exit();
	}

	public function update_indicatordata(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$time = time();
		$tablename="ic_form_data_a";
		$record_id = $this->input->post('record_id');
		$indicator_id = $this->input->post('indicator_id');
		$year_val = $this->input->post('year_val');
		$country_val = $this->input->post('country_val');
		$county_val = $this->input->post('county_val');
		$dimension_val = $this->input->post('dimension_val');
		$subdimension_val = $this->input->post('subdimension_val');
		$category_val = $this->input->post('category_val');
		$actual_val = $this->input->post('actual_val');
		$insert_array =array();
		$insert_array['data_id'] = $time.'-'.$this->session->userdata('login_id');
		$insert_array['form_id']=$indicator_id;
		$insert_array['year_id']=$year_val;
		$insert_array['country_id']=$country_val;
		$insert_array['county_id']=$county_val;
		$insert_array['dimension_id']=$dimension_val;
		$insert_array['sub_dimension_id']=$subdimension_val;
		$insert_array['category_id']=$category_val;
		$insert_array['actual_value']=$actual_val;
		$insert_array['user_id']=$this->session->userdata('login_id');
		$insert_array['status']=2;
		// print_r($insert_array);exit();

		$query = $this->db->where('id', $record_id)->update($tablename, $insert_array);
		// print_r($this->db->last_query());exit();
		if($query){
			echo json_encode(array(
				'status' => 1,
				'msg' => 'Submitted successfully.'
			));
		}else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
		}
		
		exit();
	}

	public function get_indicator_data(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$indicator_id = $this->input->post('indicator_id');
		$user_country = $this->input->post('user_country');
		// $this->db->select('*');
		// $this->db->where_in('query_status', [2,3]);
		// $this->db->where('form_id', $indicator_id);
		// $result['lkp_indicator_data_list'] = $this->db->get('ic_form_data_a')->result_array();

		$this->db->select('icd.*,y.year,ctr.country_name,cty.county_name');
		$this->db->join('lkp_year as y', 'icd.year_id = y.year_id');
		$this->db->join('lkp_country as ctr', 'icd.country_id = ctr.country_id');
		$this->db->join('lkp_county as cty', 'icd.county_id = cty.county_id');
		if($this->session->userdata('role')==6){
			$this->db->where('icd.country_id', $user_country);
		}
		$this->db->where_in('icd.status', [2,3,4]);
		$this->db->where('icd.form_id', $indicator_id);
		$result['lkp_indicator_data_list'] = $this->db->get('ic_form_data_a as icd')->result_array();

		echo json_encode(array(
			'status' => 1,
			'result' => $result
		));
		exit();
	}

	public function replace_indicatordata_csv(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}
		$result = array();
		$indicator_id = $this->input->post('indicator_id');
		$user_country = $this->input->post('user_country');
		$this->db->select('icd.*,y.year,ctr.country_name,cty.county_name');
		$this->db->join('lkp_year as y', 'icd.year_id = y.year_id');
		$this->db->join('lkp_country as ctr', 'icd.country_id = ctr.country_id');
		$this->db->join('lkp_county as cty', 'icd.county_id = cty.county_id');
		
		$this->db->where_in('icd.status', [2,3,4]);
		$indicator_data_list = $this->db->get('ic_form_data_a as icd')->result_array();
		if ($indicator_data_list.length() >0) {
			$delimiter = ","; 
			$filename = "members-data_" . date('Y-m-d') . ".csv"; 
			
			// Create a file pointer 
			$f = fopen('php://memory', 'w'); 
			
			// Set column headers 
			$fields = array('ID', 'FIRST NAME', 'LAST NAME', 'EMAIL', 'GENDER', 'COUNTRY', 'CREATED', 'STATUS'); 
			fputcsv($f, $fields, $delimiter); 
			
			// Output each row of the data, format line as csv and write to file pointer 
			while($row = $query->fetch_assoc()){ 
				$status = ($row['status'] == 1)?'Active':'Inactive'; 
				$lineData = array($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['gender'], $row['country'], $row['created'], $status); 
				fputcsv($f, $lineData, $delimiter); 
			} 
			
			// Move back to beginning of file 
			fseek($f, 0); 
			
			// Set headers to download file rather than displayed 
			header('Content-Type: text/csv'); 
			header('Content-Disposition: attachment; filename="' . $filename . '";'); 
		}
	}
	public function edit_data1(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$form_id = $this->uri->segment('3');

		$year_id = $this->uri->segment('4');
		$record_id = $this->uri->segment('5');
		/*$country_id = $this->uri->segment('5');
		$crop_id = $this->uri->segment('6');*/

		if($form_id == '' || $year_id == ''){
			show_404();
		}

		$form_details = $this->db->select('id, title, type')->where('id', $form_id)->where('status', 1)->get('form')->row_array();
		/*$crop_name = $this->db->select('*')->where('crop_id', $crop_id)->where('crop_status', 1)->get('lkp_crop')->row_array();
		$country_name = $this->db->select('*')->where('country_id', $country_id)->where('status', 1)->get('lkp_country')->row_array();*/
		$year_name = $this->db->select('*')->where('year_id', $year_id)->where('year_status', 1)->get('lkp_year')->row_array();
		$form_field_count = $this->db->where('form_id', $form_id)->where('status', 1)->get('form_field')->num_rows();
		
		if($form_field_count == 0 || $form_details == NULL){
			show_404();
		}
		$sdg_ids =0;
		$this->db->select('*');
		$record_data = $this->db->where('id', $record_id)->where('form_id', $form_id)->get('ic_form_data')->result_array();
		foreach ($record_data as $recordkey => $record_data_value) {
			// get record data
			$survey_data = json_decode($record_data_value['form_data'], true);
			$sdg_ids = $record_data_value['sdg_id'];
			$sdg_sub_ids = $record_data_value['sdg_sub_id'];
			$data_id=$record_data_value['data_id'];
		}
		// print_r($survey_data);exit();
		$this->db->select('*');
		$this->db->where('form_id', $form_id)->where_not_in('type', ['group','uploadgroupdata_excel'])->where('parent_id IS NULL')->where('parent_value IS NULL');
		$this->db->order_by('slno')->where('status', 1);
		$indicator_fields = $this->db->get('form_field')->result_array();
		foreach ($indicator_fields as $ifkey => $indicatorfield) {
			switch ($indicatorfield['type']) {
				case 'select':
				case 'radio-group':
				case 'checkbox-group':
				case 'number':
				case 'uploadgroupdata_excel':
					$this->db->select('*');
					$this->db->where('field_id', $indicatorfield['field_id']);
					$this->db->where('status', 1);
					$this->db->order_by('options_order');
					$indicator_fields[$ifkey]['options'] = $this->db->get('form_field_multiple')->result_array();

					$this->db->where('parent_id', $indicatorfield['field_id'])->where('status', 1);
					$icheck_child_fields = $this->db->get('form_field')->num_rows();

					$indicator_fields[$ifkey]['child_count']  = $icheck_child_fields;
					break;

				case 'lkp_year':
					$this->db->select('year_id, year');
					$this->db->order_by('year_id');
					$options = $this->db->where('year_status', 1)->get('lkp_year')->result_array();
					$indicator_fields[$ifkey]['options'] = $options;
					break;

				case 'lkp_rperiod':
					$this->db->select('rperiod_id, rperiod_name');
					$this->db->order_by('rperiod_name');
					$options = $this->db->where('rperiod_status', 1)->get('lkp_rperiod')->result_array();
					$indicator_fields[$ifkey]['options'] = $options;
					break;

				case 'lkp_country':
					$this->db->select('country_id, country_name,country_code');
					$this->db->order_by('slno');
					$options = $this->db->where('status', 1)->get('lkp_country')->result_array();
					$indicator_fields[$ifkey]['options'] = $options;
					break;

				case 'lkp_crop':
					$this->db->select('crop_id, crop_name, crop_description');
					// $this->db->order_by('crop_name');
					$options = $this->db->where('crop_status', 1)->get('lkp_crop')->result_array();
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
					
				case 'lkp_cluster':
					$this->db->select('*');
					$this->db->where('cluster_status', 1);
					// $this->db->order_by('trait2_id');
					$indicator_fields[$ifkey]['options'] = $this->db->get('tbl_cluster')->result_array();

					$this->db->where('parent_id', $indicatorfield['field_id'])->where('status', 1);
					$icheck_child_fields = $this->db->get('form_field')->num_rows();

					$indicator_fields[$ifkey]['child_count']  = $icheck_child_fields;
					break;
				
				case 'group':
					$this->db->where('parent_id', $indicatorfield['field_id'])->where('parent_value IS NULL')->where('status', 1);
					$this->db->order_by('slno');
					$survey_groupfields = $this->db->get('form_field')->result_array();

					foreach ($survey_groupfields as $gkey => $field) {
						switch ($field['type']) {
							case 'select':
							case 'radio-group':
							case 'checkbox-group':
								$this->db->select('*');
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
		$file_list_array = array();
		$this->db->select('*');
		$this->db->where('data_id', $data_id)->where('status', 1);
		$file_list_array = $this->db->get('ic_data_file')->result_array();

		$result = array('indicator_fields' => $indicator_fields, 'form_details' => $form_details, /*'country_name' => $country_name['country_name'], 'crop_name' => $crop_name['crop_name'],*/ 'year_name' => $year_name['year']);

		$result['formtype'] = '';
		$result['survey_data'] = $survey_data;
		$result['sdg_ids'] = $sdg_ids;
		$result['sdg_sub_ids'] = $sdg_sub_ids;
		$result['file_list_array'] = $file_list_array;
		
		$this->db->select('GROUP_CONCAT(form_id) as lkp_cluster_id');
		$this->db->where('lkp_year', $year_id)->where('lkp_cluster_id IS NULL');
		$this->db->where('relation_status', 1);
		$get_cluster_ids = $this->db->get('rpt_form_relation')->row_array();

		$cluster_ids_array = explode(",", $get_cluster_ids['lkp_cluster_id']);

		$user_role = $this->session->userdata('role');
		
		if(in_array($form_id, $cluster_ids_array)){
			$this->db->select('GROUP_CONCAT(form_id) as indicator_ids');
			$this->db->where('lkp_year', $year_id)->where('indicator_id IS NULL');
			$this->db->where('relation_status', 1)->where('lkp_cluster_id', $form_id);
			$get_output_indicators = $this->db->get('rpt_form_relation')->row_array();

			$indicator_ids_array = explode(",", $get_output_indicators['indicator_ids']);

			$indicator_data = array();
			foreach ($indicator_ids_array as $key => $indicator_id) {
				$data = array(
					'form_id' => $indicator_id,
					'year_id' => $year_id
				);
				$indicator_data[$key]['indicator_info'] = $this->Reporting_model->form_complete_info($data);

				$this->db->select('form_id');
				$this->db->where('relation_status', 1)->where('lkp_year', $year_id);
				$this->db->where('indicator_id', $indicator_id);
				$sub_indicators = $this->db->get('rpt_form_relation')->result_array();

				if(count($sub_indicators) == 0){
					$indicator_data[$key]['sub_indicators_count'] = count($sub_indicators);
					$indicator_data[$key]['sub_indicators_info'] = array();
				}else{
					$sub_indicator_data = array();
					foreach ($sub_indicators as $s_key => $subindicator_id) {
						$data = array(
							'form_id' => $subindicator_id['form_id'],
							'year_id' => $year_id
						);
						$sub_indicator_data[$s_key]['indicator_info'] = $this->Reporting_model->form_complete_info($data);
					}

					$indicator_data[$key]['sub_indicators_count'] = count($sub_indicators);
					$indicator_data[$key]['sub_indicators_info'] = $sub_indicator_data;
				}
			}

			$result['indicator_data'] = $indicator_data;
			$result['formtype'] = 'output';
		}

		$this->db->where('status', 2)->where('form_id', $form_id);
		/*$this->db->where('year_id', $year_id)->where('country_id', $country_id)->where('crop_id', $crop_id)->where('user_id', $this->session->userdata('login_id'))->where('nothingto_report', 1);*/
		$this->db->where('user_id', $this->session->userdata('login_id'))->where('nothingto_report', 1);
		$result['nothingto_report'] = $this->db->get('ic_form_data')->num_rows();

		//getting common lkp data from tables start from here
		$this->db->select('*');
		$this->db->where('year_status', 1);
		$result['lkp_year_list'] = $this->db->get('lkp_year')->result_array();
		$this->db->select('*');
		$this->db->where('status', 1);
		$this->db->order_by('slno');
		$result['lkp_country_list'] = $this->db->get('lkp_country')->result_array();
		$this->db->select('*');
		$this->db->where('rperiod_status', 1);
		$result['lkp_rperiod_list'] = $this->db->get('lkp_rperiod')->result_array();
		$this->db->select('*');
		$this->db->where('crop_status', 1);
		$result['lkp_crop_list'] = $this->db->get('lkp_crop')->result_array();
		$this->db->select('*');
		$this->db->where('sdg_status', 1);
		$this->db->order_by('slno');
		$result['lkp_sdg'] = $this->db->get('lkp_sdg')->result_array();
		$this->db->select('*');
		$this->db->where('sdg_sub_status', 1);
		$result['lkp_sdg_sub'] = $this->db->get('lkp_sdg_sub')->result_array();
		//getting common lkp data from tables end upto here
		$this->load->view('common/header');
		if($result['formtype'] == 'output'){
			// $this->load->view('reporting/outputdata_submission', $result);
			$this->load->view('reporting/online_data_edit', $result);
		}else{
			$this->load->view('reporting/online_data_edit', $result);
		}	
		// $this->load->view('reporting/online_data_edit'	);	
		$this->load->view('common/footer');
	}

	public function check_childfields(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
			exit();
		}

		$field_id = $this->input->post('field_id');
		$year_val = $this->input->post('year_val');
		$field_value = $this->input->post('field_value');

		$form_id = $this->input->post('form_id');

		if(is_array($field_value)){
			//commented for multiple selected values get multiple value childs list
			// foreach ($field_value as $key => $value) {
			// 	if($value =="N/A"){

			// 	}else{
					$this->db->where('parent_id', $field_id);
					// $this->db->like('parent_value', $value);
					$this->db->where_in('parent_value', $field_value);
					$this->db->where('form_id', $form_id);
					$this->db->like('year', $year_val);
					$get_child_fields = $this->db->where('status', 1)->order_by('slno')->get('form_field')->result_array();
					
					foreach ($get_child_fields as $ckey => $child) {

						switch ($child['type']) {
							case 'select':
							case 'radio-group':
							case 'checkbox-group':
								$this->db->select('label, value');
								$this->db->where('field_id', $child['field_id'])->where('status', 1)->order_by('options_order');
								$this->db->like('year', $year_val);
								$get_child_fields[$ckey]['options'] = $this->db->get('form_field_multiple')->result_array();

								$this->db->where('parent_id', $child['field_id'])->where('status', 1);
								// $this->db->like('year', $year_val);
								$check_child_fields = $this->db->get('form_field')->num_rows();

								$get_child_fields[$ckey]['child_count']  = $check_child_fields;
								break;

							case 'lkp_trait':
								$this->db->select('*');
								$this->db->where('trait_status', 1);
								// $this->db->order_by('trait_id');
								$get_child_fields[$ckey]['options'] = $this->db->get('lkp_trait')->result_array();

								$this->db->where('parent_id', $child['field_id'])->where('status', 1);
								// $this->db->like('year', $year_val);
								$check_child_fields = $this->db->get('form_field')->num_rows();

								$get_child_fields[$ckey]['child_count']  = $check_child_fields;
								break;

							case 'lkp_trait2':
								$this->db->select('*');
								$this->db->where('trait2_status', 1);
								// $this->db->order_by('trait2_id');
								$get_child_fields[$ckey]['options'] = $this->db->get('lkp_trait2')->result_array();
								
								$this->db->where('parent_id', $child['field_id'])->where('status', 1);
								// $this->db->like('year', $year_val);
								$check_child_fields = $this->db->get('form_field')->num_rows();

								$get_child_fields[$ckey]['child_count']  = $check_child_fields;
								break;

							case 'lkp_country':
								$this->db->select('country_id, country_name,country_code');
								$this->db->order_by('slno');
								$options = $this->db->where('status', 1)->get('lkp_country')->result_array();
								$get_child_fields[$ckey]['options'] = $options;
								
								$this->db->where('parent_id', $child['field_id'])->where('status', 1);
								$this->db->like('year', $year_val);
								$check_child_fields = $this->db->get('form_field')->num_rows();
		
								$get_child_fields[$ckey]['child_count']  = $check_child_fields;
								break;

							case 'lkp_headquarter':
								$this->db->select('*');
								$this->db->where('headquarter_status', 1);
								// $this->db->order_by('trait2_id');
								$get_child_fields[$ckey]['options'] = $this->db->get('lkp_headquarter')->result_array();
								
								$this->db->where('parent_id', $child['field_id'])->where('status', 1);
								// $this->db->like('year', $year_val);
								$check_child_fields = $this->db->get('form_field')->num_rows();

								$get_child_fields[$ckey]['child_count']  = $check_child_fields;
								break;

							case 'group':
								$this->db->where('parent_id', $child['field_id'])->where('parent_value', NULL)->where('status', 1)->order_by('slno');
								$this->db->like('year', $year_val);
								$survey_groupfields = $this->db->get('form_field')->result_array();
								foreach ($survey_groupfields as $gkey => $field) {
									switch ($field['type']) {
										case 'select':
										case 'radio-group':
										case 'checkbox-group':
											$this->db->select('label');
											$this->db->where('field_id', $field['field_id'])->where('status', 1)->order_by('options_order');
											$this->db->like('year', $year_val);
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
										case 'lkp_headquarter':
											$this->db->select('*');
											$this->db->where('headquarter_status', 1);
											// $this->db->order_by('headquarter_id');
											$survey_groupfields[$gkey]['options'] = $this->db->get('lkp_headquarter')->result_array();
											break;
									}

									$this->db->where('parent_id', $field['field_id'])->where('status', 1);
									$this->db->like('year', $year_val);
									$check_child_fields = $this->db->get('form_field')->num_rows();

									$survey_groupfields[$gkey]['child_count']  = $check_child_fields;
								}

								$get_child_fields[$ckey]['groupfields'] = $survey_groupfields;
								break;
						}					

						$option_vals = explode(",", $child['parent_value']);

						// if(!in_array($value, $option_vals)){
						// 	unset($get_child_fields[$ckey]);
						// }	
					}
			// 	}
			// }

			$get_child_fields = array_values($get_child_fields);
			if(count($get_child_fields)>0){
				$result = array('status' => 1, 'child_field' => $get_child_fields);
			}else{
				$result = array('status' => 0, 'child_field' => $get_child_fields);
			}
		}else{
			$this->db->where('parent_id', $field_id)->where('status', 1);
			$this->db->where('form_id', $form_id);
			$this->db->like('parent_value', $field_value);
			$get_child_fields = $this->db->order_by('slno')->get('form_field')->result_array();

			foreach ($get_child_fields as $key => $field) {
				switch ($field['type']) {
					case 'select':
					case 'radio-group':
					case 'checkbox-group':
						$this->db->where('field_id', $field['field_id'])->where('status', 1)->order_by('options_order');
						$get_child_fields[$key]['options'] = $this->db->get('form_field_multiple')->result_array();

						$option_vals = explode(",", $field['parent_value']);

						if(!in_array($field_value, $option_vals)){
							unset($get_child_fields[$key]);
						}

						$this->db->where('parent_id', $field['field_id'])->where('status', 1);
						$this->db->like('year', $year_val);
						$check_child_fields = $this->db->get('form_field')->num_rows();

						$get_child_fields[$key]['child_count']  = $check_child_fields;
						break;
						
					case 'lkp_trait':
						$this->db->select('*');
						$this->db->where('trait_status', 1);
						// $this->db->order_by('trait_id');
						$get_child_fields[$key]['options'] = $this->db->get('lkp_trait')->result_array();

						$this->db->where('parent_id', $field['field_id'])->where('status', 1);
						$this->db->like('year', $year_val);
						$check_child_fields = $this->db->get('form_field')->num_rows();

						$get_child_fields[$key]['child_count']  = $check_child_fields;
						break;

					case 'lkp_trait2':
						$this->db->select('*');
						$this->db->where('trait2_status', 1);
						// $this->db->order_by('trait2_id');
						$get_child_fields[$key]['options'] = $this->db->get('lkp_trait2')->result_array();
						
						$this->db->where('parent_id', $field['field_id'])->where('status', 1);
						$this->db->like('year', $year_val);
						$check_child_fields = $this->db->get('form_field')->num_rows();

						$get_child_fields[$key]['child_count']  = $check_child_fields;
						break;

					case 'lkp_country':
						$this->db->select('country_id, country_name,country_code');
						$this->db->order_by('slno');
						$options = $this->db->where('status', 1)->get('lkp_country')->result_array();
						$get_child_fields[$key]['options'] = $options;

						$this->db->where('parent_id', $field['field_id'])->where('status', 1);
						$this->db->like('year', $year_val);
						$check_child_fields = $this->db->get('form_field')->num_rows();

						$get_child_fields[$key]['child_count']  = $check_child_fields;
						break;

					case 'lkp_headquarter':
						$this->db->select('*');
						$this->db->where('headquarter_status', 1);
						// $this->db->order_by('trait2_id');
						$get_child_fields[$key]['options'] = $this->db->get('lkp_headquarter')->result_array();
						
						$this->db->where('parent_id', $field['field_id'])->where('status', 1);
						// $this->db->like('year', $year_val);
						$check_child_fields = $this->db->get('form_field')->num_rows();

						$get_child_fields[$key]['child_count']  = $check_child_fields;
						break;

					case 'group':

					
					case 'group':
						$this->db->where('parent_id', $field['field_id'])->where('parent_value IS NULL')->where('status', 1)->order_by('slno');
						$survey_groupfields = $this->db->get('form_field')->result_array();

						foreach ($survey_groupfields as $gkey => $field) {
							switch ($field['type']) {
								case 'select':
								case 'radio-group':
								case 'checkbox-group':
									$this->db->where('field_id', $field['field_id'])->where('status', 1)->order_by('options_order');
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

						$get_child_fields[$key]['groupfields'] = $survey_groupfields;
						break;
				}					
			}

			$get_child_fields = array_values($get_child_fields);
			$result = array('status' => 1, 'child_field' => $get_child_fields);
		}
		echo json_encode($result);
		exit();	
	}

	public function insert_indicatordata1()	{
		$baseurl = base_url();
		date_default_timezone_set("UTC");
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}
		$this->load->library('excel');
		$user_id = $this->session->userdata('login_id');
		$user_role = $this->session->userdata('role');
		$year_val = $this->input->post('year_val');
		$country_val = $this->input->post('country_val');
		$crop_val = $this->input->post('crop_val');
		$rperiod_val = $this->input->post('rperiod_val');
		$field_sdg = $this->input->post('field_sdg1');
		$sdg_sub_val = $this->input->post('sdg_val');
		$submit_type = $this->input->post('submit_type');
		$form_id = $this->input->post('form_id');

		$sdg_sub_val_array = explode(",", $sdg_sub_val);
		if($field_sdg=="Yes"){
			$this->db->select('GROUP_CONCAT(DISTINCT(sdg_id)) as sdg_ids');
			$this->db->where_in('sdg_sub_id', $sdg_sub_val_array);
			$this->db->where('sdg_sub_status', 1);
			$sdg_id_list = $this->db->get('lkp_sdg_sub')->row_array();
			$sdg_id_val = implode(', ', $sdg_id_list);
		}else{
			$sdg_id_val =0;
		}

		$form_details = $this->db->where('id', $form_id)->get('form')->row_array();
		$time = time();
		$datetime = date('Y-m-d H:i:s');
		$insert_array = array();
		switch ($submit_type) {
			case 'save':
				$status = 1;
				break;

			// case 'submit':
			// 	$status = 2;
			// 	break;
			case 'submit':
				if($user_role == 5){
					$status = 3;
					$insert_array['approve'] = 1;
					$insert_array['approve_by'] = $user_id;
					$insert_array['approve_date'] = $datetime;
				}else{
					$status = 2;
				}				
				break;
		}

		if(isset($_POST['indicator_comment'])){
			$comment = $_POST['indicator_comment'];
		}else{
			$comment = NULL;
		}

		$tablename = "ic_form_data";
		

		$this->db->select('field_id')->where('type', 'group');
		$this->db->where('form_id', $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		$this->db->select('field_id, type, subtype');
		$this->db->where('form_id', $form_id);
		$this->db->where('type', 'uploadfile')->where('subtype', 'document')->where('status', 1);
		$form_fields_uploadfile = $this->db->get('form_field')->result_array();

		
		$insert_array['data_id'] = $time.'-'.$this->session->userdata('login_id');
		$insert_array['form_id'] = $form_id;
		$insert_array['year_id'] = $year_val;
		$insert_array['country_id'] = $country_val;
		$insert_array['crop_id'] = $crop_val;
		$insert_array['rperiod_id'] = $rperiod_val;
		$insert_array['sdg_id'] = $sdg_id_val;
		$insert_array['sdg_sub_id'] = $sdg_sub_val;
		$insert_array['comment'] = $comment;

		$dataarray = array();

		if(count($form_fields_uploadfile) > 0){
			foreach ($form_fields_uploadfile as $key => $value) {
				$uni_id = uniqid();
				$field_name = "field_".$value['field_id'];
				if($value['type'] == 'uploadfile' && $value['subtype'] == 'document'){
					if(isset($_FILES[$field_name]) && $_FILES[$field_name]['name'] != '') {
						if($_FILES[$field_name]['name'] != ''){
							$dataarray[$field_name] = $uni_id.$this->session->userdata('login_id').'_'.$_FILES[$field_name]['name'];
							move_uploaded_file($_FILES[$field_name]['tmp_name'], "upload/survey/" . $dataarray[$field_name]);
						}else{
							$dataarray[$field_name] = NULL;
						}
					}else{
						$dataarray[$field_name] = NULL;
					}
				}
			}
		}

		if($check_group_fields > 0){
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group');
			$this->db->where('form_id', $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();
			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('child_id');
			$this->db->where_in('field_id', $get_group_id_array);
			$this->db->where('form_id', $form_id);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->result_array();

			$get_group_fields_array =  array();
			foreach ($get_group_fields as $key => $gfield) {
				$fieldlist = explode(",", $gfield['child_id']);

				$get_group_fields_array = array_merge($get_group_fields_array, $fieldlist);
			}

			$this->db->select('field_id')->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('form_id', $form_id);
			$this->db->where('status', 1)->where('type !=', 'group')->where('type !=', 'header')->where('type !=', 'uploadgroupdata_excel');
			$non_group_fields = $this->db->get('form_field')->result_array();

			if(!empty($non_group_fields)){
				foreach ($non_group_fields as $key => $value) {				
					$fieldkey = "field_".$value['field_id'];
					$multi_value = array();
					if(isset($_POST[$fieldkey])){
						if(is_array($_POST[$fieldkey])){
							foreach ($_POST[$fieldkey] as $multiplevalue) {
								array_push($multi_value, $multiplevalue);
							}
							$dataarray[$fieldkey] = implode('&#44;', $multi_value);
						}else{
							if($_POST[$fieldkey] == ''){
								$dataarray[$fieldkey] = NULL;
							}else{
								$dataarray[$fieldkey] = $_POST[$fieldkey];
							}
						}
					}else{
						$dataarray[$fieldkey] = NULL;
					}			
				}
			}
		}else{			
			foreach ($_POST as $key => $field) {
				if($key != 'country_val' && $key != 'pos_val' && $key != 'crop_val' && $key != 'year_val' && $key != 'submit_type' && $key != 'indicator_comment'){
					$multi_value = array();
					if(is_array($field)){
						foreach ($field as $value) {
							array_push($multi_value, $value);
						}
						$dataarray[$key] = implode('&#44;', $multi_value);
					}else{
						if($field == ''){
							$dataarray[$key] = NULL;
						}else{
							$dataarray[$key] = $field;
						}
					}
				}
			}
		}
		if(count($dataarray) > 0){
			$insert_array['form_data'] = json_encode($dataarray, JSON_UNESCAPED_UNICODE);
		}else{
			$insert_array['form_data'] = NULL;
		}		
		$insert_array['user_id'] = $this->session->userdata('login_id');
		$insert_array['reg_date_time'] = $datetime;
		$insert_array['ip_address'] = $this->input->ip_address();
		if(($user_role == 5) && $status == 2 && $form_details['type'] != 1){
			// $insert_array['status'] = 3;
			$insert_array['status'] = $status;
		}else{
			$insert_array['status'] = $status;
		}

		if($form_details['type'] == 1){
			$this->db->where_in('status', array(1,2,3))->where('form_id', $form_id);
			$this->db->where('year_id', $year_val)/*->where('country_id', $country_val)->where('crop_id', $crop_val)*/;
			$this->db->where('user_id', $this->session->userdata('login_id'));
			$this->db->order_by('reg_date_time', 'desc');
			$check_outputrecord = $this->db->get('ic_form_data');

			if($check_outputrecord->num_rows() == 0){
				$query = $this->db->insert($tablename, $insert_array);
			}else{
				$old_data = $check_outputrecord->row_array();

				$updatedata = array(
					'form_data' => $insert_array['form_data']
				);
				if($old_data['status'] != $insert_array['status']){
					$updatedata['status'] = $insert_array['status'];
				}
				$this->db->where_in('status', array(1,2,3))->where('form_id', $form_id);
				$this->db->where('year_id', $year_val)/*->where('country_id', $country_val)->where('crop_id', $crop_val)*/;
				$this->db->where('user_id', $this->session->userdata('login_id'));
				$query = $this->db->update($tablename, $updatedata);

				if($query){
					$formdata_logarray = array(
						'editedby' => $this->session->userdata('login_id'),
						'editedfor' => NULL,
						'table_name' => 'ic_form_data',
						'table_row_id' => $old_data['data_id'],
						'table_field_name' => 'form_data',
						'old_value' => $old_data['form_data'],
						'new_value' => $insert_array['form_data'],
						'edited_reason' => 'User editted',
						'updated_date' => date('Y-m-d H:i:s'),
						'ip_address' => $this->input->ip_address(),
						'log_status' => 1
					);

					$formdata_logquery = $this->db->insert('ic_log', $formdata_logarray);

					$status_logarray = array(
						'editedby' => $this->session->userdata('login_id'),
						'editedfor' => NULL,
						'table_name' => 'ic_form_data',
						'table_row_id' => $old_data['data_id'],
						'table_field_name' => 'status',
						'old_value' => $old_data['status'],
						'new_value' => $insert_array['status'],
						'edited_reason' => 'User editted',
						'updated_date' => date('Y-m-d H:i:s'),
						'ip_address' => $this->input->ip_address(),
						'log_status' => 1
					);

					$status_logquery = $this->db->insert('ic_log', $status_logarray);
				}
			}
		}else{
			$query = $this->db->insert($tablename, $insert_array);
		}		

		if($query) {
			if($check_group_fields > 0){
				foreach ($get_group_id_array as $groupkey => $groupid) {
					$group_table_name = "ic_form_group_data";

					$this->db->select('inline');
	        		$this->db->where('type', 'uploadgroupdata_excel')->where('inline',$groupid);
	        		$this->db->where('form_id', $form_id);
					$this->db->where('status', 1);
	        		$excel_groupids = $this->db->get('form_field')->row_array();

					$this->db->select('child_id');
	        		$this->db->where('field_id', $groupid);
	        		$this->db->where('form_id', $form_id);
					$this->db->where('status', 1);
	        		$get_fields_bygroupid = $this->db->get('form_field')->row_array();

					$get_fields_bygroupid_array = explode(",", $get_fields_bygroupid['child_id']);					

					$first_field = "field_".$get_fields_bygroupid_array[0]."";
					if($excel_groupids['inline']==$groupid){
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
										$groupdata['data_id'] = $insert_array['data_id'];
										$groupdata['form_id'] = $insert_array['form_id'];
										$groupdata['user_id'] = $insert_array['user_id'];
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
										$groupdata['status'] = 2;
	
										$surv_group_data = $this->security->xss_clean($groupdata);
										$groupquery = $this->db->insert($group_table_name, $surv_group_data);
									}
								}
							}else{
								if(isset($_POST[$first_field])){
									foreach ($_POST[$first_field] as $fieldskey => $value) {
										$groupdata = array();
										$groupdata['group_id'] = time().$groupkey.$fieldskey.'-'.$this->session->userdata('login_id');
										$groupdata['data_id'] = $insert_array['data_id'];
										$groupdata['form_id'] = $form_id;
										$groupdata['groupfield_id'] = $groupid;
										$groupdata['dataupload_type'] = 'addmore';
		
										$group_data_array = array();
		
										foreach ($get_fields_bygroupid_array as $key => $fieldvalue) {
											$group_field_key = "field_".$fieldvalue;
											$multi_value = array();
											if(isset($_POST[$group_field_key][$fieldskey])){
												if(is_array($_POST[$group_field_key][$fieldskey])){
													foreach ($_POST[$group_field_key][$fieldskey] as $multivalue) {
														array_push($multi_value, $multivalue);
													}
													$group_data_array[$group_field_key] = implode('&#44;', $multi_value);
												}else{
													$group_data_array[$group_field_key] = $_POST[$group_field_key][$fieldskey];
												}
											}else{
												$group_data_array[$group_field_key] = NULL;
											}
										}
										if(count($group_data_array) > 0){
											$groupdata['formgroup_data'] = json_encode($group_data_array, JSON_UNESCAPED_UNICODE);
										}else{
											$groupdata['formgroup_data'] = NULL;
										}							
										$groupdata['user_id'] = $this->session->userdata('login_id');
										$groupdata['reg_date_time'] = $datetime;
										$groupdata['ip_address'] = $this->input->ip_address();
										if(($user_role == 4 || $user_role == 5 || $user_role == 6) && $status == 2 && $form_details['type'] != 1){
											$groupdata['status'] = 3;
										}else{
											$groupdata['status'] = $status;
										}
		
										$groupquery = $this->db->insert($group_table_name, $groupdata);
									}
								}
							}
						}else{
						if(isset($_POST[$first_field])){
							foreach ($_POST[$first_field] as $fieldskey => $value) {
								$groupdata = array();
								$groupdata['group_id'] = time().$groupkey.$fieldskey.'-'.$this->session->userdata('login_id');
								$groupdata['data_id'] = $insert_array['data_id'];
								$groupdata['form_id'] = $form_id;
								$groupdata['groupfield_id'] = $groupid;
								$groupdata['dataupload_type'] = 'addmore';

								$group_data_array = array();

								foreach ($get_fields_bygroupid_array as $key => $fieldvalue) {
									$group_field_key = "field_".$fieldvalue;
									$multi_value = array();
									if(isset($_POST[$group_field_key][$fieldskey])){
										if(is_array($_POST[$group_field_key][$fieldskey])){
											foreach ($_POST[$group_field_key][$fieldskey] as $multivalue) {
												array_push($multi_value, $multivalue);
											}
											$group_data_array[$group_field_key] = implode('&#44;', $multi_value);
										}else{
											$group_data_array[$group_field_key] = $_POST[$group_field_key][$fieldskey];
										}
									}else{
										$group_data_array[$group_field_key] = NULL;
									}
								}
								if(count($group_data_array) > 0){
									$groupdata['formgroup_data'] = json_encode($group_data_array, JSON_UNESCAPED_UNICODE);
								}else{
									$groupdata['formgroup_data'] = NULL;
								}							
								$groupdata['user_id'] = $this->session->userdata('login_id');
								$groupdata['reg_date_time'] = $datetime;
								$groupdata['ip_address'] = $this->input->ip_address();
								if(($user_role == 4 || $user_role == 5 || $user_role == 6) && $status == 2 && $form_details['type'] != 1){
									$groupdata['status'] = 3;
								}else{
									$groupdata['status'] = $status;
								}

								$groupquery = $this->db->insert($group_table_name, $groupdata);
							}
						}
					}
				}	
				
				
			}
			switch ($submit_type) {
				case 'save':
					$ajax_message = 'Data saved successfully. You can now add more data.';
					break;

				case 'submit':
					$ajax_message = 'Data submitted successfully. You can now add more data.';
					$emaildetails = $this->db->where('status', 1)->get('emailconfiguration_details')->row_array();
					if($user_role == 3){
						//get indicator po id
						$this->db->select('lkp_program_id');
						$this->db->where('form_id', $form_id)->where('lkp_year', $year_val)->where('relation_status', 1);
						$get_poid = $this->db->get('rpt_form_relation')->row_array();

						//level 2 user for current po country crop data submitted
						$this->db->select('GROUP_CONCAT(user_id) as userids');
						$this->db->where('po_id', $get_poid['lkp_program_id'])->where('year_id', $year_val);
						/*$this->db->where('country_id', $country_val)->where('crop_id', $crop_val);*/
						$this->db->where('status', 1);
						$get_level2users = $this->db->get('tbl_user_approval')->row_array();

						$get_level2users_array = explode(",", $get_level2users['userids']);
						$level2_userlist = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where_in('user_id', $get_level2users_array)->get('tbl_users')->result_array();

						foreach ($level2_userlist as $key => $user2) {
							$config = Array(
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
							$this->email->from('mandeaticrisat@gmail.com','MPRO');
							$this->email->to($user2['email_id']);
							$this->email->subject('Indicator submission');
							$this->email->set_mailtype("html");
							$this->email->message("Dear ".$user2['first_name']." ".$user2['last_name']." ,<br/><br/><b>".$this->session->userdata('name')."</b> has submited the data for <b>".$form_details['title']."</b>.<br/><br/>Please visit the MPRO AVISA Reporting 2020 platform and review the data.<br/><br/>You can either Approve or Edit and approve.<br/><br/>You can also ask query and send back the data for further modifications.<br/><br/>Regards,<br/>MPRO team");
							if(!$this->email->send()){
								show_error($this->email->print_debugger());
							}
						}
					}

					if($user_role == 4){
						//get indicator po id
						$this->db->select('lkp_program_id');
						$this->db->where('form_id', $form_id)->where('lkp_year', $year_val)->where('relation_status', 1);
						$get_poid = $this->db->get('rpt_form_relation')->row_array();

						//level 2 user for current po country crop data submitted
						$this->db->select('GROUP_CONCAT(tua.user_id) as userids');
						$this->db->join('tbl_users as user', 'tua.user_id = user.user_id');
						$this->db->where('po_id', $get_poid['lkp_program_id'])->where('year_id', $year_val)->where('role_id >', 4)->where('role_id <', 7);
						/*$this->db->where('country_id', $country_val)->where('crop_id', $crop_val);*/
						$this->db->where('tua.status', 1);
						$get_level2users = $this->db->get('tbl_user_approval as tua')->row_array();

						$get_level2users_array = explode(",", $get_level2users['userids']);
						$level2_userlist = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where_in('user_id', $get_level2users_array)->get('tbl_users')->result_array();

						foreach ($level2_userlist as $key => $user2) {
							$config = Array(
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
							$this->email->from('mandeaticrisat@gmail.com','MPRO');
							$this->email->to($user2['email_id']);
							$this->email->subject('Indicator submission');
							$this->email->set_mailtype("html");
							$this->email->message("Dear ".$user2['first_name']." ".$user2['last_name']." ,<br/><br/><b>".$this->session->userdata('name')."</b> has submited the data for <b>".$form_details['title']."</b>.<br/><br/>Please visit the MPRO AVISA Reporting 2020 platform and review the data.<br/><br/>You can either Approve or Edit and approve.<br/><br/>You can also ask query and send back the data for further modifications.<br/><br/>Regards,<br/>MPRO team");
							if(!$this->email->send()){
								show_error($this->email->print_debugger());
							}
						}
					}

					if($user_role == 5){
						//get indicator po id
						$this->db->select('lkp_program_id');
						$this->db->where('form_id', $form_id)->where('lkp_year', $year_val)->where('relation_status', 1);
						$get_poid = $this->db->get('rpt_form_relation')->row_array();

						//level 2 user for current po country crop data submitted
						$this->db->select('GROUP_CONCAT(tua.user_id) as userids');
						$this->db->join('tbl_users as user', 'tua.user_id = user.user_id');
						$this->db->where('po_id', $get_poid['lkp_program_id'])->where('year_id', $year_val)->where('role_id', 6);
						/*$this->db->where('country_id', $country_val)->where('crop_id', $crop_val);*/
						$this->db->where('tua.status', 1);
						$get_level2users = $this->db->get('tbl_user_approval as tua')->row_array();

						$get_level2users_array = explode(",", $get_level2users['userids']);
						$level2_userlist = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where_in('user_id', $get_level2users_array)->get('tbl_users')->result_array();

						foreach ($level2_userlist as $key => $user2) {
							$config = Array(
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
							$this->email->from('mandeaticrisat@gmail.com','MPRO');
							$this->email->to($user2['email_id']);
							$this->email->subject('Indicator submission');
							$this->email->set_mailtype("html");
							$this->email->message("Dear ".$user2['first_name']." ".$user2['last_name']." ,<br/><br/><b>".$this->session->userdata('name')."</b> has submited the data for <b>".$form_details['title']."</b>.<br/><br/>Please visit the MPRO AVISA Reporting 2020 platform and review the data.<br/><br/>You can either Approve or Edit and approve.<br/><br/>You can also ask query and send back the data for further modifications.<br/><br/>Regards,<br/>MPRO team");
							if(!$this->email->send()){
								show_error($this->email->print_debugger());
							}
						}
					}
					break;
			}

			
			//Insert uploaded images / files in db
			
			if(isset($_FILES['survey_images'])) {
				foreach ($_FILES['survey_images']['name'] as $key => $si) {
					if($_FILES['survey_images']['size'][$key] > 0) {
						//Upload Image
						$file_name = $_FILES['survey_images']['name'][$key];
						$ext = pathinfo($file_name, PATHINFO_EXTENSION);
						// $file = $file_name;
						$file = uniqid().$key.$this->session->userdata('login_id').'.'.$ext;
						$path_parts = pathinfo($_FILES['survey_images']['name'][$key]);
						$extension = $path_parts['extension'];
						$file_type="image";
						if($extension=='pdf'|| $extension=='docx'|| $extension=='doc'){
							$file_type="document";
						}else{
							$file_type="image";
						}
						$file_size = $_FILES['survey_images']['size'][$key];

						if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'upload/survey/');
						$imgurl = UPLOAD_DIR . $file;

						$filename = $_FILES["survey_images"]["tmp_name"][$key];
						$file_directory = "upload/survey/";
						if($filename) {
							if(move_uploaded_file($filename, $file_directory . $file)){
								// $this->db->select('data_id');
	        					// $this->db->where('data_id', $insert_array['data_id'])->where('status', 1);
	        					// $check_record = $this->db->get('ic_data_file')->row_array();
								//  if(isset($check_record['data_id'])){
								// 	$surv_image_data = array(
								// 		'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
								// 		'form_id' => $this->uri->segment(3),
								// 		'user_id' => $this->session->userdata('login_id'),
								// 		'file_name' => $file,
								// 		'file_type' => $file_type,
								// 		'created_date' => $datetime,
								// 		'ip_address' => $this->input->ip_address(),
								// 		'status' => 1
								// 	);
								// 	$this->db->where('data_id', $insert_array['data_id'])->update('ic_data_file', $surv_image_data);

								//  }else{
									$surv_image_data = array(
										'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
										'data_id' => $insert_array['data_id'],
										'form_id' => $this->uri->segment(3),
										'user_id' => $this->session->userdata('login_id'),
										'file_name' => $file,
										'file_type' => $file_type,
										'created_date' => $datetime,
										'ip_address' => $this->input->ip_address(),
										'status' => 1
									);
									$this->db->insert('ic_data_file', $surv_image_data);
								// }
							}
						}
					}
				}
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

	public function insert_edit_indicatordata()	{
		$baseurl = base_url();
		date_default_timezone_set("UTC");
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}
		$this->load->library('excel');
		$user_id = $this->session->userdata('login_id');
		$user_role = $this->session->userdata('role');
		$record_id = $this->input->post('record_id');
		$year_val = $this->input->post('year_val');
		// $country_val = $this->input->post('country_val');
		// $crop_val = $this->input->post('crop_val');
		// $rperiod_val = $this->input->post('rperiod_val');
		$field_sdg = $this->input->post('field_sdg1');
		$sdg_sub_val = $this->input->post('sdg_val');
		$submit_type = $this->input->post('submit_type');
		$form_id = $this->input->post('form_id');

		$sdg_sub_val_array = explode(",", $sdg_sub_val);
		if($field_sdg=="Yes"){
			$this->db->select('GROUP_CONCAT(DISTINCT(sdg_id)) as sdg_ids');
			$this->db->where_in('sdg_sub_id', $sdg_sub_val_array);
			$this->db->where('sdg_sub_status', 1);
			$sdg_id_list = $this->db->get('lkp_sdg_sub')->row_array();
			$sdg_id_val = implode(', ', $sdg_id_list);
		}else{
			$sdg_id_val =0;
		}

		$form_details = $this->db->where('id', $form_id)->get('form')->row_array();
		$time = time();
		$datetime = date('Y-m-d H:i:s');
		$insert_array = array();
		switch ($submit_type) {
			case 'save':
				$status = 1;
				break;

			case 'rejected':
				$status = 2;
				break;

			// case 'submit':
			// 	$status = 2;
			// 	break;

			case 'submit':
				if($user_role == 5){
					$status = 3;
					$insert_array['approve'] = 1;
					$insert_array['approve_by'] = $user_id;
					$insert_array['approve_date'] = $datetime;
				}else{
					$status = 2;
				}				
				break;
		}

		if(isset($_POST['indicator_comment'])){
			$comment = $_POST['indicator_comment'];
		}else{
			$comment = NULL;
		}

		$tablename = "ic_form_data";
		$this->db->select('data_id');
		$this->db->where('form_id', $form_id);
		$this->db->where('id', $record_id);
		$data_id_list = $this->db->get('ic_form_data')->row_array();

		$this->db->select('field_id')->where('type', 'group');
		$this->db->where('form_id', $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		$this->db->select('field_id, type, subtype');
		$this->db->where('form_id', $form_id);
		$this->db->where('type', 'uploadfile')->where('subtype', 'document')->where('status', 1);
		$form_fields_uploadfile = $this->db->get('form_field')->result_array();

		
		$insert_array['data_id'] = $data_id_list['data_id'];
		// print_r($record_id);exit;
		// $insert_array['form_id'] = $form_id;
		// $insert_array['year_id'] = $year_val;
		// $insert_array['country_id'] = $country_val;
		// $insert_array['crop_id'] = $crop_val;
		// $insert_array['rperiod_id'] = $rperiod_val;
		$insert_array['sdg_id'] = $sdg_id_val;
		$insert_array['sdg_sub_id'] = $sdg_sub_val;
		$insert_array['comment'] = $comment;

		$dataarray = array();

		if(count($form_fields_uploadfile) > 0){
			foreach ($form_fields_uploadfile as $key => $value) {
				$uni_id = uniqid();
				$field_name = "field_".$value['field_id'];
				if($value['type'] == 'uploadfile' && $value['subtype'] == 'document'){
					if(isset($_FILES[$field_name]) && $_FILES[$field_name]['name'] != '') {
						if($_FILES[$field_name]['name'] != ''){
							$dataarray[$field_name] = $uni_id.$this->session->userdata('login_id').'_'.$_FILES[$field_name]['name'];
							move_uploaded_file($_FILES[$field_name]['tmp_name'], "upload/survey/" . $dataarray[$field_name]);
						}else{
							$dataarray[$field_name] = NULL;
						}
					}else{
						$dataarray[$field_name] = NULL;
					}
				}
			}
		}

		if($check_group_fields > 0){
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group');
			$this->db->where('form_id', $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();
			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('child_id');
			$this->db->where_in('field_id', $get_group_id_array);
			$this->db->where('form_id', $form_id);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->result_array();

			$get_group_fields_array =  array();
			foreach ($get_group_fields as $key => $gfield) {
				$fieldlist = explode(",", $gfield['child_id']);

				$get_group_fields_array = array_merge($get_group_fields_array, $fieldlist);
			}

			$this->db->select('field_id')->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('form_id', $form_id);
			$this->db->where('status', 1)->where('type !=', 'group')->where('type !=', 'header')->where('type !=', 'uploadgroupdata_excel');
			$non_group_fields = $this->db->get('form_field')->result_array();

			if(!empty($non_group_fields)){
				foreach ($non_group_fields as $key => $value) {				
					$fieldkey = "field_".$value['field_id'];
					$multi_value = array();
					if(isset($_POST[$fieldkey])){
						if(is_array($_POST[$fieldkey])){
							foreach ($_POST[$fieldkey] as $multiplevalue) {
								array_push($multi_value, $multiplevalue);
							}
							$dataarray[$fieldkey] = implode('&#44;', $multi_value);
						}else{
							if($_POST[$fieldkey] == ''){
								$dataarray[$fieldkey] = NULL;
							}else{
								$dataarray[$fieldkey] = $_POST[$fieldkey];
							}
						}
					}else{
						$dataarray[$fieldkey] = NULL;
					}			
				}
			}
		}else{			
			foreach ($_POST as $key => $field) {
				if($key != 'country_val' && $key != 'pos_val' && $key != 'crop_val' && $key != 'year_val' && $key != 'submit_type' && $key != 'indicator_comment'){
					$multi_value = array();
					if(is_array($field)){
						foreach ($field as $value) {
							array_push($multi_value, $value);
						}
						$dataarray[$key] = implode('&#44;', $multi_value);
					}else{
						if($field == ''){
							$dataarray[$key] = NULL;
						}else{
							$dataarray[$key] = $field;
						}
					}
				}
			}
		}
		if(count($dataarray) > 0){
			$insert_array['form_data'] = json_encode($dataarray, JSON_UNESCAPED_UNICODE);
		}else{
			$insert_array['form_data'] = NULL;
		}		
		$insert_array['user_id'] = $this->session->userdata('login_id');
		$insert_array['reg_date_time'] = $datetime;
		$insert_array['ip_address'] = $this->input->ip_address();
		if(($user_role == 5) && $status == 2 && $form_details['type'] != 1){
			$insert_array['status'] = 3;
		}else{
			$insert_array['status'] = $status;
		}

		if($form_details['type'] == 1){
			$this->db->where_in('status', array(1,2,3))->where('form_id', $form_id);
			$this->db->where('year_id', $year_val)/*->where('country_id', $country_val)->where('crop_id', $crop_val)*/;
			$this->db->where('user_id', $this->session->userdata('login_id'));
			$this->db->order_by('reg_date_time', 'desc');
			$check_outputrecord = $this->db->get('ic_form_data');

			if($check_outputrecord->num_rows() == 0){
				// $query = $this->db->insert($tablename, $insert_array);
				$query = $this->db->where('data_id', $insert_array['data_id'])->update($tablename, $insert_array);
			}else{
				$old_data = $check_outputrecord->row_array();

				$updatedata = array(
					'form_data' => $insert_array['form_data']
				);
				if($old_data['status'] != $insert_array['status']){
					$updatedata['status'] = $insert_array['status'];
				}
				$this->db->where_in('status', array(1,2,3))->where('form_id', $form_id);
				$this->db->where('year_id', $year_val)/*->where('country_id', $country_val)->where('crop_id', $crop_val)*/;
				$this->db->where('user_id', $this->session->userdata('login_id'));
				$query = $this->db->update($tablename, $updatedata);

				if($query){
					$formdata_logarray = array(
						'editedby' => $this->session->userdata('login_id'),
						'editedfor' => NULL,
						'table_name' => 'ic_form_data',
						'table_row_id' => $old_data['data_id'],
						'table_field_name' => 'form_data',
						'old_value' => $old_data['form_data'],
						'new_value' => $insert_array['form_data'],
						'edited_reason' => 'User editted',
						'updated_date' => date('Y-m-d H:i:s'),
						'ip_address' => $this->input->ip_address(),
						'log_status' => 1
					);

					$formdata_logquery = $this->db->insert('ic_log', $formdata_logarray);

					$status_logarray = array(
						'editedby' => $this->session->userdata('login_id'),
						'editedfor' => NULL,
						'table_name' => 'ic_form_data',
						'table_row_id' => $old_data['data_id'],
						'table_field_name' => 'status',
						'old_value' => $old_data['status'],
						'new_value' => $insert_array['status'],
						'edited_reason' => 'User editted',
						'updated_date' => date('Y-m-d H:i:s'),
						'ip_address' => $this->input->ip_address(),
						'log_status' => 1
					);

					$status_logquery = $this->db->insert('ic_log', $status_logarray);
				}
			}
		}else{
			// $query = $this->db->insert($tablename, $insert_array);
			
			$query = $this->db->where('data_id', $insert_array['data_id'])->update($tablename, $insert_array);
		}		

		if($query) {
			$groupdata['reg_date_time'] = $datetime;
			$groupdata['ip_address'] = $this->input->ip_address();
			$groupdata['status'] = 2;

			$group_table_name = "ic_form_group_data";
			$surv_group_data = $this->security->xss_clean($groupdata);
			$groupquery = $this->db->where('data_id', $insert_array['data_id'])->update($group_table_name, $surv_group_data);
			// if($check_group_fields > 0){
			// 	foreach ($get_group_id_array as $groupkey => $groupid) {
			// 		

			// 		$this->db->select('inline');
	        // 		$this->db->where('type', 'uploadgroupdata_excel')->where('inline',$groupid);
	        // 		$this->db->where('form_id', $form_id);
			// 		$this->db->where('status', 1);
	        // 		$excel_groupids = $this->db->get('form_field')->row_array();

			// 		$this->db->select('child_id');
	        // 		$this->db->where('field_id', $groupid);
	        // 		$this->db->where('form_id', $form_id);
			// 		$this->db->where('status', 1);
	        // 		$get_fields_bygroupid = $this->db->get('form_field')->row_array();

			// 		$get_fields_bygroupid_array = explode(",", $get_fields_bygroupid['child_id']);					

			// 		$first_field = "field_".$get_fields_bygroupid_array[0]."";
			// 		if($excel_groupids['inline']==$groupid){
			// 				if(isset($_FILES['uploadexcel_data']) && $_FILES['uploadexcel_data']['name'] != '' ){
			// 					$file_info = pathinfo($_FILES['uploadexcel_data']['name']);
			// 					$file_directory = "upload/survey/";
			// 					$new_file_name = uniqid().$this->session->userdata('login_id').".". $file_info["extension"];
			// 					if(move_uploaded_file($_FILES['uploadexcel_data']["tmp_name"], $file_directory . $new_file_name)){
			// 						$file_type	= PHPExcel_IOFactory::identify($file_directory . $new_file_name);
			// 						$objReader	= PHPExcel_IOFactory::createReader($file_type);
			// 						$objPHPExcel = $objReader->load($file_directory . $new_file_name);
			// 						$column = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
				
			// 						// if($column != 'K'){
			// 						// 	unlink($file_directory.''.$new_file_name);
			// 						// 	echo json_encode(array('status' => 0, 'csrfName' => $this->security->get_csrf_token_name(), 'csrfHash' => $this->security->get_csrf_hash(), 'msg' => 'Invalid number of columns in the excel choosen.'));
			// 						// 	exit();
			// 						// }
			// 					}else{
			// 						echo "not moved";
			// 						die();
			// 					}
			// 					$excel_column_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z');
	
			// 					$directory = "upload/survey/";
	
			// 					$group_table_name = "ic_form_group_data";
	
			// 					$file_type	= PHPExcel_IOFactory::identify($directory . $new_file_name);
			// 					$objReader	= PHPExcel_IOFactory::createReader($file_type);
			// 					$objPHPExcel = $objReader->load($directory . $new_file_name);
			// 					$column = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
			// 					$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); 
	
			// 					$sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			// 					$excelmulti_value = array();
			// 					foreach($sheet_data as $ekey => $data){
			// 						if($ekey > 1){
			// 							// $groupdata['group_id'] = time().$groupkey.$ekey.'-'.$this->session->userdata('login_id');
			// 							// $groupdata['data_id'] = $insert_array['data_id'];
			// 							// $groupdata['form_id'] = $insert_array['form_id'];
			// 							$groupdata['user_id'] = $insert_array['user_id'];
			// 							// $groupdata['groupfield_id'] = $groupid;
			// 							// $groupdata['groupfield_id'] = $excel_groupids['field_id'];
			// 							$groupdata['dataupload_type'] = 'excel';
	
			// 							$field_array = array();
	
			// 							foreach ($get_fields_bygroupid_array as $gkey => $fieldvalue) {
			// 								$group_field_key = "field_".$fieldvalue;
			// 								$column_value= $data[$excel_column_array[$gkey]];
			// 								if($column_value=='')
			// 									$column_value='NA';
			// 								$field_array[$group_field_key] = $column_value;
			// 							}
	
			// 							$groupdata['formgroup_data'] = json_encode($field_array, JSON_UNESCAPED_UNICODE);
			// 							$groupdata['reg_date_time'] = $datetime;
			// 							$groupdata['ip_address'] = $this->input->ip_address();
			// 							$groupdata['status'] = 2;
	
			// 							$surv_group_data = $this->security->xss_clean($groupdata);
			// 							// $groupquery = $this->db->insert($group_table_name, $surv_group_data);
			// 							$query = $this->db->where('data_id', $insert_array['data_id'])->update($group_table_name, $surv_group_data);
			// 						}
			// 					}
			// 				}else{
			// 					if(isset($_POST[$first_field])){
			// 						foreach ($_POST[$first_field] as $fieldskey => $value) {
			// 							$groupdata = array();
			// 							// $groupdata['group_id'] = time().$groupkey.$fieldskey.'-'.$this->session->userdata('login_id');
			// 							// $groupdata['data_id'] = $insert_array['data_id'];
			// 							// $groupdata['form_id'] = $form_id;
			// 							// $groupdata['groupfield_id'] = $groupid;
			// 							$groupdata['dataupload_type'] = 'addmore';
		
			// 							$group_data_array = array();
		
			// 							foreach ($get_fields_bygroupid_array as $key => $fieldvalue) {
			// 								$group_field_key = "field_".$fieldvalue;
			// 								$multi_value = array();
			// 								if(isset($_POST[$group_field_key][$fieldskey])){
			// 									if(is_array($_POST[$group_field_key][$fieldskey])){
			// 										foreach ($_POST[$group_field_key][$fieldskey] as $multivalue) {
			// 											array_push($multi_value, $multivalue);
			// 										}
			// 										$group_data_array[$group_field_key] = implode('&#44;', $multi_value);
			// 									}else{
			// 										$group_data_array[$group_field_key] = $_POST[$group_field_key][$fieldskey];
			// 									}
			// 								}else{
			// 									$group_data_array[$group_field_key] = NULL;
			// 								}
			// 							}
			// 							if(count($group_data_array) > 0){
			// 								$groupdata['formgroup_data'] = json_encode($group_data_array, JSON_UNESCAPED_UNICODE);
			// 							}else{
			// 								$groupdata['formgroup_data'] = NULL;
			// 							}							
			// 							$groupdata['user_id'] = $this->session->userdata('login_id');
			// 							$groupdata['reg_date_time'] = $datetime;
			// 							$groupdata['ip_address'] = $this->input->ip_address();
			// 							if(($user_role == 5) && $status == 2 && $form_details['type'] != 1){
			// 								$groupdata['status'] = 3;
			// 							}else{
			// 								$groupdata['status'] = $status;
			// 							}
		
			// 							// $groupquery = $this->db->insert($group_table_name, $groupdata);
			// 							$query = $this->db->where('data_id', $insert_array['data_id'])->update($group_table_name, $groupdata);
			// 						}
			// 					}
			// 				}
			// 			}else{
			// 			if(isset($_POST[$first_field])){
			// 				foreach ($_POST[$first_field] as $fieldskey => $value) {
			// 					$groupdata = array();
			// 					// $groupdata['group_id'] = time().$groupkey.$fieldskey.'-'.$this->session->userdata('login_id');
			// 					// $groupdata['data_id'] = $insert_array['data_id'];
			// 					// $groupdata['form_id'] = $form_id;
			// 					// $groupdata['groupfield_id'] = $groupid;
			// 					$groupdata['dataupload_type'] = 'addmore';

			// 					$group_data_array = array();

			// 					foreach ($get_fields_bygroupid_array as $key => $fieldvalue) {
			// 						$group_field_key = "field_".$fieldvalue;
			// 						$multi_value = array();
			// 						if(isset($_POST[$group_field_key][$fieldskey])){
			// 							if(is_array($_POST[$group_field_key][$fieldskey])){
			// 								foreach ($_POST[$group_field_key][$fieldskey] as $multivalue) {
			// 									array_push($multi_value, $multivalue);
			// 								}
			// 								$group_data_array[$group_field_key] = implode('&#44;', $multi_value);
			// 							}else{
			// 								$group_data_array[$group_field_key] = $_POST[$group_field_key][$fieldskey];
			// 							}
			// 						}else{
			// 							$group_data_array[$group_field_key] = NULL;
			// 						}
			// 					}
			// 					if(count($group_data_array) > 0){
			// 						$groupdata['formgroup_data'] = json_encode($group_data_array, JSON_UNESCAPED_UNICODE);
			// 					}else{
			// 						$groupdata['formgroup_data'] = NULL;
			// 					}							
			// 					$groupdata['user_id'] = $this->session->userdata('login_id');
			// 					$groupdata['reg_date_time'] = $datetime;
			// 					$groupdata['ip_address'] = $this->input->ip_address();
			// 					if(($user_role == 5) && $status == 2 && $form_details['type'] != 1){
			// 						$groupdata['status'] = 3;
			// 					}else{
			// 						$groupdata['status'] = $status;
			// 					}

			// 					// $groupquery = $this->db->insert($group_table_name, $groupdata);
			// 					$query = $this->db->where('data_id', $insert_array['data_id'])->update($group_table_name, $groupdata);
			// 				}
			// 			}
			// 		}
			// 	}	
				
				
			// }
			switch ($submit_type) {
				case 'save':
					$ajax_message = 'Data saved successfully. You can now add more data.';
					break;

				case 'rejected':
					$ajax_message = 'Data submitted successfully. You can now add more data.';
					break;

				case 'submit':
					$ajax_message = 'Data submitted successfully. You can now add more data.';
					// $emaildetails = $this->db->where('status', 1)->get('emailconfiguration_details')->row_array();
					// if($user_role == 3){
					// 	//get indicator po id
					// 	$this->db->select('lkp_program_id');
					// 	$this->db->where('form_id', $form_id)->where('lkp_year', $year_val)->where('relation_status', 1);
					// 	$get_poid = $this->db->get('rpt_form_relation')->row_array();

					// 	//level 2 user for current po country crop data submitted
					// 	$this->db->select('GROUP_CONCAT(user_id) as userids');
					// 	$this->db->where('po_id', $get_poid['lkp_program_id'])->where('year_id', $year_val);
					// 	/*$this->db->where('country_id', $country_val)->where('crop_id', $crop_val);*/
					// 	$this->db->where('status', 1);
					// 	$get_level2users = $this->db->get('tbl_user_approval')->row_array();

					// 	$get_level2users_array = explode(",", $get_level2users['userids']);
					// 	$level2_userlist = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where_in('user_id', $get_level2users_array)->get('tbl_users')->result_array();

					// 	foreach ($level2_userlist as $key => $user2) {
					// 		$config = Array(
					// 			'protocol' => 'smtp',
					// 			'smtp_host' => 'ssl://smtp.googlemail.com',
					// 			'smtp_port' => 465,
					// 			'smtp_user' => $emaildetails['email_id'], // change it to yours
					// 			'smtp_pass' => $emaildetails['password'], // change it to yours
					// 			'mailtype' => 'html',
					// 			'charset' => 'iso-8859-1',
					// 			'wordwrap' => TRUE
					// 		);

					// 		$this->load->library('email', $config);
					// 		$this->email->set_newline("\r\n");
					// 		$this->email->from('mandeaticrisat@gmail.com','MPRO');
					// 		$this->email->to($user2['email_id']);
					// 		$this->email->subject('Indicator submission');
					// 		$this->email->set_mailtype("html");
					// 		$this->email->message("Dear ".$user2['first_name']." ".$user2['last_name']." ,<br/><br/><b>".$this->session->userdata('name')."</b> has submited the data for <b>".$form_details['title']."</b>.<br/><br/>Please visit the MPRO AVISA Reporting 2020 platform and review the data.<br/><br/>You can either Approve or Edit and approve.<br/><br/>You can also ask query and send back the data for further modifications.<br/><br/>Regards,<br/>MPRO team");
					// 		if(!$this->email->send()){
					// 			show_error($this->email->print_debugger());
					// 		}
					// 	}
					// }

					// if($user_role == 4){
					// 	//get indicator po id
					// 	$this->db->select('lkp_program_id');
					// 	$this->db->where('form_id', $form_id)->where('lkp_year', $year_val)->where('relation_status', 1);
					// 	$get_poid = $this->db->get('rpt_form_relation')->row_array();

					// 	//level 2 user for current po country crop data submitted
					// 	$this->db->select('GROUP_CONCAT(tua.user_id) as userids');
					// 	$this->db->join('tbl_users as user', 'tua.user_id = user.user_id');
					// 	$this->db->where('po_id', $get_poid['lkp_program_id'])->where('year_id', $year_val)->where('role_id >', 4)->where('role_id <', 7);
					// 	/*$this->db->where('country_id', $country_val)->where('crop_id', $crop_val);*/
					// 	$this->db->where('tua.status', 1);
					// 	$get_level2users = $this->db->get('tbl_user_approval as tua')->row_array();

					// 	$get_level2users_array = explode(",", $get_level2users['userids']);
					// 	$level2_userlist = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where_in('user_id', $get_level2users_array)->get('tbl_users')->result_array();

					// 	foreach ($level2_userlist as $key => $user2) {
					// 		$config = Array(
					// 			'protocol' => 'smtp',
					// 			'smtp_host' => 'ssl://smtp.googlemail.com',
					// 			'smtp_port' => 465,
					// 			'smtp_user' => $emaildetails['email_id'], // change it to yours
					// 			'smtp_pass' => $emaildetails['password'], // change it to yours
					// 			'mailtype' => 'html',
					// 			'charset' => 'iso-8859-1',
					// 			'wordwrap' => TRUE
					// 		);

					// 		$this->load->library('email', $config);
					// 		$this->email->set_newline("\r\n");
					// 		$this->email->from('mandeaticrisat@gmail.com','MPRO');
					// 		$this->email->to($user2['email_id']);
					// 		$this->email->subject('Indicator submission');
					// 		$this->email->set_mailtype("html");
					// 		$this->email->message("Dear ".$user2['first_name']." ".$user2['last_name']." ,<br/><br/><b>".$this->session->userdata('name')."</b> has submited the data for <b>".$form_details['title']."</b>.<br/><br/>Please visit the MPRO AVISA Reporting 2020 platform and review the data.<br/><br/>You can either Approve or Edit and approve.<br/><br/>You can also ask query and send back the data for further modifications.<br/><br/>Regards,<br/>MPRO team");
					// 		if(!$this->email->send()){
					// 			show_error($this->email->print_debugger());
					// 		}
					// 	}
					// }

					// if($user_role == 5){
					// 	//get indicator po id
					// 	$this->db->select('lkp_program_id');
					// 	$this->db->where('form_id', $form_id)->where('lkp_year', $year_val)->where('relation_status', 1);
					// 	$get_poid = $this->db->get('rpt_form_relation')->row_array();

					// 	//level 2 user for current po country crop data submitted
					// 	$this->db->select('GROUP_CONCAT(tua.user_id) as userids');
					// 	$this->db->join('tbl_users as user', 'tua.user_id = user.user_id');
					// 	$this->db->where('po_id', $get_poid['lkp_program_id'])->where('year_id', $year_val)->where('role_id', 6);
					// 	/*$this->db->where('country_id', $country_val)->where('crop_id', $crop_val);*/
					// 	$this->db->where('tua.status', 1);
					// 	$get_level2users = $this->db->get('tbl_user_approval as tua')->row_array();

					// 	$get_level2users_array = explode(",", $get_level2users['userids']);
					// 	$level2_userlist = $this->db->select('email_id, first_name, last_name')->where('status', 1)->where_in('user_id', $get_level2users_array)->get('tbl_users')->result_array();

					// 	foreach ($level2_userlist as $key => $user2) {
					// 		$config = Array(
					// 			'protocol' => 'smtp',
					// 			'smtp_host' => 'ssl://smtp.googlemail.com',
					// 			'smtp_port' => 465,
					// 			'smtp_user' => $emaildetails['email_id'], // change it to yours
					// 			'smtp_pass' => $emaildetails['password'], // change it to yours
					// 			'mailtype' => 'html',
					// 			'charset' => 'iso-8859-1',
					// 			'wordwrap' => TRUE
					// 		);

					// 		$this->load->library('email', $config);
					// 		$this->email->set_newline("\r\n");
					// 		$this->email->from('mandeaticrisat@gmail.com','MPRO');
					// 		$this->email->to($user2['email_id']);
					// 		$this->email->subject('Indicator submission');
					// 		$this->email->set_mailtype("html");
					// 		$this->email->message("Dear ".$user2['first_name']." ".$user2['last_name']." ,<br/><br/><b>".$this->session->userdata('name')."</b> has submited the data for <b>".$form_details['title']."</b>.<br/><br/>Please visit the MPRO AVISA Reporting 2020 platform and review the data.<br/><br/>You can either Approve or Edit and approve.<br/><br/>You can also ask query and send back the data for further modifications.<br/><br/>Regards,<br/>MPRO team");
					// 		if(!$this->email->send()){
					// 			show_error($this->email->print_debugger());
					// 		}
					// 	}
					// }
					break;
			}

			
			//Insert uploaded images / files in db
			
			if(isset($_FILES['survey_images']) ){
				if(!empty($_FILES['survey_images']['name'][0])) {
					
					// existing files db records update status 0
					$surv_image_data1 = array(
						'created_date' => $datetime,
						'ip_address' => $this->input->ip_address(),
						'status' => 0
					);
					$this->db->where('data_id', $insert_array['data_id'])->where('status', 1)->update('ic_data_file', $surv_image_data1);
					foreach ($_FILES['survey_images']['name'] as $key => $si) {
						if($_FILES['survey_images']['size'][$key] > 0) {
							//Upload Image
							$file_name = $_FILES['survey_images']['name'][$key];
							$ext = pathinfo($file_name, PATHINFO_EXTENSION);
							// $file = $file_name;
							$file = uniqid().$key.$this->session->userdata('login_id').'.'.$ext;
							$path_parts = pathinfo($_FILES['survey_images']['name'][$key]);
							$extension = $path_parts['extension'];
							$file_type="image";
							if($extension=='pdf'|| $extension=='docx'|| $extension=='doc'){
								$file_type="document";
							}else{
								$file_type="image";
							}
							$file_size = $_FILES['survey_images']['size'][$key];

							if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'upload/survey/');
							$imgurl = UPLOAD_DIR . $file;

							$filename = $_FILES["survey_images"]["tmp_name"][$key];
							$file_directory = "upload/survey/";
							if($filename) {
								if(move_uploaded_file($filename, $file_directory . $file)){
									// $this->db->select('data_id');
									// $this->db->where('data_id', $insert_array['data_id'])->where('status', 1);
									// $check_record = $this->db->get('ic_data_file')->row_array();
									//  if(isset($check_record['data_id'])){
										// $this->db->delete('ic_data_file', array('data_id' => $insert_array['data_id']));
										// $this -> db -> where('data_id', $insert_array['data_id']);
										// $this -> db -> delete('ic_data_file');
										// $surv_image_data = array(
										// 	'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
										// 	'form_id' => $this->uri->segment(3),
										// 	'user_id' => $this->session->userdata('login_id'),
										// 	'file_name' => $file,
										// 	'file_type' => $file_type,
										// 	'created_date' => $datetime,
										// 	'ip_address' => $this->input->ip_address(),
										// 	'status' => 1
										// );
										// $this->db->where('data_id', $insert_array['data_id'])->update('ic_data_file', $surv_image_data);

									//  }
									//  else{
										$surv_image_data = array(
											'file_id' => time().$key.'-'.$this->session->userdata('login_id'),
											'data_id' => $insert_array['data_id'],
											'form_id' => $this->uri->segment(3),
											'user_id' => $this->session->userdata('login_id'),
											'file_name' => $file,
											'file_type' => $file_type,
											'created_date' => $datetime,
											'ip_address' => $this->input->ip_address(),
											'status' => 1
										);
										$this->db->insert('ic_data_file', $surv_image_data);
									// }
								}
							}
						}
					}
				}
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

	public function nothingto_report(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
			exit();
		}
		date_default_timezone_set("UTC");
		$user_id = $this->session->userdata('login_id');
		$user_role = $this->session->userdata('role');

		$insert_array = array(
			'data_id' => time().'-'.$this->session->userdata('login_id'),
			'form_id' => $this->input->post('form_id'),
			'year_id' => $this->input->post('year_val'),
			'country_id' => $this->input->post('country_val'),
			'crop_id' => $this->input->post('crop_val'),
			'rperiod_id' => $this->input->post('rperiod_val'),
			'comment' => NULL,
			'form_data' => NULL,
			'user_id' => $this->session->userdata('login_id'),
			'nothingto_report' => 1,
			'approve' => NULL,
			'approve_by' => NULL,
			'approve_date' => NULL,
			'reg_date_time' => date('Y-m-d H:i:s'),
			'ip_address' =>  $this->input->ip_address(),
			'query_status' => NULL
		);
		if($user_role == 4 || $user_role == 5 || $user_role == 6){
			$insert_array['status'] = 3;
		}else{
			$insert_array['status'] = 2;
		}
		$table_query = $this->db->insert('ic_form_data', $insert_array);

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

	public function submit_summaryreport(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
			exit();
		}
		date_default_timezone_set("UTC");
		$user_id = $this->session->userdata('login_id');

		$country_id = $this->input->post('country_id');
		$crop_id = $this->input->post('crop_id');

		$check_data = $this->db->where('crop_id', $crop_id[0])->where('country_id', $country_id[0])->where('year_id', $this->input->post('year_id'))->where('user_id', $this->session->userdata('login_id'))->where('status', 1)->get('ic_summary_report')->num_rows();

		if($check_data > 0){
			$updatedata = array(
				'comment' => $this->input->post('comment'),
			);
			$this->db->where('crop_id', $crop_id[0])->where('country_id', $country_id[0])->where('year_id', $this->input->post('year_id'))->where('user_id', $this->session->userdata('login_id'))->where('status', 1);
			$table_query = $this->db->update('ic_summary_report', $updatedata);
		}else{
			$insert_array = array(
				'year_id' => $this->input->post('year_id'),
				'country_id' => $country_id[0],
				'crop_id' => $crop_id[0],
				'user_id' => $this->session->userdata('login_id'),
				'comment' => $this->input->post('comment'),
				'added_date' => date('Y-m-d H:i:s'),
				'ip_address' =>  $this->input->ip_address(),
				'status' => 1
			);
			$table_query = $this->db->insert('ic_summary_report', $insert_array);
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
	
	public function removenothingto_report(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
			exit();
		}
		date_default_timezone_set("UTC");
		$user_id = $this->session->userdata('login_id');

		$this->db->where('crop_id', $this->input->post('crop_val'));
		$this->db->where('country_id', $this->input->post('country_val'));
		$this->db->where('year_id', $this->input->post('year_val'));
		$this->db->where('rperiod_id', $this->input->post('rperiod_val'));
		$check_data = $this->db->where('user_id', $this->session->userdata('login_id'))->where('status', 2)->where('form_id', $this->input->post('form_id'))->where('nothingto_report', 1)->get('ic_form_data')->num_rows();
		$sql = $this->db->last_query();
		// if($check_data == 0){
		// 	echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
		// 	exit();
		// }

		$updatedata = array(
			'status' => 0,
		);
		$this->db->where('crop_id', $this->input->post('crop_val'));
		$this->db->where('country_id', $this->input->post('country_val'));
		$this->db->where('year_id', $this->input->post('year_val'));
		$this->db->where('rperiod_id', $this->input->post('rperiod_val'));
		$this->db->where('user_id', $this->session->userdata('login_id'))->where('status', 2)->where('form_id', $this->input->post('form_id'))->where('nothingto_report', 1);
		$table_query = $this->db->update('ic_form_data', $updatedata);

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

	public function get_summarydata(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array('status' => 0, 'msg' => 'Your session has expired please login and try again'));
			exit();
		}
		date_default_timezone_set("UTC");
		$user_id = $this->session->userdata('login_id');

		$country_id = $this->input->post('country');
		$crop_id = $this->input->post('crop');

		$check_data = $this->db->where('crop_id', $crop_id[0])->where('country_id', $country_id[0])->where('year_id', $this->input->post('year'))->where('user_id', $this->session->userdata('login_id'))->where('status', 1)->get('ic_summary_report');
		if($check_data->num_rows() == 0){
			echo json_encode(array('status' => 1, 'comment' => ''));
			exit();
		}else{
			$data = $check_data->row_array();
			echo json_encode(array('status' => 1, 'comment' => $data['comment']));
			exit();
		}
	}

	//uploading form data using excel
	public function avisa_excelupload(){
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			redirect($baseurl);
		}
		if(($this->uri->segment(1) == '') || ($this->uri->segment(2) == '') || ($this->uri->segment(3) == '') || ($this->uri->segment(4) == '')){
			show_404();
		}

		$form_id = $this->uri->segment(3);
		$year_val = $this->uri->segment(4);
		$country_val = $this->uri->segment(5);
		$crop_val = $this->uri->segment(6);

		$crop_name = $this->db->select('*')->where('crop_id', $crop_val)->where('crop_status', 1)->get('lkp_crop')->row_array();
		$country_name = $this->db->select('*')->where('country_id', $country_val)->where('status', 1)->get('lkp_country')->row_array();
		$year_name = $this->db->select('*')->where('year_id', $year_val)->where('year_status', 1)->get('lkp_year')->row_array();

		$this->db->where('form_id', $form_id);
		$this->db->where('type', 'uploadgroupdata_excel')->where('status', 1);
		$indicator_data = $this->db->get('form_field')->row_array();

		if($indicator_data != NULL){
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group');
			$this->db->where('form_id', $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('GROUP_CONCAT(field_id) as field_ids')->where_in('parent_id', $get_group_id_array);
			$this->db->where('form_id', $form_id);
			$this->db->where('status', 1);
			$get_group_fields = $this->db->get('form_field')->row_array();
			$get_group_fields_array = explode(",", $get_group_fields['field_ids']);

			$this->db->select('field_id, label, type, subtype, field_count, required, description, className, maxlength, multiple, max_val');
			$this->db->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('form_id', $form_id);
			$this->db->where('parent_id IS NULL');
			$this->db->where('status', 1)->where('type !=', 'group')->where('type !=', 'header')->order_by('slno');
			$non_group_fields = $this->db->get('form_field')->result_array();

			foreach ($non_group_fields as $key => $field) {
				switch ($field['type']) {
					case 'select':
					case 'radio-group':
					case 'checkbox-group':
						$this->db->where('field_id', $field['field_id'])->where('status', 1);
						$this->db->order_by('options_order');
						$non_group_fields[$key]['options'] = $this->db->get('form_field_multiple')->result_array();
						break;
				}

				$this->db->where('parent_id', $field['field_id'])->where('status', 1);
				$check_child_fields = $this->db->get('form_field')->num_rows();

				$non_group_fields[$key]['child_count']  = $check_child_fields;
			}

			$this->db->select('title as indicator_name');
			$this->db->where('id', $form_id);
			$indicator_name = $this->db->get('form')->row_array();

			$result = array('status' => 1, 'indicator_name' => $indicator_name, 'indicator_data' => $indicator_data, 'non_group_fields' => $non_group_fields, 'country_name' => $country_name['country_name'], 'crop_name' => $crop_name['crop_name'], 'year_name' => $year_name['year']);
			
			//getting common lkp data from tables start from here
			$this->db->select('*');
			$this->db->where('year_status', 1);
			$result['lkp_year_list'] = $this->db->get('lkp_year')->result_array();
			$this->db->select('*');
			$this->db->where('status', 1);
			$result['lkp_country_list'] = $this->db->get('lkp_country')->result_array();
			$this->db->select('*');
			$this->db->where('rperiod_status', 1);
			$result['lkp_rperiod_list'] = $this->db->get('lkp_rperiod')->result_array();
			$this->db->select('*');
			$this->db->where('crop_status', 1);
			$result['lkp_crop_list'] = $this->db->get('lkp_crop')->result_array();
			//getting common lkp data from tables end upto here

			$this->load->view('common/header');
			$this->load->view('reporting/avisa_excelupload', $result);		
			$this->load->view('common/footer');
		}else{
			show_404();
		}
	}

	public function insert_indicatordata_excel(){
		$baseurl = base_url();
		date_default_timezone_set("UTC");		
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		$this->load->library('excel');

		$user_id = $this->session->userdata('login_id');

		$form_id = $this->input->post('form_id');
		// $year_id = $this->input->post('year_id');
		$year_val = $this->input->post('year_val');
		$country_val = $this->input->post('country_val');
		$crop_val = $this->input->post('crop_val');
		$rperiod_val = $this->input->post('rperiod_val');

		$this->db->select('max_val')->where('type', 'uploadgroupdata_excel')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$get_max_column_count = $this->db->get('form_field')->row_array();

		if(isset($_FILES['uploadexcel_data']) && $_FILES['uploadexcel_data']['name'] != '') {
			$file_info = pathinfo($_FILES['uploadexcel_data']['name']);
			$file_directory = "upload/survey/";
			$new_file_name = uniqid().$this->session->userdata('login_id').".". $file_info["extension"];
			if(move_uploaded_file($_FILES['uploadexcel_data']["tmp_name"], $file_directory . $new_file_name)){
				$file_type	= PHPExcel_IOFactory::identify($file_directory . $new_file_name);
				$objReader	= PHPExcel_IOFactory::createReader($file_type);
				$objPHPExcel = $objReader->load($file_directory . $new_file_name);
				$column = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();

				if($column == $get_max_column_count['max_val']){
				}else{
					unlink($file_directory.''.$new_file_name);
					echo json_encode(array('status' => 0, 'msg' => 'Invalid number of columns in the excel choosen.'));
					exit();
				}
			}
		}
		
		if(isset($_POST['indicator_comment'])){
			$comment = $_POST['indicator_comment'];
		}else{
			$comment = NULL;
		}

		$time = time();
		$datetime = date('Y-m-d H:i:s');

		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		$insert_array = array();
		$insert_array['data_id'] = $time.'-'.$this->session->userdata('login_id');
		$insert_array['form_id'] = $form_id;
		// $insert_array['year_id'] = $year_id;
		$insert_array['year_id'] = $year_val;
		$insert_array['country_id'] = $country_val;
		$insert_array['crop_id'] = $crop_val;
		$insert_array['rperiod_id'] = $rperiod_val;
		$insert_array['comment'] = $comment;
		
		$this->db->select('GROUP_CONCAT(field_id) as field_ids')->where('type', 'group')->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$get_group_id = $this->db->get('form_field')->row_array();

		$get_group_id_array = explode(",", $get_group_id['field_ids']);

		$this->db->select('GROUP_CONCAT(field_id) as field_ids')->where_in('parent_id', $get_group_id_array)->where('form_id',  $form_id);
		$this->db->where('status', 1);
		$get_group_fields = $this->db->get('form_field')->row_array();
		$get_group_fields_array = explode(",", $get_group_fields['field_ids']);

		$this->db->select('field_id')->where_not_in('field_id', $get_group_fields_array);
		$this->db->where('status', 1)->where('form_id',  $form_id)->where('type !=', 'group')->where('type !=', 'header')->where('type !=', 'uploadgroupdata_excel');
		$non_group_fields = $this->db->get('form_field')->result_array();

		$dataarray = array();
		foreach ($non_group_fields as $key => $value) {				
			$fieldkey = "field_".$value['field_id'];
			$multi_value = array();
			if(isset($_POST[$fieldkey])){
				if(is_array($_POST[$fieldkey])){
					foreach ($_POST[$fieldkey] as $multiplevalue) {
						array_push($multi_value, $multiplevalue);
					}
					$dataarray[$fieldkey] = implode('&#44;', $multi_value);
				}else{
					if($_POST[$fieldkey] == ''){
						$dataarray[$fieldkey] = NULL;
					}else{
						$dataarray[$fieldkey] = $_POST[$fieldkey];
					}
				}
			}else{
				$dataarray[$fieldkey] = NULL;
			}			
		}

		$excel_column_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z');
		if(isset($dataarray['indicator_comment'])) unset($dataarray['indicator_comment']);
		if(count($dataarray) > 0){
			$insert_array['form_data'] = json_encode($dataarray, JSON_UNESCAPED_UNICODE);
		}else{
			$insert_array['form_data'] = NULL;
		}
		$insert_array['user_id'] = $this->session->userdata('login_id');
		$insert_array['ip_address'] = $this->input->ip_address();
		$insert_array['reg_date_time'] = $datetime;
		$insert_array['status'] = 1;

		$query = $this->db->insert('ic_form_data', $insert_array);

		if($query) {
			$this->db->select('field_id')->where('type', 'group')->where('form_id',  $form_id);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$this->db->select('child_id');
    		$this->db->where('type', 'uploadgroupdata_excel');
    		$this->db->where('form_id',  $form_id);
			$this->db->where('status', 1);
    		$get_fields_bygroupid = $this->db->get('form_field')->row_array();

			$get_fields_bygroupid_array = explode(",", $get_fields_bygroupid['child_id']);

			$directory = "upload/survey/";

			$group_table_name = "ic_form_group_data";

			$file_type	= PHPExcel_IOFactory::identify($directory . $new_file_name);
			$objReader	= PHPExcel_IOFactory::createReader($file_type);
			$objPHPExcel = $objReader->load($directory . $new_file_name);
			$column = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();

			$sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			foreach($sheet_data as $ekey => $data){
				if($ekey > 1){
					$groupdata = array();
					$groupdata['group_id'] = time().$ekey.'-'.$this->session->userdata('login_id');
					$groupdata['data_id'] = $insert_array['data_id'];
					$groupdata['form_id'] = $form_id;
					$groupdata['groupfield_id'] = $get_group_id['field_id'];
					$groupdata['dataupload_type'] = 'excel';
					
					$group_data_array = array();
					foreach ($get_fields_bygroupid_array as $gkey => $fieldvalue) {
						$group_field_key = "field_".$fieldvalue;
						$group_data_array[$group_field_key] = $data[$excel_column_array[$gkey]];
					}
					if(count($group_data_array) > 0){
						$groupdata['formgroup_data'] = json_encode($group_data_array, JSON_UNESCAPED_UNICODE);
					}else{
						$groupdata['formgroup_data'] = NULL;
					}
					$groupdata['user_id'] = $this->session->userdata('login_id');
					$groupdata['ip_address'] = $this->input->ip_address();
					$groupdata['reg_date_time'] = $datetime;
					$groupdata['status'] = 1;

					$groupquery = $this->db->insert($group_table_name, $groupdata);
				}
			}
			
			$ajax_message = 'Please go through the excel data and approve it.';

			$this->db->select('field_id, label');
			$this->db->where('status', 1)->where_in('field_id', $get_fields_bygroupid_array)->order_by('slno');
			$get_groupfields = $this->db->get('form_field')->result_array();

			$get_groupdata = $this->db->where('data_id', $insert_array['data_id'])->where('status', 1)->get($group_table_name)->result_array();

			echo json_encode(array(
				'status' => 1,
				'msg' => $ajax_message,
				'get_groupdata' => $get_groupdata,
				'get_groupfields' => $get_groupfields,
				'record_id' => $insert_array['data_id']
			));			
			exit();
		} else {
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}
	}

	public function approve_excel_previewdata()
	{
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}

		$record_id = $this->input->post('recordid');
		$tablename = 'ic_form_data';
		$group_table_name = 'ic_form_group_data';

		$user_role = $this->session->userdata('role');

		if($user_role == 4 || $user_role == 5 || $user_role == 6){
			$update_tabledata = array(
				'status' => 3
			);
		}else{
			$update_tabledata = array(
				'status' => 2
			);
		}
			
		$this->db->where('data_id', $record_id)->where('status', 1);
		$table_query = $this->db->update($tablename, $update_tabledata);

		if($user_role == 4 || $user_role == 5 || $user_role == 6){
			$update_grouptabledata = array(
				'status' => 3
			);
		}else{
			$update_grouptabledata = array(
				'status' => 2
			);
		}

		$this->db->where('data_id', $record_id)->where('status', 1);
		$grouptable_query = $this->db->update($group_table_name, $update_grouptabledata);

		if($table_query == 1 && $grouptable_query == 1){
			echo json_encode(array('status' => 1, 'msg' => 'Approved successfully'));
			exit();
		}else{
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}
	}

	public function delete_groupdata()
	{
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'status' => 0,
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}
		date_default_timezone_set("UTC");

		$recordid = $this->input->post('recordid');
		$group_recordid = $this->input->post('group_recordid');
		$group_table = 'ic_form_group_data';

		$this->db->where('data_id', $this->input->post('recordid'))->where('status !=', 0);
		$check_groudata_count = $this->db->get($group_table)->num_rows();

		$getold_value = $this->db->select('status')->where('group_id', $this->input->post('group_recordid'))->get($group_table)->row_array();

		if(isset($_POST['reason'])){
			$reason = $this->input->post('reason');
		}else{
			$reason = 'Deleted by the user';			
		}

		$update_grouptabledata = array(
			'status' => 0
		);
		$this->db->where('id', $this->input->post('group_recordid'))->where('data_id', $this->input->post('recordid'));
		$grouptable_query = $this->db->update($group_table, $update_grouptabledata);

		if($grouptable_query){

			$insert_log_array = array(
				'editedby' => $this->session->userdata('login_id'),
				'editedfor' => NULL,
				'table_name' => $group_table,
				'table_row_id' => $this->input->post('group_id'),
				'table_field_name' => 'status',
				'old_value' => $getold_value['status'],
				'new_value' => 0,
				'edited_reason' => $reason,
				'updated_date' => date('Y-m-d H:i:s'),
				'ip_address' => $this->input->ip_address(),
				'log_status' => 1
			);

			$query = $this->db->insert('ic_log', $insert_log_array);

			if(!$query){
				$result = array('status' => 0, 'msg' => 'Data updated Successfully and went wrong with log');
			}else{
				echo json_encode(array('status' => 1, 'msg' => 'Group data deleted successfully'));
				exit();
			}
		}else{
			echo json_encode(array('status' => 0, 'msg' => 'Sorry! Something went wrong, please try after some time'));
			exit();
		}
	}

	public function review_data(){
		if($this->session->userdata('login_id') == '' || $this->session->userdata('login_id') == NULL){
			redirect($this->baseurl);
		}

		$form_id = $this->uri->segment('3');

		$year_id = $this->uri->segment('4');
		$country_id = $this->uri->segment('5');
		$crop_id = $this->uri->segment('6');

		if($form_id == '' || $year_id == '' || $country_id == '' || $crop_id == ''){
			show_404();
		}

		$form_details = $this->db->select('id, title, type')->where('id', $form_id)->where('status', 1)->get('form')->row_array();
		$crop_name = $this->db->select('*')->where('crop_id', $crop_id)->where('crop_status', 1)->get('lkp_crop')->row_array();
		$country_name = $this->db->select('*')->where('country_id', $country_id)->where('status', 1)->get('lkp_country')->row_array();
		$year_name = $this->db->select('*')->where('year_id', $year_id)->where('year_status', 1)->get('lkp_year')->row_array();
		$form_field_count = $this->db->where('form_id', $form_id)->where('status', 1)->get('form_field')->num_rows();
		
		if($form_field_count == 0 || $form_details == NULL){
			show_404();
		}

		$this->db->select('*');
		$this->db->where('form_id', $form_id)->where('parent_id IS NULL')->where('parent_value IS NULL');
		$this->db->order_by('slno')->where('status', 1);
		$indicator_fields = $this->db->get('form_field')->result_array();
		foreach ($indicator_fields as $ifkey => $indicatorfield) {
			switch ($indicatorfield['type']) {
				case 'select':
				case 'radio-group':
				case 'checkbox-group':
				case 'number':
					$this->db->select('*');
					$this->db->where('field_id', $indicatorfield['field_id']);
					$this->db->where('status', 1);
					$this->db->order_by('options_order');
					$indicator_fields[$ifkey]['options'] = $this->db->get('form_field_multiple')->result_array();

					$this->db->where('parent_id', $indicatorfield['field_id'])->where('status', 1);
					$icheck_child_fields = $this->db->get('form_field')->num_rows();

					$indicator_fields[$ifkey]['child_count']  = $icheck_child_fields;
					break;
				
				case 'group':
					$this->db->where('parent_id', $indicatorfield['field_id'])->where('parent_value IS NULL')->where('status', 1);
					$this->db->order_by('slno');
					$survey_groupfields = $this->db->get('form_field')->result_array();

					foreach ($survey_groupfields as $gkey => $field) {
						switch ($field['type']) {
							case 'select':
							case 'radio-group':
							case 'checkbox-group':
								$this->db->select('*');
								$this->db->where('field_id', $field['field_id'])->where('status', 1);
								$this->db->order_by('options_order');
								$survey_groupfields[$gkey]['options'] = $this->db->get('form_field_multiple')->result_array();
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

		$result = array('indicator_fields' => $indicator_fields, 'form_details' => $form_details, 'country_name' => $country_name['country_name'], 'crop_name' => $crop_name['crop_name'], 'year_name' => $year_name['year']);

		$result['formtype'] = '';

		$this->db->select('GROUP_CONCAT(form_id) as output_ids');
		$this->db->where('lkp_year', $year_id)->where('output_id IS NULL');
		$this->db->where('relation_status', 1);
		$get_output_ids = $this->db->get('rpt_form_relation')->row_array();

		$output_ids_array = explode(",", $get_output_ids['output_ids']);

		$user_role = $this->session->userdata('role');
		if(($user_role == 6 || $user_role == 5 || $user_role == 4) && in_array($form_id, $output_ids_array)){
			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, lc.crop_name, lcou.country_name');
			$this->db->from('ic_form_data as sur');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			$this->db->join('lkp_crop AS lc', 'sur.crop_id = lc.crop_id');
			$this->db->join('lkp_country AS lcou', 'sur.country_id = lcou.country_id');
			$this->db->where_in('sur.status', array(2,3))->where('form_id', $form_id);
			$this->db->where('year_id', $year_id)->where('sur.country_id', $country_id)->where('sur.crop_id', $crop_id);
			if($user_role == 4){
				$this->db->where('sur.user_id !=', $this->session->userdata('login_id'));
			}
			/*if($user_role == 5){
				$this->db->where('sur.status', 3);
			}*/
			$this->db->order_by('sur.reg_date_time', 'desc');
			$output_data = $this->db->get()->result_array();

			$result['output_data'] = $output_data;

			$this->db->select('field_id, label, type, subtype');
			$this->db->where('status', 1)->where('form_id',  $form_id);
			$this->db->where('type !=', 'group')->where('type !=', 'header')->where('type !=', 'uploadgroupdata_excel');
			$form_fields = $this->db->get('form_field')->result_array();

			$result['form_fields'] = $form_fields;

			/*if($user_role == 4){*/
				$this->db->select('sur.*');
				$this->db->from('ic_form_data as sur');
				$this->db->where_in('sur.status', array(1,2,3))->where('form_id', $form_id);
				$this->db->where('year_id', $year_id)->where('sur.country_id', $country_id)->where('sur.crop_id', $crop_id);
				$this->db->where('sur.user_id', $this->session->userdata('login_id'));
				$this->db->order_by('sur.reg_date_time', 'desc');
				$level2_outputdata = $this->db->get()->row_array();

				if($level2_outputdata == NULL){
					$result['output_fielddata'] = '';
				}else{
					$output_field = "field_".$form_fields[0]['field_id'];

					$level2_outputdata_json = json_decode($level2_outputdata['form_data'], true);
					$result['output_fielddata'] = $level2_outputdata_json[$output_field];
					$result['output_querytype'] = $level2_outputdata['query_status'];
					$result['output_submissiontype'] = $level2_outputdata['status'];
					$result['level2_outputdata'] = $level2_outputdata;
				}
			/*}*/
		}

		if(in_array($form_id, $output_ids_array)){
			$this->db->select('GROUP_CONCAT(form_id) as indicator_ids');
			$this->db->where('lkp_year', $year_id)->where('indicator_id IS NULL');
			$this->db->where('relation_status', 1)->where('output_id', $form_id);
			$get_output_indicators = $this->db->get('rpt_form_relation')->row_array();

			$indicator_ids_array = explode(",", $get_output_indicators['indicator_ids']);

			$indicator_data = array();
			foreach ($indicator_ids_array as $key => $indicator_id) {
				$data = array(
					'form_id' => $indicator_id,
					'year_id' => $year_id,
					'country_id' => $country_id,
					'crop_id' => $crop_id
				);
				$indicator_data[$key]['indicator_info'] = $this->Reporting_model->form_complete_info($data);

				$this->db->select('form_id');
				$this->db->where('relation_status', 1)->where('lkp_year', $year_id);
				$this->db->where('indicator_id', $indicator_id);
				$sub_indicators = $this->db->get('rpt_form_relation')->result_array();

				if(count($sub_indicators) == 0){
					$indicator_data[$key]['sub_indicators_count'] = count($sub_indicators);
					$indicator_data[$key]['sub_indicators_info'] = array();
				}else{
					$sub_indicator_data = array();
					foreach ($sub_indicators as $s_key => $subindicator_id) {
						$data = array(
							'form_id' => $subindicator_id['form_id'],
							'year_id' => $year_id,
							'country_id' => $country_id,
							'crop_id' => $crop_id
						);
						$sub_indicator_data[$s_key]['indicator_info'] = $this->Reporting_model->form_complete_info($data);
					}

					$indicator_data[$key]['sub_indicators_count'] = count($sub_indicators);
					$indicator_data[$key]['sub_indicators_info'] = $sub_indicator_data;
				}
			}

			$result['indicator_data'] = $indicator_data;
			$result['formtype'] = 'output';
		}

		$this->db->where('status', 2)->where('form_id', $form_id);
		$this->db->where('year_id', $year_id)->where('country_id', $country_id)->where('crop_id', $crop_id)->where('user_id', $this->session->userdata('login_id'))->where('nothingto_report', 1);
		$result['nothingto_report'] = $this->db->get('ic_form_data')->num_rows();

		$this->load->view('common/header');
		if($result['formtype'] == 'output'){
			$this->load->view('reporting/review_data', $result);
		}else{
			$this->load->view('reporting/online_data_submission', $result);
		}		
		$this->load->view('common/footer');
	}
}