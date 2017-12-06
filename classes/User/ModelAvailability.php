<?php namespace classes\User;

class ModelAvailability{
    private $monday;
    private $tuesday;
    private $wednesday;
    private $thursday;
    private $friday;
    private $saturday;
    private $sunday;
    private $userId;

    function __construct($userId){
        $this->userId = $userId;
        $this->loadModelAvailability();
    }

    function saveToDB($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        $date = date("Y-m-d H:i:s");
        if($database->has("user_model_availability", ["user_id" => $this->userId])){
            if(!$database->delete("user_model_availability", ["user_id" => $this->userId])){
                throw new \Exception($translate->getString('error-DBUpdate'));
            }
        }
        foreach($data as $day => $timeRanges){
            foreach($timeRanges['from'] as $key=>$from){
                $from = new \DateTime($from);
                $to = new \DateTime($timeRanges['to'][$key]);
                if($from->getTimestamp() > $to->getTimestamp()){
                    throw new \Exception($translate->getString('incorrTimeRange'));
                }

                if(!empty($timeRanges['from'][$key]) && !empty($timeRanges['to'][$key])){
                    if(!$database->insert("user_model_availability", ["user_id" => $this->userId,
                                                                    "day" => $day,
                                                                    "time_range_from" => $timeRanges['from'][$key], 
                                                                    "time_range_to" => $timeRanges['to'][$key],
                                                                    "date_created" => $date])){
                        throw new \Exception($translate->getString('error-DBInsert'));
                    }
                }
            }
        }
    }

    private function loadModelAvailability(){
        $database = dbCon();
        $sql = $database->select("user_model_availability", '*', ["user_id" => $this->userId]);
        $monday = array(); $mo = 0;
        $tuesday = array(); $tu = 0;
        $wednesday = array(); $we = 0;
        $thursday = array(); $th = 0;
        $friday = array(); $fr = 0;
        $saturday = array(); $sa = 0;
        $sunday = array(); $su = 0;
        if(!empty($sql)){
            foreach($sql as $v){
                switch($v['day']){
                    case 1:
                        $monday[$mo]['from'] = $v['time_range_from'];
                        $monday[$mo]['to'] = $v['time_range_to'];
                        $mo++;
                        break;
                    
                    case 2:
                        $tuesday[$tu]['from'] = $v['time_range_from'];
                        $tuesday[$tu]['to'] = $v['time_range_to'];
                        $tu++;
                        break;

                    case 3:
                        $wednesday[$we]['from'] = $v['time_range_from'];
                        $wednesday[$we]['to'] = $v['time_range_to'];
                        $we++;
                        break;

                    case 4:
                        $thursday[$th]['from'] = $v['time_range_from'];
                        $thursday[$th]['to'] = $v['time_range_to'];
                        $th++;
                        break;

                    case 5:
                        $friday[$fr]['from'] = $v['time_range_from'];
                        $friday[$fr]['to'] = $v['time_range_to'];
                        $fr++;
                        break;

                    case 6:
                        $saturday[$sa]['from'] = $v['time_range_from'];
                        $saturday[$sa]['to'] = $v['time_range_to'];
                        $sa++;
                        break;

                    case 7:
                        $sunday[$su]['from'] = $v['time_range_from'];
                        $sunday[$su]['to'] = $v['time_range_to'];
                        $su++;
                        break;
                }
            }
        }

        $this->setMonday($monday);
        $this->setTuesday($tuesday);
        $this->setWednesday($wednesday);
        $this->setThursday($thursday);
        $this->setFriday($friday);
        $this->setSaturday($saturday);
        $this->setSunday($sunday);
    }

    private function setMonday($monday){
        $this->monday = $monday;
    }
    private function setTuesday($tuesday){
        $this->tuesday = $tuesday;
    }
    private function setWednesday($wednesday){
        $this->wednesday = $wednesday;
    }
    private function setThursday($thursday){
        $this->thursday = $thursday;
    }
    private function setFriday($friday){
        $this->friday = $friday;
    }
    private function setSaturday($saturday){
        $this->saturday = $saturday;
    }
    private function setSunday($sunday){
        $this->sunday = $sunday;
    }

    function getMonday(){
        return $this->monday;
    }
    function getTuesday(){
        return $this->tuesday;
    }
    function getWednesday(){
        return $this->wednesday;
    }
    function getThursday(){
        return $this->thursday;
    }
    function getFriday(){
        return $this->friday;
    }
    function getSaturday(){
        return $this->saturday;
    }
    function getSunday(){
        return $this->sunday;
    }
}