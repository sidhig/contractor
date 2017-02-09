<?php
//print_r($_POST);
  session_start();
include_once('connect.php');

if( $_REQUEST["poi_type"]!='' )
{   //echo "select * from substation_more where `type`='".$_REQUEST["poi_type"]."'";
	$result1 = $conn->query("select * from substation_more where `type`='".$_REQUEST["poi_type"]."'");
	while($row = $result1->fetch_array()) 
	{
		echo "<option data-value='".$row["id"]."' value='".$row["name"]."'></option>";
	}
}
else if( $_REQUEST["poi_id"]!='' & $_REQUEST["poi_search"]=='true' )//search clicked
{    
	$result1 = $conn->query("select * from substation_more where id='".$_REQUEST["poi_id"]."'");
		$row = $result1->fetch_array(); 
	
	?>
	<div class="container" style="height:97%;overflow:hidden;z-index:3">    
         
  <div class="row"  >
    <div class="col-sm-4" style="margin-top:15px" >
	
<tr><td><strong>Name: </strong><span style="color:red;">*</span></td><th><input id="poi_name_txt" value="<?=$row['name']?>" style="width:80%;margin-top:-18px;margin-left:82px"><input id="poi_id" type="hidden" value="<?=$row['id']?>" ></th></tr>
<tr><td><strong>Type: </strong><span style="color:red;">*</span></td><th><select id="poi_type_dd" onchange="forcamera(this.value);" style="width:80%;margin-top:-18px;margin-left:82px">
<? $result = $conn->query("select `type` from substation_more group by `type`");
			 while($substation = $result->fetch_array())
			 {
			 ?>
			 <option value="<?=$substation["type"]?>" <? if($substation["type"]==$row['type']){ echo "selected";} ?> ><?=$substation["type"]?></option>
			<?  }  ?></select></th></tr>
			<? $add = explode(", ",$row['address']); ?>

<tr><td><strong>Address: </strong></td><th><input id="address_txt" value="<?=$add[0]?>" placeholder="Address" style="width:80%;margin-top:-18px;margin-left:82px"></th></tr>
<tr><td><strong>City: </strong></td><th><input id="city_txt" value="<?=$add[1]?>" placeholder="City" style="width:80%;margin-top:-18px;margin-left:82px"></th></tr>
<tr><td><strong>State: </strong></td><th><input id="state_txt" value="<?=$add[2]?>" placeholder="State" style="width:80%;margin-top:-18px;margin-left:82px"></th></tr>
<tr><td><strong>Zip </strong></td><th><input id="zip_txt" value="<?=$add[3]?>" placeholder="Zip" style="width:80%;margin-top:-18px;margin-left:82px"></th></tr>
<tr><td><strong>Latitude: </strong><span style="color:red;">*</span></td><th><input id="lati_txt" value="<?=$row['lati']?>" style="width:80%;margin-top:-18px;margin-left:82px"></th></tr>
<tr><td><strong>Longitude: </strong><span style="color:red;">*</span></td><th><input id="longi_txt" value="<?=$row['longi']?>" style="width:80%;margin-top:-18px;margin-left:82px"></th></tr>
<tr><td><strong>Geofence: </strong><span style="color:red;">*</span></td><th><select id="geofence"  style="width:80%;margin-top:-18px;margin-left:82px" >

			 <option value="0.25" <? if($row['geofence']=="0.25"){ echo "selected";} ?> >TINY (.25 mi) </option>
			 <option value="0.5" <? if($row['geofence']=="0.5"){ echo "selected";} ?> >SMALL (.5 mi) </option>
			 <option value="1.0" <? if($row['geofence']=="1.0"){ echo "selected";} ?> >NORMAL (1.0 mi) </option>
			 <option value="2.0" <? if($row['geofence']=="2.0"){ echo "selected";} ?> >LARGE (2.0 mi) </option>
		</select></th></tr>

<!--<tr><td><strong>Camera Id: </strong><span style="color:red;">*</span></td><th><input id="camid" class='camera_ele' <? if($row["type"]!='GPC Cameras'){ echo "disabled";} ?> value="<?=$row['camid']?>" style="width:100%" placeholder="Camera Id" ></th></tr>
<tr><td><strong>Camera Name: </strong><span style="color:red;">*</span></td><th><input id="cam_name" class='camera_ele' <? if($row["type"]!='GPC Cameras'){ echo "disabled";} ?> value="<?=$row['cam_name']?>" style="width:100%" placeholder="Camera Name" ></th></tr>-->
<tr><th colspan="2" style="text-align:center;">  

<br>
<br>

<input id="poi_save" type="button" value="Save" onclick="edit_poi();" > 

<input type="button" value="Close" onclick='$("#poi_table,#poi_dl").empty();$("#view_poi").show();$("#poi_type,#poi_name").val("");' ></th></tr>
</th></tr>
<tr><th colspan="2">&nbsp;</th></tr>
<tr><th colspan="2" style="text-align:center;"><input style="margin-bottom: 1%;" type="button" value="Edit Location On Map" onclick="get_latlong();"> </th></tr>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="col-sm-6">
<!--<tr><th colspan="2"><iframe id="poi_on_map_edit" src="" width="100%" height="150"></iframe></th></tr>-->
<tr><th colspan="2"><div id="poi_on_map" style=' width: 100%; height: 40vh;'></div></th></tr>

<tr><th colspan="2" style="text-align:center;">
<input id="poi_delete" style="margin-top:2%" type="button" value="Delete POI" onclick="del_poi();" > 

 </th></tr>

</div>
</div>
</div>

<script>
function get_map_poi(lati,longi)
 {  //alert($( "#"+lati ).val());
    if(($( "#"+lati ).val()=='') || ($( "#"+longi ).val()=='')){
		var myLatlng = new google.maps.LatLng(33.621669,-84.365368);
	}else{
		var myLatlng = new google.maps.LatLng($( "#"+lati ).val(),$( "#"+longi ).val());
	}
		var mapOptions = {
		  zoom: 15,
		  center: myLatlng
		}
		var map_manage_poi = new google.maps.Map(document.getElementById("poi_on_map"), mapOptions);

		// Place a draggable marker on the map
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map_manage_poi,
			draggable:true,
			title:"Drag me!"
		});

	marker.addListener('dragend', function(event) { 
		$("#"+lati ).val(this.position.lat());
		$("#"+longi ).val(this.position.lng()); 
		var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+$("#lati_txt").val()+","+$("#longi_txt").val()+"&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM";
		$.getJSON(geocodingAPI, function (json) { //alert(json.results[0].address_components);
			 json.results[0].address_components.forEach(myFunction);
		});
	});

			 
    }
    
