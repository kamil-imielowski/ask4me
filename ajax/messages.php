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

    case 'deleteMessage':
        $message = new \classes\Message\Message($_POST['id']);
        $message->deleteMessage();
        break;

    case 'addConversationToSession':
        if(isset($_SESSION['conversation'])){
            $conversation = unserialize(base64_decode($_SESSION['conversation']));
            array_push($conversation, $_POST['to']);
            $_SESSION['conversation'] = base64_encode(serialize($conversation));
        }else{
            $conversation[] = $_POST['to'];
            $_SESSION['conversation'] = base64_encode(serialize($conversation));
        }
        break;

    case 'deleteConversationFromSession':
        $conversation = unserialize(base64_decode($_SESSION['conversation']));
        if (($key = array_search($_POST['to'], $conversation)) !== false) {
            unset($conversation[$key]);
        }
        $_SESSION['conversation'] = base64_encode(serialize($conversation));
        break;

    case 'getSessionData':
        $result = array();
        if(isset($_SESSION['user'])){
            $user = unserialize(base64_decode($_SESSION['user']));
            if(isset($_SESSION['conversation'])){
                $conversation = unserialize(base64_decode($_SESSION['conversation']));
            }else{
                $conversation = "";
            }
            $result = array("userLogin"=>$user->getLogin(), 'conversation'=>$conversation);
        }
        echo json_encode($result);
        break;

    case 'getConversation':
        $user = unserialize(base64_decode($_SESSION['user']));
        $sender = $user->getId();

        $user = new \classes\User\User(null, $_POST['recipient']);
        $recipient = $user->getId();

        $conversation = new \classes\Message\Conversation($sender, $recipient);
        $conversation->markAsRead();
        $conversation = $conversation->getConversation();

        $messagesContent = "";
        foreach($conversation as $message){
            if($message->getUserFrom()->getId() == $sender){
                $messagesContent .= '<p class="message owner"><span><strong>'.$message->getUserFrom()->getLogin().': </strong></span><span>'.$message->getMessage().'</span></p>';
            }else{
                $messagesContent .= '<p class="message"><span><strong>'.$message->getUserFrom()->getLogin().': </strong></span><span>'.$message->getMessage().'</span></p>';
            }
        }
        echo $messagesContent;
        break;

    case 'getConversationToMessenger':
        $user = unserialize(base64_decode($_SESSION['user']));
        $sender = $user->getId();

        $user = new \classes\User\User(null, $_POST['recipient']);
        $recipient = $user->getId();

        $conversation = new \classes\Message\Conversation($sender, $recipient);
        $conversation->markAsRead();
        $conversation = $conversation->getConversation();

        $messagesContent = "";
        foreach($conversation as $message){
            if($message->getUserFrom()->getId() == $sender){
                $readed = $message->getReaded() == 1 ? 'read' : '';
                $messagesContent .= '
                                    <div class="right">
                                            <p class="message-content">'.$message->getMessage().'</p>             
                                            <p class="message-info">
                                                <span class="o-sans">'.$message->getDateCreated()->format("d.m.Y H:i").'</span>
                                                <span><i class="material-icons '.$readed.'">done_all</i></span>
                                                <span><a h-ref="#"><i msg="'.$message->getId().'" class="fa fa-trash"></i></a></span>
                                            </p>
                                        </div>';

            }else{

                $messagesContent .= '<div class="left">
                                        <p class="message-content">'.$message->getMessage().'</p>
                                        <p class="message-info">
                                            <span class="date">'.$message->getDateCreated()->format("d.m.Y H:i").'</span>
                                            <span><a h-ref="#"><i msg="'.$message->getId().'" class="fa fa-trash"></i></a></span>
                                        </p>
                                    </div>';
            }
        }
        echo $messagesContent;
        break;

    case 'saveMessageToDB':
        $user = unserialize(base64_decode($_SESSION['user']));
        $from = $user->getId();

        $user = new \classes\User\User(null, $_POST['to']);
        $to = $user->getId();

        $msg = $_POST['msg'];

        $message = new \classes\Message\Message();
        $message->saveMessage($from, $to, $msg);
        break;
    
    default:
        http_response_code(400);
        die("400 Bad Request");
        break;
}

?>