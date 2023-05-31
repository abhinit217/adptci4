<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
    
	public function __construct() {
		parent::__construct();
		$this->load->library('session');		
	}

    //Create user access
    public function login($data) {
        switch ($data['logintype']) {
            case 'simple':
                $checkuser = $this->db->select('user_id AS id, salt')->where("(username = '".$data['email_id']."' OR email_id = '".$data['email_id']."')")->get('tbl_users');
                if($checkuser->num_rows() === 0) {
                    return false;
                }
            break;

            case 'ldap':
                $username = explode('@', $data['email_id']);
                $username = $username[0];
                $email = $data['email_id'];

                //Start LDAP login process
                $ldapport = 636;
                $ldaphostA = "ldaps://AZCGNEROOT2.CGIARAD.ORG";
                $ldaphostB = "ldaps://AZCGCCROOT2.CGIARAD.ORG";

                // Connecting to LDAP
                $ldapconn = ldap_connect($ldaphostB, $ldapport);
                if(!$ldapconn) {
                    return false;
                }

                // configure ldap params
                ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
                ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 10);

                // binding to ldap server
                $ldapbind = ldap_bind($ldapconn, $email, $data['password']);
                if(!$ldapbind) {
                    return false;
                }

                $checkuser = $this->db->select('user_id AS id, salt')->where('email_id', $email)->get('tbl_users');
                if($checkuser->num_rows() === 0) {
                    return false;
                }
            break;
        }        

        $getData = $checkuser->row_array();        
        $password = $data['password'];
        $salt = $getData['salt'];
        $saltedPW =  $password . $salt;
        $hashedPW = hash('sha256', $saltedPW);
        $newData = array(
            'password' => $hashedPW,
            'approve_status' => 1,
            'status' => 1
        );

        switch ($data['logintype']) {
            case 'simple':
                $this->db->select('user_id AS id, first_name, last_name, email_id, role_id');
                $this->db->where("(username = '".$data['email_id']."' OR email_id = '".$data['email_id']."')")->where($newData);
            break;

            case 'ldap':
                $this->db->select('user_id AS id, first_name, last_name, email_id, role_id');
                $this->db->where('email_id', $data['email_id'])->where('status', 1);
            break;
        }
        $query = $this->db->get('tbl_users');

        if($query->num_rows() > 0) {
            $getData = $query->row_array();

            //Clear Session Before Starting a New One
            $data = array('login_id' => '', 'name' => '', 'role' => '', 'image' => '', 'login_time' => '');
            $this->session->set_userdata($data);

            $getImage = $this->db->where('user_id', $getData['id'])->where('status', 1)->get('tbl_images')->row_array();
            $login = 'user';
            $image = ($getImage == NULL) ? 'default.png' : $getImage['image'];

            $name = empty($getData['first_name']) ? $getData['email_id'] : $getData['first_name'].' '.$getData['last_name'];

            return array(
                'id' => $getData['id'],
                'name' => $name,
                'role' => $getData['role_id'],
                'image' => $image,
                'email_id' => $getData['email_id'],
                'login' => $login
            );
        } else {
            return false;
        }
    }
}
