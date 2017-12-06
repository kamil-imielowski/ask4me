<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

try{
    $user = unserialize(base64_decode($_SESSION['user']));
    $PA = new classes\PlannedActivities\PlannedActivitiesFactory($user->getId());
    $VF = new classes\User\VisitorsFactory($user->getId());
    $requests = new \classes\Requests\RequestsFactory($user->getId());
    $FollowersF = new \classes\User\FollowersFactory($user->getId());
    $notifications = new \classes\Notification\NotificationsFactory($user->getId());
}catch(Esception $e){
    echo $e->getMessage();
}

$translate = new \classes\Languages\Translate($_COOKIE['lang']);
?>

<div class="section homepage">
    <h4 class="dashboard-heading"><?php echo $translate->getString("dashboardHomepage") ?></h4>

    <div class="part visitors">
        <h6 class="dashboard-heading"><?php echo $translate->getString("yourVisitors") ?></h6>
        <div class="profiles2 wrapper">

            <?php if(empty($VF->getUsers())): ?>
                <span><?php echo $translate->getString("uDontHaveAnyVisityet") ?></span>
            <?php endif ?>
            
            <?php foreach($VF->getUsers() as $visitor): ?>
            <div class="profile">
                <div class="box">
                    <div class="icons">
                        <a h-ref="#" class="med-prim-bg white-txt message" login="<?php echo $visitor->getLogin() ?>"><i class='material-icons'>mail_outline</i></a>
                        <a h-ref="#" onclick="follow(<?php echo $visitor->getId() ?>)" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Follow"><i class='follow material-icons <?php if($user->amIfollower($visitor)){echo "unfollow heartbeat";} ?>'></i></a>
                    </div>
                    <a href="/<?php if($visitor->getType() == 1){echo "user/";}else{echo "model/";} echo $visitor->getLogin(); ?>">
                        <div class="photo" style="background:url(<?php echo $visitor->getProfilePicture()->getSRCThumbImage() ?>) no-repeat center center"></div>
                        <div class="med-prim-bg white-txt text">
                            <span><?php echo $visitor->getLogin(); ?>,</span>
                            <span class="lt-txt"><?php echo $visitor->getCountry()->getName() ?></span>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach ?>
            
        </div>
    </div>
    
    <div class="part activities"><!-- Upcoming activities -->
        <h6 class="dashboard-heading"><?php echo $translate->getString("upcomingActivities") ?></h6>
        <div class="upcoming wrapper">
            <?php $plannedActivities = !empty($PA->getStartSoon()) ? $PA->getPlannedActivitiesLimit(3) : $PA->getPlannedActivitiesLimit(4); ?>
            <?php if(empty($plannedActivities)): ?>
                <span><?php echo $translate->getString("uDontHaveAnyupcomingA") ?></span>
            <?php endif ?>
            
            <?php 
            if(!empty($PA->getStartSoon())){  
                $plannedActivity = $PA->getStartSoon();
                switch($plannedActivity->getType()){
                    case 1:
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/user/SO_public.html.php");
                        break;

                    case 2:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/user/SO_private_chat.html.php");                
                        break;

                    case 3:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/user/SO_private_cam.html.php");                                          
                        break;

                    case 4:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/user/SO_inPerson.html.php");      
                        break;
                }
            }
            ?>

            <?php 
            foreach($plannedActivities as $plannedActivity){
                switch($plannedActivity->getType()){
                    case 1:
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/user/public.html.php");
                        break;

                    case 2:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/user/private_chat.html.php");    
                        break;

                    case 3:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/user/private_cam.html.php");                
                        break;

                    case 4:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/user/inPerson.html.php");      
                        break;
                }
            }
            ?>
            
        </div>
    </div>
    
    <div class="part compact"><!-- requests -->
        <h6 class="dashboard-heading"><?php echo $translate->getString("requests") ?></h6>
        <?php if(empty($requests->getHomeRequests())): ?>
            <p><?php echo $translate->getString("uDontHaveAnyReq") ?></p>
        <?php endif ?>
        <?php foreach($requests->getHomeRequests() as $arrReq): $type = $arrReq['t']; $request = $arrReq['r']; ?>
        <div class="item">
            <div class="text">
                <?php switch($type):
                    case 1: ?><!-- sent -->
                        <?php switch($request->getStatus()):
                            case 1:?> <!-- pending -->
                                <?php switch($request->getType()): 
                                    case 1:?><!-- pending private chat only sent -->
                                        <span class="activity-name"><strong><?php echo $translate->getString("Tactivity-privateChat") ?></strong></span>
                                        <?php break;?>
                                    <?php case 2:?><!-- pending private 2W sent -->
                                        <span class="activity-name"><strong><?php echo $translate->getString("Tactivity-privateAll") ?></strong></span>
                                        <?php break;?>
                                    <?php case 3:?><!-- pending escort sent -->
                                        <span class="activity-name"><strong><?php echo $translate->getString("Tactivity-person") ?></strong></span>
                                        <?php break;?>
                                <?php endswitch?>
                                <span><?php echo $translate->getString("requestHasBeenSent")." ".$translate->getString("to"); ?></span>
                                <a href="/<?php echo ($request->getToUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getToUser()->getLogin() ?>"><strong><?php echo $request->getToUser()->getLogin() ?></strong></a>
                                <a h-ref="#"  onClick="tab('requests', $('#dbm-requests')); $('#activity-content').collapse('show');" class="lt-prim-txt"><?php echo $translate->getString("goToRequestsPage") ?></a>
                                <?php break;?>

                            <?php case 2:?><!-- accepted -->
                                <a href="/<?php echo ($request->getToUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getToUser()->getLogin() ?>"><strong><?php echo $request->getToUser()->getLogin() ?></strong></a>
                                <span><?php echo $translate->getString("hasAcceptedReqestFor") ?></span>
                                <?php switch($request->getType()): 
                                    case 1:?><!-- accepted private chat sent -->
                                        <span class="activity-name"><strong><?php echo $translate->getString("Tactivity-privateChat") ?></strong></span>
                                        <?php break;?>
                                    <?php case 2:?><!-- accepted private 2W sent -->
                                        <span class="activity-name"><strong><?php echo $translate->getString("Tactivity-privateAll") ?></strong></span>
                                        <?php break;?>
                                    <?php case 3:?><!-- accepted escort sent -->
                                        <span class="activity-name"><strong><?php echo $translate->getString("Tactivity-person") ?></strong></span>
                                        <?php break;?>
                                <?php endswitch?>
                                <span><?php echo $translate->getString("on") ?></span>
                                <span><strong><?php echo $request->getDate()->format("d.m.Y") ?></strong></span>
                                <a h-ref="#"  onClick="tab('requests', $('#dbm-requests')); $('#activity-content').collapse('show');" class="lt-prim-txt"><?php echo $translate->getString("goToRequestsPage") ?></a>
                                <?php break;?>

                            <?php case 3:?><!-- declined -->
                                <a href="/<?php echo ($request->getToUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getToUser()->getLogin() ?>"><strong><?php echo $request->getToUser()->getLogin() ?></strong></a>
                                <span><?php echo $translate->getString("hasDeclinedReqestFor") ?></span>
                                <?php switch($request->getType()): 
                                    case 1:?><!-- declined private chat sent -->
                                        <span class="activity-name"><strong><?php echo $translate->getString("Tactivity-privateChat") ?></strong></span>
                                        <?php break;?>
                                    <?php case 2:?><!-- declined private cam 2w sent -->
                                        <span class="activity-name"><strong><?php echo $translate->getString("Tactivity-privateAll") ?></strong></span>
                                        <?php break;?>
                                    <?php case 3:?><!-- declined escort sent -->
                                        <span class="activity-name"><strong><?php echo $translate->getString("Tactivity-person") ?></strong></span>
                                        <?php break;?>
                                <?php endswitch?>
                                <span><?php echo $translate->getString("on") ?></span>
                                <span><strong><?php echo $request->getDate()->format("d.m.Y") ?></strong></span>
                                <a h-ref="#"  onClick="tab('requests', $('#dbm-requests')); $('#activity-content').collapse('show');" class="lt-prim-txt"><?php echo $translate->getString("goToRequestsPage") ?></a>
                                <?php break;?>

                            <?php case 4:?><!-- edited -->
                                <a href="/<?php echo ($request->getToUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getToUser()->getLogin() ?>"><strong><?php echo $request->getToUser()->getLogin() ?></strong></a>
                                <span><?php echo $translate->getString("edited") ?></span>
                                <?php switch($request->getType()): 
                                    case 1:?><!-- edited private chat only sent -->
                                        <span class="activity-name"><strong><?php echo $translate->getString("Tactivity-privateChat") ?></strong></span>
                                        <?php break;?>
                                    <?php case 2:?><!-- edited private cam 2w sent -->
                                        <span class="activity-name"><strong><?php echo $translate->getString("Tactivity-privateAll") ?></strong></span>
                                        <?php break;?>
                                    <?php case 3:?><!-- edited escort sent -->
                                        <span class="activity-name"><strong><?php echo $translate->getString("Tactivity-person") ?></strong></span>
                                        <?php break;?>
                                <?php endswitch?>
                                <span><?php echo $translate->getString("on") ?></span>
                                <span><strong><?php echo $request->getDate()->format("d.m.Y") ?></strong></span>
                                <a h-ref="#"  onClick="tab('requests', $('#dbm-requests')); $('#activity-content').collapse('show');" class="lt-prim-txt"><?php echo $translate->getString("goToRequestsPage") ?></a>
                                <?php break;?>
                        <?php endswitch?>
                        <?php break;?>

                    <?php case 2: ?><!-- received -->
                        <?php switch($request->getStatus()):
                            case 1:?><!-- pending -->
                                <span><?php echo $translate->getString("uveNreqfor"); ?></span>
                                <?php switch($request->getType()): 
                                    case 1:?><!-- received pending private chat only -->
                                        <span class="activity-name"><strong><?php echo strtolower($translate->getString("Tactivity-privateChat")) ?></strong></span>
                                        <?php break;?>
                                    <?php case 2:?><!-- received pending private cam 2w -->
                                        <span class="activity-name"><strong><?php echo strtolower($translate->getString("Tactivity-privateAll")) ?></strong></span>
                                        <?php break;?>
                                    <?php case 3:?><!-- received pending escort -->
                                        <span class="activity-name"><strong><?php echo strtolower($translate->getString("Tactivity-person")) ?></strong></span>
                                        <?php break;?>
                                <?php endswitch?>
                                <span><?php echo strtolower($translate->getString("from")) ?></span>
                                <a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><strong><?php echo $request->getFromUser()->getLogin() ?></strong></a>
                                <a h-ref="#"  onClick="tab('requests', $('#dbm-requests')); $('#activity-content').collapse('show');" class="lt-prim-txt"><?php echo $translate->getString("goToRequestsPage") ?></a>
                                <?php break;?>

                            <?php case 2:?><!-- accepted -->
                                <span><?php echo $translate->getString("youveAcceptedRequest"); ?></span>
                                <?php switch($request->getType()): 
                                    case 1:?><!-- accepted received private chat only -->
                                        <span class="activity-name"><strong><?php echo strtolower($translate->getString("Tactivity-privateChat")) ?></strong></span>
                                        <?php break;?>
                                    <?php case 2:?><!-- accepted received private cam 2w -->
                                        <span class="activity-name"><strong><?php echo strtolower($translate->getString("Tactivity-privateAll")) ?></strong></span>
                                        <?php break;?>
                                    <?php case 3:?><!-- accepted received escort -->
                                        <span class="activity-name"><strong><?php echo strtolower($translate->getString("Tactivity-person")) ?></strong></span>
                                        <?php break;?>
                                <?php endswitch?>
                                <span><?php echo strtolower($translate->getString("from")) ?></span>
                                <a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><strong><?php echo $request->getFromUser()->getLogin() ?></strong></a>
                                <a h-ref="#"  onClick="tab('requests', $('#dbm-requests')); $('#activity-content').collapse('show');" class="lt-prim-txt"><?php echo $translate->getString("goToRequestsPage") ?></a>
                                <?php break;?>

                            <?php case 3:?><!-- declined -->
                                <span><?php echo $translate->getString("youveDeclineddRequest"); ?></span>
                                <?php switch($request->getType()): 
                                    case 1:?><!-- declined received chat only -->
                                        <span class="activity-name"><strong><?php echo strtolower($translate->getString("Tactivity-privateChat")) ?></strong></span>
                                        <?php break;?>
                                    <?php case 2:?><!-- declined received private cam 2w -->
                                        <span class="activity-name"><strong><?php echo strtolower($translate->getString("Tactivity-privateAll")) ?></strong></span>
                                        <?php break;?>
                                    <?php case 3:?>
                                        <!-- declined received escor -->
                                        <span class="activity-name"><strong><?php echo strtolower($translate->getString("Tactivity-person")) ?></strong></span>
                                        <?php break;?>
                                <?php endswitch?>
                                <span><?php echo strtolower($translate->getString("from")) ?></span>
                                <a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><strong><?php echo $request->getFromUser()->getLogin() ?></strong></a>
                                <a h-ref="#"  onClick="tab('requests', $('#dbm-requests')); $('#activity-content').collapse('show');" class="lt-prim-txt"><?php echo $translate->getString("goToRequestsPage") ?></a>
                                <?php break;?>

                            <?php case 4:?><!-- edited -->
                                <span><?php echo $translate->getString("youveEditedRequest"); ?></span>
                                <?php switch($request->getType()): 
                                    case 1:?><!-- edited received private chat only -->
                                        <span class="activity-name"><strong><?php echo strtolower($translate->getString("Tactivity-privateChat")) ?></strong></span>                                    
                                        <?php break;?>
                                    <?php case 2:?><!-- edited received private cam 2w -->
                                        <span class="activity-name"><strong><?php echo strtolower($translate->getString("Tactivity-privateAll")) ?></strong></span>                                    
                                        <?php break;?>
                                    <?php case 3:?><!-- edited received escort -->
                                        <span class="activity-name"><strong><?php echo strtolower($translate->getString("Tactivity-person")) ?></strong></span>                                        
                                        <?php break;?>
                                <?php endswitch?>
                                <span><?php echo strtolower($translate->getString("from")) ?></span>
                                <a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><strong><?php echo $request->getFromUser()->getLogin() ?></strong></a>
                                <a h-ref="#"  onClick="tab('requests', $('#dbm-requests')); $('#activity-content').collapse('show');" class="lt-prim-txt"><?php echo $translate->getString("goToRequestsPage") ?></a>
                                <?php break;?>

                        <?php endswitch?>
                        <?php break;?>
                <?php endswitch ?>
            </div>
            <a h-ref="#" class="delete" onclick="changeRequestView(<?php echo $request->getId()?>, this)">
                <i class="fa fa-close"></i>
            </a>
        </div>
        <?php endforeach ?>
    </div>
    
    <div class="part compact">
        <h6 class="dashboard-heading">Notifications</h6>
        <?php if(empty($notifications->getNotificationsPhoto()) && empty($notifications->getNotificationsBlog()) && empty($notifications->getNotificationsActivity()) && empty($notifications->getNotificationsGift()) && empty($notifications->getNotificationsNewProduct())): ?>
            <p><?php echo $translate->getString("uDontHaveAnyNot") ?></p>
        <?php endif ?>
        <?php foreach($notifications->getNotificationsGift() as $notification): $userType = $notification->getUser()->getType() == 1 ? 'user' : 'model'; ?>
        <div class="item">
            <div class="text">
                <span>You've received a new gift from</span>
                <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin() ?></strong></a>
                <a onClick="tab('gifts', this);" class="lt-prim-txt">Go to the gifts page</a>
            </div>
            <a onclick="dismissNotification(<?php echo $notification->getId() ?>, this)" class="delete">
                <i class="fa fa-close"></i>
            </a>
        </div>
        <?php endforeach; ?>

        <?php foreach($notifications->getNotificationsNewProduct() as $notification): $userType = $notification->getUser()->getType() == 1 ? 'user' : 'model'; ?>
            <div class="item">
                <div class="text">
                    <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin(); ?></strong></a>
                    <span>has added a new</span>
                    <span><strong><?php echo $notification->getProduct()->getName(); ?></strong></span>
                    <span>to her shop</span>
                    <a href="/product/<?php echo $notification->getProduct()->getId() . '/' . $notification->getProduct()->getURLName() ?>" class="lt-prim-txt">Go to the product page</a>
                </div>
                <a onclick="dismissNotification(<?php echo $notification->getId() ?>, this)" class="delete">
                    <i class="fa fa-close"></i>
                </a>
            </div>
        <?php endforeach; ?>
        
        <?php foreach($notifications->getNotificationsActivity() as $notification): $userType = $notification->getUser()->getType() == 1 ? 'user' : 'model'; ?>
            <div class="item">
                <div class="text">
                    <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin(); ?></strong></a>
                    <span>has planned a new</span>
                    <span><strong>activity</strong></span>
                    <a href="#" class="lt-prim-txt">Subscribe</a>
                </div>
                <a onclick="dismissNotification(<?php echo $notification->getId() ?>, this)" class="delete">
                    <i class="fa fa-close"></i>
                </a>
            </div>
        <?php endforeach; ?>
        
        <?php foreach($notifications->getNotificationsBlog() as $notification): $userType = $notification->getUser()->getType() == 1 ? 'user' : 'model'; ?>
            <div class="item">
                <div class="text">
                    <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin(); ?></strong></a>
                    <span>has added a new</span>
                    <span><strong>blog entry</strong></span>
                    <a href="/blog/<?php echo $notification->getBlog()->getId() . '/' . $notification->getBlog()->getURLTitle() ?>" class="lt-prim-txt">Read the blog entry</a>
                </div>
                <a onclick="dismissNotification(<?php echo $notification->getId() ?>, this)" class="delete">
                    <i class="fa fa-close"></i>
                </a>
            </div>
        <?php endforeach; ?>
        
        <?php foreach($notifications->getNotificationsPhoto() as $notification): $userType = $notification->getUser()->getType() == 1 ? 'user' : 'model'; ?>
            <div class="item">
                <div class="text">
                    <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin(); ?></strong></a>
                    <span>has added a new</span>
                    <span><strong>photo</strong></span>
                    <a href="model.php?action=galleryPage&login=<?php echo $notification->getUser()->getLogin() ?>" class="lt-prim-txt">Go to the user's gallery</a>
                </div>
                <a onclick="dismissNotification(<?php echo $notification->getId() ?>, this)" class="delete">
                    <i class="fa fa-close"></i>
                </a>
            </div>
        <?php endforeach; ?>
        
    </div>
    
    <!-- <div class="part compact">
        <h6 class="dashboard-heading">Messages</h6>
        <?php foreach($notifications->getNotificationsMessage() as $notification): $userType = $notification->getUser()->getType() == 1 ? 'user' : 'model'; ?>
        <div class="item">
            <div class="text">
                <span>You've got a new message from</span>
                <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin() ?></strong></a>
                <a href="messages.php" class="lt-prim-txt">Go to the messages page</a>
            </div>
            <a href="#" class="delete">
                <i class="fa fa-close"></i>
            </a>
        </div>
        <?php endforeach; ?>
    </div> -->
    
    <div class="part compact">
        <h6 class="dashboard-heading"><?php echo $translate->getString("followers")?></h6>
        <?php if(empty($notifications->getNotificationsFollowers())): ?>
            <p><?php echo $translate->getString("uDontHaveAnyFollowers") ?></p>
        <?php endif ?>
        <?php foreach($notifications->getNotificationsFollowers() as $notification): $userType = $notification->getUser()->getType() == 1 ? 'user' : 'model'; ?>
        <div class="item">
            <div class="text">
                <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin() ?></strong></a>
                <span><?php echo $translate->getString("startedfollowingY") ?></span>
            </div>
            <a h-ref="#" onclick="dismissNotification(<?php echo $notification->getId() ?>, this)" class="delete">
                <i class="fa fa-close"></i>
            </a>
        </div>
        <?php endforeach;?>
    </div>
    
