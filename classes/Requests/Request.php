<?php namespace classes\Requests;
require_once dirname(dirname(dirname(__FILE__)))."/config/config.php";

class Request{
    private $id;
    private $status;
    private $type;
    private $date;
    private $view;
    private $fromUser;
    private $toUser;
    private $additionalComments;
    private $realatedTableId;

    function __construct($id = null){
        $this->setId($id);
        if(!is_null($id)){
            $this->load();
        }
    }

    protected function load(){
        $database = dbCon();
        $sql = $database->select("requests", '*', ["id" => $this->getId()]);
        foreach($sql as $v){
            $this->setStatus($v['status']);
            $this->setType($v['type']);
            $this->setDate(new \DateTime($v['date']));
            //$this->setView($v["view"] === 1 ? true : false);
            $this->setFromUser(new \classes\User\User($v['from_user_id']));
            $this->setToUser(new \classes\User\User($v['to_user_id']));
            $this->setRelatedTableId($v['related_table_type_id']);
            $this->setAdditionalComments($v['additional_comments']);
        }
    }

    protected function saveToDB($data){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate();
        $plannedDate = new \DateTime($data['date']);
        if(!empty($this->getId())){
            //update
            if(!$database->update("requests", [ "status" => $data['status'],
                                                "date" => $plannedDate->format("Y-m-d H:i:s"),
                                                "additional_comments" => $data['additional_comments'],
                                                "date_updated" => $date], 
                                                ["id" => $this->getId()]))
            {
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
        }else{
            //insert
            if(!$database->insert("requests", [ "status" =>  $data['status'],
                                                "type" => $data['type'],
                                                "related_table_type_id" => $data['related_table_type_id'],
                                                "date" => $plannedDate->format("Y-m-d H:i:s"),
                                                "from_user_id" => $this->getFromUser()->getId(),
                                                "to_user_id" => $this->getToUser()->getId(),
                                                "additional_comments" => $data['additionalComments'],
                                                "date_created" => $date]))
            {
                throw new \Exception($translate->getString("error-DBInsert"));
            }
        }
    }

    protected function setId(int $id){
        $this->id = $id;
    }
    private function setStatus(int $status){
        $this->status = $status;
    }
    protected function setType(int $type){
        $this->type = $type;
    }
    protected function setDate(\DateTime $date){
        $this->date = $date;
    }
    protected function setView(bool $view){
        $this->view = $view;
    }
    protected function setFromUser(\classes\User\User $user){
        $this->fromUser = $user;
    }
    protected function setToUser(\classes\User\User $user){
        $this->toUser = $user;
    }
    protected function setAdditionalComments(string $additionalComments){
        $this->additionalComments = $additionalComments;
    }
    protected function setRelatedTableId(int $id){
        $this->realatedTableId = $id;
    }

    function changeStatus(int $status){
        $database = dbCon();
        if(!$database->update("requests", ["status" => $status, "view_from_user" => 1, "view_to_user" => 1, "date_updated" => date("Y-m-d H:i:s")], ["id" => $this->getId()])){
            $translate = new \classes\Languages\Translate();
            throw new \Exception($translate->getString("error-DBUpdate"));
        }

        if($status == 4){
            if($database->has("planned_activities", ["request_id" => $this->getId()])){
                $sql = $database->select("planned_activities", '*',["request_id" => $this->getId()]);
                foreach($sql as $v){
                    $plannedActivity = new \classes\PlannedActivities\PlannedActivities($v['uder_id'], $v['type'], $v['planned_activity_id']);
                    $plannedActivity->deleteFromDB();
                }
            }
        }
    }

    function changeView($view, $userId){
        $database = dbCon();
        if($database->has("requests", ["AND" => ["from_user_id" => $userId, "id" => $this->getId()]])){
            if(!$database->update("requests", ["view_from_user" => $view, "date_updated" => date("Y-m-d H:i:s")], ["id" => $this->getId()])){
                $translate = new \classes\Languages\Translate();
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
        }
        if($database->has("requests", ["AND" => ["to_user_id" => $userId, "id" => $this->getId()]])){
            if(!$database->update("requests", ["view_to_user" => $view, "date_updated" => date("Y-m-d H:i:s")], ["id" => $this->getId()])){
                $translate = new \classes\Languages\Translate();
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
        }
    }

    function getId(){
        return $this->id;
    }
    function getStatus(){
        return $this->status;
    }
    function getType(){
        return $this->type;
    }
    function getDate(){
        return $this->date;
    }
    function getView(){
        return $this->view;
    }
    function getFromUser(){
        return $this->fromUser;
    }
    function getToUser(){
        return $this->toUser;
    }
    function getAdditionalComments(){
        return $this->additionalComments;
    }
    function getRealatedTableId(){
        return $this->realatedTableId;
    }
}