function get_latlong() { 
	if ((($( "#lati_txt" ).val() != "") || ($( "#longi_txt" ).val() != "")) && ($('#address_txt').val().trim()=="") && ($('#city_txt').val().trim()=="") && ($('#state_txt').val().trim()=="")) {
		//alert('1');
		get_map_poi('lati_txt','longi_txt');
			var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+$("#lati_txt").val()+","+$("#longi_txt").val()+"&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM";
		$.getJSON(geocodingAPI, function (json) { //alert(json.results[0].address_components);
			 json.results[0].address_components.forEach(myFunction);
		});
		
		/*var url2="https://www.google.com/maps/embed/v1/place?q="+$( "#lati_txt" ).val()+","+$( "#longi_txt" ).val()+"&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM";
		$("#poi_on_map_edit").attr("src", url2);*/
	}
	else {
		//alert('2');
		if((($('#address_txt').val().trim()=="") || ($('#city_txt').val().trim()=="") /*|| ($('#state_txt').val().trim()=="")*/)){
			alert("Required fields must be filled out");
			return false;
		}else if((($( "#lati_txt" ).val() == "") || ($( "#longi_txt" ).val() == ""))){
		add = $( "#address_txt" ).val()+' '+$( "#city_txt" ).val()+' '+$( "#state_txt" ).val();
		var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+add+"&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM";
		$.getJSON(geocodingAPI, function (json) {
			//alert(json.results[0].formatted_address);
			 address = json.results[0].formatted_address;
			 //alert(address_components[0]);
			 latitude = json.results[0].geometry.location.lat;
			 longitude = json.results[0].geometry.location.lng;
			 $( "#lati_txt" ).val(latitude);
			 $( "#longi_txt" ).val(longitude);
			 get_map_poi('lati_txt','longi_txt');
		});
	}
	}
}    

    function edit_poi() {
	if (($( "#poi_name_txt" ).val().trim() == "") || ($( "#lati_txt" ).val().trim()  == "") || ($( "#longi_txt" ).val().trim()  == "")) {
		alert("Required fields must be filled out");
		return false;
	}
	else if($( "#poi_type_dd" ).val().trim()  == "GPC Cameras"){
//			if(($( "#camid" ).val().trim()  == "") || $( "#cam_name" ).val().trim()  == ""){
//				alert("Required fields must be filled out");
//				return false;
//			}
	}

	$.post( "get_poi_name.php",{ edit_poi:'true',poi_id: $("#poi_id").val(), poi_name_txt: $("#poi_name_txt").val(),poi_type_dd: $("#poi_type_dd").val(),address_txt: $("#address_txt").val(),city_txt: $("#city_txt").val(),state_txt: $("#state_txt").val(),zip_txt: $("#zip_txt").val(),lati_txt: $("#lati_txt").val(),longi_txt: $("#longi_txt").val(),geofence: $("#geofence").val(),camid: $("#camid").val(),cam_name: $("#cam_name").val() },function(data) { //alert(data);
		$("#poi_table").empty();
		$("#poi_table").html(data);
			$.post( "get_poi_name.php",{ poi_type: $("#poi_type :selected").val() },function(data) {
				$("#poi_dl").empty();
				$("#poi_name").val("");
				$("#poi_dl").html(data);
			});
		});
	$("#poi_id").val('');

}

 </script>

