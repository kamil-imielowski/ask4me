<?php namespace classes\User;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
include_once dirname(dirname(dirname(__FILE__))).'/functions/generateCode.php';

class ModelUser extends User{
    private $coverPhoto;
    private $videos;
    private $defaultVideo;
    private $photos;
    private $tagLine;
    private $turns;
    private $expertise;
    private $partnerPreferences;
    private $englishProficiency;
    private $languages;
    private $socialMedia;
    private $countries;
    private $serviceProvide;
    private $blogs;
    private $availabaility;
    private $country;

    private $realAge;
    private $looksAge;
    private $height;
    private $weight;
    private $chestCupSize;
    private $pubicHair;
    private $dressSize;
    private $ethnicity;
    private $skinColor;
    private $eyesColor;
    private $hairColor;
    private $bodyBuild;
    private $bodyDecorations;
    private $activityPrices;
    private $recentActivity; // lista typow ostatnich 5 aktywnosci

    function __construct($id=null, $nick=null){
        parent::__construct($id, $nick);
        if(!empty(parent::getId())){
            $this->loadModelUser();
        }
    }

    private function loadModelUser(){
        $database = dbCon();
        $sql = $database->select("user_model_info", '*', ["user_id" => parent::getId()]);
        if(!empty($sql)){
            foreach($sql as $v){
                $this->setCoverPhoto(new \classes\Photo\Photo($v['coverPhoto'], "user-model-cover"));
                $this->setDefaultVideo(new \classes\Video\Video($v['default_video_id']));
                $this->setTagLine($v['tag_line']);
                $this->setTurns($v['turns']);
                $this->setExpertise($v['expertise']);
                $this->setPartnerPreferences($v['partner_preferences']);
                $this->setEnglishProficiency($v['english_proficiency']);
                $this->setServiceProvide($v['service_provide']);
                $this->setRealAge($v['real_age']);
                $this->setLooksAge($v['looks_age']);
                $this->setHeight($v['height']);
                $this->setWeight($v['weight']);
                $this->setChestCupSize($v['chest_cup_size']);
                $this->setPubicHair($v['pubic_hair']);
                $this->setDressSize($v['dress_size']);
                $this->setEthnicity($v['ethnicity']);
                $this->setSkinColor($v['skin_color']);
                $this->setEyesColor($v['eyes_color']);
                $this->setHairColor($v['hair_color']);
                $this->setBodyBuild($v['body_build']);
                $this->setBodyDecorations($v['body_decorations']);
            }
        }else{
            $this->setCoverPhoto(new \classes\Photo\Photo(null, "user-model-cover"));
        }
        $sql = $database -> select("user_model_languages", 'language_code', ['user_id' => parent::getId()]);
        if(!empty($sql)){
            foreach($sql as $k){
                $lang = new \classes\Languages\Language($k);
                $lang -> loadProficiency(parent::getId());
                $languages[] = $lang;
                unset($lang);
            }
            $this->setLanguages($languages);
        }
    }

