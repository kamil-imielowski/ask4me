<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="model profile room content has-sidebar">
    
    <div class="container">
    
        <div class="main">
            
            <div class="video-container">
                
                <div id="video-player" class="video part">
                    <video id="my-video" class="video-js vjs-16-9" autoplay="true" loop="true" controls preload="auto" aspectRatio="16:9" poster="videos/video.jpg" data-setup='{"aspectRatio":"16:9"}'>
                        <source src="videos/video.mp4" type='video/mp4'>
                        <source src="videos/video.webm" type='video/webm'>
                        <p class="vjs-no-js">
                          To view this video please enable JavaScript, and consider upgrading to a web browser that
                          <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                        </p>
                    </video>
                </div>
                
                <div id="chat" class="chat part">
                    <div id="chat-content" class="message-box mCustomScrollbar">
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
                    <div id="chat-input" class="form-group type-message">
                        <input type="text" placeholder="Enter your message...">
                        <input type="submit" value="">
                    </div>
                </div>
            
            </div>
            
            <div class="top">
                <div class="menu">
                    <ul class="horizontal white-txt med-bg">
                        <div class="nav-list">
                            <li class="nav-tab"><a href="model.php">About me</a></li>
                            <li class="nav-tab"><a href="model.php">Book me</a></li>
                            <li class="nav-tab"><a href="model.php">Gallery</a></li>
                            <li class="nav-tab"><a href="model.php">Store</a></li>
                            <li class="nav-tab"><a href="model.php">Wishlist</a></li>
                            <li class="nav-tab"><a href="model.php">Blog</a></li>
                            <li class="nav-tab"><a href="model.php">Feedback</a></li>
                        </div>
                        <a href="model.php" class="button med-prim-bg">Go back to profile page</a>
                    </ul>
                </div>
                <div class="cover empty">
                    <div class="user">
                        <div class="info">
                            <div class="avatar circle" style="background:url(img/profile.jpg) no-repeat center center"></div>
                            <div class="text white-txt">
                                <p class="lg-txt">
                                    <span>Username,</span>
                                    <span class="lt-txt">Country</span>
                                </p>
                                <p class="tagline">Lorem ipsum dolor sit amet</p>
                                <div class="followers">
                                    <i class='material-icons'>favorite_border</i>
                                    <span>250</span>
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
                    <h6>Overview</h6>
                    <p>Morbi sed mi luctus, tempor arcu nec, hendrerit purus. Proin non nibh id elit vulputate ultrices. Integer finibus tincidunt leo, eu vulputate nunc. Praesent elit massa, mollis eu magna ac, ultrices pellentesque arcu. Etiam eget leo et metus viverra molestie ut eu felis. Morbi sed turpis in diam malesuada blandit volutpat ac dolor. Mauris tincidunt odio quis nunc gravida, et fermentum felis ultrices. Sed pretium metus ut ipsum consequat venenatis. Fusce nec erat nec justo tempor elementum non ut purus. Sed eleifend consectetur orci et maximus. Donec hendrerit est sed orci facilisis luctus. In hac habitasse platea dictumst. Pellentesque scelerisque, lorem quis auctor euismod, eros elit mollis ipsum, ac aliquam nunc libero a risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                </div>
            </div>
        
        </div>
        
        <div class="sidebar">
            <?php include_once dirname(__FILE__).'/includes/sidebar-right.html.php';?>
        </div>
        
    </div>
    
    <?php include_once dirname(__FILE__).'/includes/modals.html.php';?>
    
</div>

<script src="http://vjs.zencdn.net/6.2.0/video.js"></script>
    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>