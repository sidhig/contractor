<? session_start();
include_once("connect.php"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>

$('#view_edit_poi').click(function(){ 
	 $('#poi_name,#poi_type').css('border', '');
	 $("#poi_type,#poi_name").val('');
	$('#menu').hide();
	$('#view_poi').show();
});

function forcamera(poi_type){ 
 if(poi_type=="GPC Cameras"){
  $('.camera_ele').prop("disabled", false);
 }else{
  $('.camera_ele').val('');
  $('.camera_ele').prop("disabled", true);
 }
}

function poi_clear() {
$( "#poi_name_txt" ).val( "");
$( "#address_txt" ).val( "");
$( "#city_txt" ).val( "");
$( "#state_txt" ).val( "");
$( "#zip_txt" ).val( "");
$( "#lati_txt" ).val( "");
$( "#longi_txt" ).val( "");
return false;
}
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
		var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+$("#lati_txt").val()+","+$("#longi_txt").val();
		$.getJSON(geocodingAPI, function (json) { alert(json.results[0].address_components);
			 json.results[0].address_components.forEach(myFunction);
		});
	});

			 
    }
	 var state = '';
	  var address = '';
 function myFunction(item,index) { //alert(item.types[0]);
    if(item.types[0]=='administrative_area_level_2'){
		$( "#city_txt" ).val(item.long_name);
	}
    if(item.types[0]=='administrative_area_level_1'){
		$( "#state_txt" ).val(item.long_name);
	}
    else if(item.types[0]=='street_number'){
		address = item.long_name;
		$( "#address_txt" ).val(address.trim());
	}
    else if(item.types[0]=='route'){
		address = address+" "+item.long_name;
		$( "#address_txt" ).val(address.trim());
	}
    else if(item.types[0]=='locality'){
		address = address+" "+item.long_name;
		$( "#address_txt" ).val(address.trim());
		address='';
	}
    else if(item.types[0]=='postal_code'){
		$( "#zip_txt" ).val(item.long_name);
	}
}


$("#poi_name").on('input', function() {
	 $('#poi_name').css('border', '');
		var data = {};
		$("#poi_dl option").each(function(i,el) {  
				   data[$(el).data("value")] = $(el).val();
		});
		console.log(data, $("#poi_dl option").val());
		var value = $('#poi_name').val();
		if(typeof ($('#poi_dl [value="' + value + '"]').data('value')) === "undefined")
		{
				$("#poi_id").val('');
		}
		else{ 
			var poi_id = $('#poi_dl [value="' + value + '"]').data('value');
			$("#poi_id").val(poi_id);	 }
});

$("#add_poi").on('click', function() {
	$('#menu,#view_poi').hide();
	
	$.post( "get_poi_name.php",{ new_poi: 'new' },function(data) {
		//alert(data);
		$("#poi_table").empty();
		$("#poi_table").html(data);
		//alert($("#lati_txt").val());
	 get_map_poi('lati_txt','longi_txt');
	/* var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+$("#lati_txt").val()+","+$("#longi_txt").val()+"&key=AIzaSyCLWeYaDJ385i-vxLhMjNJ51NTFCVuaGaM";
		$.getJSON(geocodingAPI, function (json) {
			 json.results[0].address_components.forEach(myFunction);
			 poi_clear();
		});
*/
		});

});
$("#poi_search").on('click', function() {
	
	if($("#poi_type").val()==''){
	 $('#poi_type').focus();
	 $("#poi_table").empty();
	  $('#poi_type').css('border', '2px solid red');
	}else if($("#poi_name").val()==''){
	 $('#poi_name').focus();
	 $("#poi_table").empty();
	  $('#poi_name').css('border', '2px solid red');
	} else{
		$('#view_poi').hide();
	$.post( "get_poi_name.php",{ poi_id: $("#poi_id").val(),poi_search:'true' },function(data) { //alert(data);
		$("#poi_table").empty();
		$("#poi_table").html(data);
		get_map_poi('lati_txt','longi_txt');

		var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+$("#lati_txt").val()+","+$("#longi_txt").val();
		if($('#address_txt').val()==""){
		$.getJSON(geocodingAPI, function (json) { 
			 json.results[0].address_components.forEach(myFunction);
		});
	}
		});
}
});