</div>
		
<script src="/js/follow.js"></script>
<script>
    //slick slider - dashboard
    $(document).ready(function(){
        $('.profiles2').slick({
        dots: true,
        infinite: true,
        speed: 1000,
        slidesToShow: 5,
        slidesToScroll: 5,
        responsive: [
            {
            breakpoint: 1200,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
                speed: 800,
            }
            },
            {
            breakpoint: 991,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                speed: 600,
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                speed: 400,
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                speed: 200,
            }
            },
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
        });
    });
        
    //follow unfollow
    $('.follow').on('click', function() {
        $(this).toggleClass("unfollow heartbeat");
    });

function changeRequestView(id, btn){
        var action = "changeRequestView"
        $.ajax({
            url: "/ajax/ajax.php",
            type: "post",
            data: {id, action},
            success: function(data){
                $(btn).parent().remove();
            }
        })
    }

    function changeFollowersView(id, btn){
        var action = "changeFollowerView"
        $.ajax({
            url: "/ajax/ajax.php",
            type: "post",
            data: {id, action},
            success: function(data){
                $(btn).parent().remove();
            }
        })
    }

    function dismissNotification(id, item){
        var action = "dismissNotification"
        $.ajax({
            url: "/ajax/ajax.php",
            type: "post",
            data: {id, action},
            success: function(data){
                $(item).parent().remove();
            }
        })
    }
</script>

