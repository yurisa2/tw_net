<?php namespace App\Controllers;

use App\Models\LogModel;
use CodeIgniter\Controller;

class Log extends Controller {


  public function index()
  {
    $model = new \App\Models\LogModel();
    $model = $model->orderBy('id','desc');

    $data = [
     'title' => 'Logs',
     'log' => $model->paginate(10),
     'pager' => $model->pager
 ];


    $data['log'] = $this->processLogRow($data['log']);
    $data['log'] = $this->processResponse($data['log']);

    // echo '<pre>'; var_dump($data); exit;


    echo view('logs/index', $data);
  }

  public function processLogRow($log) {

    foreach ($log as $key => $value) {

      // if (isset(\json_decode($value["response"])->created_at)) {
      //   $value["response"] = \json_decode($value["response"])->created_at;
      //
      // } else {
      //   $value["response"] = NULL;
      // }

      $value["generic_data"] = \json_decode($value["generic_data"], TRUE);
      $log[$key] = $value;
    }

    // \var_dump($value); exit;

    return $log;
  }


    public function processResponse($response) {

      // echo '<pre>';var_dump($response); exit;

      foreach ($response as $key => $value) {

        $users = \json_decode($value['response'], TRUE);


        // echo '<pre>'. \var_dump($users);


        if(strlen($value['response'])>10) $value['response'] = processJson($value['response']);

        $response[$key] = $value;
      }

      return $response;
    }

}


?>
