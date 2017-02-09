<?session_start();
include 'connect.php';
$data="select lastdata.deviceid,IF((TIME_TO_SEC(TIMEDIFF(now(),maxdata.timestamp))/7200)>1,'Inactive',description) as description,DeviceType,lastdata.`timestamp`,lastdata.eventcode , IF((TIME_TO_SEC(TIMEDIFF(now(),maxdata.timestamp))/7200)>1,2,0) as timediff,heading,lati,longi,maxdata.DeviceImei from (select MAX(tbl_event_data_last_view.timestamp) as timestamp , tbl_event_data_last_view.deviceid , tbl_event_data_last_view.DeviceImei from tbl_event_data_last_view,tbl_event_desc where tbl_event_data_last_view.eventcode = tbl_event_desc.eventcode group by tbl_event_data_last_view.deviceid) as maxdata, tbl_event_data_last_view as lastdata ,tbl_event_desc where lastdata.timestamp = maxdata.timestamp and lastdata.eventcode = tbl_event_desc.eventcode and maxdata.deviceid = lastdata.deviceid group by lastdata.deviceid order by lastdata.deviceid";

$data = $conn->query($data);
$rows = array();
    while($r = $data->fetch_object())
    { 
	  $details = $conn->query("select tbl_eqptype.eqp_url from  tbl_eqptype left join tbl_device_det on tbl_device_det.DeviceType=tbl_eqptype.eq_name where DeviceIMEI = '".$r->DeviceImei."'")->fetch_object();
      $rows[] = array_merge((array)$r,(array)$details);

    }
     $string = "";
    foreach ($rows as $value) {
       $string.="[\"". ( implode("\",\"",array_values($value)))."\"]" . ","; 
    }
  //$finalString = "[".rtrim($string, ",")."]";
    if(@$_REQUEST['fromajax'])
  {
      echo $finalString = "[".rtrim($string, ",")."]";
  }
  else
  {
      $finalString = "[".rtrim($string, ",")."]";
  }
    //echo json_encode($rows);
  ?>