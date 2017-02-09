<?
	

			$geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_POST['lati']).','.trim($_POST['longi']).'js?key=AIzaSyDaL0ieAkLhzy1rDoLifajeowdXPwTvzmI&sensor=false'); 
			$output = json_decode($geocodeFromLatLong);
			//print_r($output);
			//$status = $output->status;
			//Get address from json data
			$address = $output->results[0]->formatted_address;
			
			$dataval = $output->results[0]->address_components;
	
			  foreach($dataval as $elements)
			  {
			   if($elements->types[0] == 'street_number')
			   {
				$Addressval = $elements->long_name;
			   }
			   if($elements->types[0] == 'route')
			   {
				$Addressval = $Addressval." ".$elements->long_name;
			   }
			   if($elements->types[0] == 'locality')
			   {
				$Cityval = $elements->long_name;
			   }
			   if($elements->types[0] == 'administrative_area_level_1')
			   {
				$stateval = $elements->long_name;
			   }
			   if($elements->types[0] == 'postal_code')
			   {
				$postalval = $elements->long_name;
			   }
			  }
			$address = $Addressval . ",".$Cityval.",".$stateval.",".$postalval;
			//$add=explode(',',$address);
			echo $address;
	
?>