$("#poi_type").on('change', function() { 
	$('#select_poi_spin').show();
	//$("#poi_dl").empty();
	 $('#poi_type').css('border', '');
	if($("#poi_type").val()=="GPC Cameras"){
		$('#camid,#cam_name').prop("disabled", false);
	}
	
	$.post( "get_poi_name.php",{ poi_type: $("#poi_type :selected").val() },function(data) { //alert(data);
		$('#select_poi_spin').hide();
		$("#poi_dl").empty();
		$("#poi_name").val("");
		$("#poi_dl").html(data);
		});
});

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
		var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+$("#lati_txt").val()+","+$("#longi_txt").val();
		$.getJSON(geocodingAPI, function (json) { //alert(json.results[0].address_components);
			 json.results[0].address_components.forEach(myFunction);
		});
	});

			 
    }
    
function get_latlong() { 
	if ((($( "#lati_txt" ).val() != "") || ($( "#longi_txt" ).val() != "")) && ($('#address_txt').val().trim()=="") && ($('#city_txt').val().trim()=="") && ($('#state_txt').val().trim()=="")) {
		//alert('1');
		get_map_poi('lati_txt','longi_txt');
			var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+$("#lati_txt").val()+","+$("#longi_txt").val();
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
		var geocodingAPI = "https://maps.googleapis.com/maps/api/geocode/json?address="+add;//alert(geocodingAPI);
		$.getJSON(geocodingAPI, function (json) { 
			//alert(json.results[0].formatted_address);
			 //address = json.results[0].formatted_address;
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
<style>
.button.blue {
	color: 				hsl(208, 50%, 40%) !important;
	background-color: 	hsl(208, 100%, 75%);
	
	-webkit-box-shadow: inset rgba(255,254,255,0.6) 0 0.3em .3em, inset rgba(0,0,0,0.15) 0 -0.1em .3em, /* inner shadow */ 
							hsl(208, 50%, 55%) 0 .1em 3px, hsl(208, 50%, 40%) 0 .3em 1px, /* color border */
							rgba(0,0,0,0.2) 0 .5em 5px;	/* drop shadow */
	-moz-box-shadow: 	inset rgba(255,254,255,0.6) 0 0.3em .3em, inset rgba(0,0,0,0.15) 0 -0.1em .3em, /* inner shadow */ 
							hsl(208, 50%, 55%) 0 .1em 3px, hsl(208, 50%, 40%) 0 .3em 1px, /* color border */
							rgba(0,0,0,0.2) 0 .5em 5px;	/* drop shadow */
	box-shadow: 		inset rgba(255,254,255,0.6) 0 0.3em .3em, inset rgba(0,0,0,0.15) 0 -0.1em .3em, /* inner shadow */ 
							hsl(208, 50%, 55%) 0 .1em 3px, hsl(208, 50%, 40%) 0 .3em 1px, /* color border */
							rgba(0,0,0,0.2) 0 .5em 5px;	/* drop shadow */
}
.button.blue:hover { 	background-color: hsl(208, 100%, 83%); }
/* -------------- States -------------- */

.button:hover {
	background-color: 	hsl(0, 0%, 83%);
}



.button:active {
	background-image: 	-webkit-gradient(radial, 50% 0, 100, 50% 0, 0, from( rgba(255,255,255,0) ), to( rgba(255,255,255,0) )), url(noise.png);
	background-image: 	-moz-gradient(radial, 50% 0, 100, 50% 0, 0, from( rgba(255,255,255,0) ), to( rgba(255,255,255,0) )), url(noise.png);
	background-image: 	gradient(radial, 50% 0, 100, 50% 0, 0, from( rgba(255,255,255,0) ), to( rgba(255,255,255,0) )), url(noise.png);

	-webkit-box-shadow: inset rgba(255,255,255,0.6) 0 0.3em .3em, inset rgba(0,0,0,0.2) 0 -0.1em .3em, /* inner shadow */ 
							rgba(0,0,0,0.4) 0 .1em 1px, /* border */
							rgba(0,0,0,0.2) 0 .2em 6px; /* drop shadow */
	-moz-box-shadow: 	inset rgba(255,255,255,0.6) 0 0.3em .3em, inset rgba(0,0,0,0.2) 0 -0.1em .3em, /* inner shadow */ 
							rgba(0,0,0,0.4) 0 .1em 1px, /* border */
							rgba(0,0,0,0.2) 0 .2em 6px; /* drop shadow */
	box-shadow: 		inset rgba(255,255,255,0.6) 0 0.3em .3em, inset rgba(0,0,0,0.2) 0 -0.1em .3em, /* inner shadow */ 
							rgba(0,0,0,0.4) 0 .1em 1px, /* border */
							rgba(0,0,0,0.2) 0 .2em 6px; /* drop shadow */

	-webkit-transform: 	translateY(.2em);
	-moz-transform: 	translateY(.2em);
	transform: 			translateY(.2em);
}

.button:focus {
	outline: none;
	color: rgba(254,255,255,0.9) !important;
	text-shadow: rgba(0,0,0,0.2) 0 1px 2px;
}

.button[disabled], .button[disabled]:hover, .button.disabled, .button.disabled:hover {
	opacity: 			.5;
	cursor: 			default;
	color: 				rgba(0,0,0,0.2) !important;
	text-shadow: 		none !important;
	background-color: 	rgba(0,0,0,0.05);
	background-image: 	none;
	border-top: 		none;

	-webkit-box-shadow: inset rgba(255,254,255,0.4) 0 0.3em .3em, inset rgba(0,0,0,0.1) 0 -0.1em .3em, /* inner shadow */ 
							rgba(0,0,0,0.3) 0 .1em 1px, /* border */
							rgba(0,0,0,0.2) 0 .2em 6px; /* drop shadow */
	-moz-box-shadow: 	inset rgba(255,254,255,0.4) 0 0.3em .3em, inset rgba(0,0,0,0.1) 0 -0.1em .3em, /* inner shadow */ 
							rgba(0,0,0,0.3) 0 .1em 1px, /* border */
							rgba(0,0,0,0.2) 0 .2em 6px; /* drop shadow */
	box-shadow: 		inset rgba(255,254,255,0.4) 0 0.3em .3em, inset rgba(0,0,0,0.1) 0 -0.1em .3em, /* inner shadow */ 
							rgba(0,0,0,0.3) 0 .1em 1px, /* border */
							rgba(0,0,0,0.2) 0 .2em 6px; /* drop shadow */

	-webkit-transform: 	translateY(5px);
	-moz-transform: 	translateY(5px);
	transform: 			translateY(5px);
}

/* -------------- Fonts -------------- */

.serif { 
	font-family: 'Lobster', serif;
	font-weight: 			normal;
}


/* -------------- Sizes -------------- */

.xs { font-size: 16px; }
.xl { font-size: 32px; }


/* -------------- Materials -------------- */

.button.glossy:after, .button.glass:after {
	content: 	"";
	position: 	absolute; 
    width: 		90%;
    height: 	60%;
    top: 		0;
    left: 		5%;    
    
    -webkit-border-radius: 	.5em .5em 1em 1em / .5em .5em 2em 2em;    
    -moz-border-radius: 	.5em .5em 1em 1em / .5em .5em 2em 2em;
    border-radius: 			.5em .5em 1em 1em / .5em .5em 2em 2em;
    
    background-image: 		-webkit-gradient(linear, 0% 0, 100% 0, from( rgba(255,255,255,.55) ), to( rgba(255,255,255,.5) ),
    							color-stop(.5, rgba(255,255,255,0)), color-stop(.8, rgba(255,255,255,0)) );	
    background-image: 		-moz-linear-gradient(left, rgba(255,255,255,.55), rgba(255,255,255,0) 50%, rgba(255,255,255,0) 80%, rgba(255,255,255,.5) );	
    background-image: 		gradient(linear, 0% 0, 100% 0, from( rgba(255,255,255,.55) ), to( rgba(255,255,255,.5) ),
    							color-stop(.5, rgba(255,255,255,0)), color-stop(.8, rgba(255,255,255,0)) );	
}
.button.glossy:active:after,
.button.glass:active:after,
.button.disabled:after,
.button[disabled]:after
 { opacity: .6; }

.button.icon.glossy:after,
.button.icon.glass:after { height: 75% ; }

/* -------------- Glass + Transparent -------------- */
.button.glass {
	text-shadow: rgba(255,255,255,.5) 0 -1px 0, rgba(0,0,0,0.18) 0 .18em .15em;
}
.button.glass:active {
	text-shadow: rgba(255,255,255,.3) 0 1px 0, rgba(0,0,0,0.15) 0 .18em .15em;
}


/* -------------- Shapes -------------- */

/* round */
.round, .round.glossy:after, .round.glass:after { 
	border-top: none; 
	-webkit-border-radius: 	1em; 
	-moz-border-radius: 	1em; 
	border-radius: 			1em; 
}

/* oval */
.oval {
	border-top: 			none; 
	padding-left: 			.8em;
	padding-right: 			.8em;
	-webkit-border-radius: 	5em / 2em; 
	-moz-border-radius: 	5em / 2em; 
	border-radius: 			5em / 2em; 
}
.oval.glossy:after, .oval.glass:after { 	
	top: 					5%;
	-webkit-border-radius: 	5em / 2em 2em 1em 1em; 
	-moz-border-radius: 	5em / 2em 2em 1em 1em; 
	border-radius: 			5em / 2em 2em 1em 1em; 
}
.oval.icon {
	padding-left: 			.8em;
	padding-right: 			.8em;	
	-webkit-border-radius: 	1.5em / 1em; 
	-moz-border-radius: 	1.5em / 1em; 
	border-radius: 			1.5em / 1em; 
}
.oval.icon.glossy:after, .oval.icon.glass:after {	
	-webkit-border-radius: 	1.5em / 1em; 
	-moz-border-radius: 	1.5em / 1em; 
	border-radius: 			1.5em / 1em; 
}

/* brackets */
.brackets, .brackets.glossy:after, .brackets.glass:after { 
	border-top: 			none; 
	-webkit-border-radius: 	.5em / 1em;
	-moz-border-radius: 	.5em / 1em;
	border-radius: 			.5em / 1em;
}

/* skew */
.skew { 
	border-top: 			none; 
	padding-right: 			1.2em;
	padding-left: 			0.8em;	
	-webkit-border-radius: 	5em 1em / 5em 1em;  
	-moz-border-radius: 	5em 1em / 5em 1em;  
	border-radius: 			5em 1em / 5em 1em;  
}
.skew.glossy:after, .skew.glass:after { 	
	left: 10%;
	-webkit-border-radius: 	7em 1em / 5em 1em;
	-moz-border-radius: 	7em 1em / 5em 1em;
	border-radius: 			7em 1em / 5em 1em;
}
.skew.icon { 	
	padding-right: 			.9em;
	padding-left: 			.8em;
}

/* back */
.back, .back.glossy:after, .back.glass:after { 
	border-top-color: 		rgba(255,255,255,0.5);
	-webkit-border-radius: 	1.6em 1.6em 1em 1em / 4em 4em 1em 1em; 
	-moz-border-radius: 	1.6em 1.6em 1em 1em / 4em 4em 1em 1em; 
	border-radius: 			1.6em 1.6em 1em 1em / 4em 4em 1em 1em; 
}
.back.glossy:after, .back.glass:after { 
	 left: 	6%;
	 width:	88%;
}

/* knife */
.knife { 						
	padding-left: 1.5em;
	-webkit-border-radius: 	.2em .5em .5em 8em / .2em .5em .5em 5em; 
	-moz-border-radius: 	.2em .5em .5em 8em / .2em .5em .5em 5em; 
	border-radius: 			.2em .5em .5em 8em / .2em .5em .5em 5em; 
}
.knife.glossy:after, .knife.glass:after {
	left: 					3%;
	width: 					97%; 		
	-webkit-border-radius: 	.1em .5em .5em 8em / .1em .5em .5em 2em;   
	-moz-border-radius: 	.1em .5em .5em 8em / .1em .5em .5em 2em;   
	border-radius: 			.1em .5em .5em 8em / .1em .5em .5em 2em;   
}
.knife.glossy.icon:after, .knife.glass.icon:after { 
	left: 					5%; 
	width: 					95%;
	-webkit-border-radius: 	.5em .5em 1em 6em / .5em .5em 1em 4em; 
	-moz-border-radius: 	.5em .5em 1em 6em / .5em .5em 1em 4em; 
	border-radius: 			.5em .5em 1em 6em / .5em .5em 1em 4em; 
}

/* shield */
.shield, .shield.glossy:after, .shield.glass:after { 
	-webkit-border-radius: 	.4em .4em 2em 2em / .4em .4em 3em 3em; 
	-moz-border-radius: 	.4em .4em 2em 2em / .4em .4em 3em 3em;
	border-radius: 			.4em .4em 2em 2em / .4em .4em 3em 3em;
}
.shield { 							
	padding-left: 	.8em;
	padding-right: 	.8em;
}
.shield.icon { 						
	padding-left: 	.6em; 
	padding-right: 	.6em;
}

/* drop */
.drop {
	border-top: none;
	-webkit-border-radius: 	2em 5em  2em .6em / 2em 4em 2em .6em; 
	-moz-border-radius: 	2em 5em  2em .6em / 2em 4em 2em .6em; 
	border-radius: 			2em 5em  2em .6em / 2em 4em 2em .6em; 
}
.drop.glossy:after, .drop.glass:after { 
	left: 4%;
	-webkit-border-radius: 	2em 6em  2em 1em / 2em 4em 2em 2em; 
	-moz-border-radius: 	2em 6em  2em 1em / 2em 4em 2em 2em;
	border-radius: 			2em 6em  2em 1em / 2em 4em 2em 2em;
}
.drop.icon { 	
	padding-right: .6em; 
}

.morph {
	border-top: none;
	-webkit-border-radius: 	5em / 2em;
	-moz-border-radius: 	5em / 2em;
	border-radius: 			5em / 2em;
	-webkit-transition: 	-webkit-border-radius .3s ease-in-out;
	-moz-transition: 		-moz-border-radius .3s ease-in-out;
	transition: 			-moz-border-radius .3s ease-in-out;
}
.morph:hover { 
	-webkit-border-radius: 	.4em .4em 2em 2em / .4em .4em 3em 3em;
	-moz-border-radius: 	.4em .4em 2em 2em / .4em .4em 3em 3em;
	border-radius: 			.4em .4em 2em 2em / .4em .4em 3em 3em;
}
.morph:active { 
	-webkit-border-radius: 	.3em;
	-moz-border-radius: 	.3em;
	border-radius: 			.3em;
}
.morph:after { 
	display: none;
}
@-moz-document url-prefix() {
	.button { text-align: center; }
	.icon { padding: .5em 1em; }
	.icon:before { margin-left: -.42em; float: left; }
	
	.drop.icon { padding-right: 1.1em; }
	.shield.icon { padding-left: 1.1em; padding-right: 1.1em; }
	.skew.icon { padding-right: 1.4em; padding-left: 1.3em; }
	.oval.icon { padding-left: 1.3em; padding-right: 1.3em;	}
	.knife { padding-left: 2em; }
}




/* Damn, this became a fat baby..  */


</style>

<center>
<h2>POI</h2>
<div id="menu">
<input type="button" id="view_edit_poi"class="button blue skew" style="width:20vw; height:5vh; color:black;" value="View/Edit" /><br /><br />
<input type="button" id="add_poi"  class="button blue skew" style="width:20vw; height:5vh; color:black;" value="Add New POI" /><br /><br />

</div>
<form>

<table id="view_poi" width="30%" style="font-size:1.2rem;display:none;">
<tr><div id="select_poi_spin" style="display:none;color:red;"><img src="image/spinner.gif" width="20px" >Please wait...</div>
<th>
Type:</th>
<th>
<select id='poi_type' class="form-control">
			<option value="" >--Select POI Type--</option>
<?php

			 $result = $conn->query("select * from substation_more group by `type` order by REPLACE( `type`, 'GPC Subs', '#' )");
			 while($substation = $result->fetch_object())
			 {
			 ?>
			 <option value="<?=$substation->type?>" ><?=$substation->type?></option>
			<?  }  ?>
		 	</select>
</th>
</tr>
<tr><th>&nbsp;</th></tr>
<tr>
<th>
	<datalist id="poi_dl">

		<!--<? $result = $conn->query("select * from substation_more where `type`='GPC Subs'");
			 //while($substation = $result->fetch_object())
			 {
			 ?>
			 <option data-value="<?=$substation->id?>" value="<?=$substation->name?>" ></option>
			<?  }  ?>-->
	</datalist>
	Name: </th>
<th>
<input id='poi_name' list="poi_dl" class="form-control" autocomplete="off">
</th>
</tr>
<tr><th>&nbsp;</th></tr>
<tr><th colspan="1"></th><th style="text-align: center;"><input id="poi_search" class="btn btn-danger" type="button" value="Search"> <input type="button" class="btn btn-danger" value="Back" onclick='$("#menu").show();$("#view_poi").hide();$("#poi_table,#poi_dl").empty();' ></th></tr>
</table>
</form><input id="poi_id" type="hidden">
<table id="poi_table" >

</table>
</center>
