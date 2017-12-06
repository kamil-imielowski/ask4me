<?php namespace classes\Notification;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Notification{

	private $id;
	private $user;
	private $userId;
	private $type;
	private $dateCreated;

	function __construct($id=null){
	 	if($id!=null){
	 		$this->setId($id);
	 		$this->loadNotification();
	 	}
	}

	protected function saveToDB(array $data){
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		$translate = new \classes\Languages\Translate();
		if(!$database->insert("notifications", ['user_id' => $this->userId, 'type' => $data['type'], 'date_created' => $date])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}
		$this->setId($database->id());
	}

	private function loadNotification(){
		$database = dbCon();
		$sql = $database->select("notifications", '*', ['id' => $this->getId()]);
		$this->setType($sql[0]['type']);
		$this->setDateCreated($sql[0]['date_created']);

		$user = new \classes\User\User($sql[0]['user_id']);
		$this->setUser($user);
	}

	function dismissNotification(int $userId){
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		$translate = new \classes\Languages\Translate();
		if(!$database->insert("notifications_dismiss", ['user_id' => $userId, 'notification_id' => $this->id, 'date_created' => $date])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}
	}

	protected function setUserId(int $userId){$this->userId = $userId;}
	private function setId(int $id){$this->id = $id;}
	private function setType(int $type){$this->type = $type;}
	private function setUser(\classes\User\User $user){$this->user = $user;}
	private function setDateCreated($dateCreated){$this->dateCreated = $dateCreated;}


	function getId(){return $this->id;}
	function getType(){return $this->type;}
	function getUser(){return $this->user;}
	function getDateCreated(){return new \DateTime($this->dateCreated);}
}