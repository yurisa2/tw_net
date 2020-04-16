<?php

class Controller_Frequency {

  public function get_time_condition($user_data) {
    $h_now = date("G");

    if($h_now >= $user_data["time_in"] && $h_now <= $user_data["time_out"]) {
      $freq_rand = $user_data["freq_in"];
      // echo "Time In <br>";
      $time_condition = "time_in";
    } else {
      // echo "Time Out <br>";
      $freq_rand = $user_data["freq_out"];
      // $time_condition = "time_out";
      $time_condition = "time_out";
    }

    return $time_condition;
  }

  public function get_freq($user_data, $time_condition) {
    $freq = NULL;

    if($time_condition == 'time_in') $freq = $user_data['freq_in'];
    if($time_condition == 'time_out') $freq = $user_data['freq_out'];

    return $freq;
  }

  public function get_permit($user_data) {
    $time_cond = $this->get_time_condition($user_data);
    $user_freq = $this->get_freq($user_data, $time_cond);

    if(rand(0,100) < $user_freq) {
      $permit = TRUE;
    } else {
      $permit = FALSE;
    }

    return $permit;
  }


}



?>
