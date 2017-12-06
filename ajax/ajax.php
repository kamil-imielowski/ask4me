<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

if(!isset($_POST['action']) && !isset($_GET['action'])){
    http_response_code(400);
    die("400 Bad Request");
}

$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];
$translate = new classes\Languages\Translate($_COOKIE['lang']);

switch($action){

    case 'getPlannedActivitiesForSelectedDate':
        $PA = new classes\PlannedActivities\PlannedActivitiesFactory($_GET['userId'], $_GET['data']);
        foreach($PA->getPlannedActivities() as $plannedActivity){ 
            switch($plannedActivity->getType()){
                case 1:
                    echo plannedActivityPublicNonActive($plannedActivity);
                    break;

                case 2:
                    echo plannedActivityPrivateChatNonActive($plannedActivity);
                    break;

                case 3:
                    echo plannedActivityPrivateCamNonActive($plannedActivity);
                    break;

                case 4:
                    echo plannedActivityEscortNonActive($plannedActivity);
                    break;
            }
        }
        break;

    case 'getPublicPlannedActivitiesForSelectedDate':
        $PA = new classes\PlannedActivities\PlannedActivitiesFactory($_GET['userId'], $_GET['data']);
        $info = array();
        $i = 0;
        foreach($PA->getPlannedActivities() as $plannedActivity){ 
            if($plannedActivity->getType() == 1){
                $info[$i]["date"] = $plannedActivity->getDate()->format("h:i a");
                $info[$i]["id"] = $plannedActivity->getId();
                $i++;
            }
        }
        echo json_encode($info);
        break;

    case 'getPlannedActivitiesforDateAndKeywordFilter':
        $PA = new classes\PlannedActivities\PlannedActivitiesFactory($_GET['userId'], $_GET['date'] , $_GET['keywords']);
        foreach($PA->getPlannedActivities() as $plannedActivity){ 
            switch($plannedActivity->getType()){
                case 1:
                    echo plannedActivityPublicNonActive($plannedActivity);
                    break;

                case 2:
                    echo plannedActivityPrivateChatNonActive($plannedActivity);
                    break;

                case 3:
                    echo plannedActivityPrivateCamNonActive($plannedActivity);
                    break;

                case 4:
                    echo plannedActivityEscortNonActive($plannedActivity);
                    break;
            }
        }
        break;

    case 'getHighlightDates':
        $PA = new classes\PlannedActivities\PlannedActivitiesFactory($_GET['userId']);
        $daty = array();
        if(!empty($PA)){
            foreach($PA->getPlannedActivities() as $plannedActivity){
                $daty[] = $plannedActivity->getDate()->format("Y-m-d");
            }
        }
        echo json_encode($daty);
        break;

    case 'getHighlightPublicDates':
        $PA = new classes\PlannedActivities\PlannedActivitiesFactory($_GET['userId']);
        if(!empty($PA)){
            foreach($PA->getPlannedActivities() as $plannedActivity){
                if($plannedActivity->getType() == 1){
                    $daty[] = $plannedActivity->getDate()->format("Y-m-d");
                }
            }
            echo json_encode($daty);
        }
        break;

    case 'getSugestUser':
        if(!empty($_GET['query'])){
            $UA = new classes\User\UserFactory();
            $users = array();
            $i = 0;
            foreach($UA->getUsers() as $user){
                if(strpos(strtolower($user->getLogin()), strtolower($_GET['query'])) !== false){
                    $users[$i]['login'] = $user->getLogin();
                    $users[$i]['id'] = $user->getId();
                    $i++;
                }
            }
            if(!empty($users)){
                echo json_encode($users);
            }
        }
        break;

    case 'getPrivateActivityInfo':
        $PCA = new classes\ActivityPrices\PrivatePerformance($_GET['user_id'], $_GET['activityId']);
        $info = array();
        $info['price'] = $PCA->getPrice();
        $info['spyCam'] = $PCA->getSpyCam();
        echo json_encode($info);
        break;

    case 'getEscortActivityInfo':
        $PCA = new classes\ActivityPrices\Escort($_GET['user_id'], $_GET['activityId']);
        $info = array();
        $info['price'] = $PCA->getPrice();
        $info['priceType'] = $PCA->getTypePrice();
        echo json_encode($info);
        break;
    case 'changeRequestView':
        try{
            $user = unserialize(base64_decode($_SESSION['user']));
            $request = new classes\Requests\Request($_POST['id']);
            $request->changeView(2, $user->getId());
        }catch(Exception $e){
            $_SESSION['errors'][] = $e->getMessage();
        }
        break;
    case 'changeFollowerView':
        try{
            $user = unserialize(base64_decode($_SESSION['user']));
            $user->changeFollowerView($_POST['id']);
        }catch(Exception $e){
            $_SESSION['errors'][] = $e->getMessage();
        }
        break;   
    case 'getQuantityFollowers':
        try{
            $user = new \classes\User\User($_GET['userId']);
            echo $user->countFollowers();
        }catch(Exception $e){
            $_SESSION['errors'][] = $e->getMessage();
        }
        break;

    case 'addToWishlist'://also deleting
            $user = unserialize(base64_decode($_SESSION['user']));
            $product = new \classes\Product\Product($_POST['idProduct']);

            $user->addToWishlist($product);
        break;

    case 'getPrice':
        $product = new \classes\Product\Product($_POST['productId']);
        echo $product->getPrice();
        break;

    case 'sendProductAsGift':
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        $user = unserialize(base64_decode($_SESSION['user']));
        try{
            $gift = new \classes\Gift\Gift(null, $user->getId());
            $gift->sendProductAsGift($_POST);
            $alert = array(true, $translate->getString("giftWasSent"));
        }catch(Exception $e){
            $alert = array(false, $e->getMessage());
        }

        $user = new \classes\User\User($gift->getUserId());
        $_SESSION['user'] = base64_encode(serialize($user));
        echo json_encode($alert);
        break;

    case 'sendTokensAsGift':
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        $user = unserialize(base64_decode($_SESSION['user']));
        try{
            $gift = new \classes\Gift\Gift(null, $user->getId());
            $gift->sendTokensAsGift($_POST);
            $alert = array(true, $translate->getString("giftWasSent"));
        }catch(Exception $e){
            $alert = array(false, $e->getMessage());
        }

        $user = new \classes\User\User($gift->getUserId());
        $_SESSION['user'] = base64_encode(serialize($user));
        echo json_encode($alert);
        break;

    case 'getModelsProducts':
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        $products = new \classes\Product\ProductsFactory(4);
        foreach($products->getProducts() as $product){
            echo '<option value="'. $product->getId() .'">'. $product->getName() . ' ' . $translate->getString("by") . ' ' . $product->getUserProduct()->getLogin() .'</option>';
        }
        break;

    case 'sendFileAsGift':
        $translate = new \classes\Languages\Translate($_COOKIE['lang']);
        $user = unserialize(base64_decode($_SESSION['user']));
        try{
            $gift = new \classes\Gift\Gift(null, $user->getId());
            $gift->sendFileAsGift($_POST, $_FILES);
            $alert = array(true, $translate->getString("giftWasSent"));
        }catch(Exception $e){
            $alert = array(false, $e->getMessage());
        }

        echo json_encode($alert);
        break;

    case 'dismissNotification':
        $user = unserialize(base64_decode($_SESSION['user']));
        try{
            $notification = new \classes\Notification\Notification($_POST['id']);
            $notification->dismissNotification($user->getId());
        }catch(Exception $e){
            echo $e->getMessage();
        }
        
        break;
    case 'sendATip':
        try{
            $transmission = new \classes\Transmissions\Transmission(new \classes\User\ModelUser(null, $_POST['broadcaster']));
            $user = unserialize(base64_decode($_SESSION['user']));
            $transmission->takeTip($user, $_POST['amount']);
            $_SESSION['user'] = base64_encode(serialize($user));
            echo json_encode(["success" => true]);
        }catch(Exception $e){
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
        break;


    case 'loadPublicTransmissionState':
        try{
            $transmission = new \classes\Transmissions\Transmission(new \classes\User\ModelUser(null, $_GET['broadcaster']));
            $results = array();
            $results = ["mostTokensFrom" => $transmission->getTipPayers(), "tokensReceived" => $transmission->getTokensReceived()];
            echo json_encode($results);
        }catch(Exception $e){
            echo json_encode(["error" => true, "msg" => $e->getMessage()]);
        }
        break;

    case 'voteForTransmissionActivity':
        try{
            $transmission = new \classes\Transmissions\Transmission(new \classes\User\ModelUser(null, $_POST['broadcaster']));
            $user = unserialize(base64_decode($_SESSION['user']));
            $amount = $transmission->vote($user, $_POST['option']);
            $_SESSION['user'] = base64_encode(serialize($user));
            $changeActivity = false;
            if($transmission->getChangeCurrentActivity()){
                $changeActivity = true;
            }
            echo json_encode(["success" => true, "amount" => $amount, "changeActivity" => $changeActivity]);
        }catch(Exception $e){
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
        break;

    case 'doSthDonate':
        try{
            $transmission = new \classes\Transmissions\Transmission(new \classes\User\ModelUser(null, $_POST['broadcaster']));
            $user = unserialize(base64_decode($_SESSION['user']));
            $amount = $transmission->doSTHDonate($user, $_POST['amount']);
            $_SESSION['user'] = base64_encode(serialize($user));
            $changeActivity = false;
            if($transmission->getChangeCurrentActivity()){
                $changeActivity = true;
            }
            echo json_encode(["success" => true, "amount" => $amount, "changeActivity" => $changeActivity]);
        }catch(Exception $e){
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
        break;

    case 'resetCountNotification':
        try{
            $user = unserialize(base64_decode($_SESSION['user']));
            $user->resetCountNotification();
        }catch(Exception $e){
            echo $e->getMessage();
        }
        break;
    
    case 'private_transmission-bailiff':
        try{
            $transmission = new \classes\Transmissions\Transmission(new \classes\User\ModelUser(null, $_POST['broadcaster']));
            $user = unserialize(base64_decode($_SESSION['user']));
            $amount = $transmission->private_minute_benefit($user);
            $_SESSION['user'] = base64_encode(serialize($user));
            echo json_encode(["success" => true, "amount" => $amount]);
        }catch(Exception $e){
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
        break;
    
    default:
        http_response_code(400);
        die("400 Bad Request");
        break;
}

function plannedActivityPublicNonActive($plannedActivity){
    $translate = new classes\Languages\Translate($_COOKIE['lang']);
    return include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/public.html.php");
}

function plannedActivityPrivateChatNonActive($plannedActivity){
    $user = unserialize(base64_decode($_SESSION['user']));
    $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
    //$link = '/'.(($correctUser->getType() == 1) ? "user/".$correctUser->getLogin() : "model/".$correctUser->getLogin());
    $translate = new classes\Languages\Translate($_COOKIE['lang']);
    return  include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/private_chat.html.php"); 
}

function plannedActivityPrivateCamNonActive($plannedActivity){
    $user = unserialize(base64_decode($_SESSION['user']));
    $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
    //$link = '/'.(($correctUser->getType() == 1) ? "user/".$correctUser->getLogin() : "model/".$correctUser->getLogin());
    $translate = new classes\Languages\Translate($_COOKIE['lang']);
    return  include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/private_cam.html.php"); 
}

function plannedActivityEscortNonActive($plannedActivity){
    $user = unserialize(base64_decode($_SESSION['user']));
    $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
    //$link = '/'.(($correctUser->getType() == 1) ? "user/".$correctUser->getLogin() : "model/".$correctUser->getLogin());
    $translate = new classes\Languages\Translate($_COOKIE['lang']);
    return include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/inPerson.html.php");      
}

?>