<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="broadcast profile model private preview content">
    
    <div class="container">
        
        <div class="top-info">
            <h3>
                <span>Private webcam preview</span>
                <a href="" class="button med-prim-bg">Start and wait for partner</a>
            </h3>
            
            <a href="dashboard.php" class="">Cancel and go back to start an activity page</a>
            
            <div class="viewers time">
                <p>
                    <i class="fa fa-users"></i>
                    <span>1</span>
                </p>
                <p>
                    <i class="fa fa-clock-o"></i>
                    <span>02:59</span>
                </p>
            </div>
        </div>
    
        <div class="video-container">
                
            <div id="video-player2" class="video part">
                <video id="my-video" class="video-js vjs-16-9" autoplay="true" loop="true" controls preload="auto" aspectRatio="16:9" poster="videos/video.jpg" data-setup='{"aspectRatio":"16:9"}'>
                    <source src="videos/video.mp4" type='video/mp4'>
                    <source src="videos/video.webm" type='video/webm'>
                    <p class="vjs-no-js">
                      To view this video please enable JavaScript, and consider upgrading to a web browser that
                      <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                </video>
            </div>
                
            <div id="chat2" class="chat part">
                <ul id="chat-nav" class="chat-nav" role="tablist">
                    <li role="presentation" class="active"><a href="#private" aria-controls="private" role="tab" data-toggle="tab">Private chat</a></li>
                </ul>
                <div class="message-box tab-content">
                    
                    <div id="private" role="tabpanel" class="private tab-pane fade active in">
                        <div class="mCustomScrollbar messages">
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message owner"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message owner"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message owner"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message owner"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message owner"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                            <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                        </div>
                        <div id="" class="form-group type-message">
                            <input type="text" placeholder="Enter your message...">
                            <input type="submit" value="">
                        </div>
                    </div>
                
                </div>
            
            </div>
            
        </div>
        
        <div class="info">
            
            <div class="main-info">
                
                <div class="form">
                    <form>
                        
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" placeholder="Enter username">
                        </div>
                        
                        <div class="form-group">
                            <label>Or choose a previous customer</label>
                            <div class="select">
                                <select>
                                    <option value="0" selected disabled>Choose from the list</option>
                                    <option value="1">username</option>
                                    <option value="2">username</option>
                                    <option value="3">username</option>
                                    <option value="4">username</option>
                                 </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Choose an activity</label>
                            <div class="select">
                                <select>
                                    <option value="1">Activity 1</option>
                                    <option value="2">Activity 2</option>
                                    <option value="3">Activity 3</option>
                                    <option value="4">Activity 4</option>
                                 </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Min. duration (in minutes):</label>
                            <input type="text" placeholder="Minimum duration">
                        </div>
                        
                        <div class="form-group">
                            <label>Confirm or change the price (in tokens):</label>
                            <input type="text" placeholder="Price" value="99">
                        </div>
                        
                        <div class="form-group checkbox">
                            <input type="checkbox" id="checkbox3">
                            <label for="checkbox3">
                                Spy cam enabled (can be disabled by customer)
                            </label>
                        </div>
                        
                    </form>
                </div>
                
            </div>

        </div>
        
    </div>
 
    <?php include_once dirname(__FILE__).'/includes/modals.html.php';?>
    
</div>

<script src="http://vjs.zencdn.net/6.2.0/video.js"></script>

<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>