<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate();

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    switch ($action) {
        case 'value':
            # code...
            break;
    }
}else{
    if(isset($_GET['nick'])){
        try{
            $profileCustomer = new classes\User\ModelUser(null, $_GET['nick']);
            $profileCustomer->loadCountry();
            $profileCustomer->loadAvailability();
            $profileCustomer->loadSocialMedia();
        }catch(Exception $e){
            $_SESSION['errors'][] = $e->getMessage();
            header("location: /home");
            exit();
        }
        include dirname(__FILE__).'/templates/model-room.html.php';
    }else{
        header("Location: /home");
    }
}

?>