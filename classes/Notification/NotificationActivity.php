<?php namespace classes\Notification;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class NotificationActivity extends Notification{
	function __construct($id=null){
		if($id!=null){
			parent::__construct($id);
		}
	}

	function saveToDB($userId){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		parent::setUserId($userId);
		parent::saveToDB(array("type"=>2));
		if(!$database->insert("notification_new_activity", ['notification_id' => parent::getId()])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}
	}
}