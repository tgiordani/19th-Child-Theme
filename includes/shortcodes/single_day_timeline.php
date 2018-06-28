<?php
function todays_sim_timeline() {

  $dayofweek = date('w', strtotime($date));
  $hours = '7,';
  // Prints a timeline showing the current hours the restaurant is opne for that day
  // '0' = sunday, '1' = monday, ect...
  if($dayofweek == 0){
    $hours = $hours . '22';
  }
  elseif(($dayofweek > 0) && ($dayofweek < 5)){
    $hours = $hours . '23';
  }
  else {
    $hours = $hours . '24';
  }

  echo do_shortcode("[bookingtimeline limit_hours='$hours' type='5,6,7,8,9,10,11,12' view_days_num=1 header_title='Todays Simulator Availability']");

}

add_shortcode( 'todays_sim_bookings', 'todays_sim_timeline');
