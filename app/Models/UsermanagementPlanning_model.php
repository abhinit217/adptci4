<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsermanagementPlanning_model extends CI_Model {
    
	public function __construct() {
		parent::__construct();
		$this->load->library('session');		
	}

    //complete pos list with output, indicator, subindicator
    public function po_list($year){
        $this->db->select('*');
        $this->db->where('po_status', 1);
        $po_list = $this->db->get('lkp_po')->result_array();
        
        foreach ($po_list as $key => $po_val) {
            $this->db->select('GROUP_CONCAT(form_id) as outputid');
            $this->db->where('rel.relation_status', 1)->where('rel.form_type', 1);
            $this->db->where('rel.lkp_po_id', $po_val['po_id'])->where('rel.output_id IS NULL')->where('rel.indicator_id IS NULL')->where('lkp_year', $year);
            $output_list = $this->db->get('rpt_form_relation as rel')->row_array();

            $output_list_array = explode(",", $output_list['outputid']);

            $this->db->select('*');
            $this->db->where('status', 1)->where('type', 1)->where_in('id', $output_list_array);
            $outputs = $this->db->get('form')->result_array();

            foreach ($outputs as $o_key => $output_val) {
                $this->db->select('GROUP_CONCAT(form_id) as indicator_id');
                $this->db->where('rel.relation_status', 1)->where('rel.form_type', 2);
                $this->db->where('rel.lkp_po_id', $po_val['po_id'])->where('output_id', $output_val['id'])->where('rel.indicator_id IS NULL')->where('lkp_year', $year);
                $indicator_list = $this->db->get('rpt_form_relation as rel')->row_array();

                $indicator_list_array = explode(",", $indicator_list['indicator_id']);

                $this->db->select('*');
                $this->db->where('status', 1)->where('type', 2)->where_in('id', $indicator_list_array);
                $this->db->order_by('slno');
                $indicators = $this->db->get('form')->result_array();

                foreach ($indicators as $i_key => $ind_val) {
                    $this->db->select('GROUP_CONCAT(form_id) as subindicator_id');
                    $this->db->where('rel.relation_status', 1)->where('rel.form_type', 3);
                    $this->db->where('rel.lkp_po_id', $po_val['po_id'])->where('output_id', $output_val['id'])->where('rel.indicator_id', $ind_val['id'])->where('lkp_year', $year);
                    $subindicator_list = $this->db->get('rpt_form_relation as rel')->row_array();

                    $subindicator_list_array = explode(",", $subindicator_list['subindicator_id']);

                    $this->db->select('*');
                    $this->db->where('status', 1)->where('type', 3)->where_in('id', $subindicator_list_array);
                    $this->db->order_by('slno');
                    $subindicators = $this->db->get('form')->result_array();


                    $indicators[$i_key]['subindicator_list'] = $subindicators;
                }
                $outputs[$o_key]['indicator_list'] = $indicators;
            }
            $po_list[$key]['output_list'] = $outputs;
        }

        return $po_list;
    }


    public function user_po_list($data){
        $this->db->select('*');
        $this->db->where('po_status', 1)->where_in('po_id', $data['user_pos']);
        $po_list = $this->db->get('lkp_po')->result_array();
        
        foreach ($po_list as $key => $po_val) {
            $this->db->select('GROUP_CONCAT(form_id) as outputid');
            $this->db->where('rel.relation_status', 1)->where('rel.form_type', 1);
            $this->db->where('rel.lkp_po_id', $po_val['po_id'])->where('rel.output_id IS NULL')->where('rel.indicator_id IS NULL')->where('lkp_year', $data['year']);
            //$this->db->where_in('form_id', $data['user_outputs']);
            $output_list = $this->db->get('rpt_form_relation as rel')->row_array();

            $output_list_array = explode(",", $output_list['outputid']);

            $this->db->select('*');
            $this->db->where('status', 1)->where('type', 1)->where_in('id', $output_list_array);
            $outputs = $this->db->get('form')->result_array();

            foreach ($outputs as $o_key => $output_val) {
                $outputs[$o_key]['output_budget'] = 0;
                $outputs[$o_key]['field_count'] = $this->db->where('form_id', $output_val['id'])->where('status', 1)->get('form_field')->num_rows();

                $this->db->select('field_id, label, type, subtype');
                $this->db->where('status', 1)->where('form_id',  $output_val['id']);
                $this->db->where('type !=', 'group')->where('type !=', 'header')->where('type !=', 'uploadgroupdata_excel');
                $form_fields = $this->db->get('form_field')->result_array();
                
                switch ($data['purpose']) {
                    case 'approval':
                        $this->db->select('sur.*');
                        $this->db->from('ic_form_data as sur');
                        $this->db->where('sur.status', 2)->where('form_id', $output_val['id']);
                        $this->db->where('year_id', $this->input->post('year'));
                        $this->db->where('sur.country_id', $this->input->post('country'));
                        $this->db->where('sur.crop_id', $this->input->post('crop'));
                        $this->db->where('sur.user_id', $this->session->userdata('login_id'));
                        $this->db->order_by('sur.reg_date_time', 'desc');
                        $level2_outputdata = $this->db->get();

                        if($level2_outputdata->num_rows() > 0) {
                            $level2_outputdata = $level2_outputdata->row_array();
                            $output_field = "field_".$form_fields[0]['field_id'];

                            $level2_outputdata_json = json_decode($level2_outputdata['form_data'], true);
                            $outputs[$o_key]['report'] = $level2_outputdata_json[$output_field];
                            $outputs[$o_key]['query_status'] = $level2_outputdata['query_status'];
                        } else {
                            $outputs[$o_key]['report'] = null;
                        }
                    break;

                    case 'review':
                        $this->db->select('sur.*, concat(user.first_name," ", user.last_name) as username');
                        $this->db->from('ic_form_data as sur');
                        $this->db->join('tbl_users as user', 'user.user_id = sur.user_id');
                        $this->db->where('sur.status', 2)->where('form_id', $output_val['id']);
                        $this->db->where('year_id', $this->input->post('year'));
                        $this->db->where('sur.country_id', $this->input->post('country'));
                        $this->db->where('sur.crop_id', $this->input->post('crop'));
                        $this->db->order_by('sur.reg_date_time', 'desc');
                        $level2_outputdata = $this->db->get();

                        if($level2_outputdata->num_rows() > 0) {
                            $level2_outputdata = $level2_outputdata->result_array();
                            $output_field = "field_".$form_fields[0]['field_id'];

                            $outputdata_review = array();
                            foreach ($level2_outputdata as $okey => $outputdata) {
                                $level2_outputdata_json = json_decode($outputdata['form_data'], true);
                                $outputdata_review[$okey]['data_id'] = $outputdata['data_id'];
                                $outputdata_review[$okey]['report'] = $level2_outputdata_json[$output_field];
                                $outputdata_review[$okey]['query_status'] = $outputdata['query_status'];
                                $outputdata_review[$okey]['username'] = $outputdata['username'];
                            }
                            $outputs[$o_key]['report'] = $outputdata_review;
                        } else {
                            $outputs[$o_key]['report'] = array();
                        }
                    break;
                }
                    

                $this->db->select('GROUP_CONCAT(form_id) as indicator_id');
                $this->db->where('rel.relation_status', 1)->where('rel.form_type', 2);
                $this->db->where('rel.lkp_po_id', $po_val['po_id'])->where('output_id', $output_val['id'])->where('rel.indicator_id IS NULL')->where('lkp_year', $data['year']);
                //$this->db->where_in('form_id', $data['user_indicators']);
                $indicator_list = $this->db->get('rpt_form_relation as rel')->row_array();

                $indicator_list_array = explode(",", $indicator_list['indicator_id']);

                $this->db->select('*');
                $this->db->where('status', 1)->where('type', 2)->where_in('id', $indicator_list_array);
                $this->db->order_by('slno');
                $indicators = $this->db->get('form')->result_array();

                foreach ($indicators as $i_key => $ind_val) {
                    $this->db->where('indicator_id', $ind_val['id'])->where('year_id', $data['year'])->where('status', 2);
                    $this->db->where('country_id', $data['country']);
                    $this->db->where('crop_id', $data['crop']);
                    $indicators[$i_key]['planning_uploadcount'] = $this->db->get('ic_planning_data')->row_array();
                }
                $outputs[$o_key]['indicator_list'] = $indicators;

                $this->db->select('GROUP_CONCAT(form_id) as indicator_id');
                $this->db->where('rel.relation_status', 1)->where('rel.form_type', 4);
                $this->db->where('rel.lkp_po_id', $po_val['po_id'])->where('output_id', $output_val['id'])->where('rel.indicator_id IS NULL')->where('lkp_year', $data['year']);
                $activity_list = $this->db->get('rpt_form_relation as rel')->row_array();

                $activity_list_array = explode(",", $activity_list['indicator_id']);

                $this->db->select('*');
                $this->db->where('status', 1)->where('type', 4)->where_in('id', $activity_list_array);
                $this->db->order_by('slno');
                $activities = $this->db->get('form')->result_array();
                foreach ($activities as $a_key => $act_val) {
                    $this->db->where('activity_id', $act_val['id'])->where('year_id', $data['year'])->where('status', 2);
                    $this->db->where('country_id', $data['country']);
                    $this->db->where('crop_id', $data['crop']);
                    $activities[$a_key]['subacticity_uploadcount'] = $this->db->get('ic_subactivity_data')->num_rows();

                    $this->db->select('GROUP_CONCAT(personname) as personname, IFNULL(SUM(sub_activity_budget), 0) as budget');
                    $this->db->where('activity_id', $act_val['id'])->where('year_id', $data['year'])->where('status', 2);
                    $this->db->where('country_id', $data['country']);
                    $this->db->where('crop_id', $data['crop']);
                    $subactivity_budet = $this->db->get('ic_subactivity_data')->row_array();

                    $activities[$a_key]['subactivity_budet'] = $subactivity_budet['budget'];
                    $activities[$a_key]['subactivity_personname'] = $subactivity_budet['personname'];

                    if($subactivity_budet != NULL){
                        $outputs[$o_key]['output_budget'] += $subactivity_budet['budget'];
                    }
                }

                $outputs[$o_key]['activities_list'] = $activities;
            }
            $po_list[$key]['output_list'] = $outputs;
        }
        return $po_list;
    }

    public function update_permissions()
    {
        date_default_timezone_set("UTC");
        $assigingstatus = $_POST['assigingstatus'];
        $user_id = $_POST['userid'];

        $update_data = array(
            'status' => ($assigingstatus == 1) ? 0 : 1
        );

        $this->db->where('user_id', $user_id);
        $updatequery = $this->db->update('tbl_reporting_user', $update_data);

        if(!$updatequery){
            return false;
        }else{
            return true;
        }
    }
}
