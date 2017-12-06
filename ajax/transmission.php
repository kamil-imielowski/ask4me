<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

if(!isset($_POST['action']) && !isset($_GET['action'])){
    http_response_code(400);
    die("400 Bad Request");
}

$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];
$translate = new classes\Languages\Translate($_COOKIE['lang']);

switch($action){

    case 'update_activity':
        try{
            $user = unserialize(base64_decode($_SESSION['user']));  
            $transmission = new \classes\Transmissions\Transmission($user);
            $transmission->updateActivity();
            $result[] = true;
        }catch(Exception $e){
            $result[] = $e->getMessage();
        }
        echo json_encode($result);
        break;

    default:
        http_response_code(400);
        die("400 Bad Request");
        break;
}