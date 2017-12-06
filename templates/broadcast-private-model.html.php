<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="broadcast profile model private content">
    
    <div class="container">

        <div class="top-info">
            <h3>
                <span><?php echo $translate->getString("privateWebcamPerformance") ?></span>
                <a h-ref="#" onClick="endedPrivBroadcast()" class="button med-prim-bg"><?php echo $translate->getString("endBroadcast") ?></a>
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
					var id_stream = '<?php echo $transmission->getId() ?>'; 
					$("#streamName").val("ask_"+id_stream);				
					//setTimeout(function(){ $('#buttonGo').click(); }, 1000);				
					setTimeout(function(){ start() }, 1000);				
				});
				pageReady();
				</script>	
            </div>

            <?php if($transmission->getActivity()->getType() == 3):?>
            <div id="video-player22" class="video part">
                <!-- Kod do oglądania -->
				<script type="text/javascript" src="//player.wowza.com/player/latest/wowzaplayer.min.js"></script>				
				<?php
				$id_stream = $transmission->getId()."SS"; // tu zmienna np: ID transmisji, nazwa uzytkownika nadającego itp.
				//$ip_server = file_get_contents("wowzaBalancer.txt");
				$ip_server = "167.114.211.128:1935";
				$urlplayer = "https://59d1dcdf890ea.streamlock.net/webrtc/ask_".$id_stream."_present4u/playlist.m3u8";
				?>
				<script type="text/javascript">
				WowzaPlayer.create('video-player22', {
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
            <?php endif?>
                
            <div id="chat2" class="chat part">
                <ul id="chat-nav" class="chat-nav" role="tablist">
                    <li role="presentation" class="active"><a href="#private" aria-controls="private" role="tab" data-toggle="tab">Private chat</a></li>
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
                    <h4><?php echo $translate->getString("Activityinfo") ?></h4>
                    <p>
                        <label><?php echo $translate->getString("partner")?>: </label>
                        <span><a href="/<?php echo $partner->getType() == 1 ? 'user/' : 'model/' ?><?php echo $partner->getLogin() ?>" target="_blink"><?php echo $partner->getLogin() ?></a></span>
                    </p>
                    
                    <p>
                        <label><?php echo $translate->getString("activity")?>: </label>
                        <span><?php echo $transmission->getActivity()->getActivity()->getDescription() ?></span>
                    </p>
                    
                    <p>
                        <label><?php echo $translate->getString("minDurationInMin") ?>: </label>
                        <span><?php echo $transmission->getActivity()->getMinDuration()?></span>
                    </p>
                    
                    <p>
                        <label><?php echo $translate->getString("pricePerMinute") ?>: </label>
                        <span><i class="fa fa-diamond"></i><span> <?php echo $transmission->getActivity()->getPrice() ?></span></span>
                    </p>
                    
                    <p>
                        <label><?php echo $translate->getString("tokensReceived") ?>: </label>
                        <span><i class="fa fa-diamond"></i><span> <bdi id="tokensReceived">0</bdi></span></span>
                    </p>
                    
                    <p>
                        <label><?php echo $translate->getString("spyCam")?>: </label>
                        <span><?php echo $transmission->getActivity()->getSpyCam() ? $translate->getString("enabled") : $translate->getString("disabled") ?></span>
                    </p>
                    
                </div>

            </div>

        </div>
        
    </div>
 
    <?php include_once dirname(__FILE__).'/includes/modals.html.php';?>
    
</div>

<script src="/js/broadcast-private.js" data-transmissionId="<?php echo $transmission->getId() ?>" data-username="<?php echo $user->getLogin(); ?>" data-id="broadcast"></script>

<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>