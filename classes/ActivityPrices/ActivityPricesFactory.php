<?php namespace classes\ActivityPrices;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class ActivityPricesFactory{
    private $userId;
    private $escort;
    private $publicVote;
    private $publicDoSTH;
    private $privateChat;
    private $private2W;

    function __construct($userId){
        $this->userId = $userId;
        $this->load();
    }

    private function load(){
        $database = dbCon();
        $escort = array();
        $publicVote = array();
        $publicDoSTH = array();
        $private2W = array();
        $privateChat = array();

        $escortSQL = $database->select("user_model_activity_escort_prices", 'id', ["user_id" => $this->userId]);
        $publicVoteSQL = $database->select("user_model_activity_public_vote_prices", 'id', ["user_id" => $this->userId]);
        $publicDoSTHSQL = $database->select("user_model_activity_public_dosth_prices", 'id', ["user_id" => $this->userId]);
        $privateChatSQL = $database->select("user_model_activity_private_prices", 'id', ["AND" => ["user_id" => $this->userId, "type" => 1]]);
        $private2WSQL = $database->select("user_model_activity_private_prices", 'id', ["AND" => ["user_id" => $this->userId, "type" => 2]]);

        if(!empty($escortSQL)){
            foreach($escortSQL as $id){
                $escort[] = new \classes\ActivityPrices\Escort($this->userId, $id);
            }
        }
        if(!empty($publicVoteSQL)){
            foreach($publicVoteSQL as $id){
                $publicVote[] = new \classes\ActivityPrices\PublicVote($this->userId, $id);
            }
        }
        if(!empty($publicDoSTHSQL)){
            foreach($publicDoSTHSQL as $id){
                $publicDoSTH[] = new \classes\ActivityPrices\PublicDoSTH($this->userId, $id);
            }
        }
        if(!empty($privateChatSQL)){
            foreach($privateChatSQL as $id){
                $privateChat[] = new \classes\ActivityPrices\PrivatePerformance($this->userId, $id);
            }
        }
        if(!empty($private2WSQL)){
            foreach($private2WSQL as $id){
                $private2W[] = new \classes\ActivityPrices\PrivatePerformance($this->userId, $id);
            }
        }

        $this->setEscort($escort);
        $this->setPrivate2W($private2W);
        $this->setPrivateChat($privateChat);
        $this->setPublicDoSTH($publicDoSTH);
        $this->setPublicVote($publicVote);
    }

    private function setEscort($escort){
        $this->escort = $escort;
    }
    private function setPublicVote($publicVote){
        $this->publicVote = $publicVote;
    }
    private function setPublicDoSTH($publicDoSTH){
        $this->publicDoSTH = $publicDoSTH;
    }
    private function setPrivateChat($privateChat){
        $this->privateChat = $privateChat;
    }
    private function setPrivate2W($private2W){
        $this->private2W = $private2W;
    }

    function getEscort(){
        return $this->escort;
    }
    function getPublicVote(){
        return $this->publicVote;
    }
    function getPublicDoSTH(){
        return $this->publicDoSTH;
    }
    function getPrivateChat(){
        return $this->privateChat;
    }
    function getPrivate2W(){
        return $this->private2W;
    }
}