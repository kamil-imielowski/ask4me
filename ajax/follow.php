<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new \classes\Languages\Translate();
try{
    $user = unserialize(base64_decode($_SESSION['user']));
    $followingUser = new \classes\User\User($_POST['followingUserId']);
    if($user->getId() === $followingUser->getId()){
        throw new Exception($translate->getString("cantFollowYourself"));
    }
    $user->follow($followingUser);
}catch(Exception $e){
    echo $e->getMessage();
}