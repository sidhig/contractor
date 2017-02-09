<? include_once('connect.php'); 
  session_start(); ?>
<style>
 body{
  background-color: #d6dce2;
 }
 td{
  padding-bottom: .8vh;
 }
 .stg{
  margin-left: 2vw;
    margin-right: 4vw;
   }
.sel{
  width:15vw;
}
 .intp{width:15vw;}

.modal {
  width:40vw;
}
.modal a.close-modal {
    top: 0.5px;
    right: 0.5px;
	}
 
th {
		text-align: center;
	}

@media only screen and (max-width: 768px) {
    /* For mobile phones: */
   
    .intp {
        width: 100%;
    }
    .sel {
        width: 100%;
    }
	.modal {
	width:90vw;
  }
}
.btn{
  /*background: url(image/close.png) no-repeat;*/
}

 </style>
 <script>
 function role_search(text_data,jo_object){
  jo = jo_object.find('tr');
 
    var data4 = capitalize(text_data.trim());
    var data5 = text_data.toLowerCase().trim();
    var data6 = text_data.toUpperCase().trim();
    var data7 = text_data.trim();
 
    jo.hide();
    jo.filter(function (i, v) {
        var $t = $(this);

            if ( ($t.is(":contains('" + data4 + "')")) || ($t.is(":contains('" + data5 + "')"))|| ($t.is(":contains('" + data6 + "')")) ||($t.is(":contains('" + data7 + "')"))) {
                return true;
            }
    
     return false;
    }).show();
}

 $("#new_user").click(function(){
    $("#spin_loading").show(); 
		$("#trip_sheet_div").load("add_user.php"); 
		$("#trip_sheet_div").show();
    $("#spin_loading").hide();
  });

 function manage_role(){
        $("#spin_loading").show(); 
        $.ajax({
                type: 'post',
                url: 'manage_role.php',
                data:'',
                success: function (data) {
                  $('#user_details').hide();
                  $('#manage_role').html('');
                  $('#manage_role').html(data);
                  $('#manage_role').show();
                  $("#spin_loading").hide();
                }
              }); 

  }



function manage_role_view(role){
         $("#spin_loading").show();
         $.ajax({
                type: 'post',
                url: 'role_det.php',
                data: 'role='+role,
                success: function (data) {
                  //$('#user_details').hide();
                  $('#manage_role').hide();
                  $("#role_record").html(data); 
                  //$("#role_record").show();
                  $("#spin_loading").hide();
                }
              }); 

}

function view_role_users(role_name){  // onclick of users button
//alert(role_name);
$('#spin_loading').show();
 $.ajax({
            type: "POST",
            url: "view_role_users.php",
            data: "role="+role_name,
            success: function(data) {
              //alert(data);
        //$("#manage_role").hide();
        $("#trip_sheet_div").html(data); 
        $("#trip_sheet_div").show();
        $('#spin_loading').hide();
        //$("#user_load_spinner").hide();
            }
        }); 
}

/*function edit_role_user(role){
$('#spin_loading').show();
 $.ajax({
            type: "POST",
            url: "view_role.php",
            data: "role_name="+role,
            success: function(data) {
              //alert(data);
        //$("#manage_role").hide();
        $("#trip_sheet_div").html(data); 
        $("#trip_sheet_div").show();
        $('#spin_loading').hide();
        //$("#user_load_spinner").hide();
            }
        }); 
}*/

function edit_user(id,role){
	//alert(id);
    $("#user_load_spinner").show(); 
  $.ajax({
            type: "POST",
            url: "edit_user.php",
            data: "id="+id+"&role="+role,
            success: function(data) {
            	//alert(data);
				$("#trip_sheet_div").html(data); 
				$("#trip_sheet_div").show();
				$("#user_load_spinner").hide();
            }
        });
  }

  function del_user(id){
  	//alert(id);
	if(confirm("Are you sure to delete this user ?")){
		$("#user_load_spinner").show(); 
			$.ajax({
				type: "POST",
				url: "user_query.php",
				data: "del_qry="+id,
				success: function(data) {
					alert(data);
					$("#user_tbl_body").load('user_tbl_body.php');
					$("#user_load_spinner").hide();
				}
			});
	}
}

  /*function del_role_user(role){
    alert(role);
  if(confirm("Are you sure to delete all users with role: "+role+ "?")){
    $("#spin_loading").show(); 
      $.ajax({
        type: "POST",
        url: "user_query.php",
        data: "del_user_role="+role,
        success: function(data) {
          alert(data);
          //manage_role();
          $("#user_details").load('manage_role.php');
          $("#spin_loading").hide();
        }
      });
  }
}*/

