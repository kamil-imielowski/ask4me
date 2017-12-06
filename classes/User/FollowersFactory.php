<?php
namespace classes\User;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class FollowersFactory{
    private $users;
    private $userId;

    function __construct($userId){+
        $this->setUserId($userId);
        $this->load($userId);
    }

    private function load($userId){
        $database = dbCon();
        $sql = $database->select("follows", "follower_id", ["following_id" => $userId]);
        $users = array();
        foreach($sql as $id){
            $user = new User($id);
            $user->loadCountry();
            $users[] = $user;
            unset($user);
        }

        $this->setUsers($users);
    }

    function getFollowers4HomePage(){
        $database = dbCon();
        $sql = $database->select("follows", "*", ["AND" => ["following_id" => $this->getUserId(), "view" => 1], "ORDER" => ["id" => "DESC"]]);
        $users = array();
        foreach($sql as $v){
            $user = new User($v['follower_id']);
            $users[$v['id']] = $user;
            unset($user);
        }

        return $users;
    }

    private function setUserId(int $id){
        $this->userId = $id;
    }
    private function getUserId(){
        return $this->userId;
    }

    private function setUsers($users){
        $this->users = $users;
    }

    function getUsers(){
        return $this->users;
    }
}