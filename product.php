<?php 
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
$translate = new classes\Languages\Translate($_COOKIE['lang']);

include_once dirname(__FILE__).'/displayErrors.php';
$product = new \classes\Product\Product($_GET['id']);
if(!isset($_GET['name']) || $_GET['name'] != $product->getURLName()){
    header("Location: /home");
    exit();
}
if($product->getType() == 4){
	$user = new \classes\User\ModelUser($product->getUserProduct()->getId());
	$products = new \classes\Product\ProductsFactory(null, $user->getLogin());
}else{
	$products = new \classes\Product\ProductsFactory();
	$products -> loadMembershipAndTokens();
}
include dirname(__FILE__).'/templates/product.html.php';

?>