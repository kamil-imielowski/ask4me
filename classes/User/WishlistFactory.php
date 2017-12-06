<?php namespace classes\User;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class WishlistFactory{

	private $id;
	private $products;
	private $userLogin;

	function __construct($userLogin){
		$this->setUserLogin($userLogin);
		$this->loadWishlist();
	}

	private function loadWishlist(){
		$database = dbCon();
		$products = array();
		$sql = array();
		$sql = $database->select("customers", 'id', ['login' => $this->userLogin]);
		$sql = $database -> select("user_wishlist", 'product_id', ['user_id' => $sql[0]]);
		foreach($sql as $k){
			$products[] = new \classes\Product\Product($k);
		}

		$this->setProducts($products);
	}


	private function setUserLogin($userLogin){$this->userLogin = $userLogin;}
	private function setProducts($products){$this->products = $products;}

	function getProducts(){return $this->products;}

}