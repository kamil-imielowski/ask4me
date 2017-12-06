<?php
session_start();
include dirname(__FILE__).'/sessionToVerb4Alerts.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

if(isset($_SESSION['admin'])){
	$productsPage = true;

	if(isset($_POST['action']) || isset($_GET['action'])){
			
		$action = empty($_POST['action']) ? $_GET['action'] : $_POST['action'];
					
		switch ($action) {
			case 'delete':
				$product = new \classes\Product\Product($_GET['id']);
				$product->deleteProduct();
				header("Location: products.php");
				break;

			case 'editTokens':
				$product = new \classes\Product\Product($_GET['id']);
				include 'templates/tokens-edit.html.php';
				break;

			case 'add':
				include 'templates/product-add.html.php';
				break;

			case 'uploadProduct':
				try{
					if(isset($_POST['id'])){
						$product = new \classes\Product\Product($_POST['id']);
						$product->uploadAdminProduct($_POST, $_FILES);
					}else{
						$product = new \classes\Product\Product();
						$product->uploadAdminProduct($_POST, $_FILES);
					}
				}catch(Exception $e){
					$_SESSION['errors'][] = $e->getMessage();
				}
				header("Location: products.php");
				break;

			case 'membership':
				$basic = new \classes\Product\ProductsFactory(1);
				$vip = new \classes\Product\ProductsFactory(2);
				include 'templates/membership.html.php';
				break;

			case 'uploadMembership':
				try{
					$product = new \classes\Product\Product();
					$product->uploadMembership($_POST, $_FILES);
				}catch(Exception $e){
					$_SESSION['errors'][] = $e->getMessage();
				}
				header("Location: products.php?action=membership");
				break;

			case 'tokens':
				$tokens = new \classes\Product\ProductsFactory(3);
				include 'templates/tokens.html.php';
				break;

			case 'uploadTokens':
				try{
					if(!isset($_POST['id'])){
						$product = new \classes\Product\Product();
						$product->uploadTokens($_POST, $_FILES);
					}else{
						$product = new \classes\Product\Product($_POST['id']);
						$product->uploadTokens($_POST, $_FILES);
					}
				}catch(Exception $e){
					$_SESSION['errors'][] = $e->getMessage();
				}
				break;
		}		

	} else {
		$products = new \classes\Product\ProductsFactory();	
		include 'templates/products.html.php';
	}

}else{
	header("Location: login.php");
}


?>