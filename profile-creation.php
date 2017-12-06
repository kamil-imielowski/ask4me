<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate();

if(!isset($_SESSION['user'])){
    if(isset($_SERVER['HTTP_REFERER'])){
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }else{
        header("Location: index.php");
    }
}
$user = unserialize(base64_decode($_SESSION['user']));
if($user->getType() == 2){
    header("Location: /home");
}

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

	switch ($action) {
		case 'become-model':
			try{
				$user->becomeModel($_POST);
				$_SESSION['user'] = base64_encode(serialize($user));
			}catch(Exception $e){
				echo $_SESSION['errors'][] = $e -> getMessage();
				header("Location: profile-creation.php");
				exit();
			}
			header("Location: profile-created.php");
			break;
	}

}else{
	try{
        $CF = new classes\Country\CountriesFactory();
        $countries = $CF->getCountries();
    }catch(Exception $e){
        $_SESSION['errors'][] = $e->getMessage();
    }
	include dirname(__FILE__).'/templates/profile-creation.html.php';
}

?>