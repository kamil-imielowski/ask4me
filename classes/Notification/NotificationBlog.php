<?php namespace classes\Notification;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class NotificationBlog extends Notification{
	
	private $blog;

	function __construct($id=null){
		if($id!=null){
			parent::__construct($id);
			$this->loadBlog();
		}
	}

	function saveToDB(array $data){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		parent::setUserId($data['user_id']);
		parent::saveToDB(array("type"=>3));
		if(!$database->insert("notification_new_blog", ['notification_id' => parent::getId(), 'blog_id' => $data['blog_id']])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}
		$user = new \classes\User\User($data['user_id']);
		$user->addCountNotification();
	}

	private function loadBlog(){
		$database = dbCon();
		$sql = $database -> select("notification_new_blog", 'blog_id', ['notification_id' => parent::getId()]);

		$blog = new \classes\Blog\Blog($sql[0]);
		$this->setBlog($blog);
	}

	private function setBlog(\classes\Blog\Blog $blog){
		$this->blog = $blog;
	}

	function getBlog(){
		return $this->blog;
	}
}