    function register($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();

        #login
        if(empty($data['login']) || ctype_space($data['login'])){
            throw new \Exception($translate->getString("loginRequired"));
        }
        if($database -> has("customers", ['login' => $data['login']])){
            throw new \Exception($translate->getString("isset-login"));
        }
        if(!preg_match('/^(?=[a-z]{2})(?=.{4,26})(?=[^.]*\.?[^.]*$)(?=[^_]*_?[^_]*$)[\w.]+$/iD', $data['login'])){
            throw new \Exception($translate->getString("unexpectedChars"));
        }

        #email
        if(empty($data['email']) || ctype_space($data['email'])){
            throw new \Exception($translate->getString("emailRequired"));
        }
        if($database -> has("customers", ['email' => $data['email']])){
            throw new \Exception($translate->getString("isset-email"));
        }

        #name
        if(empty($data['name']) || ctype_space($data['name'])){
            throw new \Exception($translate->getString("nameRequired"));
        }

        #passwords
        if(empty($data['password']) || ctype_space($data['password'])){
            throw new \Exception($translate->getString("passwordRequired"));
        }
        if($data['password'] !== $data['re_password']){
            throw new \Exception($translate->getString("error-notSame"));
        }
        if(strlen($data['password']) < 8){
            throw new \Exception($translate->getString("passwordTooShort"));
        }

        #check terms 
        if(!isset($data['terms'])){
            throw new \Exception($translate->getString("regulationsRequired"));
        }

        #gender(sex)
        if($data['sex'] <= 0 || $data['sex'] > 3){
            throw new \Exception($translate->getString("sex-required"));
        }

        #country
        if(!isset($data['country']) || empty($data['country'])){
            throw new \Exception($translate->getString("country-required"));
        }

        $code = generateCode(7);
        if(!$database -> insert("customers",[
                                            "login"         => $data['login'],
                                            "name"          => $data['name'],
                                            "surname"       => $data['surname'],
                                            "email"         => $data['email'],
                                            "password"      => md5($data['password']),
                                            "type"          => 2,
                                            "sex"           => $data['sex'],
                                            "activ_code"    => $code,
                                            "active"        => 0,
                                            "country"       => $data['country'],
                                            "date_created"  => date("Y-m-d H:i:s"),

        ]))
        {
            throw new \Exception($translate->getString("error-DBInsert"));
        }

        parent::setId($database->id());
        parent::sendActivationEmail();

        $date = date("Y-m-d H:i:s");
        $database->insert("hear_about", ["user_id" => parent::getId(), "answer" => $data['hear'], "date_created" => $date]);
        //init required tables
        if(!$database->insert("user_notifications_settings", ["user_id" => parent::getId(), "date_created" => $date])){
            throw new \Exception($translate->getString("error-DBInsert"));
        }
        if(!$database->insert("user_model_info", ['user_id' => parent::getId(), 'date_created' => $date])){
            throw new \Exception($translate->getString("error-DBInsert"));
        }

    }

    private function addCoverPhoto($image){
		$photo = new \classes\Photo\Photo();
		$photo->upload($image, '/img/customers/');
		$database = dbCon();
        $translate = new \classes\Languages\Translate();
        $date = date("Y-m-d H:i:s");
        if(!$database->has("user_model_info", ["user_id" => parent::getId()])){
            if(!$database->insert("user_model_info", ["user_id" => parent::getId(), "coverPhoto" => $photo->getId(), "date_created" => $date])){
                throw new \Exception($translate->getString('image-upload-error'));
            }
        }else{
            if(!$database->update("user_model_info", ["coverPhoto" => $photo->getId()], ["user_id" => parent::getId()])){
                throw new \Exception($translate->getString('image-upload-error'));
            }
        }
		$this->setCoverPhoto($photo);
	}

    function introductionUpdate($data, $images){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        if(!empty($images['cover']['tmp_name'])){
            $this->addCoverPhoto($images['cover']);
        }
        if(!empty($images['profile']['tmp_name'])){
            parent::addProfilePicture($images['profile']);
        }
        $translate = new \classes\Languages\Translate();

        parent::updateOverView($data['overview']);
        
        if(!$database -> update("user_model_info",[
                                                'tag_line' => $data['tag_line'],
                                                'turns' => $data['turns'],
                                                'expertise' => $data['expertise'],
                                                'partner_preferences' => $data['partner_preferences'],
                                                'english_proficiency' => $data['english_proficiency'],
                                                'date_updated' => $date

        ], ['user_id' => parent::getId()]))
        {
            throw new \Exception($date);
        }

        $this->setTagLine($data['tag_line']);
        $this->setTurns($data['turns']);
        $this->setExpertise($data['expertise']);
        $this->setPartnerPreferences($data['partner_preferences']);
        $this->setEnglishProficiency($data['english_proficiency']);
        if(!empty($data['language'])){
            foreach($data['language'] as $k => $language){
                if(!$database -> has("user_model_languages", ["AND" => ['user_id' => parent::getId(), 'language_code' => $language]])){
                    if(!$database -> insert("user_model_languages", [
                                                                'user_id' => parent::getId(),
                                                                'language_code' => $language,
                                                                'id_proficiency_language' => $data['proficiency'][$k]
                    ]))
                    {
                        throw new \Exception($translate->getString('error-DBUpdate'));
                    }
                }else{
                    if(!$database -> has("user_model_languages", ["AND" => ['user_id' => parent::getId(), 'language_code' => $language, 'id_proficiency_language' => $data['proficiency'][$k]]])){
                        if(!$database -> update("user_model_languages", ['id_proficiency_language' => $data['proficiency'][$k]], ["AND" =>['user_id' => parent::getId(), 'language_code' => $language]])){
                            throw new \Exception('aa');
                        }
                    }
                }
            }

            $sql = $database -> select("user_model_languages", '*', ['user_id' => parent::getId()]);
            foreach($sql as $k){
                if(!in_array($k['language_code'], $data['language'])){
                    if(!$database -> delete("user_model_languages", ["AND" => ['user_id' => parent::getId(), 'language_code' => $k['language_code']]])){
                        throw new \Exception($translate->getString('error-DBUpdate'));
                    }
                }
            }
        }

        $sql = $database -> select("user_model_languages", 'language_code', ['user_id' => parent::getId()]);
        foreach($sql as $k){
            $lang = new \classes\Languages\Language($k);
            $lang -> loadProficiency(parent::getId());
            $languages[] = $lang;
            unset($lang);
        }
            $this->setLanguages($languages);
    }

