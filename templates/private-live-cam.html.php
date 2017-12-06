<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="broadcast profile model user private content">
    
    <div class="container">
        
        <div class="top-info">
            <h3>
                <span><?php echo $translate->getString("privateWebcamPerformance")?></span>
                <a href="" class="button med-prim-bg"><?php echo $translate->getString("endBroadcast")?></a>
            </h3>
            <div class="viewers time">
                <p>
                    <i class="fa fa-users"></i>
                    <span id="watcherCounter">0</span>
                </p>
                <p>
                    <i class="fa fa-clock-o"></i>
                    <span id="broadcastTimer"></span>
                </p>
            </div>
        </div>
    
        <div class="video-container">
            
            <div id="video-player" class="video part">
                <!-- Kod do oglądania -->
				<script type="text/javascript" src="//player.wowza.com/player/latest/wowzaplayer.min.js"></script>				
				<?php
				$id_stream = $transmission->getId(); // tu zmienna np: ID transmisji, nazwa uzytkownika nadającego itp.
				//$ip_server = file_get_contents("wowzaBalancer.txt");
				$ip_server = "167.114.211.128:1935";
				$urlplayer = "https://59d1dcdf890ea.streamlock.net/webrtc/ask_".$id_stream."_present4u/playlist.m3u8";
				?>
				<script type="text/javascript">
				WowzaPlayer.create('video-player', {
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

            <?php if($transmission->getActivity()->getType() == 3):?>
            <div id="video-player2" class="video part">
				<script src="/js/webrtc/webrtc.js"></script>
				<script src="/js/webrtc/jquery.cookie.js"></script>
				<input type="hidden" id="userAgent" name="userAgent" value="" />		
				<input type="hidden" id="sdpURL" size="50" value="wss://59d1dcdf890ea.streamlock.net/webrtc-session.json"/>
				<input type="hidden" id="applicationName" size="25" value="webrtc"/>
				<input type="hidden" id="streamName" size="25" value=""/>
				<input type="hidden" id="videoBitrate" size="10" value="360"/>
				<input type="hidden" id="audioBitrate" size="10" value="64"/>
				<input type="hidden" id="videoFrameRate" size="10" value="29.97"/>
				<!-- <input type="button" id="buttonGo" onclick="start()" value="start" /> -->
				<video id="localVideo" autoplay muted></video>				
				<script type="text/javascript">		
				document.getElementById("userAgent").value = navigator.userAgent;
				var video = document.getElementById("localVideo");			
				$( document ).ready(function() {
					$("#sdpURL").val("wss://59d1dcdf890ea.streamlock.net/webrtc-session.json");
					var id_stream = '<?php echo $transmission->getId()."SS" ?>'; 
					$("#streamName").val("ask_"+id_stream);				
					//setTimeout(function(){ $('#buttonGo').click(); }, 1000);				
					setTimeout(function(){ start() }, 1000);				
				});
				pageReady();
				</script>	
            </div>
            <?php endif?>
                
            <div id="chat2" class="chat part">
                <ul id="chat-nav" class="chat-nav" role="tablist">
                    <li role="presentation" class="active"><a href="#private" aria-controls="private" role="tab" data-toggle="tab"><?php echo $translate->getString("privateChat")?></a></li>
                </ul>
                <div class="message-box tab-content">
                    
                    <div id="private" role="tabpanel" class="private tab-pane fade active in">
                        <div class="mCustomScrollbar messages" style="overflow:auto" id="chatContent"></div>
                        <div id="" class="form-group type-message">
                            <input type="text" placeholder="<?php echo $translate->getString("EnterYourMessage") ?>"  id="boxMSGC">
                            <input type="submit" value="" onclick="sendChatMessage()">
                        </div>
                    </div>
                
                </div>
            </div>
            
        </div>
        
        <div class="info">
            
            <div class="main-info">
            
                 <div class="top">
                    <!-- <h3><?php echo $transmission->getActivity()->getActivity()->getDescription() ?></h3> -->
                    <div class="cover empty">
                        <div class="user">
                            <div class="info">
                            <a href="/model/<?php echo $transmission->getUser()->getLogin() ?>"><div class="avatar circle" style="background:url(<?php echo $transmission->getUser()->getProfilePicture()->getSRCThumbImage() ?>) no-repeat center center"></div></a>
                                <div class="text white-txt">
                                    <p class="lg-txt">
                                        <a href="/model/<?php echo $transmission->getUser()->getLogin() ?>"><span><?php echo $transmission->getUser()->getLogin()?>,</span></a>
                                        <span class="lt-txt"><?php echo $transmission->getUser()->getCountry()->getName()?></span>
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
                    <h6><?php echo $translate->getString("activityInfo") ?></h6>
                    <div class="inside">
                        <p>
                            <label><?php echo ucfirst($translate->getString("activity")) ?>: </label>
                            <span><?php echo $transmission->getActivity()->getActivity()->getDescription() ?></span>
                        </p>

                        <p>
                            <label><?php echo $translate->getString("minDurationInMin")?>: </label>
                            <span><?php echo $transmission->getActivity()->getMinDuration()?></span>
                        </p>

                        <p>
                            <label><?php echo $translate->getString("pricePerMinute")?>: </label>
                            <span><i class="fa fa-diamond"></i><span> <?php echo $transmission->getActivity()->getPrice() ?></span></span>
                        </p>

                        <p>
                            <label><?php echo $translate->getString("spyCam")?>: </label>
                            <span><?php echo $transmission->getActivity()->getSpyCam() ? $translate->getString("enabled") : $translate->getString("disabled") ?></span>
                        </p>
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
                        
                    </div>
                </div>
            </div>

        </div>
        
    </div>
 
    <?php include_once dirname(__FILE__).'/includes/modals.html.php';?>
    
</div>

<script src="/js/watch-live-cam-private.js" 
    data-broadcaster="<?php echo $transmission->getUser()->getLogin(); ?>" 
    data-invitedUser="<?php echo $transmission->getActivity()->getInvitedUser()->getLogin(); ?>" 
    data-transmissionId="<?php echo $transmission->getId() ?>" 
    data-username="<?php echo isset($user) ? $user->getLogin() : null ; ?>" 
    data-userId="<?php echo isset($user)? $user->getId() : null ?>" 
    data-id="watch-live-cam">
</script>

<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>