<?php
// echo '<pre>';
//
foreach ($users as $key => $value) {
  $users[$key] = (array)$value;
}
// var_dump($users);

$table = new \CodeIgniter\View\Table();
$table->setHeading('id', 'Screenname', 'Size');
echo $table->generate($users);

 ?>
<?= $pager->links() ?>
