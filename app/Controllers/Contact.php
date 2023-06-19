<?php namespace App\Controllers;
 
use CodeIgniter\Controller;
use App\Models\ContactModel;
 
class Contact extends Controller
{
    public function index()
    {    
         return view('contact');
    }
 
    public function create()
    {  
        helper(['form', 'url']);
         
    $db      = \Config\Database::connect();
        $builder = $db->table('contacts');
 
        $data = [
 
            'name' => $this->request->getVar('name'),
            'email'  => $this->request->getVar('email'),
            'message'  => $this->request->getVar('message')
            ];
 
           $save = $builder->insert($data);
 
       $data = [
        'success' => true,
        'data' => $save,
        'msg' => "Thanks for contact us. We get back to you"
       ];
 
       return $this->response->setJSON($data);
    }
}