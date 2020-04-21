<?= $this->extend('default_layout') ?>
<?= $this->section('content') ?>

<?php
// echo '<pre>';
//
foreach ($users as $key => $value) {
  $users[$key] = (array)$value;
}
// var_dump($users);

$table = new \CodeIgniter\View\Table();
$template = [
        'table_open' => '<table id="simple-table" class="table  table-bordered table-hover width=100%">'];

$table->setTemplate($template);


$table->setHeading('id', 'service', 'Screenname', 'search', 'Time IN', 'Time Out', "Freq IN", "Freq Out");
echo $table->generate($users);

 ?>

<?= $pager->links() ?>
<?= $this->endSection() ?>
