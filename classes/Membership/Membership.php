<?php namespace classes\Membership;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Membership{
    private $id;
    private $userId;
    private $type;
    private $validTo;

    function __construct($userId){
        $this->userId = $userId;
        $this->loadMembership();
    }

    function saveToDB($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
    }

    private function loadMembership(){
        $database = dbCon();
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        $sql = $database->select("memberships", '*', ["user_id" => $this->userId]);
        if(!empty($sql)){
            foreach($sql as $v){
                $this->setId($v['id']);
                $this->setType($v['type']);
                $this->setValidTo($v['valid_to']);
            }
        }else{

        }
    }

    function getId(){
        return $this->id;
    }
    function getType(){
        return $this->type;
    }
    function getStringType(){
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        switch($this->type){
            case 1: 
                return $translate->getString('basicMembership');
                break;

            case 2:
                return $translate->getString('vipMembership');
                break;

            default:
                return $translate->getString('freeMembership');
        }
    }

    function getValidTo(){
        $date = new \DateTime($this->validTo);
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        return !empty($this->validTo) ? $translate->getString('validTo')." ".$date->format('d.m.Y') : "";
    }

    private function setId($id){
        $this->id = $id;
    }
    private function setType($type){
        $this->type = $type;
    }
    private function setValidTo($validTo){
        $this->validTo = $validTo;
    }
}