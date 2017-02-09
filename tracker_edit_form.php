  <? 
  session_start(); 
  include_once('connect.php'); 
  if ($result = $conn->query("select * from tbl_device_det where DeviceIMEI = '".$_REQUEST['imei']."'")) { 
        $obj = $result->fetch_object();
  }
  ?><center>
  <div style='font-size: 1.2rem;width: 50%;'>

 <form id='new_tracker_form' name="new_tracker_form">
            <h1 style="font-size:2.2rem;"><b>Update Tracker</b></h1>
			 <div id='track_add_spinner' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Please wait...</div>
          <table>
            <tr>
            <td><strong class="stg">Area:</strong></td>
            <td><select id="area" name="area" class="sel " style="background-color:#D3D3D3;">
				  <?  
                  $sql = $conn->query("select * from tbl_area order by name asc");
                  while($obj_role = $sql->fetch_object()){
              ?>
                  <option <?=($obj->opco==$obj_role->name)?'selected':''?> ><?=$obj_role->name?></option>
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
                  while($obj_role = $sql->fetch_object()){
              ?>
                  <option <?=($obj->primary==$obj_role->name)?'selected':''?> ><?=$obj_role->name?></option>
              <?   } 
              ?>
              </select>
            </td>
        </tr>
        <tr>
            <td><strong class="stg">Tracker Name:</strong></td>
            <td>
              <input id="trackername" name="trackername" type="text" value='<?=($obj->DeviceName)?>' class="intp" style="background-color:#D3D3D3;" placeholder="Tracker Name">
            </td>
        </tr>
        <tr>
              <td><strong class="stg">Driver Name:</strong></td>
              <td><input id="drivername" name="drivername" type="text" value='<?=($obj->driver_name)?>' class="intp" placeholder="Driver Name">
              </td>
        </tr>
        <tr>
              <td><strong class="stg">Driver Phone:</strong></td>
              <td><input id="driverphone" name="driverphone" type="number" value='<?=($obj->driver_phone)?>' class="intp" placeholder="Driver Phone">
              </td>
        </tr>
        <tr> 
              <td ><strong class="stg">Tracker IMEI:</strong></td>
              <td><input id="trackerimei" name="trackerimei"  type="text" value='<?=($obj->DeviceIMEI)?>' class="intp" style="background-color:#D3D3D3;" placeholder="Tracker IMEI" readonly >
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
				   <option <?=($vehicle->OBDType==$obj->OBDType)?'selected':''?> ><?=$vehicle->OBDType?></option>
				  <?  } 
				  ?>
                </select>
            </td>
        </tr>
          <tr>
            <td><strong class="stg">Tracker Phone:</strong></td>
            <td><input id="trackerphone" name="trackerphone" type="number" value='<?=($obj->DevicePhone)?>' class="intp" style="background-color:#D3D3D3;" placeholder="Tracker Phone">
            </td>
        </tr>
        <tr>
             <td><strong class="stg">Tag #:</strong></td>
             <td><input id="tag" name="tag" type="text" value='<?=($obj->tag)?>' class="intp" placeholder="Tag #">
              </td>
        </tr>
        <tr>
              <td><strong class="stg">Odometer:</strong></td>
              <td><input id="odometer" name="odometer" type="text" value='<?=($obj->odometer)?>' class="intp" placeholder="Odometer">
              </td>
        </tr> 
        <tr>
              <td><strong class="stg">Is forwarded to gpc:</strong></td>
              <td>
                <select id="isforwardedtogpc" name="isforwardedtogpc" class="sel" style="background-color:#D3D3D3;">
                   <option  value='0' <? if($obj->isforwardedtogpc=='0'){ ?> selected <? } ?>>Disable</option>
                   <option  value='1' <? if($obj->isforwardedtogpc=='1'){ ?> selected <? } ?>>Enable</option>
                </select>
              </td>
        </tr> 
		<br>
        
        <input type='hidden' name='qry_type' value='edit'>
         </table><br>
         <input onclick='validateForm();' type='button'  value="Save Tracker" class="btn btn-danger" style="margin-bottom:1vh;height:5vh;"> 
        <a onclick='$("#radio_butt").show();$("#list_area").show();$("#add_area").hide();'><input type="button" class="btn btn-danger" value="Close" style="margin-bottom:1vh;height:5vh;"></a><br>
 
       </form>
    </div></center>