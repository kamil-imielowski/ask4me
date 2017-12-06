<?php
session_start();
ob_start();
include dirname(__FILE__).'/sessionToVerb4Alerts.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

if(isset($_POST['action']) || isset($_GET['action'])){
			
	$action = empty($_POST['action']) ? $_GET['action'] : $_POST['action'];
					
	switch ($action) {
				
		case 'login':
			try{
				$admin = new classes\Admin\Admin($_POST['login']);
				$admin -> login($_POST['password']);
			}catch(Exception $e){
				$_SESSION['errors'][] = $e->getMessage();
				$_SESSION['loginData'] = $_POST['login'];
				header("location: login.php");
				break;
			}
			if(isset($_SESSION['loginData'])){
				unset($_SESSION['loginData']);
			}
			$_SESSION['admin'] = base64_encode(serialize($admin)); 
			header("Location: index.php"); 
		break;		
		
		case 'logout':
			unset($_SESSION['admin']);
			header("location: login.php");
		break;		
		
	}		

} else {	
	include 'templates/login.html.php';
}