<?php namespace classes\Requests;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class RequestsFactory{
    private $requests;
    private $userId;

    function __construct($userId){
        $this->setUserId($userId);
    }

    private function load($sql){
        $requests = array();

        foreach($sql as $v){
            $fromUser = new \classes\User\User($v['from_user_id']);
            $toUser = new \classes\User\User($v['to_user_id']);
            switch($v['type']){
                case 1:
                case 2:
                    $requests[] = new \classes\Requests\PrivateActivityRequest($fromUser, $toUser, $v['related_table_type_id']);
                    break;

                case 3:
                    $requests[] = new \classes\Requests\EscortActivityRequest($fromUser, $toUser, $v['related_table_type_id']);
                    break;
            }
        }

        $this->setRequests($requests);
    }

    function getReceivedNew(){
        $database = dbCon();
        $sql = $database->select("requests", '*', ["AND" => ["to_user_id" => $this->getUserId(), "date[>=]" => date("Y-m-d H:i:s"), "status" => 1, "view_to_user" => 1]]);
        $this->load($sql);
        return $this->getRequests();
    }
    function getReceivedPending(){
        $database = dbCon();
        $sql = $database->select("requests", '*', ["AND" => ["to_user_id" => $this->getUserId(), "date[>=]" => date("Y-m-d H:i:s"), "status" => 1]]);
        $this->load($sql);
        return $this->getRequests();
    }
    function getReceivedAccepted(){
        $database = dbCon();
        $sql = $database->select("requests", '*', ["AND" => ["to_user_id" => $this->getUserId(), "date[>=]" => date("Y-m-d H:i:s"), "status" => 2]]);
        $this->load($sql);
        return $this->getRequests();
    }
    function getReceivedDeclined(){
        $database = dbCon();
        $sql = $database->select("requests", '*', ["AND" => ["to_user_id" => $this->getUserId(), "status" => 3]]);
        $this->load($sql);
        return $this->getRequests();
    }
    function getReceivedEdited(){
        $database = dbCon();
        $sql = $database->select("requests", '*', ["AND" => ["to_user_id" => $this->getUserId(), "date[>=]" => date("Y-m-d H:i:s"), "status" => 4]]);
        $this->load($sql);
        return $this->getRequests();
    }

    function getSentPending(){
        $database = dbCon();
        $sql = $database->select("requests", '*', ["AND" => ["from_user_id" => $this->getUserId(), "date[>=]" => date("Y-m-d H:i:s"), "status" => 1]]);
        $this->load($sql);
        return $this->getRequests();
    }
    function getSentAccepted(){
        $database = dbCon();
        $sql = $database->select("requests", '*', ["AND" => ["from_user_id" => $this->getUserId(), "date[>=]" => date("Y-m-d H:i:s"), "status" => 2]]);
        $this->load($sql);
        return $this->getRequests();
    }
    function getSentDeclined(){
        $database = dbCon();
        $sql = $database->select("requests", '*', ["AND" => ["from_user_id" => $this->getUserId(), "status" => 3]]);
        $this->load($sql);
        return $this->getRequests();
    }
    function getSentEdited(){
        $database = dbCon();
        $sql = $database->select("requests", '*', ["AND" => ["from_user_id" => $this->getUserId(), "date[>=]" => date("Y-m-d H:i:s"), "status" => 4]]);
        $this->load($sql);
        return $this->getRequests();
    }

    function getHomeRequests(){
        $database = dbCon();
        $requests = array();
        $sql = $database->select("requests", '*',   ["AND #1" => [ "OR" => [   
                                                                            "AND #2" => ["from_user_id" => $this->getUserId(), "view_from_user" => 1], 
                                                                            "AND #3" => ["to_user_id" => $this->getUserId(), "view_to_user" => 1]
                                                                        ], 
                                                                "date[>=]" => date("Y-m-d H:i:s")],
                                                    "ORDER" => ["date_created" => "DESC", "date_updated" => "DESC", "id" => "DESC"]]);
        $i = 0;
        foreach($sql as $v){
            $fromUser = new \classes\User\User($v['from_user_id']);
            $toUser = new \classes\User\User($v['to_user_id']);
            if($v["from_user_id"] == $this->getUserId()){
                $requests[$i]["t"] = 1; // sent
            }elseif($v["to_user_id"] == $this->getUserId()){
                $requests[$i]["t"] = 2; // received
            }
            switch($v['type']){
                case 1:
                case 2:
                    $requests[$i]['r'] = new \classes\Requests\PrivateActivityRequest($fromUser, $toUser, $v['related_table_type_id']);;
                    break;

                case 3:
                    $requests[$i]['r'] = new \classes\Requests\EscortActivityRequest($fromUser, $toUser, $v['related_table_type_id']);
                    break;
            }
            $i++;
        }
        $this->setRequests($requests);
        return $this->getRequests();
    }


    private function setUserId(int $userId){
        $this->userId = $userId;
    }
    private function setRequests(array $requests){
        $this->requests = $requests;
    }

    private function getRequests(){
        return $this->requests;
    }
    private function getUserId(){
        return $this->userId;
    }
}