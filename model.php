<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate($_COOKIE['lang']);

if(isset($_SESSION['user'])){
    $user = unserialize(base64_decode($_SESSION['user']));
}

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    switch ($action) {
        case 'bookModelForm':
            try{
                $modelUser = new classes\User\ModelUser($_POST['id']);
                switch($_POST['type']){
                    case '1':
                        $request = new classes\Requests\PrivateActivityRequest($user, $modelUser);
                        $request->saveToDB(array_merge(["date" => $_POST['date'], "type" => $_POST['type'], "status" => 1], $_POST['privateChat']));
                        break;

                    case '2':
                        $request = new classes\Requests\PrivateActivityRequest($user, $modelUser);
                        $request->saveToDB(array_merge(["date" => $_POST['date'], "type" => $_POST['type'], "status" => 1], $_POST['privateCam']));
                        break;

                    case '3':
                        $request = new classes\Requests\EscortActivityRequest($user, $modelUser);
                        $request->saveToDB(array_merge(["date" => $_POST['date'], "type" => $_POST['type'], "status" => 1], $_POST['escort']));
                        break;
                }
                $_SESSION['ok'] = $translate->getString("requestSended");
            }catch(Exception $e){
                $_SESSION['errors'][] = $e->getMessage();
            }
            header("location: ".$_SERVER['HTTP_REFERER']);
            break;

        case 'galleryPage':
            setcookie('model_profil', "gallery", time()+3600*24*365, '/model');
            header("Location: /model/".$_GET['login']);
            break;
    }
}else{
    if(isset($_GET['nick'])){
        try{
            $profileCustomer = new classes\User\ModelUser(null, $_GET['nick']);
            $profileCustomer->loadCountry();
            $profileCustomer->loadAvailability();
            $profileCustomer->loadSocialMedia();
            $profileCustomer->loadRecentActivity();
            if(isset($user)){
                $user->visitProfile($profileCustomer);
            }
        }catch(Exception $e){
            $_SESSION['errors'][] = $e->getMessage();
            if(isset($_SERVER['HTTP_REFERER'])){
                header("location: ".$_SERVER['HTTP_REFERER']);
            }else{
                header("location: /home");
            }
            exit();
        }
        include dirname(__FILE__).'/templates/model.html.php';
    }else{
        header("Location: /home");
    }
}

?>