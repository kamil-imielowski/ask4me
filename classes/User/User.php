<?php namespace classes\User;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class User{

	protected $id;
	private $email;
	private $login;
	private $name;
	private $surname;
	private $type;
	private $sex;
	private $active;
	private $banned;
	private $profilePicture;
	private $categories;
	private $overview;
	private $notificationSettings;
	private $tokens;
	private $membership;
	private $invoiceData;
	protected $countryIsoCode2;
	private $country;
	private $wishlist;
	private $unreadedNotification;

	function __construct($id=null, $nick=null){
		if($id != null){
			$this->id = $id;
			$this->loadUser();
		}

		//ladowanie usera po nicku
		if(empty($id) && !empty($nick)){
			$database = dbCon();
			$translate = new \classes\Languages\Translate();
			if(!$database->has("customers", ["login" => $nick])){
				throw new \Exception($translate->getString("userDExist"));
			}else{ 
				$id = $database->select("customers", 'id', ["login" => $nick]);
				$this->id = $id[0];
				$this->loadUser();
			}
		}
	}

	private function loadUser(){
		$database = dbCon();
		$sql = $database -> select("customers", '*', ['id' => $this->id]);
		foreach($sql as $k){
			$this->setId($k['id']);
			$this->setEmail($k['email']);
			$this->setLogin($k['login']);
			$this->setName($k['name']);
			$this->setSurname($k['surname']);
			$this->setType($k['type']);
			$this->setSex($k['sex']);
			$this->setActive($k['active']);
			$this->setBanned($k['banned']);
			$this->setProfilePicture(new \classes\Photo\Photo($k['profile_picture'], "user-profile"));
			$this->setOverview($k['overview']);
			$this->setTokens($k['tokens']);
			$this->setCountryIsoCode2($k['country']);
			$this->setUnreadedNotification($k['unreaded_notification']);
		}

		#users to categories -- mozna kioedys przeniesc narazie laduje przy starcie 
		$this->setCategories();
		// membership to samo
		$this->setMembership();
	}

	function login($data){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		if($database -> has("customers", ["AND" =>['email' => $data['email'], 'password' => md5($data['password'])]])){
			$customer = $database -> select("customers", '*', ['email' => $data['email']]);
			if($customer[0]['active'] == 0){
				throw new \Exception($translate->getString("notActive").' <a href="register.php?action=resend&user_id='.$customer[0]['id'].'">'.$translate->getString("reSendActiv").'</a>');
			}
			if($customer[0]['banned'] == 1){
				throw new \Exception($translate->getString("bannedAcc"));
			}
			$this->setId($customer[0]['id']);
			$this->loadUser();

			if(isset($data['forgot'])){
				$code = uniqid();
				$database->update("customers", ['auto_login_code' => $code], ['id' => $this->id]);
				setcookie('remember', $code, time() + (86400 * 30), "/");
			}

			$database->update("customers", ["last_login_date" => date("Y-m-d H:i:s")], ["id" => $this->id]);
		}else{
			throw new \Exception($translate->getString("error-login"));
		}
		
	}

	function autoLogin($code){
		$database = dbCon();
		$user = $database -> select("customers", '*', ['auto_login_code' => $code]);
		if(!empty($user)){
			$this->setId($user[0]['id']);
			$this->loadUser();
			return true;
		}else{
			return false;
		}
	}

	function sendActivationEmail(){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();

		$sql = $database->select("customers", '*', ["id" => $this->id]);
		$code = $sql[0]['activ_code'];
		$email = $sql[0]['email'];
		$login = $sql[0]['login'];

		//read email content
        ob_start();
        require(dirname(dirname(dirname(__FILE__))).'/mails/active-account.html.php');
        $mailContent = ob_get_clean();

        $mail = new \PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($translate->getString('sendAddressRegister'), $translate->getString('fromNameRegister'));
        $mail->addReplyTo($translate->getString('noReplyAddress'), $translate->getString('fromNameRegister'));
        $mail->addAddress($email, $login);
        $mail->Subject = $translate->getString('activateMailSubject');
        $mail->msgHTML( $mailContent ); 

        if (!$mail->send()) {
            throw new \Exception($translate->getString("emailError"));
        } else {
            return true;
        }
	}

	function remeberPassword($email){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		if(!$database->has("customers", ["email" => $email])){
			throw new \Exception($translate->getString("userDExist"));
		}
		$sql = $database->select("customers", '*', ["email" => $email]);
		$user_id = $sql[0]['id'];
		$controlResetPassword = base64_encode($email.date("Y-m-d H:i:s"));

		if(!$database->update("customers", ["password" => $controlResetPassword], ["email" => $email])){
			throw new \Exception($translate->getString("error-DBUpdate"));
		}

		ob_start();
        require(dirname(dirname(dirname(__FILE__))).'/mails/remeber-password.html.php');
        $mailContent = ob_get_clean();

        $mail = new \PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($translate->getString('sendAddressResetPass'), $translate->getString('fromNameResetPass'));
        $mail->addReplyTo($translate->getString('noReplyAddress'), $translate->getString('fromNameResetPass'));
        $mail->addAddress($email);
        $mail->Subject = $translate->getString('resetPassMailSubject');
        $mail->msgHTML( $mailContent ); 

        if (!$mail->send()) {
            throw new \Exception($translate->getString("emailError"));
        } else {
            return true;
        }
	}
	function resetPassword($data){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		if(empty($data['new_password']) || ctype_space($data['new_password'])){
            throw new \Exception($translate->getString("passwordRequired"));
        }
		if($data['new_password'] != $data['r_new_password']){
			throw new \Exception($translate->getString("error-notSame"));
		}
		if(!$database->has("customers", ["AND" => ["id" => $data['id'], "password" => $data['control']]])){
			throw new \Exception($translate->getString("badRequest"));
		}
		if(!$database->update("customers", ["password" => md5($data['new_password'])], ["id" => $data['id']])){
			throw new \Exception($translate->getString("error-DBUpdate"));
		}	
	}
	function changePassword($data){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		if(!$database->has("customers", ["AND" => ["id" => $this->getId(), "password" => md5($data['password'])] ])){
			throw new \Exception($translate->getString("incorrectPassword"));
		}
		if($data['password'] === $data['npass']){
			throw new \Exception($translate->getString("error-npeop"));
		}
		if($data['npass'] !== $data['rnpass']){
			throw new \Exception($translate->getString("error-notSame"));
		}
		if(strlen($data['npass']) < 8){
			throw new \Exception($translate->getString("error-passMinChar"));
		}
		if(!$database->update("customers", ["password" => md5($data['npass'])], ["id" => $this->getId()])){
			throw new \Exception($translate->getString('error-DBUpdate'));
		}
	}
	function changeEmail($email){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		if($database->has("customers", ["email" => $email])){
			throw new \Exception($translate->getString("isset-email"));
		}
		$code = uniqid();
		if(!$database->insert("tmp_users_mails", ["user_id" => $this->getId(), "email" => $email, "code" => $code])){
			throw new \Exception($translate->getString('error-DBInsert'));
		}

		ob_start();
        require(dirname(dirname(dirname(__FILE__))).'/mails/confirm-new-email.html.php');
        $mailContent = ob_get_clean();

        $mail = new \PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($translate->getString('confirmNewEmail-sendAdress'), $translate->getString('confirmNewEmail-fromName'));
        $mail->addReplyTo($translate->getString('noReplyAddress'), $translate->getString('confirmNewEmail-fromName'));
        $mail->addAddress($email);
        $mail->Subject = $translate->getString('confirmNewEmail-subject');
        $mail->msgHTML( $mailContent ); 

        if (!$mail->send()) {
            throw new \Exception($translate->getString("emailError"));
        } else {
            return true;
        }
	}
	function newEmailConfirm($code){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		$sql = $database->select("tmp_users_mails", '*', ["AND" => ["user_id" => $this->getId(), "code" => $code]]);
		if(empty($sql)){
			throw new \Exception($translate->getString('badRequest'));
		}
		$email = $sql[0]['email'];
		if(!$database->delete("tmp_users_mails" , ["email" => $email])){
			throw new \Exception($translate->getString('error-DBUpdate'));
		}
		if(!$database->update("customers", ["email" => $email], ["id" => $this->getId()])){
			throw new \Exception($translate->getString('error-DBUpdate'));
		}
		$this->setEmail($email);
	}

	function activeUser($code){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		if(!$database->has("customers", ["AND" => ["id" => $this->id, "activ_code" => $code] ])){
			throw new \Exception($translate->getString("badRequest"));
		}
		if(!$database->update("customers", ["active" => 1], ["id" => $this->id])){
			throw new \Exception($translate->getString("error-DBUpdate"));
		}
	}

	function banUser(){
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		if(!$database -> update("customers", ['banned' => 1, 'date_updated' => $date], ['id' => $this->id])){
			throw new \Exception($translate->getString("error-DBUpdate"));
		}
	}

	function unBanUser(){
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		if(!$database -> update("customers", ['banned' => 0, 'date_updated' => $date], ['id' => $this->id])){
			throw new \Exception($translate->getString("error-DBUpdate"));
		}
	}

	function addCountNotification(){
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		if(!$database->update("customers", ["unreaded_notification[+]"=>1, 'date_updated'=>$date], ['id' => $this->id])){
			throw new \Exception($translate->getString("error-DBUpdate"));
		}
		$this->setUnreadedNotification($this->unreadedNotification+1);
	}

	function resetCountNotification(){
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		if($database->update("customers", ["unreaded_notification"=>0, 'date_updated'=>$date])){
			throw new \Exception($translate->getString("error-DBUpdate"));
		}
		$this->setUnreadedNotification(0);
	}

	protected function addProfilePicture($image){
		$photo = new \classes\Photo\Photo();
		$photo->upload($image, '/img/customers/');
		$database = dbCon();
		if(!$database->update("customers", ["profile_picture" => $photo->getId()], ["id" => $this->id])){
			$translate = new \classes\Languages\Translate();
			throw new \Exception($translate->getString('image-upload-error'));
		}
		$this->setProfilePicture($photo);
	}

	protected function userToCategories($categories){
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		if(!empty($categories)){
			foreach($categories as $categoryId){
				if(!$database->has("users_to_categories", ["AND" => ["user_id" => $this->id, "category_id" => $categoryId] ])){
					if(!$database->insert("users_to_categories", ["user_id" => $this->id, "category_id" => $categoryId])){
						throw new \Exception($translate->getString('error-DBInsert'));
					}
				}
			}

			$sql = $database->select("users_to_categories", '*', ["user_id" => $this->id]);
			foreach($sql as $v){
				if(!in_array($v['category_id'] , $categories)){
					if(!$database->delete("users_to_categories", ["id" => $v['id']])){
						throw new \Exception($translate->getString('error-DBUpdate'));
					}
				}
			}
		}
		$this->setCategories();
	}

	protected function updateGender($gender){
		$database = dbCon();
		if(!$database->has("customers", ["AND" => ["id" => $this->getId(), "sex" => $gender] ])){
			if(!$database->update("customers", ["sex" => $gender], ["id" => $this->getId()])){
				$translate = new \classes\Languages\Translate();
				throw new \Exception($translate->getString('error-DBUpdate'));
			}
		}
		$this->setSex($gender);
	}
	protected function updateOverView($overview){
		$database = dbCon();
		if(!$database->has("customers", ["AND" => ["id" => $this->getId(), "overview" => $overview] ])){
			if(!$database->update("customers", ["overview" => $overview], ["id" => $this->getId()])){
				$translate = new \classes\Languages\Translate();
				throw new \Exception($translate->getString('error-DBUpdate'));
			}
		}
		$this->setOverview($overview);
	}

	function loadNotificationSettings(){
		$notificationSettings = new \classes\User\NotifySettings($this->getId());
		$this->setNotificationSettings($notificationSettings);
	}

	function updateTokens(int $amount){
		$database = dbCon();
		if($amount <= -1){
			if(($this->getTokens() + $amount) < 0){
				$translate = new \classes\Languages\Translate();
				throw new \Exception($translate->getString("notEnoughTokens"));
			}
		}
		if(!$database->update("customers", ["tokens[+]" => $amount], ["id" => $this->getId()])){
			$translate = new \classes\Languages\Translate();
			throw new \Exception($translate->getString("error-DBUpdate"));
		}
		$this->setTokens($this->getTokens() + $amount);
	}

	protected function setId($id){$this->id = $id;}
	private function setEmail($email){$this->email = $email;}
	private function setLogin($login){$this->login = $login;}
	protected function setName($name){$this->name = $name;}
	protected function setSurname($surname){$this->surname = $surname;}
	protected function setType($type){$this->type = $type;}
	protected function setSex($sex){$this->sex = $sex;}
	private function setActive($active){$this->active = $active;}
	private function setBanned($banned){$this->banned = $banned;}
	private function setProfilePicture(\classes\Photo\Photo $photo){$this->profilePicture = $photo;}
	private function setOverview($overview){$this->overview = $overview;}
	private function setCategories(){
		$database = dbCon();
		$sql = $database->select("users_to_categories", '*', ["user_id" => $this->id]);
		$categories = array();
		if(!empty($sql)){
			foreach($sql as $v){
				$categories[] = $v['category_id'];
			}
		}
		$this->categories = $categories;
	}
	private function setWishlist($wishlist){
		$this->wishlist = $wishlist;
	}
	private function setNotificationSettings(NotifySettings $notificationSettings){
		$this->notificationSettings = $notificationSettings;
	}
	private function setTokens($tokens){
		$this->tokens = $tokens;
	}
	private function setMembership(){
		$membership = new \classes\Membership\Membership($this->getId());
		$this->membership = $membership;
	}
	private function setCountryIsoCode2($countryIsoCode2){
		$this->countryIsoCode2 = $countryIsoCode2;
	}
	protected function getCountryIsoCode2(){
		return $this->countryIsoCode2;
	}

	private function setUnreadedNotification(int $unreadedNotification){
		$this->unreadedNotification = $unreadedNotification;
	}

	function getId(){return $this->id;}
	function getEmail(){return $this->email;}
	function getLogin(){return $this->login;}
	function getName(){return $this->name;}
	function getSurname(){return $this->surname;}
	function getType(){return $this->type;}
	function getSex(){return $this->sex;}
	function getGender(){
		$translate = new \classes\Languages\Translate();
		switch($this->getSex()){
			case 1:
				return $translate->getString("female");
				break;

			case 2:
				return $translate->getString("male");
				break;

			case 3:
				return $translate->getString("transgender");
				break;
		}
	}
	function getActive(){return $this->active;}
	function getBanned(){return $this->banned;}
	function getProfilePicture(){return $this->profilePicture;}
	function getCategories(){return $this->categories;}
	function getOverview(){return $this->overview;}
	function getWishlist(){return $this->wishlist;}
	function getNotificationSettings(){
		return $this->notificationSettings;
	}
	function getTokens(){
		return $this->tokens;
	}
	function getMembership(){
		
		return $this->membership;
	}

	function loadInvoiceData(){
		$this->invoiceData = new \classes\Invoices\InvoiceData($this->getId());
	}
	function getInvoiceData(){
		return $this->invoiceData;
	}
	function getUnreadedNotification(){
		return $this->unreadedNotification;
	}

	function follow(User $followingUser){ //unfollow tez
		$database = dbCon();
		$translate = new \classes\Languages\Translate();
		if($database->has("follows", ["AND" => ["follower_id" => $this->getId() , "following_id" => $followingUser->getId()]])){
			//unfollow
			if(!$database->delete("follows", ["AND" => ["follower_id" => $this->getId() , "following_id" => $followingUser->getId()]])){
				throw new \Exception($translate->getString("error-DBDelete"));
			}
		}else{
			//follow
			if(!$database->insert("follows", ["follower_id" => $this->getId() , "following_id" => $followingUser->getId(), "date_created" => date("Y-m-d H:i:s")])){
				throw new \Exception($translate->getString("error-DBInsert"));
			}
			//notification
			$data = array("user_id"=>$this->getId(), "following_user_id"=>$followingUser->getId());
	        $notification = new \classes\Notification\NotificationsFollowers();
	        $notification->saveToDB($data);
		}
	}

	function amIFollower(User $followingUser){
		$database = dbCon();
		if($database->has("follows", ["AND" => ["follower_id" => $this->getId() , "following_id" => $followingUser->getId()]])){
			return true;
		}
		return false;
	}

	function loadCountry(){
        $country = new \classes\Country\Country($this->getCountryIsoCode2());
        $this->setCountry($country);
    }
    function getCountry(){
        return $this->country;
    }
    private function setCountry(\classes\Country\Country $country){
        $this->country = $country;
	}
	
	function visitProfile(User $visitedUser){
		$database = dbCon();
		if($this->getMembership()->getType()==2){
			return;
		}
		if($this->getId() !== $visitedUser->getId()){
			if(!$database->has("visites_profiles", ["AND" => [ "visitor_id" => $this->getId(), "visited_id" => $visitedUser->getId()]])){
				if(!$database->insert("visites_profiles", ["visitor_id" => $this->getId(), "visited_id" => $visitedUser->getId(), "visit_date" => date("Y-m-d H:i:s")])){
					//throw new \Exception("dupa");
				}
			}else{
				if(!$database->update("visites_profiles", ["visit_date" => date("Y-m-d H:i:s")], ["AND" =>[ "visitor_id" => $this->getId(), "visited_id" => $visitedUser->getId()]])){
					//throw new \Exception("dupa");
				}
			}
			
		}
	}

	//z home-page do wyświetlania
	function changeFollowerView($id){
		$database = dbCon();
		if(!$database->update("follows", ["view" => 2], ["id" => $id])){
			$translate = new \classes\Languages\Translate();
			throw new \Exception($translate->getString("error-DBUpdate"));
		}
	}

	function countFollowers(){
		$database = dbCon();
		return $database->count("follows", ["following_id" => $this->getId()]);
	}

	function addToWishList(\classes\Product\Product $product){//also deleting
		$database = dbCon();
		$date = date("Y-m-d H:i:s");
		if($database->has("user_wishlist", ["AND" => ['product_id' => $product->getId(), 'user_id' => $this->id]])){
			if(!$database->delete("user_wishlist", ["AND" => ['product_id' => $product->getId(), 'user_id' => $this->id]])){
				//throw new \Exception("dupa");
			}
		}else{
			if(!$database->insert("user_wishlist", ['product_id' => $product->getId(), 'user_id' => $this->id, 'date_created'=>$date])){
				//throw new \Exception("dupa");
			}
		}
	}

	function loadWishlist(){
		$database = dbCon();
		$wishlist = $database -> select("user_wishlist", 'product_id', ['user_id' => $this->id]);
		$this->setWishlist($wishlist); 
	}

}