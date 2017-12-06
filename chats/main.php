<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

try{
    $chat = new \classes\Chat\ChatToFile($_POST['transmissionId']."-".$_POST['type'].".txt");
    $chat->updateFile($_POST['user'], $_POST['message']);
    echo "saved";
}catch(Exception $e){
    echo $e->getMessage();
}