<?php
namespace classes\User;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class FollowingFactory{
    private $users;

    function __construct($userId){
        $this->load($userId);
    }

    private function load($userId){
        $database = dbCon();
        $sql = $database->select("follows", "following_id", ["follower_id" => $userId]);
        $users = array();
        foreach($sql as $id){
            $user = new User($id);
            $user->loadCountry();
            $users[] = $user;
            unset($user);
        }

        $this->setUsers($users);
    }

    private function setUsers($users){
        $this->users = $users;
    }

    function getUsers(){
        return $this->users;
    }
}