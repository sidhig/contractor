<?php
		  session_start();
		 // error_reporting(0);
		     set_time_limit(0);
		  //print_r($_REQUEST);
	 include_once('connect.php');

if($_POST["driver_name"]!='') 
{ 
  //$reportbyid =$conn->query("select max(maxid) as maxid,min(minid) as minid from table_id_ref where val_date = '".$_POST['for_date']."'")->fetch_object();
		
$report = "select * from tbl_event_data_start_stop where `timestamp` > '".$_POST['for_date']." 00:00:00' and `timestamp` < '".date( 'Y-m-d', strtotime( $_POST['for_date'] . ' +1 day' ) )." 00:00:00' and DeviceImei = '".$_POST['driver_name']."' order by `timestamp`";
//echo $report;
}
?>

<style>
 html, body, #map-canvas {
				height: 100%;
				margin: 0px;
				padding: 0px
			  }
.trip{
margin:10px;
border:2px solid black;
padding:10px;
font-weight:600;
align:center;
}
div#cost input{
width:90px;
}
footer {
      color:black;
      padding-top: 1vh;
      padding-bottom: 0vh;
      background-color: white;
      border: 1px solid #BBBBBB;
      width:100%;
    }
th{
	text-align: center;
	padding-bottom: 3vh;
	font-weight: initial;
}
</style>
<script type="text/javascript" src="js/jquery.min.1.12.0.js"></script>

<center><div id="container" style="width:70%;height:auto;">
<div id="wrappermap" style="width:98%;height:auto;">
<center><h1>Daily Report</h1>
<?
 $result = $conn->query("select driver_name from tbl_device_det where OBDType = 'OBDII' and DeviceIMEI ='".$_POST["driver_name"]."'")->fetch_object(); 
 ?>
<h2><?=$result->driver_name?></h2></center>
<center>
<h3>Report For: <?=date('m-d-Y ',strtotime($_POST['for_date']))?> 
</h3>
</center>
<table border="0" width="100%" style=" border-spacing: 0px;cellpadding:4vh;">
<tr><th><b>Start Time</th><th><b>Stop Location</th><th><b>Arrival Time</th><th><b>Idle Duration</th><th><b>Stop Duration</th></tr>
<?
$csv_string = ",,Stop Report,,,\r\n";
$csv_string = $csv_string.",,Driver Name:,".$result->driver_name.",,\r\n";
$csv_string = $csv_string."Arrival,,Departure,,Details,\r\n";
$csv_string = $csv_string."Date,Time,Date,Time,Duration(HH:MM:SS),Location\r\n";
 $result = $conn->query($report); $count = 0 ; 
 $isstart = false;
 $stat_time_str='';
 ?>

<? 
 while($ereport = $result->fetch_object()){  
$count++;?>

<?  if($ereport->eventcode =='6012' and !$isstart){ ?>
 <tr>
 <? $isstart = true;
 	$sstart_time = $ereport->timestamp;
 	$slati = $ereport->lati;
 	$slongi = $ereport->longi;
 } 
	if($isstart){
		 if($ereport->eventcode=='6011'){
		 	$isstart = false;
		 	$estart_time = $ereport->timestamp;
		 	$elati = $ereport->lati;
		 	$elongi = $ereport->longi;

			if($stat_time_str!=date('m-d-Y',strtotime($sstart_time))){
				$stat_time_str = date('m-d-Y',strtotime($sstart_time));
				//echo '<td>&nbsp;</td></tr><tr>';
				//echo '<th>'.$stat_time_str.'</th>';
			}else{
				//echo '<th></th>';
				$stat_time_str='';
			}
?>
<?
$forPOI = $conn->query("SELECT (name) AS 'POI',(((acos(sin((".$elati."*pi()/180)) * sin((lati*pi()/180))+cos((".$elati."*pi()/180)) * cos((lati*pi()/180)) * cos(((".$elongi."- longi)*pi()/180))))*180/pi())*60*1.1515) as distance FROM `substation_more` order by distance limit 1")->fetch_object();

?>
<!--<th><?//=date('m-d-Y',strtotime($estart_time))?></th>-->
<th><?=date('h:i:s A',strtotime($sstart_time))?></th>
<!--<th><?//=$stat_time_str?></th>-->


<th style="text-align: center;">
<? if($forPOI->distance > 0.5){ ?>
<a style="color:blue;" target="_blank" href="https://maps.google.com/maps?q=<?=$elati.",".$elongi?>" ><img src="image/activity_search_icon.png" style="width: 2vw;"></a>
<?
$loc = '=HYPERLINK("https://www.google.com/maps?q='.$elati.'+'.$elongi.'")';
}else{ ?>
<?=$forPOI->POI?>
<? 
$loc = $forPOI->POI;
} ?>
</th>
<th><?=date('h:i:s A',strtotime($estart_time))?></th>
<th></th>
<th><?=$str = timediff($estart_time,$sstart_time)?></th>
</tr>
<?
$csv_string = $csv_string.
	date('m-d-Y',strtotime($estart_time)).','.
	date('h:i:s A',strtotime($estart_time)).','.
	date('m-d-Y',strtotime($sstart_time)).",".
	date('h:i:s A',strtotime($sstart_time)).','.
	$str.','.$loc."\r\n";
		 }

?>

    <? } 

    }
    ?>

