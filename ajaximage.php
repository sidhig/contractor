<?php
header("Content-Type: image/png");
$im = @imagecreate(200, 20)
    or die("Cannot Initialize new GD image stream");
$background_color = imagecolorallocate($im,233, 14, 91);
$text_color = imagecolorallocate($im, 0,0,0);
imagestring($im, 1, 5, 5,  "A Simple Text String", $text_color);
imagepng($im);
imagedestroy($im);
?>