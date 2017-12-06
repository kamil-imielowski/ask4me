<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
/* if(!isset($_COOKIE['lang'])){
	setcookie('lang',"en",time()+3600*24*365,'/');
	header("Refresh:0");
} */
if(isset($_SESSION['errors'])){
		$errors = $_SESSION['errors'];
		unset($_SESSION['errors']);
}
if(isset($_SESSION['ok'])){
		$ok = $_SESSION['ok'];
		unset($_SESSION['ok']);
}
?>