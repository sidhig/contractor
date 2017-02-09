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
 
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" href="css/bootstrap-multiselect.css"> 
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.3.3.6.css" />


 <script src="js/jquery.min.1.12.0.js"></script> 
 <script src="js/bootstrap-multiselect.js"></script> 
 <script src="js/bootstrap.min.3.3.6.js"></script> 
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 86.5vh;}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      min-height: 100%;
      height: auto
    }
    
    /* Set black background color, white text and some padding */
   footer {
      margin-top:.2vh;
      border: 1px solid #BBBBBB;
      height:auto;
      font-size:.9vw;
      padding: 1vh;
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
/*    .row.content {
        height: 450vh;
    }*/
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
        <li><a href=""><b><?=" Welcome   ".$_SESSION["username"]?></b></a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
    
<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <ul class="nav nav-pills nav-stacked" style="margin-top:2vh;">
        <li><a>View :
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select id="view" name="view"  class="form-control" style="width:10vw;">
                    <?
                        $r = $conn->query("select * from tbl_view order by name asc");
                        while($res = $r->fetch_object())
                        {?>
                        <option value="<?=$res->name?>" <? if($res->name == 'Map'){ echo "selected";}?>> <?=$res->name?> </option>
                       <? }
                    ?>
                </select>
            </a></li>
        <li><a>Area :
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select id="area" name="area" multiple="multiple">
                    <?
                        $r = $conn->query("select * from tbl_area order by name asc");
                        while($res = $r->fetch_object())
                        {?>
                        <option <? if($res->name == 'Map'){ echo "selected";}?>> <?=$res->name?> </option>
                       <? }
                    ?>
                </select>
            </a>
        </li>
        <li><a>Supervisor :
            <select id="supervisor" name="supervisor" multiple="multiple">
                    <?
                        $r = $conn->query("select * from tbl_supervisor order by name asc");
                        while($res = $r->fetch_object())
                        {?>
                        <option <? if($res->name == 'Map'){ echo "selected";}?>> <?=$res->name?> </option>
                       <? }
                    ?>
            </select>
          </a>
        </li>
      </ul>
    </div>

    <div class="col-sm-9">

    

