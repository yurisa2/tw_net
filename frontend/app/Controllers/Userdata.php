<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Userdata extends Controller {


  public function index()
  {
    // echo 'Hello World!';

    $userModel = new UserModel();

    // var_dump($userModel);

    $data = [
     'users' => $userModel->paginate(10),
     'pager' => $userModel->pager
 ];


 
// echo '<pre>';
//  var_dump($data);

         echo view('users/index', $data);


  }



}


?>
