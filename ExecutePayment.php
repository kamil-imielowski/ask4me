<?php
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

if(isset($_GET['success'])){
	if($_GET['success'] == 'true' && isset($_GET['orderId'])){
		try{
			$payment = new \classes\Payment\Payment($_GET['orderId']);
			$payment->uploadPaymentStatus();
		}catch(Exception $e){
			$_SESSION['errors'][] = $e -> getMessage();
		}
		header("Location: order-complete.php");
	}else{
		$_SESSION['errors'][] = $translate->getString("somethingWrong");
		header("Location: order-complete.php");
	}
}else{
	header("Location: /home");
}