<?php
  session_start();
  error_reporting(0);
if(!empty($_SESSION)){
	echo 'in';
}else{
	echo 'out';

}
?>