<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\AuthModel;

class Auth extends Controller {

	function __construct()
	{
		$this->session = \Config\Services::session();
		$this->db = \Config\Database::connect();
		$this->uri = new \CodeIgniter\HTTP\URI(current_url());
		$this->security = \Config\Services::security();
		$this->baseurl = base_url();
	}

	public function index()
	{
		$this->logout();
	}

	// login
	public function login()
	{
		$db = \Config\Database::connect();
		$builder = $db->table('tbl_users');
		$baseurl = base_url();
		date_default_timezone_set("UTC");
		
		$data = [			
			'password' => $this->request->getVar('password'),
			'email_id'  => $this->request->getVar('email'),
			'logintype'  => $this->request->getVar('logintype')
		];
		$error = array('email' => '', 'password' => '', 'form' => '', 'status' => 1);
		if(empty($data['email_id'])) {
			$error['email'] = 'Email or Username is required';
			$error['status'] = 0;
		}

		if(empty($data['password'])) {
			$error['password'] = 'Password is required';
			$error['status'] = 0;
		}

		if($error['status'] == 0) {
			return $this->response->setJSON($error);
		}

		$authModel = new AuthModel();
		$logindata = $authModel->login($data);

		if($logindata) {
			if(isset($logindata['msg'])) {
				return $this->response->setJSON(array(
					'csrfName' => $this->security->get_csrf_token_name(),
					'csrfHash' => $this->security->get_csrf_hash(),
					'form' => $logindata['msg'],
					'status' => 0
				));
			} else {
				$newdata = array(
					'login_id' => $logindata['id'],
					'name' => $logindata['name'],
					'role' => $logindata['role'],
					'image' => $logindata['image'],
					'login_time' => date('H:i:s'),
				);

				$this->session = \Config\Services::session(); 

				$this->session->set($newdata);
				if($logindata['role'] == 6){
					$redirect = $baseurl.'reporting/c_dashboard';
				} else if($logindata['role'] == 5){
					$redirect = $baseurl.'reporting/c_dashboard';
				}else{
					$redirect = $baseurl.'reporting/common_dashboard';	
					// $redirect = $baseurl.'dashboard';	
				}

				return $this->response->setJSON(array(
					'redirect' => $redirect,
					'status' => 1
				));
			}
		} else {
			return $this->response->setJSON(array(
				'csrfName' => $this->security->getCSRFTokenName(),
				'csrfHash' => $this->security->getCSRFHash(),
				'form' => 'Invalid login credentials or Admin not approved Login',
				'status' => 0
			));
		}		
	}
}
