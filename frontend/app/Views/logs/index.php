<?= $this->extend('default_layout') ?>
<?= $this->section('content') ?>
<?php
$table = new \CodeIgniter\View\Table();

$template = [
        'table_open' => '<table id="simple-table" class="table  table-bordered table-hover width=100%">'];

$table->setTemplate($template);


$table->setHeading('Id', 'Link User', 'Date', 'Response', 'Generic Data');
echo $table->generate($log);


?>
  <?= $pager->links() ?>
  <?= $this->endSection() ?>
