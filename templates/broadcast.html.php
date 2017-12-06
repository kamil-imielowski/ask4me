<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="broadcast profile model content">
    
    <div class="container">
        
        <div class="top-info">
            <h3>
                <span><?php echo $translate->getString("Tactivity-public") ?></span>
                <a href="/broadcast.php?action=end" class="button med-prim-bg"><?php echo $translate->getString("endBroadcast") ?></a>
            </h3>
            <div class="viewers">
                <p class="xl-txt">
                    <i class="fa fa-users"></i>
                    <span><?php echo $transmission->getViewers() ?></span>
                </p>
            </div>
        </div>
    
        <div class="video-container">
                
            <div id="video-player2" class="video part">
				<!-- Kod do nadawania -->				
				<script src="/js/webrtc/webrtc.js"></script>
				<script src="/js/webrtc/jquery.cookie.js"></script>
				<input type="hidden" id="userAgent" name="userAgent" value="" />		
				<input type="hidden" id="sdpURL" size="50" value="wss://59d1dcdf890ea.streamlock.net/webrtc-session.json"/>
				<input type="hidden" id="applicationName" size="25" value="webrtc"/>
				<input type="hidden" id="streamName" size="25" value=""/>
				<input type="hidden" id="videoBitrate" size="10" value="360"/>
				<input type="hidden" id="audioBitrate" size="10" value="64"/>
				<input type="hidden" id="videoFrameRate" size="10" value="29.97"/>
				<input type="button" id="buttonGo" onclick="start()" value="start" />
				<video id="localVideo" autoplay muted></video>				
				<script type="text/javascript">		
				document.getElementById("userAgent").value = navigator.userAgent;
				var video = document.getElementById("localVideo");			
				$( document ).ready(function() {
					$("#sdpURL").val("wss://59d1dcdf890ea.streamlock.net/webrtc-session.json");
					var id_stream = <?php echo $transmission->getId() ?>; // tu zmienna np: ID transmisji, nazwa uzytkownika nadającego itp.
					$("#streamName").val("ask_"+id_stream);				
					setTimeout(function(){ $('#buttonGo').click(); }, 1000);				
				});

				pageReady();
				</script>	
				<!-- koniec Kod do nadawania -->
                <div id="errorMsg"></div>
            </div>
                
            <div id="chat2" class="chat part">
                <ul id="chat-nav" class="chat-nav" role="tablist">
                    <li role="presentation" class="active"><a href="#group" aria-controls="group" role="tab" data-toggle="tab">Group chat</a></li>
                    <li role="presentation"><a href="#private" aria-controls="private" role="tab" data-toggle="tab">Private chat</a></li>
                    <li role="presentation"><a href="#user-list" aria-controls="users" role="tab" data-toggle="tab">Users</a></li>
                </ul>
                <div class="message-box tab-content">
                    
                    <div id="group" role="tabpanel" class="group tab-pane fade active in">
                        <div class="mCustomScrollbar messages" id="chatGrupContent" style="overflow:auto"></div>
                        <div id="" class="form-group type-message">
                            <input type="text" placeholder="<?php echo $translate->getString("EnterYourMessage") ?>" id="boxMSGC">
                            <button type="button" onclick="sendChatMessage()">send</button>
                        </div>
                    </div>
                    
                    <div id="private" role="tabpanel" class="private tab-pane fade">
                        <ul id="user-nav" class="users" role="tablist"></ul><!-- lista z chatami prywatnymi -->
                        <div id="userContentLiTab" class="user-box tab-content"></div><!-- dynamiczny content w js -->
                    </div>
                    
                    <div id="user-list" role="tabpanel" class="tab-pane fade">
                        <div class="mCustomScrollbar user-list" id="watchingUserList"></div><!-- lista ogladajacych - content w js -->
                    </div>  
                    
                </div>
            </div>
            
        </div>
        
        <div class="info">
            
            <div class="main-info">
            
                 <div class="top">
                    <h3><?php echo $transmission->getActivity()->getBroadcastTitle() ?></h3>
                </div>

                <div class="form activities">
                    <form>
                        <?php foreach($transmission->getActivity()->getMergeActivities() as $k => $activity): ?>
                            <?php switch($activity->getType()):
                                case 1: ?>
                                    <div class="form-group <?php echo $transmission->getSpecTAProgress(1, $activity->getId()) ?>"><!-- klasa tez completed || current || upcoming -->
                                        <span><?php echo $activity->getFirstOption()->getDescription() ?></span>
                                        <label><?php echo $translate->getString($transmission->getSpecTAProgress(1, $activity->getId())) ?></label>
                                    </div>
                                    <?php break; ?>
                                
                                <?php case 2: ?>
                                    <div class="form-group <?php echo $transmission->getSpecTAProgress(2, $activity->getId()) ?>">
                                        <span><?php echo $activity->getDescription() ?><span>
                                        <label><?php echo $translate->getString($transmission->getSpecTAProgress(2, $activity->getId())) ?></label>
                                    </div>
                                    <?php break; ?>

                            <?php endswitch ?>
                        <?php endforeach ?>

                        
                        <!-- <div class="form-group completed">
                            <div class="select">
                                <select disabled>
                                    <option value="1" selected>Activity 1</option>
                                    <option value="2">Activity 2</option>
                                    <option value="3">Activity 3</option>
                                    <option value="4">Activity 4</option>
                                 </select>
                            </div>
                            <label>Completed</label>
                        </div>
                        
                        <div class="form-group current">
                            <div class="select">
                                <select disabled>
                                    <option value="1">Activity 1</option>
                                    <option value="2" selected>Activity 2</option>
                                    <option value="3">Activity 3</option>
                                    <option value="4">Activity 4</option>
                                 </select>
                            </div>
                            <label>Current</label>
                        </div>
                        
                        <div class="form-group upcoming">
                            <div class="select">
                                <select>
                                    <option value="1">Activity 1</option>
                                    <option value="2">Activity 2</option>
                                    <option value="3" selected>Activity 3</option>
                                    <option value="4">Activity 4</option>
                                 </select>
                            </div>
                            <label>Upcoming</label>
                            <a href="#" class="remove"><i class="fa fa-trash"></i></a>
                        </div>
                        
                        <div class="form-group upcoming">
                            <div class="select">
                                <select>
                                    <option value="1">Activity 1</option>
                                    <option value="2">Activity 2</option>
                                    <option value="3">Activity 3</option>
                                    <option value="4" selected>Activity 4</option>
                                 </select>
                            </div>
                            <label>Upcoming</label>
                            <a href="#" class="remove"><i class="fa fa-trash"></i></a>
                        </div>
                        
                        <a href="#" class="add-activity"><i class="fa fa-plus lt-txt"></i><span>Add another activity</span></a> -->
                        
                    </form>
                </div>

            </div>

            <div class="sidebar">
                <div class="box activity">
                    <h6><?php echo $translate->getString("currentActivity") ?></h6>
                    <div id="currentActivityContainer" class="inside">
                        <?php if($transmission->getCurrentActivity()->getType() == 1): ?>
                            <div class="vote"><!--dla vote activity-->
                                <p>
                                    <label><?php echo $translate->getString("currentActivityType") ?>:</label>
                                    <span><?php echo $translate->getString("vote") ?></span>
                                </p>

                                <label>What should I do next?</label>
                                <form>
                                    <div class="form-group">
                                        <div class="radio">
                                            <span><?php echo $transmission->getCurrentActivity()->getFirstOption()->getDescription() ?> - </span><i class="fa fa-diamond"></i><span><?php echo $transmission->getCurrentActivity()->getFirstOption()->getPrice() ?></span>
                                        </div>
                                        <div class="progress-info">
                                            <div class="progress">
                                                <div class="progress-bar" id="progressBarFirstOPTVotes" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($transmission->getCurrentActivityProgress()['option1']/$transmission->getCurrentActivity()->getVotesToWin()) * 100 ?>%"></div>
                                            </div>
                                            <span class="xs-txt"><bdi id="currentFirstOPTVotes"><?php echo $transmission->getCurrentActivityProgress()['option1'] ?></bdi>/<?php echo $transmission->getCurrentActivity()->getVotesToWin() ?> <?php echo $translate->getString("votes") ?></span>  
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="radio">
                                            <span><?php echo $transmission->getCurrentActivity()->getSecondOption()->getDescription() ?> - </span><i class="fa fa-diamond"></i><span><?php echo $transmission->getCurrentActivity()->getSecondOption()->getPrice() ?></span>
                                        </div>
                                        <div class="progress-info">
                                            <div class="progress">
                                                <div class="progress-bar" id="progressBarSecondOPTVotes" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($transmission->getCurrentActivityProgress()['option2']/$transmission->getCurrentActivity()->getVotesToWin()) * 100 ?>%"></div>
                                            </div>
                                            <span class="xs-txt"><bdi id="currentSecondOPTVotes"><?php echo $transmission->getCurrentActivityProgress()['option2'] ?></bdi>/<?php echo $transmission->getCurrentActivity()->getVotesToWin() ?> <?php echo $translate->getString("votes") ?></span>  
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="radio">
                                            <span><?php echo $transmission->getCurrentActivity()->getThirdOption()->getDescription() ?> - </span><i class="fa fa-diamond"></i><span><?php echo $transmission->getCurrentActivity()->getThirdOption()->getPrice() ?></span>
                                        </div>
                                        <div class="progress-info">
                                            <div class="progress">
                                                <div class="progress-bar" id="progressBarThirdOPTVotes" role="progressbar" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($transmission->getCurrentActivityProgress()['option3']/$transmission->getCurrentActivity()->getVotesToWin()) * 100 ?>%"></div>
                                            </div>
                                            <span class="xs-txt"><bdi id="currentThirdOPTVotes"><?php echo $transmission->getCurrentActivityProgress()['option3'] ?></bdi>/<bdi id="requiredVotesToWin"><?php echo $transmission->getCurrentActivity()->getVotesToWin() ?></bdi> <?php echo $translate->getString("votes") ?></span>  
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php elseif($transmission->getCurrentActivity()->getType() == 2): ?>
                            <div class="doing-something"><!--dla doing something activity-->
                                <p>
                                    <label><?php echo $translate->getString("currentActivityType") ?>:</label>
                                    <span><?php echo $translate->getString("doingSTH") ?></span>
                                </p>

                                <label><?php echo $translate->getString("activityDescription") ?>:</label>
                                
                                <p><?php echo $transmission->getCurrentActivity()->getDescription() ?></p>
                                
                                <div class="goal-info">
                                    <p>
                                        <label><?php echo $translate->getString("requiredTokens") ?>:</label>
                                        <span><i class="fa fa-diamond"></i><span id="requiredTokens_doSTH"><?php echo $transmission->getCurrentActivity()->getPrice() ?></span></span>
                                    </p>
                                    <div class="progress-info">
                                        <div class="progress">
                                            <div class="progress-bar" id="progressBar_doSTH" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($transmission->getCurrentActivityProgress() / $transmission->getCurrentActivity()->getPrice()) * 100 ?>%"></div>
                                        </div>
                                        <span class="xs-txt"><i class="fa fa-diamond"></i><span id="currentTokens_doSTH"><?php echo $transmission->getCurrentActivityProgress() ?></span></span>
                                    </div>
                                </div>
                                
                            </div>
                        <?php endif ?>

                    </div>     
                </div>

                <div class="box tokens">
                    <h6><?php echo $translate->getString("tokens") ?></h6>
                    <div class="inside">
                        <div class="goal-info">
                            <p>
                                <label><?php echo $translate->getString("tokensReceived") ?>:</label>
                                <span><i class="fa fa-diamond"></i><span id="tokenReceivedContainer">0</span></span>
                            </p>
                        </div>

                        <ol>
                            <label><?php echo $translate->getString("mostTokensFrom") ?>:</label>
                            <div id="mostTokensFromContainer"></div>
                        </ol>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
 
    <?php include_once dirname(__FILE__).'/includes/modals.html.php';?>
    
</div>

<script src="/js/broadcast.js" data-transmissionId="<?php echo $transmission->getId() ?>" data-username="<?php echo $user->getLogin(); ?>" data-id="broadcast"></script>

<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>