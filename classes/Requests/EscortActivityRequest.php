<?php namespace classes\Requests;
require_once dirname(dirname(dirname(__FILE__)))."/config/config.php";

class EscortActivityRequest extends Request{
    private $escortId;
    private $activity;
    private $duration;
    private $price;

    function __construct(\classes\User\User $fromUser, \classes\User\User $toUser, int $escortId = null){
        parent::setFromUser($fromUser);
        parent::setToUser($toUser);
        if(!empty($escortId)){
            $this->setEscortId($escortId);
            $this->load();
        }
    }

    protected function load(){
        $database = dbCon();
        $sql = $database->select("requests_escort", '*', ["id" => $this->getEscortId()]);
        foreach($sql as $v){
            $this->setActivity(new \classes\ActivityPrices\Escort(parent::getToUser()->getId(), $v['activity_id']));
            is_null($v['duration']) ? : $this->setDuration($v['duration']);
            $this->setPrice($v['price']);
        }
        $requestId = $database->select("requests", 'id', ["AND" => ["type" => 3, "related_table_type_id" => $this->getEscortId()]]);
        parent::setId($requestId[0]);
        parent::load();
    }

    function saveToDB($data){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        if(!empty($this->getEscortId())){
            //update
            if(!$database->update("requests_escort", [  "activity_id"   => $data['activity'], 
                                                        "duration"      => isset($data['duration']) ? $data['duration'] : null, 
                                                        "price"         => $data['price'], 
                                                        "date_updated"  => $date], 
                                                        ["id"           => $this->getEscortId()]))
            {
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
        }else{
            //insert
            if(!$database->insert("requests_escort", [  "activity_id"   => $data['activity'], 
                                                        "duration"      => isset($data['duration']) ? $data['duration'] : null, 
                                                        "price"         => $data['price'], 
                                                        "date_created"  => $date]))
            {
                throw new \Exception($translate->getString("error-DBInsert"));
            }
            $this->setEscortId($database->id());
        }

        parent::saveToDB(array_merge(["related_table_type_id" => $this->getEscortId()], $data));
    }

    function changeRequestToPlannedActivity(){
        $PPA = new \classes\PlannedActivities\EscortPlannedActivities(parent::getFromUser()->getId());
        $PPA->saveToDB(["date" => parent::getDate()->format("Y-m-d H:i:s"), 
                        "invitedUserId" => parent::getToUser()->getId(),
                        "activity" => $this->getActivity()->getId(),
                        "duration" => $this->getDuration(),
                        "price" => $this->getPrice(),
                        "request_id" => parent::getId(),
                        "additionalComments" => $this->getAdditionalComments()
                        ]);		
    }

    private function setEscortId(int $escortId){
        $this->escortId = $escortId;
    }
    private function setDuration(int $duration){
        $this->duration = $duration;
    }
    private function setActivity(\classes\ActivityPrices\Escort $activity){
        $this->activity = $activity;
    }
    private function setPrice(int $price){
        $this->price = $price;
    }


    function getEscortId(){
        return $this->escortId;
    }
    function getDuration(){
        return $this->duration;
    }
    function getActivity(){
        return $this->activity;
    }
    function getPrice(){
        return $this->price;
    }
}