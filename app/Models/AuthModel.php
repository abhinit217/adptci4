<?php

namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class AuthModel extends Model {

    protected $table  = 'tbl_users';
    

    //Create user access
    public function login($data) {
        $db = \Config\Database::connect();

        switch ($data['logintype']) {
            case 'simple':
                $checkUserQuery = $db->query("select user_id as id, salt from tbl_users where username = '".$data['email_id']."' OR email_id = '".$data['email_id']."' ");
                $checkuser = $checkUserQuery->getRow();
                if(!isset($checkuser)) {
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

        $getData = $checkUserQuery->getRow();        
        $password = $data['password'];
        $salt = $getData->salt;
        $saltedPW =  $password . $salt;
        $hashedPW = hash('sha256', $saltedPW);
        $newData = array(
            'password' => $hashedPW,
            'approve_status' => 1,
            'status' => 1
        );

        switch ($data['logintype']) {
            case 'simple':
                $userInfo = $db->query("select user_id as id, first_name, last_name, email_id, role_id from tbl_users where username = '".$data['email_id']."' OR email_id = '".$data['email_id']."' and password = '".$newData['password']."' and approve_status = 1 and status = 1");
            break;

            case 'ldap':
                $userInfo = $db->query("select user_id as id, first_name, last_name, email_id, role_id from tbl_users where username = '".$data['email_id']."' ");
            break;
        }
        $userInfoData = $userInfo->getRow();

        if(isset($userInfoData)) {
            $getImage = $db->query("select * from tbl_images where user_id = '".$userInfoData->id."' and status = 1 ")->getRow();
            $login = 'user';
            $image = (!isset($getImage)) ? 'default.png' : $getImage->image;

            $name = empty($userInfoData->first_name) ? $userInfoData->email_id : $userInfoData->first_name.' '.$userInfoData->last_name;

            return array(
                'id' => $userInfoData->id,
                'name' => $name,
                'role' => $userInfoData->role_id,
                'image' => $image,
                'email_id' => $userInfoData->email_id,
                'login' => $login
            );
        } else {
            return false;
        }
    }
}
