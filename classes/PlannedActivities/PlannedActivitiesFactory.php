<?php namespace classes\PlannedActivities;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class PlannedActivitiesFactory{
    private $plannedActivities;
    private $startSoon;

    function __construct($user_id, $date = null, $keywords = null){ 
        $this->load($user_id, $date, $keywords);
        $this->startSoon($user_id);
    }

    private function load($user_id, $date, $keywords){
        $database = dbCon();
        $plannedActivities = array();

        if(empty($date)){
            //$sql = $database->select("planned_activities", '*', ["AND" => ['user_id' => $user_id, "planned_date[>=]" => date("Y-m-d H:i:s")], "ORDER" => "planned_date"]);

            $sql = $database->select("planned_activities", '*', ["AND" =>   [ 
                                                                                "OR" => [
                                                                                            'user_id' => $user_id, 
                                                                                            'invited_user_id' => $user_id
                                                                                        ],
                                                                                "planned_date[>=]" => date("Y-m-d H:i:s")
                                                                            ], 
                                                                 "ORDER" => "planned_date"]);

        }else{
            //$sql = $database->select("planned_activities", '*', ["AND" => ['user_id' => $user_id, "planned_date[~]" => $date]]);
            $sql = $database->select("planned_activities", '*', ["AND" =>   [ 
                                                                                "OR" => [
                                                                                            'user_id' => $user_id, 
                                                                                            'invited_user_id' => $user_id
                                                                                        ],
                                                                                "planned_date[~]" => $date
                                                                            ], 
                                                                 "ORDER" => "planned_date"]);
        }
        
        if(!empty($sql)){
            foreach($sql as $v){
                switch($v['type']){
                    case '1':
                        $plannedActivities[] = new PublicPlannedActivities($user_id, $v['planned_activity_id']);
                        break;

                    case '2':
                        $plannedActivities[] = new PrivatePlannedActivities($user_id, 2, $v['planned_activity_id']);
                        break;

                    case '3':
                        $plannedActivities[] = new PrivatePlannedActivities($user_id, 3, $v['planned_activity_id']);
                        break;

                    case '4':
                        $plannedActivities[] = new EscortPlannedActivities($user_id, $v['planned_activity_id']);
                        break;
                }
            }
        }

        if(!empty($keywords)){
            foreach($plannedActivities as $k => $plannedActivity){
                switch($plannedActivity->getType()){
                    case '1':
                        if(strpos(strtolower($plannedActivity->getBroadcastTitle()), strtolower($keywords)) === false){
                            unset($plannedActivities[$k]);
                        }
                        break;

                    case '2':
                        if(strpos(strtolower($plannedActivity->getInvitedUser()->getLogin()), strtolower($keywords)) === false){
                            unset($plannedActivities[$k]);
                        }
                        break;

                    case '2':
                        if(strpos(strtolower($plannedActivity->getInvitedUser()->getLogin()), strtolower($keywords)) === false){
                            unset($plannedActivities[$k]);
                        }
                        break;
                }
            }
        }

        $this->setPlannedActivities($plannedActivities);
    }

    private function startSoon($user_id){
        $database = dbCon();
        $sql = $database->select("planned_activities", '*', ["AND" => [ "OR" =>['user_id' => $user_id, 'invited_user_id' => $user_id], "planned_date[<>]" => [date("Y-m-d H:i:s"), date("Y-m-d H:i:s", strtotime("+30 minutes"))]]]);
        if(!empty($sql)){
            foreach($sql as $v){
                switch($v['type']){
                    case '1':
                        $startingActivity = new PublicPlannedActivities($user_id, $v['planned_activity_id']);
                        break;

                    case '2':
                        $startingActivity = new PrivatePlannedActivities($user_id, 2, $v['planned_activity_id']);
                        break;

                    case '3':
                        $startingActivity = new PrivatePlannedActivities($user_id, 3, $v['planned_activity_id']);
                        break;

                    case '4':
                        $startingActivity = new EscortPlannedActivities($user_id, $v['planned_activity_id']);
                        break;
                }
            }
        }else{
            $startingActivity = null;
        }

        $this->setStartSoon($startingActivity);
        if (false !== $key = array_search($this->getStartSoon(), $this->getPlannedActivities())) {
            $activities = $this->getPlannedActivities();
            unset($activities[$key]);
            $this->setPlannedActivities($activities);
        }
    }

    private function setPlannedActivities($plannedActivities){
        $this->plannedActivities = $plannedActivities;
    }
    private function setStartSoon($startSoon){
        $this->startSoon = $startSoon;
    }

    function getHightLightDates(){
        
    }

    function getPlannedActivities(){
        return $this->plannedActivities;
    }
    function getStartSoon(){
        return $this->startSoon;
    }

    function getPlannedActivitiesLimit($limit){
        return array_slice($this->plannedActivities, 0, $limit);
    }
}