    function socialMediaUpdate($data){
        $socialMedia = new \classes\SocialMedia\SocialMedia(parent::getId());
        $socialMedia -> saveToDB($data);
    }

    function loadSocialMedia(){
        $socialMedia = new \classes\SocialMedia\SocialMedia(parent::getId());
        $this->setSocialMedia($socialMedia);
    }

    function addUserProduct($id){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        if(!$database -> insert("user_products", ['user_id' => parent::getId(), 'product_id' => $id])){
            throw new \Exception($id);
        }
        //notification
        $data = array("user_id"=>parent::getId(), "product_id" => $id);
        $notification = new \classes\Notification\NotificationNewProduct();
        $notification->saveToDB($data);
    }

    function categoriesAndServicesUpdate($data){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate();
        parent::userToCategories($data['categories']);
        
        # przy wprowadzeniu członkowstwa trzeba zwracać uwagę na rodzaj usługi
        if($database -> has("user_model_info", ['user_id' => parent::getId()])){
            if(!$database->update("user_model_info", ['service_provide' => $data['service'], 'date_updated' => $date], ['user_id' => parent::getId()])){
                throw new \Exception($translate->getString('error-DBUpdate'));
            }
        }
        $this->setServiceProvide($data['service']);
        
        if(!empty($data['country'])){
            foreach($data['country'] as $i => $k){
                if($database->has("user_model_services_location", ["AND" => ['user_id' => parent::getId(), 'country_iso_code_2' => $k]])){
                    if(!$database->update("user_model_services_location", ['city_or_region' => $data['cityOrRegion'][$i], 'date_updated' => $date],["AND" =>['user_id' => parent::getId(),'country_iso_code_2' => $k]])){
                        throw new \Exception($translate->getString('error-DBUpdate'));
                    }
                }else{
                    if(!$database -> insert("user_model_services_location", ['user_id' => parent::getId(),'country_iso_code_2' => $k, 'city_or_region' => $data['cityOrRegion'][$i]])){
                        throw new \Exception($translate->getString('error-DBInsert'));
                    }
                }
            }

            $sql = array();
            $sql = $database -> select("user_model_services_location", 'country_iso_code_2', ['user_id' => parent::getId()]);
            foreach($sql as $k){
                if(!in_array($k, $data['country'])){
                    if(!$database->delete("user_model_services_location", ["AND" => ['user_id' => parent::getId(), 'country_iso_code_2' => $k]])){
                        throw new \Exception($translate->getString('error-DBUpdate'));
                    }
                }
            }
        }
        $sql = array();
        $countries = array();
        $sql = $database -> select("user_model_services_location", 'country_iso_code_2', ['user_id' => parent::getId()]);
        foreach($sql as $k){
            $country = new \classes\Country\Country($k);
            $country -> loadCityOrRegion(parent::getId());
            $countries[] = $country;
            unset($country);
        }
        $this->setCountries($countries);
    }

