<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$requests = new \classes\Requests\RequestsFactory($user->getId());

$translate = new \classes\Languages\Translate($_COOKIE['lang']);  
?>
<div class="section requests animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("requests") ?></h4>
            
    <div class="part">
        <h6><?php echo $translate->getString("receivedRequests") ?></h6>
        
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#received-new" aria-controls="received-new" role="tab" data-toggle="tab"><?php echo $translate->getString('newRequests') ?>s</a></li>
            <li role="presentation" class=""><a href="#received-pending" aria-controls="received-pending" role="tab" data-toggle="tab"><?php echo $translate->getString("pending") ?></a></li>
            <li role="presentation" class=""><a href="#received-accepted" aria-controls="received-accepted" role="tab" data-toggle="tab"><?php echo $translate->getString("accepted") ?></a></li>
            <li role="presentation" class=""><a href="#received-declined" aria-controls="received-declined" role="tab" data-toggle="tab"><?php echo $translate->getString('declined') ?></a></li>
            <li role="presentation" class=""><a href="#received-edited" aria-controls="received-edited" role="tab" data-toggle="tab"><?php echo $translate->getString("editedRequests") ?></a></li>
        </ul>

        <div class="tab-content">
            
            <div role="tabpanel" class="tab-pane active fade in" id="received-new">
                <?php $receivedNew = $requests->getReceivedNew() ?>
                <?php if(!empty($receivedNew)): ?>
                    <div class="wrapper">
                        <?php foreach($receivedNew as $request):?>
                            <?php switch($request->getType()): 
                                case 1:
                                case 2: ?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><?php echo $request->getFromUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $request->getType()==1 ? $translate->getString("Tactivity-privateChat") : $translate->getString("Tactivity-privateAll") ; ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("minLength") ?>: </span></strong><span><?php echo $request->getMinDuration() ?> <?php echo $translate->getString("minutes")?></span></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("pricePerMinute") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku webcam performance-->
                                        <p><?php echo $request->getSpyCam() ? $translate->getString("spyCamEnabled") : $translate->getString("spyCamDisabled") ?></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <a href="/dashboard-model.php?action=changeRequestStatus&status=2&id=<?php echo $request->getId() ?>"><i class='fa fa-check'></i><span><?php echo $translate->getString("accept") ?></span></a>
                                            <a href="/dashboard-model.php?action=changeRequestStatus&status=3&id=<?php echo $request->getId() ?>"><i class='fa fa-close'></i><span><?php echo $translate->getString("decline") ?></span></a>
                                            <a h-ref="#" onClick="editRequest(<?php echo $request->getId() ?>)"><i class='fa fa-pencil'></i><span><?php echo $translate->getString("edit") ?></span></a>
                                        </div>
                                    </div>
                                    <?php break; ?>    

                                <?php case 3:?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><?php echo $request->getFromUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $translate->getString("Tactivity-person") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <?php if(!is_null($request->getDuration())):?>
                                            <p><strong><span><?php echo $translate->getString("length") ?>: </span></strong><span><?php echo $request->getDuration() ?> <?php echo $translate->getString("hour")?></span></p><!--w przypadku in person service z płatnością za godzinę-->
                                        <?php endif ?>
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("price") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku in person-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <a href="/dashboard-model.php?action=changeRequestStatus&status=2&id=<?php echo $request->getId() ?>"><i class='fa fa-check'></i><span><?php echo $translate->getString("accept") ?></span></a>
                                            <a href="/dashboard-model.php?action=changeRequestStatus&status=3&id=<?php echo $request->getId() ?>"><i class='fa fa-close'></i><span><?php echo $translate->getString("decline") ?></span></a>
                                            <a h-ref="#" onClick="editRequest(<?php echo $request->getId() ?>);"><i class='fa fa-pencil'></i><span><?php echo $translate->getString("edit") ?></span></a>
                                        </div>
                                    </div>
                                    <?php break; ?>                        
                            <?php endswitch ?>
                        <?php endforeach?>
                    </div>
                <?php else: ?>
                    <div class="no-content">
                        <p><?php echo $translate->getString("noNewRequests") ?></p>
                    </div>
                <?php endif ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="received-pending">
                <?php $receivedPending = $requests->getReceivedPending() ?>
                <?php if(!empty($receivedPending)): ?>
                    <div class="wrapper">
                        <?php foreach($receivedPending as $request):?>
                            <?php switch($request->getType()): 
                                case 1:
                                case 2: ?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><?php echo $request->getFromUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $request->getType()==1 ? $translate->getString("Tactivity-privateChat") : $translate->getString("Tactivity-privateAll") ; ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("minLength") ?>: </span></strong><span><?php echo $request->getMinDuration() ?> <?php echo $translate->getString("minutes")?></span></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("pricePerMinute") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku webcam performance-->
                                        <p><?php echo $request->getSpyCam() ? $translate->getString("spyCamEnabled") : $translate->getString("spyCamDisabled") ?></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <a href="/dashboard-model.php?action=changeRequestStatus&status=2&id=<?php echo $request->getId() ?>"><i class='fa fa-check'></i><span><?php echo $translate->getString("accept") ?></span></a>
                                            <a href="/dashboard-model.php?action=changeRequestStatus&status=3&id=<?php echo $request->getId() ?>"><i class='fa fa-close'></i><span><?php echo $translate->getString("decline") ?></span></a>
                                            <a h-ref="#" onClick="editRequest(<?php echo $request->getId() ?>);"><i class='fa fa-pencil'></i><span><?php echo $translate->getString("edit") ?></span></a>
                                        </div>
                                    </div>
                                    <?php break; ?>    

                                <?php case 3:?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><?php echo $request->getFromUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $translate->getString("Tactivity-person") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <?php if(!is_null($request->getDuration())):?>
                                            <p><strong><span><?php echo $translate->getString("length") ?>: </span></strong><span><?php echo $request->getDuration() ?> <?php echo $translate->getString("hour")?></span></p><!--w przypadku in person service z płatnością za godzinę-->
                                        <?php endif ?>
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("price") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku in person-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <a href="/dashboard-model.php?action=changeRequestStatus&status=2&id=<?php echo $request->getId() ?>"><i class='fa fa-check'></i><span><?php echo $translate->getString("accept") ?></span></a>
                                            <a href="/dashboard-model.php?action=changeRequestStatus&status=3&id=<?php echo $request->getId() ?>"><i class='fa fa-close'></i><span><?php echo $translate->getString("decline") ?></span></a>
                                            <a h-ref="#" onClick="editRequest(<?php echo $request->getId() ?>);"><i class='fa fa-pencil'></i><span><?php echo $translate->getString("edit") ?></span></a>
                                        </div>
                                    </div>
                                    <?php break; ?>                        
                            <?php endswitch ?>
                        <?php endforeach?>
                    </div>
                <?php else: ?>
                    <div class="no-content">
                        <p><?php echo $translate->getString("noPendingRequests") ?></p>
                    </div>
                <?php endif ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="received-accepted">
                <?php $receivedAccepted = $requests->getReceivedAccepted() ?>
                <?php if(!empty($receivedAccepted)): ?>
                    <div class="wrapper">
                        <?php foreach($receivedAccepted as $request):?>
                            <?php switch($request->getType()): 
                                case 1:
                                case 2: ?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><?php echo $request->getFromUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $request->getType()==1 ? $translate->getString("Tactivity-privateChat") : $translate->getString("Tactivity-privateAll") ; ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("minLength") ?>: </span></strong><span><?php echo $request->getMinDuration() ?> <?php echo $translate->getString("minutes")?></span></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("pricePerMinute") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku webcam performance-->
                                        <p><?php echo $request->getSpyCam() ? $translate->getString("spyCamEnabled") : $translate->getString("spyCamDisabled") ?></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <span class="lt-prim-txt"><strong><i class='fa fa-check'></i><span><?php echo $translate->getString("accepted") ?></span></strong></span>
                                            <!-- <a href="/dashboard-model.php?action=changeRequestStatus&status=3&id=<?php echo $request->getId() ?>"><i class='fa fa-close'></i><span><?php echo $translate->getString("decline") ?></span></a> -->
                                        </div>
                                    </div>
                                    <?php break; ?>    

                                <?php case 3:?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><?php echo $request->getFromUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $translate->getString("Tactivity-person") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <?php if(!is_null($request->getDuration())):?>
                                            <p><strong><span><?php echo $translate->getString("length") ?>: </span></strong><span><?php echo $request->getDuration() ?> <?php echo $translate->getString("hour")?></span></p><!--w przypadku in person service z płatnością za godzinę-->
                                        <?php endif ?>
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("price") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku in person-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <span class="lt-prim-txt"><strong><i class='fa fa-check'></i><span><?php echo $translate->getString("accepted") ?></span></strong></span>
                                            <!-- <a href="/dashboard-model.php?action=changeRequestStatus&status=3&id=<?php echo $request->getId() ?>"><i class='fa fa-close'></i><span><?php echo $translate->getString("decline") ?></span></a> -->
                                        </div>
                                    </div>
                                    <?php break; ?>                        
                            <?php endswitch ?>
                        <?php endforeach?>
                    </div>
                <?php else: ?>
                    <div class="no-content">
                        <p><?php echo $translate->getString("noAcceptedRequests") ?></p>
                    </div>
                <?php endif ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="received-declined">
                <?php $receivedDeclined = $requests->getReceivedDeclined()?>
                <?php if(!empty($receivedDeclined)): ?>
                    <div class="wrapper">
                        <?php foreach($receivedDeclined as $request):?>
                            <?php switch($request->getType()): 
                                case 1:
                                case 2: ?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><?php echo $request->getFromUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $request->getType()==1 ? $translate->getString("Tactivity-privateChat") : $translate->getString("Tactivity-privateAll") ; ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("minLength") ?>: </span></strong><span><?php echo $request->getMinDuration() ?> <?php echo $translate->getString("minutes")?></span></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("pricePerMinute") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku webcam performance-->
                                        <p><?php echo $request->getSpyCam() ? $translate->getString("spyCamEnabled") : $translate->getString("spyCamDisabled") ?></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <span class="lt-prim-txt"><strong><i class='fa fa-close'></i><span><?php echo $translate->getString("declined") ?></span></strong></span>
                                        </div>
                                    </div>
                                    <?php break; ?>    

                                <?php case 3:?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><?php echo $request->getFromUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $translate->getString("Tactivity-person") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <?php if(!is_null($request->getDuration())):?>
                                            <p><strong><span><?php echo $translate->getString("length") ?>: </span></strong><span><?php echo $request->getDuration() ?> <?php echo $translate->getString("hour")?></span></p><!--w przypadku in person service z płatnością za godzinę-->
                                        <?php endif ?>
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("price") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku in person-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <span class="lt-prim-txt"><strong><i class='fa fa-close'></i><span><?php echo $translate->getString("declined") ?></span></strong></span>
                                        </div>
                                    </div>
                                    <?php break; ?>                        
                            <?php endswitch ?>
                        <?php endforeach?>
                    </div>
                <?php else: ?>
                    <div class="no-content">
                        <p><?php echo $translate->getString("noDeclinedRequests") ?></p>
                    </div>
                <?php endif ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="received-edited">
                <?php $receivedEdited = $requests->getReceivedEdited() ?>
                <?php if(!empty($receivedEdited)): ?>
                    <div class="wrapper">
                        <?php foreach($receivedEdited as $request):?>
                            <?php switch($request->getType()): 
                                case 1:
                                case 2: ?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><?php echo $request->getFromUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $request->getType()==1 ? $translate->getString("Tactivity-privateChat") : $translate->getString("Tactivity-privateAll") ; ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("minLength") ?>: </span></strong><span><?php echo $request->getMinDuration() ?> <?php echo $translate->getString("minutes")?></span></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("pricePerMinute") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku webcam performance-->
                                        <p><?php echo $request->getSpyCam() ? $translate->getString("spyCamEnabled") : $translate->getString("spyCamDisabled") ?></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <span class="lt-prim-txt"><strong><i class='fa fa-hourglass-o'></i><span><?php echo $translate->getString("wait4uDecision") ?></span></strong></span>
                                        </div>
                                    </div>
                                    <?php break; ?>    

                                <?php case 3:?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="/<?php echo ($request->getFromUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getFromUser()->getLogin() ?>"><?php echo $request->getFromUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $translate->getString("Tactivity-person") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <?php if(!is_null($request->getDuration())):?>
                                            <p><strong><span><?php echo $translate->getString("length") ?>: </span></strong><span><?php echo $request->getDuration() ?> <?php echo $translate->getString("hour")?></span></p><!--w przypadku in person service z płatnością za godzinę-->
                                        <?php endif ?>
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("price") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku in person-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <span class="lt-prim-txt"><strong><i class='fa fa-hourglass-o'></i><span><?php echo $translate->getString("wait4uDecision") ?></span></strong></span>
                                        </div>
                                    </div>
                                    <?php break; ?>                        
                            <?php endswitch ?>
                        <?php endforeach?>
                    </div>
                <?php else: ?>
                    <div class="no-content">
                        <p><?php echo $translate->getString("noEditedRequests") ?></p>
                    </div>
                <?php endif ?>
            </div>
            
        </div>

        <!-- <div class="tab-content">
            
            <div role="tabpanel" class="tab-pane active fade in" id="received-new">
                <div class="wrapper">
                    
                    <div class="item">
                        <p><strong><span>From: </span></strong><a href="user.php">username</a></p>
                        <p><strong><span>Type: </span></strong><span>public webcam performance</span></p>
                        <p><strong><span>Time: </span></strong><span>29.08.2017 18:00</span></p>
                        <p><strong><span>Additional comments: </span></strong><span>-</span></p>
                        
                        <div class="icons">
                            <a href="#"><i class='fa fa-check'></i><span>accept</span></a>
                            <a href="#"><i class='fa fa-close'></i><span>decline</span></a>
                        </div>
                    </div>
                    
                    <div class="item">
                        <p><strong><span>From: </span></strong><a href="user.php">username</a></p>
                        <p><strong><span>Type: </span></strong><span>in person</span></p>
                        <p><strong><span>Time: </span></strong><span>22.08.2017 20:00</span></p>
                        <p><strong><span>Length: </span></strong><span>1 hour</span></p>
                        <p><strong><span>Activity: </span></strong><span>wybrane z listy użytkownika</span></p>
                        <p><strong><span>Price: </span></strong><i class="fa fa-diamond"></i><span>999</span></p>
                        <p><strong><span>Additional comments: </span></strong><span>Nulla aliquet congue id, orci. Nullam in faucibus lectus varius vitae, faucibus augue. Sed sollicitudin arcu. In hac habitasse platea dictumst. Maecenas arcu luctus et massa. Ut wisi vel nibh. Cras magna diam, suscipit urna.</span></p>
                        
                        <div class="icons">
                            <a href="#"><i class='fa fa-check'></i><span>accept</span></a>
                            <a href="#"><i class='fa fa-close'></i><span>decline</span></a>
                            <a href="#" onClick="tab('edit', this);"><i class='fa fa-pencil'></i><span>edit</span></a>
                        </div>
                    </div>
                    
                    <div class="item">
                        <p><strong><span>From: </span></strong><a href="user.php">username</a></p>
                        <p><strong><span>Type: </span></strong><span>private webcam performance with chat only</span></p>
                        <p><strong><span>Time: </span></strong><span>25.08.2017 22:00</span></p>
                        <p><strong><span>Min. length: </span></strong><span>10 minutes</span></p>
                        <p><strong><span>Activity: </span></strong><span>wybrane z listy użytkownika</span></p>
                        <p><strong><span>Price per minute: </span></strong><i class="fa fa-diamond"></i><span>99</span></p>
                        <p>Spy cam disabled</p>
                        <p><strong><span>Additional comments: </span></strong><span>In hac habitasse platea dictumst. Maecenas arcu luctus et massa. Ut wisi vel nibh. Cras magna diam, suscipit urna.</span></p>
                        
                        <div class="icons">
                            <a href="#"><i class='fa fa-check'></i><span>accept</span></a>
                            <a href="#"><i class='fa fa-close'></i><span>decline</span></a>
                            <a href="#" onClick="tab('edit', this);"><i class='fa fa-pencil'></i><span>edit</span></a>
                        </div>
                    </div>
                    
                    <div class="item">
                        <p><strong><span>From: </span></strong><a href="user.php">username</a></p>
                        <p><strong><span>Type: </span></strong><span>private webcam performance with 2-way audio/video</span></p>
                        <p><strong><span>Time: </span></strong><span>29.08.2017 18:00</span></p>
                        <p><strong><span>Min. length: </span></strong><span>20 minutes</span></p>
                        <p><strong><span>Activity: </span></strong><span>wybrane z listy użytkownika</span></p>
                        <p><strong><span>Price per minute: </span></strong><i class="fa fa-diamond"></i><span>149</span></p>
                        <p>Spy cam enabled</p>
                        <p><strong><span>Additional comments: </span></strong><span>-</span></p>
                        
                        <div class="icons">
                            <a href="#"><i class='fa fa-check'></i><span>accept</span></a>
                            <a href="#"><i class='fa fa-close'></i><span>decline</span></a>
                            <a href="#" onClick="tab('edit', this);"><i class='fa fa-pencil'></i><span>edit</span></a>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="received-pending">
                <div class="wrapper">
                    <div class="item">
                        <p><strong><span>From: </span></strong><a href="user.php">username</a></p>
                        <p><strong><span>Type: </span></strong><span>in person</span></p>
                        <p><strong><span>Time: </span></strong><span>22.08.2017 20:00</span></p>
                        <p><strong><span>Length: </span></strong><span>1 hour</span></p>
                        <p><strong><span>Activity: </span></strong><span>wybrane z listy użytkownika</span></p>
                        <p><strong><span>Price: </span></strong><i class="fa fa-diamond"></i><span>999</span></p>
                        <p><strong><span>Additional comments: </span></strong><span>Nulla aliquet congue id, orci. Nullam in faucibus lectus varius vitae, faucibus augue. Sed sollicitudin arcu. In hac habitasse platea dictumst. Maecenas arcu luctus et massa. Ut wisi vel nibh. Cras magna diam, suscipit urna.</span></p>
                        
                        <div class="icons">
                            <a href="#"><i class='fa fa-check'></i><span>accept</span></a>
                            <a href="#"><i class='fa fa-close'></i><span>decline</span></a>
                            <a href="#" onClick="tab('edit', this);"><i class='fa fa-pencil'></i><span>edit</span></a>
                        </div>
                    </div>
                    
                    <div class="item">
                        <p><strong><span>From: </span></strong><a href="user.php">username</a></p>
                        <p><strong><span>Type: </span></strong><span>private webcam performance with chat only</span></p>
                        <p><strong><span>Time: </span></strong><span>25.08.2017 22:00</span></p>
                        <p><strong><span>Min. length: </span></strong><span>10 minutes</span></p>
                        <p><strong><span>Activity: </span></strong><span>wybrane z listy użytkownika</span></p>
                        <p><strong><span>Price per minute: </span></strong><i class="fa fa-diamond"></i><span>99</span></p>
                        <p>Spy cam disabled</p>
                        <p><strong><span>Additional comments: </span></strong><span>In hac habitasse platea dictumst. Maecenas arcu luctus et massa. Ut wisi vel nibh. Cras magna diam, suscipit urna.</span></p>
                        
                        <div class="icons">
                            <a href="#"><i class='fa fa-check'></i><span>accept</span></a>
                            <a href="#"><i class='fa fa-close'></i><span>decline</span></a>
                            <a href="#" onClick="tab('edit', this);"><i class='fa fa-pencil'></i><span>edit</span></a>
                        </div>
                    </div>
                    
                    <div class="item">
                        <p><strong><span>From: </span></strong><a href="user.php">username</a></p>
                        <p><strong><span>Type: </span></strong><span>private webcam performance with 2-way audio/video</span></p>
                        <p><strong><span>Time: </span></strong><span>29.08.2017 18:00</span></p>
                        <p><strong><span>Min. length: </span></strong><span>20 minutes</span></p>
                        <p><strong><span>Activity: </span></strong><span>wybrane z listy użytkownika</span></p>
                        <p><strong><span>Price per minute: </span></strong><i class="fa fa-diamond"></i><span>149</span></p>
                        <p>Spy cam enabled</p>
                        <p><strong><span>Additional comments: </span></strong><span>-</span></p>
                        
                        <div class="icons">
                            <a href="#"><i class='fa fa-check'></i><span>accept</span></a>
                            <a href="#"><i class='fa fa-close'></i><span>decline</span></a>
                            <a href="#" onClick="tab('edit', this);"><i class='fa fa-pencil'></i><span>edit</span></a>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="received-accepted">
                <div class="wrapper">
                    <div class="item">
                        <p><strong><span>From: </span></strong><a href="user.php">username</a></p>
                        <p><strong><span>Type: </span></strong><span>in person</span></p>
                        <p><strong><span>Time: </span></strong><span>22.08.2017 20:00</span></p>
                        <p><strong><span>Length: </span></strong><span>1 hour</span></p>
                        <p><strong><span>Activity: </span></strong><span>wybrane z listy użytkownika</span></p>
                        <p><strong><span>Price: </span></strong><i class="fa fa-diamond"></i><span>999</span></p>
                        <p><strong><span>Additional comments: </span></strong><span>Nulla aliquet congue id, orci. Nullam in faucibus lectus varius vitae, faucibus augue. Sed sollicitudin arcu. In hac habitasse platea dictumst. Maecenas arcu luctus et massa. Ut wisi vel nibh. Cras magna diam, suscipit urna.</span></p>
                        
                        <div class="icons">
                            <span class="lt-prim-txt"><strong><i class='fa fa-check'></i><span>accepted</span></strong></span>
                            <a href="#" onClick="tab('edit', this);"><i class='fa fa-pencil'></i><span>edit</span></a>
                            <a href="#" data-toggle="modal" data-target="#cancel" ><i class='fa fa-close'></i><span>cancel</span></a>
                        </div>
                    </div>
                    
                    <div class="item">
                        <p><strong><span>From: </span></strong><a href="user.php">username</a></p>
                        <p><strong><span>Type: </span></strong><span>private webcam performance with chat only</span></p>
                        <p><strong><span>Time: </span></strong><span>25.08.2017 22:00</span></p>
                        <p><strong><span>Min. length: </span></strong><span>10 minutes</span></p>
                        <p><strong><span>Activity: </span></strong><span>wybrane z listy użytkownika</span></p>
                        <p><strong><span>Price per minute: </span></strong><i class="fa fa-diamond"></i><span>99</span></p>
                        <p>Spy cam disabled</p>
                        <p><strong><span>Additional comments: </span></strong><span>In hac habitasse platea dictumst. Maecenas arcu luctus et massa. Ut wisi vel nibh. Cras magna diam, suscipit urna.</span></p>
                        
                        <div class="icons">
                            <span class="lt-prim-txt"><strong><i class='fa fa-check'></i><span>accepted</span></strong></span>
                            <a href="#" onClick="tab('edit', this);"><i class='fa fa-pencil'></i><span>edit</span></a>
                            <a href="#" data-toggle="modal" data-target="#cancel" ><i class='fa fa-close'></i><span>cancel</span></a>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="received-declined">
                
                <div class="wrapper">
                    <div class="item">
                        <p><strong><span>From: </span></strong><a href="user.php">username</a></p>
                        <p><strong><span>Type: </span></strong><span>in person</span></p>
                        <p><strong><span>Time: </span></strong><span>22.08.2017 20:00</span></p>
                        <p><strong><span>Length: </span></strong><span>1 hour</span></p>
                        <p><strong><span>Activity: </span></strong><span>wybrane z listy użytkownika</span></p>
                        <p><strong><span>Price: </span></strong><i class="fa fa-diamond"></i><span>999</span></p>
                        <p><strong><span>Additional comments: </span></strong><span>Nulla aliquet congue id, orci. Nullam in faucibus lectus varius vitae, faucibus augue. Sed sollicitudin arcu. In hac habitasse platea dictumst. Maecenas arcu luctus et massa. Ut wisi vel nibh. Cras magna diam, suscipit urna.</span></p>
                        
                        <div class="icons">
                            <span class="lt-prim-txt"><strong><i class='fa fa-close'></i><span>declined</span></strong></span>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="received-edited">
                
                 <div class="wrapper">
                    
                    <div class="item">
                        <p><strong><span>From: </span></strong><a href="user.php">username</a></p>
                        <p><strong><span>Type: </span></strong><span>private webcam performance with chat only</span></p>
                        <p><strong><span>Time: </span></strong><span>25.08.2017 22:00</span></p>
                        <p><strong><span>Min. length: </span></strong><span>10 minutes</span></p>
                        <p><strong><span>Activity: </span></strong><span>wybrane z listy użytkownika</span></p>
                        <p><strong><span>Price per minute: </span></strong><i class="fa fa-diamond"></i><span>99</span></p>
                        <p>Spy cam disabled</p>
                        <p><strong><span>Additional comments: </span></strong><span>In hac habitasse platea dictumst. Maecenas arcu luctus et massa. Ut wisi vel nibh. Cras magna diam, suscipit urna.</span></p>
                        
                        <div class="icons">
                            <div class="icons">
                                <span class="lt-prim-txt"><strong><i class='fa fa-hourglass-o'></i><span>waiting for user's decision</span></strong></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="item">
                        <p><strong><span>From: </span></strong><a href="user.php">username</a></p>
                        <p><strong><span>Type: </span></strong><span>private webcam performance with 2-way audio/video</span></p>
                        <p><strong><span>Time: </span></strong><span>29.08.2017 18:00</span></p>
                        <p><strong><span>Min. length: </span></strong><span>20 minutes</span></p>
                        <p><strong><span>Activity: </span></strong><span>wybrane z listy użytkownika</span></p>
                        <p><strong><span>Price per minute: </span></strong><i class="fa fa-diamond"></i><span>149</span></p>
                        <p>Spy cam enabled</p>
                        <p><strong><span>Additional comments: </span></strong><span>-</span></p>
                        
                        <div class="icons">
                            <a href="#"><i class='fa fa-check'></i><span>accept</span></a>
                            <a href="#"><i class='fa fa-close'></i><span>decline</span></a>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
        </div> -->
        
    </div>
            
    <div class="part">
        <h6><?php echo $translate->getString("sentRequests") ?></h6>
             
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#sent-pending" aria-controls="sent-pending" role="tab" data-toggle="tab"><?php echo $translate->getString("pending") ?></a></li>
            <li role="presentation" class=""><a href="#sent-accepted" aria-controls="sent-accepted" role="tab" data-toggle="tab"><?php echo $translate->getString("accepted") ?></a></li>
            <li role="presentation" class=""><a href="#sent-declined" aria-controls="sent-declined" role="tab" data-toggle="tab"><?php echo $translate->getString('declined') ?></a></li>
            <li role="presentation" class=""><a href="#sent-edited" aria-controls="sent-edited" role="tab" data-toggle="tab"><?php echo $translate->getString("editedRequests") ?></a></li>
        </ul>

        <div class="tab-content">

            <div role="tabpanel" class="tab-pane fade in active" id="sent-pending">
                <?php $sentPending = $requests->getSentPending(); ?>
                <?php if(!empty($sentPending)): ?>
                    <div class="wrapper">
                        <?php foreach($sentPending as $request):?>
                            <?php switch($request->getType()): 
                                case 1:
                                case 2: ?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("to") ?>: </span></strong><a href="/<?php echo ($request->getToUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getToUser()->getLogin() ?>"><?php echo $request->getToUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $request->getType()==1 ? $translate->getString("Tactivity-privateChat") : $translate->getString("Tactivity-privateAll") ; ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("minLength") ?>: </span></strong><span><?php echo $request->getMinDuration() ?> <?php echo $translate->getString("minutes")?></span></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("pricePerMinute") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku webcam performance-->
                                        <p><?php echo $request->getSpyCam() ? $translate->getString("spyCamEnabled") : $translate->getString("spyCamDisabled") ?></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <span class="lt-prim-txt"><strong><i class='fa fa-hourglass-o'></i><span><?php echo $translate->getString("wait4uDecision") ?></span></strong></span>
                                        </div>
                                    </div>
                                    <?php break; ?>    

                                <?php case 3:?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("to") ?>: </span></strong><a href="/<?php echo ($request->getToUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getToUser()->getLogin() ?>"><?php echo $request->getToUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $translate->getString("Tactivity-person") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <?php if(!is_null($request->getDuration())):?>
                                            <p><strong><span><?php echo $translate->getString("length") ?>: </span></strong><span><?php echo $request->getDuration() ?> <?php echo $translate->getString("hour")?></span></p><!--w przypadku in person service z płatnością za godzinę-->
                                        <?php endif ?>
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("price") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku in person-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <span class="lt-prim-txt"><strong><i class='fa fa-hourglass-o'></i><span><?php echo $translate->getString("wait4uDecision") ?></span></strong></span>
                                        </div>
                                    </div>
                                    <?php break; ?>                        
                            <?php endswitch ?>
                        <?php endforeach?>
                    </div>
                <?php else: ?>
                    <div class="no-content">
                        <p><?php echo $translate->getString("noPendingRequests") ?></p>
                    </div>
                <?php endif ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="sent-accepted">
                <?php $sentAccepted = $requests->getSentAccepted() ?>
                <?php if(!empty($sentAccepted)): ?>
                    <div class="wrapper">
                        <?php foreach($sentAccepted as $request):?>
                            <?php switch($request->getType()): 
                                case 1:
                                case 2: ?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("to") ?>: </span></strong><a href="/<?php echo ($request->getToUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getToUser()->getLogin() ?>"><?php echo $request->getToUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $request->getType()==1 ? $translate->getString("Tactivity-privateChat") : $translate->getString("Tactivity-privateAll") ; ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("minLength") ?>: </span></strong><span><?php echo $request->getMinDuration() ?> <?php echo $translate->getString("minutes")?></span></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("pricePerMinute") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku webcam performance-->
                                        <p><?php echo $request->getSpyCam() ? $translate->getString("spyCamEnabled") : $translate->getString("spyCamDisabled") ?></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <span class="lt-prim-txt"><strong><i class='fa fa-check'></i><span><?php echo $translate->getString("accepted") ?></span></strong></span>
                                            <!-- <a href="/dashboard-model.php?action=changeRequestStatus&status=3&id=<?php echo $request->getId() ?>"><i class='fa fa-close'></i><span><?php echo $translate->getString("decline") ?></span></a> -->
                                        </div>
                                    </div>
                                    <?php break; ?>    

                                <?php case 3:?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("to") ?>: </span></strong><a href="/<?php echo ($request->getToUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getToUser()->getLogin() ?>"><?php echo $request->getToUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $translate->getString("Tactivity-person") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <?php if(!is_null($request->getDuration())):?>
                                            <p><strong><span><?php echo $translate->getString("length") ?>: </span></strong><span><?php echo $request->getDuration() ?> <?php echo $translate->getString("hour")?></span></p><!--w przypadku in person service z płatnością za godzinę-->
                                        <?php endif ?>
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("price") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku in person-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <span class="lt-prim-txt"><strong><i class='fa fa-check'></i><span><?php echo $translate->getString("accepted") ?></span></strong></span>
                                            <!-- <a href="/dashboard-model.php?action=changeRequestStatus&status=3&id=<?php echo $request->getId() ?>"><i class='fa fa-close'></i><span><?php echo $translate->getString("decline") ?></span></a> -->
                                        </div>
                                    </div>
                                    <?php break; ?>                        
                            <?php endswitch ?>
                        <?php endforeach?>
                    </div>
                <?php else: ?>
                    <div class="no-content">
                        <p><?php echo $translate->getString("noAcceptedRequests") ?></p>
                    </div>
                <?php endif ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="sent-declined">
                <?php $sentDeclined = $requests->getSentDeclined(); ?>
                <?php if(!empty($sentDeclined)): ?>
                    <div class="wrapper">
                        <?php foreach($sentDeclined as $request):?>
                            <?php switch($request->getType()): 
                                case 1:
                                case 2: ?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("to") ?>: </span></strong><a href="/<?php echo ($request->getToUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getToUser()->getLogin() ?>"><?php echo $request->getToUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $request->getType()==1 ? $translate->getString("Tactivity-privateChat") : $translate->getString("Tactivity-privateAll") ; ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("minLength") ?>: </span></strong><span><?php echo $request->getMinDuration() ?> <?php echo $translate->getString("minutes")?></span></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("pricePerMinute") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku webcam performance-->
                                        <p><?php echo $request->getSpyCam() ? $translate->getString("spyCamEnabled") : $translate->getString("spyCamDisabled") ?></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <span class="lt-prim-txt"><strong><i class='fa fa-close'></i><span><?php echo $translate->getString("declined") ?></span></strong></span>
                                        </div>
                                    </div>
                                    <?php break; ?>    

                                <?php case 3:?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("to") ?>: </span></strong><a href="/<?php echo ($request->getToUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getToUser()->getLogin() ?>"><?php echo $request->getToUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $translate->getString("Tactivity-person") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <?php if(!is_null($request->getDuration())):?>
                                            <p><strong><span><?php echo $translate->getString("length") ?>: </span></strong><span><?php echo $request->getDuration() ?> <?php echo $translate->getString("hour")?></span></p><!--w przypadku in person service z płatnością za godzinę-->
                                        <?php endif ?>
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("price") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku in person-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <span class="lt-prim-txt"><strong><i class='fa fa-close'></i><span><?php echo $translate->getString("declined") ?></span></strong></span>
                                        </div>
                                    </div>
                                    <?php break; ?>                        
                            <?php endswitch ?>
                        <?php endforeach?>
                    </div>
                <?php else: ?>

                    <div class="no-content">
                        <p><?php echo $translate->getString("noDeclinedRequests") ?></p>
                    </div>

                <?php endif?>
                
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="sent-edited">
                <?php $sentEdited = $requests->getSentEdited(); ?>
                <?php if(!empty($sentEdited)): ?>
                    <div class="wrapper">
                        <?php foreach($sentEdited as $request):?>
                            <?php switch($request->getType()): 
                                case 1:
                                case 2: ?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("to") ?>: </span></strong><a href="/<?php echo ($request->getToUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getToUser()->getLogin() ?>"><?php echo $request->getToUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $request->getType()==1 ? $translate->getString("Tactivity-privateChat") : $translate->getString("Tactivity-privateAll") ; ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("minLength") ?>: </span></strong><span><?php echo $request->getMinDuration() ?> <?php echo $translate->getString("minutes")?></span></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("pricePerMinute") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku webcam performance-->
                                        <p><?php echo $request->getSpyCam() ? $translate->getString("spyCamEnabled") : $translate->getString("spyCamDisabled") ?></p><!--w przypadku webcam performance-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <a href="/dashboard-model.php?action=changeRequestStatus&status=2&id=<?php echo $request->getId() ?>"><i class='fa fa-check'></i><span><?php echo $translate->getString("accept") ?></span></a>
                                            <a href="/dashboard-model.php?action=changeRequestStatus&status=3&id=<?php echo $request->getId() ?>"><i class='fa fa-close'></i><span><?php echo $translate->getString("decline") ?></span></a>
                                        </div>
                                    </div>
                                    <?php break; ?>    

                                <?php case 3:?>
                                    <div class="item">
                                        <p><strong><span><?php echo $translate->getString("to") ?>: </span></strong><a href="/<?php echo ($request->getToUser()->getType() == 1) ? "user" : "model"; echo '/'.$request->getToUser()->getLogin() ?>"><?php echo $request->getToUser()->getLogin() ?></a></p>
                                        <p><strong><span><?php echo $translate->getString("type") ?>: </span></strong><span><?php echo $translate->getString("Tactivity-person") ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("time") ?>: </span></strong><span><?php echo $request->getDate()->format("d.m.Y h:i a") ?></span></p>
                                        <?php if(!is_null($request->getDuration())):?>
                                            <p><strong><span><?php echo $translate->getString("length") ?>: </span></strong><span><?php echo $request->getDuration() ?> <?php echo $translate->getString("hour")?></span></p><!--w przypadku in person service z płatnością za godzinę-->
                                        <?php endif ?>
                                        <p><strong><span><?php echo $translate->getString("activity") ?>: </span></strong><span><?php echo $request->getActivity()->getDescription() ?></span></p>
                                        <p><strong><span><?php echo $translate->getString("price") ?>: </span></strong><i class="fa fa-diamond"></i><span><?php echo $request->getPrice() ?></span></p><!--w przypadku in person-->
                                        <p><strong><span><?php echo $translate->getString("additionalComments") ?>: </span></strong><span><?php echo $request->getAdditionalComments() ?></span></p>
                                        
                                        <div class="icons">
                                            <a href="/dashboard-model.php?action=changeRequestStatus&status=2&id=<?php echo $request->getId() ?>"><i class='fa fa-check'></i><span><?php echo $translate->getString("accept") ?></span></a>
                                            <a href="/dashboard-model.php?action=changeRequestStatus&status=3&id=<?php echo $request->getId() ?>"><i class='fa fa-close'></i><span><?php echo $translate->getString("decline") ?></span></a>
                                        </div>
                                    </div>
                                    <?php break; ?>                        
                            <?php endswitch ?>
                        <?php endforeach?>
                    </div>
                <?php else: ?>
                    <div class="no-content">
                        <p><?php echo $translate->getString("noEditedRequests") ?></p>
                    </div>
                <?php endif?>
            </div>

        </div>
                
    </div>    
</div>

<script>
function editRequest(requestId){
    $.ajax({
        url: "/ajax/user-dashboard-edit.php",
        type: 'post',
        data: {requestId},
        success: function(data){
            $("#content").html(data);
        }
    })
}
</script>
