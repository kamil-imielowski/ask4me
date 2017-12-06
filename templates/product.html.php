<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="store product content">
    <div class="container section">
        
        <div class="main-info part">
            <?php if($product->getType() == 4){//user Product ?>
            <div class="photo" style="background:url(<?php echo $product->getSRCFile() ?>) no-repeat center center;"></div>
            <div class="text">
                <h3><?php echo $product->getName() ?></h3>
                <p class="lg-txt"><span><?php echo $translate->getString("by") ?> </span><a href="/model/<?php echo $product->getUserProduct()->getLogin() ?>"><?php echo $product->getUserProduct()->getLogin() ?></a></p>
                <p class="xs-txt category-name"><?php echo $translate->getString("modelItems"); ?></p>
                <h2 class="price lt-prim-txt"><i class="fa fa-diamond"></i><span><?php echo $product->getPrice() ?></span></h2>
                <div class="buttons">
                    <form action="">
                        <a href="/cart.php?action=addProduct&id=<?php echo $product->getId() ?>&type=<?php echo $product->getType()?>" class="button full med-prim-bg"><?php echo $translate->getString("addToCart") ?></a>
                    </form>
                    <div class="inline">
                        <a class="button wishlist-add empty med-prim-br" data-toggle="tooltip" data-placement="bottom" title="Add to wishlist"><i class='wishlist material-icons'></i></a>
                        <a href="#" class="button gift empty med-prim-br"><i class="fa fa-gift"></i><span><?php echo $translate->getString("sendAsAGift") ?></span></a>
                    </div>
                </div>
            </div>
            <?php }else{//admin Product?>
            <div class="photo" style="background:url(<?php echo $product->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center;"></div>
            <div class="text">
                <h3><?php echo $product->getName() ?></h3>

                <p class="xs-txt category-name"><?php echo $translate->getString("featured"); ?></p>
                <h2 class="price lt-prim-txt">$</i><span><?php echo $product->getPrice() ?></span></h2>
                <div class="buttons">
                    <form action="">
                        <a href="/cart.php?action=addProduct&id=<?php echo $product->getId() ?>&type=<?php echo $product->getType()?>" class="button full med-prim-bg"><?php echo $translate->getString("addToCart") ?></a>
                    </form>
                    <div class="inline">
                        <a class="button wishlist-add empty med-prim-br" data-toggle="tooltip" data-placement="bottom" title="Add to wishlist"><i class='wishlist material-icons'></i></a>
                        <a href="#" class="button gift empty med-prim-br"><i class="fa fa-gift"></i><span><?php echo $translate->getString("sendAsAGift") ?></span></a>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
        
        <div class="description part">
            <h4><?php echo $translate->getString("productDescription") ?></h4>
            
            <div class="text">

                <p><?php echo $product->getDescription() ?></p>

            </div>
        </div>
        
        <?php if($product->getType() == 4){//user Product ?>
        <div class="related store-data part">
            <h4><span><?php echo $translate->getString("otherProductFrom") ?> </span><a href="/model/<?php echo $product->getUserProduct()->getLogin() ?>"><?php echo $product->getUserProduct()->getLogin() ?></a></h4>
            
            <div class="wrapper">
                <?php foreach($products->getUserProducts() as $k){ if($k->getId() == $product->getId()){continue;}?>
                    <div class="item model-item">
                        <div class="icons">
                            <a href="/cart.php?action=addProduct&id=<?php echo $k->getId() ?>&type=<?php echo $k->getType()?>" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                            <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Add to wishlist"><i class='wishlist material-icons'></i></a>
                        </div>
                        <a href="/product/<?php echo $k->getId()?>/<?php echo $k->getURLName()?>">
                            <div class="photo" style="background:url(<?php echo $k->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center"></div>
                        </a>
                        <div class="lt-med-bg white-txt text center">
                            <a href="/product/<?php echo $k->getId()?>/<?php echo $k->getURLName()?>"><p class="title white-txt"><?php echo $k->getName(); ?></p></a>
                            <a href="/model/<?php echo $user->getLogin() ?>"><p class="username lt-txt xs-txt"><?php echo $user->getLogin() ?></p></a>
                            <p class="price xl-txt"><strong><i class="fa fa-diamond"></i><?php echo $k->getPrice() ?></strong></p>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
        <?php }else{// admin Products ?>
        <div class="related store-data part">
            <h4><span><?php echo $translate->getString("otherProduct") ?> </span></h4>
            
            <div class="wrapper">
                <?php foreach($products->getProducts() as $k){ if($k->getId() == $product->getId()){continue;}?>
                    <div class="item model-item">
                        <div class="icons">
                            <a href="/cart.php?action=addProduct&id=<?php echo $k->getId() ?>&type=<?php echo $k->getType()?>" class="med-prim-bg white-txt"><i class='material-icons'>add_shopping_cart</i></a>
                            <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Add to wishlist"><i class='wishlist material-icons'></i></a>
                        </div>
                        <a href="/product/<?php echo $k->getId()?>/<?php echo $k->getName()?>">
                            <div class="photo" style="background:url(<?php echo $k->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center"></div>
                        </a>
                        <div class="lt-med-bg white-txt text center">
                            <a href="/product/<?php echo $k->getId()?>/<?php echo $k->getName()?>"><p class="title white-txt"><?php echo $k->getName(); ?></p></a>
                            <p class="price xl-txt"><strong>$</i><?php echo $k->getPrice() ?></strong></p>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
        <?php }?>
    
    </div>
</div>
    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>