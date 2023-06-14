<?php 
namespace App\Controllers;
//use CodeIgniter\RESTful\ResourceController;
use App\Controllers\BaseController;

class Login extends BaseController
{
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
		redirect($baseurl);
	}
}

