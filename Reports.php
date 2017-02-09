<? session_start();
include_once('connect.php');
?>
<!--<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>-->
<style>
.intp {
        width: 20vw;
    }
@media only screen and (max-width: 768px) {
        .intp {
        width: 100%;
    }
}
</style>
<div id="report" style="">
<center><h3>Reports</h3></center>
<div id="report_buttons">
<center>
<?
$sql = "SELECT * from role_report order by name asc";
        $result = $conn->query($sql); 
		$count = 0 ;
        while($obj = $result->fetch_object())
			{ ?>

					<? if ($count%2 ==0 ) {  ?> 
						<a href="<?=($obj->href)?>" target='blank' ><input type="button" class="btn btn-danger" value="<?=($obj->name)?>" class="btn btn-warning intp" style="width: 15vw; height:5vh; color:black; margin: 5px;" /><br><br>
					<? } else {  ?> 
						<a href="<?=($obj->href)?>" target='blank' ><input type="button" class="btn btn-danger" value="<?=($obj->name)?>" class="btn btn-warning intp" style="width: 15vw; height:5vh; color:black; margin: 5px;" />
					<? } $count++; ?> 
			<?}?>
   
</center>
</div>

</div>