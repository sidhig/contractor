<?php

//  $s = curl_init(); 
        
//          curl_setopt($s,CURLOPT_URL,"http://www.amazon.in/s/&field-keywords=$datastring"); 
//          curl_setopt($s, CURLOPT_SSL_VERIFYPEER, false);
//          curl_setopt ($s, CURLOPT_RETURNTRANSFER, true);

// curl_exec($s);
// curl_close($s);
//$useragent = "Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.14912/870; U; id) Presto/2.4.15";
if(isset($_POST['btn']) == true)
{

$ch = curl_init ("");
$query=$_POST['search'];
curl_setopt ($ch, CURLOPT_URL, "http://www.google.com/search?hl=en&tbo=d&site=&source=hp&q=".$query);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1');

// curl_setopt ($ch, CURLOPT_USERAGENT, $useragent); // set user agent
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
echo $output = curl_exec ($ch);
curl_close($ch);
}
?>
<html>
<form method="POST"> 
<!-- <H2> Image Grabber From Amazon </H2>
 --> <input type="text" name="search">
 <input type="submit" name="btn" value="SEARCH">
</form>
</html>
