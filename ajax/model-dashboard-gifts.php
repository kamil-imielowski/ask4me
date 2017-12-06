<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$gifts = new \classes\Gift\GiftsFactory($user->getId());
$gifts_received = clone $gifts;
$gifts->loadSentGifts();
$gifts_sent = $gifts;

$translate = new \classes\Languages\Translate();
?>

<div class="section purchases gifts animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("gifts") ?></h4>

    <div class="part">
        <h6><?php echo $translate->getString("receivedGifts"); ?></h6>
            
        <div class="wrapper">
            <?php foreach($gifts_received->getGifts() as $gift): ?>
                <?php switch($gift->getType()): 
                    case 1: ?>
                        <div class="item">
                            <div class="product lt-med-bg">
                                <div class="white-txt text center">
                                    <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="model.php" class="username lt-txt"><?php echo $gift->getSenderUser()->getLogin() ?></a></p>
                                    <p class="category xs-txt lt-txt"><?php echo $translate->getString("file"); ?></p>
                                    <p class="message white-txt"><?php echo $gift->getDescription(); ?></p>
                                </div>
                            </div>
                            <div class="purchase-info">
                                <p><strong><span><?php echo $translate->getString("received") ?>:</span></strong><span> <?php echo $gift->getDateCreated()->format('d-m-Y') ?></span></p>
                                <a href="download.php?action=download&file=<?php echo $gift->getFileName().'&nick='.$gift->getSenderUser()->getLogin() ?>'&dir=gift_file/orginal/"><i class="fa fa-download"></i><span><?php echo $translate->getString("download") ?></span></a>
                            </div>
                        </div>
                        <?php break;
                    case 2: ?>
                        <div class="item">
                            <div class="product lt-med-bg">
                                <div class="white-txt text center">
                                    <a href="/product/<?php echo $gift->getProduct()->getId()?>/<?php echo $gift->getProduct()->getName()?>"><p class="title white-txt"><?php echo $gift->getProduct()->getName()?></p></a>
                                    <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="/model/<?php echo $gift->getSenderUser()->getLogin() ?>" class="username lt-txt"><?php echo $gift->getSenderUser()->getLogin() ?></a></p>
                                    <p class="category xs-txt lt-txt"><?php echo $translate->getString("wishlistItem") ?></p>
                                    <p class="message white-txt"><?php echo $gift->getDescription(); ?></p>
                                </div>
                            </div>
                            <div class="purchase-info">
                                <p><strong><span><?php echo $translate->getString("received") ?>:</span></strong><span> <?php echo $gift->getDateCreated()->format('d-m-Y') ?></span></p>
                                <a href="download.php?action=download&file=<?php echo $gift->getProduct()->getFileName().'&nick='.$gift->getSenderUser()->getLogin() ?>'&dir=product_file/orginal/"><i class="fa fa-download"></i><span><?php echo $translate->getString("download") ?></span></a>
                            </div>
                        </div>
                        <?php break;
                    case 3: ?>
                        <div class="item">
                            <div class="product lt-med-bg">
                                <div class="white-txt text center">
                                    <a href="product.php"><p class="title white-txt"><i class="fa fa-diamond"></i><span><?php echo $gift->getTokenAmount() ?></span></p></a>
                                    <p><strong><span><?php echo $translate->getString("from") ?>: </span></strong><a href="/model/<?php echo $gift->getSenderUser()->getLogin() ?>" class="username lt-txt"><?php echo $gift->getSenderUser()->getLogin() ?></a></p>
                                    <p class="category xs-txt lt-txt"><?php echo $translate->getString("tokens") ?></p>
                                    <p class="message white-txt"><?php echo $gift->getDescription(); ?></p>
                                </div>
                            </div>
                            <div class="purchase-info">
                                <p><strong><span><?php echo $translate->getString("received") ?>:</span></strong><span> <?php echo $gift->getDateCreated()->format('d-m-Y') ?></span></p>
                            </div>
                        </div>
                        <?php break;?>
                <?php endswitch; ?>
            <?php endforeach; ?>
        </div>
    </div>
        
    <div class="part">
        <h6><?php echo $translate->getString("sentGifts"); ?></h6>
            
        <div class="wrapper">
            <?php foreach($gifts_sent->getGifts() as $gift): ?>
                <?php switch($gift->getType()): 
                    case 1: ?>
                        <div class="item">
                            <div class="product lt-med-bg">
                                <div class="white-txt text center">
                                    <p><strong><span><?php echo $translate->getString("for") ?>: </span></strong><a href="/model/<?php echo $gift->getReceivedUser()->getLogin() ?>" class="username lt-txt"><?php echo $gift->getReceivedUser()->getLogin() ?></a></p>
                                    <p class="category xs-txt lt-txt"><?php echo $translate->getString("file") ?></p>
                                    <p class="message white-txt"><?php echo $gift->getDescription(); ?></p>
                                </div>
                            </div>
                            <div class="purchase-info">
                                <p><strong><span><?php echo $translate->getString("sent") ?>:</span></strong><span> <?php echo $gift->getDateCreated()->format('d-m-Y') ?></span></p>
                                <a href="download.php?action=download&file=<?php echo $gift->getFileName().'&nick='.$gift->getSenderUser()->getLogin() ?>'&dir=gift_file/orginal/"><i class="fa fa-download"></i><span><?php echo $translate->getString("download") ?></span></a>
                            </div>
                        </div>
                        <?php break;
                    case 2: ?>
                        <div class="item">
                            <div class="product lt-med-bg">
                                <div class="white-txt text center">
                                    <a href="/product/<?php echo $gift->getProduct()->getId()?>/<?php echo $gift->getProduct()->getName()?>"><p class="title white-txt"><?php echo $gift->getProduct()->getName() ?></p></a>
                                    <p><strong><span><?php echo $translate->getString("for") ?>: </span></strong><a href="/model/<?php echo $gift->getReceivedUser()->getLogin() ?>" class="username lt-txt"><?php echo $gift->getReceivedUser()->getLogin() ?></a></p>
                                    <p class="category xs-txt lt-txt"><?php echo $translate->getString("wishlistItem") ?></p>
                                    <p class="message white-txt"><?php echo $gift->getDescription(); ?></p>
                                </div>
                            </div>
                            <div class="purchase-info">
                                <p><strong><span><?php echo $translate->getString("sent") ?>:</span></strong><span> <?php echo $gift->getDateCreated()->format('d-m-Y') ?></span></p>
                            </div>
                        </div>
                        <?php break; 
                    case 3: ?>
                        <div class="item">
                            <div class="product lt-med-bg">
                                <div class="white-txt text center">
                                    <a h-ref="#"><p class="title white-txt"><i class="fa fa-diamond"></i><span><?php echo $gift->getTokenAmount() ?></span></p></a>
                                    <p><strong><span><?php echo $translate->getString("for") ?>: </span></strong><a href="/model/<?php echo $gift->getReceivedUser()->getLogin() ?>" class="username lt-txt"><?php echo $gift->getReceivedUser()->getLogin() ?></a></p>
                                    <p class="category xs-txt lt-txt"><?php echo $translate->getString("tokens") ?></p>
                                    <p class="message white-txt"><?php echo $gift->getDescription(); ?></p>
                                </div>
                            </div>
                            <div class="purchase-info">
                                <p><strong><span><?php echo $translate->getString("sent") ?>:</span></strong><span> <?php echo $gift->getDateCreated()->format('d-m-Y') ?></span></p>
                            </div>
                        </div>
                        <?php break; ?>
                <?php endswitch; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>