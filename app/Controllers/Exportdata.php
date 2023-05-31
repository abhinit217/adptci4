<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportdata extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('user_agent');

        $this->load->model('Reporting_model');
	}


    public function survey_dataexport(){
        require(APPPATH .'third_party/PHPExcel.php');
        require(APPPATH .'third_party/PHPExcel/Writer/Excel2007.php');

        $survey_id=$this->uri->segment(3);
        
        $form_data = $this->db->select('id ,title')->where('id',$survey_id)->get('form')->row_array();
        
        //get survey fields
        $this->db->select('field_id, label, type, status');
        $this->db->where('form_id',$form_data['id']);
        $this->db->order_by('slno');
        $form_fields = $this->db->get('form_field')->result_array();
        
        //get options of all the fields
        $this->db->select('form_field.label as field_label, form_field_multiple.label as multiple_label, form_field.field_id, form_field.type, form_field.label as field_label, form_field_multiple.status as status, multi_id'); 
        $this->db->from('form_field_multiple');
        $this->db->join('form_field', 'form_field.field_id = form_field_multiple.field_id' );
        $this->db->where('form_field.form_id', $form_data['id']);
        $form_multiples = $this->db->get()->result_array();                 

        //get list of all lookup tables
        $this->db->distinct()->select('type');
        $this->db->where('form_id',$form_data['id'])->like('type','lkp_');
        $get_unique_lkp_tables = $this->db->get('form_field')->result_array();

        $get_unique_lkp_tables_array = array();
        foreach($get_unique_lkp_tables as $table){
            array_push($get_unique_lkp_tables_array, $table['type']);
        }

        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->getProperties()->setCreator("Measure");
        $objPHPExcel->getProperties()->setLastModifiedBy("");
        $objPHPExcel->getProperties()->setTitle("Survey data - OLM");
        $objPHPExcel->getProperties()->setSubject("");
        
        //print of survey fields
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1,'Field Id');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1,'Field Type');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1,'Label'); 
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1,'Status'); 
        $metacol = 2; //columnnumber

        foreach ($form_fields as $key => $field){
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $metacol, 'field_'.$field['field_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $metacol, $field['type']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $metacol, $field['label']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $metacol, $field['status']);
            $metacol++;
        }
        $objPHPExcel->getActiveSheet()->setTitle("form_fields"); //formfields

        $i = 1;

        //print of the options related to survey 
        if(count($form_multiples)){
            $objPHPExcel->createSheet();
            $objPHPExcel->setActiveSheetIndex($i);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Field Id');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'Label'); 
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'Type');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'Option Id');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'Type Label');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, 'Status');
            $metacol = 2; //columnnumber
            foreach($form_multiples as $multiples){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $metacol, $multiples['field_id']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $metacol, $multiples['field_label']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $metacol, $multiples['type']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $metacol, $multiples['multi_id']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $metacol, $multiples['multiple_label']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $metacol, $multiples['status']);
                $metacol++;
            }
            $objPHPExcel->getActiveSheet()->setTitle("form_field_multiple");
        }

        //print of data related to all lookup tables
        if(count($get_unique_lkp_tables_array)){
            foreach($get_unique_lkp_tables_array as $tbl){
                $i++;

                $lkp_table_columns = $this->db->list_fields($tbl);
               
                $objPHPExcel->createSheet();
                $objPHPExcel->setActiveSheetIndex($i);
                $column_col = 0;
                foreach ($lkp_table_columns as $key => $field){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column_col, 1, $field);
                    $column_col++;
                }

                $lkp_table = $this->db->select('*')->get($tbl)->result_array();

                $row=2;         
                foreach ($lkp_table as $key => $data) {
                    $metacol = 0;

                    foreach ($lkp_table_columns as $key => $column) {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($metacol, $row, $data[$column]);
                        $metacol++;
                    }
                    $row++;
                }
                $objPHPExcel->getActiveSheet()->setTitle($tbl); //$g[type]
            }
        }

        $table_name = "ic_form_data";
        $i++;
        //to check survey contains any group field
        $this->db->select('field_id');
        $this->db->where('type', 'group')->where('form_id', $survey_id)->where('status', 1);
        $check_group_field = $this->db->get('form_field')->num_rows();

        //printing of the data related to survey table
        $surveytable_columns = $this->db->list_fields($table_name);

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex($i);

        $form_fields = $this->Reporting_model->get_form_fields($survey_id);

        $metacol = 0;
        foreach ($surveytable_columns as $key => $field){
            if($field == 'form_data'){
                foreach ($form_fields as $key => $field){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($metacol, 1, $field['label']);
                    $metacol++;
                }
            }else{
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($metacol, 1, $field);
                $metacol++;
            }
        }

        $this->db->select('*');
        $this->db->where('form_id', $survey_id)->where('project_id', 1)->where('data_status', 1);
        $this->db->order_by('id', 'DESC');
        $surveydata = $this->db->get($table_name)->result_array();

        $row=2;         
        foreach ($surveydata as $key => $data) {
            $metacol = 0;

            foreach ($surveytable_columns as $key => $column) {

                if($column == 'form_data'){
                    $jsondata = json_decode($data['form_data'], true);

                    foreach ($form_fields as $key => $field){
                        $field_var = "field_".$field['field_id'];

                        $val = isset($jsondata[$field_var]) ? $jsondata[$field_var] : "N/A";

                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($metacol, $row, $val);
                        $metacol++;
                    }
                }else{
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($metacol, $row, $data[$column]);
                    $metacol++;
                }                   
            }
            $row++;
        }

        $objPHPExcel->getActiveSheet()->setTitle($table_name);

        //group data
        $this->db->select('*');
        $this->db->where('type', 'group')->where('form_id', $survey_id)->where('status', 1);
        $group_fieldinfo = $this->db->get('form_field')->result_array();

        foreach ($group_fieldinfo as $key => $value) {            

            $group_tablename = "ic_form_group_data";
            $i++;
            $surveytable_group_columns = $this->db->list_fields($group_tablename);

            $objPHPExcel->createSheet();
            $objPHPExcel->setActiveSheetIndex($i);

            $child_array = explode(",", $value['child_id']);

            $metacol = 0;
            foreach ($surveytable_group_columns as $key => $field){
                if($field == 'formgroup_data'){
                    foreach ($child_array as $key => $fieldid) {
                        $getlablename = $this->db->select('label')->where('field_id', $fieldid)->get('form_field')->row_array();
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($metacol, 1, $getlablename['label']);
                        $metacol++;
                    }
                }else{
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($metacol, 1, $field);
                    $metacol++;
                }
            }

            $this->db->select('*');
            $this->db->where('form_id', $survey_id)->where('groupfield_id', $value['field_id'])->where('data_status', 1);
            $this->db->order_by('reg_date_time', 'DESC');
            $surveygroupdata = $this->db->get($group_tablename)->result_array();

            $row=2;         
            foreach ($surveygroupdata as $key => $groupdata) {
                $metacol = 0;

                foreach ($surveytable_group_columns as $key => $column) {

                    if($column == 'formgroup_data'){
                        $group_jsondata = json_decode($groupdata['formgroup_data'], true);

                        foreach ($child_array as $key => $fieldid){
                            $field_var = "field_".$fieldid;

                            $val = isset($group_jsondata[$field_var]) ? $group_jsondata[$field_var] : "N/A";

                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($metacol, $row, $val);
                            $metacol++;
                        }
                    }else{
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($metacol, $row, $groupdata[$column]);
                        $metacol++;
                    }                   
                }
                $row++;
            }

            $objPHPExcel->getActiveSheet()->setTitle($value['label']);
        }
        
        $filename = "beneficary_dataexport.xlsx"; 
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(getcwd()."/uploads/data/".$filename);
        //$objWriter->save('php://output');
    }

} ?>