<?
		 session_start();
		 include_once('connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Contractor</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" href="css/bootstrap-multiselect.css"> 
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.3.3.6.css" />


 <script src="js/jquery.min.1.12.0.js"></script> 
 <script src="js/bootstrap-multiselect.js"></script> 
 <script src="js/bootstrap.min.3.3.6.js"></script> 
  <style>
  body{
  /*background-color: #d6dce2;*/
 }
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 86.5vh;}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      min-height: 100%;
      height: auto
    }
    
    /* Set black background color, white text and some padding */
   footer {
      margin-top:.2vh;
      border: 1px solid #BBBBBB;
      height:auto;
      font-size:.9vw;
      padding: 1vh;
      background-color: white;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
    
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
/*    .row.content {
        height: 450vh;
    }*/
     .form-control {
         display:initial;
        height: 30px;
        padding: 3px 6px; 
    }  
    .col-sm-3{
            width: 20%;
    }
    .col-sm-9{
            width: 80%;
    }
	.ScrollStyle
	{
		min-height: 550px;
		max-height: 550px;
		overflow-y: scroll;
	}
  </style>   
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
          <li><img src="image/cont.png" style="width: 15vw;margin-right: 82vw;">
		  <h2 style="width: 30vw;color:white; margin-top: -4vh; margin-left:50vw;">Daily Report</h2></span>
		  </li>
      </ul>
	  
    </div>
  </div>
</nav>
    
<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
	<form id="get_daily_report">
      <ul class="nav nav-pills nav-stacked" style="margin-top:.2vh;">
        <li><a ><b style='margin-right: 2.5vw;'>Driver : </b>
			<input list='browsers' class="intp" style="width: 11.5vw;" id='driver_name' autocomplete="off"/>
             <input type='hidden' name="driver_name" id="hidden_driver_name">   
            </a>
			<? $result = $conn->query("select if(driver_name = '' ,concat(trim(DeviceName ),'(DNM)'), concat(trim(driver_name),'(',trim(DeviceName),')')) as  Deviceanddriver,DeviceName, DeviceIMEI from tbl_device_det  order by driver_name"); 
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

			</li>
        <li><a ><b style='margin-right: 2.5vw;'>For Date : </b>
			<?
				date_default_timezone_set("EST5EDT"); $d=strtotime("-1 day");
			?>
            <input type="date" class="intp" name="for_date" id="for_date" value="<?=date("Y-m-d", $d)?>">
            </a>
        </li>
        <li><a>
            <input type="button" id="submit" onclick="return validateForm()" style="margin-left: 2vw;" value="Get Report" /><input onclick='window.close();' type="button" value="Back" style="float:left;" />
          </a>
        </li>
      </ul>
	</form>
    </div>
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
    <div class="col-sm-9">
		<div class="ScrollStyle" id="report_data">
		
		</div>
		
<?
include('fotter.php');
?>
