<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usermanagement_model extends CI_Model {
    
	public function __construct() {
		parent::__construct();
		$this->load->library('session');		
	}

    //complete pos list with output, indicator, subindicator
    public function program_list($year){
        $this->db->select('*');
        $this->db->where('status', 1);
        $program_list = $this->db->get('tbl_program')->result_array();
        
        foreach ($program_list as $key => $po_val) {
            $this->db->select('GROUP_CONCAT(form_id) as clusterid');
            $this->db->where('rel.relation_status', 1)->where('rel.form_type', 1);
            $this->db->where('rel.lkp_program_id', $po_val['prog_id'])->where('rel.lkp_cluster_id IS NULL')->where('rel.indicator_id IS NULL')->where('lkp_year', $year);
            $cluster_list = $this->db->get('rpt_form_relation as rel')->row_array();

            $cluster_list_array = explode(",", $cluster_list['clusterid']);

            $this->db->select('*');
            $this->db->where('cluster_status', 1)->where_in('cluster_id', $cluster_list_array);
            $clusters = $this->db->get('tbl_cluster')->result_array();

            foreach ($clusters as $o_key => $cluster_val) {
                $this->db->select('GROUP_CONCAT(form_id) as indicator_id');
                $this->db->where('rel.relation_status', 1)->where('rel.form_type', 2);
                $this->db->where('rel.lkp_program_id', $po_val['prog_id'])->where('lkp_cluster_id', $cluster_val['cluster_id'])->where('rel.indicator_id IS NULL')->where('lkp_year', $year);
                $indicator_list = $this->db->get('rpt_form_relation as rel')->row_array();

                $indicator_list_array = explode(",", $indicator_list['indicator_id']);

                $this->db->select('*');
                $this->db->where('status', 1)->where('type', 2)->where_in('id', $indicator_list_array);
                $this->db->order_by('slno');
                $indicators = $this->db->get('form')->result_array();

                foreach ($indicators as $i_key => $ind_val) {
                    $this->db->select('GROUP_CONCAT(form_id) as subindicator_id');
                    $this->db->where('rel.relation_status', 1)->where('rel.form_type', 3);
                    $this->db->where('rel.lkp_program_id', $po_val['prog_id'])->where('lkp_cluster_id', $cluster_val['cluster_id'])->where('rel.indicator_id', $ind_val['id'])->where('lkp_year', $year);
                    $subindicator_list = $this->db->get('rpt_form_relation as rel')->row_array();

                    $subindicator_list_array = explode(",", $subindicator_list['subindicator_id']);

                    $this->db->select('*');
                    $this->db->where('status', 1)->where('type', 3)->where_in('id', $subindicator_list_array);
                    $this->db->order_by('slno');
                    $subindicators = $this->db->get('form')->result_array();


                    $indicators[$i_key]['subindicator_list'] = $subindicators;
                }
                $clusters[$o_key]['indicator_list'] = $indicators;
            }
            $program_list[$key]['cluster_list'] = $clusters;
        }

        return $program_list;
    }

    public function user_program_list_d($data){
        $this->db->select('*');
        $this->db->where('status', 1)->where_in('prog_id', $data['user_programs']);
        $program_list = $this->db->get('tbl_program')->result_array();
        
        foreach ($program_list as $key => $po_val) {
            $this->db->select('*');
            $this->db->where('cluster_status', 1)->where_in('cluster_id', $data['user_clusters']);
            $clusters = $this->db->get('tbl_cluster')->result_array();

            foreach ($clusters as $o_key => $cluster_val) {
               
                if($data['type'] == "view"){
                    $this->db->select('GROUP_CONCAT(form_id) as indicator_id');
                    $this->db->where('rel.relation_status', 1)->where('rel.form_type', 2);
                    $this->db->where('rel.lkp_program_id', $po_val['prog_id'])->where('lkp_cluster_id', $cluster_val['cluster_id'])->where('rel.indicator_id IS NULL')->where('lkp_year', $data['year']);
                    $indicator_list = $this->db->get('rpt_form_relation as rel')->row_array();

                    $indicator_list_array = explode(",", $indicator_list['indicator_id']);

                    $this->db->select('*');
                    $this->db->where('status', 1)->where('type', 2)->where_in('id', $indicator_list_array);
                    $this->db->order_by('slno');
                    $indicators = $this->db->get('form')->result_array();
                }else{
                    $this->db->select('*');
                    $this->db->where('status', 1)->where('type', 2)->where_in('id', $data['user_indicators']);
                    $this->db->order_by('slno');
                    $indicators = $this->db->get('form')->result_array();
                }

                foreach ($indicators as $i_key => $ind_val) {
                    $indicators[$i_key]['field_count'] = $this->db->where('form_id', $ind_val['id'])->where('status', 1)->get('form_field')->num_rows();

                    $this->db->select('GROUP_CONCAT(form_id) as subindicator_id');
                    $this->db->where('rel.relation_status', 1)->where('rel.form_type', 3);
                    $this->db->where('rel.lkp_program_id', $po_val['prog_id'])->where('lkp_cluster_id', $cluster_val['cluster_id'])->where('rel.indicator_id', $ind_val['id'])->where('lkp_year', $data['year']);
                    $this->db->where_in('form_id', $data['user_subindicators']);
                    $subindicator_list = $this->db->get('rpt_form_relation as rel')->row_array();

                    $subindicator_list_array = explode(",", $subindicator_list['subindicator_id']);

                    $this->db->select('*');
                    $this->db->where('status', 1)->where('type', 3)->where_in('id', $subindicator_list_array);
                    $this->db->order_by('slno');
                    $subindicators = $this->db->get('form')->result_array();
                    foreach ($subindicators as $s_key => $subind) {
                        $subindicators[$s_key]['field_count'] = $this->db->where('form_id', $subind['id'])->where('status', 1)->get('form_field')->num_rows();
                    }

                    $indicators[$i_key]['subindicator_list'] = $subindicators;
                }
                $clusters[$o_key]['indicator_list'] = $indicators;

                $this->db->select('GROUP_CONCAT(form_id) as indicator_id');
                $this->db->where('rel.relation_status', 1)->where('rel.form_type', 4);
                $this->db->where('rel.lkp_program_id', $po_val['prog_id'])->where('lkp_cluster_id', $cluster_val['cluster_id'])->where('rel.indicator_id IS NULL')->where('lkp_year', $data['year']);
                $activity_list = $this->db->get('rpt_form_relation as rel')->row_array();

                $activity_list_array = explode(",", $activity_list['indicator_id']);

                $this->db->select('*');
                $this->db->where('status', 1)->where('type', 4)->where_in('id', $activity_list_array);
                $this->db->order_by('slno');
                $activities = $this->db->get('form')->result_array();

                $clusters[$o_key]['activities_list'] = $activities;
            }
            $program_list[$key]['cluster_list'] = $clusters;
        }
        return $program_list;
    }

    public function get_county_name_byID($county_id){
		$this->db->select('county_name');
		$this->db->where('county_status', 1);
		$this->db->where('county_id', $county_id);
		$county_name = $this->db->get('lkp_county')->row_array();
		return $county_name['county_name'];
	}

    public function user_program_list($data){
        if(isset($data['indicator']) && $data['indicator'] != NULL){
            unset($data['user_programs']);
            unset($data['user_clusters']);
            $this->db->select('rel.*');
            $this->db->where('rel.form_type', 2);
            $this->db->where('rel.form_id', $data['indicator']);
            $rpt_relation_list = $this->db->get('rpt_form_relation as rel')->result_array();
            foreach ($rpt_relation_list as $rpt_key => $rpt_relation) {
                $data['user_programs'][0]=$rpt_relation['lkp_program_id'];
                $data['user_clusters'][0]=$rpt_relation['lkp_cluster_id'];
            }
        }
        $this->db->select('*');
        $this->db->where('status', 1)->where_in('prog_id', $data['user_programs']);
        $program_list = $this->db->get('tbl_program')->result_array();
        
        $this->db->select('*');
        $this->db->where('cluster_status', 1)->where_in('cluster_id', $data['user_clusters']);
        $clusters = $this->db->get('tbl_cluster')->result_array();
        
        foreach ($program_list as $key => $po_val) {
            /*$this->db->select('GROUP_CONCAT(form_id) as outputid');
            $this->db->where('rel.relation_status', 1)->where('rel.form_type', 1);
            $this->db->where('rel.lkp_program_id', $po_val['prog_id'])->where('rel.lkp_cluster_id IS NULL')->where('rel.indicator_id IS NULL')->where('lkp_year', $data['year']);
            $cluster_list = $this->db->get('rpt_form_relation as rel')->row_array();

            $cluster_list_array = explode(",", $cluster_list['outputid']);*/


            foreach ($clusters as $o_key => $cluster_val) {
                $indicator_list_array = array();
                $clusters[$o_key]['field_count'] = $this->db->where('form_id', $cluster_val['cluster_id'])->where('status', 1)->get('form_field')->num_rows();
                $actual_count=0;
                if($cluster_val['cluster_id']==7){
                    $this->db->select('*');
                    $this->db->where('form_id', 14)->where_in('status', [2,3]);
                    $records_list = $this->db->get('ic_form_data')->result_array();
                    foreach ($records_list as $r_key => $records_val) {
                        $temp_value=0;
                        $records_val_json = json_decode($records_val['form_data'], true);
                        $field_id = "field_92";
                        $temp_value=0;
                        if(isset($records_val_json[$field_id])){
                            $actual_count++;
                        }
                    }
                    $clusters[$o_key]['14_actual_count'] = $actual_count;
                    $clusters[$o_key]['14_record_count'] = $this->db->where('form_id', 14)->where_in('status', [2,3])->get('ic_form_data')->num_rows();
                }
                $this->db->select('GROUP_CONCAT(form_id) as indicator_id');
                $this->db->where('rel.indicator_id', NULL)->where('rel.relation_status', 1)->where('rel.form_type', 2);
                $this->db->where('rel.lkp_program_id', $po_val['prog_id'])->where('lkp_cluster_id', $cluster_val['cluster_id'])->where('rel.indicator_id IS NULL')->where('lkp_year', $data['year']);
                //$this->db->where_in('form_id', $data['user_indicators']);
                $indicator_list = $this->db->get('rpt_form_relation as rel')->row_array();
                if(isset($data['indicator']) && $data['indicator'] != NULL){
                    array_push($indicator_list_array,$data['indicator']);
                }else{
                    $indicator_list_array = explode(",", $indicator_list['indicator_id']);
                }
                 // indicators list with out user based
                $this->db->select('f.*');
                $this->db->where('f.status', 1)->where('f.type', 2)->where_in('f.id', $indicator_list_array);
                $this->db->order_by('f.slno');
                $indicators = $this->db->get('form as f')->result_array();

                foreach ($indicators as $i_key => $ind_val) {
                    $actual_count =0;
                    $target_count =0;
                    // $indicators[$i_key]['field_count'] = $this->db->where('form_id', $ind_val['id'])->where('status', 1)->get('form_field')->num_rows();
                    $indicators[$i_key]['record_count'] = $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3])->get('ic_form_data')->num_rows();
                    // $indicators[$i_key]['record_count'] = $this->db->where('form_id', $ind_val['id'])->where('status', 2)->get('ic_form_data')->num_rows();
                    //getting derived inds data
                    $derived_inds = array();
                    $this->db->select('*');
                    $this->db->where_in('year_id', $data['year']);
                    $this->db->where('status', 1)->where('survey_id', $ind_val['id']);
                    
                    $derived_inds_list = $this->db->get('tbl_derived_inds')->result_array();
                    foreach ($derived_inds_list as $di_key => $derived_indsdata) {
                        $actual_count=0;
                        $derived_inds[$di_key]['d_ind_id'] = $derived_indsdata['derived_id'];
                        $derived_inds[$di_key]['d_title'] = $derived_indsdata['d_title'];
                        $derived_inds[$di_key]['d_target'] = $derived_indsdata['target'];
                        switch ($derived_indsdata['derived_id']) {
                            case '27_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_145";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '27_2':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_group_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['formgroup_data'], true);
                                    $field_id = "field_165";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '98_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_939";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '98_2':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_941";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '98_1':
                            //test sample
                            $this->db->select('*');
                            $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                            $records_list = $this->db->get('ic_form_data')->result_array();
                            foreach ($records_list as $r_key => $records_val) {
                                $temp_value=0;
                                $records_val_json = json_decode($records_val['form_data'], true);
                                $field_id = "field_939";
                                if(isset($records_val_json[$field_id])){
                                    $actual_count++;
                                }
                            }
                            break;

                            case '98_2':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_941";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){                                        
                                        $temp_value=$records_val_json[$field_id];
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '94_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {                                   
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_900";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '94_2':
                                //test sample
                                $actual_count = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', 901)->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                break;

                            case '99_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_947";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '99_2':
                                $actual_count = $this->db->where('form_id', $ind_val['id'])->where('crop_id !=', NULL)->where_in('status', [2,3])->get('ic_form_data')->num_rows();
                                break;

                            case '99_3':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_948";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){                                        
                                        $temp_value=$records_val_json[$field_id];
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '87_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_832";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '87_2':
                                // $actual_count = $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                $actual_count=0;
                                $temp_count=0;
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_group_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['formgroup_data'], true);
                                    $field_id = "field_838";
                                    if(isset($records_val_json[$field_id])){
                                        $temp_value=0;
                                        $temp_count = $records_val_json[$field_id];
                                        $actual_count= $actual_count + $temp_count;
                                    }
                                    $field_id = "field_839";
                                    if(isset($records_val_json[$field_id])){
                                        $temp_value=0;
                                        $temp_count = $records_val_json[$field_id];
                                        $actual_count= $actual_count + $temp_count;
                                    }
                                }
                                break;

                            case '87_3':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_840";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){                                        
                                        $temp_value=$records_val_json[$field_id];
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '87_4':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_841";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){                                        
                                        $temp_value=$records_val_json[$field_id];
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '87_5':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_842";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){                                        
                                        $temp_value=$records_val_json[$field_id];
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '87_6':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_843";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){                                        
                                        $temp_value=$records_val_json[$field_id];
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '82_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_790";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '82_2':
                                $actual_count = $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                break;

                            case '82_3':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_798";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){                                        
                                        $temp_value=$records_val_json[$field_id];
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '82_4':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_799";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){                                        
                                        $temp_value=$records_val_json[$field_id];
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '82_5':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_800";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){                                        
                                        $temp_value=$records_val_json[$field_id];
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '82_6':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_801";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){                                        
                                        $temp_value= round($records_val_json[$field_id],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                $actual_count= round($actual_count,2);
                                break;

                            case '76_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_761";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '76_2':
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_763";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){
                                        $temp_value= round($records_val_json[$field_id],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '14_1':
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $ic_form_datalist = $this->db->get('ic_form_data')->result_array();
                                foreach ($ic_form_datalist as $ifd_key => $data_val) {
                                    $records_val_json = json_decode($data_val['form_data'], true);
                                    if(isset($records_val_json["field_88"])){
                                        $one_field_value = $records_val_json["field_88"];
                                        if($one_field_value=="Yes")
                                        {
                                            $actual_count++;
                                        }
                                    } 
                                    if(isset($records_val_json["field_91"])){
                                        $two_field_value = $records_val_json["field_91"];
                                        if($two_field_value=="Yes"){
                                            $actual_count++;
                                        }
                                    }
                                    if(isset($records_val_json["field_94"])){
                                        $three_field_value = $records_val_json["field_94"];
                                        if( $three_field_value=="Yes" ){
                                            $actual_count++;
                                        }
                                    }                                    
                                }
                                break;

                            // case '14_2':
                            //     $this->db->select('*');
                            //     $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                            //     $records_list = $this->db->get('ic_form_data')->result_array();
                            //     foreach ($records_list as $r_key => $records_val) {
                            //         $temp_value=0;
                            //         $records_val_json = json_decode($records_val['form_data'], true);
                            //         $field_id = "field_763";
                            //         $temp_value=0;
                            //         if(isset($records_val_json[$field_id])){
                            //             $temp_value= round($records_val_json[$field_id],2);
                            //             $actual_count= $actual_count+$temp_value;
                            //         }
                            //     }
                            //     break;

                            case '170_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_1277";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '170_2':
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_group_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['formgroup_data'], true);
                                    $field_id = "field_1294";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){
                                        $temp_value= round($records_val_json[$field_id],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '170_3':
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id1 = "field_1282";
                                    $temp_value1=0;
                                    if(isset($records_val_json[$field_id1])){
                                        $temp_value= round($records_val_json[$field_id1],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                    $field_id2 = "field_1283";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id2])){
                                        $temp_value= round($records_val_json[$field_id2],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                    $field_id3 = "field_1284";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id3])){
                                        $temp_value= round($records_val_json[$field_id3],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                    $field_id4 = "field_1285";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id4])){
                                        $temp_value= round($records_val_json[$field_id4],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                    $field_id5 = "field_1286";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id5])){
                                        $temp_value= round($records_val_json[$field_id5],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                    $field_id6 = "field_1287";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id6])){
                                        $temp_value= round($records_val_json[$field_id6],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                    $field_id7 = "field_1288";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id7])){
                                        $temp_value= round($records_val_json[$field_id7],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                    $field_id8 = "field_1289";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id8])){
                                        $temp_value= round($records_val_json[$field_id8],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '175_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_1312";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '175_2':
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_1309";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '177_1':
                                //test sample
                                $actual_count = $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                break;

                            case '177_2':
                                $user_indicators = array();
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_group_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['formgroup_data'], true);
                                    $field_id = "field_1370";
                                    if(isset($records_val_json[$field_id])){
                                        $data_array = explode("&#44;", $records_val_json[$field_id]);
                                        // $actual_count = $actual_count+ count($data_array);
                                        $user_indicators = array_merge($user_indicators, $data_array);
                                    }
                                }
                                $actual_count = count(array_unique($user_indicators));
                                break;

                            
                            case '181_1':
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $data_array = array();
                                    $actual_count2 =0;
                                    unset($data_array); 
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $check_field_id = "field_1912";
                                    if(isset($records_val_json[$check_field_id])){
                                        $data_array = explode("&#44;", $records_val_json[$check_field_id]);
                                    }
                                    if(in_array('Breeder seed', $data_array)){
                                        $field_id1 = "field_1409";
                                        $field_id2 = "field_1410";
                                        $field_id3 = "field_1411";
                                        $field_id4 = "field_1412";
                                        $field_id5 = "field_1444";
                                        $field_id6 = "field_1413";
                                        $field_id7 = "field_1414";
                                        $kgt_field_id = "field_1415";
                                        
                                        if(isset($records_val_json[$field_id1])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id1];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id2])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id2];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id3])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id3];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id4])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id4];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id5])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id5];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id6])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id6];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id7])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id7];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$kgt_field_id])){
                                            if($records_val_json[$kgt_field_id]=="Tonnes"){
                                                $actual_count2 = $actual_count2*1000;
                                            }                                            
                                        }
                                        $actual_count= $actual_count+$actual_count2;
                                    }                                    
                                }
                                $actual_count = round($actual_count ,2);
                                break;

                            case '181_2':
                                
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $data_array = array();
                                    $actual_count2 =0;
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $check_field_id = "field_1912";
                                    if(isset($records_val_json[$check_field_id])){
                                        $data_array = explode("&#44;", $records_val_json[$check_field_id]);
                                    }
                                    if(in_array('Foundation seed', $data_array)){
                                        $field_id1 = "field_1417";
                                        $field_id2 = "field_1418";
                                        $field_id3 = "field_1419";
                                        $field_id4 = "field_1420";
                                        $field_id5 = "field_1445";
                                        $field_id6 = "field_1421";
                                        $field_id7 = "field_1422";
                                        $kgt_field_id = "field_1423";
                                        
                                        if(isset($records_val_json[$field_id1])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id1];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id2])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id2];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id3])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id3];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id4])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id4];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id5])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id5];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id6])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id6];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id7])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id7];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$kgt_field_id])){
                                            if($records_val_json[$kgt_field_id]=="KG"){
                                                $actual_count2 = $actual_count2/1000;
                                            }                                            
                                        }
                                        $actual_count= $actual_count+$actual_count2;
                                    }
                                }
                                $actual_count = round($actual_count ,2);
                                break;

                            case '181_3':
                                
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $data_array = array();
                                    $actual_count2 =0;
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $check_field_id = "field_1912";
                                    if(isset($records_val_json[$check_field_id])){
                                        $data_array = explode("&#44;", $records_val_json[$check_field_id]);
                                    }
                                    if(in_array('Certified seed', $data_array)){
                                        $field_id1 = "field_1425";
                                        $field_id2 = "field_1426";
                                        $field_id3 = "field_1427";
                                        $field_id4 = "field_1428";
                                        $field_id5 = "field_1446";
                                        $field_id6 = "field_1429";
                                        $field_id7 = "field_1430";
                                        $kgt_field_id = "field_1431";
                                        
                                        if(isset($records_val_json[$field_id1])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id1];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id2])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id2];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id3])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id3];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id4])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id4];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id5])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id5];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id6])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id6];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id7])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id7];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$kgt_field_id])){
                                            if($records_val_json[$kgt_field_id]=="KG"){
                                                $actual_count2 = $actual_count2/1000;
                                            }                                           
                                        }
                                        $actual_count= $actual_count+$actual_count2;
                                    }
                                }
                                $actual_count = round($actual_count ,2);
                                break;

                            case '181_4':
                                
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $data_array = array();
                                    $actual_count2 =0;
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $check_field_id = "field_1912";
                                    if(isset($records_val_json[$check_field_id])){
                                        $data_array = explode("&#44;", $records_val_json[$check_field_id]);
                                    }
                                    if(in_array('QDS or truthfully labelled seed', $data_array)){
                                        $field_id1 = "field_1433";
                                        $field_id2 = "field_1434";
                                        $field_id3 = "field_1435";
                                        $field_id4 = "field_1436";
                                        $field_id5 = "field_1447";
                                        $field_id6 = "field_1437";
                                        $field_id7 = "field_1438";
                                        $kgt_field_id = "field_1439";
                                        
                                        if(isset($records_val_json[$field_id1])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id1];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id2])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id2];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id3])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id3];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id4])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id4];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id5])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id5];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id6])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id6];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$field_id7])){
                                            $temp_value=0;
                                            $temp_value = $records_val_json[$field_id7];
                                            $actual_count2 = $actual_count2+$temp_value;
                                        }
                                        if(isset($records_val_json[$kgt_field_id])){
                                            if($records_val_json[$kgt_field_id]=="KG"){
                                                $actual_count2 = $actual_count2/1000;
                                            }                                           
                                        }
                                        $actual_count= $actual_count+$actual_count2;
                                    }
                                }
                                $actual_count = round($actual_count ,2);
                                break;

                            case '158_1':
                                $actual_count=0;
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_1188";
                                    if(isset($records_val_json[$field_id])){
                                        $temp_count=0;
                                        $temp_count = $records_val_json[$field_id];
                                        $actual_count= $actual_count + $temp_count;
                                    }
                                }
                                break;

                            case '158_2':
                                $actual_count=0;
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_1194";
                                    if(isset($records_val_json[$field_id])){
                                        $temp_count=0;
                                        $temp_count = $records_val_json[$field_id];
                                        $actual_count= $actual_count + $temp_count;
                                    }
                                }
                                break;

                            case '158_3':
                                $actual_count=0;
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_1466";
                                    if(isset($records_val_json[$field_id])){
                                        $temp_count=0;
                                        $temp_count = $records_val_json[$field_id];
                                        $actual_count= $actual_count + $temp_count;
                                    }
                                }
                                break;

                            case '158_4':
                                $actual_count=0;
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_1201";
                                    if(isset($records_val_json[$field_id])){
                                        $temp_count=0;
                                        $temp_count = $records_val_json[$field_id];
                                        $actual_count= $actual_count + $temp_count;
                                    }
                                }
                                break;

                            case '158_5':
                                $actual_count=0;
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_1467";
                                    if(isset($records_val_json[$field_id])){
                                        $temp_count=0;
                                        $temp_count = $records_val_json[$field_id];
                                        $actual_count= $actual_count + $temp_count;
                                    }
                                }
                                break;

                            case '270_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2365";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '270_2':
                                $actual_count=0;
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2366";
                                    if(isset($records_val_json[$field_id])){
                                        $temp_count=0;
                                        $temp_count = $records_val_json[$field_id];
                                        $actual_count= $actual_count + $temp_count;
                                    }
                                    $field_id1 = "field_2367";
                                    if(isset($records_val_json[$field_id1])){
                                        $temp_count1=0;
                                        $temp_count1 = $records_val_json[$field_id1];
                                        $actual_count= $actual_count + $temp_count1;
                                    }
                                }
                                break;

                            case '271_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2370";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '271_2':
                                $actual_count=0;
                                $this->db->select('*');
                                $this->db->where_in('groupfield_id', 2372);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_group_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['formgroup_data'], true);
                                    $field_id = "field_2374";
                                    if(isset($records_val_json[$field_id])){
                                        $temp_count=0;
                                        $temp_count = $records_val_json[$field_id];
                                        $actual_count= $actual_count + $temp_count;
                                    }
                                    $field_id1 = "field_2375";
                                    if(isset($records_val_json[$field_id1])){
                                        $temp_count1=0;
                                        $temp_count1 = $records_val_json[$field_id1];
                                        $actual_count= $actual_count + $temp_count1;
                                    }
                                }
                                break;

                            case '292_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2474";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '292_2':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2479";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '292_3':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2481";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '244_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2157";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '244_2':
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_group_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['formgroup_data'], true);
                                    $field_id = "field_2162";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){
                                        $temp_value= round($records_val_json[$field_id],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '244_3':

                                $actual_count = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', '2159')->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                break;

                            case '245_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2169";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '245_2':
                                $actual_count=0;
                                //get actual filed and calculate actual count
                                $this->db->select('field_id');
                                $this->db->where('status', 1);
                                $this->db->where_in('survey_id', $ind_val['id']);
                                $actualfield = $this->db->get('tbl_actual_fields')->result_array();
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    foreach ($actualfield as $af_key => $af_val) {
                                        $temp_count=0;
                                        $field_id = "field_".$af_val['field_id'];
                                        if(isset($records_val_json[$field_id]) && $records_val_json[$field_id]!=NULL){
                                            $temp_count = $records_val_json[$field_id];
                                            if(is_numeric($temp_count)){
                                                $actual_count= $actual_count + $temp_count;
                                            }
                                        }
                                    }
                                    
                                }
                                break;

                            case '245_3':

                                $actual_count = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', '2192')->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                break;

                            case '250_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2230";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '250_2':
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_group_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['formgroup_data'], true);
                                    $field_id = "field_2235";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){
                                        $temp_value= round($records_val_json[$field_id],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                }
                                break;

                            case '250_3':

                                $actual_count = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', '2232')->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                break;

                            case '252_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2245";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '252_2':
                                $actual_count=0;
                                //get actual filed and calculate actual count
                                $this->db->select('field_id');
                                $this->db->where('status', 1);
                                $this->db->where_in('survey_id', $ind_val['id']);
                                $actualfield = $this->db->get('tbl_actual_fields')->result_array();
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    foreach ($actualfield as $af_key => $af_val) {
                                        $temp_count=0;
                                        $field_id = "field_".$af_val['field_id'];
                                        if(isset($records_val_json[$field_id]) && $records_val_json[$field_id]!=NULL){
                                            $temp_count = $records_val_json[$field_id];
                                            if(is_numeric($temp_count)){
                                                $actual_count= $actual_count + $temp_count;
                                            }
                                        }
                                    }
                                    
                                }
                                break;

                            case '252_3':

                                $actual_count = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', '2268')->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                break;

                            case '249_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2223";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '249_2':

                                $actual_count = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', '2225')->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                break;
    

                            case '269_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2359";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '269_2':
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2361";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){
                                        $temp_value= round($records_val_json[$field_id],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                    $field_id1 = "field_2362";
                                    $temp_value1=0;
                                    if(isset($records_val_json[$field_id1])){
                                        $temp_value1= round($records_val_json[$field_id1],2);
                                        $actual_count= $actual_count+$temp_value1;
                                    }
                                }
                                break;

                            case '270_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2365";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '270_2':
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2366";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){
                                        $temp_value= round($records_val_json[$field_id],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                    $field_id1 = "field_2367";
                                    $temp_value1=0;
                                    if(isset($records_val_json[$field_id1])){
                                        $temp_value1= round($records_val_json[$field_id1],2);
                                        $actual_count= $actual_count+$temp_value1;
                                    }
                                }
                                break;

                            

                            case '292_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2474";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '292_2':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2479";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '292_3':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2481";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '191_1':
                                //test sample
                                $actual_count=0;
                                break;

                            case '191_2':
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_group_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['formgroup_data'], true);
                                    $field_id = "field_1616";
                                    $temp_value=0;
                                    if(isset($records_val_json[$field_id])){
                                        $temp_value= round($records_val_json[$field_id],2);
                                        $actual_count= $actual_count+$temp_value;
                                    }
                                    $field_id1 = "field_1617";
                                    $temp_value1=0;
                                    if(isset($records_val_json[$field_id1])){
                                        $temp_value1= round($records_val_json[$field_id1],2);
                                        $actual_count= $actual_count+$temp_value1;
                                    }
                                }
                                break;

                            case '359_1':
                                //test sample
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $temp_value=0;
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    $field_id = "field_2871";
                                    if(isset($records_val_json[$field_id])){
                                        $actual_count++;
                                    }
                                }
                                break;

                            case '359_2':
                                $actual_count=0;
                                //get actual filed and calculate actual count
                                $this->db->select('field_id');
                                $this->db->where('status', 1);
                                $this->db->where_in('survey_id', $ind_val['id']);
                                $actualfield = $this->db->get('tbl_actual_fields')->result_array();
                                $this->db->select('*');
                                $this->db->where_in('year_id', $data['year']);
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    foreach ($actualfield as $af_key => $af_val) {
                                        $temp_count=0;
                                        $field_id = "field_".$af_val['field_id'];
                                        if(isset($records_val_json[$field_id]) && $records_val_json[$field_id]!=NULL){
                                            $temp_count = $records_val_json[$field_id];
                                            if(is_numeric($temp_count)){
                                                $actual_count= $actual_count + $temp_count;
                                            }
                                        }
                                    }
                                    
                                }
                                break;

                            default:
                                //getting mutiple actual field array list records count
                                $actual_count=0;
                                break;
                        }
                        $derived_inds[$di_key]['d_actual_count'] = $actual_count;
                    }
                    $indicators[$i_key]['derived_inds'] = $derived_inds;


                    //Get target as per user indicator list
                    $this->db->select('target,cal_type');
                    $this->db->where('status', 1);
                    $this->db->where_in('indicator_id_2020', $ind_val['id']);
                    $this->db->where_in('year_id', $data['year']);
                    $targets = $this->db->get('tbl_indicator_target')->row_array();
                    if(isset($targets['target'])){
                        $target_count =$targets['target'];
                        $indicators[$i_key]['target'] = $target_count;
                    }else{
                        $indicators[$i_key]['target'] = $target_count;
                    }

                    //get actual filed and calculate actual count
                    $this->db->select('field_id');
                    $this->db->where('status', 1);
                    $this->db->where_in('survey_id', $ind_val['id']);
                    $actualfield = $this->db->get('tbl_actual_fields')->result_array();
                    switch ($targets['cal_type']) {
                        case 'count':
                            if(count($actualfield) >1){
                                switch ($ind_val['id']) {
                                    case '1':
                                        //test sample
                                        break;

                                    case '34':
                                        $actual_count=0;
                                        $this->db->select('*');
                                        $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                        $this->db->where_in('year_id', $data['year']);
                                        $records_list = $this->db->get('ic_form_data')->result_array();
                                        foreach ($records_list as $r_key => $records_val) {
                                            $records_val_json = json_decode($records_val['form_data'], true);
                                            foreach ($actualfield as $af_key => $af_val) {
                                                $data_array = array();
                                                $field_id = "field_".$af_val['field_id'];
                                                if(isset($records_val_json[$field_id])){
                                                    $data_array = explode("&#44;", $records_val_json[$field_id]);
                                                    $actual_count = $actual_count+ count($data_array);
                                                }
                                            }
                                        }
                                        break;

                                    case '70':
                                        $actual_count =0;
                                        $this->db->select('*');
                                        $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', 683)->where_in('status', [2,3]);
                                        $ic_form_datalist = $this->db->get('ic_form_group_data')->result_array();
                                        foreach ($ic_form_datalist as $ifd_key => $data_val) {
                                            $records_val_json = json_decode($data_val['formgroup_data'], true);
                                            if(isset($records_val_json["field_686"])){
                                                $temp_count=0;
                                                $temp_count = $records_val_json["field_686"];
                                                $actual_count= $actual_count + $temp_count;
                                            } 
                                            if(isset($records_val_json["field_687"])){
                                                $temp_count=0;
                                                $temp_count = $records_val_json["field_687"];
                                                $actual_count= $actual_count + $temp_count;
                                            }                             
                                        }
                                        $actual_gcount =0;
                                        $actual_gcount = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', 689)->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                        $actual_gcount1 = 0;
                                        $actual_gcount1 = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', 693)->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                        $actual_count= $actual_count + $actual_gcount + $actual_gcount1;
                                        break;

                                    case '138':
                                        $actual_count1=0;
                                        //get field 1 option count
                                        $this->db->select('*');
                                        $this->db->order_by('options_order');
                                        $this->db->where('form_id', $ind_val['id'])->where('field_id', $actualfield[0]['field_id'])->where('status',1);
                                        $foptions_list = $this->db->get('form_field_multiple')->result_array();
                                        if(count($foptions_list)>0){
                                            $this->db->select('*');
                                            $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                            $this->db->where_in('year_id', $data['year']);
                                            $records_list = $this->db->get('ic_form_data')->result_array();
                                            foreach ($records_list as $r_key => $records_val) {
                                                $field_number=0;
                                                $records_val_json = json_decode($records_val['form_data'], true);
                                                if(isset($records_val_json["field_".$actualfield[0]['field_id']])){
                                                    $field_value = $records_val_json["field_".$actualfield[0]['field_id']];
                                                    foreach ($foptions_list as $of_key => $ofrecords_val) {
                                                        if($ofrecords_val['value']==$field_value){
                                                            $field_number=$ofrecords_val['options_order'];
                                                        }
                                                    }
                                                    $actual_count1=$field_number;
                                                    switch (count($foptions_list)) {
                                                        case '6':
                                                            //if 5 options
                                                            switch ($field_number) {
                                                                case 1:
                                                                    $actual_count1=0;
                                                                    break;

                                                                case 2:
                                                                    $actual_count1=20;
                                                                    break;

                                                                case 3:
                                                                    $actual_count1=40;
                                                                    break;

                                                                case 4:
                                                                    $actual_count1=60;
                                                                    break;
                                                                    
                                                                case 5:
                                                                    $actual_count1=80;
                                                                    break;

                                                                case 6:
                                                                    $actual_count1=100;
                                                                    break;

                                                                default:
                                                                    $actual_count1=0;
                                                                    break;
                                                                }
                                                            break;
                                                        default:
                                                            $actual_count1=0;
                                                            break;
                                                    }
                                                }
                                            }
                                            
                                        }
                                        $actual_count2=0;
                                        //get field 2 option count
                                        $this->db->select('*');
                                        $this->db->order_by('options_order');
                                        $this->db->where('form_id', $ind_val['id'])->where('field_id', $actualfield[1]['field_id'])->where('status',1);
                                        $foptions_list = $this->db->get('form_field_multiple')->result_array();
                                        if(count($foptions_list)>0){
                                            $this->db->select('*');
                                            $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                            $this->db->where_in('year_id', $data['year']);
                                            $records_list = $this->db->get('ic_form_data')->result_array();
                                            foreach ($records_list as $r_key => $records_val) {
                                                $field_number=0;
                                                $records_val_json = json_decode($records_val['form_data'], true);
                                                if(isset($records_val_json["field_".$actualfield[1]['field_id']])){
                                                    $field_value = $records_val_json["field_".$actualfield[1]['field_id']];
                                                    foreach ($foptions_list as $of_key => $ofrecords_val) {
                                                        if($ofrecords_val['value']==$field_value){
                                                            $field_number=$ofrecords_val['options_order'];
                                                        }
                                                    }
                                                    $actual_count2=$field_number;
                                                    switch (count($foptions_list)) {
                                                        case '6':
                                                            //if 5 options
                                                            switch ($field_number) {
                                                                case 1:
                                                                    $actual_count2=0;
                                                                    break;

                                                                case 2:
                                                                    $actual_count2=20;
                                                                    break;

                                                                case 3:
                                                                    $actual_count2=40;
                                                                    break;

                                                                case 4:
                                                                    $actual_count2=60;
                                                                    break;
                                                                    
                                                                case 5:
                                                                    $actual_count2=80;
                                                                    break;

                                                                case 6:
                                                                    $actual_count2=100;
                                                                    break;

                                                                default:
                                                                    $actual_count2=0;
                                                                    break;
                                                                }
                                                            break;
                                                        default:
                                                            $actual_count2=0;
                                                            break;
                                                    }
                                                }
                                            }
                                            
                                        }
                                        $actual_count=$actual_count1+$actual_count2;
                                        if($actual_count!=0){
                                            $actual_count=$actual_count/2;
                                        }
                                        // $actual_count=$actual_count2;
                                        break;
                                    
                                    default:
                                        //getting mutiple actual field array list records count
                                        $actual_count=0;
                                        $this->db->select('*');
                                        $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                        $this->db->where_in('year_id', $data['year']);
                                        $records_list = $this->db->get('ic_form_data')->result_array();
                                        foreach ($records_list as $r_key => $records_val) {
                                            $records_val_json = json_decode($records_val['form_data'], true);
                                            foreach ($actualfield as $af_key => $af_val) {
                                                $field_id = "field_".$af_val['field_id'];
                                                if(isset($records_val_json[$field_id])){
                                                    $actual_count++;
                                                }
                                            }
                                        }
                                        break;
                                }
                                
                            }else{
                                switch ($ind_val['id']) {
                                    case '4':
                                        $actual_count = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', $actualfield[0]['field_id'])->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                        break;
                                    case '6':
                                        $actual_count = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', $actualfield[0]['field_id'])->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                        break;
    
                                    case '15':
                                        // $actual_count = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', $actualfield[0]['field_id'])->where('status', 2)->get('ic_form_group_data')->num_rows();
                                        $actual_count=21;
                                        $this->db->select('*');
                                        $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', 618)->where_in('status', [2,3]);
                                        $ic_form_datalist = $this->db->get('ic_form_group_data')->result_array();
                                        foreach ($ic_form_datalist as $ifd_key => $data_val) {
                                            $one_field_value=0;
                                            $records_val_json = json_decode($data_val['formgroup_data'], true);
                                            $one_field_value = $records_val_json["field_".$actualfield[0]['field_id']];
                                            $actual_count++;
                                            if(isset($one_field_value)){
                                                $actual_count = $actual_count+$one_field_value;
                                            }
                                        }
                                        break;
                                    
                                    default:
                                        if(isset($actualfield[0]['field_id'])){
                                            $field_id = "field_".$actualfield[0]['field_id']."";
                                            // $this->db->like('form_data', $field_id);
                                            $this->db->where("form_data LIKE '%$field_id%'");
                                            $this->db->where_in('year_id', $data['year']);
                                            $actual_count = $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3])->get('ic_form_data')->num_rows();
                                            // $indicators[$i_key]['record_count'] = $this->db->last_query();
                                        }else{
                                            $actual_count = 0;
                                        }
                                        break;
                                }
                            }
                            break;
                        case 'value':
                            if(count($actualfield) >1){
                                switch ($ind_val['id']) {
                                    case '14':
                                        $this->db->select('*');
                                        $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                        $this->db->where_in('year_id', $data['year']);
                                        $ic_form_datalist = $this->db->get('ic_form_data')->result_array();
                                        foreach ($ic_form_datalist as $ifd_key => $data_val) {
                                            $records_val_json = json_decode($data_val['form_data'], true);
                                            if(isset($records_val_json["field_88"])){
                                                $one_field_value = $records_val_json["field_88"];
                                                if($one_field_value=="Yes")
                                                {
                                                    $actual_count++;
                                                }
                                            } 
                                            if(isset($records_val_json["field_91"])){
                                                $two_field_value = $records_val_json["field_91"];
                                                if($two_field_value=="Yes"){
                                                    $actual_count++;
                                                }
                                            }
                                            if(isset($records_val_json["field_94"])){
                                                $three_field_value = $records_val_json["field_94"];
                                                if( $three_field_value=="Yes" ){
                                                    $actual_count++;
                                                }
                                            }                                    
                                        }
                                        break;

                                    case '268':
                                        $this->db->select('*');
                                        $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                        $this->db->where_in('year_id', $data['year']);
                                        $ic_form_datalist = $this->db->get('ic_form_data')->result_array();
                                        foreach ($ic_form_datalist as $ifd_key => $data_val) {
                                            $records_val_json = json_decode($data_val['form_data'], true);
                                            if(isset($records_val_json["field_2355"])){
                                                $one_field_value = $records_val_json["field_2355"];
                                                if($one_field_value=="Yes")
                                                {
                                                    if(isset($records_val_json["field_2356"])){
                                                        $two_field_value = $records_val_json["field_2356"];
                                                        if($two_field_value=="Yes"){
                                                            if(isset($records_val_json["field_2353"])){
                                                                
                                                                $actual_count++;
                                                            } 
                                                        }
                                                    }
                                                }
                                            } 
                                            
                                                                               
                                        }
                                        break;
                                    
                                    default:
                                        //getting mutiple aactual field array list
                                        $actual_count=0;
                                        $this->db->select('*');
                                        $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                        $this->db->where_in('year_id', $data['year']);
                                        $records_list = $this->db->get('ic_form_data')->result_array();
                                        foreach ($records_list as $r_key => $records_val) {
                                            $records_val_json = json_decode($records_val['form_data'], true);
                                            foreach ($actualfield as $af_key => $af_val) {
                                                $temp_count=0;
                                                $field_id = "field_".$af_val['field_id'];
                                                if(isset($records_val_json[$field_id])){
                                                    $temp_count = $records_val_json[$field_id];
                                                    $actual_count= $actual_count + $temp_count;
                                                }
                                            }
                                        }
                                        break;
                                }
                            }else{
                                switch ($ind_val['id']) {
                                    case '15':
                                        $actual_count=0;
                                        $this->db->select('*');
                                        $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', 618)->where_in('status', [2,3]);
                                        $ic_form_datalist = $this->db->get('ic_form_group_data')->result_array();
                                        foreach ($ic_form_datalist as $ifd_key => $data_val) {
                                            $one_field_value=0;
                                            $records_val_json = json_decode($data_val['formgroup_data'], true);
                                            $one_field_value = $records_val_json["field_".$actualfield[0]['field_id']];
                                            if(isset($one_field_value)){
                                                $actual_count = $actual_count+$one_field_value;
                                            }
                                        }
                                        break;
                                    case '20':
                                        $actual_count=0;
                                        $this->db->select('*');
                                        $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                        $ic_form_datalist = $this->db->get('ic_form_group_data')->result_array();
                                        foreach ($ic_form_datalist as $ifd_key => $data_val) {
                                            $one_field_value=0;
                                            $records_val_json = json_decode($data_val['formgroup_data'], true);
                                            $one_field_value = $records_val_json["field_".$actualfield[0]['field_id']];
                                            if(isset($one_field_value) && $one_field_value=="Yes"){
                                                $actual_count++;
                                            }
                                        }
                                        break;
                                    
                                    default:
                                        if(isset($actualfield[0]['field_id'])){
                                            $field_id = "field_".$actualfield[0]['field_id'];
                                            $actual_count = $this->get_filed_sum_value($ind_val['id'],$field_id, $data['year']);
                                        }else{
                                            $actual_count = 0;
                                        }
                                        break;
                                }
                            }
                            break;
                        case 'gcount':
                            //Group Count
                            if(count($actualfield) >1){
                                //multiple fileds
                                switch ($ind_val['id']) {
                                    case '1':
                                        //test sample
                                        break;
                                    
                                    default:
                                        //getting mutiple actual field array list records count
                                        $actual_count=0;
                                        foreach ($actualfield as $af_key => $af_val) {
                                            $temp_count=0;
                                            $field_id = $af_val['field_id'];
                                            $temp_count = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', $field_id)->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                            $actual_count= $actual_count + $temp_count;
                                        }
                                        break;
                                }

                            }else{
                                $actual_count = $this->db->where('form_id', $ind_val['id'])->where('groupfield_id', $actualfield[0]['field_id'])->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                            }
                            break;

                        case 'gfvalue':
                            //Group Count
                            if(count($actualfield) >1){
                                //multiple fileds
                                switch ($ind_val['id']) {
                                    case '1':
                                        //test sample
                                        break;
                                    
                                    default:
                                        //getting mutiple actual field array list records count
                                        $actual_count=0;
                                        $temp_count=0;
                                        $this->db->select('*');
                                        $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                        $records_list = $this->db->get('ic_form_group_data')->result_array();
                                        foreach ($records_list as $r_key => $records_val) {
                                            $records_val_json = json_decode($records_val['formgroup_data'], true);
                                            foreach ($actualfield as $af_key => $af_val) {
                                                $temp_count=0;
                                                $field_id = "field_".$af_val['field_id'];
                                                if(isset($records_val_json[$field_id])){
                                                    $temp_count = $records_val_json[$field_id];
                                                    $actual_count= $actual_count + $temp_count;
                                                }
                                            }
                                        }
                                        break;
                                }

                            }else{
                                        $temp_count=0;
                                        $this->db->select('*');
                                        $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                        $records_list = $this->db->get('ic_form_group_data')->result_array();
                                        foreach ($records_list as $r_key => $records_val) {
                                            $records_val_json = json_decode($records_val['formgroup_data'], true);
                                            foreach ($actualfield as $af_key => $af_val) {
                                                $temp_count=0;
                                                $field_id = "field_".$af_val['field_id'];
                                                if(isset($records_val_json[$field_id])){
                                                    $temp_count = $records_val_json[$field_id];
                                                    $actual_count= $actual_count + $temp_count;
                                                }
                                            }
                                        }
                            }
                            break;

                        case 'gfcount':
                                //Groupfiled count
                                if(count($actualfield) >1){
                                    //
                                }else{
                                    $field_id = "field_".$actualfield[0]['field_id']."";
                                    $this->db->where("formgroup_data LIKE '%$field_id%'");
                                    $actual_count = $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3])->get('ic_form_group_data')->num_rows();
                                }
                            break;

                        case 'gfdcount':
                                //Groupfiled count
                                if(count($actualfield) >1){
                                    //
                                }else{
                                    $field_id = "field_".$actualfield[0]['field_id']."";
                                    $distict_field_value_array= array();
                                    $this->db->where("formgroup_data LIKE '%$field_id%'");
                                    $records_list = $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3])->get('ic_form_group_data')->result_array();
                                    foreach ($records_list as $r_key => $records_val) {
                                        $actual_count++;
                                        $records_val_json = json_decode($records_val['formgroup_data'], true);
                                        if(isset($records_val_json[$field_id])){
                                            if(in_array($records_val_json[$field_id],$distict_field_value_array)){
                                                //skip if already existis
                                            }else{
                                                array_push($distict_field_value_array,$records_val_json[$field_id]);
                                            }
                                        }
                                    }
                                    if(isset($records_list)){
                                        $actual_count =count($distict_field_value_array);
                                    }
                                    
                                }
                            break;

                        case 'cfcount':
                                //checkbox field count 
                                $actual_count=0;
                                $this->db->select('*');
                                $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                $this->db->where_in('year_id', $data['year']);
                                $records_list = $this->db->get('ic_form_data')->result_array();
                                foreach ($records_list as $r_key => $records_val) {
                                    $records_val_json = json_decode($records_val['form_data'], true);
                                    foreach ($actualfield as $af_key => $af_val) {
                                        $data_array = array();
                                        $field_id = "field_".$af_val['field_id'];
                                        if(isset($records_val_json[$field_id])){
                                            $data_array = explode("&#44;", $records_val_json[$field_id]);
                                            $actual_count = $actual_count+ count($data_array);
                                        }
                                    }
                                }
                                break;

                        case 'percentage':
                            //percentage count
                            if(count($actualfield) >1){
                                //
                                switch ($ind_val['id']) {
                                    case '41':
                                        //test sample
                                        $actual_count=0;
                                        $actual_3a_count=0;
                                        $actual_3b_count=0;
                                        $record_count=0;
                                        $this->db->select('*');
                                        $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                        $this->db->where_in('year_id', $data['year']);
                                        $records_list = $this->db->get('ic_form_data')->result_array();
                                        foreach ($records_list as $r_key => $records_val) {
                                            $records_val_json = json_decode($records_val['form_data'], true);
                                                $temp_3a_count=0;
                                                $temp_3b_count=0;
                                                if(isset($records_val_json["field_315"])){
                                                    $temp_3a_count = $records_val_json["field_315"];
                                                    $actual_3a_count= $actual_3a_count + $temp_3a_count;
                                                }
                                                if(isset($records_val_json["field_316"])){
                                                    $temp_3b_count = $records_val_json["field_316"];
                                                    $actual_3b_count= $actual_3b_count + $temp_3b_count;
                                                    $record_count++;
                                                }
                                        }
                                        // if($actual_3b_count>0){
                                        //     $actual_count=($actual_3b_count/$actual_3a_count)*100;
                                        // }else{
                                        //     $actual_count=0;
                                        // }
                                        if($record_count>0){
                                            $actual_count= ($actual_3b_count/$record_count)*100;
                                        }else{
                                            $actual_count=0;
                                        }
                                        $actual_count= round($actual_count,2);
                                        break;
                                    
                                    default:
                                        //getting mutiple actual field array list records count
                                        $actual_count=0;
                                        break;
                                }
                            }else{
                                $actual_count =0;
                            }
                            break;

                        case 'status':
                            //status count
                            if(count($actualfield) >1){
                                //more than one field
                            }else{
                                //if single field
                                $actual_count=0;
                                //get option count
                                $this->db->select('*');
                                $this->db->order_by('options_order');
                                $this->db->where('form_id', $ind_val['id'])->where('field_id', $actualfield[0]['field_id'])->where('status',1);
                                $foptions_list = $this->db->get('form_field_multiple')->result_array();
                                if(count($foptions_list)>0){
                                    $this->db->select('*');
                                    $this->db->where('form_id', $ind_val['id'])->where_in('status', [2,3]);
                                    $this->db->where_in('year_id', $data['year']);
                                    $records_list = $this->db->get('ic_form_data')->result_array();
                                    foreach ($records_list as $r_key => $records_val) {
                                        $field_number=0;
                                        $records_val_json = json_decode($records_val['form_data'], true);
                                        if(isset($records_val_json["field_".$actualfield[0]['field_id']])){
                                            $field_value = $records_val_json["field_".$actualfield[0]['field_id']];
                                            foreach ($foptions_list as $of_key => $ofrecords_val) {
                                                if($ofrecords_val['value']==$field_value){
                                                    $field_number=$ofrecords_val['options_order'];
                                                }
                                            }
                                            $actual_count=$field_number;
                                            switch (count($foptions_list)) {
                                                case '2':
                                                    //if 2 options
                                                    switch ($field_number) {
                                                        case 1:
                                                            $actual_count=50;
                                                            break;

                                                        case 2:
                                                            $actual_count=100;
                                                            break;

                                                        default:
                                                            $actual_count=0;
                                                            break;
                                                        }
                                                    break;

                                                case '3':
                                                    //if 3 options
                                                    switch ($field_number) {
                                                        case 1:
                                                            $actual_count=0;
                                                            break;

                                                        case 2:
                                                            $actual_count=50;
                                                            break;

                                                        case 3:
                                                            $actual_count=100;
                                                            break;

                                                        default:
                                                            $actual_count=0;
                                                            break;
                                                        }
                                                    break;

                                                case '4':
                                                    //if 4 options
                                                    switch ($field_number) {
                                                        case 1:
                                                            $actual_count=0;
                                                            break;

                                                        case 2:
                                                            $actual_count=33.33;
                                                            break;

                                                        case 3:
                                                            $actual_count=66.66;
                                                            break;

                                                        case 4:
                                                            $actual_count=100;
                                                            break;

                                                        default:
                                                            $actual_count=0;
                                                            break;
                                                        }
                                                    break;
        
                                                case '5':
                                                    //if 5 options
                                                    switch ($field_number) {
                                                        case 1:
                                                            $actual_count=0;
                                                            break;

                                                        case 2:
                                                            $actual_count=25;
                                                            break;

                                                        case 3:
                                                            $actual_count=50;
                                                            break;

                                                        case 4:
                                                            $actual_count=75;
                                                            break;
                                                            
                                                        case 5:
                                                            $actual_count=100;
                                                            break;

                                                        default:
                                                            $actual_count=0;
                                                            break;
                                                        }
                                                    break;

                                                case '6':
                                                    //if 5 options
                                                    switch ($field_number) {
                                                        case 1:
                                                            $actual_count=0;
                                                            break;

                                                        case 2:
                                                            $actual_count=20;
                                                            break;

                                                        case 3:
                                                            $actual_count=40;
                                                            break;

                                                        case 4:
                                                            $actual_count=60;
                                                            break;
                                                            
                                                        case 5:
                                                            $actual_count=80;
                                                            break;

                                                        case 6:
                                                            $actual_count=100;
                                                            break;

                                                        default:
                                                            $actual_count=0;
                                                            break;
                                                        }
                                                    break;

                                                    case '7':
                                                        //if 5 options
                                                        switch ($field_number) {
                                                            case 1:
                                                                $actual_count=0;
                                                                break;
    
                                                            case 2:
                                                                $actual_count=16.67;
                                                                break;
    
                                                            case 3:
                                                                $actual_count=33.33;
                                                                break;
    
                                                            case 4:
                                                                $actual_count=50;
                                                                break;
                                                                
                                                            case 5:
                                                                $actual_count=66.67;
                                                                break;
    
                                                            case 6:
                                                                $actual_count=83.33;
                                                                break;

                                                            case 7:
                                                                $actual_count=100;
                                                                break;
    
                                                            default:
                                                                $actual_count=0;
                                                                break;
                                                            }
                                                        break;

                                                default:
                                                    $actual_count=0;
                                                    break;
                                            }
                                        }
                                    }
                                    
                                }
                                
                            }
                            break;                        

                        default:
                            $actual_count=0;
                            break;
                    }

                    $indicators[$i_key]['actual_count'] = $actual_count;
                }
                $clusters[$o_key]['indicator_list'] = $indicators;
            }
            $program_list[$key]['cluster_list'] = $clusters;
        }
        return $program_list;
    }

    public function get_filed_sum_value($surve_id,$field_id, $year)
    {
        $actual_count=0;
        $this->db->select('*');
        $this->db->where('form_id', $surve_id)->where_in('status', [2,3]);
        $this->db->where_in('year_id', $year);
        $records_list = $this->db->get('ic_form_data')->result_array();
        foreach ($records_list as $key => $records_val) {
            $temp_count=0;
            $records_val_json = json_decode($records_val['form_data'], true);
            if(isset($records_val_json[$field_id])){
                $temp_count = $records_val_json[$field_id];
                $actual_count= $actual_count + $temp_count;
            }
        }
        return $actual_count;
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
