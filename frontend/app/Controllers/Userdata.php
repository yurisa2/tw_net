<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Userdata extends Controller {


  public function index()
  {
    echo 'Hello World!';

    $userModel = new UserModel();
    echo '<pre>';
    var_dump($userModel->listar());



  }



}


?>
