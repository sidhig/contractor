<?php
		  session_start();
		  error_reporting(0);
	 include_once('connect.php'); 
	 //print_r($_POST);die();
if(isset($_POST['qry_type']) && $_POST['qry_type'] == "edit"){ 
		if($_POST['trackerimei'] != "" && $_POST['trackername'] != "" && $_POST['trackerphone'] != "" ) {
		
			$dev_update = "update `tbl_device_det` SET 
				area = '".$_POST['area']."',
				supervisor = '".$_POST['supervisor']."',
				DeviceName = '".$_POST['trackername']."',
				driver_name = '".str_replace('"',' ',$_POST['drivername'])."',
				driver_phone = '".$_POST['driverphone']."',
				DeviceIMEI = '".$_POST['trackerimei']."',
				OBDType = '".$_POST['trackertype']."',
				DeviceType = '".$_POST['equipment']."',
				DevicePhone = '".$_POST['trackerphone']."',
				odometer = '".$_POST['odometer']."',
				tag = '".$_POST['tag']."',
				odometerCurrent = '".$_POST['odometer']."',  
				isforwardedtogpc = '".$_POST['isforwardedtogpc']."'
			where DeviceIMEI = '".$_POST['trackerimei']."'";
			$result =  $conn->query($dev_update) or die(mysqli_error());
			if($result){
						 $qry = "update tbl_event_data_last set deviceid = '".$_POST['trackername']."' where DeviceImei = '".$_POST['trackerimei']."'"; 
						
						//$result = mysql_query($qry) or die(mysql_error());
					echo $err = "Device Successfully updated.";
					 unset($_POST);
					}		
					}else {
					echo $err = "Please fill all required fields.";
					}
}
else if(isset($_POST['qry_type']) && $_POST['qry_type'] == "add"){
			if($_POST['trackerimei'] != "" && $_POST['trackername'] != "" && $_POST['trackerphone'] != "" ) {
				$result = $conn->query("select * from `tbl_device_det` where DeviceIMEI = '".$_POST['trackerimei']."'");
				$alraedy = $result->num_rows;
		if($alraedy >0){
			$alraedy = $result->fetch_object();
			echo $err = 'Device already exist with this IMEI. ';
			echo $err = 'Equipment Type: '.$alraedy->DeviceType.' Equipment #:'.$alraedy->DeviceName; 
			return false;
		}
		$dev_insert = "INSERT INTO 
				`tbl_device_det` SET 
				area = '".$_POST['area']."',
				supervisor = '".$_POST['supervisor']."',
				DeviceName = '".$_POST['trackername']."',
				driver_name = '".str_replace('"',' ',$_POST['drivername'])."',
				driver_phone = '".$_POST['driverphone']."',
				DeviceIMEI = '".$_POST['trackerimei']."',
				OBDType = '".$_POST['trackertype']."',
				DeviceType = '".$_POST['equipment']."',
				DevicePhone = '".$_POST['trackerphone']."',
				odometer = '".$_POST['odometer']."',
				tag = '".$_POST['tag']."',
				odometerCurrent = '".$_POST['odometer']."',  
				isforwardedtogpc = '".$_POST['isforwardedtogpc']."',
				username = 'gpc'";
				//echo $dev_insert;
				$result = $conn->query($dev_insert) or die(mysqli_error());
					if($result){
						$q = $conn_admin->query("insert into tbl_deviceinfo set deviceIMEI = '".$_POST['trackerimei']."' , companyid = '".$_SESSION['account_id']."'");
						if($q){
							echo $err = "Tracker Successfully Added.";
							unset($_POST);
						}
					}
				}		
			//}
			else {
			echo $err = "Please fill all required fields.";
			}
			$mbval="admin";
	}
else if(isset($_POST['del_qry']) && $_POST['del_qry'] != ""){

			//$conn->begin_transaction();
			$result =  $conn->query($_POST['del_qry']) or die(mysqli_error());
			if($result){
					$res =  $conn_admin->query($_POST['del_admin']);
					if($res){
						echo $err = "Tracker Successfully deleted. Tracker List Refreshing...";
						unset($_POST);
						//$conn->commit();
					}else{
						//$conn->rollback();
					}
			}
}

?>