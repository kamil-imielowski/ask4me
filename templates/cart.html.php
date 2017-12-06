<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="store cart content">
    <div class="container section">
        <?php include_once dirname(__FILE__).'/includes/alerts.html.php'; ?>
        <?php if(!empty($products_user)){ ?>
            <div class="part store-data token-items center">
                <h3>Model items</h3>
                <form method="post" id="buyItemsForTokens">
                    <div class="wrapper products">
                        <?php $totalPrice = 0; foreach($products_user as $k){ $totalPrice += $k->getPrice();?>
                            <input type="hidden" name="products[]" value="<?php echo $k->getId() ?>">
                            <div class="item model-item">
                                <div class="icons">
                                    <a href="/cart.php?action=deleteProduct&id=<?php echo $k->getId() ?>&type=<?php echo $k->getType() ?>" class="med-prim-bg white-txt"><i class="fa fa-trash"></i></a>
                                </div>
                                <a href="/product/<?php echo $k->getId()?>/<?php echo $k->getName()?>">
                                    <div class="photo" style="background:url(<?php echo $k->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center"></div>
                                </a>
                                <div class="lt-med-bg white-txt text center">
                                    <a href="/product/<?php echo $k->getId()?>/<?php echo $k->getName()?>"><p class="title white-txt"><?php echo $k->getName() ?></p></a>
                                    <a href="/model/<?php echo $k->getUserProduct()->getLogin() ?>"><p class="username lt-txt xs-txt"><?php echo $k->getUserProduct()->getLogin() ?></p></a>
                                    <p class="price xl-txt"><strong><i class="fa fa-diamond"></i><?php echo $k->getPrice() ?></strong></p>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </form>
                <div class="summary">
                    <h2 class="lt-prim-txt"><span>Total price:</span> <i class="fa fa-diamond"></i><span><?php echo $totalPrice; ?></span></h2>
                    <p class="xl-txt"><span><strong>Payment method:</strong></span><span> token balance</span></p>
                    
                    <button value="buyItemsForTokens" name="action" class="button full med-prim-bg" form="buyItemsForTokens"><?php echo $translate->getString("buyItems"); ?></button>
                </div>
            </div>
        <?php }?>
        <?php if(!empty($products_admin)){ ?>
            <div class="part store-data token-items center">
                <h3>Membership and tokens</h3>
                    <form method="post" id="buyItemsForMoney">
                    <div class="wrapper products">
                        <?php $totalPrice=0; foreach($products_admin as $product): $totalPrice += $product->getPrice();?>
                            <input type="hidden" name="products[]" value="<?php echo $product->getId() ?>">
                            <?php if($product->getType() == 3): ?>
                            
                            <div class="item tokens">
                                <div class="icons">
                                    <a href="/cart.php?action=deleteProduct&id=<?php echo $product->getId() ?>&type=<?php echo $product->getType() ?>" class="med-prim-bg white-txt"><i class="fa fa-trash"></i></a>
                                </div>
                                <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>">
                                    <div class="photo" style="background:url(<?php echo $product->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center"></div>
                                </a>
                                <div class="lt-med-bg white-txt text center">
                                    <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>"><p class="title white-txt"><?php echo $product->getName() ?></p></a>
                                    <p class="price xl-txt"><strong>$<?php echo $product->getPrice() ?></strong></p>
                                </div>
                            </div>
                            <?php else: ?>

                            <div class="item membership">
                                <div class="icons">
                                    <a href="/cart.php?action=deleteProduct&id=<?php echo $product->getId() ?>&type=<?php echo $product->getType() ?>" class="med-prim-bg white-txt"><i class="fa fa-trash"></i></a>
                                </div>
                                <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>">
                                    <div class="photo" style="background:url(<?php echo $product->getPhoto()->getSRCOrginalImage() ?>) no-repeat center center"></div>
                                </a>
                                <div class="lt-med-bg white-txt text center">
                                    <a href="/product/<?php echo $product->getId()?>/<?php echo $product->getName()?>"><p class="title white-txt"><?php echo $product->getName() ?></p></a>
                                    <p class="price xl-txt"><strong>$<?php echo $product->getPrice() ?></strong></p>
                                </div>
                            </div>
                        <?php 
                                endif;
                            endforeach;
                        ?>
                    </div>
                    <div class="summary">
                        <h2 class="lt-prim-txt"><span>Total price:</span><span> $<?php echo $totalPrice ?></span></h2>
                        <!--
                        <div class="form-group xl-txt">
                            <label>Payment method:</label>
                            <div class="select">
                                <select name="payment">
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>
                        </div>
                        -->
                        <input type="hidden" name="action" value="buyItemsForMoney">
                        <button onclick="mrTangoCollect.submit(); return false;" form="buyItemsForMoney" id="pay-button" class="button full med-prim-bg"><?php echo $translate->getString("buyItems"); ?></button>
                    </div>
                </form>
            </div>
        <?php }?>
        <?php if(empty($products_admin) && empty($products_user)){?>
            <center><h4>Your cart is empty</h4></center>
        <?php }?>
    </div>    
</div>

<script src="https://payment.mistertango.com/resources/scripts/mt.collect.js?v=01" type="text/javascript"></script>
<script type="text/javascript">
//Main loader (mandatory)
document.addEventListener('DOMContentLoaded', function() {mrTangoCollect.load();}, false);
//Set recipient (must be registered as Mistertango merchant) (mandatory)
mrTangoCollect.set.recipient('info@ctiplus.pl');
mrTangoCollect.set.lang('pl');
mrTangoCollect.set.amount(<?php echo $totalPrice ?>);
mrTangoCollect.set.currency('EUR');
mrTangoCollect.set.description('test');
mrTangoCollect.onSuccess = function(response){
    console.log('Success response');
    console.log(response);

    $('#pay-button').text('Paid!');
    $('#pay-button').prop('disabled', true);
    $("#buyItemsForMoney").submit();
};
</script>

    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>