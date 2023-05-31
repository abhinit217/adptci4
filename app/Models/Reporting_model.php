<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporting_model extends CI_Model {
    
	public function __construct() {
		parent::__construct();
		$this->load->library('session');		
	}

   	public function form_complete_info($data){
   		$this->db->select('field_id')->where('type', 'group')->where('form_id',  $data['form_id']);
		$this->db->where('status', 1);
		$check_group_fields = $this->db->get('form_field')->num_rows();

		if($check_group_fields > 0){
			$this->db->select('GROUP_CONCAT(field_id) as field_ids');
			$this->db->where('type', 'group')->where('form_id',  $data['form_id']);
			$this->db->where('status', 1);
			$get_group_id = $this->db->get('form_field')->row_array();

			$get_group_id_array = explode(",", $get_group_id['field_ids']);

			$this->db->select('child_id');
			$this->db->where('form_id',  $data['form_id']);
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
			$this->db->where('status', 1)->where('form_id',  $data['form_id']);
			$this->db->where_not_in('field_id', $get_group_fields_array);
			$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, lc.crop_name, lcou.country_name');
			$this->db->from('ic_form_data as sur');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			$this->db->join('lkp_crop AS lc', 'sur.crop_id = lc.crop_id');
			$this->db->join('lkp_country AS lcou', 'sur.country_id = lcou.country_id');
			$this->db->where('sur.status', 3);
			$this->db->where('year_id', $data['year_id']);
			$this->db->where('form_id', $data['form_id']);
			// $this->db->where('sur.country_id', $data['country_id'])->where('sur.crop_id', $data['crop_id']);
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();

			$group_table = "ic_form_group_data";

			foreach ($form_data as $dkey => $data) {
				$this->db->where('data_id', $data['data_id']);
				$this->db->where('status', 3);
				$form_data[$dkey]['groupdata'] = $this->db->get('ic_form_group_data')->result_array();
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
		}else{
			$this->db->select('field_id, label, type, subtype');
			$this->db->where('status', 1)->where('form_id',  $data['form_id'])->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();

			$this->db->select('sur.*, CONCAT(u.first_name, " ", u.last_name) as username, lc.crop_name, lcou.country_name');
			$this->db->from('ic_form_data as sur');
			$this->db->join('tbl_users as u', 'sur.user_id = u.user_id');
			$this->db->join('lkp_crop AS lc', 'sur.crop_id = lc.crop_id');
			$this->db->join('lkp_country AS lcou', 'sur.country_id = lcou.country_id');
			$this->db->where('sur.status', 3);
			$this->db->where('year_id', $data['year_id']);
			$this->db->where('form_id', $data['form_id']);
			// $this->db->where('sur.country_id', $data['country_id'])->where('sur.crop_id', $data['crop_id']);
			$this->db->order_by('sur.reg_date_time', 'desc');
			$form_data = $this->db->get()->result_array();

			$result = array('form_fields' => $form_fields, 'form_data' => $form_data);		
		}

		$result['form_details'] = $this->db->where('id', $data['form_id'])->get('form')->row_array();

		return $result;
   	}
	public function get_form_fields($data){
	   		$this->db->select('*');
			$this->db->where('status', 1)->where('form_id',  $data);
			$this->db->where('type !=', 'group')->where('type !=', 'uploadgroupdata_excel');
			$this->db->order_by('slno');
			$form_fields = $this->db->get('form_field')->result_array();
			$result['form_fields'] = $form_fields;
			return $result;
	}

	public function get_year_name_byId($year_id){
		$this->db->select('year');
		$this->db->where('year_status', 1)->where('year_id',  $year_id);
		$result = $this->db->get('lkp_year')->row_array();
		return $result['year'];
	}

	public function get_rperiod_name_byId($rperiod_id){
		$this->db->select('rperiod_name');
		$this->db->where('rperiod_status', 1)->where('rperiod_id',  $rperiod_id);
		$result = $this->db->get('lkp_rperiod')->row_array();
		return $result['rperiod_name'];
	}

	public function get_user_name_byId($user_id){
		$this->db->select('first_name,last_name');
		$this->db->where('status', 1)->where('user_id',  $user_id);
		$result_u = $this->db->get('tbl_users')->row_array();
		$user_name = $result_u['first_name']." ".$result_u['last_name'];

		return $user_name;
	}

	public function get_details_byIds($data){
		$this->db->select('year');
		$this->db->where('year_status', 1)->where_in('year_id',  $data['year_id']);
		$result_year = $this->db->get('lkp_year')->row_array();

		$this->db->select('rperiod_name');
		$this->db->where('rperiod_status', 1)->where('rperiod_id',  $data['rp_id']);
		$result_rp = $this->db->get('lkp_rperiod')->row_array();

		$this->db->select('country_name');
		$this->db->where('status', 1)->where('country_id',  $data['country_id']);
		$result_c = $this->db->get('lkp_country')->row_array();

		$this->db->select('crop_name');
		$this->db->where('crop_status', 1)->where('crop_id',  $data['crop_id']);
		$result_crp = $this->db->get('lkp_crop')->row_array();

		if(isset($data['status'])){
			switch ($data['status']) {
				case '2':
					$data_status="Data Submitted";
					break;
				case '3':
					$data_status="Data Approved";
					break;
				case '4':
					$data_status="Data Rejected";
					break;
				
				default:
					$data_status= "N/A";
					break;
			}
		}
		if($data['nothing_to_report'] ==1 ){
			$nreport ="User has selected Nothing to Report";
		}else{
			$nreport ="";
		}

		$data = array(
			'Reporting year' => $result_year['year'],
			'Reporting Period' => $result_rp['rperiod_name'],
			'Country' => $result_c['country_name'],
			'Crop' => $result_crp['crop_name'],
			'Data Status' => $data_status,
			'Submitted by' => $this->get_user_name_byId($data['user_id']),
			'Submitted on' => $data['reg_date_time'],
			'Approved by' => $this->get_user_name_byId($data['approved_by']),
			'Approved on' => $data['approved_date'],
			'Rejected by' => $this->get_user_name_byId($data['rejected_by']),
			'Rejected on' => $data['rejected_date'],
			'Nothing to report' => $nreport,
			'Data Id' => $data['data_id']
		);
		return $data;
	}

}
