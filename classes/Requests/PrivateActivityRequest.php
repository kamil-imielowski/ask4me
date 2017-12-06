<?php namespace classes\Requests;
require_once dirname(dirname(dirname(__FILE__)))."/config/config.php";

class PrivateActivityRequest extends Request{
    private $privateRequestId;
    private $privateRequestType;
    private $activity;
    private $minDuration;
    private $price; /* per minute */
    private $spyCam;

    function __construct(\classes\User\User $fromUser, \classes\User\User $toUser, int $privateRequestId = null){
        parent::setFromUser($fromUser);
        parent::setToUser($toUser);
        if(!empty($privateRequestId)){
            $this->setPrivateRequestId($privateRequestId);
            $this->load();
        }
    }

    protected function load(){
        $database = dbCon();
        $sql = $database->select("requests_private", '*', ["id" => $this->getPrivateRequestId()]);
        foreach($sql as $v){
            $this->setType($v['type']);
            $this->setActivity(new \classes\ActivityPrices\PrivatePerformance(parent::getToUser()->getId(), $v['activity_id']));
            $this->setMinDuration($v['min_duration']);
            $this->setPrice($v['price']);
            $this->setSpyCam($v['spy_cam'] == 1 ? true : false);
        }
        $requestId = $database->select("requests", 'id', ["AND" => ["type" => $this->getType(), "related_table_type_id" => $this->getPrivateRequestId()]]);
        parent::setId($requestId[0]);
        parent::load();
    }

    function saveToDB($data){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        if(!empty($this->getPrivateRequestId())){
            //update
            if(!$database->update("requests_private", [ "type"          => $data['type'], 
                                                        "activity_id"   => $data['activity'], 
                                                        "min_duration"  => $data['minDuration'], 
                                                        "price"         => $data['price'], 
                                                        "spy_cam"       => isset($data['spyCam']) ? 1 : 0, 
                                                        "date_updated"  => $date], 
                                                        ["id"           => $this->getPrivateRequestId()]))
            {
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
        }else{
            //insert
            if(!$database->insert("requests_private", [ "type"          => $data['type'], 
                                                        "activity_id"   => $data['activity'], 
                                                        "min_duration"  => $data['minDuration'], 
                                                        "price"         => $data['price'], 
                                                        "spy_cam"       => isset($data['spyCam']) ? 1 : 0, 
                                                        "date_created"  => $date]))
            {
                throw new \Exception($translate->getString("error-DBInsert"));
            }
            $this->setPrivateRequestId($database->id());
        }

        parent::saveToDB(array_merge(["related_table_type_id" => $this->getPrivateRequestId()], $data));
    }

    function changeRequestToPlannedActivity(){
        $PPA = new \classes\PlannedActivities\PrivatePlannedActivities(parent::getFromUser()->getId(), parent::getType() + 1);
        //throw new \Exception("minDuration =>".$this->getMinDuration()." price =>".$this->getPrice());
        $PPA->saveToDB(["date" => parent::getDate()->format("Y-m-d H:i:s"), 
                        "invitedUserId" => parent::getToUser()->getId(), 
                        "privateType" => parent::getType(),
                        "activity" => $this->getActivity()->getId(),
                        "minDuration" => $this->getMinDuration(),
                        "price" => $this->getPrice(),
                        "request_id" => parent::getId(),
                        "additionalComments" => $this->getAdditionalComments(),
                        "spyCam" => $this->getSpyCam() ? true : null,
                        ]);		
    }

    private function setPrivateRequestId(/* int */$id){
        $this->privateRequestId = $id;
    }
    private function setPrivateRequestType(/* int */$type){
        $this->privateRequestType = $type;
    }
    private function setActivity(\classes\ActivityPrices\PrivatePerformance $activity){
        $this->activity = $activity;
    }
    private function setMinDuration(/* int */$duration){
        $this->minDuration = $duration;
    }
    private function setPrice(/* int */$price){
        $this->price = $price;
    }
    private function setSpyCam(/* boolean */$spyCam){
        $this->spyCam = $spyCam;
    }

    function getPrivateRequestId(){
        return $this->privateRequestId;
    }
    function getPrivateRequestType(){
        return $this->privateRequestType;
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
    function getSpyCam(){
        return $this->spyCam;
    }
}