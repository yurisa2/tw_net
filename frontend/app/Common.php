<?php

/**
* The goal of this file is to allow developers a location
* where they can overwrite core procedural functions and
* replace them with their own. This file is loaded during
* the bootstrap process and is called during the frameworks
* execution.
*
* This can be looked at as a `master helper` file that is
* loaded early on, and may also contain additional functions
* that you'd like to use throughout your entire application
*
* @link: https://codeigniter4.github.io/CodeIgniter4/
*/


function processJson($json) {

  if(is_string($json)) $users = \json_decode($json, TRUE);
  if(is_array($json)) $users = $json;

  if(is_null($users)) return NULL;

  $string = '<ul>';

  foreach ($users as $key => $value) {
    if(is_string($key)) $string .= '<li><b>'.$key.'</b></li>';

    if(is_string($value)) {
      $string .= '"'.$value.'", ';
    }

    if(is_array($value)){
      // var_dump($value);
      $string .= processJson($value);
    }
  }

  $string .= '</ul>';

    // var_dump($json);

  return $string;
}
