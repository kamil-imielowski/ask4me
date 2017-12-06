<?php namespace classes\User;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
include_once dirname(dirname(dirname(__FILE__))).'/functions/generateCode.php';

class StandardUser extends User{
    private $lookingFor;
    private $services;
    private $profileVisibility;
  
    function __construct($id=null, $nick=null){
        parent::__construct($id, $nick);
        if(!empty($id)){
            $this->loadStandarUser();
        }
    }

    private function loadStandarUser(){
        $database = dbCon();
        $sql = $database->select("user_standard_info", '*', ["user_id" => parent::getId()]);
        if(!empty($sql)){
            foreach($sql as $v){
                $this->setLookingFor($v['looking_for']);
                $this->setServices($v['services']);
                $this->setProfileVisibility($v['profile_visibility']);
            }
        }
    }

    function becomeModel($data){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate();

        if(empty($data['name']) || ctype_space($data['name'])){
            throw new \Exception($translate->getString("nameRequired"));
        }
        if(!isset($data['terms'])){
            throw new \Exception($translate->getString("regulationsRequired"));
        }
        if($data['sex'] <= 0 || $data['sex'] > 3){
            throw new \Exception($translate->getString("sex-required"));
        }
        if(!isset($data['country']) || empty($data['country'])){
            throw new \Exception($translate->getString("country-required"));
        }

        if(!$database->update("customers",[
                                            'name' => $data['name'],
                                            'surname' => $data['surname'],
                                            'type' => 2,
                                            'sex' => $data['sex'],
                                            'country' => $data['country'],
                                            'date_updated' => $date
        ], ['id' => parent::getId()]))
        {
            throw new \Exception($translate->getString("error-DBUpdate"));
        }
        parent::setType(2);
        parent::setSex($data['sex']);

        $database->insert("hear_about", ["user_id" => parent::getId(), "answer" => $data['hear'], "date_created" => $date]);
        //init required tables
        if(!$database->insert("user_model_info", ['user_id' => parent::getId(), 'date_created' => $date])){
            throw new \Exception($translate->getString("error-DBInsert"));
        }
    }

    function register($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        if(empty($data['email']) || ctype_space($data['email'])){
            throw new \Exception($translate->getString("emailRequired"));
        }
        if(empty($data['login']) || ctype_space($data['login'])){
            throw new \Exception($translate->getString("loginRequired"));
        }
        if(!preg_match('/^(?=[a-z]{2})(?=.{4,26})(?=[^.]*\.?[^.]*$)(?=[^_]*_?[^_]*$)[\w.]+$/iD', $data['login'])){
            throw new \Exception($translate->getString("unexpectedChars"));
        }
        if(empty($data['password']) || ctype_space($data['password'])){
            throw new \Exception($translate->getString("passwordRequired"));
        }
        if($database -> has("customers", ['email' => $data['email']])){
            throw new \Exception($translate->getString("isset-email"));
        }
        if($database -> has("customers", ['login' => $data['login']])){
            throw new \Exception($translate->getString("isset-login"));
        }
        if($data['password'] !== $data['re_password']){
            throw new \Exception($translate->getString("error-notSame"));
        }
        if(strlen($data['password']) < 8){
            throw new \Exception($translate->getString("passwordTooShort"));
        }
        if(!isset($data['check1'])){
            throw new \Exception($translate->getString("regulationsRequired"));
        }
        if(!isset($data['check2'])){
            throw new \Exception($translate->getString("adultRequired"));
        }
        $code = generateCode(7);
        if(!$database -> insert("customers",[
                                            "login" => $data['login'],
                                            "email" => $data['email'],
                                            "password" => md5($data['password']),
                                            "type" => 1,
                                            "activ_code" => $code,
                                            "active" => 0,
                                            "date_created" => date("Y-m-d H:i:s"),

        ]))
        {
            throw new \Exception($translate->getString("error-DBInsert"));
        }
        
        parent::setId($database->id());
        parent::sendActivationEmail();

        //init required tables
        if(!$database->insert("user_notifications_settings", ["user_id" => parent::getId(), "date_created" => date("Y-m-d H:i:s")])){
            throw new \Exception($translate->getString("error-DBInsert"));
        }
    }

