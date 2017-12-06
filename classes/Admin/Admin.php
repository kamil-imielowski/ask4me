<?php namespace classes\Admin;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class Admin{
    private $id;
    private $email;
    private $name;
    private $surname;

    function __construct($email){
        $this -> email = $email;
    }

    function login($password){
        $database = dbCon();
        $password = md5($password);
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        if(!$database -> has("users", ["AND"=>["email" => $this -> email, "password" => $password]])){
            throw new \Exception($translate->getString('error-login'));
        }else{
            $sql = $database -> select("users", '*', ["email" => $this -> email]);
            $this -> id = $sql[0]['id'];
            $this -> name = $sql[0]['name'];
            $this -> surname = $sql[0]['surname'];
        } 
    }

    function getName(){
        return $this->name;
    }

    function changePassword($data){
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        $database = dbCon();
        $cpass = md5($data['cpass']);
        if(!$database -> has("users", ["AND"=>["email" => $this -> email, "password" => $cpass]])){
            throw new \Exception($translate->getString('error-invPas'));
        }
        if($data['cpass'] == $data['npass']){
            throw new \Exception($translate->getString('error-npeop'));
        }
        if($data['npass'] != $data['rpass']){
            throw new \Exception($translate->getString('error-rpassN'));
        }
        $pass = md5($data['npass']);
        if(!$database->update("users", ["password" => $pass], ["AND"=>["email" => $this -> email, "password" => $cpass]])){
            throw new \Exception($translate->getString('error-DBUpdate'));
        }
    }
}