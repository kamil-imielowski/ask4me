<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$products = new \classes\Product\ProductsFactory(null, $_POST['nick']);
$translate = new \classes\Languages\Translate();
?>
<div class="store animated fadeIn">
    
    <div class="wrapper">
            <?php foreach($products->getUserProducts() as $product){?>
                <div class="item model-item">
                    <div class="icons">
                        <a href="/cart.php?action=addProduct&id=<?php echo $product->getId() ?>&type=<?php echo $product->getType()?>" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                        <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Add to wishlist"><i class='wishlist material-icons'></i></a>
                    </div>
                    <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>">
                        <div class="photo" style="background:url(<?php echo $product->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center"></div>
                    </a>
                    <div class="lt-med-bg white-txt text center">
                        <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>"><p class="title white-txt"><?php echo $product->getName() ?></p></a>
                        <p class="price xl-txt"><strong><i class="fa fa-diamond"></i><?php echo $product->getPrice() ?></strong></p>
                    </div>
                </div>
            <?php }?>
    </div>
    
</div>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
    
    //add/remove wishlist
    $('.wishlist').on('click', function() {
      $(this).toggleClass("remove star-pulse");
    });
</script>
