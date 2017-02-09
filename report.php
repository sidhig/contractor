<? error_reporting(0);

ini_set('max_execution_time', 6000);
$dbcnx = mysql_connect('132.148.86.127', 'contracktor', 'Uve52^s6');
//$dbcnx = mysql_connect('localhost', 'root', '');
$selected = mysql_select_db("db_contracktor",$dbcnx) ;?>
<?PHP


$dateval			= @$_REQUEST["timestamp"];
$IMEI				= @$_REQUEST["imei"];
$header				= '';
$data				= '';
$totalidle_			= 0;
$totalidledrive_	= 0;
$totalmiles_		= 0;
$totalpowerup		= 0;


if ($dateval != '' && $IMEI != '') 
{
$initial_date=date_create($dateval);
$filename = "Monthly_Idle_Summary_Report_".date_format($initial_date,"m_d_y")."_to_".date_format(date_add($initial_date,date_interval_create_from_date_string("1 month -1 second")),"m_d_y")."_updated.csv"; 

$maxminid = mysql_fetch_array(mysql_query("select min(id) as `minid`, max(id) as `maxid` from tbl_event_data where date(timestamp) = '".$dateval."' "));


			$result= mysql_query("select DeviceName,DeviceIMEI,DeviceType,driver_name from tbl_device_det where DeviceIMEI = '".$IMEI."' order by DeviceType ");
			while ($row = mysql_fetch_array($result)) { 

				$starttime = '';
				$endtime = '';
				$tamival = '';
				$total_idletime = 0;
				$maxidletime = 0;


				$starttime_d = '';
				$endtime_d = '';
				$total_dtime = 0;
				$last_miles= 0;
				$Start_miles= 0;
				$powerup = 0;
				$driver = "\"".$row['driver_name']."\"";
				$device = "\"".$row['DeviceName']."\"";
				$typedevice = "".$row['DeviceType']."";
				$ownedby = "";
				$dept = "";

			
				$totalmilesval = 0;

				$maxspeed = 0;
				$speedcount = 0;

				//For stop 

				$varStart = '';
				$varStop  = '';
				$varStopstart  = 0;
				
				
				$varStoptotal  = 0;
			

		
				$select = "select deviceid as 'Device Name',
				timestamp as 'Date_Time',
				miles_driven_sys as 'Miles',
				description as 'Description',
				concat('=HYPERLINK(\"https://www.google.com/maps/place/',lati,',',longi,'\")') as 'Location Link',
				speed as 'Speed',
				rpm as 'RPM',if(tbl_event_desc.eventcode = 4001 and speed = 0 , if(rpm > 1000,'HIGH IDLE','LOW IDLE') , '')  as 'IDLE Status',tbl_event_desc.eventcode as 'eventcode1' from tbl_event_data left join tbl_event_desc on tbl_event_data.eventcode =  tbl_event_desc.eventcode where DeviceImei = '".$row['DeviceIMEI']."' and id <= ".$maxminid['maxid']." and id >= ".$maxminid['minid']." ";

				$export = mysql_query ( $select ) or die ( "Sql error : " . mysql_error( ) );

				$num_rows = mysql_num_rows ( $export );
				$fields = mysql_num_fields ( $export );

				for ( $i = 0; $i < $fields; $i++ )
				{
					$header .= mysql_field_name( $export , $i ) . ",";
				}
				$header = "Driver, 	Equip # , Dept ,  Equip Type ,Owned By,  Longest Idle ,	Total Idle , Idle Fuel ,Idle Fuel $,	Total Ign On, 	% Idle , Total miles ,# of Power Ups , Speeding , Max Speed , Event Count\n";
				$rowcount = 0;
				$totalmilesval = 0;
				$time_temp = '' ;
				$numevent = 0;

				while( $row = mysql_fetch_row( $export ) )
				{
					$numevent++;
					$tamival = '';
					$tamival_d = '';
					$line = '';
					$count = 0;
					foreach( $row as $value )
					{                   
						$value = str_replace( '"' , '""' , $value );
						
						if(1 == $numevent && $count == 8 && ( $value == '6011' || $value == '4002'  ))
						{
							$varStop = $dateval.' 00:00:00';
						}
						

						if($num_rows == $numevent && $count == 8 && $varStop!= '')
						{
							$varStart = $dateval.' 23:59:59';
						}

						//Calculation for stopduration 
						if($count == 8 &&  $value == '6012')
						{
							$varStop = $tamival_d;
							$varStoptotal++;
						}
						else if($count == 8 &&  $value == '6011' && $varStop!= '')
						{
							$varStart = $tamival_d;
						}

						

						if($count == 3 &&  $value == 'Power Up/Reset and GPS lock' )
						{
							$powerup++;
						}
						
						if($count == 1 )
						{
								$tamival_d = $value;
						}

						if ( ( !isset( $value ) ) || ( $value == "" ) )
						{
							if($count == 7 && $starttime != '') //Ideal State
							{
								$endtime = $tamival;
							}
						}
						else
						{
							
							if($count == 1 )
							{
								$tamival = $value;

							
							}
							if($count == 7 && $starttime == '' && $value == 'LOW IDLE' )
							{
								$starttime = $tamival;
							}
						

							if($Start_miles == 0 && $count == 2)
							{
								$Start_miles = $value;
							}
							if ($count == 2)
							{
								$last_miles = $value;
								if($last_miles > $Start_miles)
								{
									$totalmilesval += ($last_miles-$Start_miles);
								}
								$Start_miles = $last_miles;
							}

							if($count == 5 && $value > 0)
							{
								if($maxspeed < $value)
									$maxspeed  = $value;
							}

							if($count == 5 && $value > 79)
							{
								$speedcount++;
							}

						
							if($count == 3 && $starttime_d == '' && $value == 'Driving ' )
							{
								$starttime_d = $tamival;
							}
							else if($count == 3 && $starttime_d != '' && ($value != 'Driving ' ||  $rowcount == ($num_rows -1 )) )
							{
								$endtime_d = $time_temp;
							}

							else if($count == 3 && $starttime_d != '' && ($value == 'Driving ' &&   round(abs(strtotime($tamival_d) - strtotime($time_temp )) / 60,2) > 10) )
							{
								$endtime_d = $time_temp;
							}
						}

						if($count == 8)
						{
							$time_temp = $tamival_d;
						}
	
						$count++;
					
					}

				
					if($varStart != '' && $varStop != '')
					{
							$to_time = strtotime($varStop);
							$from_time = strtotime($varStart);
							$varStopstart = $varStopstart + abs($to_time - $from_time);

							$varStart = '' ;
							$varStop = '';
					}


					if($starttime != '' && $endtime != '')
					{
							$to_time = strtotime($starttime);
							$from_time = strtotime($endtime);
							$ideltime = ($to_time - $from_time);
							$total_idletime = $total_idletime + $ideltime ;
							if(abs($ideltime) > $maxidletime)
							{
								$maxidletime = abs($ideltime);
							}
							$starttime = '';
							$endtime = '';
							
					}

					if($starttime_d != '' && $endtime_d != '')
					{
							$to_time = strtotime($starttime_d);
							$from_time = strtotime($endtime_d);
							$ideltime = ($to_time - $from_time);
							$total_dtime = $total_dtime + $ideltime ;
							$starttime_d = '';
							$endtime_d = '';


							
					}
					$rowcount++;
				}
				$totalidle_ +=  round(abs($total_idletime) / 60,0);
				$totalidledrive_ +=  round(abs($total_dtime) / 60,0)  ;
				$totalmiles_ += abs($totalmilesval);
		        $totalpowerup = $totalpowerup+$powerup;


				$strval =  getHHMM( round(abs($maxidletime) / 60,0)) .','. getHHMM( round(abs($total_idletime) / 60,0)).','.  getHHMM( round(abs($total_dtime) / 60,0) ).','. ( round(abs($total_idletime*100/$total_dtime),0)).','.round(($totalmilesval),0) .','.$powerup.','.$speedcount.','.round($maxspeed).','.$numevent.','.getHHMM( round(abs($varStopstart) / 60,0)).",".$varStoptotal."\n";

				echo $strval;


				
				$data = $data. $strval ;
			

			}	
	}
	function getHHHHH($min)
	{
	return number_format((float)($min /60), 2,'.','');
	}
	function getHHMM($min)
	{
		
		$val = '';
		$sec = $min * 60 ;

		$d = floor($sec/(3600*24));
		$sec = $sec - ($d * 3600*24);
		$h = floor( $sec /3600);
		$m = floor(($sec - $h *3600) / 60);

		if($d > 0)
		{
			$val = $val.$d.' Days ';
		}
		if($h > 0)
		{
			$val = $val.$h.' hrs ';
		}
		if($m > 0)
		{
			$val = $val.$m.' min ';
		}
	

		return $val;
	}
		 
?>
<? if(empty($_REQUEST)){ ?>
<center>
<h2>Get Monthly Report</h2>
<form method="post" action="<?=basename($_SERVER['PHP_SELF'])?>">
<input type="date" name="timestamp"  />
<input type="submit"  />
</center>
<? } ?>