</table>
<textarea id="csv_string" style="display:none;" ><?=$csv_string?></textarea>
<center>

<?
function timediff($etime,$stime){
		$datetime1 = new DateTime($etime);
		$datetime2 = new DateTime($stime);
		$interval = $datetime1->diff($datetime2); 
		$dd = $interval->format('%a days');//echo $dates;
		//$dt=0;
		if($dd >0){
		$dd=$dd*24;
		}
		$hh = $interval->format('%H');
		$d=$dd+$hh;
		$mm = $interval->format('%I:%S');
		//$ss = $interval->format('%S');
		//echo $mm;
		if($d<9)
		{
		 $d='0'.$d;
		}
		//echo $d.':'.$mm.':'.$ss;
		return $d.':'.$mm;
}

/*$myfile = fopen("Exc Report.csv", "w") or die("Unable to open file!");
fwrite($myfile, $csv_string);
fclose($myfile);*/
?>
<div id="butns" style="padding: 20px 24% 20px 24%;">
<input type="button" id="excep_report" style=" width: auto; min-width: 25%; font-weight: 700; height: 40px; cursor:pointer; background: url('image/3_d_button.png'); background-size: 100% 100%; border:0px;color: #337ab7;" onclick="PrintElem('#wrappermap')" value="Print" />
<input type="button" id="excep_report" style=" width: auto; min-width: 25%; font-weight: 700; height: 40px; cursor:pointer; background: url('image/3_d_button.png'); background-size: 100% 100%; border:0px;color: #337ab7;" onclick="exc()" value="Send CSV" />
<a id="csv_link" href=""><input type="button" id="excep_report" style=" width: auto;  min-width:40%;  font-weight: 700;  height: 40px; cursor:pointer; background: url('image/3_d_button.png'); background-size: 100% 100%; border:0px;" onclick="exc_download()" value="Download CSV" /></a>
</div><!--butns div close -->
</div>
</center>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
function exc(){
//alert($("#csv_string").val());
$.post( "create_csv.php",{ csv_string: $("#csv_string").val() },function(data) {
					filename = data;
					var email = prompt("Send CSV to Email");
						if(email!='' & email!=null){
						 	$.post( "create_csv.php",{ email: email, csv_string: $("#csv_string").val(), create_for: 'Trip' },function(data) { alert("Email send successfully to "+email); 
							});
						}
						else{ return false; }
					});
}
function exc_download(){
//alert($("#csv_string").val());
$.post( "create_csv.php",{ csv_string: $("#csv_string").val(), create_for: 'Trip' },function(data) { 
					//alert(data);
					$("#csv_link").attr("href", data);
					document.getElementById("csv_link").click();
					});
}
</script>
<script type="text/javascript">

function PrintElem(data) 
    {
	
        /*var mywindow = window.open('', 'wrappermap', 'height=600,width=1000');
        mywindow.document.write('<html><head><title>Trip Sheet</title>');		
        mywindow.document.write('</head><body onload="" >');
		if(data!=''){*/
        //mywindow.document.write($(data).html());
		// mywindow.document.write($("#trip_data").html());this.form.submit();onclick="return alert("If You want to create CSV file Enter Email here"); "
		$("#butns").hide();
		$("#report_back").hide();
		/* mywindow.document.write($("#wrappermap").html());
		 }
		
        mywindow.document.write('</body></html>');
		mywindow.print();*/
		window.print();
		$("#butns").show();
		$("#report_back").show();
		//mywindow.close();
        return true;
    }

</script>



</div><!---wrappermap close -->

		</div></center><!--- container close -->

