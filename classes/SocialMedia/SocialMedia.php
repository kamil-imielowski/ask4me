<?php namespace classes\SocialMedia;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class SocialMedia{ 
    private $userId;
    private $facebook;
    private $googlePlus;
    private $twitter;
    private $instagram;
    private $snapchat;
    private $pinterest;
    private $linkedin;
    private $youTube;

    function __construct($userId = null){
        $this->userId = empty($userId) ? null : $userId;
        $this->loadSocialMedia();
    }

    function saveToDB($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        $date = date("Y-m-d H:i:s");

        if(empty($this->facebook)){
            #insert
            if(!empty($data['facebook'])){
                if(!strpos($data['facebook'], 'facebook')){
                    throw new \Exception($translate->getString('incorrectLink').' - facebook');
                }
                if(!$database->insert("social_media", ["user_id" => $this->userId, "type" => 1, "link" => $data['facebook'], "date_created" => $date, "date_updated" => $date])){
                    throw new \Exception($translate->getString('error-DBInsert'));
                }   
            }
        }else{
            #update
            if(!empty($data['facebook'])){
                if(!strpos($data['facebook'], 'facebook')){
                    throw new \Exception($translate->getString('incorrectLink').' - facebook');
                }
                if(!$database->update("social_media", ["link" => $data['facebook'], "date_updated" => $date], ["AND" => ["user_id" => $this->userId, "type" => 1]])){
                    throw new \Exception($translate->getString('error-DBUpdate'));
                }   
            }
        }

        if(empty($this->googlePlus)){
            #insert
            if(!empty($data['googlePlus'])){
                if(!strpos($data['googlePlus'], 'plus.google')){
                    throw new \Exception($translate->getString('incorrectLink').' - google plus');
                }
                if(!$database->insert("social_media", ["user_id" => $this->userId, "type" => 2, "link" => $data['googlePlus'], "date_created" => $date, "date_updated" => $date])){
                    throw new \Exception($translate->getString('error-DBInsert'));
                }   
            }
        }else{
            #update
            if(!empty($data['googlePlus'])){
                if(!strpos($data['googlePlus'], 'plus.google')){
                    throw new \Exception($translate->getString('incorrectLink').' - google plus');
                }
                if(!$database->update("social_media", ["link" => $data['googlePlus'], "date_updated" => $date], ["AND" => ["user_id" => $this->userId, "type" => 2]])){
                    throw new \Exception($translate->getString('error-DBUpdate'));
                }   
            }
        }

        if(empty($this->twitter)){
            #insert
            if(!empty($data['twitter'])){
                if(!strpos($data['twitter'], 'twitter')){
                    throw new \Exception($translate->getString('incorrectLink').' - twitter');
                }
                if(!$database->insert("social_media", ["user_id" => $this->userId, "type" => 3, "link" => $data['twitter'], "date_created" => $date, "date_updated" => $date])){
                    throw new \Exception($translate->getString('error-DBInsert'));
                }   
            }
        }else{
            #update
            if(!empty($data['twitter'])){
                if(!strpos($data['twitter'], 'twitter')){
                    throw new \Exception($translate->getString('incorrectLink').' - twitter');
                }
                if(!$database->update("social_media", ["link" => $data['twitter'], "date_updated" => $date], ["AND" => ["user_id" => $this->userId, "type" => 3]])){
                    throw new \Exception($translate->getString('error-DBUpdate'));
                }   
            }
        }

        if(empty($this->instagram)){
            #insert
            if(!empty($data['instagram'])){
                if(!strpos($data['instagram'], 'instagram')){
                    throw new \Exception($translate->getString('incorrectLink').' - instagram');
                }
                if(!$database->insert("social_media", ["user_id" => $this->userId, "type" => 4, "link" => $data['instagram'], "date_created" => $date, "date_updated" => $date])){
                    throw new \Exception($translate->getString('error-DBInsert'));
                }   
            }
        }else{
            #update
            if(!empty($data['instagram'])){
                if(!strpos($data['instagram'], 'instagram')){
                    throw new \Exception($translate->getString('incorrectLink').' - instagram');
                }
                if(!$database->update("social_media", ["link" => $data['instagram'], "date_updated" => $date], ["AND" => ["user_id" => $this->userId, "type" => 4]])){
                    throw new \Exception($translate->getString('error-DBUpdate'));
                }   
            }
        }

        if(empty($this->snapchat)){
            #insert
            if(!empty($data['snapchat'])){
                if(!strpos($data['snapchat'], 'snapchat')){
                    throw new \Exception($translate->getString('incorrectLink').' - snapchat');
                }
                if(!$database->insert("social_media", ["user_id" => $this->userId, "type" => 5, "link" => $data['snapchat'], "date_created" => $date, "date_updated" => $date])){
                    throw new \Exception($translate->getString('error-DBInsert'));
                }   
            }
        }else{
            #update
            if(!empty($data['snapchat'])){
                if(!strpos($data['snapchat'], 'snapchat')){
                    throw new \Exception($translate->getString('incorrectLink').' - snapchat');
                }
                if(!$database->update("social_media", ["link" => $data['snapchat'], "date_updated" => $date], ["AND" => ["user_id" => $this->userId, "type" => 5]])){
                    throw new \Exception($translate->getString('error-DBUpdate'));
                }   
            }
        }

        if(empty($this->pinterest)){
            #insert
            if(!empty($data['pinterest'])){
                if(!strpos($data['pinterest'], 'pinterest')){
                    throw new \Exception($translate->getString('incorrectLink').' - pinterest');
                }
                if(!$database->insert("social_media", ["user_id" => $this->userId, "type" => 6, "link" => $data['pinterest'], "date_created" => $date, "date_updated" => $date])){
                    throw new \Exception($translate->getString('error-DBInsert'));
                }   
            }
        }else{
            #update
            if(!empty($data['pinterest'])){
                if(!strpos($data['pinterest'], 'pinterest')){
                    throw new \Exception($translate->getString('incorrectLink').' - pinterest');
                }
                if(!$database->update("social_media", ["link" => $data['pinterest'], "date_updated" => $date], ["AND" => ["user_id" => $this->userId, "type" => 6]])){
                    throw new \Exception($translate->getString('error-DBUpdate'));
                }   
            }
        }

        if(empty($this->linkedin)){
            #insert
            if(!empty($data['linkedin'])){
                if(!strpos($data['linkedin'], 'linkedin')){
                    throw new \Exception($translate->getString('incorrectLink').' - linkedin');
                }
                if(!$database->insert("social_media", ["user_id" => $this->userId, "type" => 7, "link" => $data['linkedin'], "date_created" => $date, "date_updated" => $date])){
                    throw new \Exception($translate->getString('error-DBInsert'));
                }   
            }
        }else{
            #update
            if(!empty($data['linkedin'])){
                if(!strpos($data['linkedin'], 'linkedin')){
                    throw new \Exception($translate->getString('incorrectLink').' - linkedin');
                }
                if(!$database->update("social_media", ["link" => $data['linkedin'], "date_updated" => $date], ["AND" => ["user_id" => $this->userId, "type" => 7]])){
                    throw new \Exception($translate->getString('error-DBUpdate'));
                }   
            }
        }

        if(empty($this->youTube)){
            #insert
            if(!empty($data['youTube'])){
                if(!strpos($data['youTube'], 'youtube')){
                    throw new \Exception($translate->getString('incorrectLink').' - youtube');
                }
                if(!$database->insert("social_media", ["user_id" => $this->userId, "type" => 8, "link" => $data['youTube'], "date_created" => $date, "date_updated" => $date])){
                    throw new \Exception($translate->getString('error-DBInsert'));
                }   
            }
        }else{
            #update
            if(!empty($data['youTube'])){
                if(!strpos($data['youTube'], 'youtube')){
                    throw new \Exception($translate->getString('incorrectLink').' - youtube');
                }
                if(!$database->update("social_media", ["link" => $data['youTube'], "date_updated" => $date], ["AND" => ["user_id" => $this->userId, "type" => 8]])){
                    throw new \Exception($translate->getString('error-DBUpdate'));
                }   
            }
        }
    }

    private function loadSocialMedia(){
        $database = dbCon();
        $sql = $database->select("social_media", '*', ["user_id" => $this->userId]);
        if(!empty($sql)){
            foreach($sql as $v){
                if($v['type'] == 1)
                    $this->setFacebook($v['link']);
                if($v['type'] == 2)
                    $this->setGooglePlus($v['link']);           
                if($v['type'] == 3)
                    $this->setTwitter($v['link']);
                if($v['type'] == 4)
                    $this->setInstagram($v['link']);
                if($v['type'] == 5)
                    $this->setSnapchat($v['link']);
                if($v['type'] == 6)
                    $this->setPinterest($v['link']);
                if($v['type'] == 7)
                    $this->setLinkedin($v['link']);      
                if($v['type'] == 8)
                    $this->setYouTube($v['link']);                                                                                                     
            }
        }
    }

    function getFacebook(){
        return $this->facebook;
    }
    function getGooglePlus(){
        return $this->googlePlus;
    }
    function getTwitter(){
        return $this->twitter;
    }
    function getInstagram(){
        return $this->instagram;
    }
    function getSnapchat(){
        return $this->snapchat;
    }
    function getPinterest(){
        return $this->pinterest;
    }
    function getLinkedin(){
        return $this->linkedin;
    }
    function getYouTube(){
        return $this->youTube;
    }

    private function setFacebook($facebook){
        $this->facebook = $facebook;
    }
    private function setGooglePlus($googlePlus){
        $this->googlePlus = $googlePlus;
    }
    private function setTwitter($twitter){
        $this->twitter = $twitter;
    }
    private function setInstagram($instagram){
        $this->instagram = $instagram;
    }
    private function setSnapchat($snapchat){
        $this->snapchat = $snapchat;
    }
    private function setPinterest($pinterest){
        $this->pinterest = $pinterest;
    }
    private function setLinkedin($linkedin){
        $this->linkedin = $linkedin;
    }
    private function setYouTube($youTube){
        $this->youTube = $youTube;
    }
}