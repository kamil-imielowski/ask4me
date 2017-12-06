<?php namespace classes\User;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class NotifySettings{
    private $id;
    private $user_id;
    private $privateMessage;
    private $privateMessageEmail;
    private $request;
    private $requestEmail;
    private $followers;
    private $followersEmail;
    private $gift;
    private $giftEmail;
    private $soldProduct;
    private $soldProductEmail;
    private $followingActivity;
    private $followingActivityEmail;
    private $plannedActivity;
    private $plannedActivityEmail;
    private $sound;

    function __construct($user_id){
        $this->user_id = $user_id;
        $this->loadNotifySettings();
    }

    private function loadNotifySettings(){
        $database = dbCon();
        $sql = $database->select("user_notifications_settings", '*', ["user_id" => $this->user_id]);
        if(!empty($sql)){
            foreach($sql as $v){
                $this->setPrivateMessage($v['npw']);
                $this->setPrivateMessageEmail($v['enpm']);
                $this->setRequest($v['nr']);
                $this->setRequestEmail($v['enr']);
                $this->setFollowers($v['nf']);
                $this->setFollowersEmail($v['enf']);
                $this->setGift($v['ng']);
                $this->setGiftEmail($v['eng']);
                $this->setSoldProduct($v['sp']);
                $this->setSoldProductEmail($v['esp']);
                $this->setFollowingActivity($v['afuif']);
                $this->setFollowingActivityEmail($v['eafuif']);
                $this->setPlannedActivity($v['rmataihp']);
                $this->setPlannedActivityEmail($v['ermataihp']);
                $this->setSound($v['sound']);
            }
        }
    }

    function saveToDB($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();        
        if(!$database->update("user_notifications_settings", [  "npw"           => isset($data['npw']) ? 1 : 0,
                                                                "nr"            => isset($data['nr']) ? 1 : 0,
                                                                "nf"            => isset($data['nf']) ? 1 : 0,
                                                                "ng"            => isset($data['ng']) ? 1 : 0,
                                                                "sp"            => isset($data['sp']) ? 1 : 0,
                                                                "afuif"         => isset($data['afuif']) ? 1 : 0,
                                                                "rmataihp"      => isset($data['rmataihp']) ? 1 : 0,
                                                                "sound"         => $data['sound'],
                                                                "enpm"          => isset($data['enpm']) ? 1 : 0,
                                                                "enr"           => isset($data['enr']) ? 1 : 0,
                                                                "enf"           => isset($data['enf']) ? 1 : 0,
                                                                "eng"           => isset($data['eng']) ? 1 : 0,
                                                                "esp"           => isset($data['esp']) ? 1 : 0,
                                                                "eafuif"        => isset($data['eafuif']) ? 1 : 0,
                                                                "ermataihp"     => isset($data['ermataihp']) ? 1 : 0,
                                                                "date_updated"  => date("Y-m-d H:i:s")], 
                                                             ["user_id" => $this->user_id])
        ){
            throw new \Exception($translate->getString('error-DBUpdate'));
        }
    }

    function getPrivateMessage(){
        return $this->privateMessage;
    }
    function getPrivateMessageEmail(){
        return $this->privateMessageEmail;
    }
    function getRequest(){
        return $this->request;
    }
    function getRequestEmail(){
        return $this->requestEmail;
    }
    function getFollowers(){
        return $this->followers;
    }
    function getFollowersEmail(){
        return $this->followersEmail;
    }
    function getGift(){
        return $this->gift;
    }
    function getGiftEmail(){
        return $this->giftEmail;
    }
    function getSoldProduct(){
        return $this->soldProduct;
    }
    function getSoldProductEmail(){
        return $this->soldProductEmail;
    }
    function getFollowingActivity(){
        return $this->followingActivity;
    }
    function getFollowingActivityEmail(){
        return $this->followingActivityEmail;
    }
    function getPlannedActivity(){
        return $this->plannedActivity;
    }
    function getPlannedActivityEmail(){
        return $this->plannedActivityEmail;
    }
    function getSound(){
        return $this->sound;
    }

    private function setPrivateMessage($privateMessage){
        $this->privateMessage = $privateMessage;
    }
    private function setPrivateMessageEmail($privateMessageEmail){
        $this->privateMessageEmail = $privateMessageEmail;
    }
    private function setRequest($request){
        $this->request = $request;
    }
    private function setRequestEmail($requestEmail){
        $this->requestEmail = $requestEmail;
    }
    private function setFollowers($followers){
        $this->followers = $followers;
    }
    private function setFollowersEmail($followersEmail){
        $this->followersEmail = $followersEmail;
    }
    private function setGift($gift){
        $this->gift = $gift;
    }
    private function setGiftEmail($giftEmail){
        $this->giftEmail = $giftEmail;
    }
    private function setSoldProduct($soldProduct){
        $this->soldProduct = $soldProduct;
    }
    private function setSoldProductEmail($soldProductEmail){
        $this->soldProductEmail = $soldProductEmail;
    }
    private function setFollowingActivity($followingActivity){
        $this->followingActivity = $followingActivity;
    }
    private function setFollowingActivityEmail($followingActivityEmail){
        $this->followingActivityEmail = $followingActivityEmail;
    }
    private function setPlannedActivity($plannedActivity){
        $this->plannedActivity = $plannedActivity;
    }
    private function setPlannedActivityEmail($plannedActivityEmail){
        $this->plannedActivityEmail = $plannedActivityEmail;
    }
    private function setSound($sound){
        $this->sound = $sound;
    }
}