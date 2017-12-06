<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$profileCustomer = new classes\User\ModelUser(null, $_POST['nick']);
$profileCustomer->loadBlogs();

$translate = new \classes\Languages\Translate();
?>

<div class="blog animated fadeIn">

    <?php foreach($profileCustomer->getBlogs() as $blog){ ?>            
        <div class="item lt-med-bg white-txt">
            <div class="photo" style="background:url(<?php echo $blog->getPhoto()->getSRCThumbImage(); ?>) no-repeat center center"></div>
            <div class="text">
                <h6><a href="/blog/<?php echo $blog->getId()?>/<?php echo $blog->getURLTitle()?>"><?php echo $blog->getTitle(); ?></a></h6>
                <p class="xs-txt date"><?php echo $blog->getDateCreated(); ?></p>
                <p><span><?php echo substr($blog->getContent(), 0, 500) ?>...</span> <a href="/blog/<?php echo $blog->getId()?>/<?php echo $blog->getURLTitle()?>"><strong><span><?php echo $translate->getString("readMore") ?></span></strong></a></p>
            </div>
        </div>
    <?php }?>
    
</div>
