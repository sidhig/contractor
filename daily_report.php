<?php
		  session_start();
		  error_reporting(0);
		 include_once('connect.php');
	// Edit form script start //

					 
			
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
    <title>Daily Report</title>
<link rel="image icon" type="image/png" sizes="160x160" href="image/icon.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" src="js/jquery.min.1.12.0.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
<script>
    webshims.setOptions('forms-ext', {types: 'date'});
	webshims.polyfill('forms forms-ext');
</script>
<style>
* {
    box-sizing: border-box;
}
.row:after {
    content: "";
    clear: both;
    display: block;
}
[class*="col-"] {
    float: left;
    padding: 15px;
}
html {
    font-family: "Lucida Sans", sans-serif;
}


/* For desktop: */

.col-12 {width: 100%;}
 .sel{width:10vw;}
 .intp{width:10vw;}
@media only screen and (max-width: 768px) {
    /* For mobile phones: */
    [class*="col-"] {
        width: 100%;
    }
    .intp {
        width: 100%;
    }
    .sel {
        width: 100%;
    }
    .tbl {
        height: 100%;
    }
}
footer {
      color:black;
      padding-top: .8vh;
      padding-bottom: 2.5vh;
      background-color: white;
      border: 1px solid #BBBBBB;
      width:100%;
    }
</style>
</head>
<body style="background-color: #d6dce2;">  
<div class="row" style="margin-top:.3vh;border: 1px solid #BBBBBB;background-color: white;padding-bottom:.3vh;height:auto;min-height:70vh;">
	<input onclick='window.close();' type="button" value="Back" style="float:left;margin-top:2vh;margin-left:2vw;" />
	<center><h1>Daily Report</h1></center>
	<form id="get_daily_report">
		<center>
		<div class="tbl" style="width:20%;">
			<div class="col-12 right" style="margin-top:6vh;border: 1px solid black;background-color: white;padding-bottom:1vh;padding-left:1vh;height:auto;min-height:25vh;">
				<strong>Driver: </strong><input list='browsers' class="intp" id='driver_name' autocomplete="off"/><input type='hidden' name="driver_name" id="hidden_driver_name"><br>
				<br>

				<? date_default_timezone_set("EST5EDT"); $d=strtotime("-1 day");
				 ?>
				<strong>For date: </strong><input type="date" class="intp" name="for_date" id="for_date" value="<?=date("Y-m-d", $d)?>">
				<br><br/>
				<input type="button" id="submit" onclick="return validateForm()" value="Get Report" /><br/><br/>
				<span id="error" style="color:red; display:none;">Please wait while your request is processed.</span>
			</div>
		</div>
		</center>
		<script type="text/javascript" src="js/jquery.min.1.12.0.js"></script>

		<script>
		$("#driver_name").on('input', function() {
				var data = {};
				$("#browsers option").each(function(i,el) {  
						   data[$(el).data("value")] = $(el).val();
				});
				console.log(data, $("#browsers option").val());
				var value = $('#driver_name').val();
				//alert(value);
				if(typeof ($('#browsers [value="' + value + '"]').data('value')) === "undefined")
				{
							
				}
				else
				{
							
							var v_imei = ($('#browsers [value="' + value + '"]').data('value'));
							$("#hidden_driver_name").val(v_imei);
							
				}

		});
		
		function validateForm() {
			if (($( "#for_date" ).val() == "") || ($( "#from_time" ).val() == "")) {
			alert("All fields must be filled out");
			return false;
			}
			else if ($( "#hidden_driver_name" ).val() == "") {
			alert("Please select Driver");
			return false;
			}
			else {
			$("#error").show();
				var data = $("#get_daily_report").serialize();//alert(data);
				$.ajax({
					url:'get_daily_report.php',
					type:'post',
					data:data
				}).done(function(data){
					$("#error").hide();
					$('#report_data').html('');
					$('#report_data').html(data);
				});
			}
		}

		</script>
	</form>
<span id="report_data"></span>
</div>
<?php $result = $conn->query("select if(driver_name = '' ,concat(trim(DeviceName ),'(DNM)'), concat(trim(driver_name),'(',trim(DeviceName),')')) as  Deviceanddriver,DeviceName, DeviceIMEI from tbl_device_det  order by driver_name"); 

?>
<datalist id="browsers">
<? 
while($vehicle = $result->fetch_object())
			 {
			 ?>
			   <option data-value="<?=$vehicle->DeviceIMEI?>" value="<?=$vehicle->Deviceanddriver?>" > 
			<?  }
			 ?>
	 </datalist>

<center><div>
<? include_once('fotter.php'); ?>
