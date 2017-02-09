<?
session_start();
include_once('connect.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Contractor</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/png" href="image/favicon.png"/>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" href="css/bootstrap-multiselect.css"> 
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.3.3.6.css" />


 <script src="js/jquery.min.1.12.0.js"></script> 
 <script src="js/bootstrap-multiselect.js"></script> 
 <script src="js/bootstrap.min.3.3.6.js"></script> 
  <style>
	
    .row.content {
		height: 86.5vh;
	}
    
    .sidenav {
      background-color: #f1f1f1;
      min-height: 100%;
      height: auto
    }
    
   footer {
	   width:100%;
      margin-top:.2vh;
      border: 1px solid #BBBBBB;
      height:auto;
      font-size:.9vw;
      padding: 1vh;
      background-color: white;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
    
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }

     .form-control {
         display:initial;
        height: 30px;
        padding: 3px 6px; 
    }  
    .col-sm-3{
            width: 20%;
    }
    .col-sm-9{
            width: 80%;
    }
	
  </style>
  <script>
     $(document).ready(function() {
      $('#area,#supervisor').multiselect({
        includeSelectAllOption: true,
        selectAllText: 'All',
         numberDisplayed: 1
      }); 
  
  $("#view").change(function(){ 
      view_change($("#view").val());
  });
  });
  </script>
      
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
          <li><img src="image/cont.png" style="width: 15vw;margin-right: 67vw;"></li>
        <li><a href=""><b><?=" Welcome   ".$_SESSION["username"]?></b></a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
    
<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <ul class="nav nav-pills nav-stacked" style="margin-top:.2vh;">
        <li><a ><b style='margin-right: 1.1vw;'>Function :</b>
                <select id="view" name="view"  class="form-control" style="width: 9.5vw;">
                    <?
                        $r = $conn->query("select * from tbl_view order by name asc");
                        while($res = $r->fetch_object())
                        {?>
                        <option "<?=$res->name?>" <? if($res->name == 'Map'){ echo "selected";}?>> <?=$res->name?> </option>
                       <? }
                    ?>
                </select>
            </a></li>
        <li><a ><b style='margin-right: 2.5vw;'>Area :</b>
            <select id="area" name="area" multiple="multiple">
                    <?
                        $r = $conn->query("select * from tbl_area order by name asc");
                        while($res = $r->fetch_object())
                        {?>
                        <option selected> <?=$res->name?> </option>
                       <? }
                    ?>
                </select>
            </a>
        </li>
        <li><a><b>Supervisor : </b>
            <select id="supervisor" name="supervisor" multiple="multiple">
                    <?
                        $r = $conn->query("select * from tbl_supervisor order by name asc");
                        while($res = $r->fetch_object())
                        {?>
                        <option selected> <?=$res->name?> </option>
                       <? }
                    ?>
            </select>
          </a>
        </li>
      </ul>
    </div>

    <div class="col-sm-9">

    

