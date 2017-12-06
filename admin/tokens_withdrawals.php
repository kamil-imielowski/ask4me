<?php
session_start();
include dirname(__FILE__).'/sessionToVerb4Alerts.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

if(isset($_SESSION['admin'])){
	$tokensWithdrawsPage = true;

	if(isset($_POST['action']) || isset($_GET['action'])){
			
		$action = empty($_POST['action']) ? $_GET['action'] : $_POST['action'];
					
		switch ($action) {

            case 'updatePayment':
                try{
                    $withdrawal = new \classes\Withdrawal\Withdrawal($_GET['id']);
                    $withdrawal->updatePayment();
                    $_SESSION['ok'] = $translate->getString('Form-ok');
                }catch(Exception $e){
                    $_SESSION['errors'][] = $e->getMessage();
                }
                header("Location: tokens_withdrawals.php");
                break;
			
		}		

	} else {	
        $withdrawals = new \classes\Withdrawal\WithdrawalsFactory();
        $withdrawals = $withdrawals->getWithdrawals();
		include 'templates/tokens_withdrawals.html.php';
	}

}else{
	header("Location: login.php");
}


?>