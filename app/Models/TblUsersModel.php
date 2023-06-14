<?php namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
 
class TblUsersModel extends Model
{
    protected $table = 'tbl_users';
 
    protected $allowedFields = ['username', 'email_id', 'password'];
}