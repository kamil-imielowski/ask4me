<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="broadcast profile user content">
    
    <div class="container">
    
        <div class="video-container">
                
            <div id="video-player2" class="video part">
				<!-- Kod do oglądania -->
				<script type="text/javascript" src="//player.wowza.com/player/latest/wowzaplayer.min.js"></script>				
				<?php
				$id_stream = $transmission->getId(); // tu zmienna np: ID transmisji, nazwa uzytkownika nadającego itp.
				//$ip_server = file_get_contents("wowzaBalancer.txt");
				$ip_server = "167.114.211.128:1935";
				$urlplayer = "https://59d1dcdf890ea.streamlock.net/webrtc/ask_".$id_stream."_present4u/playlist.m3u8";
				?>
				<script type="text/javascript">
				WowzaPlayer.create('video-player2', {
						"license":"PLAY1-3KHUp-GfF8B-9QkQB-wpnmW-V3HF4",
						"title":"",
						"description":"",
						"sourceURL":"<?php echo  $urlplayer;  ?>",
						"autoPlay":true,
						"volume":"75",
						"mute":false,
						"loop":false,
						"audioOnly":false,
						"uiShowQuickRewind":true,
						"uiQuickRewindSeconds":"30"
					}
				);
				</script>
				<!-- koniec Kod do oglądania --> 
            </div>
                
            <div id="chat2" class="chat part">
                <ul id="chat-nav" class="chat-nav" role="tablist">
                    <li role="presentation" class="active"><a href="#group" aria-controls="group" role="tab" data-toggle="tab"><?php echo $translate->getString("groupChat") ?></a></li>
                    <?php if(isset($user)):?> <li role="presentation"><a href="#private" aria-controls="private" role="tab" data-toggle="tab"><?php echo $translate->getString("privateChat") ?></a></li><?php endif ?>
                </ul>
                <div class="message-box tab-content">
                    
                    <div id="group" role="tabpanel" class="group tab-pane fade active in">
                        <div class="mCustomScrollbar messages" style="overflow:auto" id="chatGrupContent"></div>
                        <div id="" class="form-group type-message">
                            <input type="text" placeholder="Enter your message..." id="boxMSGC">
                            <!-- <input type="submit" value=""> -->
                            <button type="button" onclick="sendChatMessage()">send</button>
                        </div>
                    </div>
                    
                    <?php if(isset($user)):?>
                    <div id="private" role="tabpanel" class="private tab-pane fade">
                        <div class="mCustomScrollbar messages" id="chatPrivateContent"></div>
                        <div id="" class="form-group type-message">
                            <input type="text" placeholder="Enter your message..." id="boxMSGCPrivate">
                            <button type="button" onclick="sendPrivateChatMessage()">send</button>
                        </div>
                    </div>
                    <?php endif ?>
                    
                </div>
            </div>
            
        </div>
        
        <div class="info">
            
            <div class="main-info">
            
                 <div class="top">
                    <h3><?php echo $transmission->getActivity()->getBroadcastTitle() ?></h3>
                    <div class="cover empty">
                        <div class="user">
                            <div class="info">
                                <a href="/model/<?php echo $transmission->getUser()->getLogin() ?>"><div class="avatar circle" style="background:url(<?php echo $transmission->getUser()->getProfilePicture()->getSRCThumbImage() ?>) no-repeat center center"></div></a>
                                <div class="text white-txt">
                                    <p class="lg-txt">
                                        <a href="/model/<?php echo $transmission->getUser()->getLogin() ?>"><?php echo $transmission->getUser()->getLogin() ?>,</a>
                                        <span class="lt-txt"><?php echo $transmission->getUser()->getCountry()->getName() ?></span>
                                    </p>
                                    <p class="tagline"><?php echo $transmission->getUser()->getTagLine() ?></p>
                                    <div class="followers">
                                        <i class='material-icons'>favorite_border</i>
                                        <span><?php echo $transmission->getUser()->countFollowers() ?></span>
                                    </div>              
                                </div>
                            </div>
                            <div class="icons">
                                <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                                <a href="#" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Send a message"><i class='material-icons'>mail_outline</i></a>
                                <a href="#" data-toggle="modal" data-target="#gift" class="med-prim-bg white-txt"><i class="fa fa-gift" data-toggle="tooltip" data-placement="right" title="Send a gift"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-data">
                    <div class="part overview">
                        <h6><?php echo $translate->getString("overview") ?></h6>
                        <p><?php echo htmlspecialchars($transmission->getUser()->getOverview()) ?></p>
                    </div>
                </div>

            </div>

            <div class="sidebar">
                <div class="box activity">
                    <h6><?php echo $translate->getString("currentActivity") ?></h6>
                    <div class="inside">
                        <p id="currentActivityAllerts"></p>
                        <div id="currentActivityContainer">
                            <?php if($transmission->getCurrentActivity()->getType() == 1): ?>
                                <div class="vote"><!--dla vote activity-->
                                    <p>
                                        <label><?php echo $translate->getString("currentActivityType"); ?></label>
                                        <span><?php echo $translate->getString("vote") ?></span>
                                    </p>

                                    <label><?php echo $translate->getString("whatNext") ?></label>

                                    <form id="voteForm" onsubmit="vote(); return false">
                                        <div class="form-group">
                                            <div class="radio">
                                                <input type="radio" name="voteOption" id="radio1" value="option1" checked>
                                                <label for="radio1">
                                                    <span><?php echo $transmission->getCurrentActivity()->getFirstOption()->getDescription() ?> - </span><i class="fa fa-diamond"></i><span><?php echo $transmission->getCurrentActivity()->getFirstOption()->getPrice() ?></span>
                                                </label>
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
                                                <input type="radio" name="voteOption" id="radio2" value="option2">
                                                <label for="radio2">
                                                    <span><?php echo $transmission->getCurrentActivity()->getSecondOption()->getDescription() ?> - </span><i class="fa fa-diamond"></i><span><?php echo $transmission->getCurrentActivity()->getSecondOption()->getPrice() ?></span>
                                                </label>
                                            </div>
                                            <div class="progress-info">
                                                <div class="progress">
                                                    <div class="progress-bar" id="progressBarSecondOPTVotes" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($transmission->getCurrentActivityProgress()['option2']/$transmission->getCurrentActivity()->getVotesToWin()) * 100 ?>%"></div>
                                                </div>
                                                <span class="xs-txt"><bdi id="currentSecondOPTVotes"><?php echo $transmission->getCurrentActivityProgress()['option2'] ?></bdi>/<bdi id="requiredVotesToWin"><?php echo $transmission->getCurrentActivity()->getVotesToWin() ?></bdi> <?php echo $translate->getString("votes") ?></span>  
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="radio">
                                                <input type="radio" name="voteOption" id="radio3" value="option3">
                                                <label for="radio3">
                                                    <span><?php echo $transmission->getCurrentActivity()->getThirdOption()->getDescription() ?> - </span><i class="fa fa-diamond"></i><span><?php echo $transmission->getCurrentActivity()->getThirdOption()->getPrice() ?></span>
                                                </label>
                                            </div>
                                            <div class="progress-info">
                                                <div class="progress">
                                                    <div class="progress-bar" id="progressBarThirdOPTVotes" role="progressbar" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($transmission->getCurrentActivityProgress()['option3']/$transmission->getCurrentActivity()->getVotesToWin()) * 100 ?>%"></div>
                                                </div>
                                                <span class="xs-txt"><bdi id="currentThirdOPTVotes"><?php echo $transmission->getCurrentActivityProgress()['option3'] ?></bdi>/<?php echo $transmission->getCurrentActivity()->getVotesToWin() ?> <?php echo $translate->getString("votes") ?></span>  
                                            </div>
                                        </div>
                                        <button type="submit" form="voteForm" class="button med-prim-bg" value="send a tip" name=""><?php echo $translate->getString("vote") ?></button>
                                    </form>
                                </div>

                            <?php elseif($transmission->getCurrentActivity()->getType() == 2): ?>
                            
                                <div class="doing-something"><!--dla doing something activity-->
                                    <p>
                                        <label><?php echo $translate->getString("currentActivityType"); ?>:</label>
                                        <span><?php echo strtolower($translate->getString("doingSTH")) ?></span>
                                    </p>

                                    <label><?php echo $translate->getString("activityDescription") ?>:</label>
                                    
                                    <p><?php echo $transmission->getCurrentActivity()->getDescription(); ?></p>
                                    
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
                                    
                                    <form class="inline" id="doSTHForm" onsubmit="doSTH(); return false">
                                        <input type="number" min="1" max="<?php echo $transmission->getCurrentActivity()->getPrice() - $transmission->getCurrentActivityProgress() ?>" name="amount" required placeholder="<?php echo $translate->getString("enterTokenAmount") ?>">
                                        <button type="submit" form="doSTHForm" class="button med-prim-bg" value="send a tip" name=""><?php echo $translate->getString("sendTip") ?></button>
                                    </form>
                                    
                                </div>

                            <?php endif ?>
                        </div>
                    </div>     
                </div>

                <div class="box tokens">
                    <h6><?php echo $translate->getString("tokens") ?></h6>
                    <div class="inside">
                        
                        <form class="inline" id="sendTipForm" onsubmit="sendATip(); return false">
                            <input type="number" min="1" max="" id="tip_amount" required placeholder="<?php echo $translate->getString("enterTokenAmount") ?>">
                            <button type="submit" class="button med-prim-bg" form="sendTipForm"><?php echo $translate->getString("sendTip") ?></button>
                        </form>
                        <p id="tipsAllerts"></p>

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

<script src="/js/watch-live-cam.js" data-broadcaster="<?php echo $transmission->getUser()->getLogin(); ?>" data-transmissionId="<?php echo $transmission->getId() ?>" data-username="<?php echo isset($user) ? $user->getLogin() : null ; ?>" data-userId="<?php echo isset($user)? $user->getId() : null ?>" data-id="watch-live-cam"></script>

<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>