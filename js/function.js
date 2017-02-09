
function setimage(timediff,eventcode,header,image_url){
//alert(timediff+','+eventcode+','+header);
  //var values = image_url.split('#');
  //var image_url = 'Isuzu/Isuzu-MovingTruck_';
  var isrotation = 1;

  //var name = values[0];

   if (timediff < 1) 
       {

        if(eventcode=='4001' || eventcode=='6011' || eventcode=='8001')
        { 
     /*if (header == 901)//for poi image on history
         {
          image = 'image/poi/'+image_url+'.png';
         }*/
     
		if (header >= 349 || header < 12 || isrotation == 0)
         {
          image = 'image/vehicles/'+image_url+'Green1.png';
         }
         else if (header >= 12 && header < 34)
         {
          image = 'image/vehicles/'+image_url+'Green31.png';
         }
         else if (header >= 34 && header < 57)
         {
          image = 'image/vehicles/'+image_url+'Green29.png';
         }
         else if (header >= 57 && header < 79)
         {
          image = 'image/vehicles/'+image_url+'Green27.png';
         }
         else if (header >= 79 && header < 102)
         {
          image = 'image/vehicles/'+image_url+'Green25.png';
         }
         else if (header >= 102 && header < 124)
         {
          image = 'image/vehicles/'+image_url+'Green23.png';
         }
         else if (header >= 124 && header < 147)
         {
          image = 'image/vehicles/'+image_url+'Green21.png';
         }
         else if (header >= 147 && header < 169)
         {
          image = 'image/vehicles/'+image_url+'Green19.png';
         }
         else if (header >= 169 && header < 192)
         {
          image = 'image/vehicles/'+image_url+'Green17.png';
         }
         else if (header >= 192 && header < 214)
         {
          image = 'image/vehicles/'+image_url+'Green15.png';
         }
         else if (header >= 214 && header < 237)
         {
          image = 'image/vehicles/'+image_url+'Green13.png';
         }
         else if (header >= 237 && header < 259)
         {
          image = 'image/vehicles/'+image_url+'Green11.png';
         }
         else if (header >= 259 && header < 282)
         {
          image = 'image/vehicles/'+image_url+'Green9.png';
         }
         else if (header >= 282 && header < 304)
         {
          image = 'image/vehicles/'+image_url+'Green7.png';
         }
         else if (header >= 304 && header < 327)
         {
          image = 'image/vehicles/'+image_url+'Green5.png';
         }
         else if (header >= 327 && header < 349)
         {
          image = 'image/vehicles/'+image_url+'Green3.png';
         }
         else 
         {
          image = 'image/vehicles/'+image_url+'Green1.png';
         }
        }//end green condition

        else if(eventcode=='4002' || eventcode=='6012')
        {
         if (header >= 349 || header < 12 || isrotation == 0)
         {
          image = 'image/vehicles/'+image_url+'Red1.png';
         }
         else if (header >= 12 && header < 34)
         {
          image = 'image/vehicles/'+image_url+'Red31.png';
         }
         else if (header >= 34 && header < 57)
         {
          image = 'image/vehicles/'+image_url+'Red29.png';
         }
         else if (header >= 57 && header < 79)
         {
          image = 'image/vehicles/'+image_url+'Red27.png';
         }
         else if (header >= 79 && header < 102)
         {
          image = 'image/vehicles/'+image_url+'Red25.png';
         }
         else if (header >= 102 && header < 124)
         {
          image = 'image/vehicles/'+image_url+'Red23.png';
         }
         else if (header >= 124 && header < 147)
         {
          image = 'image/vehicles/'+image_url+'Red21.png';
         }
         else if (header >= 147 && header < 169)
         {
          image = 'image/vehicles/'+image_url+'Red19.png';
         }
         else if (header >= 169 && header < 192)
         {
          image = 'image/vehicles/'+image_url+'Red17.png';
         }
         else if (header >= 192 && header < 214)
         {
          image = 'image/vehicles/'+image_url+'Red15.png';
         }
         else if (header >= 214 && header < 237)
         {
          image = 'image/vehicles/'+image_url+'Red13.png';
         }
         else if (header >= 237 && header < 259)
         {
          image = 'image/vehicles/'+image_url+'Red11.png';
         }
         else if (header >= 259 && header < 282)
         {
          image = 'image/vehicles/'+image_url+'Red9.png';
         }
         else if (header >= 282 && header < 304)
         {
          image = 'image/vehicles/'+image_url+'Red7.png';
         }
         else if (header >= 304 && header < 327)
         {
          image = 'image/vehicles/'+image_url+'Red5.png';
         }
         else if (header >= 327 && header < 349)
         {
          image = 'image/vehicles/'+image_url+'Red3.png';
         }
         else 
         {
          image = 'image/vehicles/'+image_url+'Red1.png';
         }
        } 
        else{
           if (header >= 349 || header < 12 || isrotation == 0)
                if (header >= 349 || header < 12 || isrotation == 0)
         {
          image = 'image/vehicles/'+image_url+'Yellow1.png';
         }
         else if (header >= 12 && header < 34)
         {
          image = 'image/vehicles/'+image_url+'Yellow31.png';
         }
         else if (header >= 34 && header < 57)
         {
          image = 'image/vehicles/'+image_url+'Yellow29.png';
         }
         else if (header >= 57 && header < 79)
         {
          image = 'image/vehicles/'+image_url+'Yellow27.png';
         }
         else if (header >= 79 && header < 102)
         {
          image = 'image/vehicles/'+image_url+'Yellow25.png';
         }
         else if (header >= 102 && header < 124)
         {
          image = 'image/vehicles/'+image_url+'Yellow23.png';
         }
         else if (header >= 124 && header < 147)
         {
          image = 'image/vehicles/'+image_url+'Yellow21.png';
         }
         else if (header >= 147 && header < 169)
         {
          image = 'image/vehicles/'+image_url+'Yellow19.png';
         }
         else if (header >= 169 && header < 192)
         {
          image = 'image/vehicles/'+image_url+'Yellow17.png';
         }
         else if (header >= 192 && header < 214)
         {
          image = 'image/vehicles/'+image_url+'Yellow15.png';
         }
         else if (header >= 214 && header < 237)
         {
          image = 'image/vehicles/'+image_url+'Yellow13.png';
         }
         else if (header >= 237 && header < 259)
         {
          image = 'image/vehicles/'+image_url+'Yellow11.png';
         }
         else if (header >= 259 && header < 282)
         {
          image = 'image/vehicles/'+image_url+'Yellow9.png';
         }
         else if (header >= 282 && header < 304)
         {
          image = 'image/vehicles/'+image_url+'Yellow7.png';
         }
         else if (header >= 304 && header < 327)
         {
          image = 'image/vehicles/'+image_url+'Yellow5.png';
         }
         else if (header >= 327 && header < 349)
         {
          image = 'image/vehicles/'+image_url+'Yellow3.png';
         }
         else 
         {
          image = 'image/vehicles/'+image_url+'Yellow1.png';
         }
          } 
        }
        else
        {
          if (header >= 349 || header < 12 || isrotation == 0)
         {
          image = 'image/vehicles/'+image_url+'Grey1.png';
         }
         else if (header >= 12 && header < 34)
         {
          image = 'image/vehicles/'+image_url+'Grey31.png';
         }
         else if (header >= 34 && header < 57)
         {
          image = 'image/vehicles/'+image_url+'Grey29.png';
         }
         else if (header >= 57 && header < 79)
         {
          image = 'image/vehicles/'+image_url+'Grey27.png';
         }
         else if (header >= 79 && header < 102)
         {
          image = 'image/vehicles/'+image_url+'Grey25.png';
         }
         else if (header >= 102 && header < 124)
         {
          image = 'image/vehicles/'+image_url+'Grey23.png';
         }
         else if (header >= 124 && header < 147)
         {
          image = 'image/vehicles/'+image_url+'Grey21.png';
         }
         else if (header >= 147 && header < 169)
         {
          image = 'image/vehicles/'+image_url+'Grey19.png';
         }
         else if (header >= 169 && header < 192)
         {
          image = 'image/vehicles/'+image_url+'Grey17.png';
         }
         else if (header >= 192 && header < 214)
         {
          image = 'image/vehicles/'+image_url+'Grey15.png';
         }
         else if (header >= 214 && header < 237)
         {
          image = 'image/vehicles/'+image_url+'Grey13.png';
         }
         else if (header >= 237 && header < 259)
         {
          image = 'image/vehicles/'+image_url+'Grey11.png';
         }
         else if (header >= 259 && header < 282)
         {
          image = 'image/vehicles/'+image_url+'Grey9.png';
         }
         else if (header >= 282 && header < 304)
         {
          image = 'image/vehicles/'+image_url+'Grey7.png';
         }
         else if (header >= 304 && header < 327)
         {
          image = 'image/vehicles/'+image_url+'Grey5.png';
         }
         else if (header >= 327 && header < 349)
         {
          image = 'image/vehicles/'+image_url+'Grey3.png';
         }
         else 
         {
          image = 'image/vehicles/'+image_url+'Grey1.png';
         }
      }
	//image = 'image/vehicles/freightliner/freightlinerred.png';
      var bgimg = new Image();
          bgimg.src = image;
        //  center='30';
        //  size: new google.maps.Size(bgimg.width, bgimg.height),
        
        image = { url: image,
              origin: new google.maps.Point(0,0),
              anchor: new google.maps.Point((bgimg.width*0.5), (bgimg.height*0.5))
              };
        
          return image;
    }
    
    function view_change(module) {

        $.get("check_session.php", function(data) {
            if (data.trim() == 'out') {
                alert('Session out. Contractor redirecting you to login page..');
                window.location.href = 'index.php';
            }
        });
        if (module == 'Map') {
            $(".current_view").hide();
            $("#map").show();
            $('.multiselect').removeAttr("disabled");
            initialize();
        } else if (module == 'Admin') {
            $(".current_view").hide();
            $('#Admin').show();
            $('.multiselect').attr('disabled', 'disabled');
            if ($("#Admin").html().trim() == '') {
                $("#Admin").html("<center><img src='image/spinner.gif'> <strong>Please wait while getting Admin...</strong></center>");
                $("#Admin").load("Admin.php");
                $("#tracker").load('tracker_list.php');
            }
        } else if (module == 'POI') {
            $(".current_view").hide();
            $('#manage_poi').show();
            $('.multiselect').removeAttr("disabled");
            if ($("#manage_poi").html().trim() == '') {
                $("#manage_poi").html("<center><img src='image/spinner.gif'> <strong>Please wait while getting Manage POI...</strong></center>");
                $("#manage_poi").load("Manage_POI.php");
            }
        } else if (module == 'Reports') {
            $(".current_view").hide();
            $('#report').show();
            $('.multiselect').removeAttr("disabled");
            if ($("#report").html().trim() == '') { //alert('hlo');
                $("#report").html("<center><img src='image/spinner.gif'> <strong>Please wait while getting Report...</strong></center>");
                $("#report").load("Reports.php");
            }
        }
    }