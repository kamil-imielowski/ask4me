<?php namespace classes\PlannedActivities;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class PrivatePlannedActivities extends PlannedActivities{
    private $typePrivate;
    private $activity;
    private $minDuration;
    private $price;
    private $additionalComments;
    private $spyCam;

    function __construct($userId, $type, $id = null){
        parent::__construct($userId, $type, $id);
        if(!empty($id)){
            $this->load();
        }
    }

    private function load(){
        $database = dbCon();
        $sql = $database->select("planned_private_activities", '*', ["id" => parent::getPlannedActivityId()]);
        foreach($sql as $v){
            $this->setTypePrivate($v['type']);
            $this->setActivity(new \classes\ActivityPrices\PrivatePerformance(parent::getUser()->getId() ,$v['private_activity_id']));
            $this->setMinDuration($v['min_duration']);
            $this->setPrice($v['price']);
            $this->setAdditionalComments($v['additional_comments']);
            $this->setSpyCam($v['spy_cam']);
        }
    }

    function saveToDB($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        $dateTime = date("Y-m-d H:i:s");
        if(empty(parent::getPlannedActivityId())){
            //insert
            if(!$database->insert("planned_private_activities", [   "type"                  => $data['privateType'], 
                                                                    "private_activity_id"   => $data['activity'],
                                                                    "min_duration"          => $data['minDuration'],
                                                                    "price"                 => $data['price'],
                                                                    "additional_comments"   => $data['additionalComments'],
                                                                    "spy_cam"               => isset($data['spyCam']) ? 1 : 0,
                                                                    "date_created"          => $dateTime]))
            {
                throw new \Exception($translate->getString("error-DBInsert"). "PrivatePlannedActivities");
            }
            parent::setPlannedActivityId($database->id());
        }else{
            //update
            if(!$database->update("planned_private_activities", [   "private_activity_id"   => $data['activity'],
                                                                    "min_duration"          => $data['minDuration'],
                                                                    "price"                 => $data['price'],
                                                                    "additional_comments"   => $data['additionalComments'],
                                                                    "spy_cam"               => isset($data['spyCam']) ? 1 : 0,
                                                                    "date_updated"          => $dateTime], 
                                                                [   "id" => parent::getPlannedActivityId()]))
            {
                throw new \Exception($translate->getString("error-DBUpdate"). "PrivatePlannedActivities");
            }
        }
        parent::saveToDB(["date" => $data['date'], "request_id" => $data['request_id'], "invited_user_id" => $data['invitedUserId']]);
    }

    private function setTypePrivate($typePrivate){
        $this->typePrivate = $typePrivate;
    }
    private function setActivity(\classes\ActivityPrices\PrivatePerformance $activity){
        $this->activity = $activity;
    }
    private function setMinDuration($minDuration){
        $this->minDuration = $minDuration;
    }
    private function setPrice($price){
        $this->price = $price;
    }
    private function setAdditionalComments($additionalComments){
        $this->additionalComments = $additionalComments;
    }
    private function setSpyCam($spyCam){
        $this->spyCam = $spyCam;
    }

    function getTypePrivate(){
        return $this->typePrivate;
    }
    function getActivity(){
        return $this->activity;
    }
    function getMinDuration(){
        return $this->minDuration;
    }
    function getPrice(){
        return $this->price;
    }
    function getAdditionalComments(){
        return $this->additionalComments;
    }
    function getSpyCam(){
        return ($this->spyCam) == 1 ? true : false;
    }

}