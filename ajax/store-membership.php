<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$products = new \classes\Product\ProductsFactory;
$products -> loadMembershipAndTokens();
$translate = new \classes\Languages\Translate($_COOKIE['lang']);

if(isset($_SESSION['user'])){
    $user = unserialize(base64_decode($_SESSION['user']));
    $user -> loadWishlist();
    $wishlist = $user->getWishlist();
}
?>
<div class="membership-tokens animated fadeIn">
    <div class="part main">
        <h4><?php echo $translate->getString("membershipAndTokens") ?></h4>
        
        <div class="wrapper">
            <?php foreach($products->getProducts() as $product):
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
                                <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getURLName()?>">
                                    <div class="photo" style="background:url(<?php echo $product->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center"></div>
                                </a>
                                <div class="lt-med-bg white-txt text center">
                                    <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getURLName()?>"><p class="title white-txt"><?php echo $product->getName() ?></p></a>
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
                                    <?php else:?>
                                        <a href="login.php?action=referer" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                                    <?php endif?>
                                </div>
                                <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getURLName()?>">
                                    <div class="photo" style="background:url(<?php echo $product->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center"></div>
                                </a>
                                <div class="lt-med-bg white-txt text center">
                                    <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getURLName()?>"><p class="title white-txt"><?php echo $product->getName() ?></p></a>
                                    <p class="price xl-txt"><strong>$<?php echo $product->getPrice() ?></strong></p>
                                </div>
                            </div>
                        </bdi>

                        <?php
                        break;

                endswitch;
            endforeach;?>
            
        </div>
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

