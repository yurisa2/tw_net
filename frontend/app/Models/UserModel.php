<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

  protected $table      = 'user_data';
  protected $primaryKey = 'id';

  protected $returnType = 'array';
  protected $useSoftDeletes = true;

  public function __construct() {
    $this->db = \Config\Database::connect();


  }


  public function listar (){

    $results   = $this->db->table('user_data')->get()->getResult();


    return $results;
  }

}

?>
