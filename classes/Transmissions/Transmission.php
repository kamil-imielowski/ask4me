<?php namespace classes\Transmissions;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Transmission{
    private $id;
    private $user;
    private $activityDate;
    private $activity; //planed activity 
    private $viewers;
    private $startedDate;
    private $tipPayers;
    private $tokensReceived;
    private $transmissionActivityProgress; //lista aktualnego eptapu activity
    private $currentTAPID; // id of current activity progress
    private $currentActivity; // aobiekt aktywnosci - init w loadtransmissionActivityProgress
    private $currentActivityProgress;
    private $changeCurrentActivity; //boolean

    function __construct(\classes\User\User $user = null){
        if(!is_null($user)){
            $this->setUser($user);
            $this->__load();
        }
    }

    private function __load(){
        $database = dbCon();
        $sql = $database->select("transmissions", '*', ["AND" => ["user_id" => $this->getUser()->getId(), "activity_date[>=]" => date("Y-m-d H:i:s", strtotime("-80 sec"))]]);
        if(empty($sql)){
            $translate = new \classes\Languages\Translate($_COOKIE['lang']);
            throw new \Exception($translate->getString("error-Transmission"));
        }
        foreach($sql as $v){
            $this->setId($v['id']);
            $this->setActivityDate(new \DateTime($v['activity_date']));
            $this->setViewers($v['viewers']);
            $this->setStartedDate(new \DateTime($v['date_started']));
            switch($v['type']){
                case 1:
                    $this->setActivity(new \classes\PlannedActivities\PublicPlannedActivities($this->getUser()->getId(), $v['planned_activity_id']));
                    $sql = $database->select("transmission_tips", ["[>]customers" => ["user_id" => "id"]], ["transmission_tips.amount(amount)", "customers.login(login)"], ["transmission_tips.transmision_id" => $this->getId()]);
                    $tipPayers = array();
                    $tokensReceived = 0;
                    foreach($sql as $v){
                        if(!isset($tipPayers[$v['login']])){
                            $tipPayers[$v['login']]["amount"] = $v['amount'];
                        }else{
                            $tipPayers[$v['login']]["amount"] += $v['amount'];
                        }
                        $tokensReceived += $v['amount'];
                    }
                    $this->setTipPayers($tipPayers);
                    $this->setTokensReceived($tokensReceived);
                    $this->loadTransmissionActivityProgress();
                    $this->setchangeCurrentActivity(false);
                    break;

                case 2:
                    $this->setActivity(new \classes\PlannedActivities\PrivatePlannedActivities($this->getUser()->getId(), 2, $v['planned_activity_id']));
                    break;

                case 3:
                    $this->setActivity(new \classes\PlannedActivities\PrivatePlannedActivities($this->getUser()->getId(), 3, $v['planned_activity_id']));
                    break;
            }   
        }

    }

    function __create(\classes\PlannedActivities\PlannedActivities $activity){
        $database = dbCon();
        if(!$database->insert("transmissions", ["type" => $activity->getType(),
                                                "user_id" => $activity->getUser()->getId(),
                                                "planned_activity_id" => $activity->getPlannedActivityId(),
                                                "activity_date" => date("Y-m-d H:i:s"),
                                                "date_started" => date("Y-m-d H:i:s")]))
        {
            $translate = new \classes\Languages\Translate($_COOKIE['lang']);
            throw new \Exception($translate->getString("error-TransmissionCreate"));
        }

        $this->setId($database->id());

        $status = "current";
        if($activity->getType() == 1){
            foreach($activity->getMergeActivities() as $k => $specaActivity){
                switch($specaActivity->getType()){
                    case 1:
                        if(!$database->insert("transmission_activity_progress", ["transmission_id" => $this->getId(), 
                                                                                "status" => $status, 
                                                                                "type" => 1, 
                                                                                "activity_id" => $specaActivity->getId(), 
                                                                                "date_created" => date("Y-m-d H:i:s"), 
                                                                                "date_updated" => date("Y-m-d H:i:s")]))
                        {
                            $translate = new \classes\Languages\Translate($_COOKIE['lang']);
                            throw new \Exception($translate->getString("error-TransmissionCreate"));
                        }
                        break; 
                
                    case 2: 
                        if(!$database->insert("transmission_activity_progress", ["transmission_id" => $this->getId(), 
                                                                                "status" => $status, 
                                                                                "type" => 2, 
                                                                                "activity_id" => $specaActivity->getId(), 
                                                                                "date_created" => date("Y-m-d H:i:s"), 
                                                                                "date_updated" => date("Y-m-d H:i:s")]))
                        {
                            $translate = new \classes\Languages\Translate($_COOKIE['lang']);
                            throw new \Exception($translate->getString("error-TransmissionCreate"));
                        }
                        break;
                }
                $status = "upcoming";
            }
        }
        
    }

    function updateActivity(){
        $database = dbCon();
        if(!$database->update("transmissions", ["activity_date" => date("Y-m-d H:i:s")], ["id" => $this->getId()])){
            $translate = new \classes\Languages\Translate($_COOKIE['lang']);
            throw new \Exception($translate->getString("error-DBUpdate"));
        }
    }

    function __stop(){
        $database = dbCon();
        if(!$database->update("transmissions", ["activity_date" => date("Y-m-d H:i:s", strtotime("-80 sec")), "date_stopped" => date("Y-m-d H:i:s")], ["id" => $this->getId()])){
            $translate = new \classes\Languages\Translate($_COOKIE['lang']);
            throw new \Exception($translate->getString("error-DBUpdate"));
        }
    }

    function takeTip(\classes\User\User $tipPayer, int $amount){
        $database = dbCon();
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        if(!$database->has("customers", ["AND" => ["id" => $tipPayer->getId(), "tokens[>=]" => $amount]])){
            throw new \Exception($translate->getString("notEnoughTokens"));
        }
        if(!$database->insert("transmission_tips", ["transmision_id" => $this->getId(), "amount" => $amount, "user_id" => $tipPayer->getId(), "date_created" => date("Y-m-d H:i:s")])){
            throw new \Exception($translate->getString("error-DBUpdate"));
        }
        $tipPayer->updateTokens($amount * -1);
        $this->getUser()->updateTokens($amount);
    }

    private function loadTransmissionActivityProgress(){
        $database = dbCon();
        $transmissionActivityProgress = array();
        $sqlq = $database->select("transmission_activity_progress", '*', ["transmission_id" => $this->getId()]);
        foreach($sqlq as $v){

            $transmissionActivityProgress[$v['type']][$v['activity_id']] = $v['status'];

            if($v['status'] == "current"){
                $this->setCurrentTAPID($v['id']);
                switch($v['type']){
                    case 1: //public vote
                        $currentActivity = new \classes\ActivityPrices\PublicVote($this->getUser()->getId(), $v['activity_id']);
                        $currentActivityProgress = array("option1" => 0, "option2" => 0, "option3" => 0);
                        $sql = $database->select("transmission_progress_details_public_vote", '*', ["tap_id" => $this->getCurrentTAPID()]);
                        foreach($sql as $val){
                            if(!is_null($val['opt1'])){
                                $currentActivityProgress['option1']++;
                            }elseif(!is_null($val['opt2'])){
                                $currentActivityProgress['option2']++;
                            }elseif(!is_null($val['opt3'])){
                                $currentActivityProgress['option3']++;
                            }
                        }
                        break;

                    case 2: //public do sth
                        $currentActivity = new \classes\ActivityPrices\PublicDoSTH($this->getUser()->getId(), $v['activity_id']);
                        $currentActivityProgress = 0;
                        $sql = $database->select("transmission_progress_details_public_dosth", '*', ["tap_id" => $this->getCurrentTAPID()]);
                        foreach($sql as $val){
                            $currentActivityProgress += $val['amount'];
                        }
                        break;
                }
                $this->setCurrentActivity($currentActivity);
                $this->setCurrentActivityProgress($currentActivityProgress);
            }

        }
        $this->setTransmissionActivityProgress($transmissionActivityProgress);
    }

    function vote($user, $option){ //glosowanie na aktywność
        $database = dbCon();
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        if($this->getCurrentActivityProgress()['option1'] == $this->getCurrentActivity()->getVotesToWin() || $this->getCurrentActivityProgress()['option2'] == $this->getCurrentActivity()->getVotesToWin() || $this->getCurrentActivityProgress()['option3'] == $this->getCurrentActivity()->getVotesToWin() ){
            throw new \Exception($translate->getString("voteEnded"));
        }
        switch($option){
            case 'option1':
                $amount = $this->getCurrentActivity()->getFirstOption()->getPrice();
                if($user->getTokens() - $amount <= -1){
                    $translate = new \classes\Languages\Translate($_COOKIE['lang']);
                    throw new \Exception($translate->getString("notEnoughTokens"));
                }
                if(!$database->insert("transmission_progress_details_public_vote", ["tap_id" => $this->getCurrentTAPID(), "user_id" => $user->getId(), "opt1" => 1, "date_created" => date("Y-m-d H:i:s")])){
                    throw new \Exception($translate->getString("error-DBUpdate"));                    
                }
                break;

            case 'option2':
                $amount = $this->getCurrentActivity()->getSecondOption()->getPrice();       
                if($user->getTokens() - $amount <= -1){
                    $translate = new \classes\Languages\Translate($_COOKIE['lang']);
                    throw new \Exception($translate->getString("notEnoughTokens"));
                }     
                if(!$database->insert("transmission_progress_details_public_vote", ["tap_id" => $this->getCurrentTAPID(), "user_id" => $user->getId(), "opt2" => 1, "date_created" => date("Y-m-d H:i:s")])){
                    throw new \Exception($translate->getString("error-DBUpdate"));                    
                }
                break;

            case 'option3':
                $amount = $this->getCurrentActivity()->getThirdOption()->getPrice();
                if($user->getTokens() - $amount <= -1){
                    $translate = new \classes\Languages\Translate($_COOKIE['lang']);
                    throw new \Exception($translate->getString("notEnoughTokens"));
                }
                if(!$database->insert("transmission_progress_details_public_vote", ["tap_id" => $this->getCurrentTAPID(), "user_id" => $user->getId(), "opt3" => 1, "date_created" => date("Y-m-d H:i:s")])){
                    throw new \Exception($translate->getString("error-DBUpdate"));                    
                }
                break;
        }
        $this->loadTransmissionActivityProgress();
        if($this->getCurrentActivityProgress()['option1'] == $this->getCurrentActivity()->getVotesToWin() || $this->getCurrentActivityProgress()['option2'] == $this->getCurrentActivity()->getVotesToWin() || $this->getCurrentActivityProgress()['option3'] == $this->getCurrentActivity()->getVotesToWin() ){
            $this->setChangeCurrentActivity(true);
            $this->nextActivityStatusChange();
        }
        $user->updateTokens($amount * -1);
        $this->getUser()->updateTokens($amount);
        return $amount * -1;
    }

    function doSTHDonate($user, $amount){
        $database = dbCon();
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);

        //czy glosujacy ma tokeny
        if($user->getTokens() - $amount <= -1){
            $translate = new \classes\Languages\Translate($_COOKIE['lang']);
            throw new \Exception($translate->getString("notEnoughTokens"));
        }

        //czy donate nie jest juz na 100%
        if($this->getCurrentActivity()->getPrice() == $this->getCurrentActivityProgress()){
            //koniec
            throw new \Exception($translate->getString("currentActivityProgresReach"));
        }

        // jesli kwota tipa jest większa od wymaganej jest zmiana tej kwoty
        if($this->getCurrentActivityProgress() + $amount > $this->getCurrentActivity()->getPrice()){
            $amount = $this->getCurrentActivity()->getPrice() - $this->getCurrentActivityProgress();
        }

        //insert progres activity
        if(!$database->insert("transmission_progress_details_public_dosth", ["tap_id" => $this->getCurrentTAPID(), "user_id" => $user->getId(), "amount" => $amount, "date_created" => date("Y-m-d H:i:s")])){
            throw new \Exception($translate->getString("error-DBUpdate"));                    
        }

        //pobranie aktualnego stanu transmisji
        $this->loadTransmissionActivityProgress();

        //sprawdzenie czy aktywność nie ma 100% progresu
        if($this->getCurrentActivity()->getPrice() == $this->getCurrentActivityProgress()){
            $this->setChangeCurrentActivity(true);
            $this->nextActivityStatusChange();
        }

        //aktualizacja sald
        $user->updateTokens($amount * -1);
        $this->getUser()->updateTokens($amount);

        //zwracam kwote w razie gdyby się ona zmieniła
        return $amount * -1;
    }

    function private_minute_benefit(\classes\User\User $watcher){
        $amount = $this->getActivity()->getPrice();
        $database = dbCon();
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        if(!$database->has("customers", ["AND" => ["id" => $watcher->getId(), "tokens[>=]" => $amount]])){
            throw new \Exception($translate->getString("notEnoughTokens"));
        }
        if(!$database->insert("transmission_tips", ["transmision_id" => $this->getId(), "amount" => $amount, "user_id" => $watcher->getId(), "date_created" => date("Y-m-d H:i:s")])){
            throw new \Exception($translate->getString("error-DBUpdate"));
        }
        $watcher->updateTokens($amount * -1);
        $this->getUser()->updateTokens($amount);
        return $amount;
    }

    private function setId(int $id){
        $this->id = $id;
    }
    private function setUser(\classes\User\User $user){
        $this->user = $user;
    }
    private function setActivityDate(\DateTime $activityDate){
        $this->activityDate = $activityDate;
    }
    private function setStartedDate(\DateTime $startedDate){
        $this->startedDate = $startedDate;
    }
    private function setActivity(\classes\PlannedActivities\PlannedActivities $activity){
        $this->activity = $activity;
    }
    private function setViewers(int $viewers){
        $this->viewers = $viewers;
    }
    private function setTipPayers(array $tipPayers){
        $this->tipPayers = $tipPayers;
    }
    private function setTokensReceived(int $tokensReceived){
        $this->tokensReceived = $tokensReceived;
    }

    private function setTransmissionActivityProgress(array $transmissionActivityProgress){
        $this->transmissionActivityProgress = $transmissionActivityProgress;
    }
    function getSpecTAProgress($type, $id){
        return $this->transmissionActivityProgress[$type][$id];
    }

    private function setCurrentActivity($currentActivity){
        $this->currentActivity = $currentActivity;
    }
    function getCurrentActivity(){
        return $this->currentActivity;
    }

    private function setCurrentTAPID(int $ctapid){
        $this->currentTAPID = $ctapid;
    }
    private function getCurrentTAPID(){
        return $this->currentTAPID;
    }

    private function setCurrentActivityProgress($currentActivityProgress){
        $this->currentActivityProgress = $currentActivityProgress;
    }
    function getCurrentActivityProgress(){
        return $this->currentActivityProgress;
    }
    
    private function setChangeCurrentActivity(bool $change){
        $this->changeCurrentActivity = $change;
    }
    private function nextActivityStatusChange(){
        //zmiana logiki obiektu na inna aktywną aktywnosć - tak wiem popierdolone :) 
        $database = dbCon();
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        if(!$database->update("transmission_activity_progress", ["status" => "completed"], ["id" => $this->getCurrentTAPID()])){
            throw new \Exception($translate->getString("error-DBUpdate"));
        }
        if($database->has("transmission_activity_progress", ["AND" => ["status" => "upcoming", "id" => $this->getCurrentTAPID() + 1]])){
            if(!$database->update("transmission_activity_progress", ["status" => "current"], ["id" => $this->getCurrentTAPID() + 1])){
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
        }
    }
    function getChangeCurrentActivity(){
        return $this->changeCurrentActivity;
    }


    function getId(){
        return $this->id;
    }
    function getUser(){
        return $this->user;
    }
    function getActivityDate(){
        return $this->activityDate;
    }
    function getStartedDate(){
        return $this->startedDate;
    }
    function getActivity(){
        return $this->activity;
    }
    function getViewers(){
        return $this->viewers;
    }
    function getDuration(){
        $today = new \DateTime("now");
        $interval = $today->diff($this->getStartedDate());
        return ($interval->h * 60) + $interval->i;
    }
    function getTipPayers(){
        return $this->tipPayers;
    }
    function getTokensReceived(){
        return $this->tokensReceived;
    }
}