    function deleteAcc(){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        if($database->has("user_model_info", ["user_id" => parent::getId()])){
            if(!$database->delete("user_model_info", ["user_id" => parent::getId()])){
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
        if($database->has("user_model_services_location", ['user_id' => parent::getId()])){
            if(!$database->delete("user_model_services_location", ['user_id' => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("user_model_languages", ['user_id' => parent::getId()])){
            if(!$database -> delete("user_model_languages", ['user_id' => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database -> has("blogs", ['user_id' => parent::getId()])){
            if(!$database->delete("blogs", ['user_id' => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("hear_about", ['user_id' => parent::getId()])){
            if(!$database -> delete("hear_about", ['user_id' => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("user_model_availability", ["user_id" => parent::getId()])){
            if(!$database->delete("user_model_availability", ["user_id" => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("invoice_users_data", ['user_id' => parent::getId()])){
            if(!$database->delete("invoice_users_data", ['user_id' => parent::getId()])){
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
        if($database->has("orders", ['user_id' => parent::getId()])){
            $ordersId = $database->select("orders", 'id', ['user_id' => parent::getId()]);
            if(!$database->delete("order_info", ['order_id' => $ordersId])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
            if(!$database->delete("orders", ['user_id' => parent::getId()])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("follows", ["OR" => ['follower_id' => parent::getId(), 'following_id' => parent::getId()]])){
            if(!$database->delete("follows", ["OR" => ['follower_id' => parent::getId(), 'following_id' => parent::getId()]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if($database->has("visites_profiles", ["OR" => ['visitor_id' => parent::getId(), 'visited_id' => parent::getId()]])){
            if(!$database->delete("visites_profiles", ["OR" => ['visitor_id' => parent::getId(), 'visited_id' => parent::getId()]])){
                throw new \Exception($translate->getString('error-DBDelete'));
            }
        }
        if(!$database->delete("customers", ["id" => parent::getId()])){
            throw new \Exception($translate->getString('error-DBDelete'));
        }
    }

    function getCoverPhoto(){
        return $this->coverPhoto;
    }
    
    private function setCoverPhoto(\classes\Photo\Photo $coverPhoto){
        $this->coverPhoto = $coverPhoto;
    }

    function addVideo($file){
        $file_ary = array();
        $file_count = count($file['name']);
        $file_keys = array_keys($file);
    
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file[$key][$i];
            }
        }
        
        foreach($file_ary as $k){
            $video = new \classes\Video\Video();
            $video->upload($k, '/videos/customers/');
            $database = dbCon();
            $translate = new \classes\Languages\Translate();
            $date = date("Y-m-d H:i:s");
            
            $database -> insert("videos_to_user", ['user_id' => parent::getId(), 'video_id' => $video->getId()]);
            $videos[] = $video;
        }

        $this->addAnActivity(5);
    }

    function addDefaultVideo($file){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $video = new \classes\Video\Video();
        $video->upload($file, 0);
        $translate = new \classes\Languages\Translate();

        if(!$database->has("user_model_info", ["user_id" => parent::getId()])){
            if(!$database->insert("user_model_info", ["user_id" => parent::getId(), "default_video_id" => $video->getId(), "date_created" => $date, "date_updated" => $date])){
                throw new \Exception($translate->getString('image-upload-error'));
            }
        }else{
            if(!$database->update("user_model_info", ["default_video_id" => $video->getId(), "date_updated" => $date], ["user_id" => parent::getId()])){
                throw new \Exception($translate->getString('image-upload-error'));
            }
        }
    }

    function addImage($file){
        $database = dbCon();
        $image=array();
        foreach ($file['name'] as $key => $value) {
            $image['name'] = $value;
            $image['type'] = $file['type'][$key];
            $image['tmp_name'] = $file['tmp_name'][$key];
            $image['error'] = $file['error'][$key];
            $image['size'] = $file['size'][$key];

            $photo = new \classes\Photo\Photo();
		    $photo->upload($image, '/img/customers/');

            $database -> insert("photos_to_user", ['user_id' => parent::getId(), 'photo_id' => $photo->getId()]);
        }

        //notification
        $data = array("user_id" => parent::getId());
        $notification = new \classes\Notification\NotificationPhoto();
        $notification->saveToDB($data);
        $this->addAnActivity(1);
    }

    function uploadBlog($data, $image){
        if(isset($data['id_blog'])){//update blog
            $blog = new \classes\Blog\Blog($data['id_blog']);
        }else{
            $blog = new \classes\Blog\Blog();
        }
            $blog->uploadBlog($data, $image, parent::getId());
    }

    function loadBlogs(){
        $database = dbCon();
        $sql = $database -> select("blogs", '*', ['user_id' => parent::getId()]);
        $blogs = array();
        foreach($sql as $k){
            $blogs[] = new \classes\Blog\Blog($k['id']);
        }
        $this->setBlogs($blogs);
    }

    function deleteBlog($id){
        $database = dbCon();
        $blog = new \classes\Blog\Blog($id);
        $blog->deleteBlog();
    }

    function saveLooks($data){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate();

        if(!$database->update("user_model_info", [
                                                'real_age' => $data['real_age'],
                                                'looks_age' => $data['looks_age'],
                                                'height' => $data['height'],
                                                'weight' => $data['weight'],
                                                'chest_cup_size' => $data['chest_cup_size'],
                                                'pubic_hair' => $data['pubic_hair'],
                                                'dress_size' => $data['dress_size'],
                                                'ethnicity' => $data['ethnicity'],
                                                'skin_color' => $data['skin_color'],
                                                'eyes_color' => $data['eyes_color'],
                                                'hair_color' => $data['hair_color'],
                                                'body_build' => $data['body_build'],
                                                'body_decorations' => $data['body_decorations'],
                                                'date_updated' => $date
        ], ['user_id' => parent::getId()])){
            throw new \Exception($translate->getString('error-DBInsert'));
        }
        $this->setRealAge($data['real_age']);
        $this->setLooksAge($data['looks_age']);
        $this->setHeight($data['height']);
        $this->setWeight($data['weight']);
        $this->setChestCupSize($data['chest_cup_size']);
        $this->setPubicHair($data['pubic_hair']);
        $this->setDressSize($data['dress_size']);
        $this->setEthnicity($data['ethnicity']);
        $this->setSkinColor($data['skin_color']);
        $this->setEyesColor($data['eyes_color']);
        $this->setHairColor($data['hair_color']);
        $this->setBodyBuild($data['body_build']);
        $this->setBodyDecorations($data['body_decorations']);
    }

    function withdrawTokens($data){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $settings = new \classes\Settings\SettingsFactory();
        parent::updateTokens($data['tokens'] * $settings->getPriceForToken() * -1);
        if(!$database->insert('tokens_withdraws', [
                                                    'user_id' => parent::getId(),
                                                    'tokens' => $data['tokens'],
                                                    'dolars' => $data['tokens'] * $settings->getPriceForToken(),
                                                    'iban' => $data['iban'],
                                                    'swift_bic' => $data['swift_bic'],
                                                    'owner_name' => $data['owner_name'],
                                                    'owner_last_name' => $data['owner_last_name'],
                                                    'date_created' => $date 
        ])){
            throw new \Exception($translate->getString('error-DBInsert'));
        }
    }

    private function setVideos($videos){
        $this->videos = $videos;
    }

    private function setPhotos($photos){
        $this->photos = $photos;
    }
    
    private function setTagLine($tagLine){$this->tagLine = $tagLine;}
    private function setTurns($turns){$this->turns = $turns;}
    private function setExpertise($expertise){$this->expertise = $expertise;}
    private function setPartnerPreferences($partnerPreferences){$this->partnerPreferences = $partnerPreferences;}
    private function setEnglishProficiency($englishProficiency){$this->englishProficiency = $englishProficiency;}
    private function setLanguages($languages){$this->languages = $languages;}
    private function setSocialMedia($socialMedia){$this->socialMedia = $socialMedia;}
    private function setCountries($countries){$this->countries = $countries;}
    private function setServiceProvide($serviceProvide){$this->serviceProvide = $serviceProvide;}
    private function setBlogs($blogs){$this->blogs = $blogs;}
    
    private function setRealAge($realAge){$this->realAge = $realAge;}
    private function setLooksAge($looksAge){$this->looksAge = $looksAge;}
    private function setHeight($height){$this->height = $height;}
    private function setWeight($weight){$this->weight = $weight;}
    private function setChestCupSize($chestCupSize){$this->chestCupSize = $chestCupSize;}
    private function setPubicHair($pubicHair){$this->pubicHair = $pubicHair;}
    private function setDressSize($dressSize){$this->dressSize = $dressSize;}
    private function setEthnicity($ethnicity){$this->ethnicity = $ethnicity;}
    private function setSkinColor($skinColor){$this->skinColor = $skinColor;}
    private function setEyesColor($eyesColor){$this->eyesColor = $eyesColor;}
    private function setHairColor($hairColor){$this->hairColor = $hairColor;}
    private function setBodyBuild($bodyBuild){$this->bodyBuild = $bodyBuild;}
    private function setBodyDecorations($bodyDecorations){$this->bodyDecorations = $bodyDecorations;}

    function getVideo(){
        return $this->video;
    }

    function loadGallery(){
        $galleryList = array();
        $i = 0;
        $database = dbCon();
        $sql = $database -> select("user_model_info", 'default_video_id', ['user_id' => parent::getId()]);
        $sqlq = $database -> select("videos_to_user", 'video_id', ['user_id' => parent::getId()]);
        if(isset($sql[0]) && $sql[0] != null){
            $sqlq = array_merge($sql, $sqlq);
        }
        $sqlq = $database -> select("videos", '*', ['id' => $sqlq]);
        $videos = array();
        if(!empty($sqlq)){
            foreach($sqlq as $k){
                $videos[$k['id']] = new \classes\Video\Video($k['id']);
                $galleryList[$i]['type'] = "video";
                $galleryList[$i]['id'] = $k['id'];
                $galleryList[$i]['data'] = $k['date_created'];
                $i++;
            }
        }
        $this->setVideos($videos);

        $sqlq = $database -> select("photos_to_user", 'photo_id', ['user_id' => parent::getId()]);
        $sqlq = $database -> select("photos", '*', ['id' => $sqlq]);
        $photos = array();
        if(!empty($sqlq)){
            foreach($sqlq as $k){
                $photos[$k['id']] = new \classes\Photo\Photo($k['id']);
                $galleryList[$i]['type'] = "photo";
                $galleryList[$i]['id'] = $k['id'];
                $galleryList[$i]['data'] = $k['date_created'];
                $i++;
            }
        }
        $this->setPhotos($photos);

        usort($galleryList, function($a, $b) {
            return $a['data'] < $b['data'];
        });

        return $galleryList;
    }

    private function setDefaultVideo($video){
        $this->defaultVideo = $video;
    }

    function getPhotos(){
        return $this->photos;
    }

    function getVideos(){
        return $this->videos;
    }

    function getTagLine(){return $this->tagLine;}
    function getTurns(){return $this->turns;}
    function getExpertise(){return $this->expertise;}
    function getPartnerPreferences(){return $this->partnerPreferences;}
    function getEnglishProficiency(){return $this->englishProficiency;}
    function getUserLanguages(){return $this->languages;}
    function getSocialMedia(){return $this->socialMedia;}
    function getUserCountries(){return $this->countries;}
    function getServiceProvide(){return $this->serviceProvide;}
    function getBlogs(){return $this->blogs;}

    function getRealAge(){return $this->realAge;}
    function getLooksAge(){return $this->looksAge;}
    function getHeight(){return $this->height;}
    function getWeight(){return $this->weight;}
    function getChestCupSize(){return $this->chestCupSize;}
    function getPubicHair(){return $this->pubicHair;}
    function getDressSize(){return $this->dressSize;}
    function getEthnicity(){return $this->ethnicity;}
    function getSkinColor(){return $this->skinColor;}
    function getEyesColor(){return $this->eyesColor;}
    function getHairColor(){return $this->hairColor;}
    function getBodyBuild(){return $this->bodyBuild;}
    function getBodyDecorations(){return $this->bodyDecorations;}

    function loadAvailability(){
        $availabaility = new \classes\User\ModelAvailability(parent::getId());
        $this->availabaility = $availabaility;
    }
    function getAvailability(){
        return $this->availabaility;
    }

    function loadActivityPrices(){
        $activityPrices = new \classes\ActivityPrices\ActivityPricesFactory(parent::getId());
        $this->setActivityPrices($activityPrices);
    }
    private function setActivityPrices(\classes\ActivityPrices\ActivityPricesFactory $activityPrices){
        $this->activityPrices = $activityPrices;
    }
    function getActivityPrices(){
        return $this->activityPrices;
    }

    function addAnActivity($type){
        $database = dbCon();
        $database->insert("model_recent_activity", ["user_id" => $this->getId(), "activity_type" => $type,"date_created" => date("Y-m-d H:i:s")]);
    }
    function loadRecentActivity(){
        $database = dbCon();
        $sql = $database->select("model_recent_activity", '*', ["user_id" => $this->getId(), "ORDER" => ["date_created" => "DESC"], "LIMIT" => 5]);
        $recentActivity = array();
        $i=0;
        foreach($sql as $v){
            $recentActivity[$i]["date"] = new \DateTime($v['date_created']);
            $recentActivity[$i]["type"] = $v['activity_type'];
            $i++;
        }
        $this->setRecentActivity($recentActivity);
    }
    private function setRecentActivity($recentActivity){
        $this->recentActivity = $recentActivity;
    }
    function getRecentActivity(){
        return $this->recentActivity;
    }
}