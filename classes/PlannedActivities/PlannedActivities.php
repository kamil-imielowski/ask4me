<?php namespace classes\PlannedActivities;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class PlannedActivities{
    private $id;
    private $user;
    private $invitedUser;
    private $type;
    private $plannedActivityId;//id z tabeli danego typu aktywnosci
    private $date;

    function __construct($userId, $type, $plannedActivityId){
        $this->setUser(new \classes\User\User($userId));
        $this->setType($type);
        if(!empty($plannedActivityId)){
            $this->setPlannedActivityId($plannedActivityId);
            $this->load();
        }
    }

    private function load(){
        $database = dbCon();
        $sql = $database->select("planned_activities", '*', ["AND" => [ "OR" => ["user_id" => $this->getUser()->getId(), "invited_user_id" => $this->getUser()->getId()], "type" => $this->getType(), "planned_activity_id" => $this->getPlannedActivityId()] ]);
        if(!empty($sql)){
            foreach($sql as $v){
                $this->setId($v['id']);
                $this->setDate(new \DateTime($v['planned_date']));
                if(!is_null($v['invited_user_id'])){
                    $this->setUser(new \classes\User\User($v['user_id']));
                    $this->setInvitedUser(new \classes\User\User($v['invited_user_id']));
                }
            }
        }
    }

    function saveToDB($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        $dateTime = date("Y-m-d H:i:s");
        $date = new \DateTime($data['date']);
        if(empty($this->id)){
            //insert
            if(!$database->insert("planned_activities", [   "user_id"               => $this->getUser()->getId(), 
                                                            "type"                  => $this->getType(),
                                                            "invited_user_id"       => isset($data['invited_user_id']) ? $data['invited_user_id'] : null,
                                                            "request_id"            => isset($data['request_id']) ? $data['request_id'] : null,
                                                            "planned_activity_id"   => $this->getPlannedActivityId(), 
                                                            "planned_date"          => $date->format("Y-m-d H:i:s"), 
                                                            "date_created"          => $dateTime]))
            {
                throw new \Exception($translate->getString("error-DBInsert"). "PlannedActivities");
            }
            $this->setId($database->id());
        }else{
            //update
            if(!$database->update("planned_activities", [   "planned_date" => $date->format("Y-m-d H:i:s"), 
                                                            "date_updated" => $dateTime],
                                                        [   "id" => $this->getId()]))
            {
                throw new \Exception($translate->getString("error-DBUpdate"). "PlannedActivities");
            }
        }
    }

    function deleteFromDB(){
        $database = dbCon();
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        switch($this->getType()){
            case 1:
                if($database->has("planned_activities_to_activity_prices", ["planned_activity_id" => $this->id])){
                    if(!$database->delete("planned_activities_to_activity_prices", ["planned_activity_id" => $this->id])){
                        throw new \Exception($translate->getString("error-DBDelete"));
                    }
                }
                if($database->has("planned_public_activities", ["id" => $this->plannedActivityId])){
                    if(!$database->delete("planned_public_activities", ["id" => $this->plannedActivityId])){
                        throw new \Exception($translate->getString("error-DBDelete"));
                    }
                }
                break;
                
            case 2:
            case 3:
                if($database->has("planned_private_activities", ["id" => $this->plannedActivityId])){
                    if(!$database->delete("planned_private_activities", ["id" => $this->plannedActivityId])){
                        throw new \Exception($translate->getString("error-DBDelete"));
                    }
                }
                break;

            case 4:
                if($database->has("planned_escort_activities", ["id" => $this->plannedActivityId])){
                    if(!$database->delete("planned_escort_activities", ["id" => $this->plannedActivityId])){
                        throw new \Exception($translate->getString("error-DBDelete"));
                    }
                }
                break;
        }
        
        if($database->has("planned_activities", ["id" => $this->id])){
            if(!$database->delete("planned_activities", ["id" => $this->id])){
                throw new \Exception($translate->getString("error-DBDelete"));
            }
        }
    }

    private function setId($id){
        $this->id = $id;
    }
    private function setUser(\classes\User\User $user){
        $this->user = $user;
    }
    private function setType($type){
        $this->type = $type;
    }
    protected function setPlannedActivityId($plannedActivityId){
        $this->plannedActivityId = $plannedActivityId;
    }
    private function setDate(\DateTime $date){
        $this->date = $date;
    }
    private function setInvitedUser(\classes\User\User $user){
        $this->invitedUser = $user;
    }
    

    function getId(){
        return $this->id;
    }
    function getUser(){
        return $this->user;
    }
    function getType(){
        return $this->type;
    }
    function getPlannedActivityId(){
        return $this->plannedActivityId;
    }
    function getDate(){
        return $this->date;
    }
    function getInvitedUser(){
        return $this->invitedUser;
    }

    function getStaringMinutesDiferential(){
        $today = new \DateTime("now");
        $interval = $today->diff($this->getDate());
        return $interval->format('%i%');
    }
}