<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$orders = new \classes\Order\OrdersFactory($user->getId());
$translate = new \classes\Languages\Translate();
?>

<div class="section purchases animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("myPurchaseHistory"); ?></h4>
    
    <div class="wrapper">
        
        <?php foreach($orders->getOrders() as $order){ 
                foreach($order->getProducts() as $product){
        ?>
            <div class="item">
                <div class="product lt-med-bg">
                    <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>">
                       <div class="photo" style="background:url(<?php echo $product->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center"></div>
                    </a>
                    <div class="white-txt text center">
                        <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>"><p class="title white-txt"><?php echo $product->getName() ?></p></a>
                        <?php if($product->getType() == 4): ?>
                            <a href="/model/<?php echo $product->getUserProduct()->getLogin() ?>"><p class="username lt-txt xs-txt"><?php echo $product->getUserProduct()->getLogin() ?></p></a>
                            <p class="price"><strong><i class="fa fa-diamond"></i><?php echo $product->getPrice() ?></strong></p>
                        <?php else:?>
                            <p class="price"><strong>$ <?php echo $product->getPrice() ?></strong></p>
                        <?php endif;?>
                    </div>
                </div>
                <div class="purchase-info">
                    <p><strong><span>Purchased:</span></strong><span> <?php echo $order->getDate() ?></span></p>
                    <?php if($product->getType() == 4): ?>
                        <a href="download.php?action=download&file=<?php echo $product->getFileName().'&nick='.$product->getUserProduct()->getLogin() ?>.'&dir=product_file/orginal/"><i class="fa fa-download"></i><span><?php echo $translate->getString("download"); ?></span></a>
                    <?php endif;?>
                </div>
            </div>
        <?php }}?>
        
    </div>
    
</div>