function validateEmail1(x) {
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        //alert("Not a valid e-mail address");
        return true;
    }else{
      return false;
    }
}
function validateuser(){ 
  if ($("#name").val().trim() == ''){
        alert('Please Fill Name');
        $("#name").focus();
        
      } else if(validateEmail1($("#email").val().trim())){
        alert('Please Fill Email');
        $("#email").focus();
        
      }else 
    if ($("#username").val().trim() == ''){
        alert('Please Fill username');
        $("#username").focus();
        
      }
      else if ($("#password").val().trim() == ''){
        alert('Please Fill Password');
        $("#password").focus();
        
      }
    else {
     $("#user_add_spinner").show();
   $.ajax({
            type: "POST",
            url: "user_query.php",
            data: $('#new_user_form').serialize(),
            success: function(data) {
        //alert(data);
        if(data == 1){
          alert("Username Already Exists");
          $("#user_add_spinner").hide();
          $("#username").focus();
        }else{
           alert(data);
        $("#trip_sheet_div").html(""); 
        $("#trip_sheet_div").hide();
        $("#user_add_spinner").hide();
        $("#new_user").show();
        $("#new_role").show();
        $("#user_tbl_body").load('user_tbl_body.php');
            }
          }
        });
   
    }
} 

 </script>
 <link rel="stylesheet" href="css/jquery.modal.css">
 <script src="js/jquery.modal.js"></script>
 <center>
 <div id='spin_loading' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Please wait...</div>
 <div id="user_details" style="margin-top: 1vh;">
 <button onclick="sch_back();" style="position: absolute; left: 2vw;">Back</button>
<? if($_SESSION['LOGIN_role']!='superadmin'){ ?>
<input type="button" id='new_user' value="Add User" class="btn btn-warning intp" style="color:black; margin-bottom:.3vh; padding: 1vh;" />
<?}?>
<? if($_SESSION['LOGIN_role']=='superadmin'){ ?>
 <input type="button" id='manage_role_butt' value="Add User" onclick="manage_role()" class="btn btn-warning intp" style="color:black; margin-bottom:.3vh; padding: 1vh;" />
<?}?>
 <br>
 <div id='user_load_spinner' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Please wait...</div>
 
<!--<input type="button" id='new_role' value="Add Role" class="btn btn-warning intp" style="color:black; margin-bottom:.3vh; padding: 1vh;" /><br>-->
<center><div id="search" style="margin: 10px;font-size: medium;">
  Search : <input id="search_role"   oninput="role_search($(this).val(),$('#user_tbl_body'));" style="padding: .1vh;height: 4%;">
  
</div></center>
<div id='user_loading' style="color:red; clear: both; display:none;"><img src="image/spinner.gif" width="20px">Please wait...</div>
 <table border="1" style="width:80%; margin-top:20px; text-align: center; font-size: 1.35rem; background-color: white;">
 <thead id='user_head'>
   <tr>
   <th>Name</th>
    <th>Username</th> 
    <!-- <th>Password</th> -->
    
   <!--  <th>Area</th> -->
    <th>Role</th>
    <th>Edit /Delete</th>
   </tr>
</thead>
   <tbody id="user_tbl_body">
<? include_once('user_tbl_body.php'); ?>

   </tbody>
</table>
</div>
<div id="manage_role"></div>
<div id="role_record" class="col-sm-12" style="width:100%;margin-top:1vh;margin-bottom: 18vh;"></div>
</center>
