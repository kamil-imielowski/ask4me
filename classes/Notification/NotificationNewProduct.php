<?php namespace classes\Notification;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class NotificationNewProduct extends Notification{

	private $product;

	function __construct($id=null){
		if($id!=null){
			parent::__construct($id);
			$this->loadProduct();
		}
	}

	function saveToDB(array $data){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		parent::setUserId($data['user_id']);
		parent::saveToDB(array("type"=>5));
		if(!$database->insert("notification_new_product", ['notification_id' => parent::getId(), 'product_id' => $data['product_id']])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}
		$user = new \classes\User\User($data['user_id']);
		$user->addCountNotification();
	}

	private function loadProduct(){
		$database = dbCon();
		$sql = $database -> select("notification_new_product", 'product_id', ['notification_id' => parent::getId()]);

		$product = new \classes\Product\Product($sql[0]);
		$this->setProduct($product);
	}

	private function setProduct(\classes\Product\Product $product){
		$this->product = $product;
	}

	function getProduct(){
		return $this->product;
	}
} 