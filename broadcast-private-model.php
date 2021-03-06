<?php
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate();
 
$user = unserialize(base64_decode($_SESSION['user']));  

if (isset($_POST['action']) || isset($_GET['action'])) {
    $action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    switch ($action) {
        case 'start':
            try{          
                $activity = new \classes\PlannedActivities\PrivatePlannedActivities($user->getId(), $_GET['type'],$_GET['id']);
                $transmission = new classes\Transmissions\Transmission();
                $transmission->__create($activity);
            }catch(Exception $e){
                echo $e->getMessage();
                $_SESSION['errors'][] = $e->getMessage();
            }
            header("location: private-broadcast/".$user->getLogin());
            break;

        case 'end':
            try{
                $transmission = new \classes\Transmissions\Transmission($user);
                $transmission->__stop();
                $_SESSION['ok'] = $translate->getString("broadcastEnd");
            }catch(Exception $e){
                $_SESSION['errors'][] = $e->getMessage();
            }
            setcookie('user_sideTab', "planned", time()+3600*24*365, '/');
            setcookie('collapse', "activity-content", time()+3600*24*365, '/');
            header("Location: /dashboard-model");
            exit();
            break;
    }
} else {
    try{
        $transmission = new \classes\Transmissions\Transmission($user);
        $partner =  $transmission->getActivity()->getInvitedUser()->getId() == $user->getId() ? $transmission->getActivity()->getUser() : $transmission->getActivity()->getInvitedUser();
    }catch(Exception $e){
        $_SESSION['errors'][] = $e->getMessage();
        setcookie('user_sideTab', "planned", time()+3600*24*365, '/');
        setcookie('collapse', "activity-content", time()+3600*24*365, '/');
        header("Location: /dashboard-model");
        exit();
    }
    include dirname(__FILE__).'/templates/broadcast-private-model.html.php';
}

?>