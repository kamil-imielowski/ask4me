<?php 
session_start();
require_once dirname(dirname(dirname(__FILE__))).'/displayErrors.php';
require_once dirname(dirname(dirname(__FILE__))).'/vendor/autoload.php';

if(!isset($_POST['action']) && !isset($_GET['action'])){
    http_response_code(400);
    die("400 Bad Request");
}

$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

switch($action){

	case 'saveAdminSettings':
		try{
			$settings = new \classes\Settings\Setting($_POST['key']);
			$settings->saveSetting($_POST['value']);
		}catch(Exception $e){
			echo $e->getMessage();
		}
		break;


    default:
        http_response_code(400);
        die("400 Bad Request");
        break;
}


?>