<?php
function todays_sim_timeline() {
  $dayofweek = date('w', strtotime($date));

  // Prints a timeline showing the current hours the restaurant is opne for that day
  // '0' = sunday, '1' = monday, ect...

  if ($dayofweek = 0){
    ?>
    <div>
      <?php echo do_shortcode("[bookingtimeline limit_hours='7,22' type='5,6,7,8,9,10,11,12' view_days_num=1 header_title='Todays Simulator Availability']"); ?>
    </div>
    <?php
  }
  elseif ($dayofweek > 0 && $dayofweek < 5) {
    ?>
    <div>
      <?php echo do_shortcode("[bookingtimeline limit_hours='7,23' type='5,6,7,8,9,10,11,12' view_days_num=1 header_title='Todays Simulator Availability']"); ?>
    </div>
    <?php
  }
  else {
    ?>
    <div>
      <?php echo do_shortcode("[bookingtimeline limit_hours='7,24' type='5,6,7,8,9,10,11,12' view_days_num=1 header_title='Todays Simulator Availability']"); ?>
    </div>
    <?php
  }
}

add_shortcode( 'todays_sim_bookings', 'todays_sim_timeline');
