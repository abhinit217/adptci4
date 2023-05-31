<?php 
namespace App\Controllers;
use App\Controllers\BaseController;

class Abhinit extends BaseController
{
   public function index() {
      $data['content'] = "Home Page";
      return view('abhinit',$data);
   }
}