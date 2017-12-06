<?php namespace classes\Notification;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class NotificationGift extends Notification{
	
	function __construct($id=null){
		if($id!=null){
			parent::__construct($id);
		}
	}

	function saveToDB(array $data){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		parent::setUserId($data['user_id']);
		parent::saveToDB(array("type"=>1));
		if(!$database->insert("notification_gift", ['notification_id' => parent::getId(), 'user_id' => $data['receiving_user_id']])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}
		$user = new \classes\User\User($data['receiving_user_id']);
		$user->addCountNotification();
	}
}