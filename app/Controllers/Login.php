<?php 
namespace App\Controllers;
//use CodeIgniter\RESTful\ResourceController;
use App\Controllers\BaseController;
use App\Models\Compress_model;

class Login extends BaseController
{

	function __construct()
	{
		$this->session = \Config\Services::session();
		$this->db = \Config\Database::connect();
		$this->uri = new \CodeIgniter\HTTP\URI(current_url());
		$this->security = \Config\Services::security();
		$this->baseurl = base_url();

		$result['lkp_user_list'] = $this->db->query("select * from tbl_users where status = 1 and user_id = '".$this->session->get('login_id')."'")->getRow();
		if(isset($result['lkp_user_list'])){
			$this->country_id = $result['lkp_user_list']->country_id;
		}else{
			$this->country_id = 1;
		}
		helper('form');
		helper('url');
	}

   	public function index(){
		$baseurl = base_url();
		return view('login');
	}

	public function login()
	{	
		$data = $this->request->getPost();
		var_dump($data);
	}

	
	public function logout(){
		$baseurl = base_url();

		//Clear Session Before Starting a New One
		$data = array('login_id' => '', 'name' => '', 'role' => '', 'image' => '', 'login_time' => '');

		$this->session = \Config\Services::session(); 

		$this->session->remove($data);
		$this->session->destroy();
		return redirect()->to(site_url());
	}

	public function register()
	{
		$result = array('profile_details' => "N/A");

		return view('register',$result)
		.('common/footer');
	}

	public function profile()
	{
		$baseurl = base_url();
		if($this->session->get('login_id') == '') {
			redirect($baseurl);
		}

		//getting profile details

		$profile_details = $this->db->query("select u.first_name, u.last_name, m.image, u.email_id from tbl_users as u join tbl_images as m on u.user_id = m.user_id where u.user_id = '".$this->session->get('login_id')."' and u.status = 1")->getRowArray();

		$result = array('profile_details' => $profile_details);

		$headerresult['country_id'] = $this->country_id;

		return view('common/header', $headerresult)
			.view('profile',$result)
			.view('common/footer');
	}

	public function change_profile_img(){ 
		$baseurl = base_url();
		if($this->session->get('login_id') == '') {
			echo json_encode(array());
		} 
		
		if(isset($_FILES['profile_img'])) {
			//Upload Image
			date_default_timezone_set("UTC");
			/*$timestamp = new DateTime();
			$timestamp = $timestamp->format('U');*/
			$img = 'profileimage_' .time(). '_' .$this->session->get('login_id'). '_' .$_FILES['profile_img']['name'];

			if(!defined('UPLOAD_DIR')) define('UPLOAD_DIR', 'upload/user/');
			$crop = $_POST['cropimg'];
			$crop = str_replace('data:image/png;base64,', '', $crop);
			$crop = str_replace(' ', '+', $crop);
			$cropdata = base64_decode($crop);
			$file = uniqid() . '.png';

			$orgurl = UPLOAD_DIR . $img;
			$url = UPLOAD_DIR . $file;
			
			$data = array(
				'user_id' => $this->session->get('login_id'),
				'image' => $file,
				'original_image' => $img,
				'ip_address' => $this->request->getIPAddress(),
				'regdate' => date('Y-m-d H:i:s'),
				'status' => 1
			);
			$builder = $this->db->table('tbl_images');
			$builder->where('user_id', $this->session->get('login_id'));
			$query = $builder->update(array('status' => 0));

			$builder = $this->db->table('tbl_images');
			$insert = $builder->insert($data);
			if($insert) {
				/*move_uploaded_file($_FILES['userimg']['tmp_name'], UPLOAD_DIR . $img);
				file_put_contents(UPLOAD_DIR . $file, $cropdata);*/
				$Compress_model = new Compress_model();
				$filename = $Compress_model->compress_image_file($_FILES["profile_img"]["tmp_name"], $orgurl, $_FILES["profile_img"]["size"]);
				$filename = $Compress_model->compress_image_base64($cropdata, $url, 100);

				$this->session->set(array('image' => $file));
				$this->session->set("succ", "Profile image updated successfully.");
			}
			else {
				$this->session->set_flashdata("err", "Cannot update profile image. Server is currently down");
			}
		}
		return redirect()->to($this->baseurl.'login/profile/');
	}

	//change password
	public function change_password() {
		$baseurl = base_url();
		date_default_timezone_set("UTC");
		if($this->session->get('login_id') == '') {
			echo json_encode(array(
				'c_status' => 0,
				'csrfName' => $this->security->getCSRFTokenName(),
				'csrfHash' => $this->security->getCSRFHash(),
				'msg' => 'Session Expired! Please login again to continue.'
			));
			exit();
		}
		//old password
		$pass = $_POST['old_pass'];
		$query = $this->db->query("select * from tbl_users where user_id = '".$this->session->get('login_id')."' ")->getRowArray();
		$salt = $query['salt'];
		$saltedPW = $pass.$salt;
		$hashedPW = hash('sha256', $saltedPW);

        //new password
		$npass = $_POST['new_pass'];
		$nsalt = bin2hex(random_bytes(32));
		$nsaltedPW = $npass.$nsalt;
		$nhashedPW = hash('sha256', $nsaltedPW);

		$error = array('old_pass' => '', 'new_pass' => '', 'cnew_pass' => '', 'status' => '');
		$error['csrfName'] = $this->security->getCSRFTokenName();
		$error['csrfHash'] = $this->security->getCSRFHash();

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

		$builder = $this->db->table('tbl_users');
		$builder->where('user_id', $this->session->get('login_id'));
		$change_pass = $builder->update($pass_data);
		if($change_pass){
			$return = array(
				'csrfName' => $this->security->getCSRFTokenName(),
				'csrfHash' => $this->security->getCSRFHash(),
				'msg' =>'Password changed successfully',
				'c_status' => 1
			);
		}
		else {
			$return = array(
				'csrfName' => $this->security->getCSRFTokenName(),
				'csrfHash' => $this->security->getCSRFHash(),
				'msg' =>'Please try again',
				'c_status' => 0
			);
		}
		return $this->response->setJSON($return);
	}
}

