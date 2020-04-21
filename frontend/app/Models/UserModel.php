<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

  protected $table      = 'user_data';
  protected $primaryKey = 'id';

  protected $returnType = 'array';

protected $allowedFields = ['service', 'screenname', 'token', 'token_secret', 'search',
                            'time_in', 'time_out', 'freq_in', 'freq_out'];
}

?>
