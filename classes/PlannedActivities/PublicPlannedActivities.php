<?php namespace classes\PlannedActivities;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class PublicPlannedActivities extends PlannedActivities{
    private $broadcastTitle;
    private $activitiesDoSTH;
    private $activitiesVote;

    function __construct($userId, $id = null){
        parent::__construct($userId, 1, $id);
        if(!empty($id)){
            $this->load();
        }
    }

    private function load(){
        $database = dbCon();
        $sql = $database->select("planned_public_activities", '*', ["id" => parent::getPlannedActivityId()]);
        foreach($sql as $v){
            $this->setBroadcastTitle($v['broadcastTitle']);
        }
        $activitiesDoSTH = array();
        $activitiesVote = array();
        $sql = $database->select("planned_activities_to_activity_prices", '*', ["planned_activity_id" => parent::getId()]);
        $i = 0;
        foreach($sql as $v){
            if(!empty($v['public_dosth_id'])){
                $activitiesDoSTH[$i] = new \classes\ActivityPrices\PublicDoSTH(parent::getUser()->getId(), $v['public_dosth_id']);
            }
            if(!empty($v['public_vote_id'])){
                $activitiesVote[$i] = new \classes\ActivityPrices\PublicVote(parent::getUser()->getId(), $v['public_vote_id']);
            }
            $i++;
        }
        $this->setActivitiesDoSTH($activitiesDoSTH);
        $this->setActivitiesVote($activitiesVote);
    }

    function saveToDB($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        $dateTime = date("Y-m-d H:i:s");
        if(empty(parent::getPlannedActivityId())){
            //insert
            if(!$database->insert("planned_public_activities", ["broadcastTitle" => $data['broadcastTitle'], "date_created" => $dateTime])){
                throw new \Exception($translate->getString("error-DBInsert"));
            }
            parent::setPlannedActivityId($database->id());
        }else{
            //update
            if(!$database->update("planned_public_activities", ["broadcastTitle" => $data['broadcastTitle'], "date_updated" => $dateTime], ["id" => parent::getPlannedActivityId()])){
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
        }

        parent::saveToDB(["date" => $data['date']]);

        if($database->has("planned_activities_to_activity_prices", ["planned_activity_id" => parent::getId()])){
            if(!$database->delete("planned_activities_to_activity_prices", ["planned_activity_id" => parent::getId()])){
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
        }
        foreach($data["activity"] as $activity){
            $activityA = explode("|", $activity);
            switch($activityA[0]){
                case 'V':
                    if(!$database->insert("planned_activities_to_activity_prices", ["planned_activity_id" => parent::getId(), "public_vote_id" => $activityA[1], "date_created" => $dateTime])){
                        throw new \Exception($translate->getString("error-DBInsert"));
                    }
                    break;

                case 'D':
                    if(!$database->insert("planned_activities_to_activity_prices", ["planned_activity_id" => parent::getId(), "public_dosth_id" => $activityA[1], "date_created" => $dateTime])){
                        throw new \Exception($translate->getString("error-DBInsert"));
                    }
                    break;
            }
        }
    }

    private function setBroadcastTitle($broadcastTitle){
        $this->broadcastTitle = $broadcastTitle;
    }
    private function setActivitiesDoSTH($activitiesDoSTH){
        $this->activitiesDoSTH = $activitiesDoSTH;
    }
    private function setActivitiesVote($activitiesVote){
        $this->activitiesVote = $activitiesVote;
    }

    function getBroadcastTitle(){
        return $this->broadcastTitle;
    }
    function getActivitiesDoSTH(){
        return $this->activitiesDoSTH;
    }
    function getActivitiesVote(){
        return $this->activitiesVote;
    }
    function getMergeActivities(){
        $activities = array();
        $activities = array_merge($this->getActivitiesDoSTH(), $this->getActivitiesVote());
        return $activities;
    }
}