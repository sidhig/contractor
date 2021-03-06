<?
session_start();
if($_SESSION['username']==''){
  header("location: index.php");
}
include_once('connect.php');
include_once('vehicles.php');
?>

   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaL0ieAkLhzy1rDoLifajeowdXPwTvzmI"></script>
   <script type="text/javascript" src="js/date.js"></script>
   <script src="js/function.js"></script>
   
 <script>

  
  var LocationData = <?=$finalString?>;
  var image;
  var zoomval = 7;
  var mapLat; 
  var mapLng;
  var map; 
  var myMapType = '';

function initialize()
{
	//alert(LocationData);
     map = new google.maps.Map(document.getElementById('map'),{
      mapTypeId: google.maps.MapTypeId.ROADMAP,
    mapTypeControl: true
  });
    var bounds = new google.maps.LatLngBounds();
    var infowindow = new google.maps.InfoWindow();

    if(myMapType != '')
      map.setMapTypeId(myMapType);
    
     
    for (var i = 0; i < LocationData.length; i++)
    { 

        var sites = LocationData[i];
        
        var ingstatus;
        var latlng = new google.maps.LatLng(sites[7], sites[8]);
        bounds.extend(latlng);
         html = '<b>Name:</b> '+sites[0]+
                '<br> <strong>Equipment Type:</strong> '+sites[2]+
                '<br> <strong>Status:</strong> '+sites[1]+
                '<br> <strong>Last Location:</strong> '+(new Date(sites[3].replace("-", "/")).toString("MM-dd-yyyy hh:mm tt"));
        
        var marker = new google.maps.Marker({
            position: latlng,
            zoom: 7,
            map: map,
            icon: setimage(sites[5],sites[4],sites[6],sites[10]),
            title: sites[2],
            html: html
        });
    
        google.maps.event.addListener(marker, 'click', function() {
       infowindow.setContent(this.html);
            infowindow.open(map, this);
        });
    }
    map.fitBounds(bounds);
    //alert(map.getZoom());
}
 
google.maps.event.addDomListener(window, 'load', initialize);

</script>
<script>
setInterval(function() {
    //alert();
    map_refresh();
}, 30000);

function map_refresh() {
    // alert('test');
    $.ajax({
        type: "POST",
        url: "vehicles.php",
        data: 'fromajax=true',
        cache: false,
        success: function(result) {
            //alert(result);
            var myMapType = map.getMapTypeId();
            var savedMapZoom = map.getZoom();
            var mapCentre = map.getCenter();
            mapLat = mapCentre.lat();
            mapLng = mapCentre.lng();
            LocationData = $.parseJSON(result);
            initialize();
            map.setCenter(new google.maps.LatLng(mapLat, mapLng));
            map.setZoom(savedMapZoom);
            map.setMapTypeId(myMapType);
        } //sucess close
    });
}

</script>
<style>

    .ScrollStyle {
        min-height: 550px;
        max-height: 550px;
        overflow-y: scroll;
}
</style>   
<?include_once('header.php');?>
<div id='trip_sheet_div' style='display:none;position: fixed; top: 0; right: 0; bottom: 0; left: 0; width: 100%; height: 100%; overflow: auto;
    z-index: 3; padding: 20px; box-sizing: border-box; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.75); text-align: center;'>
</div>
<div id="main">
    <!--<div class="ScrollStyle">-->
        <div id="map" class='current_view' style="width:100%;height:97%;margin-top:1vh; color:black; "></div>
        <div class='current_view ScrollStyle' id='Admin' style="display:none;background-color: white;margin-top: 0vh;background-image: url('image/bgmap.png');
  background-size: cover;height: auto;color:black;overflow - y: scroll;"></div>
        <div id="manage_poi" class='current_view ScrollStyle' style="height:auto;margin-top:0vh;background-image: url('image/bgmap.png');
  background-size: cover; color:black;display:none;background-color: white;min-height: 84vh;"></div>
        <div id="report" class='current_view ScrollStyle' style="height:auto;margin-top:0vh;background-image: url('image/bgmap.png');
  background-size: cover;height: auto; color:black;display:none;background-color: white;min-height: 84vh;"></div>
    <!--</div>-->
</div>
<? include_once('fotter.php'); ?>


