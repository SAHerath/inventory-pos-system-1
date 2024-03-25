 <?php


  function checkMyDate($date)
  {
    $dt = DateTime::createFromFormat("Y-m-d", $date);
    //print_r(array_sum($dt::getLastErrors()));
    return $dt !== false && !array_sum($dt::getLastErrors());
  }
