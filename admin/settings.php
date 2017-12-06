<?php
session_start();
include dirname(__FILE__).'/sessionToVerb4Alerts.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

if(isset($_SESSION['admin'])){
	$settingsPage = true;
	$socialMediaPage = true;

	if(isset($_POST['action']) || isset($_GET['action'])){
			
		$action = empty($_POST['action']) ? $_GET['action'] : $_POST['action'];
					
		switch ($action) {

			
		}		

	} else {
		$settings = new \classes\Settings\SettingsFactory();	
		include 'templates/settings.html.php';
	}

}else{
	header("Location: login.php");
}


?>