<? } 
else if( $_REQUEST["new_poi"]=='new' )//new button clicked
{ ?>
	<div class="container" style="max-width:100%;height:97%;overflow:hidden;z-index:3">    
         
  <div class="row">
	<div class="col-sm-4" style="margin-top:15px">
<tr><td><strong>Name: </strong><span style="color:red;">*</span></td><th><input id="poi_name_txt" placeholder="Name" value="" style="width:80%;margin-top:-18px;"><input id="poi_id" type="hidden" ></th></tr>
<tr><td><strong>Type: </strong><span style="color:red;">*</span></td><th><select id="poi_type_dd" style="width:80%;margin-top:-18px;" >
			<option value="" ></option>
<? $result = $conn->query("select `type` from substation_more group by `type`");
			 while($substation = $result->fetch_array())
			 {
			 ?>
			 <option value="<?=$substation["type"]?>" ><?=$substation["type"]?></option>
			<?  }  ?></select></th></tr>
<tr><td><strong>Address: </strong></td><th><input id="address_txt" placeholder="Address" value="" style="width:80%;margin-top:-18px;"></th></tr>
<tr><td><strong>City: </strong></td><th><input id="city_txt" placeholder="City" value="" style="width:80%;margin-top:-18px;"></th></tr>
<tr><td><strong>State: </strong></td><th><input id="state_txt" placeholder="State" value="" style="width:80%;margin-top:-18px;"></th></tr>
<tr><td><strong>Zip: </strong></td><th><input id="zip_txt" placeholder="Zip" value="" style="width:80%;margin-top:-18px;margin-left:82px"></th></tr>
<tr><td><strong>Latitude: </strong><span style="color:red;">*</span></td><th><input id="lati_txt" placeholder="Latitude" value="" style="width:80%;margin-top:-18px;"></th></tr>
<tr><td><strong>Longitude: </strong><span style="color:red;">*</span></td><th><input id="longi_txt" value="" placeholder="Longitude" style="width:80%;margin-top:-18px;"></th></tr>
<tr><td><strong>Geofence: </strong><span style="color:red;">*</span></td><th><select id="geofence" style="width:80%;margin-top:-18px;" >
			<option value="" ></option>
			 <option value="0.25" >TINY (.25 mi) </option>
			 <option value="0.5" >SMALL (.5 mi) </option>
			 <option value="1.0" >NORMAL (1.0 mi) </option>
			 <option value="2.0" >LARGE (2.0 mi) </option>
		</select></th></tr>
<!--<tr><td><strong>Camera Id: </strong><span style="color:red;">*</span></td><th><input id="camid" class="camera_ele" placeholder="Camera Id" style="width:100%"></th></tr>
<tr><td><strong>Camera Name: </strong><span style="color:red;">*</span></td><th><input id="cam_name" class="camera_ele" placeholder="Camera Name" style="width:100%"></th></tr>-->

<tr><th colspan="2">&nbsp;</th></tr>
<br>
<tr><th colspan="2" style="text-align: center;"><input class="poi_add_new" type="button" value="Add" onclick="add_poi();"> <input class="" type="button" value="View on Map" onclick="get_latlong();"> <input type="reset" value="Clear" onclick="poi_clear();" > <input type="button" value="Close" onclick='$("#poi_table").empty();$("#menu").show();$("#view_poi").hide();' ></th></tr>
<tr><th colspan="2">&nbsp;</th></tr>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="col-sm-6" >
<!--<tr><th colspan="2"><iframe id="poi_on_map_add" src="" width="100%" height="150"></iframe></th></tr>-->
<tr><th colspan="2"><div id="poi_on_map" style='height: 40vh;'></div></th></tr>
</div>
</div>
</div><br>
<script>
function add_poi() {
    
    if (($( "#poi_name_txt" ).val().trim()  == "") || ($( "#lati_txt" ).val().trim()  == "") || ($( "#longi_txt" ).val().trim()  == "") || ($( "#poi_type_dd" ).val().trim()  == "") || ($( "#geofence" ).val().trim()  == "")) {
    alert("Required fields must be filled out");
    return false;
    }
    else if($( "#poi_type_dd" ).val().trim()  == "GPC Cameras"){
//                            if(($( "#camid" ).val().trim()  == "") || $( "#cam_name" ).val().trim()  == ""){
//                                    alert("Required fields must be filled out");
//                                    return false;
//                            }
            }
            $.post( "get_poi_name.php",{ add_poi:'true',poi_name_txt: $("#poi_name_txt").val(),poi_type_dd: $("#poi_type_dd").val(),address_txt: $("#address_txt").val(),city_txt: $("#city_txt").val(),state_txt: $("#state_txt").val(),zip_txt: $("#zip_txt").val(),lati_txt: $("#lati_txt").val(),longi_txt: $("#longi_txt").val(),geofence: $("#geofence").val(),camid: $("#camid").val(),cam_name: $("#cam_name").val() },function(data) {
                    $("#poi_table").empty();
                    $("#poi_table").html(data);
                            $.post( "get_poi_name.php",{ poi_type: $("#poi_type :selected").val() },function(data) {
                                    $("#poi_dl").empty();
                                    $("#poi_name").val("");
                                    $("#poi_dl").html(data);
                            });
                    });
 }
 

function del_poi() {
	yesorno = confirm("Are you want to delete this POI.");
		if(yesorno){
	$.post( "get_poi_name.php",{ del_poi:'true',poi_id: $("#poi_id").val(),poi_name_txt: $("#poi_name_txt").val(),poi_type_dd: $("#poi_type_dd").val() },function(data) {
		$("#poi_table").empty();
		$("#poi_table").html(data);
			$.post( "get_poi_name.php",{ poi_type: $("#poi_type :selected").val() },function(data) {
				$("#poi_dl").empty();
				$("#poi_name").val("");
				$("#poi_dl").html(data);
			});
		});
	}
}

 </script>
<? } 
else if( $_REQUEST["del_poi"]!='' & $_REQUEST["poi_id"]!='' )//delete clicked
{ 
$result1 =$conn->query("delete from substation_more where id ='".$_REQUEST["poi_id"]."' and `type` ='".$_REQUEST["poi_type_dd"]."'");
	echo "<center><h4>".$_REQUEST["poi_name_txt"]." Successfully Deleted.</h4><input type='button' value='Close' onclick='back_menu();' ><center>";
}
else if( $_REQUEST["add_poi"]=='true' & $_REQUEST["poi_name_txt"]!='' & $_REQUEST["poi_type_dd"]!='' )//add poi form submit
{ 

$result1 = $conn->query("insert into substation_more set name ='".mysql_real_escape_string($_REQUEST["poi_name_txt"])."',`type` ='".$_REQUEST["poi_type_dd"]."',address ='".mysql_real_escape_string($_REQUEST["address_txt"]).", ".mysql_real_escape_string($_REQUEST["city_txt"]).", ".mysql_real_escape_string($_REQUEST["state_txt"]).", ".mysql_real_escape_string($_REQUEST["zip_txt"])."',lati ='".$_REQUEST["lati_txt"]."',longi ='".$_REQUEST["longi_txt"]."',geofence ='".$_REQUEST["geofence"]."',camid ='".$_REQUEST["camid"]."',cam_name ='".$_REQUEST["cam_name"]."'");
	echo "<center><h4>".$_REQUEST["poi_name_txt"]." Successfully added.</h4><input type='button' value='Close' onclick='back_menu();' ><center>";
 } 