    function ProfilePageUpdate($data, $image){
        if(!empty($image['profile']['tmp_name'])){
            parent::addProfilePicture($image['profile']);
        }
        parent::userToCategories($data['categories']);
        parent::updateGender($data['sex']);
        parent::updateOverView($data['overview']);

        $translate = new \classes\Languages\Translate();
        $database = dbCon();
        $date = date("Y-m-d H:i:s");

        ## WAŻNE: jak już będzie członkostwo sprawdzac przed zmiana profile_visibility

        if(!$database->has("user_standard_info", ["user_id" => parent::getId()])){
            if(!$database->insert("user_standard_info", [   "user_id"           => parent::getId(), 
                                                            "looking_for"       => $data['looking_for'], 
                                                            "services"          => $data['services'], 
                                                            "profile_visibility"=> $data['profile_visibility'], 
                                                            "date_created"      => $date, 
                                                            "date_updated"      => $date]))
            {
                throw new \Exception($translate->getString("error-DBInsert"));
            }
        }else{
            if(!$database->update("user_standard_info", [   "looking_for"       => $data['looking_for'], 
                                                            "services"          => $data['services'], 
                                                            "profile_visibility"=> $data['profile_visibility'], 
                                                            "date_updated"      => $date], 
                                                            ["user_id"          => parent::getId()]))
            {
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
        }
        $this->loadStandarUser();
    }

    function deleteAcc(){        
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        if($database->has("user_standard_info", ["user_id" => parent::getId()])){
            if(!$database->delete("user_standard_info", ["user_id" => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("tmp_users_mails", ["user_id" => parent::getId()])){
            if(!$database->delete("tmp_users_mails", ["user_id" => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }

        if($database->has("users_to_categories", ["user_id" => parent::getId()])){
            if(!$database->delete("users_to_categories", ["user_id" => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("social_media", ["user_id" => parent::getId()])){
            if(!$database->delete("social_media", ["user_id" => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("user_notifications_settings", ["user_id" => parent::getId()])){
            if(!$database->delete("user_notifications_settings", ["user_id" => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("invoice_users_data", ['user_id' => parent::getId()])){
            if(!$database->delete("invoice_users_data", ['user_id' => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("visites_profiles", ["OR" => ['visitor_id' => parent::getId(), 'visited_id' => parent::getId()]])){
            if(!$database->delete("visites_profiles", ["OR" => ['visitor_id' => parent::getId(), 'visited_id' => parent::getId()]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("gifts", ["OR" => ["sender_user_id" => parent::getId(), 'receiving_user_id' => parent::getId()]])){
            $gifts = $database->select("gifts", '*', ["OR" => ["sender_user_id" => parent::getId(), 'receiving_user_id' => parent::getId()]]);
            foreach ($gifts as $gift) {
                switch ($gift['type']) {
                    case '1'://gift file
                        if(!$database->delete("gift_file", ['gift_id' => $gift['id']])){
                            throw new \Exception($translate->getString('error-DBDelete'));
                        }
                        break;
                    
                    case '2'://gift product
                        if(!$database->delete("gift_product", ['gift_id' => $gift['id']])){
                            throw new \Exception($translate->getString('error-DBDelete'));
                        }
                        break;

                    case '3'://gift tokens
                        if(!$database->delete("gift_tokens", ['gift_id' => $gift['id']])){
                            throw new \Exception($translate->getString('error-DBDelete'));
                        }
                        break;
                }
            }
            if(!$database->delete("gifts", ["OR" => ["sender_user_id" => parent::getId(), 'receiving_user_id' => parent::getId()]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("memberships", ['user_id' => parent::getId()])){
            if(!$database->delete("memberships", ['user_id' => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        //START DELETE FROM NOTIFICATIONS TABLES
        $sql = $database->select("notifications", 'id', ['user_id' => parent::getId()]);
        if($database->has("notification_dismiss", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
            if(!$database->delete("notification_dismiss", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("notification_followers", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
            if(!$database->delete("notification_followers", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("notification_gift", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
            if(!$database->delete("notification_gift", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("notification_message", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
            if(!$database->delete("notification_message", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("notification_new_activity", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
            if(!$database->delete("notification_new_activity", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("notification_new_blog", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
            if(!$database->delete("notification_new_blog", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("notification_new_photo", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
            if(!$database->delete("notification_new_photo", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("notification_new_product", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
            if(!$database->delete("notification_new_product", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("notification_sold_product", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
            if(!$database->delete("notification_sold_product", ["OR"=>['user_id' => parent::getId(), 'notification_id'=>$sql]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("notifications", ['user_id' => parent::getId()])){
            if(!$database->delete("notifications", ['user_id' => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        //END DELETE FROM NOTIFICATIONS TABLES
        if($database->has("orders", ['user_id' => parent::getId()])){
            $ordersId = $database->select("orders", 'id', ['user_id' => parent::getId()]);
            if(!$database->delete("order_info", ['order_id' => $ordersId])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
            if(!$database->delete("orders", ['user_id' => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("follows", ["OR"=>['follower_id' => parent::getId(), 'following_id'=>parent::getId()]])){
            if(!$database->delete("follows", ["OR"=>['follower_id' => parent::getId(), 'following_id'=>parent::getId()]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("user_wishlist", ['user_id' => parent::getId()])){
            if(!$database->delete("user_wishlist", ['user_id' => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }

        if(!$database->delete("customers", ["id" => parent::getId()])){
            throw new \Exception($translate->getString('error-DBDelete'));
        }
    }

    function getLookingFor(){
        return $this->lookingFor;
    }
    function getLookingForGander(){
		$translate = new \classes\Languages\Translate();
		switch($this->getSex()){
			case 1:
				return $translate->getString("woman");
				break;

			case 2:
				return $translate->getString("man");
				break;

			case 3:
				return $translate->getString("transgender");
				break;
		}
	}
    function getServices(){
        return $this->services;
    }
    function getProfileVisibility(){
        return $this->profileVisibility;
    }

    private function setLookingFor($lookingFor){
        $this->lookingFor = $lookingFor;
    }
    private function setServices($services){
        $this->services = $services;
    }
    private function setProfileVisibility($profileVisibility){
        $this->profileVisibility = $profileVisibility;
    }
}