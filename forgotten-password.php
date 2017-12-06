<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate();

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    switch($action){

        case 'setNewPassword':
            if(!isset($_GET['id']) && !isset($_GET['control'])){
                header("Location: login.php");
            }   
            include dirname(__FILE__).'/templates/set-new-password.html.php';
        break;

        case 'setNewPasswordRequest':
            try{
                $user = new classes\User\User($_POST['id']);
                $user->resetPassword($_POST);
                $_SESSION['ok'] = $translate->getString("passChanged");
            }catch(Exception $e){
                $_SESSION['errors'][] = $e->getMessage();
                header("Location: forgotten-password.html.php?action=setNewPassword&id=".$_POST['id'].'&control='.$_POST['control']);
                break;
            }
            header("Location: login.php");
        break;

        case 'sendRequest-passChange':
            try{
                $user = new classes\User\User();
                $user->remeberPassword($_POST['email']);
                $_SESSION['ok'] = $translate->getString("passResetSend");
            }catch(Exception $e){
                $_SESSION['errors'][] = $e->getMessage();
                header("Location: forgotten-password.php");
                break;
            }
            header("Location: login.php");
        break;
    }

}else{
    include dirname(__FILE__).'/templates/forgotten-password.html.php';

}

?>