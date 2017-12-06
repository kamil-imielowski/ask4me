<?php
session_start();
include dirname(__FILE__).'/sessionToVerb4Alerts.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

if(isset($_SESSION['admin'])){
	$customersPage = true;

	if(isset($_POST['action']) || isset($_GET['action'])){
			
		$action = empty($_POST['action']) ? $_GET['action'] : $_POST['action'];
					
		switch ($action) {

            case 'delete':
                /* try{
                    $category = new classes\Categories\Category($_GET['id']);
                    $category->deleteFromDB();
                    $_SESSION['ok'] = "";
                }catch(Exception $e){
                    $_SESSION['errors'][] = $e->getMessage();
                }
                header("Location: categories.php"); */
                break;

            case 'ban':
                try{
                    $user = new \classes\User\User($_GET['id']);
                    $user->banUser();
                }catch(Exception $e){
                    $_SESSION['errors'][] = $e->getMessage();
                }
                header("Location: customers.php");
                break;
            
            case 'unBan':
                try{
                    $user = new \classes\User\User($_GET['id']);
                    $user->unBanUser();
                }catch(Exception $e){
                    $_SESSION['errors'][] = $e->getMessage();
                }
                header("Location: customers.php");
                break;
			
		}		

	} else {	
        $CF = new classes\User\UserFactory();
        $customers = $CF->getUsers();
		include 'templates/customers.html.php';
	}

}else{
	header("Location: login.php");
}


?>