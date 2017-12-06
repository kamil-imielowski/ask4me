<?php namespace classes\ActivityPrices;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class PrivatePerformance extends Base{
    private $id;
    private $userId;
    private $type;
    private $spyCam; //true - mozna || false - nie mozna
    private $spyCamPrice;

    function __construct($userId, $id = null){
        $this->userId = $userId;
        if(!empty($id)){
            $this->id = $id;
            $this->load();
        }
    }

    private function load(){
        $database = dbCon();
        $sql = $database->select("user_model_activity_private_prices", '*', ["id" => $this->id]);
        if(!empty($sql)){
            foreach($sql as $v){
                $this->setType($v['type']);
                parent::__construct($v['price'], $v['description']);
                if($v['spycam'] == 1){
                    $this->setSpyCam(true);
                    $this->setSpyCamPice($v['spy_cam_price']);
                }else{
                    $this->setSpyCam(false);
                    $this->setSpyCamPice(null);
                }
            }
        }
    }

    function saveToDB($data){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate();
        if(empty($this->id)){
            if(!$database->insert("user_model_activity_private_prices", ["user_id" => $this->userId,
                                                                        "type" => $data['type'],
                                                                        "description" => $data['description'],
                                                                        "price" => $data['price'],
                                                                        "spycam" => isset($data['spycam']) ? 1 : 0,
                                                                        "spy_cam_price" => isset($data['spyCamPrice']) ? $data['spyCamPrice'] : null,
                                                                        "date_created" => $date]))
            {
                throw new \Exception($translate->getString("error-DBInsert"));
            }
        }else{
            if(!$database->update("user_model_activity_private_prices", ["type" => $data['type'],
                                                                        "description" => $data['description'],
                                                                        "price" => $data['price'],
                                                                        "spycam" => isset($data['spycam']) ? 1 : 0,
                                                                        "spy_cam_price" => isset($data['spyCamPrice']) ? $data['spyCamPrice'] : null,
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
        if($database->has("user_model_activity_private_prices", ["id" => $this->id])){
            if(!$database->delete("user_model_activity_private_prices", ["id" => $this->id])){
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

    private function setType($type){
        $this->type = $type;
    }
    function getType(){
        return $this->type;
    }

    private function setSpyCam($spyCam){
        $this->spyCam = $spyCam;
    }
    function getSpyCam(){
        return $this->spyCam;
    }

    private function setSpyCamPice($spyCamPrice){
        $this->spyCamPrice = $spyCamPrice;
    }
    function getSpyCamPrice(){
        return $this->spyCamPrice;
    }
}