<?php namespace classes\Order;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class OrdersFactory{

	private $userId;
	private $orders;
	private $soldProductsOrder;

	function __construct($userId){
		$this->setUserId($userId);
		$this->loadOrders();
	}

	function loadSoldProductsOrder(){
		$database = dbCon();
		$sql = array();
		$orders = array();
		$sql = $database->select("user_products", 'product_id', ['user_id' => $this->userId]);
		$sql = $database->select("order_info", 'order_id', ['product_id' => $sql]);
		if(!empty($sql)){
			foreach($sql as $k){
				$orders[] = new Order(null, $k);
			}
		}
		
		$this->setSoldProductsOrder($orders);
	}

	private function loadOrders(){
		$database = dbCon();
		$sql = array();
		$orders = array();
		$sql = $database -> select("orders", 'id', ['user_id' => $this->userId, 'payment'=>1]);

		foreach ($sql as $key) {
			$orders[] = new Order(null, $key);
		}
		$this->setOrders($orders);
	}

	private function setUserId($userId){$this->userId = $userId;}
	private function setOrders($orders){$this->orders = $orders;}
	private function setSoldProductsOrder($soldProductsOrder){$this->soldProductsOrder = $soldProductsOrder;}

	function getOrders(){return $this->orders;}
	function getSoldProductsOrder(){return $this->soldProductsOrder;}
}