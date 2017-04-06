<?
if(isset($_POST['btn']) == true)
{

 $datastring=$_POST['search'];
$curl = curl_init();
$url = 'http://www.amazon.in/s/&field-keywords='.$datastring;
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


$result = curl_exec($curl);
$reg = "!http://ecx.images-amazon.com/images/I/[^\s]*?._AC_US160_.jpg!";
preg_match_all($reg,$result,$matches);
// http://ecx.images-amazon.com/images/I/51iwW7wZjlL._AC_US160_.jpg




$images =array_unique($matches[0]);

foreach($images as $curimg){

echo "<img src= $curimg />";
}


curl_close($curl);

}
?>

<!DOCTYPE html>
<html>
<head>
 <title>Grab From Amazon</title>
</head>
<body>
<form method="POST"> 
<H2> Image Grabber From Amazon </H2>
 <input type="text" name="search">
 <input type="submit" name="btn" value="SEARCH">
</form>
</body>
</html>