<?php namespace classes\ActivityPrices;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class PublicDoSTH extends Base{
    private $id;
    private $userId;

    function __construct($userId, $id = null){
        $this->userId = $userId;
        if(!empty($id)){
            $this->id = $id;
            $this->load();
        }
    }

    private function load(){
        $database = dbCon();
        $sql = $database->select("user_model_activity_public_dosth_prices", '*', ["id" => $this->id]);
        if(!empty($sql)){
            foreach($sql as $v){
                parent::__construct($v['price'], $v['description']);
            }
        }
    }

    function saveToDB($data){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate();
        if(empty($this->id)){
            if(!$database->insert("user_model_activity_public_dosth_prices", ["user_id" => $this->userId,
                                                                        "description" => $data['description'],
                                                                        "price" => $data['price'],
                                                                        "date_created" => $date]))
            {
                throw new \Exception($translate->getString("error-DBInsert"));
            }
        }else{
            if(!$database->update("user_model_activity_public_dosth_prices", ["description" => $data['description'],
                                                                        "price" => $data['price'],
                                                                        "date_updated" => $date],
                                                                        ["id" => $this->id]))
            {
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
        }
    }

    function deleteFromDB(){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        if($database->has("user_model_activity_public_dosth_prices", ["id" => $this->id])){
            if(!$database->delete("user_model_activity_public_dosth_prices", ["id" => $this->id])){
                throw new \Exception($translate->getString("error-DBDelete"));
            }
        }
    }

    private function setId($id){
        $this->id = $id;
    }
    function getId(){
        return $this->id;
    }
    function getType(){
        return 2;
    }
}