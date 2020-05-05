<?php 

$z = [
    'Drago' => [1,2,3,4,5,6],
    'Rex' => ["hello","world"]
  ];

$year = "year2020";
$day = "22";
$y = array($year => [$day => ["123123123"]]);
  $z = array_merge($z, $y);
  print_r($z);
  echo "<br>---------------------------<br>";
  echo $z['year2020'][3];
  // -----------------------------------------------
  if (isset ($z[$year][$day])){
    array_push($z[$year][$day], "isset works");
  }
  else{
  $y = array($year => [$day => ["2"]]);
  $z = array_merge($z, $y);
  }
  echo "<br>---------------------------<br>";
  print_r($z[$year][$day]);

  function test($day, $year, $value){
    $y = array($year => [$day => [$value]]);
    $z = array_merge($z, $y);
    print_r($z);
    echo "<br>---------------------------<br>";

    // -----------------------------------------------
    if (isset ($z[$year][$day])){
      array_push($z[$year][$day], $value);
    }
    else{
    $y = array($year => [$day => [$value]]);
    $z = array_merge($z, $y);
    }
    echo "<br>---------------------------<br>";
    print_r($z[$year][$day]);

  }
?>