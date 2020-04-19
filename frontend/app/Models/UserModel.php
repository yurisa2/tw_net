<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

  protected $table      = 'user_data';
  protected $primaryKey = 'id';

  protected $returnType = 'array';


}

?>
