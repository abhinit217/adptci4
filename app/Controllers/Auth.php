<?php
namespace App\Controllers;

class Auth extends \CodeIgniter\Controller {

	public function __construct()
	{
		/*header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header('Content-Type: application/json');
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}

		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('user_agent');*/

		$this->session = \Config\Services::session();
        $this->session->start();
	}

	public function index()
	{
		$this->logout();
	}

	// login
	public function login()
	{
		date_default_timezone_set("UTC");
		$error = array('email' => '', 'password' => '', 'form' => '', 'status' => 1);
		$error['csrfName'] = csrf_token();
		$error['csrfHash'] = csrf_hash();
		$baseurl = base_url();
		if(($this->session->get('login_id') != null && $this->session->get('login_id') != '')) {
			$error['form'] = 'It seems you are already logged in. Please refresh the page to continue to your dashboard.';
			$error['status'] = 0;

			echo json_encode($error);
			exit();
		}

		if(empty($_POST['email'])) {
			$error['email'] = 'Email or Username is required';
			$error['status'] = 0;
		}

		if(empty($_POST['password'])) {
			$error['password'] = 'Password is required';
			$error['status'] = 0;
		}

		if($error['status'] == 0) {
			echo json_encode($error);
			exit();
		}

		$data = array(
			'logintype' => $this->input->post('logintype') ? $this->input->post('logintype') : 'simple',
			'uuid' => $this->input->post('uuid') ? $this->input->post('uuid') : false,
			'email_id' => $this->input->post('email'),
			'password' => $this->input->post('password'),
		);
		$this->load->model('Auth_model');
		$logindata = $this->Auth_model->login($data);

		if($logindata) {
			if(isset($logindata['msg'])) {
				echo json_encode(array(
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

				$this->session->set_userdata($newdata);
				if($logindata['role'] == 6){
					// $redirect = 'http://3.16.201.127/atpd/country-admin-atpd/dashboard.html?countryId=1';
					$redirect = $baseurl.'reporting/c_dashboard';
				} else if($logindata['role'] == 5){
					$redirect = $baseurl.'reporting/c_dashboard';
				}else{
					$redirect = $baseurl.'reporting/common_dashboard';	
					// $redirect = $baseurl.'dashboard';	
				}
				

				echo json_encode(array(
					'redirect' => $redirect,
					'status' => 1
				));
				exit();
			}
			exit();
		} else {
			echo json_encode(array(
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'form' => 'Invalid login credentials or Admin not approved Login',
				'status' => 0
			));
			exit();
		}
	}

	public function logout()
	{
		$baseurl = base_url();
		$page = $this->uri->segment(3);
		//Clear Session Before Starting a New One
		$data = array('user_id' => '', 'admin_id' => '', 'ic_admin_id' => '', 'viewer_id' => '', 'capdevuser_id' => '', 'kisanmitra_id' => '', 'name' => '', 'role' => '', 'image' => '', 'login_time' => '', 'viewer_id' => '');
		$this->session->set_userdata($data);
		$this->session->sess_destroy();
		redirect($baseurl.$page);
	}


	public function contactform()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$message = $this->input->post('contact_message');
		$contact_phone = $this->input->post('contact_phone');
		$contact_fullname = $this->input->post('contact_fullname');
		$contact_email = $this->input->post('contact_email');
		$error = array(
			'error_status'=>0
		);
		if (empty($contact_fullname)) {
			$error['error_status'] = 1;
			$error['fullname']= 'This field is mandatory';
		}
		if (empty($contact_email)) {
			$error['error_status'] = 1;
			$error['email']= 'This field is mandatory';
		}
		if (empty($contact_phone)) {
			$error['error_status'] = 1;
			$error['phone']= 'This field is mandatory';
		}
		if (empty($message)) {
			$error['error_status'] = 1;
			$error['message']= 'This field is mandatory';
		}	
		
		// validation
		$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
		if (empty($recaptchaResponse)) {
			$error['error_status'] = 1;
			$error['google_captcha']= "Please check I'm not a robot";
		}
		if ($error['error_status']> 0 ) {
			echo json_encode($error);
			exit();
		}
		/* google recaptch validation */
		$userIp=$this->input->ip_address();

		$secret = $this->config->item('google_secret');

		$credential = array(
		'secret' => $secret,
		'response' => $recaptchaResponse,
		'remoteip'=> $userIp
		);

		$verify = curl_init();
		curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
		curl_setopt($verify, CURLOPT_POST, true);
		curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
		curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($verify);

		$status= json_decode($response, true);

		if ($status['success'] == false) {
				$error['error_status'] = 1;
				$error['google_captcha']= 'Sorry Google Recaptcha Unsuccessfull!';
		}
		if ($error['error_status'] > 0) {
				echo json_encode($error);
				exit();
		}
		/* /google recaptch validation */

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'info@verdentum.org',
			'smtp_pass' => 'Verd@2020$',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('info@verdentum.org','Icrisat contact form');
		$this->email->to('s.nagaraji@cgiar.org');
		/*$this->email->to('niranjan@verdentum.org');*/
		$this->email->subject('Query');
		$this->email->set_mailtype("html");
		$body = 'Name :'.$contact_fullname.'<br>'.'Email :'.$contact_email.'<br>'.'Phone No :'.$contact_phone.'<br>'.'Query message :'.$message;
		$this->email->message($body);
		if($this->email->send()) {
			$result = array('msg' => 'Message sent successfully', 'status' => 1);
			echo json_encode($result);
			exit();
		}
		else {
			$result = array('msg' => 'Please try after some time', 'status' => 0);
			echo json_encode($result);
			exit();
		}
	}
}