else if( $_REQUEST["edit_poi"]=='true' & $_REQUEST["poi_name_txt"]!='' & $_REQUEST["poi_type_dd"]!='' )//add poi form submit
{ 
	$camid=(($_REQUEST["camid"]=="") ? NULL : $_REQUEST["camid"] );
	$cam_name=(($_REQUEST["cam_name"]=="") ? NULL : $_REQUEST["cam_name"] );
	
$result1 = $conn->query("update substation_more set `type` ='".$_REQUEST["poi_type_dd"]."',name = '".mysql_real_escape_string($_REQUEST["poi_name_txt"])."', address ='".mysql_real_escape_string($_REQUEST["address_txt"]).", ".mysql_real_escape_string($_REQUEST["city_txt"]).", ".mysql_real_escape_string($_REQUEST["state_txt"]).", ".mysql_real_escape_string($_REQUEST["zip_txt"])."',lati ='".$_REQUEST["lati_txt"]."',longi ='".$_REQUEST["longi_txt"]."',geofence ='".$_REQUEST["geofence"]."',camid ='".$camid."',cam_name ='".$cam_name."' where id = '".$_REQUEST["poi_id"]."'");
	echo "<center><h4>".$_REQUEST["poi_name_txt"]." Successfully Updated.</h4><input type='button' value='Close' onclick='back_menu();' ><center>";
 } ?>
 <script>
      function back_menu() { //alert();
	$("#poi_table").empty();
	$("#menu").show();
	$("#view_poi").hide();
}
 </script>