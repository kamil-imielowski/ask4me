<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="model profile content has-sidebar">
    
    <div class="container">
    
        <div class="main">
            
            <div class="top">
                <div class="cover" style="background:url(<?php echo $profileCustomer->getCoverPhoto()->getSRCOrginalImage() ?>) no-repeat center center">
                    <div class="social-media white-txt">
                        <a href="<?php echo $profileCustomer->getSocialMedia()->getFacebook(); ?>" target="blank"><i class="fa fa-facebook"></i></a>
                        <a href="<?php echo $profileCustomer->getSocialMedia()->getGooglePlus(); ?>" target="blank"><i class="fa fa-google-plus"></i></a>
                        <a href="<?php echo $profileCustomer->getSocialMedia()->getTwitter(); ?>" target="blank"><i class="fa fa-twitter"></i></a>
                        <a href="<?php echo $profileCustomer->getSocialMedia()->getInstagram(); ?>" target="blank"><i class="fa fa-instagram"></i></a>
                        <a href="<?php echo $profileCustomer->getSocialMedia()->getYoutube(); ?>" target="blank"><i class="fa fa-youtube"></i></a>
                        <a href="<?php echo $profileCustomer->getSocialMedia()->getSnapchat(); ?>" target="blank"><i class="fa fa-snapchat"></i></a>
                        <a href="<?php echo $profileCustomer->getSocialMedia()->getPinterest(); ?>" target="blank"><i class="fa fa-pinterest"></i></a>
                        <a href="<?php echo $profileCustomer->getSocialMedia()->getLinkedin(); ?>" target="blank"><i class="fa fa-linkedin"></i></a>
                    </div>
                    <div class="user">
                        <div class="info">
                            <div class="avatar circle" style="background:url(<?php echo $profileCustomer->getProfilePicture()->getSRCThumbImage() ?>) no-repeat center center"></div>
                            <div class="text white-txt">
                                <p class="lg-txt">
                                    <span><?php echo $profileCustomer->getLogin() ?>,</span>
                                    <span class="lt-txt"><?php echo $profileCustomer->getCountry()->getName() ?></span>
                                </p>
                                <p class="tagline"><?php echo $profileCustomer->getTagLine() ?></p>
                                <div class="followers">
                                    <i class='material-icons'>favorite_border</i>
                                    <span id="quntityFollowers"><?php echo $profileCustomer->countFollowers() ?></span>
                                </div>              
                            </div>
                        </div>
                        <div class="icons">
                            <?php if(isset($user)): ?>
                                <?php if($user->getId() !== $profileCustomer->getId()): ?>
                                    <a h-ref='#' onClick="follow(<?php echo $profileCustomer->getId() ?>); updateQFollowers(<?php echo $profileCustomer->getId() ?>)" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons <?php if($user->amIfollower($profileCustomer)){echo "unfollow heartbeat";} ?>'></i></a>
                                    <a h-ref="#" class="med-prim-bg white-txt message" login="<?php echo $profileCustomer->getLogin() ?>"><i class='material-icons'>mail_outline</i></a>
                                    <a h-ref="#" data-toggle="modal" data-target="#gift" class="med-prim-bg white-txt"><i class="fa fa-gift" data-toggle="tooltip" data-placement="right" title="Send a gift"></i></a>
                                <?php else: ?>
                                    <a h-ref='#' disabled class="med-prim-bg white-txt" style="pointer-events: none; cursor: default;" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                                    <a h-ref="#" disabled class="med-prim-bg white-txt" style="pointer-events: none; cursor: default;" data-toggle="tooltip" data-placement="right" title="Send a message"><i class='material-icons'>mail_outline</i></a>
                                    <a h-ref="#" disabled data-toggle="modal" style="pointer-events: none; cursor: default;" class="med-prim-bg white-txt"><i class="fa fa-gift" data-toggle="tooltip" data-placement="right" title="Send a gift"></i></a>
                                <?php endif ?>
                            <?php else: ?>
                                <a href="/login.php?action=referer" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                                <a href="/login.php?action=referer" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Send a message"><i class='material-icons'>mail_outline</i></a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                
                <div class="menu">
                    <ul class="horizontal white-txt med-bg">
                        <div class="nav-list">
                            <li class="nav-tab"><a h-ref="#" onClick="tab('about', this);" id="model-about-nav-tab"><?php echo $translate->getString('about_me') ?></a></li>
                            <li class="nav-tab"><a h-ref="#" onClick="tab('book', this);" id="model-book-nav-tab"><?php echo $translate->getString('book_me') ?></a></li>
                            <li class="nav-tab"><a h-ref="#" onClick="tab('gallery', this);" id="model-gallery"><?php echo $translate->getString('gallery') ?></a></li>
                            <li class="nav-tab"><a h-ref="#" onClick="tab('store', this);" id="model-store-nav-tab"><?php echo $translate->getString('store') ?></a></li>
                            <li class="nav-tab"><a h-ref="#" onClick="tab('wishlist', this);" id="model-wishlist-nav-tab"><?php echo $translate->getString('wishlist') ?></a></li>
                            <li class="nav-tab"><a h-ref="#" onClick="tab('blog', this);" id="model-blog-nav-tab"><?php echo $translate->getString('blog') ?></a></li>
                            <li class="nav-tab"><a h-ref="#" onClick="tab('feedback', this);" id="model-feedback-nav-tab"><?php echo $translate->getString('feedback') ?></a></li>
                        </div>
                        <a href="/model-room/<?php echo $_GET['nick'] ?>" class="button med-prim-bg"><?php echo $translate->getString('myRoom') ?></a>
                    </ul>
                </div>
                
            </div>

            <?php include_once dirname(__FILE__).'/includes/alerts.html.php'; ?>

            <div id="content" class="profile-data"></div>
        
        </div>
        
        <div class="sidebar">
            <?php include_once dirname(__FILE__).'/includes/sidebar-right.html.php';?>
        </div>
        
    </div>
    
    <?php include_once dirname(__FILE__).'/includes/modals.html.php';?>
    
</div>


<script src="/js/follow.js"></script>
<script type="text/javascript" src="/js/gifts.js"></script>
<script type="text/javascript" src="/js/alerts.js"></script>
<script type="text/javascript" src="/js/cookies.js"></script>
<script src="/js/page-scripts/model-profile.js" data-nick=<?php echo $_GET['nick'] ?> data-id="model-profile-S"></script>


    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>