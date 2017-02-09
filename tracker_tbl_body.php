  <?  
  session_start(); 
  include_once('connect.php');
  ?>
  
<? //$sql = "select *, if(Lostlocall.eventcode IS NULL ,'Inactive',Lostlocall.eventcode ) as `eventcode1`  from devicedetails left join (select  Event_data_last_view.DeviceIMEI,Event_data_last_view.eventcode,IF((TIME_TO_SEC(TIMEDIFF(now(),maxdata.timestamp))/7200)>1,2,0) as timediff, (Event_data_last_view.`timestamp` -interval 0 hour) as 'timestamp' from (select MAX(Event_data_last_view.timestamp) as timestamp , Event_data_last_view.deviceid from Event_data_last_view,event_desc where Event_data_last_view.eventcode = event_desc.eventcode  and Event_data_last_view.DeviceImei  in (Select DeviceIMEI from devicedetails where UserName = 'GPC' group by DeviceIMEI) group by Event_data_last_view.deviceid) as maxdata, Event_data_last_view,event_desc where Event_data_last_view.timestamp = maxdata.timestamp and Event_data_last_view.eventcode = event_desc.eventcode and maxdata.deviceid = Event_data_last_view.deviceid group by Event_data_last_view.deviceid order by Event_data_last_view.deviceid) as Lostlocall   on devicedetails.DeviceIMEI = Lostlocall.DeviceIMEI where devicedetails.UserName = 'GPC' and devicedetails.DeviceIMEI != '270113183009586452' and CASE WHEN (select dept  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select dept from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', department, '%')  END and  CASE WHEN (select `group`  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select `group` from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', `group`, '%')  END  and CASE WHEN (select `eqp`  as eqpval  from roletable where username = '".$_SESSION['LOGIN_user']."') = 'All' THEN 1 ELSE (select `eqp` from roletable where username = '".$_SESSION['LOGIN_user']."') like CONCAT('%', `DeviceType`, '%')  END order by timestamp desc";
 $sql = "select *, if(Lostlocall.eventcode IS NULL ,'Inactive',Lostlocall.eventcode ) as `eventcode1`  from tbl_device_det left join (select  tbl_event_data_last_view.DeviceIMEI,lati,longi,tbl_event_data_last_view.eventcode,IF((TIME_TO_SEC(TIMEDIFF(now(),maxdata.timestamp))/7200)>1,2,0) as timediff, (tbl_event_data_last_view.`timestamp` -interval 0 hour) as 'timestamp' from (select MAX(tbl_event_data_last_view.timestamp) as timestamp , tbl_event_data_last_view.deviceid from tbl_event_data_last_view,tbl_event_desc where tbl_event_data_last_view.eventcode = tbl_event_desc.eventcode  and tbl_event_data_last_view.DeviceImei  in (Select DeviceIMEI from tbl_device_det where UserName = 'gpc' group by DeviceIMEI) group by tbl_event_data_last_view.deviceid) as maxdata, tbl_event_data_last_view,tbl_event_desc where tbl_event_data_last_view.timestamp = maxdata.timestamp and tbl_event_data_last_view.eventcode = tbl_event_desc.eventcode and maxdata.deviceid = tbl_event_data_last_view.deviceid group by tbl_event_data_last_view.deviceid order by tbl_event_data_last_view.deviceid) as Lostlocall   on tbl_device_det.DeviceIMEI = Lostlocall.DeviceIMEI order by timestamp desc";
//print_r($sql);
 if ($result = $conn->query($sql)) { 

        while($obj = $result->fetch_object()){ 
/*if($obj->longi!=null){
	$forPOI = $conn->query("SELECT (name) AS 'POI',(((acos(sin((".$obj->lati."*pi()/180)) * sin((lati*pi()/180))+cos((".$obj->lati."*pi()/180)) * cos((lati*pi()/180)) * cos(((".$obj->longi."- longi)*pi()/180))))*180/pi())*60*1.1515) as distance FROM `substation_more`  order by distance limit 1");
		$row0 = $forPOI->fetch_object();
}else{
	$row0->POI = '';
}*/
?>

<tr style="display: table-row;">
    <td ><?=($obj->DeviceName)?></td>
    <td><?=($obj->driver_name)?></td>
    <td><?=($obj->driver_phone)?></td>
    <td><?=($obj->DeviceIMEI)?></td>
    <!-- <td><?=($obj->DeviceType)?></td> -->
    <td><?=($obj->OBDType)?></td>
    <td><?=($obj->area)?></td>
    <td><?=($obj->supervisor)?></td>
    <td><?if($obj->isforwardedtogpc=='0'){ echo 'Disable'; } else if($obj->isforwardedtogpc=='1'){ echo 'Enable'; }?></td>
   <!--  <td><? if($obj->timestamp!=''){ ?><?=date('m-d-y h:i A',strtotime($obj->timestamp))?><? } ?></td> -->
	
    <td>
		<image onclick="edit_tracker('<?=($obj->DeviceIMEI)?>')" style='cursor: pointer;'src="image/edit1.png" >
        <image src="image/remove1.png" style='cursor: pointer;' onclick=del_tracker('<?=($obj->DeviceIMEI)?>') >
       <!--  <?if($obj->OBDType=='OBDII'){?>
        	<input type="button" value="CONFIG" id='config_tracker' onclick="config_tracker('<?=($obj->DeviceIMEI)?>')" style="margin-top:1vh;">
        <?}?> -->
    </td>
	
   <!--  <td style='display:none;'><?=($obj->OBDType)?></td>
    <td style='display:none;'><?=($obj->opco)?></td>
    <td style='display:none;'><?=($obj->primary)?></td> -->
		</tr>    
		<?
			}
		}
		?>