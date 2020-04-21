<?= $this->extend('default_layout') ?>
<?= $this->section('content') ?>
<?php

helper('form');

$attributes = ['class' => 'form-horizontal', 'role' => 'form'];

echo form_open('userdata/update', $attributes);

foreach ($userData as $key => $value) {

  // var_dump($value); exit;
  echo '<div class="form-group">';

  $data = [
          'name'      => $key,
          'id'        => $key,
          'value'     => $value,
          'maxlength' => '500',
          'size'      => '50',
          'style'     => 'width:50%'
  ];

  $label = ['class' => 'col-sm-3 control-label no-padding-right'];

  echo form_label($data['id'],$key,$label);

  $input = ['class' => 'typeahead scrollable tt-input',
            'style' => 'position: relative; vertical-align: top; background-color: transparent;',
          ];

  if($key == 'search') {
    echo form_textarea($data, $value, $input);
  } else {
    echo form_input($data, $value, $input);
  }

  echo '</div>';

  // if($key == 'search') {
  //   echo '<br><br>';
  //   // echo  processJson($value);
  // }

}


$data = [
        'name'    => 'update',
        'id'      => 'submit',
        'class'   => 'btn',
        'type'    => 'submit',
        'content' => 'Update'
];


echo form_submit($data, 'Update Record!');
?>

  <?= $this->endSection() ?>
