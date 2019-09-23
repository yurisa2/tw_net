<?php
use Stringy\Stringy as S;

class TextFormat {



    function trim_last_sentence($input, $max_chars) {

      $input = (string)S::create($input)->truncate($max_chars, '');

      $idx_period = (string)S::create($input)->indexOfLast('.');
      $idx_exp = (string)S::create($input)->indexOfLast('!');
      $idx_int = (string)S::create($input)->indexOfLast('?');
      $idx_ret = (string)S::create($input)->indexOfLast('...');

      $last_idx = max($idx_period,$idx_exp,$idx_int,$idx_ret);

      $input = (string)S::create($input)->truncate($last_idx+1, '');

      return $input;
    }


}




 ?>
