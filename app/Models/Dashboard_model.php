<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    
	public function __construct() {
		parent::__construct();
		$this->load->library('session');		
	}

	public function monitoring_evauation($data){
		$year = $data['year'];
		$country = $data['country'];
		$crop = $data['crop'];
		$po_id = $data['po_id'];

		$this->db->distinct()->select('GROUP_CONCAT(output_id) as outputs');
		$this->db->where('year_id', $year)->where('status', 1);
		if(isset($data['user_id'])){
			$this->db->where('user_id', $data['user_id']);
		}		
		$outputs = $this->db->get('tbl_user_indicator')->row_array();
		$user_outputs = explode(",", $outputs['outputs']);

		$this->db->distinct()->select('GROUP_CONCAT(indicator_id) as indicators');
		$this->db->where('year_id', $year)->where('status', 1);
		if(isset($data['user_id'])){
			$this->db->where('user_id', $data['user_id']);
		}
		$indicators = $this->db->get('tbl_user_indicator')->row_array();
		$user_indicators = explode(",", $indicators['indicators']);

		$this->db->distinct()->select('GROUP_CONCAT(sub_indicator_id) as subindicators');
		$this->db->where('year_id', $year)->where('status', 1);
		if(isset($data['user_id'])){
			$this->db->where('user_id', $data['user_id']);
		}
		$subindicators = $this->db->get('tbl_user_indicator')->row_array();
		$user_subindicators = explode(",", $subindicators['subindicators']);

		$this->db->select('GROUP_CONCAT(form_id) as outputid');
        $this->db->where('rel.relation_status', 1)->where('rel.form_type', 1);
        $this->db->where('rel.lkp_po_id', $po_id)->where('rel.output_id IS NULL')->where('rel.indicator_id IS NULL')->where('lkp_year', $year)->where_in('form_id', $user_outputs);
        $output_list = $this->db->get('rpt_form_relation as rel')->row_array();

        $output_list_array = explode(",", $output_list['outputid']);

        $this->db->select('*');
        $this->db->where('status', 1)->where('type', 1)->where_in('id', $output_list_array);
        $outputs = $this->db->get('form')->result_array();

        foreach ($outputs as $o_key => $output_val) {
            $outputs[$o_key]['field_count'] = $this->db->where('form_id', $output_val['id'])->where('status', 1)->get('form_field')->num_rows();
            
            $this->db->where('form_id', $output_val['id'])->where('year_id', $year)->where('status', 2);
            if($country != 'all'){
                $this->db->where('country_id', $country);
            }
            if($crop != 'all'){
                $this->db->where('crop_id', $crop);
            }
            if(isset($data['user_id'])){
				$this->db->where('user_id', $data['user_id']);
			}
            $outputs[$o_key]['upload_count'] = $this->db->get('ic_form_data')->num_rows();

            $this->db->select('GROUP_CONCAT(form_id) as indicator_id');
            $this->db->where('rel.relation_status', 1)->where('rel.form_type', 2);
            $this->db->where('rel.lkp_po_id', $po_id)->where('output_id', $output_val['id'])->where('rel.indicator_id IS NULL')->where('lkp_year', $year)->where_in('form_id', $user_indicators);
            $indicator_list = $this->db->get('rpt_form_relation as rel')->row_array();

            $indicator_list_array = explode(",", $indicator_list['indicator_id']);

            $this->db->select('*');
            $this->db->where('status', 1)->where('type', 2)->where_in('id', $indicator_list_array);
            $this->db->order_by('slno');
            $indicators = $this->db->get('form')->result_array();

            foreach ($indicators as $i_key => $ind_val) {
                $indicators[$i_key]['field_count'] = $this->db->where('form_id', $ind_val['id'])->where('status', 1)->get('form_field')->num_rows();

                //get saved count
                $this->db->select('data_id');
                $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 1);
                if($country != 'all'){
                    $this->db->where('country_id', $country);
                }
                if($crop != 'all'){
                    $this->db->where('crop_id', $crop);
                }
                if(isset($data['user_id'])){
					$this->db->where('user_id', $data['user_id']);
				}
                $indicators[$i_key]['saved_count'] = $this->db->get('ic_form_data')->num_rows();
                
                //get submitted count
                $this->db->select('data_id');
                $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where(array('status >=' => 2, 'status <' => 4));
                if($country != 'all'){
                    $this->db->where('country_id', $country);
                }
                if($crop != 'all'){
                    $this->db->where('crop_id', $crop);
                }
                if(isset($data['user_id'])){
					$this->db->where('user_id', $data['user_id']);
				}
                $indicators[$i_key]['submitted_count'] = $this->db->get('ic_form_data')->num_rows();

                //get pending approval count
                $this->db->select('data_id');
                $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 2);
                if($country != 'all'){
                    $this->db->where('country_id', $country);
                }
                if($crop != 'all'){
                    $this->db->where('crop_id', $crop);
                }
                if(isset($data['user_id'])){
                    $this->db->where('user_id', $data['user_id']);
                }
                $indicators[$i_key]['pendingapproval_count'] = $this->db->get('ic_form_data')->num_rows();

                //get approved count
                $this->db->select('data_id');
                $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                if($country != 'all'){
                    $this->db->where('country_id', $country);
                }
                if($crop != 'all'){
                    $this->db->where('crop_id', $crop);
                }
                if(isset($data['user_id'])){
					$this->db->where('user_id', $data['user_id']);
				}
                $indicators[$i_key]['approved_count'] = $this->db->get('ic_form_data')->num_rows();

                // Query Pending
                $this->db->select('data_id');
                $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status !=', 0)->where('query_status', 1);
                if($country != 'all'){
                    $this->db->where('country_id', $country);
                }
                if($crop != 'all'){
                    $this->db->where('crop_id', $crop);
                }
                if(isset($data['user_id'])){
                    $this->db->where('user_id', $data['user_id']);
                }
                $indicators[$i_key]['query_pen'] = $this->db->get('ic_form_data')->num_rows();

                // Query Responded
                $this->db->select('data_id');
                $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status !=', 0)->where('query_status', 2);
                if($country != 'all'){
                    $this->db->where('country_id', $country);
                }
                if($crop != 'all'){
                    $this->db->where('crop_id', $crop);
                }
                if(isset($data['user_id'])){
                    $this->db->where('user_id', $data['user_id']);
                }
                $indicators[$i_key]['query_res'] = $this->db->get('ic_form_data')->num_rows();

                //monitoring and evalution page showing current user query count
                if(isset($_POST['page_type']) && $_POST['page_type'] == 'monitoring_evaluation'){
                    // Query Pending
                    $this->db->select('data_id');
                    $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status !=', 0)->where('query_status', 1);
                    if($country != 'all'){
                        $this->db->where('country_id', $country);
                    }
                    if($crop != 'all'){
                        $this->db->where('crop_id', $crop);
                    }
                    $this->db->where('user_id', $this->session->userdata('login_id'));
                    $indicators[$i_key]['my_query_pen'] = $this->db->get('ic_form_data')->num_rows();

                    // Query Responded
                    $this->db->select('data_id');
                    $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status !=', 0)->where('query_status', 2);
                    if($country != 'all'){
                        $this->db->where('country_id', $country);
                    }
                    if($crop != 'all'){
                        $this->db->where('crop_id', $crop);
                    }
                    $this->db->where('user_id', $this->session->userdata('login_id'));
                    $indicators[$i_key]['my_query_res'] = $this->db->get('ic_form_data')->num_rows();
                }


                $this->db->select('GROUP_CONCAT(form_id) as subindicator_id');
                $this->db->where('rel.relation_status', 1)->where('rel.form_type', 3);
                $this->db->where('rel.lkp_po_id', $po_id)->where('output_id', $output_val['id'])->where('rel.indicator_id', $ind_val['id'])->where('lkp_year', $year)->where_in('form_id', $user_subindicators);
                $subindicator_list = $this->db->get('rpt_form_relation as rel')->row_array();

                $subindicator_list_array = explode(",", $subindicator_list['subindicator_id']);

                $this->db->select('*');
                $this->db->where('status', 1)->where('type', 3)->where_in('id', $subindicator_list_array);
                $this->db->order_by('slno');
                $subindicators = $this->db->get('form')->result_array();
                foreach ($subindicators as $s_key => $subind) {
                    $subindicators[$s_key]['field_count'] = $this->db->where('form_id', $subind['id'])->where('status', 1)->get('form_field')->num_rows();

                    //get saved count
                    $this->db->select('data_id');
                    $this->db->where('form_id', $subind['id'])->where('year_id', $year)->where('status', 1);
                    if($country != 'all'){
                        $this->db->where('country_id', $country);
                    }
                    if($crop != 'all'){
                        $this->db->where('crop_id', $crop);
                    }
                    if(isset($data['user_id'])){
						$this->db->where('user_id', $data['user_id']);
					}
                    $subindicators[$s_key]['saved_count'] = $this->db->get('ic_form_data')->num_rows();

                    //get submitted count
                    $this->db->select('data_id');
                    $this->db->where('form_id', $subind['id'])->where('year_id', $year)->where(array('status >=' => 2, 'status <' => 4));
                    if($country != 'all'){
                        $this->db->where('country_id', $country);
                    }
                    if($crop != 'all'){
                        $this->db->where('crop_id', $crop);
                    }
                    if(isset($data['user_id'])){
						$this->db->where('user_id', $data['user_id']);
					}
                    $subindicators[$s_key]['submitted_count'] = $this->db->get('ic_form_data')->num_rows();

                    //get pending approval count
                    $this->db->select('data_id');
                    $this->db->where('form_id', $subind['id'])->where('year_id', $year)->where('status', 2);
                    if($country != 'all'){
                        $this->db->where('country_id', $country);
                    }
                    if($crop != 'all'){
                        $this->db->where('crop_id', $crop);
                    }
                    if(isset($data['user_id'])){
                        $this->db->where('user_id', $data['user_id']);
                    }
                    $subindicators[$s_key]['pendingapproval_count'] = $this->db->get('ic_form_data')->num_rows();

                    //get approved count
                    $this->db->select('data_id');
                    $this->db->where('form_id', $subind['id'])->where('year_id', $year)->where('status', 3);
                    if($country != 'all'){
                        $this->db->where('country_id', $country);
                    }
                    if($crop != 'all'){
                        $this->db->where('crop_id', $crop);
                    }
                    if(isset($data['user_id'])){
						$this->db->where('user_id', $data['user_id']);
					}
                    $subindicators[$s_key]['approved_count'] = $this->db->get('ic_form_data')->num_rows();

                    // Query Pending
                    $this->db->select('data_id');
                    $this->db->where('form_id', $subind['id'])->where('year_id', $year)->where('status !=', 0)->where('query_status', 1);
                    if($country != 'all'){
                        $this->db->where('country_id', $country);
                    }
                    if($crop != 'all'){
                        $this->db->where('crop_id', $crop);
                    }
                    if(isset($data['user_id'])){
                        $this->db->where('user_id', $data['user_id']);
                    }
                    $subindicators[$s_key]['query_pen'] = $this->db->get('ic_form_data')->num_rows();

                    // Query Responded
                    $this->db->select('data_id');
                    $this->db->where('form_id', $subind['id'])->where('year_id', $year)->where('status !=', 0)->where('query_status', 2);
                    if($country != 'all'){
                        $this->db->where('country_id', $country);
                    }
                    if($crop != 'all'){
                        $this->db->where('crop_id', $crop);
                    }
                    if(isset($data['user_id'])){
                        $this->db->where('user_id', $data['user_id']);
                    }
                    $subindicators[$s_key]['query_res'] = $this->db->get('ic_form_data')->num_rows();

                    //monitoring and evalution page showing current user query count
                    if(isset($_POST['page_type']) && $_POST['page_type'] == 'monitoring_evaluation'){
                        // Query Pending
                        $this->db->select('data_id');
                        $this->db->where('form_id', $subind['id'])->where('year_id', $year)->where('status !=', 0)->where('query_status', 1);
                        if($country != 'all'){
                            $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('user_id', $this->session->userdata('login_id'));
                        $subindicators[$s_key]['my_query_pen'] = $this->db->get('ic_form_data')->num_rows();

                        // Query Responded
                        $this->db->select('data_id');
                        $this->db->where('form_id', $subind['id'])->where('year_id', $year)->where('status !=', 0)->where('query_status', 2);
                        if($country != 'all'){
                            $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('user_id', $this->session->userdata('login_id'));
                        $subindicators[$s_key]['my_query_res'] = $this->db->get('ic_form_data')->num_rows();
                    }

                    $indicators[$i_key]['saved_count'] +=  $subindicators[$s_key]['saved_count'];
                    $indicators[$i_key]['submitted_count'] +=  $subindicators[$s_key]['submitted_count'];
                    $indicators[$i_key]['pendingapproval_count'] +=  $subindicators[$s_key]['pendingapproval_count'];
                    $indicators[$i_key]['approved_count'] +=  $subindicators[$s_key]['approved_count'];
                    $indicators[$i_key]['query_pen'] +=  $subindicators[$s_key]['query_pen'];
                    $indicators[$i_key]['query_res'] +=  $subindicators[$s_key]['query_res'];

                    //monitoring and evalution page showing current user query count
                    if(isset($_POST['page_type']) && $_POST['page_type'] == 'monitoring_evaluation'){
                        $indicators[$i_key]['my_query_pen'] +=  $subindicators[$s_key]['my_query_pen'];
                        $indicators[$i_key]['my_query_res'] +=  $subindicators[$s_key]['my_query_res'];
                    }
                }
                $indicators[$i_key]['subindicator_list'] = $subindicators;
            }
            $outputs[$o_key]['indicator_list'] = $indicators;
        }

        return $outputs;
	}

    public function calculate_result_tracker($data){
        $year = $data['year'];
        $country = $data['country'];
        $crop = $data['crop'];
        $po_id = $data['po_id'];

        $this->db->select('GROUP_CONCAT(distinct output_id) as outputs');
        $this->db->where('year_id', $year)->where('status', 1);
        if(is_array($po_id)){
            $this->db->where_in('po_id', $po_id);
        }else{
            $this->db->where('po_id', $po_id);
        }
        if ($this->session->userdata('role') == 4) {
            $this->db->where('user_id', $this->session->userdata('login_id'));
            $outputs = $this->db->get('tbl_user_resulttrack_indicator')->row_array();
        }else{
            $outputs = $this->db->get('tbl_user_indicator')->row_array();
        }        
        $user_outputs = explode(",", $outputs['outputs']);

        $this->db->select('GROUP_CONCAT(distinct indicator_id) as indicators');
        $this->db->where('year_id', $year)->where('status', 1);
        if(is_array($po_id)){
            $this->db->where_in('po_id', $po_id);
        }else{
            $this->db->where('po_id', $po_id);
        }
        if ($this->session->userdata('role') == 4) {
            $this->db->where('user_id', $this->session->userdata('login_id'));
            $indicators = $this->db->get('tbl_user_resulttrack_indicator')->row_array();
        }else{
            $indicators = $this->db->get('tbl_user_indicator')->row_array();
        }
        $user_indicators = explode(",", $indicators['indicators']);

        $this->db->select('GROUP_CONCAT(distinct sub_indicator_id) as subindicators');
        $this->db->where('year_id', $year)->where('status', 1);
        if(is_array($po_id)){
            $this->db->where_in('po_id', $po_id);
        }else{
            $this->db->where('po_id', $po_id);
        }
        if ($this->session->userdata('role') == 4) {
            $this->db->where('user_id', $this->session->userdata('login_id'));
            $subindicators = $this->db->get('tbl_user_resulttrack_indicator')->row_array();
        }else{
            $subindicators = $this->db->get('tbl_user_indicator')->row_array();
        }
        $user_subindicators = explode(",", $subindicators['subindicators']);
        
        $this->db->select('GROUP_CONCAT(form_id) as outputid');
        $this->db->where('rel.relation_status', 1)->where('rel.form_type', 1);
        if(is_array($po_id)){
            $this->db->where_in('rel.lkp_po_id', $po_id);
        }else{
            $this->db->where('rel.lkp_po_id', $po_id);
        }        
        $this->db->where('rel.output_id IS NULL')->where('rel.indicator_id IS NULL')->where('lkp_year', $year)->where_in('form_id', $user_outputs);
        $output_list = $this->db->get('rpt_form_relation as rel')->row_array();
        $output_list_array = explode(",", $output_list['outputid']);

        $this->db->select('*');
        $this->db->where('status', 1)->where('type', 1)->where_in('id', $output_list_array);
        $outputs = $this->db->get('form')->result_array();

        foreach ($outputs as $o_key => $output_val) {
            $outputs[$o_key]['field_count'] = $this->db->where('form_id', $output_val['id'])->where('status', 1)->get('form_field')->num_rows();

            $this->db->select('GROUP_CONCAT(form_id) as indicator_id');
            $this->db->where('rel.relation_status', 1)->where('rel.form_type', 2);
            if(is_array($po_id)){
                $this->db->where_in('rel.lkp_po_id', $po_id);
            }else{
                $this->db->where('rel.lkp_po_id', $po_id);
            }
            $this->db->where('output_id', $output_val['id'])->where('rel.indicator_id IS NULL')->where('lkp_year', $year)->where_in('form_id', $user_indicators);
            $indicator_list = $this->db->get('rpt_form_relation as rel')->row_array();

            $indicator_list_array = explode(",", $indicator_list['indicator_id']);

            $this->db->select('*');
            $this->db->where('status', 1)->where('type', 2)->where_in('id', $indicator_list_array);
            $this->db->order_by('slno');
            $indicators = $this->db->get('form')->result_array();

            foreach ($indicators as $i_key => $ind_val) {
                switch ($ind_val['id']) {
                    //case for indicator to get submission count
                    case 102:
                    case 158:
                    case 104:
                    case 155:
                    case 97:
                    case 73:
                    case 37:
                    case 45:
                    case 156:
                    case 69:
                        $this->db->select('data_id');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $actual_val = $this->db->get('ic_form_data')->num_rows();
                        break;

                    //case for indicators to take addmore count
                    case 77:
                    case 78:
                    case 80:
                    case 82:
                    case 86:
                    case 87:
                    case 96:
                    case 98:
                    case 70:
                    case 36:
                    case 46:
                    case 47:
                    case 48:
                    case 49:
                    case 39:
                    case 103:
                    case 159:
                    case 66:
                    case 61:
                        $this->db->select('data.data_id, group.group_id');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $actual_val = $this->db->get()->num_rows();
                        break;

                    case 154:
                        $this->db->distinct();
                        $this->db->select('form_id, year_id, country_id, crop_id');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $actual_val = $this->db->get('ic_form_data')->num_rows();
                        break;

                    case 79:
                        $subindicator_list_79 = array(131, 132, 133, 134, 135, 136, 137);
                        $this->db->select('data.data_id, group.group_id');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where_in('data.form_id', $subindicator_list_79)->where_in('group.form_id', $subindicator_list_79);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $actual_val = $this->db->get()->num_rows();
                        break;

                    case 81:
                        $subindicator_list_81 = array(125, 126);
                        $this->db->select('data.data_id, group.group_id');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where_in('data.form_id', $subindicator_list_81)->where_in('group.form_id', $subindicator_list_81);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $actual_val = $this->db->get()->num_rows();
                        break;

                    case 44:
                        $subindicator_list_81 = array(117, 118);
                        $this->db->select('data.data_id, group.group_id');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where_in('data.form_id', $subindicator_list_81)->where_in('group.form_id', $subindicator_list_81);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $actual_val = $this->db->get()->num_rows();
                        break;

                    case 35:
                        //subindicator 113
                        $subindicator_113_count = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 113)->where('group.form_id', 113);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $subindicator_113 = $this->db->get()->result_array();
                        foreach ($subindicator_113 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_544'] != NULL && $array_data['field_544'] > 0){
                                $subindicator_113_count++;
                            }
                        }

                        //subindicator 114
                        $subindicator_114_count = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 114)->where('group.form_id', 114);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $subindicator_114 = $this->db->get()->result_array();
                        foreach ($subindicator_114 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_545'] != NULL && $array_data['field_545'] > 0){
                                $subindicator_114_count++;
                            }
                        }

                        //subindicator 115
                        $subindicator_115_count = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 115)->where('group.form_id', 115);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $subindicator_115 = $this->db->get()->result_array();
                        foreach ($subindicator_115 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_546'] != NULL && $array_data['field_546'] > 0){
                                $subindicator_115_count++;
                            }
                        }

                        //subindicator 116
                        $subindicator_116_count = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 116)->where('group.form_id', 116);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $subindicator_116 = $this->db->get()->result_array();
                        foreach ($subindicator_116 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_1025'] != NULL && $array_data['field_1025'] > 0){
                                $subindicator_116_count++;
                            }
                        }

                        $actual_val = $subindicator_113_count+$subindicator_114_count+$subindicator_115_count+$subindicator_116_count;
                        break;

                    case 34:
                        //subindicator 109
                        $subindicator_109_count = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 109)->where('group.form_id', 109);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $subindicator_109 = $this->db->get()->result_array();
                        foreach ($subindicator_109 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_675'] != NULL && $array_data['field_675'] > 0){
                                $subindicator_109_count++;
                            }
                        }

                        //subindicator 110
                        $subindicator_110_count = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 110)->where('group.form_id', 110);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $subindicator_110 = $this->db->get()->result_array();
                        foreach ($subindicator_110 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_677'] != NULL && $array_data['field_677'] > 0){
                                $subindicator_110_count++;
                            }
                        }

                        //subindicator 111
                        $subindicator_111_count = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 111)->where('group.form_id', 111);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $subindicator_111 = $this->db->get()->result_array();
                        foreach ($subindicator_111 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_679'] != NULL && $array_data['field_679'] > 0){
                                $subindicator_111_count++;
                            }
                        }

                        //subindicator 112
                        $subindicator_112_count = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 112)->where('group.form_id', 112);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $subindicator_112 = $this->db->get()->result_array();
                        foreach ($subindicator_112 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_14'] != NULL && $array_data['field_14'] > 0){
                                $subindicator_112_count++;
                            }
                        }

                        $actual_val = $subindicator_109_count+$subindicator_110_count+$subindicator_111_count+$subindicator_112_count;
                        break;
                    
                    case 38:
                        $this->db->distinct();
                        $this->db->select('country_id, crop_id');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $get_unique_programs = $this->db->get('ic_form_data')->result_array();
                        $count = 0;
                        foreach ($get_unique_programs as $key => $unique_prgm) {
                            $unique_program_val = 0;
                            $unique_program_sum = 0;
                            $this->db->select('form_data');
                            $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                            $this->db->where('country_id', $unique_prgm['country_id']);
                            $this->db->where('crop_id', $unique_prgm['crop_id']);
                            $records = $this->db->get('ic_form_data')->result_array();
                            foreach ($records as $key => $value) {
                                $array_data = json_decode($value['form_data'], true);

                                if($array_data['field_25'] != NULL && $array_data['field_25'] != ''){
                                    $unique_program_sum += $array_data['field_25'];
                                }
                            }

                            $count_val = (count($records) > 0) ? $unique_program_sum/count($records) : 0;

                            $count = $count + $count_val;
                        }                            

                        if(count($get_unique_programs) == 0){
                            $actual_val = 0;
                        }else{
                            $actual_val = $count/count($get_unique_programs);
                        }
                        break;

                    case 41:
                        $subindicator_list_79 = array(123, 124);
                        $this->db->select('data.data_id, group.group_id');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where_in('data.form_id', $subindicator_list_79)->where_in('group.form_id', $subindicator_list_79);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $actual_val = $this->db->get()->num_rows();
                        break;

                    case 43:
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_1098'] != NULL && $array_data['field_1098'] != ''){
                                $actual_val += $array_data['field_1098'];
                            }
                        }
                        break;

                    case 148:
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_1179'] != NULL && $array_data['field_1179'] != ''){
                                $explode_checkboxval = explode("&#44;", $array_data['field_1179']);
                                
                                if(count($explode_checkboxval) == 2){
                                    $actual_val++;   
                                }
                            }
                        }
                        break;

                    case 149:
                        $this->db->distinct();
                        $this->db->select('form_id, year_id, country_id, crop_id');
                        $this->db->where('form_id', 148)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $actual_val = $this->db->get('ic_form_data')->num_rows();
                        break;

                    case 50:
                        $this->db->select('form_data');
                        $this->db->where('form_id', 50)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_75'] != NULL && $array_data['field_75'] != '' && $array_data['field_75'] == 'Multi-locational trial/ Advanced yield trial'){
                                $actual_val++;
                            }
                        }
                        break;

                    case 150:
                        $this->db->select('form_data');
                        $this->db->where('form_id', 50)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_75'] != NULL && $array_data['field_75'] != '' && $array_data['field_75'] == 'Tricot trial'){
                                $actual_val++;
                            }
                        }
                        break;

                    case 53:
                        $this->db->select('form_data');
                        $this->db->where('form_id', 50)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_75'] != NULL && $array_data['field_75'] != '' && $array_data['field_75'] == '(F)PVS'){
                                $actual_val++;
                            }
                        }
                        break;

                    case 52:
                        $this->db->select('form_data');
                        $this->db->where('form_id', 50)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_75'] != NULL && $array_data['field_75'] != '' && $array_data['field_75'] == 'On-farm trials'){
                                $actual_val++;
                            }
                        }
                        break;

                    case 54:
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_1086'] != NULL && $array_data['field_1086'] != ''){
                                $actual_val += $array_data['field_1086'];
                            }
                        }
                        break;

                    case 55:
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_1083'] != NULL && $array_data['field_1083'] != ''){
                                $actual_val += $array_data['field_1083'];
                            }

                            if($array_data['field_1084'] != NULL && $array_data['field_1084'] != ''){
                                $actual_val += $array_data['field_1084'];
                            }
                        }
                        break;

                    case 56:
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_1011'] != NULL && $array_data['field_1011'] != ''){
                                $explode_comma = explode(",", $array_data['field_1011']);
                                $actual_val = $actual_val + count($explode_comma);
                            }
                        }
                        break;

                    case 57:
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_1075'] != NULL && $array_data['field_1075'] != ''){
                                $explode_comma = explode(",", $array_data['field_1075']);
                                $actual_val = $actual_val + count($explode_comma);
                            }
                        }
                        break;

                    case 58:
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_1080'] != NULL && $array_data['field_1080'] != ''){
                                $explode_comma = explode(",", $array_data['field_1080']);
                                $actual_val = $actual_val + count($explode_comma);
                            }
                        }
                        break;

                    case 95:
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_258'] != NULL && $array_data['field_258'] != ''){
                                $actual_val = $actual_val + $array_data['field_258'];
                            }
                        }
                        break;

                    case 93:
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_949'] != NULL && $array_data['field_949'] != ''){
                                $actual_val += $array_data['field_949'];
                            }

                            if($array_data['field_950'] != NULL && $array_data['field_950'] != ''){
                                $actual_val += $array_data['field_950'];
                            }
                        }
                        break;

                    case 89:
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_1207'] != NULL && $array_data['field_1207'] != ''){
                                $actual_val += $array_data['field_1207'];
                            }

                            if($array_data['field_1208'] != NULL && $array_data['field_1208'] != ''){
                                $actual_val += $array_data['field_1208'];
                            }

                            if($array_data['field_1209'] != NULL && $array_data['field_1209'] != ''){
                                $actual_val += $array_data['field_1209'];
                            }

                            if($array_data['field_1210'] != NULL && $array_data['field_1210'] != ''){
                                $actual_val += $array_data['field_1210'];
                            }

                            if($array_data['field_1211'] != NULL && $array_data['field_1211'] != ''){
                                $actual_val += $array_data['field_1211'];
                            }

                            if($array_data['field_1212'] != NULL && $array_data['field_1212'] != ''){
                                $actual_val += $array_data['field_1212'];
                            }
                        }

                        $actual_val = $actual_val*0.001;
                        break;

                    case 90:
                        $this->db->select('form_data');
                        $this->db->where('form_id', 89)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_1213'] != NULL && $array_data['field_1213'] != ''){
                                $actual_val += $array_data['field_1213'];
                            }

                            if($array_data['field_1214'] != NULL && $array_data['field_1214'] != ''){
                                $actual_val += $array_data['field_1214'];
                            }

                            if($array_data['field_1215'] != NULL && $array_data['field_1215'] != ''){
                                $actual_val += $array_data['field_1215'];
                            }

                            if($array_data['field_1216'] != NULL && $array_data['field_1216'] != ''){
                                $actual_val += $array_data['field_1216'];
                            }

                            if($array_data['field_1217'] != NULL && $array_data['field_1217'] != ''){
                                $actual_val += $array_data['field_1217'];
                            }

                            if($array_data['field_1218'] != NULL && $array_data['field_1218'] != ''){
                                $actual_val += $array_data['field_1218'];
                            }
                        }
                        break;

                    case 91:
                        $this->db->select('form_data');
                        $this->db->where('form_id', 89)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_1219'] != NULL && $array_data['field_1219'] != ''){
                                $actual_val += $array_data['field_1219'];
                            }

                            if($array_data['field_1220'] != NULL && $array_data['field_1220'] != ''){
                                $actual_val += $array_data['field_1220'];
                            }

                            if($array_data['field_1221'] != NULL && $array_data['field_1221'] != ''){
                                $actual_val += $array_data['field_1221'];
                            }

                            if($array_data['field_1222'] != NULL && $array_data['field_1222'] != ''){
                                $actual_val += $array_data['field_1222'];
                            }

                            if($array_data['field_1223'] != NULL && $array_data['field_1223'] != ''){
                                $actual_val += $array_data['field_1223'];
                            }

                            if($array_data['field_1224'] != NULL && $array_data['field_1224'] != ''){
                                $actual_val += $array_data['field_1224'];
                            }

                            if($array_data['field_1225'] != NULL && $array_data['field_1225'] != ''){
                                $actual_val += $array_data['field_1225'];
                            }

                            if($array_data['field_1226'] != NULL && $array_data['field_1226'] != ''){
                                $actual_val += $array_data['field_1226'];
                            }

                            if($array_data['field_1227'] != NULL && $array_data['field_1227'] != ''){
                                $actual_val += $array_data['field_1227'];
                            }

                            if($array_data['field_1228'] != NULL && $array_data['field_1228'] != ''){
                                $actual_val += $array_data['field_1228'];
                            }

                            if($array_data['field_1229'] != NULL && $array_data['field_1229'] != ''){
                                $actual_val += $array_data['field_1229'];
                            }

                            if($array_data['field_1230'] != NULL && $array_data['field_1230'] != ''){
                                $actual_val += $array_data['field_1230'];
                            }
                        }
                        break;

                    case 92:
                        $actual_val = 0;

                        $this->db->select('form_data');
                        $this->db->where('form_id', 141)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $subindicator_141records = $this->db->get('ic_form_data')->result_array();                        
                        foreach ($subindicator_141records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_1042'] != NULL && $array_data['field_1042'] != '' && $array_data['field_1042'] == 'Farmer'){
                                $actual_val++;
                            }

                            if($array_data['field_1042'] != NULL && $array_data['field_1042'] != '' && $array_data['field_1042'] == 'Farmer group'){
                                $female_val = (isset($array_data['field_1047'])) ? $array_data['field_1047'] : 0;
                                $male_val = (isset($array_data['field_1048'])) ? $array_data['field_1048'] : 0;
                                $actual_val += $female_val + $male_val;
                            }
                        }

                        $this->db->select('form_data');
                        $this->db->where('form_id', 142)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $subindicator_142records = $this->db->get('ic_form_data')->result_array();                        
                        foreach ($subindicator_142records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if(isset($array_data['field_1052']) && $array_data['field_1052'] != NULL && $array_data['field_1052'] != '' && $array_data['field_1052'] == 'Farmer'){
                                $actual_val++;
                            }

                            if(isset($array_data['field_1052']) && $array_data['field_1052'] != NULL && $array_data['field_1052'] != '' && $array_data['field_1052'] == 'Farmer group'){
                                $female_val = (isset($array_data['field_1057'])) ? $array_data['field_1057'] : 0;
                                $male_val = (isset($array_data['field_1058'])) ? $array_data['field_1058'] : 0;
                                $actual_val += $female_val + $male_val;
                            }
                        }
                        break;

                    case 88:
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_209'] != NULL && $array_data['field_209'] != ''){
                                $actual_val += $array_data['field_209'];
                            }

                            if($array_data['field_210'] != NULL && $array_data['field_210'] != ''){
                                $actual_val += $array_data['field_210'];
                            }
                        }
                        break;

                    case 157:
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 156)->where('group.form_id', 156);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_1197'] != NULL && $array_data['field_1197'] != ''){
                                $actual_val += $array_data['field_1197'];
                            }
                        }
                        break;

                    case 100:
                        $subindicator_list_100 = array(128, 127);
                        $this->db->select('data.data_id, group.group_id');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where_in('data.form_id', $subindicator_list_100)->where_in('group.form_id', $subindicator_list_100);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $actual_val = $this->db->get()->num_rows();
                        break;

                    case 83:
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_166'] != NULL && $array_data['field_166'] != ''){
                                $actual_val += $array_data['field_166'];
                            }

                            if($array_data['field_167'] != NULL && $array_data['field_167'] != ''){
                                $actual_val += $array_data['field_167'];
                            }
                        }
                        break;

                    case 84:
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_613'] != NULL && $array_data['field_613'] != ''){
                                $actual_val += $array_data['field_613'];
                            }

                            if($array_data['field_614'] != NULL && $array_data['field_614'] != ''){
                                $actual_val += $array_data['field_614'];
                            }
                        }
                        break;

                    case 85:
                        $actual_val = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 82)->where('group.form_id', 82);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_82 = $this->db->get()->result_array();
                        foreach ($records_82 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_327'] != NULL && $array_data['field_327'] != ''){
                                $actual_val += $array_data['field_327'];
                            }

                            if($array_data['field_685'] != NULL && $array_data['field_685'] != ''){
                                $actual_val += $array_data['field_685'];
                            }
                        }

                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 125)->where('group.form_id', 125);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_125 = $this->db->get()->result_array();
                        foreach ($records_125 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_155'] != NULL && $array_data['field_155'] != ''){
                                $actual_val += $array_data['field_155'];
                            }

                            if($array_data['field_156'] != NULL && $array_data['field_156'] != ''){
                                $actual_val += $array_data['field_156'];
                            }
                        }

                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 126)->where('group.form_id', 126);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_126 = $this->db->get()->result_array();
                        foreach ($records_126 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_606'] != NULL && $array_data['field_606'] != ''){
                                $actual_val += $array_data['field_606'];
                            }

                            if($array_data['field_607'] != NULL && $array_data['field_607'] != ''){
                                $actual_val += $array_data['field_607'];
                            }
                        }
                        break;

                    case 68:
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_249'] != NULL && $array_data['field_249'] != ''){
                                $actual_val += $array_data['field_249'];
                            }
                        }
                        break;

                    case 71:
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_106'] != NULL && $array_data['field_106'] != '' && $array_data['field_106'] == 'Yes'){
                                $actual_val++;
                            }
                        }
                        break;

                    case 72:
                        $this->db->select('data.data_id, group.group_id');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 71)->where('group.form_id', 71);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $actual_val = $this->db->get()->num_rows();
                        break;

                    case 152:
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_1186'] != NULL && $array_data['field_1186'] != ''){
                                $explode_checkboxval = explode("&#44;", $array_data['field_1186']);
                                
                                if(count($explode_checkboxval) == 2){
                                    $actual_val++;   
                                }
                            }
                        }
                        break;

                    case 153:
                        $this->db->select('form_data');
                        $this->db->where('form_id', 152)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_1187'] != NULL && $array_data['field_1187'] != ''){
                                $actual_val += $array_data['field_1187'];
                            }
                        }
                        break;

                    case 65:
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_589'] == $array_data['field_590']){
                                $actual_val++;
                            }
                        }
                        break;

                    case 63:
                        $actual_val = 0;
                        $this->db->select('form_data');
                        $this->db->where('form_id', 59);
                        $this->db->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_63 = $this->db->get('ic_form_data')->result_array();
                        foreach ($records_63 as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_1115'] != NULL && $array_data['field_1115'] != ''){
                                $actual_val += $array_data['field_1115'];
                            }

                            if($array_data['field_1120'] != NULL && $array_data['field_1120'] != ''){
                                $actual_val += $array_data['field_1120'];
                            }
                        }
                        break;

                    case 40:
                        $subindicator_list_79 = array(143, 144);
                        $this->db->select('data.data_id, group.group_id');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where_in('data.form_id', $subindicator_list_79)->where_in('group.form_id', $subindicator_list_79);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $actual_val = $this->db->get()->num_rows();
                        break;

                    case 42:
                        //$subindicator_list_79 = array(146, 145);
                        $actual_val = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 145)->where('group.form_id', 145);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $subindicator_145 = $this->db->get()->result_array();
                        foreach ($subindicator_145 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_1091'] != '' && $array_data['field_1091'] != ''){
                                $actual_val += $array_data['field_1091'];
                            }
                        }

                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 146)->where('group.form_id', 146);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $subindicator_146 = $this->db->get()->result_array();
                        foreach ($subindicator_146 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_1095'] != '' && $array_data['field_1095'] != ''){
                                $actual_val += $array_data['field_1095'];
                            }
                        }
                        break;

                    case 151:
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_1100'] != '' && $array_data['field_1100'] != ''){
                                $actual_val += $array_data['field_1100'];
                            }
                        }
                        break;

                    case 74:
                        $count = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('data.country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('data.crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get()->result_array();
                        foreach ($records as $key => $value) {
                            $val = 0;
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_937'] != NULL && $array_data['field_937'] != ''){
                                $val += $array_data['field_937'];
                            }

                            if($array_data['field_938'] != NULL && $array_data['field_938'] != ''){
                                $val += $array_data['field_938'];
                            }

                            if($array_data['field_939'] != NULL && $array_data['field_939'] != ''){
                                $val += $array_data['field_939'];
                            }
                            $count += $val/3;
                        }
                        if(count($records)> 0){
                            $count = $count/count($records);
                        }

                        $this->db->distinct();
                        $this->db->select('country_id, crop_id');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $get_unique_programs = $this->db->get('ic_form_data')->result_array();

                        if(count($get_unique_programs) == 0){
                            $actual_val = 0;
                        }else{
                            $actual_val = $count/count($get_unique_programs);
                        }
                        break;

                    case 75:
                        $count = 0;
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id']);
                        $this->db->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_75 = $this->db->get('ic_form_data')->result_array();
                        foreach ($records_75 as $key => $value) {
                            $val = 0;
                            $array_data = json_decode($value['form_data'], true);
                            if($array_data['field_941'] != NULL && $array_data['field_941'] != ''){
                                $val += $array_data['field_941'];
                            }

                            if($array_data['field_942'] != NULL && $array_data['field_942'] != ''){
                                $val += $array_data['field_942'];
                            }

                            if($array_data['field_943'] != NULL && $array_data['field_943'] != ''){
                                $val += $array_data['field_943'];
                            }
                            $count += $val/3;
                        }
                        if(count($records_75)> 0){
                            $count = $count/count($records_75);
                        }

                        $this->db->distinct();
                        $this->db->select('country_id, crop_id');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $get_unique_programs = $this->db->get('ic_form_data')->result_array();

                        if(count($get_unique_programs) == 0){
                            $actual_val = 0;
                        }else{
                            $actual_val = $count/count($get_unique_programs);
                        }
                        break;

                    case 76:
                        $count = 0;
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id']);
                        $this->db->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_76 = $this->db->get('ic_form_data')->result_array();
                        foreach ($records_76 as $key => $value) {
                            $val = 0;
                            $array_data = json_decode($value['form_data'], true);
                            if($array_data['field_945'] != NULL && $array_data['field_945'] != ''){
                                $val += $array_data['field_945'];
                            }

                            if($array_data['field_946'] != NULL && $array_data['field_946'] != ''){
                                $val += $array_data['field_946'];
                            }

                            if($array_data['field_947'] != NULL && $array_data['field_947'] != ''){
                                $val += $array_data['field_947'];
                            }
                            $count += $val/3;
                        }
                        if(count($records_76)> 0){
                            $count = $count/count($records_76);
                        }

                        $this->db->distinct();
                        $this->db->select('country_id, crop_id');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $get_unique_programs = $this->db->get('ic_form_data')->result_array();

                        if(count($get_unique_programs) == 0){
                            $actual_val = 0;
                        }else{
                            $actual_val = $count/count($get_unique_programs);
                        }
                        break;

                    case 67:
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_100'] != NULL && $array_data['field_100'] != '' && $array_data['field_100'] == 'Yes'){
                                $actual_val++;
                            }
                        }
                        break;

                    case 64:
                        $this->db->select('form_data');
                        $this->db->where('form_id', 122)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);
                            if(isset($array_data['field_462']) && $array_data['field_462'] != NULL && $array_data['field_462'] != '' && $array_data['field_460'] != NULL && $array_data['field_460'] != ''){
                                if($array_data['field_460'] == 0){
                                    $val = 0;
                                }else{
                                    $val = ($array_data['field_462']/$array_data['field_460'])*100;
                                }

                                if($val == 100){
                                    $actual_val++;
                                }
                            }
                        }
                        break;

                    case 62:
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records = $this->db->get('ic_form_data')->result_array();
                        $actual_val = 0;
                        foreach ($records as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_1131'] != NULL && $array_data['field_1131'] != '' && ($array_data['field_1131'] == 'WEAI (Women empowerment in agriculture index)' || $array_data['field_1131'] == 'GREAT' || $array_data['field_1131'] == 'Both')){
                                $actual_val++;
                            }
                        }
                        break;

                    case 60:
                        $count = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('data.country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('data.crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_60 = $this->db->get()->result_array();
                        foreach ($records_60 as $key => $value) {
                            $check_val = 0;
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_1014'] != NULL && $array_data['field_1014'] != '' /*&& ($array_data['field_1014'] == 100 || $array_data['field_1014'] == 100.00 || $array_data['field_1014'] == 100.0)*/){
                                $check_val += $array_data['field_1014'];
                            }

                            if($array_data['field_1015'] != NULL && $array_data['field_1015'] != '' /*&& ($array_data['field_1015'] == 100 || $array_data['field_1015'] == 100.00 || $array_data['field_1015'] == 100.0)*/){
                                $check_val += $array_data['field_1015'];
                            }

                            if($array_data['field_1016'] != NULL && $array_data['field_1016'] != '' /*&& ($array_data['field_1016'] == 100 || $array_data['field_1016'] == 100.00 || $array_data['field_1016'] == 100.0)*/){
                                $check_val += $array_data['field_1016'];
                            }

                            if($array_data['field_1017'] != NULL && $array_data['field_1017'] != '' /*&& ($array_data['field_1017'] == 100 || $array_data['field_1017'] == 100.00 || $array_data['field_1017'] == 100.0)*/){
                                $check_val += $array_data['field_1017'];
                            }

                            if($array_data['field_1018'] != NULL && $array_data['field_1018'] != '' /*&& ($array_data['field_1018'] == 100 || $array_data['field_1018'] == 100.00 || $array_data['field_1018'] == 100.0)*/){
                                $check_val += $array_data['field_1018'];
                            }

                            $check_val = $check_val/5;
                            $count += $check_val;
                        }

                        $this->db->distinct();
                        $this->db->select('country_id, crop_id');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $get_unique_programs = $this->db->get('ic_form_data')->result_array();

                        if(count($get_unique_programs) == 0){
                            $actual_val = 0;
                        }else{
                            $actual_val = $count/count($get_unique_programs);
                        }
                        break;

                    case 51:
                        $sum_val = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', $ind_val['id'])->where('group.form_id', $ind_val['id']);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('data.country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('data.crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_51 = $this->db->get()->result_array();
                        foreach ($records_51 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);
                            if($array_data['field_1039'] != NULL && $array_data['field_1039'] != ''){
                                $sum_val += $array_data['field_1039'];
                            }
                        }

                        $this->db->distinct();
                        $this->db->select('form_id, year_id, country_id, crop_id');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $reportedcount = $this->db->get('ic_form_data')->num_rows();

                        if($reportedcount == 0){
                            $avg_val = 0;
                        }else{
                            $avg_val = $sum_val/$reportedcount;
                        }
                        $actual_val = $avg_val;
                        break;

                    case 94:
                        $sum_val = 0;
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_94 = $this->db->get('ic_form_data')->result_array();
                        foreach ($records_94 as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_254'] != NULL && $array_data['field_254'] != ''){
                                $sum_val += $array_data['field_254'];
                            }

                            if($array_data['field_255'] != NULL && $array_data['field_255'] != ''){
                                $sum_val += $array_data['field_255'];
                            }
                        }
                        if(count($records_94)> 0){
                            $sum_val = $sum_val/count($records_94);
                        }

                        $this->db->distinct();
                        $this->db->select('form_id, year_id, country_id, crop_id');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $reportedcount = $this->db->get('ic_form_data')->num_rows();

                        if($reportedcount == 0){
                            $avg_val = 0;
                        }else{
                            $avg_val = $sum_val/$reportedcount;
                        }
                        $actual_val = $avg_val;
                        break;

                    case 2:
                        //subindicator 105
                        $structure_sum = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 105)->where('group.form_id', 105);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('data.country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('data.crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_105 = $this->db->get()->result_array();
                        foreach ($records_105 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_529'] != NULL && $array_data['field_529'] != ''){
                                $structure_sum += $array_data['field_529'];
                            }
                        }
                        if(count($records_105) == 0){
                            $structure_val = 0;
                        }else{
                            $structure_val = $structure_sum/count($records_105);
                        }

                        //subindicator 106
                        $equipment_sum = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 106)->where('group.form_id', 106);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('data.country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('data.crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_106 = $this->db->get()->result_array();
                        foreach ($records_106 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_1013'] != NULL && $array_data['field_1013'] != ''){
                                $equipment_sum += $array_data['field_1013'];
                            }
                        }
                        if(count($records_106) == 0){
                            $equipment_val = 0;
                        }else{
                            $equipment_val = $equipment_sum/count($records_106);
                        }

                        //subindicator 107
                        $personnel_sum = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 107)->where('group.form_id', 107);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('data.country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('data.crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_107 = $this->db->get()->result_array();
                        foreach ($records_107 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_532'] != NULL && $array_data['field_532'] != ''){
                                $personnel_sum += $array_data['field_532'];
                            }
                        }
                        if(count($records_107) == 0){
                            $personnel_val = 0;
                        }else{
                            $personnel_val = $personnel_sum/count($records_107);
                        }

                        //subindicator 108
                        $others_sum = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 108)->where('group.form_id', 108);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('data.country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('data.crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_108 = $this->db->get()->result_array();
                        foreach ($records_108 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_980'] != NULL && $array_data['field_980'] != ''){
                                $others_sum += $array_data['field_980'];
                            }
                        }
                        if(count($records_108) == 0){
                            $others_val = 0;
                        }else{
                            $others_val = $others_sum/count($records_108);
                        }
                        
                        $actual_val = ($structure_val + $equipment_val + $personnel_val + $others_val)/4;
                        break;

                    case 101:
                        $actual_val = 0;
                        //subindicator 105
                        $structure_sum = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 105)->where('group.form_id', 105);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('data.country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('data.crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_105 = $this->db->get()->result_array();
                        foreach ($records_105 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_529'] != NULL && $array_data['field_529'] != ''){
                                $structure_sum += $array_data['field_529'];
                            }
                        }
                        if(count($records_105) == 0){
                            $structure_val = 0;
                        }else{
                            $structure_val = $structure_sum/count($records_105);
                        }

                        //subindicator 106
                        $equipment_sum = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 106)->where('group.form_id', 106);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('data.country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('data.crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_106 = $this->db->get()->result_array();
                        foreach ($records_106 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_1013'] != NULL && $array_data['field_1013'] != ''){
                                $equipment_sum += $array_data['field_1013'];
                            }
                        }
                        if(count($records_106) == 0){
                            $equipment_val = 0;
                        }else{
                            $equipment_val = $equipment_sum/count($records_106);
                        }

                        //subindicator 107
                        $personnel_sum = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 107)->where('group.form_id', 107);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('data.country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('data.crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_107 = $this->db->get()->result_array();
                        foreach ($records_107 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_532'] != NULL && $array_data['field_532'] != ''){
                                $personnel_sum += $array_data['field_532'];
                            }
                        }
                        if(count($records_107) == 0){
                            $personnel_val = 0;
                        }else{
                            $personnel_val = $personnel_sum/count($records_107);
                        }

                        //subindicator 108
                        $others_sum = 0;
                        $this->db->select('data.data_id, group.group_id, group.formgroup_data');
                        $this->db->from('ic_form_data as data');
                        $this->db->join('ic_form_group_data as group', 'data.data_id = group.data_id');
                        $this->db->where('data.form_id', 108)->where('group.form_id', 108);
                        $this->db->where('data.year_id', $year)->where('data.status', 3)->where('group.status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('data.country_id', $country);
                            else $this->db->where('data.country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('data.crop_id', $crop);
                            else $this->db->where('data.crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_108 = $this->db->get()->result_array();
                        foreach ($records_108 as $key => $value) {
                            $array_data = json_decode($value['formgroup_data'], true);

                            if($array_data['field_980'] != NULL && $array_data['field_980'] != ''){
                                $others_sum += $array_data['field_980'];
                            }
                        }
                        if(count($records_108) == 0){
                            $others_val = 0;
                        }else{
                            $others_val = $others_sum/count($records_108);
                        }
                        
                        $indicator1_val = ($structure_val + $equipment_val + $personnel_val + $others_val)/4;

                        if($indicator1_val > 0){
                            $actual_val++;
                        }

                        break;

                    case 59:
                        $sum_val = 0;
                        $this->db->select('form_data');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_59 = $this->db->get('ic_form_data')->result_array();
                        foreach ($records_59 as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            //Nurseries established in the field
                            $a = 0;
                            if($array_data['field_1108'] != NULL && $array_data['field_1108'] != ''){
                                $a += $array_data['field_1108'];
                            }
                            if($array_data['field_1109'] != NULL && $array_data['field_1109'] != ''){
                                $a += $array_data['field_1109'];
                            }
                            if($array_data['field_1110'] != NULL && $array_data['field_1110'] != ''){
                                $a += $array_data['field_1110'];
                            }
                            if($array_data['field_1107'] == 0){
                                $a_final = 0;
                            }else{
                                $a_final = ($a/$array_data['field_1107'])/3;    
                            }

                            // Nurseries established in the greenhouse
                            $b = 0;
                            if($array_data['field_1113'] != NULL && $array_data['field_1113'] != ''){
                                $b += $array_data['field_1113'];
                            }
                            if($array_data['field_1114'] != NULL && $array_data['field_1114'] != ''){
                                $b += $array_data['field_1114'];
                            }
                            if($array_data['field_1115'] != NULL && $array_data['field_1115'] != ''){
                                $b += $array_data['field_1115'];
                            }
                            if($array_data['field_1112'] == 0){
                                $b_final = 0;
                            }else{
                                $b_final = ($b/$array_data['field_1112'])/3;    
                            }

                            //Trials established in the field
                            $c = 0;
                            if($array_data['field_1118'] != NULL && $array_data['field_1118'] != ''){
                                $c += $array_data['field_1118'];
                            }
                            if($array_data['field_1119'] != NULL && $array_data['field_1119'] != ''){
                                $c += $array_data['field_1119'];
                            }
                            if($array_data['field_1120'] != NULL && $array_data['field_1120'] != ''){
                                $c += $array_data['field_1120'];
                            }
                            if($array_data['field_1117'] == 0){
                                $c_final = 0;
                            }else{
                                $c_final = ($c/$array_data['field_1117'])/3;    
                            }

                            //Trials established in the greenhouse
                            $d = 0;
                            if($array_data['field_1123'] != NULL && $array_data['field_1123'] != ''){
                                $d += $array_data['field_1123'];
                            }
                            if($array_data['field_1124'] != NULL && $array_data['field_1124'] != ''){
                                $d += $array_data['field_1124'];
                            }
                            if($array_data['field_1125'] != NULL && $array_data['field_1125'] != ''){
                                $d += $array_data['field_1125'];
                            }
                            if($array_data['field_1122'] == 0){
                                $d_final = 0;
                            }else{
                                $d_final = ($d/$array_data['field_1122'])/3;    
                            }                            

                            //Datasets genotyped
                            if(!isset($array_data['field_1258']) || $array_data['field_1258'] == 0){
                                $e = 0;
                            }else{
                                $e = $array_data['field_1128']/$array_data['field_1258'];
                            }

                            $finalval = (($a_final+$b_final+$c_final+$d_final+$e)/5)*100;

                            $sum_val = $sum_val+$finalval;
                        }

                        $this->db->distinct();
                        $this->db->select('form_id, year_id, country_id, crop_id');
                        $this->db->where('form_id', $ind_val['id'])->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $reportedcount = $this->db->get('ic_form_data')->num_rows();

                        if($reportedcount == 0){
                            $actual_val = 0;
                        }else{
                            $actual_val = $sum_val/$reportedcount;
                        }
                        break;

                    case 99:
                        $sum_val = 0;
                        $this->db->select('form_data');
                        $this->db->where('form_id', 139)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $records_139 = $this->db->get('ic_form_data')->result_array();
                        foreach ($records_139 as $key => $value) {
                            $array_data = json_decode($value['form_data'], true);

                            if($array_data['field_811'] != NULL && $array_data['field_811'] != ''){
                                $sum_val += $array_data['field_811'];
                            }
                        }

                        $this->db->distinct();
                        $this->db->select('form_id, year_id, country_id, crop_id');
                        $this->db->where('form_id', 139)->where('year_id', $year)->where('status', 3);
                        if($country != 'all'){
                            if(is_array($country)) $this->db->where_in('country_id', $country);
                            else $this->db->where('country_id', $country);
                        }
                        if($crop != 'all'){
                            if(is_array($crop)) $this->db->where_in('crop_id', $crop);
                            else $this->db->where('crop_id', $crop);
                        }
                        $this->db->where('nothingto_report !=', 1);
                        $reportedcount = $this->db->get('ic_form_data')->num_rows();

                        if($reportedcount == 0){
                            $avg_val = 0;
                        }else{
                            $avg_val = $sum_val/$reportedcount;
                        }
                        $actual_val = $avg_val;
                        break;

                    default:
                        $actual_val = 0;
                        break;
                }
                
                $indicators[$i_key]['actual_val'] = round($actual_val, 2);

                $this->db->select('IFNULL(sum(target), 0) as val');
                $this->db->where('indicator_id_2020', $ind_val['id'])->where('year_id', $year)->where('status', 1);
                if($country != 'all'){
                    if(is_array($country)) $this->db->where_in('country', $country);
                    else $this->db->where('country', $country);
                }
                if($crop != 'all'){
                    if(is_array($crop)) $this->db->where_in('crop', $crop);
                    else $this->db->where('crop', $crop);
                }
                $targetval = $this->db->get('tbl_indicator_target')->row_array();

                $this->db->distinct();
                $this->db->select('id');
                $this->db->where('indicator_id_2020', $ind_val['id'])->where('year_id', $year)->where('status', 1);
                if($country != 'all'){
                    if(is_array($country)) $this->db->where_in('country', $country);
                    else $this->db->where('country', $country);
                }
                if($crop != 'all'){
                    if(is_array($crop)) $this->db->where_in('crop', $crop);
                    else $this->db->where('crop', $crop);
                }
                $this->db->where('target IS NOT NULL');
                $targetval_count = $this->db->get('tbl_indicator_target')->num_rows();

                $average_indicators_list = array(2, 38, 51, 74, 75, 76, 94, 99);
                if(in_array($ind_val['id'], $average_indicators_list)){
                    if($targetval == NULL || $targetval_count == 0){
                        $indicators[$i_key]['target_val'] = 0;
                    }else{
                        $indicators[$i_key]['target_val'] = ($targetval['val'] == NULL) ? 0 : round($targetval['val']/$targetval_count, 2);
                    }
                }else{
                    $indicators[$i_key]['target_val'] = $targetval['val'];
                }

                //get result tracker reviews
                if(!is_array($country) && !is_array($crop)){
                    $this->db->where('form_id', $ind_val['id']);
                    $this->db->where('country_id', $country);
                    $this->db->where('crop_id', $crop);
                    $this->db->where('year_id', $year);
                    $this->db->where('user_id', $this->session->userdata('login_id'));
                    $indicators[$i_key]['user_resulttracker_report'] = $this->db->get('resulttracker_reviews')->num_rows();

                    $this->db->where('form_id', $ind_val['id']);
                    $this->db->where('country_id', $country);
                    $this->db->where('crop_id', $crop);
                    $this->db->where('year_id', $year);
                    $indicators[$i_key]['resulttracker_report'] = $this->db->get('resulttracker_reviews')->num_rows();

                    $this->db->where('form_id', $ind_val['id']);
                    $this->db->where('country_id', $country);
                    $this->db->where('crop_id', $crop);
                    $this->db->where('year_id', $year);
                    $this->db->where('query_status', 1);
                    $indicators[$i_key]['resulttracker_report_query'] = $this->db->get('resulttracker_reviews')->num_rows();
                }else{
                    if(count($country) == 1 && count($crop) == 1){
                        $this->db->where('form_id', $ind_val['id']);
                        $this->db->where_in('country_id', $country);
                        $this->db->where_in('crop_id', $crop);
                        $this->db->where('year_id', $year);
                        $this->db->where('user_id', $this->session->userdata('login_id'));
                        $indicators[$i_key]['user_resulttracker_report'] = $this->db->get('resulttracker_reviews')->num_rows();

                        $this->db->where('form_id', $ind_val['id']);
                        $this->db->where_in('country_id', $country);
                        $this->db->where_in('crop_id', $crop);
                        $this->db->where('year_id', $year);
                        $indicators[$i_key]['resulttracker_report'] = $this->db->get('resulttracker_reviews')->num_rows();

                        $this->db->where('form_id', $ind_val['id']);
                        $this->db->where_in('country_id', $country);
                        $this->db->where_in('crop_id', $crop);
                        $this->db->where('year_id', $year);
                        $this->db->where('query_status', 1);
                        $indicators[$i_key]['resulttracker_report_query'] = $this->db->get('resulttracker_reviews')->num_rows();
                    }
                }                    
            }
            $outputs[$o_key]['indicator_list'] = $indicators;
        }

        return $outputs;
    }
}