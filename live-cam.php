<?php
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate($_COOKIE['lang']);

///////////////////////////
//                       //
// public broadcast only //
//                       //
///////////////////////////

if(isset($_SESSION['user'])){
    $user = unserialize(base64_decode($_SESSION['user']));  
}

if (isset($_POST['action']) || isset($_GET['action'])) {
    $action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    switch ($action) {
        case '':

            break;
    }
} else {
    try{
        $broadcaster = new \classes\User\ModelUser(null, $_GET['nick']);
        $broadcaster->loadCountry();
        $transmission = new \classes\Transmissions\Transmission($broadcaster);
        unset($broadcaster);
    }catch(Exception $e){
        $_SESSION['errors'][] = $e->getMessage();
        setcookie('user_sideTab', "planned", time()+3600*24*365, '/');
        setcookie('collapse', "activity-content", time()+3600*24*365, '/');
        if(isset($_SERVER['HTTP_REFERER'])){
            header("Location: ".$_SERVER['HTTP_REFERER']);
        }else{
            header("Location: /home");
        }
        exit();
    }
    include dirname(__FILE__).'/templates/live-cam.html.php';
}
