</div>
</div>
</div>
<footer>	 
<center>
<!--				 <span style="width: 204px; float: left;border: 1px solid white;"></span>-->
				 
				 <span id="currentDate" style="margin-left: 20vw;"><b>as of: </b>
				 <script>
					function ShowLocalDate()
					{
					//alert('aaa');
					var dNow = new Date();
					var localdate= (dNow.getMonth()+1) + '-' + dNow.getDate() + '-' + dNow.getFullYear().toString().substr(2,2) + ' ' + n(dNow.getHours()) + ':' + n(dNow.getMinutes());
					return localdate;
					}
					function n(n){
						return n > 9 ? "" + n: "0" + n;
					}

					 document.write(ShowLocalDate());
					</script>
				 </span>
			<!--footer section start-->		
				 <span style="float:right; margin-bottom:0px;margin-right:10px;">Copyright &copy; 2017
					  <a href="#" title="contracktorsystems.com" target="blank">contracktorsystems.com</a>. 
					  All rights reserved.
				 </span>
</center>


</footer>

</body>
</html>
