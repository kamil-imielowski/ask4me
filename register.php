<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate();

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    switch($action){

        case 'model':
            try{
                $CF = new classes\Country\CountriesFactory();
                $countries = $CF->getCountries();
            }catch(Exception $e){
                $_SESSION['errors'][] = $e->getMessage();
            }
            $data = isset($_SESSION['data']) ? $_SESSION['data'] : '';
            include dirname(__FILE__).'/templates/register-model.html.php';
            break;

        case 'register_model':
            try{
                $user = new classes\User\ModelUser();
                $user->register($_POST);
            }catch(Exception $e){
                $_SESSION['errors'][] = $e -> getMessage();
                $_SESSION['data'] = $_POST;
                header("Location: /register/model");
                exit();
            }
            header("Location: /home");
            break;
        
        case 'register_standard':
            try{
                $user = new classes\User\StandardUser();
                $user->register($_POST);
            }catch(Exception $e){
                $_SESSION['errors'][] = $e -> getMessage();
                $_SESSION['data'] = $_POST;
                header("Location: /register");
                exit();
            }
            header("Location: registration-successful.php?login=".$_POST['login']);
            
            break;

        case 'activate-user':
            if(!isset($_GET['activeCode']) && !isset($_GET['id'])){
                header("Location: /login");
            }
            try{
                $user = new classes\User\User($_GET['id']);
                $user->activeUser($_GET['activeCode']);
                $_SESSION['ok'] = $translate->getString("actived");
            }catch(Exception $e){
                $_SESSION['errors'][] = $e->getMessage();
            }
            header("Location: /login");
            break;

        case 'resend':
            try{
                $user = new classes\User\User($_GET['user_id']);
                $user->sendActivationEmail();
                $_SESSION['ok'] = $translate->getString('resendOK');
            }catch(Exception $e){
                $_SESSION['errors'][] = $e->getMessage();
            }
            if(!isset($_SERVER['HTTP_REFERER'])){
                header("Location: ".$_SERVER['HTTP_REFERER']);
            }else{
                header("Location: /login");
            }
        break;

        case 'resendFromLogin':
            try{
                $user = new classes\User\User(null, $_GET['login']);
                $user->sendActivationEmail();
                $_SESSION['ok'] = $translate->getString('resendOK');
            }catch(Exception $e){
                $_SESSION['errors'][] = $e->getMessage();
            }
            if(!isset($_SERVER['HTTP_REFERER'])){
                header("Location: ".$_SERVER['HTTP_REFERER']);
            }else{
                header("Location: /login");
            }
            break;

        case 'confirm-new-email':
            try{
                if(isset($_SESSION['user'])){
                    $user = unserialize(base64_decode($_SESSION['user']));
                    if($_GET['id'] != $user->getId()){
                        throw new Exception($translate->getString('badRequest'));
                    }
                    $user->newEmailConfirm($_GET['code']);
                    $_SESSION['user'] = base64_encode(serialize($user));
                    $_SESSION['ok'] = $translate->getString("emailChanged");
                }else{
                    $_SESSION['errors'][] = $translate->getString('mustLogIn');
                    header("Location: /login");
                    break;
                }
            }catch(Exception $e){
                $_SESSION['errors'][] = $e->getMessage();
            }
            if($user->getType() == 1){
                setcookie('user_sideTab', "account-settings", time()+3600*24*365, '/');
                header("Location: /dashboard-user");
            }elseif($user->getType == 2){
                header("Location: /dashboard-model");
            }
        break;
    }

}else{
    $data = isset($_SESSION['data']) ? $_SESSION['data'] : '';
    include dirname(__FILE__).'/templates/register.html.php';

}

?>