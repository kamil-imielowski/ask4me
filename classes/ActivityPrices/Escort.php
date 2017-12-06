<?php namespace classes\ActivityPrices;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Escort extends Base{
    private $id;
    private $userId;
    private $typePrice;

    function __construct($userId, $id = null){
        $this->userId = $userId;
        if(!empty($id)){
            $this->id = $id;
            $this->load();
        }
    }

    function saveToDB($data){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate();
        if(empty($this->id)){
            if(!$database->insert("user_model_activity_escort_prices", ["user_id" => $this->userId,
                                                                        "description" => $data['description'],
                                                                        "price" => $data['price'],
                                                                        "price_type" => $data['priceType'],
                                                                        "date_created" => $date]))
            {
                throw new \Exception($translate->getString("error-DBInsert"));
            }
        }else{
            if(!$database->update("user_model_activity_escort_prices", ["description" => $data['description'],
                                                                        "price" => $data['price'],
                                                                        "price_type" => $data['priceType'],
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
        if($database->has("user_model_activity_escort_prices", ["id" => $this->id])){
            if(!$database->delete("user_model_activity_escort_prices", ["id" => $this->id])){
                throw new \Exception($translate->getString("error-DBDelete"));
            }
        }
    }

    private function load(){
        $database = dbCon();
        $sql = $database->select("user_model_activity_escort_prices", '*', ["id" => $this->id]);
        if(!empty($sql)){
            foreach($sql as $v){
                $this->setTypePrice($v['price_type']);
                parent::__construct($v['price'], $v['description']);
            }
        }
    }

    private function setTypePrice($typePrice){
        $this->typePrice = $typePrice;
    }
    function getTypePrice(){
        return $this->typePrice;
    }
    function getId(){
        return $this->id;
    }
}