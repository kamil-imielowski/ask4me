<?php namespace classes\Notification;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class NotificationsFactory{

	private $dismissNorifications;
	private $usersId; // follower users
	private $userId;
	private $notifications;
	private $notificationsGift;
	private $notificationsSettings;

	function __construct($userId=null){
		if(!empty($userId)){
			$this->setUserId($userId);

			$database = dbCon();
			$sql = $database->select("follows", 'following_id', ['follower_id'=>$userId]);
			$this->setUsersId($sql);

			$dismissNotifications = $database->select("notifications_dismiss", 'notification_id', ['user_id' => $userId]);
			$this->setDismissNotifications($dismissNotifications);

			$notificationsSettings = $database->select("user_notifications_settings", '*', ['user_id' => $userId]);
			$this->setNotificationsSettings($notificationsSettings[0]);
		}
	}

	function getNotificationsAll(){
			
		$notifications = array();
		$getNotifications = $this->getNotificationsGift();
		$notifications = array_merge($notifications, $getNotifications);

		$getNotifications = $this->getNotificationsActivity();
		$notifications = array_merge($notifications, $getNotifications);

		$getNotifications = $this->getNotificationsBlog();
		$notifications = array_merge($notifications, $getNotifications);

		$getNotifications = $this->getNotificationsPhoto();
		$notifications = array_merge($notifications, $getNotifications);

		$getNotifications = $this->getNotificationsNewProduct();
		$notifications = array_merge($notifications, $getNotifications);

		$getNotifications = $this->getNotificationsSoldProduct();
		$notifications = array_merge($notifications, $getNotifications);

		$getNotifications = $this->getNotificationsMessage();
		$notifications = array_merge($notifications, $getNotifications);

		$getNotifications = $this->getNotificationsFollowers();
		$notifications = array_merge($notifications, $getNotifications);

		usort($notifications, function($a, $b) {
            return $a->getDateCreated()->format("U") < $b->getDateCreated()->format("U");
        });

		return $notifications;
	}

	function getNotificationsGift(){
		$database = dbCon();
		$sql = array();
		if($this->notificationsSettings['ng'] == 1){
			if(!empty($this->dismissNotifications)){
				$sql = $database -> select("notification_gift", 'notification_id', ["user_id" => $this->userId]);
				$sql = $database -> select("notifications", '*', ["AND" => ['type' => 1, 'id'=>$sql, 'id[!]' => $this->dismissNotifications]]);
			}else{
				$sql = $database -> select("notification_gift", 'notification_id', ["user_id" => $this->userId]);
				$sql = $database -> select("notifications", '*', ["AND" => ['id' => $sql, 'type' => 1]]);
			}
		}
		$this->load($sql);
		return $this->getNotifications();
	}

	function getNotificationsActivity(){
		$database = dbCon();
		$sql = array();
		if($this->notificationsSettings['afuif'] == 1){
			if(!empty($this->dismissNotifications)){
				$sql = $database -> select("notifications", '*', ["AND" => ['user_id' => $this->usersId, 'type' => 2, 'id[!]' => $this->dismissNotifications]]);
			}else{
				$sql = $database -> select("notifications", '*', ["AND" => ['user_id' => $this->usersId, 'type' => 2]]);
			}
		}
		$this->load($sql);
		return $this->getNotifications();
	}

	function getNotificationsBlog(){
		$database = dbCon();
		$sql = array();
		if($this->notificationsSettings['afuif'] == 1){
			if(!empty($this->dismissNotifications)){
				$sql = $database -> select("notifications", '*', ["AND" => ['user_id' => $this->usersId, 'type' => 3, 'id[!]' => $this->dismissNotifications]]);
			}else{
				$sql = $database -> select("notifications", '*', ["AND" => ['user_id' => $this->usersId, 'type' => 3]]);
			}
		}
		$this->load($sql);
		return $this->getNotifications();
	}

	function getNotificationsPhoto(){
		$database = dbCon();
		$sql = array();
		if($this->notificationsSettings['afuif'] == 1){
			if(!empty($this->dismissNotifications)){
				$sql = $database -> select("notifications", '*', ["AND" => ['user_id' => $this->usersId, 'type' => 4, 'id[!]' => $this->dismissNotifications]]);
			}else{
				$sql = $database -> select("notifications", '*', ["AND" => ['user_id' => $this->usersId, 'type' => 4]]);
			}
		}
		$this->load($sql);
		return $this->getNotifications();
	}

	function getNotificationsNewProduct(){
		$database = dbCon();
		$sql = array();
		if($this->notificationsSettings['afuif'] == 1){
			if(!empty($this->dismissNotifications)){
				$sql = $database -> select("notifications", '*', ["AND" => ['user_id' => $this->usersId, 'type' => 5, 'id[!]' => $this->dismissNotifications]]);
			}else{
				$sql = $database -> select("notifications", '*', ["AND" => ['user_id' => $this->usersId, 'type' => 5]]);
			}
		}
		$this->load($sql);
		return $this->getNotifications();
	}

	function getNotificationsSoldProduct(){
		$database = dbCon();
		$sql = array();
		if($this->notificationsSettings['sp'] == 1){
			if(!empty($this->dismissNotifications)){
				$sql = $database -> select("notification_sold_product", 'notification_id', ["user_id" => $this->userId]);
				$sql = $database -> select("notifications", '*', ["AND" => ['type' => 6, 'id' => $sql, 'id[!]' => $this->dismissNotifications]]);
			}else{
				$sql = $database -> select("notification_sold_product", 'notification_id', ["user_id" => $this->userId]);
				$sql = $database -> select("notifications", '*', ["AND" => ['type' => 6, 'id' => $sql]]);
			}
		}
		$this->load($sql);
		return $this->getNotifications();
	}

	function getNotificationsMessage(){
		$database = dbCon();
		$sql = array();
		if($this->notificationsSettings['npw'] == 1){
			if(!empty($this->dismissNotifications)){
				$sql = $database -> select("notification_message", 'notification_id', ["user_id" => $this->userId]);
				$sql = $database -> select("notifications", '*', ["AND" => ['type' => 7, 'id'=>$sql, 'id[!]' => $this->dismissNotifications]]);
			}else{
				$sql = $database -> select("notification_message", 'notification_id', ["user_id" => $this->userId]);
				$sql = $database -> select("notifications", '*', ["AND" => ['id' => $sql, 'type' => 7]]);
			}
		}
		$this->load($sql);
		return $this->getNotifications();
	}

	function getNotificationsFollowers(){
		$database = dbCon();
		$sql = array();
		if($this->notificationsSettings['nf'] == 1){
			if(!empty($this->dismissNotifications)){
				$sql = $database -> select("notification_followers", 'notification_id', ["user_id" => $this->userId]);
				$sql = $database -> select("notifications", '*', ["AND" => ['type' => 8, 'id'=>$sql, 'id[!]' => $this->dismissNotifications]]);
			}else{
				$sql = $database -> select("notification_followers", 'notification_id', ["user_id" => $this->userId]);
				$sql = $database -> select("notifications", '*', ["AND" => ['type' => 8, 'id'=>$sql]]);
			}
		}
		$this->load($sql);
		return $this->getNotifications();
	}

	private function load($sql){
		$notifications = array();
		if(!empty($sql)){
			foreach($sql as $k){
				switch ($k['type']) {
					case 1:
						$notifications[] = new NotificationGift($k['id']);
						break;

					case 2:
						$notifications[] = new NotificationActivity($k['id']);
						break;

					case 3:
						$notifications[] = new NotificationBlog($k['id']);
						break;

					case 4:
						$notifications[] = new NotificationPhoto($k['id']);
						break;

					case 5:
						$notifications[] = new NotificationNewProduct($k['id']);
						break;

					case 6:
						$notifications[] = new NotificationSoldProduct($k['id']);
						break;

					case 7:
						$notifications[] = new NotificationMessage($k['id']);
						break;

					case 8:
						$notifications[] = new NotificationsFollowers($k['id']);
						break;
				}
			}
		}
		$this->setNotifications($notifications);
	}

	private function setUsersId($usersId){
		$this->usersId = $usersId;
	}

	private function setNotifications($notifications){
		$this->notifications = $notifications;
	}

	private function getNotifications(){
		return $this->notifications;
	}

	private function setDismissNotifications($dismissNotifications){
		$this->dismissNotifications = $dismissNotifications;
	}

	private function setNotificationsSettings($notificationsSettings){
		$this->notificationsSettings = $notificationsSettings;
	}

	private function setUserId($userId){
		$this->userId = $userId;
	}

}