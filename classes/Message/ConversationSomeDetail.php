<?php namespace classes\Message;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class ConversationSomeDetail{

	private $user;
	private $readed;
	private $lastMessage;
	private $lastDateMessage;

	function __construct(\classes\User\User $user){
		$this->user = $user;
		$this->loadConversation();
	}

	private function loadConversation(){
		$database = dbCon();
		if($database->has("messages", ["AND" => ['user_id_from'=>$this->user->getId(), 'readed'=>0]])){
			$this->readed = 0;
		}else{
			$this->readed = 1;
		}

	}

	function getUser(){return $this->user;}
	function getReaded(){return $this->readed;}
}