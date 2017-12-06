<?php
session_start();
require_once dirname(__FILE__).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();

include_once dirname(__FILE__).'/displayErrors.php';

if(isset($_SESSION['user'])){
    $user = unserialize(base64_decode($_SESSION['user']));
}


if(isset($_POST['action']) || isset($_GET['action'])){
	$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

	switch ($action) {
		case 'search':
			$userFind = new \classes\User\UserFactory();
			$standardUsers = $userFind->getStandardUsersByString($_POST['search']);
			$modelUsers = $userFind->getModelUsersByString($_POST['search']);

			$blogs = new \classes\Blog\BlogsFactory();
			$blogs = $blogs->getBlogsByString($_POST['search']);

			$products = new \classes\Product\ProductsFactory();
			$products = $products->getProductsByString($_POST['search']);
			include dirname(__FILE__).'/templates/search.html.php';
			break;
	}

}else{
	header("Location: /home");
}


?>