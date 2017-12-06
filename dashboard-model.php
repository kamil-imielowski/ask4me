<?php
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate($_COOKIE['lang']);

if(!isset($_SESSION['user'])){
    if(isset($_SERVER['HTTP_REFERER'])){
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }else{
        header("Location: index.php");
    }
}
$user = unserialize(base64_decode($_SESSION['user']));
if($user->getType() == 1){
    header("Location: dashboard-user.php");
}

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

	switch ($action) {
		case 'introduction':
			try{
				$user->introductionUpdate($_POST, $_FILES);
                $_SESSION['ok'] = $translate->getString('Form-ok');
                $_SESSION['user'] = base64_encode(serialize($user)); // aktualizacja usera w sesji
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "introduction", time()+3600*24*365, '/');
			setcookie('collapse', "profile-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;
		
		case 'gallery':
			try{
				if(isset($_FILES['video']['name']) && !empty($_FILES['video']['name'][0])){
					$user->addVideo($_FILES['video']);
				}
				if(isset($_FILES['default-video']['name']) && !empty($_FILES['default-video']['name'][0])){
					$user->addDefaultVideo($_FILES['default-video']);
				}
				if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'][0])){
					$user->addImage($_FILES['image']);
				}
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "gallery", time()+3600*24*365, '/');
			setcookie('collapse', "profile-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

		case 'delete_video':
			try{
				$video = new \classes\Video\Video($_GET['id']);
				$video->deleteVideo();
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}

			setcookie('user_sideTab', "gallery", time()+3600*24*365, '/');
			setcookie('collapse', "profile-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

		case 'delete_photo':
			try{
				$photo = new \classes\Photo\Photo($_GET['id']);
				$photo->deletePhoto();
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}

			setcookie('user_sideTab', "gallery", time()+3600*24*365, '/');
			setcookie('collapse', "profile-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

		case 'notifySettings':
			try{
				$user->loadNotificationSettings();
				$user->getNotificationSettings()->saveToDB($_POST);
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "notification-settings", time()+3600*24*365, '/');
			setcookie('collapse', "account-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

		case 'invoiceDataForm':
			try{
				$user->loadInvoiceData();
				$user->getInvoiceData()->saveToDB($_POST);
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "membership", time()+3600*24*365, '/');
			setcookie('collapse', "account-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
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
			setcookie('collapse', "account-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;
		
		case 'socialMedia':
			try{
				$user->socialMediaUpdate($_POST);
				$_SESSION['user'] = base64_encode(serialize($user)); // aktualizacja usera w sesji
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "media", time()+3600*24*365, '/');
			setcookie('collapse', "profile-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

		case 'categoriesAndServices':
			try{
				$user->categoriesAndServicesUpdate($_POST);
				$_SESSION['user'] = base64_encode(serialize($user)); // aktualizacja usera w sesji
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "categories", time()+3600*24*365, '/');
			setcookie('collapse', "profile-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;
		
		case 'uploadBlog':
			try{
				$user->uploadBlog($_POST, $_FILES['img']);
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "blog", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

		case 'updateBlog':
			try{
				$user->uploadBlog($_POST, $_FILES['img']);
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "blog", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;
		case 'deleteBlog':
			try{
				$user->deleteBlog($_GET['id']);
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
			}
			setcookie('user_sideTab', "blog", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

		case 'saveLooks':
			try{
				$user->saveLooks($_POST);
				$_SESSION['user'] = base64_encode(serialize($user)); // aktualizacja usera w sesji
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e->getMessage();
			}
			setcookie('user_sideTab', "looks", time()+3600*24*365, '/');
			setcookie('collapse', "profile-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

		case 'model_availability':
			try{
				$availability = new classes\User\ModelAvailability($user->getId());
				$availability->saveToDB($_POST['day']);
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e->getMessage();
			}
			setcookie('user_sideTab', "availability", time()+3600*24*365, '/');
			setcookie('collapse', "activity-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

		case 'modelDasPricesActivity':
			try{
				#insert / update
				if(isset($_POST['escort'])){
					foreach($_POST['escort'] as $data){
						$id = isset($data['id']) ? $data['id'] : null;
						$escort = new classes\ActivityPrices\Escort($user->getId(), $id);
						$escort->saveToDB($data);
						unset($escort);
					}
				}
				if(isset($_POST['public'])){
					foreach($_POST['public'] as $data){
						$id = isset($data['id']) ? $data['id'] : null;
						switch($data['type']){
							case '1':
								$publicDoSTH = new classes\ActivityPrices\PublicDoSTH($user->getId(), $id);
								$publicDoSTH->saveToDB($data);
								unset($publicDoSTH);
								break;

							case '2':
								$publicVote = new classes\ActivityPrices\PublicVote($user->getId(), $id);
								$publicVote->saveToDB($data);
								unset($publicVote);
								break;
						}
					}
				}
				if(isset($_POST['private'])){
					foreach($_POST['private'] as $data){
						$id = isset($data['id']) ? $data['id'] : null;
						$privatePerformance = new classes\ActivityPrices\PrivatePerformance($user->getId(), $id);
						$privatePerformance->saveToDB($data);
						unset($privatePerformance);
					}
				}

				#usuwanie zaznaczonych
				if(isset($_POST['delete']['escort'])){
					foreach($_POST['delete']['escort'] as $id){
						$escort = new classes\ActivityPrices\Escort($user->getId(), $id);
						$escort->deleteFromDB();
						unset($escort);
					}
				}
				if(isset($_POST['delete']['publicVote'])){
					foreach($_POST['delete']['publicVote'] as $id){
						$publicVote = new classes\ActivityPrices\PublicVote($user->getId(), $id);
						$publicVote->deleteFromDB();
						unset($publicVote);
					}
				}
				if(isset($_POST['delete']['publicDoSTH'])){
					foreach($_POST['delete']['publicDoSTH'] as $id){
						$publicDoSTH = new classes\ActivityPrices\PublicDoSTH($user->getId(), $id);
						$publicDoSTH->deleteFromDB();
						unset($publicDoSTH);
					}
				}
				if(isset($_POST['delete']['private'])){
					foreach($_POST['delete']['private'] as $id){
						$privatePerformance = new classes\ActivityPrices\PrivatePerformance($user->getId(), $id);
						$privatePerformance->deleteFromDB();
						unset($privatePerformance);
					}
				}
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e->getMessage();
			}
			setcookie('user_sideTab', "pricing", time()+3600*24*365, '/');
			setcookie('collapse', "activity-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

		case 'dashboardPlanActivity':
			try{
				switch($_POST['type']){
					case '1':
						$PPA = new \classes\PlannedActivities\PublicPlannedActivities($user->getId(), isset($_POST['activityId']) ? $_POST['activityId'] : null);
						$PPA->saveToDB(array_merge(["date" => $_POST['date']], $_POST['public']));
						$_SESSION['ok'] = $translate->getString('Form-ok');
						setcookie('user_sideTab', "planned", time()+3600*24*365, '/');
						setcookie('collapse', "activity-content", time()+3600*24*365, '/');
						break;

					case '2':
						$invitedUser = new \classes\User\User(null, $_POST['privateChat']['username']);
						//$PPA = new \classes\PlannedActivities\PrivatePlannedActivities($user->getId(), 2, isset($_POST['activityId']) ? $_POST['activityId'] : null);
						//$PPA->saveToDB(array_merge(["date" => $_POST['date'], "invitedUserId" => $invitedUser->getId(), "privateType" => 1], $_POST['privateChat']));
						$request = new classes\Requests\PrivateActivityRequest($user, $invitedUser);
						$request->saveToDB(array_merge(["date" => $_POST['date'], "type" => 1, "status" => 1], $_POST['privateChat']));
						$_SESSION['ok'] = $translate->getString("requestSended");
						setcookie('user_sideTab', "requests", time()+3600*24*365, '/');
						setcookie('collapse', "activity-content", time()+3600*24*365, '/');
						break;

					case '3':
						$invitedUser = new \classes\User\User(null, $_POST['privateCam']['username']);
						//$PPA = new \classes\PlannedActivities\PrivatePlannedActivities($user->getId(), 3, isset($_POST['activityId']) ? $_POST['activityId'] : null);
						//$PPA->saveToDB(array_merge(["date" => $_POST['date'], "invitedUserId" => $invitedUser->getId(), "privateType" => 2], $_POST['privateCam']));						
						$request = new classes\Requests\PrivateActivityRequest($user, $invitedUser);
						$request->saveToDB(array_merge(["date" => $_POST['date'], "type" => 2, "status" => 1], $_POST['privateCam']));
						$_SESSION['ok'] = $translate->getString("requestSended");
						setcookie('user_sideTab', "requests", time()+3600*24*365, '/');
						setcookie('collapse', "activity-content", time()+3600*24*365, '/');
						break;

					case '4':
						$invitedUser = new \classes\User\User(null, $_POST['escort']['username']);
						//$PPA = new \classes\PlannedActivities\EscortPlannedActivities($user->getId(), isset($_POST['activityId']) ? $_POST['activityId'] : null);
						//$PPA->saveToDB(array_merge(["date" => $_POST['date'], "invitedUserId" => $invitedUser->getId()], $_POST['escort']));
						$request = new classes\Requests\EscortActivityRequest($user, $invitedUser);
                        $request->saveToDB(array_merge(["date" => $_POST['date'], "type" => 3, "status" => 1], $_POST['escort']));
						$_SESSION['ok'] = $translate->getString("requestSended");
						setcookie('user_sideTab', "requests", time()+3600*24*365, '/');
						setcookie('collapse', "activity-content", time()+3600*24*365, '/');
						break;
				}
			}catch(Exception $e){
				$_SESSION['errors'][] = $e->getMessage();
			}
			header("Location: /dashboard-model");
			break;

		case 'deletePlannedActivity':
			try{
				$plannedActivity = new \classes\PlannedActivities\PlannedActivities($user->getId(), $_GET['type'], $_GET['plannedActivityId']);
				$plannedActivity->deleteFromDB();
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e->getMessage();
			}
			setcookie('user_sideTab', "planned", time()+3600*24*365, '/');
			setcookie('collapse', "activity-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

		
		case 'uploadProduct':
			try{
				if(!isset($_POST['id'])){
					$product = new classes\Product\Product();
					$product -> uploadProduct($_POST, $_FILES);
					$user->addUserProduct($product->getId());
				}else{
					$product = new classes\Product\Product($_POST['id']);
					$product -> uploadProduct($_POST, $_FILES);
				}
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e->getMessage();
			}
			setcookie('user_sideTab', "store", time()+3600*24*365, '/');
			header("Location: dashboard-model.php");
			break;
		case 'deleteProduct':
			try{
				$product = new classes\Product\Product($_GET['id']);
				$product -> deleteProduct();
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e->getMessage();
			}
			setcookie('user_sideTab', "store", time()+3600*24*365, '/');
			header("Location: dashboard-model.php");
			break;

		case 'purchases':
			setcookie('user_sideTab', "purchases", time()+3600*24*365, '/');
			header("Location: dashboard-model.php");
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

		case 'editRequest':
			try{
				$modelUser = new classes\User\User($_POST['id']);
				switch($_POST['type']){
					case '1':
						$request = new classes\Requests\PrivateActivityRequest($modelUser, $user, $_POST['related_id']);
						$request->saveToDB(array_merge(["date" => $_POST['date'], "type" => $_POST['type']], $_POST['privateChat']));
						break;

					case '2':
						$request = new classes\Requests\PrivateActivityRequest($modelUser, $user, $_POST['related_id']);
						$request->saveToDB(array_merge(["date" => $_POST['date'], "type" => $_POST['type']], $_POST['privateCam']));
						break;

					case '3':
						$request = new classes\Requests\EscortActivityRequest($modelUser, $user, $_POST['related_id']);
						$request->saveToDB(array_merge(["date" => $_POST['date'], "type" => $_POST['type'], "status" => 4, "view" => 1], $_POST['escort']));
						break;
				}
				$request->changeStatus(4);
				$_SESSION['ok'] = $translate->getString("requestSended");
			}catch(Exception $e){
				$_SESSION['errors'][] = $e->getMessage();
			}
			setcookie('user_sideTab', "requests", time()+3600*24*365, '/');
			setcookie('collapse', "activity-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;

		case 'dashboardPlanAndStartPublicActivity':
			try{
				$PPA = new \classes\PlannedActivities\PublicPlannedActivities($user->getId(), isset($_POST['activityId']) ? $_POST['activityId'] : null);
				$PPA->saveToDB(array_merge(["date" => $_POST['date']], $_POST['public']));
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e->getMessage();
				setcookie('user_sideTab', "start", time()+3600*24*365, '/');
				setcookie('collapse', "activity-content", time()+3600*24*365, '/');
				header("Location: /dashboard-model");
				exit();
			}
			header("Location: /broadcast.php?action=start&id=".$PPA->getPlannedActivityId());
			break;

		case 'withdrawTokens':
			try{
				$user->withdrawTokens($_POST);
				$_SESSION['user'] = base64_encode(serialize($user)); // aktualizacja usera w sesji
				$_SESSION['ok'] = $translate->getString('Form-ok');
			}catch(Exception $e){
				$_SESSION['errors'][] = $e->getMessage();
			}
			setcookie('user_sideTab', "get-paid", time()+3600*24*365, '/');
			setcookie('collapse', "account-content", time()+3600*24*365, '/');
			header("Location: /dashboard-model");
			break;
	}
}else{
	include dirname(__FILE__).'/templates/dashboard-model.html.php';
}


?>