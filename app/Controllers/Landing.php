<?php

namespace App\Controllers;

class Landing extends BaseController {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		//parent::__construct();
		//$this->load->helper('url');
		//$this->load->library('session');
		//$this->load->library('user_agent');

		//$this->load->model('Auth_model');
	}

	public function index(){
		$baseurl = base_url();
		/*if($this->session->userdata('login_id') != null && $this->session->userdata('login_id') != '') {
			redirect($baseurl.'dashboard');
		}*/

		return view('Landing');
	}

	// login
	public function login()
	{
		date_default_timezone_set("UTC");
		$error = array('email' => '', 'password' => '', 'form' => '', 'status' => 1);
		$baseurl = base_url();
		if(($this->session->userdata('login_id') != null && $this->session->userdata('login_id') != '')) {
			$error['form'] = 'It seems you are already logged in. Please refresh the page to continue to your dashboard.';
			$error['status'] = 0;

			echo json_encode($error);
			exit();
		}

		if(empty($_POST['email'])) {
			$error['email'] = 'Email ID or Username is required';
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
			'email_id' => $this->input->post('email'),
			'password' => $this->input->post('password'),
		);
		
		$logindata = $this->Auth_model->login($data);

		if(!$logindata) {
			echo json_encode(array(
				'form' => 'Invalid login credentials.',
				'status' => 0
			));
			exit();
		}

		$newdata = array(
			'login_id' => $logindata['id'],
			'name' => $logindata['name'],
			'role' => $logindata['role'],
			'image' => $logindata['image'],
			'login_time' => date('H:i:s')
		);

		$this->session->set_userdata($newdata);
		$redirect = $baseurl.'dashboard';

		echo json_encode(array(
			'redirect' => $redirect,
			'status' => 1
		));
		exit();
	}

	public function logout(){
		$baseurl = base_url();

		//Clear Session Before Starting a New One
		$data = array('login_id' => '', 'name' => '', 'role' => '', 'image' => '', 'login_time' => '');

		$this->session->set_userdata($data);
		$this->session->sess_destroy();
		redirect($baseurl);
	}


	public function profile()
	{
		$baseurl = base_url();
		/*if($this->session->userdata('login_id') == '') {
			redirect($baseurl);
		}*/

		$db = \Config\Database::connect();
		$builder = $db->table('tbl_users');

		//getting profile details
		$profile_details = $builder->select('tbl_users.first_name, tbl_users.last_name, m.image, tbl_users.email_id')
		->join('tbl_images as m', 'tbl_users.user_id = m.user_id')
		->where('tbl_users.user_id', 1)
		->where('tbl_users.status', 1)
		->get()->getResult();

		$result = array('profile_details' => $profile_details);

		return view('common/header');
		return view('profile',$result);
		return view('common/footer');
	}

	//change password
	public function change_password() {
		$baseurl = base_url();
		date_default_timezone_set("UTC");
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array(
				'c_status' => 0,
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}
		//old password
		$pass = $_POST['old_pass'];
		$query = $this->db->where('user_id', $this->session->userdata('login_id'))->get('tbl_users')->row_array();
		$salt = $query['salt'];
		$saltedPW = $pass.$salt;
		$hashedPW = hash('sha256', $saltedPW);

        //new password
		$npass = $_POST['new_pass'];
		$nsalt = bin2hex(random_bytes(32));
		$nsaltedPW = $npass.$nsalt;
		$nhashedPW = hash('sha256', $nsaltedPW);

		$error = array('old_pass' => '', 'new_pass' => '', 'cnew_pass' => '', 'status' => '');
		$error['csrfName'] = $this->security->get_csrf_token_name();
		$error['csrfHash'] = $this->security->get_csrf_hash();

		$rex = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{6,25}$/';

		if(empty($_POST['old_pass'])) {
			$error['old_pass'] = 'Old password cannot be empty.';
			$error['status'] = 1;
		} else if($hashedPW != $query['password']){
			$error['old_pass'] = 'Entered password does not match your current password.';
			$error['status'] = 1;
		}

		if(empty($_POST['new_pass'])){
			$error['new_pass'] = 'New password cannot be empty.';
			$error['status'] = 1;
		} else if (!preg_match($rex, $_POST['new_pass'])) {
			$error['new_pass'] = 'The New Password field must be between 6 to 25 characters including at least 1 Alphabet, 1 Number and 1 Special Character.';
			$error['status'] = 1;
 		}

		if ($_POST['new_pass'] == $_POST['old_pass']){
 		// if($nhashedPW == $query['password']){
			$error['new_pass'] = 'The New Password field must differ from Current Password.';
			$error['status'] = 1;
		}

		if(empty($_POST['cnew_pass'])){
			$error['cnew_pass'] = 'Confirm password cannot be empty.';
			$error['status'] = 1;
		} else if($_POST['new_pass'] != $_POST['cnew_pass']){
			$error['cnew_pass'] = 'The Confirm Password field does not match the New Password field.';
			$error['status'] = 1;
		}

		if($error['status'] == 1){
			echo json_encode($error);
			exit();
		}

		$pass_data = array(
			'password' => $nhashedPW,
			'salt' => $nsalt
		);

		$change_pass = $this->db->where('user_id', $this->session->userdata('login_id'))->update('tbl_users', $pass_data);
		if($change_pass){
			$return = array(
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'msg' =>'Password changed successfully',
				'c_status' => 1
			);
		}
		else {
			$return = array(
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash(),
				'msg' =>'Please try again',
				'c_status' => 0
			);
		}
		echo json_encode($return);
		exit();
	}

	public function change_profile_img(){ 
		$baseurl = base_url();
		if($this->session->userdata('login_id') == '') {
			echo json_encode(array());
		} 
		
		if(isset($_FILES['profile_img'])) {
			//Upload Image
			date_default_timezone_set("UTC");
			$timestamp = new DateTime();
			$timestamp = $timestamp->format('U');
			$img = 'profileimage_' .$timestamp. '_' .$this->session->userdata('login_id'). '_' .$_FILES['profile_img']['name'];

			if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'upload/user/');
			$crop = $_POST['cropimg'];
			$crop = str_replace('data:image/png;base64,', '', $crop);
			$crop = str_replace(' ', '+', $crop);
			$cropdata = base64_decode($crop);
			$file = uniqid() . '.png';

			$orgurl = UPLOAD_DIR . $img;
			$url = UPLOAD_DIR . $file;
			
			$data = array(
				'user_id' => $this->session->userdata('login_id'),
				'image' => $file,
				'original_image' => $img,
				'ip_address' => $this->input->ip_address(),
				'regdate' => date('Y-m-d H:i:s'),
				'status' => 1
			);
			$this->db->where('user_id', $this->session->userdata('login_id'))->update('tbl_images', array('status' => 0));
			$insert = $this->db->insert('tbl_images', $data);
			if($insert) {
				/*move_uploaded_file($_FILES['userimg']['tmp_name'], UPLOAD_DIR . $img);
				file_put_contents(UPLOAD_DIR . $file, $cropdata);*/
				$this->load->model('Compress_model');
				$filename = $this->Compress_model->compress_image_file($_FILES["profile_img"]["tmp_name"], $orgurl, $_FILES["profile_img"]["size"]);
				$filename = $this->Compress_model->compress_image_base64($cropdata, $url, 100);

				$this->session->set_userdata(array('image' => $file));
				$this->session->set_flashdata("succ", "Profile image updated successfully.");
			}
			else {
				$this->session->set_flashdata("err", "Cannot update profile image. Server is currently down");
			}
		}		
		redirect($baseurl.'login/profile/');
	}
}
