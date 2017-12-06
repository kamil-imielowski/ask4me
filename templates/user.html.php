<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="user profile content">
    
    <div class="container">
        <?php include_once dirname(__FILE__).'/includes/alerts.html.php'; ?>
        <div class="top">
                
            <div class="cover empty">
                <div class="user">
                    <div class="info">
                        <div class="avatar circle" style="background:url(<?php echo $profileCustomer->getProfilePicture()->getSRCThumbImage() ?>) no-repeat center center"></div>
                        <div class="text white-txt">
                            <p class="lg-txt">
                                <span><?php echo $profileCustomer->getLogin() ?>,</span>
                                <span class="lt-txt"><?php echo $profileCustomer->getCountry()->getName() ?></span>
                            </p>
                            <p class="tagline"></p>
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
                            <?php else: ?>
                                <a h-ref='#' disabled class="med-prim-bg white-txt" style="pointer-events: none; cursor: default;" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                            <?php endif ?>
                        <?php else: ?>
                            <a href="/login.php?action=referer" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                        <?php endif ?>
                        <a h-ref="#" class="med-prim-bg white-txt message" login="<?php echo $profileCustomer->getLogin() ?>"><i class='material-icons'>mail_outline</i></a>
                        <a h-ref="#" data-toggle="modal" data-target="#gift" class="med-prim-bg white-txt"><i class="fa fa-gift" data-toggle="tooltip" data-placement="right" title="Send a gift"></i></a>
                        <a href="#" data-toggle="modal" data-target="#request" class="med-prim-bg white-txt"><i class="fa fa-user-circle" data-toggle="tooltip" data-placement="right" title="Send a request"></i></a>
                    </div>
                </div>
            </div>
        </div>
            
        <div class="profile-data">
            <div class="part overview categories">
                <h6><?php echo $translate->getString("overview") ?></h6>
                <p><?php echo $profileCustomer->getOverview(); ?></p>
                    
                <p><span><strong><?php echo $translate->getString("gender") ?>: </strong></span><span><?php echo $profileCustomer->getGender() ?></span></p>
                <p><span><strong><?php echo $translate->getString("lookingFor") ?>: </strong></span><span><?php echo $profileCustomer->getLookingForGander() ?></span></p>
                <p class="inline">
                    <span><strong><?php echo $translate->getString("categoryPreferences") ?>: </strong></span>
                </p>
                <ul>
                <?php foreach($CF->getCategories() as $category){?>
                    <?php if(in_array($category->getId(), $profileCustomer->getCategories())){?>
                        <li><a href="#">#<?php echo $category->getCategoryInfo()->getName() ?></a></li>
                    <?php }?>
                <?php }?>
            </ul>
            </div>
            
            <div class="part wishlist-page">
                
                <h6>User's wishlist</h6>
                <div class="wrapper">
                    
                    <?php foreach($wishlistProducts->getProducts() as $product){
                    switch ($product->getType()):
                        case 1://basic
                        case 2://vip
                            ?>
                            <bdi>
                                <div class="item membership">
                                    <div class="icons">
                                        <?php if(isset($_SESSION['user'])): ?>
                                            <a href="/cart.php?action=addProduct&id=<?php echo $product->getId() ?>&type=<?php echo $product->getType()?>" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                       <?php else:?>
                                           <a href="login.php?action=referer" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                       <?php endif?>
                                   </div>
                                   <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>">
                                       <div class="photo" style="background:url(<?php echo $product->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center"></div>
                                   </a>
                                   <div class="lt-med-bg white-txt text center">
                                       <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>"><p class="title white-txt"><?php echo $product->getName() ?></p></a>
                                       <p class="price xl-txt"><strong>$</i><?php echo $product->getPrice() ?></strong></p>
                                   </div>
                               </div>
                           </bdi>

                            <?php
                            break;

                        case 3: //tokens
                            ?>
                            <bdi>
                                <div class="item tokens">
                                    <div class="icons">
                                        <?php if(isset($_SESSION['user'])): ?>
                                            <a href="/cart.php?action=addProduct&id=<?php echo $product->getId() ?>&type=<?php echo $product->getType()?>" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                            <a href="#" data-toggle="modal" onclick="getPrice(<?php echo $product->getId() ?>)" data-target="#gift-product" class="med-prim-bg white-txt"><i class="fa fa-gift" data-toggle="tooltip" data-placement="left" title="Send a gift"></i></a>
                                            <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Add to wishlist" onclick="addToWishlist(<?php echo $product->getId() ?>)"><i class='wishlist material-icons <?php echo in_array($product->getId(), $wishlist) ? 'remove star-pulse' : ''; ?>'></i></a>
                                        <?php else:?>
                                            <a href="login.php?action=referer" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                            <a href="login.php?action=referer" data-toggle="modal" data-target="#gift" class="med-prim-bg white-txt"><i class="fa fa-gift" data-toggle="tooltip" data-placement="left" title="Send a gift"></i></a>
                                            <a href="login.php?action=referer" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Add to wishlist"><i class='wishlist material-icons'></i></a>
                                        <?php endif?>
                                    </div>
                                    <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>">
                                        <div class="photo" style="background:url(<?php echo $product->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center"></div>
                                    </a>
                                    <div class="lt-med-bg white-txt text center">
                                        <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>"><p class="title white-txt"><?php echo $product->getName() ?></p></a>
                                        <p class="price xl-txt"><strong>$<?php echo $product->getPrice() ?></strong></p>
                                    </div>
                                </div>
                            </bdi>

                            <?php
                            break;

                        case 4://user
                            ?>
                            <bdi> 
                                <div class="item model-item">
                                    <div class="icons">
                                        <?php if(isset($_SESSION['user'])): ?>
                                            <?php if($user->getId() !== $profileCustomer->getId()): ?>
                                                <a href="/cart.php?action=addProduct&id=<?php echo $product->getId() ?>&type=<?php echo $product->getType()?>" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                                <a href="#" data-toggle="modal" onclick="getPrice(<?php echo $product->getId() ?>)" data-target="#gift-product" class="med-prim-bg white-txt"><i class="fa fa-gift" data-toggle="tooltip" data-placement="left" title="Send a gift"></i></a>
                                                <a onclick="addToWishlist(<?php echo $product->getId() ?>)" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Add to wishlist"><i class='wishlist material-icons <?php echo in_array($product->getId(), $wishlist) ? 'remove star-pulse' : ''; ?>'></i></a>
                                            <?php else: ?>
                                                <a href="/cart.php?action=addProduct&id=<?php echo $product->getId() ?>&type=<?php echo $product->getType()?>" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                                <a h-ref="#" disabled style="pointer-events: none; cursor: default;" data-toggle="modal" data-target="#gift-product" class="med-prim-bg white-txt"><i class="fa fa-gift" data-toggle="tooltip" data-placement="left" title="Send a gift"></i></a>
                                                <a onclick="addToWishlist(<?php echo $product->getId() ?>)" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Add to wishlist"><i class='wishlist material-icons <?php echo in_array($product->getId(), $wishlist) ? 'remove star-pulse' : ''; ?>'></i></a>
                                            <?php endif;?>
                                        <?php else:?>
                                            <a href="login.php?action=referer" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                            <a href="login.php?action=referer" data-toggle="modal" data-target="#gift-product" class="med-prim-bg white-txt"><i class="fa fa-gift" data-toggle="tooltip" data-placement="left" title="Send a gift"></i></a>
                                            <a href="login.php?action=referer" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Add to wishlist"><i class='wishlist material-icons'></i></a>
                                        <?php endif?>
                                    </div>
                                    <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>">
                                        <div class="photo" style="background:url(<?php echo $product->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center"></div>
                                    </a>
                                    <div class="lt-med-bg white-txt text center">
                                        <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>"><p class="title white-txt"><?php echo $product->getName() ?></p></a>
                                        <a href="/model/<?php echo $product->getUserProduct()->getLogin() ?>"><p class="username lt-txt xs-txt"><?php echo $product->getUserProduct()->getLogin() ?></p></a>
                                        <p class="price xl-txt"><strong><i class="fa fa-diamond"></i><?php echo $product->getPrice() ?></strong></p>
                                    </div>
                                </div>
                            </bdi>                
                            <?php 
                            break;
                        endswitch;
                    }?>
                    
                </div>
            
            </div>
        </div>
        
        <div class="ban">
            <a href="#" data-toggle="modal" data-target="#block">
                <i class='material-icons'>block</i>
                <span>Block</span>
            </a>
            <a href="#" data-toggle="modal" data-target="#report">
                <i class='material-icons'>report</i>
                <span>Report</span>
            </a>
        </div>
        
    </div>
</div>
    
<script src="/js/follow.js"></script>

<?php include_once dirname(__FILE__).'/includes/modals.html.php';?>
   
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>
<script type="text/javascript" src="/js/gifts.js"></script>
<script type="text/javascript" src="/js/alerts.js"></script>
