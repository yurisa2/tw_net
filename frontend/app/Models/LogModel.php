<?php namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{

  protected $table      = 'logs';
  protected $primaryKey = 'id';

  protected $returnType = 'array';


}

?>
