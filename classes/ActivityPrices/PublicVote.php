<?php namespace classes\ActivityPrices;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class PublicVote{
    private $id;
    private $userId;
    private $firstOption;  /* obiekty klasy BASE */
    private $secondOption;
    private $thirdOption;
    private $votesToWin;

    function __construct($userId, $id = null){
        $this->userId = $userId;
        if(!empty($id)){
            $this->id = $id;
            $this->load();
        }
    }

    private function load(){
        $database = dbCon();
        $sql = $database->select("user_model_activity_public_vote_prices", '*', ["id" => $this->id]);
        if(!empty($sql)){
            foreach($sql as $v){
                $this->setFirstOption(new \classes\ActivityPrices\Base($v['price1'], $v['description1']));
                $this->setSecondOption(new \classes\ActivityPrices\Base($v['price2'], $v['description2']));
                $this->setThirdOption(new \classes\ActivityPrices\Base($v['price3'], $v['description3']));
                $this->setVotesToWin($v['votes_for_win']);
            }
        }
    }

    function saveToDB($data){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate();
        if(empty($this->id)){
            if(!$database->insert("user_model_activity_public_vote_prices", ["user_id" => $this->userId,
                                                                            "description1" => $data['description1'],
                                                                            "price1" => $data['price1'],
                                                                            "description2" => $data['description2'],
                                                                            "price2" => $data['price2'],
                                                                            "description3" => $data['description3'],
                                                                            "price3" => $data['price3'],
                                                                            "votes_for_win" => $data['votesForWin'],
                                                                            "date_created" => $date]))
            {
                throw new \Exception($translate->getString("error-DBInsert"));
            }
        }else{
            if(!$database->update("user_model_activity_public_vote_prices", ["description1" => $data['description1'],
                                                                            "price1" => $data['price1'],
                                                                            "description2" => $data['description2'],
                                                                            "price2" => $data['price2'],
                                                                            "description3" => $data['description3'],
                                                                            "price3" => $data['price3'],
                                                                            "votes_for_win" => $data['votesForWin'],
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
        if($database->has("user_model_activity_public_vote_prices", ["id" => $this->id])){
            if(!$database->delete("user_model_activity_public_vote_prices", ["id" => $this->id])){
                throw new \Exception($translate->getString("error-DBDelete"));
            }
        }
    }

    private function setFirstOption(Base $firstOption){
        $this->firstOption = $firstOption;
    }
    private function setSecondOption(Base $secondOption){
        $this->secondOption = $secondOption;
    }
    private function setThirdOption(Base $thirdOption){
        $this->thirdOption = $thirdOption;
    }
    private function setVotesToWin($votesToWin){
        $this->votesToWin = $votesToWin;
    }

    function getFirstOption(){
        return $this->firstOption;
    }
    function getSecondOption(){
        return $this->secondOption;
    }
    function getThirdOption(){
        return $this->thirdOption;
    }
    function getVotesToWin(){
        return $this->votesToWin;
    }

    function getId(){
        return $this->id;
    }
    function getType(){
        return 1;
    }

}