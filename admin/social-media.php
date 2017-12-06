<?php
session_start();
include dirname(__FILE__).'/sessionToVerb4Alerts.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

if(isset($_SESSION['admin'])){
	$settingsPage = true;
	$socialMediaPage = true;

	if(isset($_POST['action']) || isset($_GET['action'])){
			
		$action = empty($_POST['action']) ? $_GET['action'] : $_POST['action'];
					
		switch ($action) {

            case 'form-edit-add':
                try{
                    $socialMedia = new classes\SocialMedia\SocialMedia();
                    $socialMedia->saveToDB($_POST);
                    $_SESSION['ok'] = $translate->getString('updated');
                }catch(Exception $e){
                    $_SESSION['errors'][] = $e->getMessage();
                }
                header("Location: social-media.php");
            break;
			
		}		

	} else {	
        $socialMedia = new classes\SocialMedia\SocialMedia;
		include 'templates/social-media.html.php';
	}

}else{
	header("Location: login.php");
}


?>