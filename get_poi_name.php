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

  <tr>
    <td style='padding-right: 3vw;'>
    <table>
   <tr>
    <td style='padding: 5px;'><strong>Name: </strong><span style="color:red;">*</span></td>
    <th><input id="poi_name_txt" value="<?=$row['name']?>" style="width:100%">
    	<input id="poi_id" type="hidden" value="<?=$row['id']?>" ></th>
    </tr>
    <tr>
	    <td style='padding: 5px;'><strong>Type: </strong><span style="color:red;">*</span>
	    </td>
	    <th><select id="poi_type_dd" onchange="forcamera(this.value);" style="width:100%">
         <? $result = $conn->query("select `type` from substation_more group by `type`");
             while($substation = $result->fetch_array())
             {
             ?>
             <option value="<?=$substation["type"]?>" <? if($substation["type"]==$row['type']){ echo "selected";} ?> ><?=$substation["type"]?></option>
            <?  }  ?></select>
        </th>
    </tr>
            <? $add = explode(", ",$row['address']); ?>

<tr><td style='padding: 5px;'><strong>Address: </strong></td><th><input id="address_txt" value="<?=$add[0]?>" placeholder="Address" style="width:100%"></th></tr>
<tr><td style='padding: 5px;'><strong>City: </strong></td><th><input id="city_txt" value="<?=$add[1]?>" placeholder="City" style="width:100%"></th></tr>
<tr><td style='padding: 5px;'><strong>State: </strong></td><th><input id="state_txt" value="<?=$add[2]?>" placeholder="State" style="width:100%"></th></tr>
<tr><td style='padding: 5px;'><strong>Zip </strong></td><th><input id="zip_txt" value="<?=$add[3]?>" placeholder="Zip" style="width:100%"></th></tr>
<tr><td style='padding: 5px;'><strong>Latitude: </strong><span style="color:red;">*</span></td><th><input id="lati_txt" value="<?=$row['lati']?>" style="width:100%"></th></tr>
<tr><td style='padding: 5px;'><strong>Longitude: </strong><span style="color:red;">*</span></td><th><input id="longi_txt" value="<?=$row['longi']?>" style="width:100%"></th></tr>
<tr><td style='padding: 5px;'><strong>Geofence: </strong><span style="color:red;">*</span></td><th><select id="geofence"  style="width:100%" >

             <option value="0.25" <? if($row['geofence']=="0.25"){ echo "selected";} ?> >TINY (.25 mi) </option>
             <option value="0.5" <? if($row['geofence']=="0.5"){ echo "selected";} ?> >SMALL (.5 mi) </option>
             <option value="1.0" <? if($row['geofence']=="1.0"){ echo "selected";} ?> >NORMAL (1.0 mi) </option>
             <option value="2.0" <? if($row['geofence']=="2.0"){ echo "selected";} ?> >LARGE (2.0 mi) </option>
        </select></th></tr>

    </table>
    
    </td>
    <td>
		<table style="border: 1px solid black;">
			<tr>
				<td>
					<div id="poi_on_map" style='width:40vw;height: 40vh;'>
				</td>
			</tr>
		</table>
    </td>
  </tr>
  <tr>
    <th colspan="2" style="text-align: center;padding-top: 2vh;">
        <input id="poi_save" type="button" class="btn btn-danger" value="Save" onclick="edit_poi();" > 
		<input type="button" value="Close" class="btn btn-danger" onclick='$("#poi_table,#poi_dl").empty();$("#view_poi").show();$("#poi_type,#poi_name").val("");' >
		<input style="" type="button" class="btn btn-danger" value="Edit Location On Map" onclick="get_latlong();">
		<input id="poi_delete" class="btn btn-danger"  type="button" value="Delete POI" onclick="del_poi();" > 
    </th>
</tr>


<? } 
else if( $_REQUEST["new_poi"]=='new' )//new button clicked
{ ?>

<tr>
    <td style='padding-right: 3vw;'>
    <table>
   <tr><td style='padding: 5px;'><strong>Name: </strong><span style="color:red;">*</span></td><th><input id="poi_name_txt" placeholder="Name" value="" style="width:100%"><input id="poi_id" type="hidden" ></th></tr>
<tr><td style='padding: 5px;'><strong>Type: </strong><span style="color:red;">*</span></td><th><select id="poi_type_dd" style="width:100%" >
            <option value="" ></option>
<? $result = $conn->query("select `type` from substation_more group by `type`");
             while($substation = $result->fetch_array())
             {
             ?>
             <option value="<?=$substation["type"]?>" ><?=$substation["type"]?></option>
            <?  }  ?></select></th></tr>
<tr><td style='padding: 5px;'><strong>Address: </strong></td><th><input id="address_txt" placeholder="Address" value="" style="width:100%"></th></tr>
<tr><td style='padding: 5px;'><strong>City: </strong></td><th><input id="city_txt" placeholder="City" value="" style="width:100%"></th></tr>
<tr><td style='padding: 5px;'><strong>State: </strong></td><th><input id="state_txt" placeholder="State" value="GA" style="width:100%"></th></tr>
<tr><td style='padding: 5px;'><strong>Zip: </strong></td><th><input id="zip_txt" placeholder="Zip"  readonly value="" style="width:100%"></th></tr>
<tr><td style='padding: 5px;'><strong>Latitude: </strong><span style="color:red;">*</span></td><th><input type="text" id="lati_txt" placeholder="Click View on Map to add" value=""  readonly style="width:100% ;color:black"></th></tr>
<tr><td style='padding: 5px;'><strong>Longitude: </strong><span style="color:red;">*</span></td><th><input type="text"id="longi_txt" value="" placeholder="Click View on Map to add" style="width:100%"></th></tr>
<tr><td style='padding: 5px;'><strong>Geofence: </strong><span style="color:red;">*</span></td><th><select id="geofence" style="width:100%" >
			<option value="" ></option>
			 <option value="0.25" >TINY (.25 mi) </option>
			 <option value="0.5" >SMALL (.5 mi) </option>
			 <option value="1.0" selected>NORMAL (1.0 mi) </option>
			 <option value="2.0" >LARGE (2.0 mi) </option>
		</select></th></tr>
    </table>
    
    </td>
    
    <td>
    <table style="border: 1px solid black;">
    <tr>
    <td>
    <div id="poi_on_map" style='width:40vw;height: 40vh;'></div>
    </td>
    </tr>
    </table>
    </td>
  </tr>
   <tr>
  <td colspan="1"></td>
  <td style="padding:1vh;">
    <span style="color:red;" id="map_hint">* You can drag the map's pin for Address,Latitude and Longitude </span>
  </td>
  </tr>
  <tr>
    <td colspan="1"></td>
  <td style="text-align:center;">
        <input class="poi_add_new btn btn-danger" type="button" value="Add" onclick="add_poi();"> 
        <input type="button" class="btn btn-danger" value="View on Map" onclick="get_latlong();"> 
        <input type="reset" value="Clear" class="btn btn-danger" onclick="poi_clear();"> 
        <input type="button" value="Close" class="btn btn-danger" onclick="$(&quot;#poi_table&quot;).empty();$(&quot;#menu&quot;).show();$(&quot;#view_poi&quot;).hide();">
    </td>
</tr>
 
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