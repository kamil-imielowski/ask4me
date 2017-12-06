<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="store content">
    <div class="container section">
    
        <div id="content" class="store-data">
            <div class="homepage animated fadeIn">
                <?php if(!empty($standardUsers)): ?>
                    <div class="part featured">
                        <h4>Standard User</h4>
                        <div class="wrapper">

                            <?php foreach($standardUsers as $userFind): ?>

                                    <div class="profile">
                                        <div class="box">
                                            <?php if(isset($user) && $user->getId() !== $userFind->getId()){ ?>
                                            <div class="icons">
                                                <a href="messages.php" class="med-prim-bg white-txt"><i class='material-icons'>mail_outline</i></a>
                                                <a h-ref="#" onClick="follow(<?php echo $userFind->getId() ?>)" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Follow"><i class='follow material-icons <?php if($user->amIfollower($userFind)){echo "unfollow heartbeat";} ?>'></i></a>
                                            </div>
                                            <?php }?>
                                            <a href="/model/<?php echo $userFind->getLogin() ?>">
                                                <div class="photo" style="background:url(<?php echo $userFind->getProfilePicture()->getSRCThumbImage() ?>) no-repeat center center"></div>
                                                <div class="med-prim-bg white-txt text">
                                                    <span><?php echo $userFind->getLogin() ?>,</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(!empty($modelUsers)): ?>
                    <div class="part bestsellers">
                        <h4>Model User</h4>
                        <div class="wrapper">
                            
                            <?php foreach($modelUsers as $userFind): ?>

                                    <div class="profile">
                                        <div class="box">
                                            <?php if(isset($user) && $user->getId() !== $userFind->getId()){ ?>
                                            <div class="icons">
                                                <a href="messages.php" class="med-prim-bg white-txt"><i class='material-icons'>mail_outline</i></a>
                                                <a h-ref="#" onClick="follow(<?php echo $userFind->getId() ?>)" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Follow"><i class='follow material-icons <?php if($user->amIfollower($userFind)){echo "unfollow heartbeat";} ?>'></i></a>
                                            </div>
                                            <?php }?>
                                            <a href="/model/<?php echo $userFind->getLogin() ?>">
                                                <div class="photo" style="background:url(<?php echo $userFind->getProfilePicture()->getSRCThumbImage() ?>) no-repeat center center"></div>
                                                <div class="med-prim-bg white-txt text">
                                                    <span><?php echo $userFind->getLogin() ?>,</span>
                                                    <span class="lt-txt"><?php echo $userFind->getCountry()->getName() ?></span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                            <?php endforeach; ?>
                            
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if(!empty($blogs)): ?>
                    <h4>Blogs</h4>
                    <div class="wrapper">
                        <?php foreach($blogs as $blog): ?>
                            <div class="item lt-med-bg white-txt">
                                <div class="photo" style="background:url(<?php echo $blog->getPhoto()->getSRCThumbImage(); ?>) no-repeat center center">
                                </div>
                                <div class="text">
                                    <h6><a href="/blog/<?php echo $blog->getId()?>/<?php echo $blog->getURLTitle()?>"><?php echo $blog->getTitle(); ?></a></h6>
                                    <p class="xs-txt date"><?php echo $blog->getDateCreated(); ?></p>
                                    <p><span><?php echo substr($blog->getContent(), 0, 500) ?>...</span> <a href="/blog/<?php echo $blog->getId()?>/<?php echo $blog->getURLTitle()?>"><strong><span><?php echo $translate->getString("readMore") ?></span></strong></a></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if(!empty($products)): ?>
                    <div class="part new-products">
                        <h4>Products</h4>
                        <div class="wrapper">
                            <?php foreach($products as $product){
                                switch ($product->getType()){
                                    
                                    case 1://basic
                                    case 2://vip
                                        ?>
                                        <bdi>
                                            <div class="item membership">
                                                <div class="icons">
                                                    <?php if(isset($_SESSION['user'])): ?>
                                                        <a href="/cart.php?action=addProduct&id=<?php echo $product->getId() ?>&type=<?php echo $product->getType()?>" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                                    <?php else: ?>
                                                        <a href="login.php?action=referer" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                                    <?php endif;?>
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
                                                    <?php else: ?>
                                                        <a href="login.php?action=referer" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                                    <?php endif;?>
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
                                                    <a href="/cart.php?action=addProduct&id=<?php echo $product->getId() ?>&type=<?php echo $product->getType()?>" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                                    <a onclick="addToWishlist(<?php echo $product->getId() ?>)" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Add to wishlist"><i class='wishlist material-icons <?php echo in_array($product->getId(), $wishlist) ? 'remove star-pulse' : ''; ?>'></i></a>
                                                <?php else: ?>
                                                    <a href="login.php?action=referer" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                                    <a href="login.php?action=referer" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Add to wishlist"><i class='wishlist material-icons'></i>
                                                <?php endif;?>
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

                                }
                            }?>                        
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    
    </div>
</div>
    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>