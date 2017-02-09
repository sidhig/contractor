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
echo $report;
}
?>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaL0ieAkLhzy1rDoLifajeowdXPwTvzmI"></script>
<script>
$(document).ready(function(){ //alert(data);
	var timestamp = '<?=$_POST["for_date"]?>';
	var IMEI = '<?=$_POST["driver_name"]?>';
	$.ajax({
		type:'post',
		url:'report.php',
		data:'timestamp='+timestamp+'&imei='+IMEI
	}).done(function(data){
		//alert(data);
		var data_arr = data.split(',');
		//$('#1').html('<b>'+data_arr[0]);
		$('#2').html('<b>'+data_arr[1]);
		$('#3').html('<b>'+data_arr[2]);
		$('#4').html('<b>'+data_arr[3]);
		$('#5').html('<b>'+data_arr[9]);
		$('#6').html('<b>'+data_arr[4]);
		$('#7').html('<b>'+data_arr[10]);
		$('#tab_list_spinner').show();
	});
	  var trHTML = '<tr>';
	  
	$.ajax({
		type:'post',
		url:'reporttemp.php',
		data:'timestamp='+timestamp+'&imei='+IMEI
	}).done(function(data){ //alert(data);
		var res_str = data.replace(/##+$/g,"");//alert(res_str);
		//var j =0;var k = '';
		$.each(res_str.split('##'), function( index, value ) {
			//j++;
			var i = false;
			if(index % 6 == 0){
				//i = true;
			  trHTML +='</tr><tr>'
			}
			/* if(i){
				 k = j;
			} */ 
		  trHTML += '<td style="text-align:center;color:black;">'+value + '</td>';
		  
		});
		$('#records_table').append(trHTML);
		$('#tab_list_spinner').hide(); 
		$('#records_table').show();
	});
	
});
</script>
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
#report_head{
	color: white;
    background-color: #49b5e4;
    padding: 0.1vh;
    width: 20vw;
    height: 6vh;
    text-align: center;
}
#report_head1{
    background-color: #49b5e4;
    width: 75vw;
    height: 1.2vh;
}
</style>
<script type="text/javascript" src="js/jquery.min.1.12.0.js"></script>

<center><div id="container" style="width:70%;height:auto;">
<div id="wrappermap" style="width:98%;height:auto;">
</center>
<h2 style="color:#2196F3;">Daily Report</h2>
<?date_default_timezone_set('US/Eastern');?>
<h4 style="color:#2196F3;">Created:<?=Date('m/d/Y h:i A')?></h4>
<?
 $result = $conn->query("select driver_name from tbl_device_det where OBDType = 'OBDII' and DeviceIMEI ='".$_POST["driver_name"]."'")->fetch_object(); 
 ?>
<h4 style="color:#2196F3;"><?=$result->driver_name?></h4>

<div id="report_head">
<h4>Report Totals for: <?=date('m-d-Y ',strtotime($_POST['for_date']))?> 
</h4>
</div>
<div id="report_head1">
</div>
<style>
.tb_span{
	font-size:small;
	display:none;
}
.table{
	width: 90%;
	border-color: none;
	color:#2196F3;
}
#main_det>tbody>tr>td{
	width:9vw;
	border-top: none;
	
}
#records_table>tbody>tr>td{
    border-top: 1px solid #49b5e4;
    border-right: 1px solid #49b5e4;
	border-bottom: 1px solid #49b5e4;
}
#records_table>tbody>tr>th{
    border-top: 1px solid #49b5e4;
    border-right: 1px solid #49b5e4;
}
.tab_td{
	border-right: 1px solid #49b5e4;
}
</style>
<div id="hidden_add" style="display:none;"></div>
<table id="main_det" class="table">
	<tr>
		<td class="tab_td">Total Stop Duration:</td>
		<td class="tab_td">Total Idle Time:</td>
		<td>Total Travel Duration:</td>
	</tr>
	<tr>
		<td id="5" class="tab_td"></td>
		<td id="2" class="tab_td"></td>
		<td id="3"></td>
	</tr>
	<tr>
		<td class="tab_td">Total Distance Traveled(Miles):</td>
		<td class="tab_td">Number Of Stops:</td>
		<td>Idle(%):</td>
	</tr>
	<tr>
		<td id="6" class="tab_td"></td>
		<td id="7" class="tab_td"></td>
		<td id="4" ></td>
	</tr>
</table>
<center><div id='tab_list_spinner' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Please wait for Report List...</div></center>
<table id="records_table" class="table" style="display:none;">
<tr><th><b>Start Time</th><th><b>Distance(Miles) Duration</th><th><b>Stop Location</th><th><b>Arrival Time</th><th><b>Idle Duration</th><th><b>Stop Duration</th></tr>
</table>

</center>
</form>
<script>
/* jQuery("#records_table").each(function() {
    var $ = jQuery;
    var tbl = $(this);
    $('th', this).click(function() {
        var clickRow = $(this).closest('tr');
        var body = $(this).closest('tbody').get(0);
        var col = $(this).index();
        var sortKeys = $(body).find('tr').not(clickRow).map(function(idx, row) {
			//alert($('td', row).eq(col).text().split(" ")[1]);
            return {
                row: row,
                key: $('td', row).eq(col).text().split(",")[0] // you can do all sorts of things besides simple text values. cache the key for efficiency
            };
        }).get();
		
        sortKeys.sort(function(a, b) {
            return a.key > b.key ? 1 : a.key < b.key ? -1 : 0; 
        });
        for (var i = sortKeys.length - 1; i >= 0; i--) {
            body.appendChild(sortKeys[i].row);
        }
    });
}); */
</script>
</div><!---wrappermap close -->

		</div></center><!--- container close -->

