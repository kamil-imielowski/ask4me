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
    header("Location: dashboard-model.php");
}

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

	switch ($action) {
		case 'profile_page_form':
			try{
				$user->ProfilePageUpdate($_POST, $_FILES);
                $_SESSION['ok'] = $translate->getString('Form-ok');
                $_SESSION['user'] = base64_encode(serialize($user)); // aktualizacja usera w sesji
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "profile", time()+3600*24*365, '/');
			header("Location: /dashboard-user/");
			break;

		case 'changeUserAccSettings':
			try{
				if(isset($_POST['password']) && !empty($_POST['password'])){
					$user->changePassword($_POST);
					$_SESSION['ok'] = "<p>".$translate->getString("passChanged")."</p>";
				}
				if(isset($_POST['email']) && !empty($_POST['email'])){
					$user->changeEmail($_POST['email']);
					$_SESSION['ok'] .= $translate->getString("emailChanged-confirm");
				}
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "account-settings", time()+3600*24*365, '/');
			header("Location: dashboard-user.php");
			break;

		case 'delete_account':
			try{
				$user->deleteAcc();
				unset($_SESSION['user']);
				$_SESSION['ok'] = $translate->getString('delAccOK');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			header("Location: register.php");
			break;

		case 'notifySettings':
			try{
				$user->loadNotificationSettings();
				$user->getNotificationSettings()->saveToDB($_POST);
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "notification-settings", time()+3600*24*365, '/');
			header("Location: /dashboard-user");
			break;

		case 'invoiceDataForm':
			try{
				$user->loadInvoiceData();
				$user->getInvoiceData()->saveToDB($_POST);
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "membership", time()+3600*24*365, '/');
			header("Location: /dashboard-user");
			break;

		case 'changeRequestStatus':
			try{
				$request = new classes\Requests\Request($_GET['id']);
				switch($request->getType()){
					case 1:
					case 2:
						$request = new classes\Requests\PrivateActivityRequest($request->getFromUser(), $request->getToUser(), $request->getRealatedTableId());
						break;

					case 3:
						$request = new classes\Requests\EscortActivityRequest($request->getFromUser(), $request->getToUser(), $request->getRealatedTableId());
						break;
				}
				$request->changeStatus($_GET['status']);
				if($_GET['status'] == 2){
					$request->changeRequestToPlannedActivity();
				}
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e->getMessage();
			}
			setcookie('user_sideTab', "requests", time()+3600*24*365, '/');
			setcookie('collapse', "activity-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

	}
}else{
	include dirname(__FILE__).'/templates/dashboard-user.html.php';
}

?>