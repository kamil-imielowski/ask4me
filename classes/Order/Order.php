<?php namespace classes\Order;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Order{
	
	private $id;
	private $userId;
	private $totalPrice;
	private $date;
	private $products;
	private $userCustomer;


	function __construct($userId=null, $orderId = null){
		if($userId != null){
			$this->setUserId($userId);
		}
		if($orderId != null){
			$this->setId($orderId);
			$this->loadOrder();
		}
	}

	function saveOrder($data){
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		$translate = new \classes\Languages\Translate();

		$prices = $database -> select("products", 'price', ['id' => $data['products']]);
		$total_price = array_sum($prices);

		$type_product = $database->select("products", 'type', ['id' => $data['products'][0]]);
		if($type_product[0] == 4){//user products, token payment
			$user = new \classes\User\User($this->userId);
			$user->updateTokens($total_price * (-1));
			$payment = 1;
		}else{
			$payment = 1;
		}

		if(!$database ->insert("orders", [
											'user_id' => $this->userId,
											'total_price' => $total_price,
											'payment' => $payment,
											'date' => $date
		]))
		{
			throw new \Exception($translate->getString("error-DBInsert"));
		}
		$this->setId($database->id());
		$this->setTotalPrice($total_price);

		foreach($data['products'] as $product_id){
			if(!$database -> insert("order_info", ['order_id' => $this->id, 'product_id' => $product_id])){
				throw new \Exception($translate->getString("error-DBInsert"));
			}
			if($type_product[0] == 4){//user products, token payment
				//notification
				$sql = $database->select("user_products", 'user_id', ['product_id' => $product_id]);
		        $data = array("user_id"=>$this->userId, "product_id" => $product_id, "user_id_owner_product" => $sql[0]);
		        $notification = new \classes\Notification\NotificationSoldProduct();
		        $notification->saveToDB($data);

		        $sqlq = $database->select("products", 'price', ['id'=>$product_id]);
		        $user = new \classes\User\User($sql[0]);
				$user->updateTokens(round($sqlq[0]*0.9));
		    }
		}
	}

	private function loadOrder(){
		$database = dbCon();
		$sql = $database -> select("orders", '*', ['id' => $this->id]);
		$user = new \classes\User\User($sql[0]['user_id']);
		$this->setUserId($sql[0]['user_id']);
		$this->setUserCustomer($user);
		$this->setDate($sql[0]['date']);
		$this->setTotalPrice($sql[0]['total_price']);

		$sql = array();
		$products = array();
		$sql = $database -> select("order_info", 'product_id', ['order_id' => $this->id]);
		foreach($sql as $k){
			$products[] = new \classes\Product\Product($k);
		}

		$this->setProducts($products);
	}

	private function setUserId($userId){$this->userId = $userId;}
	private function setId($id){$this->id = $id;}
	private function setDate($date){$this->date = $date;}
	private function setTotalPrice($totalPrice){$this->totalPrice = $totalPrice;}
	private function setProducts($products){$this->products = $products;}
	private function setUserCustomer($userCustomer){$this->userCustomer = $userCustomer;}

	function getId(){return $this->id;}
	function getUserId(){return $this->userId;}
	function getDate(){return date("d-m-Y", strtotime($this->date));}
	function getTotalPrice(){return $this->totalPrice;}
	function getProducts(){return $this->products;}
	function getUserCustomer(){return $this->userCustomer;}
}
