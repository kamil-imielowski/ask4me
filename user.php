<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate();

if(isset($_SESSION['user'])){
    $user = unserialize(base64_decode($_SESSION['user']));
}

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

    switch ($action) {
        case '':

            break;
    }
}else{
    if(isset($_GET['nick'])){
        try{
            $profileCustomer = new classes\User\StandardUser(null, $_GET['nick']);
            $profileCustomer->loadCountry();
            $wishlistProducts = new \classes\User\WishlistFactory($_GET['nick']);
            $CF = new classes\Categories\CategoriesFactory();
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
        include dirname(__FILE__).'/templates/user.html.php';
    }else{
        header("Location: /home");
    }
}

?>