<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

if(isset($_SESSION['user'])){
    $user = unserialize(base64_decode($_SESSION['user']));
    $user -> loadWishlist();
    $wishlist = $user->getWishlist();
}

$wishlistProducts = new \classes\User\WishlistFactory($_POST['nick']);
$profileCustomer = new \classes\User\User(null, $_POST['nick']);
$translate = new \classes\Languages\Translate();
?>

<div class="wishlist-page animated fadeIn">
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
<script type="text/javascript" src="/js/wishlist.js"></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
    
    //add/remove wishlist
    $('.wishlist').on('click', function() {
      $(this).toggleClass("remove star-pulse");
    });
</script>
