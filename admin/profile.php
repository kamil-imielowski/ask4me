<?php
session_start();
include_once dirname(__FILE__).'/sessionToVerb4Alerts.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

if(isset($_SESSION['admin'])){
    $admin = unserialize(base64_decode($_SESSION['admin']));

	if(isset($_POST['action']) || isset($_GET['action'])){
			
		$action = empty($_POST['action']) ? $_GET['action'] : $_POST['action'];
					
		switch ($action) {
				
			case 'passChange':
                try{
                    $admin->changePassword($_POST);
                    $_SESSION['ok'] = $translate->getString('alert-passChnaged');
                    echo $_SESSION['ok'];
                }catch(Exception $e){
                    $_SESSION['errors'][] = $e->getMessage();
                }
                header("Location: profile.php");
			break;		
			
		}		

	} else {	
		include 'templates/profile.html.php';
	}

}else{
	header("Location: login.php");
}


?>