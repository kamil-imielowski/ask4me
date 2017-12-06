<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$PA = new classes\PlannedActivities\PlannedActivitiesFactory($user->getId());

$translate = new \classes\Languages\Translate();
?>
<div class="section start-activity animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("startAnActivity") ?></h4>
    
    <?php if(!empty($PA->getStartSoon())){?>
        <div class="part activities"><!--część wyświetlana jeżeli użytkonik ma zaplanowaną jakąś aktywność w ciągu powiedzmy 30 minut-->
            <p><?php echo $translate->getString("activityScheduledIn") ?> <?php echo $PA->getStartSoon()->getStaringMinutesDiferential(); ?> <?php echo $translate->getString("minutes"); ?></p>
            <div class="upcoming wrapper">
                <?php 
                $plannedActivity = $PA->getStartSoon();
                switch($plannedActivity->getType()){
                    case 1:
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/SO_public.html.php");
                        break;

                    case 2:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/SO_private_chat.html.php");                
                        break;

                    case 3:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/SO_private_cam.html.php");                                          
                        break;

                    case 4:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/SO_inPerson.html.php");      
                        break;
                }
                ?>
            </div>
        </div>
    <?php }else{?>
        <div class="part start-now">
            <a h-ref="#" onClick="tab('plan-and-start', this);" class="add-activity xl-txt"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString("addAndStartAnActivity"); ?></span></a><!--to samo co plan an activity tylko bez wyboru daty, jedynie z możliwością wybrania wszystkich opcji (jak przy plan an activity, bez in person) i rozpoczęcia już-->
        </div>
    <?php }?>

    
    
</div>