<?php namespace App\Controllers;

use App\Models\LogModel;
use CodeIgniter\Controller;

class Log extends Controller {


  public function index()
  {
    $model = new \App\Models\LogModel();

    $data = [
     'title' => 'Logs',
     'log' => $model->paginate(10),
     'pager' => $model->pager
 ];


    echo view('logs/index', $data);
  }


}


?>
