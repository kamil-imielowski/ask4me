<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$products = new \classes\Product\ProductsFactory();
$products -> loadNewItems();
$translate = new \classes\Languages\Translate();
if(isset($_SESSION['user'])){
    $user = unserialize(base64_decode($_SESSION['user']));
    $user -> loadWishlist();
    $wishlist = $user->getWishlist();
}
?>
<div class="new-products animated fadeIn">
    <div class="part main">
        <h4><?php echo $translate->getString("newProducts") ?></h4>
        
        <div class="wrapper" id="easyPaginate">
            <?php foreach($products->getProducts() as $product){
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
        
        <div class="paginate">
            <a href="#" class="prev"><i class="fa fa-arrow-left"></i><span>Previous page</span></a>
            <a href="#" class="next"><span>Next page</span><i class="fa fa-arrow-right"></i></a>
        </div>
        
    </div>
    
</div>
<script type="text/javascript" src="/js/wishlist.js"></script>
<script type="text/javascript" src="/js/jquery.easyPaginate.js"></script>
<script type="text/javascript">
    $('#easyPaginate').easyPaginate({
        paginateElement: 'bdi',
        elementsPerPage: 15
    });
</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
    
    //add/remove wishlist
    $('.wishlist').on('click', function() {
      $(this).toggleClass("remove star-pulse");
    });
</script>

