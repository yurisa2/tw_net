<?php namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{

  protected $table      = 'logs';
  protected $primaryKey = 'id';

  protected $returnType = 'array';
  protected $useSoftDeletes = true;

  public function __construct() {
    $this->db = \Config\Database::connect();


  }


  public function listar (){

    $query   = $this->db->query('SELECT * FROM logs');
    $results = $query->getResult();

    return $results;
  }

}

?>
