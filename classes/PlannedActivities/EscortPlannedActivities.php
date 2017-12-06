<?php namespace classes\PlannedActivities;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class EscortPlannedActivities extends PlannedActivities{
    private $activity;
    private $duration;
    private $price;
    private $additionalComments;

    function __construct($userId, $id = null){
        parent::__construct($userId, 4, $id);
        if(!empty($id)){
            $this->load();
        }
    }

    private function load(){
        $database = dbCon();
        $sql = $database->select("planned_escort_activities", '*', ["id" => parent::getPlannedActivityId()]);
        foreach($sql as $v){
            $this->setActivity(new \classes\ActivityPrices\Escort(parent::getUser()->getId() ,$v['escort_activity_id']));
            $this->setDuration($v['duration']);
            $this->setPrice($v['price']);
            $this->setAdditionalComments($v['additional_comments']);
        }
    }

    function saveToDB($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        $dateTime = date("Y-m-d H:i:s");
        if(empty(parent::getPlannedActivityId())){
            //insert
            if(!$database->insert("planned_escort_activities", [    "escort_activity_id"    => $data['activity'],
                                                                    "duration"              => isset($data['duration']) ? $data['duration'] : null,
                                                                    "price"                 => $data['price'],
                                                                    "additional_comments"   => $data['additionalComments'],
                                                                    "date_created"          => $dateTime]))
            {
                throw new \Exception($translate->getString("error-DBInsert"));
            }
            parent::setPlannedActivityId($database->id());
        }else{
            //update
            if(!$database->update("planned_escort_activities", [    "escort_activity_id"    => $data['activity'],
                                                                    "duration"              => isset($data['duration']) ? $data['duration'] : null,
                                                                    "price"                 => $data['price'],
                                                                    "additional_comments"   => $data['additionalComments'],
                                                                    "date_updated"          => $dateTime], 
                                                                [   "id" => parent::getPlannedActivityId()]))
            {
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
        }
        parent::saveToDB(["date" => $data['date'], "request_id" => $data['request_id'], "invited_user_id" => $data['invitedUserId']]);
    }

    private function setActivity(\classes\ActivityPrices\Escort $activity){
        $this->activity = $activity;
    }
    private function setDuration($duration){
        $this->duration = $duration;
    }
    private function setPrice($price){
        $this->price = $price;
    }
    private function setAdditionalComments($additionalComments){
        $this->additionalComments = $additionalComments;
    }

    function getActivity(){
        return $this->activity;
    }
    function getDuration(){
        return $this->duration;
    }
    function getPrice(){
        return $this->price;
    }
    function getAdditionalComments(){
        return $this->additionalComments;
    }
}