<?php namespace classes\Message;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Message{

	private $id;
	private $userFrom;
	private $userTo;
	private $message;
	private $dateCreated;
	private $readed;

	function __construct($id=null, $message = array()){
		if(!empty($id)){
			$this->setId($id);
			if(!empty($message)){
				$this->setUserFrom($message['user_from']);
				$this->setUserTo($message['user_to']);
				$this->setMessage($message['message']);
				$this->setDateCreated($message['date_created']);
				$this->setReaded($message['readed']);
			}
		}
	}

	function saveMessage($from, $to, $message){
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		echo $message;
		if(!$database->insert('messages', [
											'user_id_from' => $from,
											'user_id_to' => $to,
											'message' => $message,
											'date_created' => $date
		]))
		{	
			$translate = new \classes\Languages\Translate();
			throw new \Exception($translate->getString("error-DBInsert"));
		}
	}

	function markAsRead(){
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		$database->update('messages', ['readed'=>1, 'date_updated'=>$date], ['id' => $this->id]);
	}

	function deleteMessage(){
		$database = dbCon();
		$database->delete("messages", ['id' => $this->id]);
	}

	private function setId(int $id){
		$this->id = $id;
	}

	private function setUserTo(\classes\User\User $userTo){
		$this->userTo = $userTo;
	}

	private function setUserFrom(\classes\User\User $userFrom){
		$this->userFrom = $userFrom;
	}

	private function setMessage(string $message){
		$this->message = $message;
	}

	private function setDateCreated(\DateTime $dateCreated){
		$this->dateCreated = $dateCreated;
	}

	private function setReaded(int $readed){
		$this->readed = $readed;
	}

	function getId(){return $this->id;}
	function getUserFrom(){return $this->userFrom;}
	function getUserTo(){return $this->userTo;}
	function getMessage(){return $this->message;}
	function getDateCreated(){return $this->dateCreated;}
	function getReaded(){return $this->readed;}


}