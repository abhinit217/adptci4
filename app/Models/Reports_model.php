<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');		
	}
    public function all_surveys($cid){
		$this->db->select('fm.*');
		$this->db->join('form AS fm', 'fm.id = tci.indicator_id');
		$this->db->where('tci.component_id', $cid);
		$this->db->where('fm.status', 1)->where('tci.status', 1);
		$data = $this->db->order_by('fm.sl_no', 'ASC')->get('tbl_component_indicator AS tci')->result_array();
        foreach($data as $key=>$value){
            $survey_table = "survey".$value["id"];
            // echo($survey_table);
            $data[$key]['verified_count'] = $this->db->where('ifd.status', 1)->get($survey_table.' AS ifd')->num_rows();
            $data[$key]['underreview_count'] = $this->db->where('ifd.status', 2)->get($survey_table.' AS ifd')->num_rows();
            $data[$key]['rejected_count'] = $this->db->where('ifd.status', 0)->get($survey_table.' AS ifd')->num_rows();
        }
        return $data;
    }

    public function export_survey_details($survey_id){
        $this->db->select('*');
        $this->db->where("form_id", $survey_id)->where('status', 1);
        $survey_fields = $this->db->order_by('slno', 'ASC')->get('form_field')->result_array();
        return $survey_fields;
    }
    public function export_survey_title($survey_id){
        $this->db->select('title');
        $this->db->where("id", $survey_id)->where('status', 1);
        $title = $this->db->get('form')->row_array();
        return $title['title'];
    }
    public function export_survey_data($data){
        $survey_table = 'survey'.$data['survey_id'];
        $this->db->distinct()->select('ifd.*, concat(tu.first_name, " ", tu.last_name) as username, ');
        $this->db->join('tbl_users AS tu', 'tu.user_id = ifd.user_id');
        $survey_data = $this->db->where('ifd.status', 1)->order_by('ifd.id', 'ASC')->get($survey_table.' AS ifd')->result_array();
        
        foreach ($survey_data as $key => $record) {

            $data_id = $record['data_id'];
            $this->db->select('file_name');
            $this->db->where('data_id', $data_id )->where('status', 1);
            $upload_link = $this->db->get('ic_data_file')->row_array();

            $this->db->select('field_id');
            $this->db->where('type', 'uploadfile')->where('form_id', $data['survey_id'])->where('status', 1);
            $upload_fields = $this->db->get('form_field')->row_array();
            if(!empty($upload_fields)){
                $survey_data[$key]['field_'.$upload_fields['field_id']]= $upload_link['file_name'] ?? null;
            }
            // $survey_data[$key]['field_'.$upload_fields['field_id']]= $upload_link['file_name'] ?? null;
            foreach ($data['survey_fields'] as $fkey => $field) {
                switch ($field['type']) {
                    case 'lkp_year':
                        $this->db->select('year_name');
                        $this->db->where('year_id', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->order_by('slno', 'ASC')->get('lkp_year')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['year_name'];
                        break;
                    case 'lkp_compact':
                        $this->db->select('compact_name');
                        $this->db->where('compact_id', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_compact')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['compact_name'];
                        break;
                    case 'lkp_country':
                        $this->db->select('name');
                        $this->db->where('country_id', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_country')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['name'];
                        break;
                    case 'lkp_actual':
                        $this->db->select('actual_name');
                        $this->db->where('actual_id', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_actual')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['actual_name'];
                        break;
                    case 'lkp_geographicscope':
                        $this->db->select('scope_name');
                        $this->db->where('scope_id', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_geographicscope')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['scope_name'];
                        break;
                    case 'lkp_innovation_platform':
                        $this->db->select('innovation_name');
                        $this->db->where('innovation_id', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_innovation_platform')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['innovation_name'];
                        break;
                    case 'lkp_outcome':
                        $this->db->select('outcome_name');
                        $this->db->where('outcome_id', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_outcome')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['outcome_name'];
                        break;
                    case 'lkp_partners':
                        $this->db->select('partner_name');
                        $this->db->where('partner_id', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_partners')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['partner_name'];
                        break;
                    case 'lkp_quarter':
                        $this->db->select('quarter_name');
                        $this->db->where('quarter_id', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_quarter')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['quarter_name'];
                        break;
                    case 'lkp_status_assessment':
                        $this->db->select('assessment_name');
                        $this->db->where('assessment_id', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_status_assessment')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['assessment_name'];
                        break;
                    case 'lkp_yesno':
                        $this->db->select('name');
                        $this->db->where('id', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_yesno')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['name'];
                        break;
                    case 'lkp_technology_deployed':
                        $this->db->select('tech_deployed');
                        $this->db->where('tech_deployed', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_technology_deployed')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['tech_deployed'];
                        break;
                    case 'lkp_technology_type':
                        $this->db->select('technology_type');
                        $this->db->where('technology_type', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_technology_type')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['technology_type'];
                        break;
                    case 'lkp_technology_varieties':
                        $this->db->select('technology_varieties');
                        $this->db->where('technology_varieties', $survey_data[$key]['field_'.$field['field_id']] )->where('status', 1);
                        $field_value = $this->db->get('lkp_technology_varieties')->row_array();
                        $survey_data[$key]['field_'.$field['field_id']] = $field_value['technology_varieties'];
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
        }
        

        return $survey_data;
    }
    /* add more fields display start */

    public function survey_details($survey_id){
        
        $form_details = $this->db->where('id', $survey_id)->where('status', 1)->get('form')->row_array();

        $this->db->select('*');
        $this->db->where("form_id", $survey_id)->where("type", 'group')->where('status', 1);
        $group_field_count = $this->db->order_by('slno')->get('form_field')->result_array();

        if($group_field_count > 0){
            $this->db->select('GROUP_CONCAT(field_id) as field_ids');
            $this->db->where('type', 'group')->where('form_id', $survey_id)->where('status', 1);
            $form_group_id = $this->db->get('form_field')->row_array();

            $form_group_id_array = explode(",", $form_group_id['field_ids']);

            $form_group_id_array_list = array();
            foreach ($form_group_id_array as $key => $value) {
                $this->db->select('child_id');
                $this->db->where('form_id', $survey_id)->where('field_id', $value);
                $this->db->where('status', 1);
                $group_childid = $this->db->get('form_field')->row_array();

                $child_id_array = explode(",", $group_childid['child_id']);

                foreach ($child_id_array as $key => $child) {
                    array_push($form_group_id_array_list, $child);
                }
            }
        }else{
            $form_group_id_array_list = array(0);
        }

        $this->db->select('*');
        $this->db->where("form_id", $survey_id)->where('status', 1);
        $this->db->where_not_in('field_id', $form_group_id_array_list);
        $this->db->where('type !=', 'group')->where('type !=', 'header');
        $survey_formfields = $this->db->order_by('slno')->get('form_field')->result_array();

        // $this->db->select('*');
        // $this->db->where("form_id", $survey_id)->where("type !=", 'group')->where('status', 1);
        // $survey_formfields = $this->db->order_by('slno')->get('form_field')->result_array();
        
        $result = array('fields' => $survey_formfields, 'form_details' => $form_details, 'form_id'=>$survey_id, 'group_field_count'=>$group_field_count );
        return $result;
    }
    public function survey_approval_details($survey_id){
        
        $form_details = $this->db->where('id', $survey_id)->where('status', 1)->get('form')->row_array();

        $this->db->select('*');
        $this->db->where("form_id", $survey_id)->where("type", 'group')->where('status', 1);
        $group_field_count = $this->db->order_by('slno')->get('form_field')->result_array();

        if($group_field_count > 0){
            $this->db->select('GROUP_CONCAT(field_id) as field_ids');
            $this->db->where('type', 'group')->where('form_id', $survey_id)->where('status', 1);
            $form_group_id = $this->db->get('form_field')->row_array();

            $form_group_id_array = explode(",", $form_group_id['field_ids']);

            $form_group_id_array_list = array();
            foreach ($form_group_id_array as $key => $value) {
                $this->db->select('child_id');
                $this->db->where('form_id', $survey_id)->where('field_id', $value);
                $this->db->where('status', 1);
                $group_childid = $this->db->get('form_field')->row_array();

                $child_id_array = explode(",", $group_childid['child_id']);

                foreach ($child_id_array as $key => $child) {
                    array_push($form_group_id_array_list, $child);
                }
            }
        }else{
            $form_group_id_array_list = array(0);
        }

        $this->db->select('*');
        $this->db->where("form_id", $survey_id)->where('status', 1);
        $this->db->where_not_in('field_id', $form_group_id_array_list);
        $this->db->where('type !=', 'group')->where('type !=', 'header');
        $survey_formfields = $this->db->order_by('slno')->get('form_field')->result_array();

        // $this->db->select('*');
        // $this->db->where("form_id", $survey_id)->where("type !=", 'group')->where('status', 1);
        // $survey_formfields = $this->db->order_by('slno')->get('form_field')->result_array();
        
        $result = array('fields' => $survey_formfields, 'form_details' => $form_details, 'form_id'=>$survey_id, 'group_field_count'=>$group_field_count );
        return $result;
    }

    // public function check_record($data){
    //     $this->db->select('data_id');
    //     $this->db->where('data_id', $data['data_id'])->where('form_id', $data['survey_id']);
    //     return $record_status = $this->db->where('data_status', $data['status'])->get('ic_form_data')->num_rows();
    // }

    public function group_info($data){
        $this->db->select('GROUP_CONCAT(field_id) as field_ids');
        $this->db->where('type', 'group')->where('form_id', $data['survey_id'])->where("field_id", $data['group_field_id'])->where('status', 1);
        $form_group_id = $this->db->get('form_field')->row_array();

        $form_group_id_array = explode(",", $form_group_id['field_ids']);

        $group_fields = array();
        $grouptable = "ic_form_group_data";

        foreach ($form_group_id_array as $key => $value) {

            $group_fields[$key]['group_fieldid'] = $value;

            $group_label = $this->db->select('label')->where('field_id', $value)->get('form_field')->row_array();

            $group_fields[$key]['group_label'] = $group_label['label'];
            
            $this->db->select('child_id');
            $this->db->where('form_id', $data['survey_id'])->where('field_id', $value);
            $this->db->where('status', 1);
            $group_childid = $this->db->get('form_field')->row_array();

            $child_id_array = explode(",", $group_childid['child_id']);

            $this->db->select('field_id, type, label, slno');
            $this->db->where('form_id', $data['survey_id'])->where('type !=', 'header')->where_in('field_id', $child_id_array);
            $this->db->where('status', 1);
            $this->db->order_by('slno');
            $group_fields[$key]['group_fields'] = $this->db->get('form_field')->result_array();

            

            $this->db->select('*');
            $this->db->where('groupfield_id', $value)->where('data_id', $data['data_id'])->where('status!=',0);
            $group_fields[$key]['group_data'] = $this->db->get($grouptable)->result_array();
        }
        // print_r($grouptable);exit;

        return $group_fields;
    }

    
    /* add more fields display end */

    public function survey_data($data){
        $user_id=$this->session->userdata['login_id'];
        $curent_page = $data['curent_page'];
        $total_records_per_page = $data['total_records_per_page'];
        $survey_table = 'survey'.$data['survey_id'];
        $this->db->distinct()->select('ifd.*, concat(tu.first_name, " ", tu.last_name) as username, ');
        $this->db->join('tbl_users AS tu', 'tu.user_id = ifd.user_id');
        $survey_data = $this->db->where('ifd.status', 1)->order_by('ifd.id', 'DESC')->limit($total_records_per_page,($total_records_per_page*$curent_page)-($total_records_per_page))->get($survey_table.' AS ifd')->result_array();
        //    echo $this->db->last_query();exit;
        //  print_r($data);exit;
        
        foreach ($survey_data as $key => $field) {

            $data_id = $field['data_id'];
            $this->db->select('file_name');
            $this->db->where('data_id', $data_id )->where('status', 1);
            $upload_link = $this->db->get('ic_data_file')->row_array();

            $this->db->select('field_id');
            $this->db->where('type', 'uploadfile')->where('form_id', $data['survey_id'])->where('status', 1);
            $upload_fields = $this->db->get('form_field')->row_array();

            if(!empty($upload_fields)){
                $survey_data[$key]['field_'.$upload_fields['field_id']]= $upload_link['file_name'] ?? null;
            }
        }
        

        return $survey_data;
    }

    public function survey_data_records($survey_id){
        $user_id=$this->session->userdata['login_id'];
        $survey_table = 'survey'.$survey_id;
        $data = $this->db->where('ifd.status', 1)->order_by('ifd.id', 'DESC')->get($survey_table.' AS ifd')->num_rows();
       return $data;
    }

    public function survey_data_by_id($data){
        $user_id=$this->session->userdata['login_id'];
        $survey_table = 'survey'.$data['survey_id'];
        $survey_group_table = 'survey'.$data['survey_id'].'_groupdata';
        $this->db->distinct()->select('ifd.*');
        $this->db->where('ifd.id', $data['record_id']);
        $surveyData = $this->db->get($survey_table.' AS ifd')->result_array();
        // echo $this->db->last_query();exit;
        // print_r($surveyData);exit();
        foreach ($surveyData as $key => $field) {

            $data_id = $field['data_id'];

            $this->db->select('file_name');
            $this->db->where('data_id', $data_id )->where('status', 1);
            $upload_link = $this->db->get('ic_data_file')->row_array();

            $this->db->select('field_id');
            $this->db->where('type', 'uploadfile')->where('form_id', $data['survey_id'] )->where('status', 1);
            $upload_fields = $this->db->get('form_field')->row_array();
            if(!empty($upload_fields)){
                $surveyData[0]['field_'.$upload_fields['field_id']]= $upload_link['file_name'];
            }
          

        }

        // $this->db->select('GROUP_CONCAT(field_id) as field_ids');
        $this->db->select('field_id');
        $this->db->where('type', 'group')->where('form_id',  $data['survey_id'])->where('status', 1);
        $get_group_id = $this->db->get('form_field')->result_array();
        if(!empty($get_group_id)){
            // $get_group_id_array = explode(",", $get_group_id['field_ids']);
            foreach($get_group_id as $gkey => $groupId){
                $this->db->select('group_id, data_id, groupfield_id, data');
                $this->db->from($survey_group_table);
                $this->db->where('groupfield_id', $groupId['field_id']);
                $this->db->where('data_id', $surveyData[0]['data_id']);
                $groupfieldsdata = $this->db->get()->result_array();
    
                $surveyData[0][$groupId['field_id']] = $groupfieldsdata;
                
            }
        }
        return $surveyData[0];
    }

    public function survey_data_by_id_1($data){
        $user_id=$this->session->userdata['login_id'];
        $survey_table = 'survey'.$data['survey_id'];
        $survey_group_table = 'survey'.$data['survey_id'].'_groupdata';
        $this->db->distinct()->select('ifd.*');
        $this->db->where('ifd.id', $data['record_id']);
        $surveyData = $this->db->get($survey_table.' AS ifd')->result_array();
        // echo $this->db->last_query();exit;
        // print_r($surveyData);exit();
        foreach ($surveyData as $key => $field) {

            $data_id = $field['data_id'];

            $this->db->select('file_name');
            $this->db->where('data_id', $data_id )->where('status', 1);
            $upload_link = $this->db->get('ic_data_file')->row_array();

            $this->db->select('field_id');
            $this->db->where('type', 'uploadfile')->where('form_id', $data['survey_id'] )->where('status', 1);
            $upload_fields = $this->db->get('form_field')->row_array();
            if(!empty($upload_fields)){
                $surveyData[0]['field_'.$upload_fields['field_id']]= $upload_link['file_name'];
            }
        }
        // $this->db->select('field_id');
        // $this->db->where('type', 'group')->where('form_id',  $data['survey_id'])->where('status', 1);
        // $get_group_id = $this->db->get('form_field')->result_array();
        // if(!empty($get_group_id)){
        //     // $get_group_id_array = explode(",", $get_group_id['field_ids']);
        //     foreach($get_group_id as $gkey => $groupId){
        //         $this->db->select('group_id, data_id, groupfield_id, data');
        //         $this->db->from($survey_group_table);
        //         $this->db->where('groupfield_id', $groupId['field_id']);
        //         $this->db->where('data_id', $surveyData[0]['data_id']);
        //         $groupfieldsdata = $this->db->get()->result_array();
    
        //         $surveyData[0][$groupId['field_id']] = $groupfieldsdata;
                
        //     }
        // }
        return $surveyData[0];
    }
    /*public function survey_groupdata_by_id($data){
        $user_id=$this->session->userdata['login_id'];
        $survey_table = 'survey'.$data['survey_id'];
        $survey_group_table = 'survey'.$data['survey_id'].'_groupdata';
        $this->db->distinct()->select('ifd.*');
        $this->db->where('ifd.id', $data['record_id']);
        $surveyData = $this->db->get($survey_table.' AS ifd')->result_array();
        foreach ($surveyData as $key => $field) {
            $data_id = $field['data_id'];
            $this->db->select('group_id, data_id, groupfield_id, data');
            $this->db->from($survey_group_table);
            $this->db->where('data_id', $data_id);
            $groupfieldsdata = $this->db->get()->result_array();
        }
        
        return $groupfieldsdata;
    }*/
    public function group_info_details($data){
        $survey_group_table= "ic_form_group_data";
        $this->db->select('*');
        $this->db->where('group_id', $data['group_id']);
        $group_data = $this->db->get($survey_group_table)->row_array();

        return $group_data;
    }
    public function group_field_details($data){
        $this->db->select('*');
        $this->db->where('field_id', $data['field_id']);
        $data = $this->db->where('status', 1)->get('form_field')->row_array();

        switch ($data['type']) {
            case 'checkbox-group':
            case 'radio-group':
            case 'select':
                $this->db->select('multiple_id, label, value');
                $this->db->where("field_id", $data['field_id'])->where('status', 1);
                $options = $this->db->get('form_field_multiple')->result_array();

                $data['options'] = $options;
                break;
            
            case 'lkp_gender':
                $this->db->select('id, type');
                $this->db->where('status', 1);
                $options = $this->db->get('lkp_gender')->result_array();

                $data['options'] = $options;
                break;

            case 'lkp_trait':
                $this->db->select('*');
                $this->db->where('trait_status', 1);
                // $this->db->order_by('trait_id');
                $data['options'] = $this->db->get('lkp_trait')->result_array();
                break;
            case 'lkp_trait2':
                $this->db->select('*');
                $this->db->where('trait2_status', 1);
                // $this->db->order_by('trait2_id');
                $data['options'] = $this->db->get('lkp_trait2')->result_array();
                break;
            case 'lkp_country':
                $this->db->select('country_id, country_name,country_code');
                $this->db->order_by('country_id');
                $data['options'] = $this->db->where('status', 1)->get('lkp_country')->result_array();
                break;
            case 'lkp_headquarter':
                $this->db->select('*');
                $this->db->where('headquarter_status', 1);
                // $this->db->order_by('headquarter_id');
                $data['options'] = $this->db->get('lkp_headquarter')->result_array();
                break;
        }

        return $data;
    }
    // public function survey_data_add($data){
    //     $user_id=$this->session->userdata['login_id'];
    //     $survey_table = 'survey'.$data['survey_id'];
    //     $this->db->distinct()->select('ifd.*');
    //     $data = $this->db->get($survey_table.' AS ifd')->row_array();
    //     return $data;
    // }
    public function user_compact_list(){
        $this->db->distinct()->select('*');
        $data = $this->db->where('status', 1)->get('lkp_compact')->result_array();
        return $data;
    }
    public function country_list(){
        $this->db->select('*');
        $data = $this->db->where('status', 1)->get('lkp_country')->result_array();
        return $data;
    }
    public function compact_list(){
        $this->db->distinct()->select('*');
        $data = $this->db->where('status', 1)->get('lkp_compact')->result_array();
        return $data;
    }
    public function actual_list(){
        $this->db->distinct()->select('*');
        $data = $this->db->where('status', 1)->get('lkp_actual')->result_array();
        return $data;
    }
    public function quarter_list(){
        $this->db->distinct()->select('*');
        $data = $this->db->where('status', 1)->get('lkp_quarter')->result_array();
        return $data;
    }
    public function geographicscope_list(){
        $this->db->distinct()->select('*');
        $data = $this->db->where('status', 1)->get('lkp_geographicscope')->result_array();
        return $data;
    }
    public function innovation_platform_list(){
        $this->db->distinct()->select('*');
        $data = $this->db->where('status', 1)->get('lkp_innovation_platform')->result_array();
        return $data;
    }
    public function technology_type_list(){
        $this->db->distinct()->select('*');
        $data = $this->db->where('status', 1)->get('lkp_technology_type')->result_array();
        return $data;
    }
    public function technology_deployed_list(){
        $this->db->distinct()->select('*');
        $data = $this->db->where('status', 1)->get('lkp_technology_deployed')->result_array();
        return $data;
    }
    public function technology_varieties_list(){
        $this->db->distinct()->select('*');
        $data = $this->db->where('status', 1)->get('lkp_technology_varieties')->result_array();
        return $data;
    }
    public function toolkit_list(){
        $this->db->distinct()->select('*');
        $data = $this->db->where('status', 1)->get('tbl_toolkit')->result_array();
        return $data;
    }
    public function year_list(){
        $this->db->distinct()->select('*');
        $data = $this->db->where('status', 1)->order_by('slno', 'ASC')->get('lkp_year')->result_array();
        return $data;
    }
    public function all_components(){
        $this->db->distinct()->select('*');
        $data = $this->db->where('status', 1)->get('lkp_component')->result_array();
        return $data;
    }

    public function headquarter_list(){
        $this->db->select('*');
        $data = $this->db->where('headquarter_status', 1)->get('lkp_headquarter')->result_array();
        return $data;
    }

    public function excel_u_status($data){
        $survey_id = $data['survey_id'];
        $this->db->select('inline');
        $this->db->where('form_id', $survey_id)->where('type', 'uploadgroupdata_excel');
        $data = $this->db->where('status', 1)->get('form_field')->row_array();
        return $data['inline'];
    }


    public function survey_fields($data){
        $survey_id = $data['survey_id'];
        $form_details = $this->db->where('id', $survey_id)->where('status', 1)->get('form')->row_array();

        $this->db->select('*');
		$this->db->where("form_id", $survey_id)->where("field_id", $data['group_field_id'])->where('status', 1);
		$this->db->where('parent_id', NULL)->where('parent_value', NULL)->order_by('slno');
		$survey_formfields = $this->db->get('form_field')->result_array();

        

		foreach ($survey_formfields as $key => $field) {
			// Remove ip_address and added_by
			unset($survey_formfields[$key]['added_by']);
			unset($survey_formfields[$key]['ip_address']);

			$survey_formfields[$key]['childfields_count'] = $this->db->where('parent_id', $field['field_id'])->where('status', 1)->where("form_id", $survey_id)->get('form_field')->num_rows();
			
			switch ($field['type']) {
				case 'group':
					$this->db->where('parent_id', $field['field_id'])->where('parent_value IS NULL')->where('status', 1);
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

					$survey_formfields[$key]['groupfields'] = $survey_groupfields;
					break;

				case 'checkbox-group':
				case 'radio-group':
				case 'select':
					$this->db->select('multi_id, label, selected, value');
					$this->db->where("field_id", $field['field_id'])->where('status', 1);
					$this->db->order_by('options_order', 'ASC')->order_by('label', 'ASC');
					$options = $this->db->get('form_field_multiple')->result_array();

					$survey_formfields[$key]['options'] = $options;
					break;

				// case 'lkp_age':
				// 	$this->db->select('id, age');
				// 	$this->db->where('status', 1);
				// 	$options = $this->db->get('lkp_age')->result_array();

				// 	$survey_formfields[$key]['options'] = $options;
				// 	break;

				case 'lkp_country':
					$this->db->select('country_id, name');
					$options = $this->db->where('status', 1)->get('lkp_country')->result_array();

					$survey_formfields[$key]['options'] = $options;
					break;
				
				case 'lkp_year':
					$this->db->select('year_id, year_name');
					$options = $this->db->where('status', 1)->order_by('slno', 'ASC')->get('lkp_year')->result_array();

					$survey_formfields[$key]['options'] = $options;
					break;
				
				case 'lkp_quarter':
					$this->db->select('quarter_id, quarter_name');
					$options = $this->db->where('status', 1)->get('lkp_quarter')->result_array();

					$survey_formfields[$key]['options'] = $options;
					break;

                case 'lkp_year':
                    $this->db->select('year_id, year');
                    $this->db->order_by('year_id');
                    $options = $this->db->where('year_status', 1)->get('lkp_year')->result_array();
                    $survey_formfields[$key]['options'] = $options;
                    break;

                case 'lkp_rperiod':
                    $this->db->select('rperiod_id, rperiod_name');
                    $this->db->order_by('rperiod_name');
                    $options = $this->db->where('rperiod_status', 1)->get('lkp_rperiod')->result_array();
                    $survey_formfields[$key]['options'] = $options;
                    break;

                case 'lkp_country':
                    $this->db->select('country_id, country_name,country_code');
                    $this->db->order_by('slno');
                    $options = $this->db->where('status', 1)->get('lkp_country')->result_array();
                    $survey_formfields[$key]['options'] = $options;
                    break;

                case 'lkp_crop':
                    $this->db->select('crop_id, crop_name, crop_description');
                    // $this->db->order_by('crop_name');
                    $options = $this->db->where('crop_status', 1)->get('lkp_crop')->result_array();
                    $survey_formfields[$key]['options'] = $options;
                    break;

                case 'lkp_trait':
                    $this->db->select('*');
                    $this->db->where('trait_status', 1);
                    // $this->db->order_by('trait_id');
                    $survey_formfields[$key]['options'] = $this->db->get('lkp_trait')->result_array();

                    $this->db->where('parent_id', $indicatorfield['field_id'])->where('status', 1);
                    $icheck_child_fields = $this->db->get('form_field')->num_rows();

                    $survey_formfields[$key]['child_count']  = $icheck_child_fields;
                    break;

                case 'lkp_trait2':
                    $this->db->select('*');
                    $this->db->where('trait2_status', 1);
                    // $this->db->order_by('trait2_id');
                    $survey_formfields[$key]['options'] = $this->db->get('lkp_trait2')->result_array();

                    $this->db->where('parent_id', $indicatorfield['field_id'])->where('status', 1);
                    $icheck_child_fields = $this->db->get('form_field')->num_rows();

                    $survey_formfields[$key]['child_count']  = $icheck_child_fields;
                    break;

                    
			}
		}
       
		$result = array(
			'fields' => $survey_formfields,
            'form_details' => $form_details
		);

       
		return $result;
	}

    public function survey_data_details($id, $survey_id){
        $this->db->select('*');
        $this->db->where('id', $id);
        $data = $this->db->get('survey'.$survey_id)->row_array();
        // $data = $this->db->get('ic_form_data')->row_array();

        return $data;
    }
    public function survey_data_details_edit($id, $survey_id){
        $this->db->select('*');
        $this->db->where('id', $id);
        $data = $this->db->where('status', 1)->get('survey'.$survey_id)->row_array();

        return $data;
    }

    public function field_details($field_id, $survey_data = NULL){
        $this->db->select('*');
        $this->db->where('field_id', $field_id);
        $data = $this->db->where('status', 1)->get('form_field')->row_array();

        switch ($data['type']) {
            case 'checkbox-group':
            case 'radio-group':
            case 'select':
                $this->db->select('multi_id, label, value');
                $this->db->where("field_id", $data['field_id'])->where('status', 1);
                $options = $this->db->get('form_field_multiple')->result_array();

                $data['options'] = $options;
                break;
            
            case 'lkp_gender':
                $this->db->select('id, type');
                $this->db->where('status', 1);
                $options = $this->db->get('lkp_gender')->result_array();

                $data['options'] = $options;
                break;

            case 'lkp_country':
                // Get user details
                $user = $this->db->where('user_id', $survey_data['user_id'])->get('tbl_users')->row_array();
                
                // Get countries assigned to the user
                $this->db->where('status', 1)->where('form_id', $survey_data['form_id']);
                //$this->db->where('proj_id', $survey_data['project_id']);
                if($user['role_id'] > 2) {
                    $this->db->where('user_id', $survey_data['user_id'])->from('rpt_user_form_location');
                } else {
                    $this->db->from('rpt_project_form_location');
                }
                $assignment = $this->db->get()->row_array();
                $location = (array)json_decode($assignment['location']);
                
                $this->db->select('country_id, name, code');
                $this->db->where_in('country_id', $location['country']);
                $countries = $this->db->where('status', 1)->get('lkp_country')->result_array();

                $data['countries'] = $countries;
                break;
        }

        return $data;
    }

    public function survey_approvel_data($data){
        $user_id=$this->session->userdata['login_id'];
        $curent_page = $data['curent_page'];
        $total_records_per_page = $data['total_records_per_page'];
        $survey_table = 'survey'.$data['survey_id'];
        $this->db->distinct()->select('ifd.*, concat(tu.first_name, " ", tu.last_name) as username, ');
        $this->db->join('tbl_users AS tu', 'tu.user_id = ifd.user_id');
        $survey_data = $this->db->where('ifd.status', 2)->order_by('ifd.id', 'DESC')->limit($total_records_per_page,($total_records_per_page*$curent_page)-($total_records_per_page))->get($survey_table.' AS ifd')->result_array();
        foreach ($survey_data as $key => $field) {

            $data_id = $field['data_id'];
            $this->db->select('file_name');
            $this->db->where('data_id', $data_id )->where('status', 1);
            $upload_link = $this->db->get('ic_data_file')->row_array();

            $this->db->select('field_id');
            $this->db->where('type', 'uploadfile')->where('form_id', $data['survey_id'] )->where('status', 1);
            $upload_fields = $this->db->get('form_field')->row_array();

            if(!empty($upload_fields)){
                $survey_data[$key]['field_'.$upload_fields['field_id']]= $upload_link['file_name'] ?? null;
            }
        }
        return $survey_data;
    }

    public function survey_approvel_records($survey_id){
        $user_id=$this->session->userdata['login_id'];
        $survey_table = 'survey'.$survey_id;
        $data = $this->db->where('ifd.status', 2)->order_by('ifd.id', 'DESC')->get($survey_table.' AS ifd')->num_rows();
       return $data;
    }

    public function survey_rejected_data($data){
        $user_id=$this->session->userdata['login_id'];
        $curent_page = $data['curent_page'];
        $total_records_per_page = $data['total_records_per_page'];
        $survey_table = 'survey'.$data['survey_id'];
        $this->db->distinct()->select('ifd.*, concat(tu.first_name, " ", tu.last_name) as username, ');
        $this->db->join('tbl_users AS tu', 'tu.user_id = ifd.user_id');
        $survey_data = $this->db->where('ifd.status', 0)->where('ifd.verified_status', 0)->order_by('ifd.id', 'DESC')->limit($total_records_per_page,($total_records_per_page*$curent_page)-($total_records_per_page))->get($survey_table.' AS ifd')->result_array();
        foreach ($survey_data as $key => $field) {

            $data_id = $field['data_id'];
            $this->db->select('file_name');
            $this->db->where('data_id', $data_id )->where('status', 1);
            $upload_link = $this->db->get('ic_data_file')->row_array();

            $this->db->select('field_id');
            $this->db->where('type', 'uploadfile')->where('form_id', $data['survey_id'] )->where('status', 1);
            $upload_fields = $this->db->get('form_field')->row_array();
            if(!empty($upload_fields)){
                $survey_data[$key]['field_'.$upload_fields['field_id']]= $upload_link['file_name'] ?? null;
            }
            
        }
        return $survey_data;
    }
    public function survey_rejected_records($survey_id){
        $user_id=$this->session->userdata['login_id'];
        $survey_table = 'survey'.$survey_id;
        $data = $this->db->where('ifd.status', 0)->where('ifd.verified_status', 0)->order_by('ifd.id', 'DESC')->get($survey_table.' AS ifd')->num_rows();
       return $data;
    }


    public function get_tech_types($compact_id){
        //block list
        $this->db->distinct();
        $this->db->select('tech_type_id');
        $this->db->where('compact_id', $compact_id)->where('status', 1);
        $unique_types = $this->db->get('tbl_technology_relation')->result_array();
        // $test = $this->db->last_query(); 
        // print_r($test);exit();
        $tech_type_list = array();
        foreach ($unique_types as $key => $type) {
            $tech_type_details = $this->db->select('tech_type_id, technology_type')->where('status', 1)->where('tech_type_id', $type['tech_type_id'])->get('lkp_technology_type')->row_array();
            if($tech_type_details != NULL){
                $tech_type_list[$key]['tech_type_id'] = $tech_type_details['tech_type_id'];
                $tech_type_list[$key]['technology_type'] = $tech_type_details['technology_type'];
            }
        }

        return $tech_type_list;
    }
    public function get_toolkit_type($compact_id){
        //block list
        $this->db->distinct();
        $this->db->select('toolkit_id,toolkit_name');
        $this->db->where('compact_id', $compact_id)->where('status', 1);
        $tooltip_list = $this->db->get('tbl_toolkit')->result_array();
        return $tooltip_list;
    }

    public function get_tech_deployes($data){
        //block list
        $this->db->distinct();
        $this->db->select('tech_deployed_id');
        $this->db->where('compact_id', $data['compact_id'])->where('tech_type_id', $data['tech_type_id'])->where('status', 1);
        // $this->db->where('tech_type_id', $data['tech_type_id'])->where('status', 1);
        $unique_deployes = $this->db->get('tbl_technology_relation')->result_array();
        // $test = $this->db->last_query(); 
        // var_dump($test);exit();
        $tech_deployed_list = array();
        foreach ($unique_deployes as $key => $deployed) {
            $tech_deployed_details = $this->db->select('tech_deployed_id, tech_deployed')->where('status', 1)->where('tech_deployed_id', $deployed['tech_deployed_id'])->get('lkp_technology_deployed')->row_array();
            if($tech_deployed_details != NULL){
                $tech_deployed_list[$key]['tech_deployed_id'] = $tech_deployed_details['tech_deployed_id'];
                $tech_deployed_list[$key]['tech_deployed'] = $tech_deployed_details['tech_deployed'];
            }
        }
        // var_dump($tech_deployed_list);exit();

        return $tech_deployed_list;
    }
    public function get_tech_deployes_type($data){
        //block list
        $this->db->distinct();
        $this->db->select('tech_deployed_id');
        // $this->db->where('compact_id', $data['compact_id'])->where('tech_type_id', $data['tech_type_id'])->where('status', 1);
        $this->db->where('compact_id', $data['compact_id'])->where('status', 1);
        $unique_deployes = $this->db->get('tbl_technology_relation')->result_array();
        // $test = $this->db->last_query(); 
        // var_dump($test);exit();
        $tech_deployed_list = array();
        foreach ($unique_deployes as $key => $deployed) {
            $tech_deployed_details = $this->db->select('tech_deployed_id, tech_deployed')->where('status', 1)->where('tech_deployed_id', $deployed['tech_deployed_id'])->get('lkp_technology_deployed')->row_array();
            if($tech_deployed_details != NULL){
                $tech_deployed_list[$key]['tech_deployed_id'] = $tech_deployed_details['tech_deployed_id'];
                $tech_deployed_list[$key]['tech_deployed'] = $tech_deployed_details['tech_deployed'];
            }
        }
        // var_dump($tech_deployed_list);exit();

        return $tech_deployed_list;
    }

    public function get_tech_verities($data){
        //block list
        $this->db->distinct();
        $this->db->select('tech_varieties_id');
        $this->db->where('compact_id', $data['compact_id'])->where('tech_type_id', $data['tech_type_id'])->where('tech_deployed_id', $data['tech_deployed_id'])->where('status', 1);
        $unique_deployes = $this->db->get('tbl_technology_relation')->result_array();
        // $test = $this->db->last_query(); 
        // var_dump($test);exit();
        $tech_verities_list = array();
        foreach ($unique_deployes as $key => $deployed) {
            $tech_verities_details = $this->db->distinct()->select('tech_varieties_id, technology_varieties')->where('status', 1)->where('tech_varieties_id', $deployed['tech_varieties_id'])->get('lkp_technology_varieties')->row_array();
            if($tech_verities_details != NULL){
                $tech_verities_list[$key]['tech_varieties_id'] = $tech_verities_details['tech_varieties_id'];
                $tech_verities_list[$key]['technology_varieties'] = $tech_verities_details['technology_varieties'];
            }
        }
        // var_dump($tech_verities_list);exit();

        return $tech_verities_list;
    }

    public function compact_data($data){
        $this->db->where('status', 1);
		$surveys = $this->db->get('form')->result_array();
		foreach ($surveys as $key => $survey) {
            // Get compact field id
            $this->db->where('form_id', $survey['id'])->where('status', 1);
            $compact = $this->db->where('type', 'lkp_compact')->get('form_field')->row_array();
            // Get year field id
            $this->db->where('form_id', $survey['id'])->where('status', 1);
            $year = $this->db->where('type', 'lkp_year')->get('form_field')->row_array();
            // Get quater field id
            $this->db->where('form_id', $survey['id'])->where('status', 1);
            $quater = $this->db->where('type', 'lkp_quarter')->get('form_field')->row_array();
            // Get quater field id
            $this->db->where('form_id', $survey['id'])->where('status', 1);
            $actual = $this->db->where('type', 'lkp_actual')->get('form_field')->row_array();
            if($survey['id'] != 68){
				$this->db->where('form_id', $survey['id'])->where('status', 1);
				$field = $this->db->where('label', 'Actual count')->get('form_field')->row_array();
			}else{
				$this->db->where('form_id', $survey['id'])->where('status', 1);
				$field = $this->db->where('label', 'Amount leveraged (USD million)')->get('form_field')->row_array();
			}
            $survey_table = 'survey'.$survey['id'];
            $this->db->select('*');
            if(isset($compact) &&
            (isset($data['compact_id']))) {
                $col_compact = 'field_'.$compact['field_id'];
                $this->db->where($col_compact, $data['compact_id']);
            }
            if(isset($quater) &&
            (isset($data['quarter_id']))) {
                $col_quater = 'field_'.$quater['field_id'];
                $this->db->where($col_quater, $data['quarter_id']);
            }
            if(isset($year) &&
            (isset($data['year_id']))) {
                $col_year = 'field_'.$year['field_id'];
                if($survey['id'] !=17){
                    $this->db->where($col_year, $data['year_id']);
                }
            }
            $result_list = $this->db->where('status', 1)->get($survey_table)->result_array();
            $attribution_count = 0;
            $contribution_count = 0;
            foreach($result_list as $vkey => $value){
                if(isset($actual)){
                    $col_actual = 'field_'.$actual['field_id']; 
                    if($value[$col_actual] == "1") {
                       
                            $temp = 0;
                            $column_count = 'field_'.$field['field_id'];
                            $temp = intval($value[$column_count]);
                            $attribution_count = $attribution_count+$temp;
                        
                    }
                    if($value[$col_actual] == "2") {
                        $temp = 0;
                        $column_count = 'field_'.$field['field_id'];
                        $temp = intval($value[$column_count]);
                        $contribution_count = $contribution_count+$temp;
                        
                    }
                }
                
            }
            $surveys[$key]['attribution_count'] = round($attribution_count,2);
            $surveys[$key]['contribution_count'] = round($contribution_count,2);
            $target_value = 1;
            $surveys[$key]['target'] = 'N/A';
            $target_percent = 0;
            if($attribution_count == 0 && $contribution_count == 0){

            }else{
                $target_percent = ((($attribution_count)/($target_value))*100);
            }
            $surveys[$key]['target_percent'] =  $target_percent;
            if($target_percent >= 100){
                $target_percent_status = 1; 
            }elseif($target_percent > 50 && $target_percent <= 99){
                $target_percent_status = 2;
            }elseif($target_percent > 25 && $target_percent <= 49){
                $target_percent_status = 3;
            }elseif($target_percent > 0 && $target_percent <= 24){
                $target_percent_status = 4;
            }else{
                $target_percent_status = 5;
            }

            $surveys[$key]['target_percent_status'] =  $target_percent_status;
        }
        return $surveys;
    }


   
}
