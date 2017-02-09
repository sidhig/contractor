<? error_reporting(0);

ini_set('max_execution_time', 6000);
$dbcnx = mysql_connect('132.148.86.127', 'contracktor', 'Uve52^s6');
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
$numevent			= 0;

if ($dateval != '' && $IMEI != '') 
{
			$initial_date=date_create($dateval);
			$filename = "Monthly_Idle_Summary_Report_".date_format($initial_date,"m_d_y")."_to_".date_format(date_add($initial_date,date_interval_create_from_date_string("1 month -1 second")),"m_d_y")."_updated.csv"; 

			$maxminid = mysql_fetch_array(mysql_query("select min(id) as `minid`, max(id) as `maxid` from tbl_event_data where date(timestamp) = '".$dateval."' "));


			$result= mysql_query("select DeviceName,DeviceIMEI,DeviceType,driver_name from tbl_device_det where DeviceIMEI = '".$IMEI."' order by DeviceType ");
			while ($row = mysql_fetch_array($result)) { 

			
				$driver = "\"".$row['driver_name']."\"";
				$device = "\"".$row['DeviceName']."\"";
				$typedevice = "".$row['DeviceType']."";
												
				$select = "select deviceid as 'Device Name',
				timestamp as 'Date_Time',
				miles_driven_sys as 'Miles',
				description as 'Description',
				concat(lati,',',longi) as 'Location Link',
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
			
				$start6011   = '';
				$stop6012    = '';
				$eventtime   = '';
				$startideal  = '';
				$stopideal   = '';
				$Totalideal  = 0;
				$milesstart	 = '';
				$Start_miles	= 0;
				$totalmilesval = 0;
				$last_miles = 0 ;
				$location  = '' ;

				$start6011_forstop   = '';
				$stop6012_forstop    = '';
				
				
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
					
						if($count == 1 )
						{
							$eventtime = $value;
						}
						if($count == 4 )
						{
							$Location = $value;
						}
					
						//Device Start 
						if ($count == 8 &&  $value == '6011')
						{
								$start6011 = $eventtime;
						}
						//Device Stop 
						if ($count == 8 &&  $value == '6012' && $start6011 != '')
						{
								$stop6012 = $eventtime;
						}

						//Device Start 
						if ($count == 8 &&  $value == '6012')
						{
								$stop6012_forstop = $eventtime;
						}
						//Device Stop 
						if ($count == 8 &&  $value == '6011' && $stop6012_forstop != '')
						{
								$start6011_forstop = $eventtime;
						}

						if ($count == 8 &&  $num_rows == $numevent && $start6011 != '')
						{
								$stop6012 = $dateval.' 23:59:59';
						}

						if ($count == 8 &&  $num_rows == $numevent && $stop6012_forstop != '')
						{
								$start6011_forstop = $dateval.' 23:59:59';
						}

						if ($numevent == 1 && $count == 8 && $value == '4001')
						{
								$start6011 = $dateval.' 00:00:00';
						}

						if($start6011 != '')
						{
							//Checking for Ideal 
							if($count == 7 && $value != '' && $startideal == '' )
							{
								$startideal = $eventtime;
							}
							else if ($count == 7 && $value == '' && $startideal != '')
							{
								$stopideal = $eventtime;
							}
						
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

						$count++;
					}

					if($startideal != '' && $stopideal != '')
					{

						$to_time = strtotime($startideal);
						$from_time = strtotime($stopideal);
						$Totalideal = $Totalideal + abs($to_time - $from_time);
						$startideal  = '';
						$stopideal   = '';
					}
					
					if($start6011 != '' && $stop6012 != '')
					{
						$to_time = strtotime($start6011);
						$from_time = strtotime($stop6012);
						$Totalignontime = abs($to_time - $from_time);
						
						$geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$Location); 
						$output = json_decode($geocodeFromLatLong);
						$address = $output->results[0]->formatted_address;
								
						$dataval = $output->results[0]->address_components;
				
						  foreach($dataval as $elements)
						  {
						   if($elements->types[0] == 'street_number')
						   {
							$Addressval = $elements->long_name;
						   }
						   if($elements->types[0] == 'route')
						   {
							$Addressval = $Addressval." ".$elements->long_name;
						   }
						   if($elements->types[0] == 'locality')
						   {
							$Cityval = $elements->long_name;
						   }
						   if($elements->types[0] == 'administrative_area_level_1')
						   {
							$stateval = $elements->long_name;
						   }
						   if($elements->types[0] == 'postal_code')
						   {
							$postalval = $elements->long_name;
						   }
						  }
						$address = $Addressval . ",".$Cityval.",".$stateval.",".$postalval;
			//$add=explode(',',$address);
			
						echo "".date('h:i A',strtotime($start6011)).
							 "##" . $totalmilesval.' mi <br/>'. getHHMM($Totalignontime). 
							 "##".$address . 
							 "##".date('h:i A',strtotime($stop6012)). 
							 "##" .  getHHMM($Totalideal)."##";
						$start6011  = '';
						$stop6012   = '';
						$Totalideal = 0;
						$totalmilesval = 0;
					}

					if($stop6012_forstop != '' && $start6011_forstop != '')
					{
						$to_time = strtotime($stop6012_forstop);
						$from_time = strtotime($start6011_forstop);
						$Totalignontime = abs($to_time - $from_time);
						echo getHHMM($Totalignontime). 
							 "##";
						$stop6012_forstop = "";
						$start6011_forstop = "";
					}
				}

				
			}

}
	function getHHHHH($min)
	{
		return number_format((float)($min /60), 2,'.','');
	}

	function getHHMM($min)
	{
		
		$val = '';
		$sec = $min ;//* 60 ;

		$d = floor($sec/(3600*24));
		$sec = $sec - ($d * 3600*24);
		$h = floor( $sec /3600);
		$m = floor(($sec - $h *3600) / 60);
		$s = $sec - (( $h *3600)+($m*60));
		if($d > 0)
		{
			$val = $val.$d.' Days ';
		}
		if($h > 0)
		{
			$val = $val.$h.'h ';
		}
		if($m > 0)
		{
			$val = $val.$m.'m ';
		}
		if($s > 0)
		{
			$val = $val.$s.'s ';
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
