<?php
$signupdate='2017-03-07';
$signupweek=date("W",strtotime($signupdate));
$year=date("Y",strtotime($signupdate));
$currentweek = date("W");

for($i=$signupweek;$i<=$currentweek;$i++) {
    $result=getWeek($i,$year);
    echo "Week:".$i." Start date:".$result['start']." End date:".$result['end']."<br>";
}

function getWeek($week, $year) {
  $dto = new DateTime();
  $result['start'] = $dto->setISODate($year, $week, 0)->format('Y-m-d');
  $result['end'] = $dto->setISODate($year, $week, 6)->format('Y-m-d');
  return $result;
}

?>


<?php
  $signupweek='2014-8-13';
/*start day*/
    for($i = 0; $i <7 ; $i++)
    {
     $date = date('Y-m-d', strtotime("-".$i."days", strtotime($signupweek)));
     $dayName = date('D', strtotime($date));
     if($dayName == "Sun")
     {
       echo "start day is ". $date."<br>";
     }
    }
/*end day*/
 for($i = 0; $i <7 ; $i++)
    {
     $date = date('Y-m-d', strtotime("+".$i."days", strtotime($signupweek)));
     $dayName = date('D', strtotime($date));
     if($dayName == "Sat")
     {
       echo "end day is ". $date."<br>";
     }
    }

?>
<?php
 function getDateRangeForAllWeeks($start, $end){
    $fweek = getDateRangeForWeek($start);
    $lweek = getDateRangeForWeek($end);
    $week_dates = [];
    while($fweek['sunday']!=$lweek['sunday']){
        $week_dates [] = $fweek;
        $date = new DateTime($fweek['sunday']);
        $date->modify('next day');

        $fweek = getDateRangeForWeek($date->format("Y-m-d"));
    }
    $week_dates [] = $lweek;

    return $week_dates;
}

function getDateRangeForWeek($date){
    $dateTime = new DateTime($date);
    $monday = clone $dateTime->modify(('Sunday' == $dateTime->format('l')) ? 'Monday last week' : 'Monday this week');
    $sunday = clone $dateTime->modify('Sunday this week'); 
    return ['monday'=>$monday->format("Y-m-d"), 'sunday'=>$sunday->format("Y-m-d")];
}

print_r( getDateRangeForWeek("2016-05-07") );

print_r( getDateRangeForAllWeeks("2015-11-07", "2016-02-15") );
?>

// current week echo
<?php

$current_dayname = date("l");
             
echo $date = date("Y-m-d",strtotime('monday this week')).' To '.date("Y-m-d",strtotime("sunday this week")); 
?>
//week is given and start and end date is printed
<?php

function getStartAndEndDate($week, $year) {
  $dto = new DateTime();
  $dto->setISODate($year, $week);
  $ret['week_start'] = $dto->format('Y-m-d');
  $dto->modify('+6 days');
  $ret['week_end'] = $dto->format('Y-m-d');
  return $ret;
}

$week_array = getStartAndEndDate(23,2017);
print_r($week_array);
?>


<?php

/* Simple way to get current month name */

$mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");

$date = getdate();
$month = $date['mon'];

$month_name = $mons[$month];

echo $month_name; // Displays the current month

?>

<?php
$signupweek = '2017-01-01';
$signupweek = date("W", strtotime($signupweek));

$current_week = date('W');

$output = array();
for($i = $signupweek + 1; $i < $current_week; $i++) {
	$dates = getStartAndEndDate($i, '2017');
	if(strtotime($dates['start']) > time() or strtotime($dates['end']) > time())
		continue;
	$output[] = $dates;
}

print_r($output);

function getStartAndEndDate($week, $year)
{

    $time = strtotime("1 January $year", time());
    $day = date('w', $time);
    $time += ((7 * $week) + 1 - $day) * 24 * 3600;
    $return['start'] = date('Y-n-j', $time);
    $time += 6 * 24 * 3600;
    $return['end'] = date('Y-n-j', $time);
    return $return;
}


?>
