  <?  
  session_start(); 
  include_once('connect.php');?><center>
  <div style='font-size: 1.2rem;width: 50%;'>
 <form id='new_tracker_form' name="new_tracker_form">
             <!--<h1 style="font-size:2.2rem;"><b>Add Tracker</b></h1>-->
			 <div id='track_add_spinner' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Please wait...</div>
          <table>
            <tr>
            <td><strong class="stg">Area:</strong></td>
            <td><select id="area" name="area" class="sel " style="background-color:#D3D3D3;">
              <?  
                  $sql = $conn->query("select * from tbl_area order by name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option  ><?=$obj->name?></option>
              <?   } 
              ?>
            </select>
            </td>
        </tr>
        <tr>
            <td><strong class="stg">Supervisor:</strong></td>
            <td><select id="supervisor" name="supervisor" class="sel" style="background-color:#D3D3D3;">
              <?  
                  $sql = $conn->query("select * from tbl_supervisor order by name asc");
                  while($obj = $sql->fetch_object()){
              ?>
                  <option  ><?=$obj->name?></option>
              <?   } 
              ?>
            </select>
            </td>
        </tr>
        
        <tr>
            <td><strong class="stg">Tracker Name:</strong></td>
            <td><input type='hidden' name='qry_type' value='new'>
              <input id="trackername" name="trackername" type="text" class="intpclass " style="background-color:#D3D3D3;" placeholder="Tracker Name">
            </td>
        </tr>
        <tr>
              <td><strong class="stg">Driver Name:</strong></td>
              <td><input id="drivername" name="drivername" type="text" class="intpclass" placeholder="Driver Name">
              </td>
        </tr>
        <tr>
              <td><strong class="stg">Driver Phone:</strong></td>
              <td><input id="driverphone" name="driverphone" type="number" class="intpclass" placeholder="Driver Phone">
              </td>
        </tr>
        <tr> 
              <td ><strong class="stg">Tracker IMEI:</strong></td>
              <td><input id="trackerimei" name="trackerimei"  type="text" class="intpclass" style="background-color:#D3D3D3;" placeholder="Tracker IMEI">
              </td>
        </tr>
         <tr>      
            <td><strong class="stg">Tracker Type:</strong></td>
            <td>
                <select id="trackertype" name="trackertype" class="sel" style="background-color:#D3D3D3;">
				 <?
				   $result = $conn->query("SELECT OBDType FROM `tbl_device_det` group by OBDType");
				   while($vehicle  = $result->fetch_object())
				   {
				  ?>
				   <option <? if($vehicle->OBDType=='OBDII'){ echo 'selected'; } ?> > <?=$vehicle->OBDType?></option>
				  <?  } 
				  ?>
                </select>
            </td>
        </tr>
          <tr>
            <td><strong class="stg">Tracker Phone:</strong></td>
            <td><input id="trackerphone" name="trackerphone" type="number" class="intpclass" style="background-color:#D3D3D3;" placeholder="Tracker Phone">
            </td>
        </tr>
        <tr>
             <td><strong class="stg">Tag #:</strong></td>
             <td><input id="tag" name="tag" type="text" class="intpclass" placeholder="Tag #">
              </td>
        </tr>
        <tr>
              <td><strong class="stg">Odometer:</strong></td>
              <td><input id="odometer" name="odometer" type="text" class="intpclass" placeholder="Odometer">
              </td>
        </tr> 
        <tr>
              <td><strong class="stg">Is forwarded to gpc:</strong></td>
              <td>
                <select id="isforwardedtogpc" name="isforwardedtogpc" class="sel" style="background-color:#D3D3D3;">
                   <option  value='0'>Disable</option>
                   <option  value='1'>Enable</option>
                </select>
              </td>
        </tr> 
		<br>
        
        <input type='hidden' id='qry_type' name='qry_type' value='add'>
         </table><br>
       
         <input onclick='validateForm();' type='button'  value="Add Tracker" class="btn btn-danger" style="margin-bottom:1vh;height:5vh;"> 
        <!--<a onclick='$("#trip_sheet_div").hide();$("#trip_sheet_div").html("");' ><input type="button" class="btn btn-danger" value="Close" style="margin-bottom:1vh;height:5vh;"></a><br>-->
    
       </form>
    </div></center>