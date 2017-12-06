<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="broadcast profile model preview content">
    
    <div class="container">
        
        <div class="top-info">
            <h3>
                <span>Public webcam preview</span>
                <a href="#" class="button med-prim-bg" data-toggle="modal" data-target="#invitation" >Start now</a>
            </h3>
            
            <a href="dashboard.php" class="">Cancel and go back to start an activity page</a>
            <div class="viewers">
                <p class="xl-txt">
                    <i class="fa fa-users"></i>
                    <span>999</span>
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
                    <li role="presentation" class="active"><a href="#group" aria-controls="group" role="tab" data-toggle="tab">Group chat</a></li>
                    <li role="presentation"><a href="#private" aria-controls="private" role="tab" data-toggle="tab">Private chat</a></li>
                    <li role="presentation"><a href="#user-list" aria-controls="users" role="tab" data-toggle="tab">Users</a></li>
                </ul>
                <div class="message-box tab-content">
                    
                    <div id="group" role="tabpanel" class="group tab-pane fade active in">
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
                    
                    <div id="private" role="tabpanel" class="private tab-pane fade">
                        <ul id="user-nav" class="users" role="tablist">
                            <li role="presentation" class="active"><a href="#user1" aria-controls="username" role="tab" data-toggle="tab">username</a></li>
                            <li role="presentation"><a href="#user2" aria-controls="username" role="tab" data-toggle="tab">username</a></li>
                            <li role="presentation"><a href="#user3" aria-controls="username" role="tab" data-toggle="tab">username</a></li>
                            <li role="presentation"><a href="#user4" aria-controls="username" role="tab" data-toggle="tab">username</a></li>
                            <li role="presentation"><a href="#user5" aria-controls="username" role="tab" data-toggle="tab">username</a></li>
                            <li role="presentation"><a href="#user6" aria-controls="username" role="tab" data-toggle="tab">username</a></li>
                        </ul>
                        <div class="user-box tab-content">
                            <div id="user1" role="tabpanel" class="tab-pane fade active in">
                                <div class="mCustomScrollbar messages2">
                                    <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                                    <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                                </div>
                                 <div id="" class="form-group type-message">
                                    <input type="text" placeholder="Enter your message...">
                                    <input type="submit" value="">
                                </div>
                            </div>
                             <div id="user2" role="tabpanel" class="tab-pane fade">
                                 <div class="mCustomScrollbar messages2">
                                    <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                                    <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                                    <p class="message owner"><span><strong>username: </strong></span><span>message</span></p>
                                    <p class="message owner"><span><strong>username: </strong></span><span>message</span></p>
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
                             <div id="user3" role="tabpanel" class="tab-pane fade">
                                <div class="mCustomScrollbar messages2"> 
                                    <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                                    <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                                    <p class="message owner"><span><strong>username: </strong></span><span>message</span></p>
                                    <p class="message owner"><span><strong>username: </strong></span><span>message</span></p>
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
                                 </div>
                                 <div id="" class="form-group type-message">
                                    <input type="text" placeholder="Enter your message...">
                                    <input type="submit" value="">
                                </div>
                            </div>
                             <div id="user4" role="tabpanel" class="tab-pane fade">
                                 <div class="mCustomScrollbar messages2">
                                    <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                                    <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                                    <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                                 </div>
                                 <div id="" class="form-group type-message">
                                    <input type="text" placeholder="Enter your message...">
                                    <input type="submit" value="">
                                </div>
                            </div>
                             <div id="user5" role="tabpanel" class="tab-pane fade">
                                 <div class="mCustomScrollbar messages2">
                                    <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                                    <p class="message"><span><strong>username: </strong></span><span>message</span></p>
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
                                 </div>
                                 <div id="" class="form-group type-message">
                                    <input type="text" placeholder="Enter your message...">
                                    <input type="submit" value="">
                                </div>
                            </div>
                             <div id="user6" role="tabpanel" class="tab-pane fade">
                                 <div class="mCustomScrollbar messages2">
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
                                    <p class="message"><span><strong>username: </strong></span><span>message</span></p>
                                 </div>
                                 <div id="" class="form-group type-message">
                                    <input type="text" placeholder="Enter your message...">
                                    <input type="submit" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="user-list" role="tabpanel" class="tab-pane fade">
                        <div class="mCustomScrollbar user-list">
                            <div class="user">
                                <span><strong>username</strong></span>
                                <a href="">Block</a>
                                <a href="">Silence</a>
                                <div class="icons">
                                    <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                                </div>
                            </div>
                            <div class="user">
                                <span><strong>username</strong></span>
                                <a href="">Block</a>
                                <a href="">Silence</a>
                                <div class="icons">
                                    <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                                </div>
                            </div>
                            <div class="user">
                                <span><strong>username</strong></span>
                                <a href="">Block</a>
                                <a href="">Silence</a>
                                <div class="icons">
                                    <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                                </div>
                            </div>
                            <div class="user">
                                <span><strong>username</strong></span>
                                <a href="">Block</a>
                                <a href="">Silence</a>
                                <div class="icons">
                                    <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                                </div>
                            </div>
                            <div class="user">
                                <span><strong>username</strong></span>
                                <a href="">Block</a>
                                <a href="">Silence</a>
                                <div class="icons">
                                    <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                                </div>
                            </div>
                            <div class="user">
                                <span><strong>username</strong></span>
                                <a href="">Block</a>
                                <a href="">Silence</a>
                                <div class="icons">
                                    <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                                </div>
                            </div>
                            <div class="user">
                                <span><strong>username</strong></span>
                                <a href="">Block</a>
                                <a href="">Silence</a>
                                <div class="icons">
                                    <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                                </div>
                            </div>
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
                            <label>Broadcast title</label>
                            <input type="text" placeholder="Enter the title">
                        </div>
                        
                        <div class="form-group">
                            <label>1st activity</label>
                            <div class="select">
                                <select>
                                    <option value="1">Activity 1</option>
                                    <option value="2">Activity 2</option>
                                    <option value="3">Activity 3</option>
                                    <option value="4">Activity 4</option>
                                 </select>
                            </div>
                        </div>
                        
                        <a href="#" class="add-activity"><i class="fa fa-plus lt-txt"></i><span>Add another activity</span></a>
                        
                    </form>
                </div>

            </div>

        </div>
        
    </div>
 
    <?php include_once dirname(__FILE__).'/includes/modals.html.php';?>
    
</div>

<script src="http://vjs.zencdn.net/6.2.0/video.js"></script>

<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>