<?php namespace classes\Gift;

class GiftsFactory{

	private $userId;
	private $gifts;

	function __construct($userId=null){
		if($userId != null){
			$this->setUserId($userId);
			$this->loadGifts();
		}
	}

	function loadSentGifts(){
		$database = dbCon();
		$sql = array();
		$gifts=array();
		$sql = $database->select("gifts", 'id', ['sender_user_id' => $this->userId]);
		foreach($sql as $k){
			$gifts[] = new Gift($k);
		}
		$this->setGifts($gifts);
	}

	private function loadGifts(){
		$database = dbCon();
		$sql = array();
		$gifts = array();
		$sql = $database->select("gifts", 'id', ['receiving_user_id' => $this->userId]);
		foreach($sql as $v){
			$gifts[] = new Gift($v);
		}

		$this->setGifts($gifts);
	}

	private function setUserId($userId){$this->userId = $userId;}
	private function setGifts($gifts){$this->gifts = $gifts;}

	function getGifts(){return $this->gifts;}
}