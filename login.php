<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
include_once dirname(__FILE__).'/displayErrors.php';
$translate = new classes\Languages\Translate($_COOKIE['lang']);

if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

	switch ($action) {
		case 'referer':
			if(isset($_SERVER['HTTP_REFERER'])){
				setcookie('referer',$_SERVER['HTTP_REFERER'],time()+60*20,'/');
			}
			header("Location: /login");
			break;
		case 'login':
			try{
				$user = new classes\User\User();
				$user->login($_POST);
				#okreslenie jaka klasa zalogowanego usera - z tej klasy jest dostep do klasy user wiec bez problemu :)
				if($user->getType() == 1){
					$user = new classes\User\StandardUser($user->getId());
				}elseif($user->getType() == 2){
					$user = new classes\User\ModelUser($user->getId());
				}

				$_SESSION['user'] = base64_encode(serialize($user));
			}catch(Exception $e){
				$_SESSION['errors'][] = $e -> getMessage();
				$_SESSION['data'] = $_POST;
				header("Location: /login");
				exit();
			}
			
			if(isset($_COOKIE['referer'])){
				setcookie('referer',$_SESSION['HTTP_REFERER'],time()+60*20,'/');
				$referer = $_COOKIE['referer'];
				header("Location: ".$referer);
			}else{
				header("Location: /home");
			}
			break;

		case 'logout':
			unset($_SESSION['user']);
			setcookie('remember', null, time() - 1, "/");;
			header("Location: /home");
			break;
	}
}else{
	$data = isset($_SESSION['data']) ? $_SESSION['data'] : '';
	include dirname(__FILE__).'/templates/login.html.php';
}

?>