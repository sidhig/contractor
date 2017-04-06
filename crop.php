<?php
$file_path="contractor/image/images.jpg"
$size=getimagesize($file_path);
$width=$size[0];
$height=$size[1];
$x=$_POST["locationX"];
$y=$_POST["locationY"];
if (($x+$width)>300){
    $tWidth=$x>=0?(300-$x):300;
}else{
    $tWidth=$width;
}
// if (($y+$height)>600){
//     $tHeight=$y>=0?(600-$y):600;
// }else{
//     $tHeight=$height;
// }
$tX=$x>=0?0:($x*-1);
$tY=$y>=0?0:($y*-1);
$img_r=imagecreatefromjpeg($file_path);
$dst_r = imagecreatetruecolor($tWidth,$tHeight);
imagecopyresampled($dst_r,$img_r,0,0,$tX,$tY,$tWidth,$tHeight,$tWidth,$tHeight);
imagejpeg($dst_r,"cropped.jpg",90);
?>
<html>
<head><title>crop this image</title></head>

</html>
