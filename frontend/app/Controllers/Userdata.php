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
      'title' => 'Users',
      'users' => $userModel->paginate(10),
      'pager' => $userModel->pager
    ];

    $data['users'] = $this->processRowUsers($data['users']);
    $data['users'] = $this->processSearch($data['users']);


    echo view('users/index', $data);
  }


  public function processRowUsers($users) {

    foreach ($users as $key => $value) {
      $value['id'] = anchor('userdata/edit/'.$value['id'],
                            'Edit: '.$value['id'],
                            ['title' => 'Edit: '.$value['id'],
                            'class' => 'btn']);
      unset($value['token']);
      unset($value['token_secret']);
      $users[$key] = $value;
    }

    return $users;
  }


  public function processSearch($users) {

    foreach ($users as $key => $value) {

      $value['search'] = processJson($value['search']);

      $users[$key] = $value;
    }

    return $users;
  }

  public function edit($id) {

    $userModel = new UserModel();
    $user_data = ['title' => 'Editar Form',
                  'userData' => $userModel->find($id)];


    // var_dump($user_data);

    echo view('form/userdata',$user_data);

  }

  public function update() {

// echo '<pre>'; var_dump($_POST); exit;

$userModel = new UserModel();

// $get_json = [ 'datasets' => $_POST['datasets'],
//               'hashtags' => $_POST['hashtags'],
//               'people' => $_POST['people']
//   ];
//
// $_POST['search'] = \json_encode($get_json);
//
// unset($_POST['datasets']);
// unset($_POST['hashtags']);
// unset($_POST['people']);

$userModel->update($_POST['id'], $_POST);

// redirect("userdata/edit/".$_POST['id']);
// return redirect()->back()->with('foo', 'message');
return redirect()->to('index');

  }

}

?>
