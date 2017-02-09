  <? 
  session_start();
  include_once('connect.php'); 
  ?>

  <script type="text/javascript" src="https://code.jquery.com/jquery-1.6.min.js"></script>
  <link rel="stylesheet" href="css/jquery.modal.css">
  <script src="js/jquery.modal.js"></script>
  <script>
	 $("#new_tracker").click(function(){
		$("#tracker_load_spinner").show(); 
		$("#trip_sheet_div").load("tracker_add_form.php"); 
		$("#trip_sheet_div").show();
		$( "#tracker_add_btn" ).hide();
			$("#tracker_load_spinner").hide();
	  });
</script>
<script>
 function validateForm(){
    if ($("#trackername").val().trim() == ''){
        alert('Please Fill Tracker Name');
        $("#trackername").focus();
        
      }
      else if ($("#trackerimei").val().trim() == ''){
        alert('Please Fill Tracker MEID DEC');
        $("#trackerimei").focus();
        
      }
      else if ($("#trackerphone").val().trim() == ''){
        alert('Please Fill Tracker Phone');
        $("#trackerphone").focus();
        
      }
    else {
     $("#track_add_spinner").show();
   $.ajax({
            type: "POST",
            url: "tracker_query.php",
            data: $('#new_tracker_form').serialize(),
            success: function(data) {
				alert(data);
				$('#tracker_tbl_body').html('');
				$('#tracker_tbl_body').load('tracker_tbl_body.php');
				$('#add_area').hide();
				$('#list_radio').prop('checked',true);
				$('#list_area').show();
				$('#radio_butt').show();
				$("#track_add_spinner").hide();
            }
        });
    }
}

  
function del_tracker(imei){
  if(confirm("Are you sure to delete this tracker with MEID DEC: "+imei+ "?")){
    $("#tracker_load_spinner").show(); 
      $.ajax({
        type: "POST",
        url: "tracker_query.php",
        data: "del_qry=delete from `tbl_device_det` where DeviceIMEI = '"+imei+"'"+"&del_admin=delete from `tbl_deviceinfo` where deviceIMEI = '"+imei+"'",
        success: function(data) {
          alert(data);
          $("#tracker_tbl_body").load('tracker_tbl_body.php');
          $("#tracker_load_spinner").hide();
        }
      });
  }
}

function edit_tracker(tsn){
    $("#tracker_load_spinner").show(); 
  $.ajax({
            type: "POST",
            url: "tracker_edit_form.php",
            data: "imei="+tsn,
            success: function(data) {
				$("#list_area").hide();
				$("#add_area").html('');
				$("#add_area").html(data); 
				$("#radio_butt").hide();
				$("#add_area").show();
				$("#tracker_load_spinner").hide(); 
            }
        });
  }

/*function config_tracker(tsn){
   $("#tracker_load_spinner").show();
     $.ajax({
            type: "POST",
            url: "add_conf_tracker.php",
            data: "imei="+tsn,
            success: function(data) {
        $("#trip_sheet_div").html(data); 
        $("#trip_sheet_div").show();
        $("#tracker_load_spinner").hide();
            }
        });
}*/
function show_list(){
	$("#tracker_load_spinner").show();
	$("#add_area").hide();
	$("#list_area").show();
	//$("#trip_sheet_div").html("");
	$("#tracker_load_spinner").hide();
}

function show_add_new(){
	$("#tracker_load_spinner").show(); 
	$("#list_area").hide();
	$("#add_area").html('');
	 $("#add_area").load("tracker_add_form.php"); 
	 $("#add_area").show();
	// $( "#tracker_add_btn" ).hide();
	$("#tracker_load_spinner").hide();
}
</script>
<style>
 body{
  background-color: #d6dce2;
 }
 td{
  padding-bottom: .8vh;
  text-align: center;
 }
  .stg{
    margin-left: 2vw;
    margin-right: 1vw;
   }
.sel{
  width:15vw;
  border-radius: 4px;
  padding: 6px 12px;
  height: 34px;
  border: 1px solid #ccc;
}
 .intpclass{
  width:15vw;
   border-radius: 4px;
  padding: 6px 12px;
  height: 34px;
  border: 1px solid #ccc;
  color: black;
}

.modal {
  width:40vw;
}
.modal a.close-modal {
    top: 0.5px;
    right: 0.5px;
  }
 
th {
    text-align: center;
  }

@media only screen and (max-width: 768px) {
    /* For mobile phones: */
   
     .intp {
        width: 100%;
    }
    .sel {
        width: 100%;
    }
  .modal {
  width:90vw;
  }
}
.btn{
  /*background: url(image/close.png) no-repeat;*/
}
.table>thead>tr>th{
	border-top: none;
}

 </style>
</head>
<body>


<button onclick="sch_back();" class="btn btn-danger" style="position: absolute; left: 2vw;">Back</button>

<div id="radio_butt" style="font-size: large;">
	<input type="radio" name="radio_but" id="list_radio" onchange="show_list()" checked>
	<label for="list_radio">Show List</label>
	<input type="radio" name="radio_but" id="add_radio" onchange="show_add_new()">
	<label for="add_radio">Add New Tracker</label>
</div>
<div id='tracker_load_spinner' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Please wait...</div>
<div id="list_area">	
<!--<input type="button" id='new_tracker' value="Add New Tracker" class="btn btn-danger" style="color:black; margin-bottom:.3vh; padding: 1vh;" /><br>-->

<div id='tracker_loading' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Please wait...</div>
 <table border="1" class="table" style="width:98%; margin-top:10px; font-size: smaller; background-color: white;">
 <thead id='tracker_head'>
   <tr style="background-color: rgba(150, 150, 150, 0.25);">
    <th>Tracker Name</th>
    <th>Driver Name</th>
    <th>Driver Phone #</th>
    <th>Tracker MEID DEC</th>
    <!-- <th>Equipment</th> -->
    <th>Tracker Type</th>
    <th>Area</th>
    <th>Supervisor</th>
    <th> forwarded</th> 
    <!-- <th>Last Reported</th>  -->
  <?// if($_SESSION['ROLE_can_edit']){ ?>
    <th>Edit /Delete</th>   
     <? //} ?>
   </tr>
</thead>
   <tbody id="tracker_tbl_body">
<? include_once('tracker_tbl_body.php'); ?>
</tbody>
</table>
	</div>
	<div id="add_area">
	</div>

