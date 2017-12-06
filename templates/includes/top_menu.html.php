<?php 
if(!isset($user) && isset($_SESSION['user'])){
    $user = unserialize(base64_decode($_SESSION['user']));
}
if(isset($user)){
    $notifications = new \classes\Notification\NotificationsFactory($user->getId());
    $messages = new \classes\Message\UsersConversations($user);
    $newMessages = $messages->getCountUnreadedMessages();
}
?>
<div id="top" class="row top" id="top-menu">
    <div class="preheader hidden-xs">
        <div class="container">
            <div class="right">
                <?php if(isset($_SESSION['user'])){ ?>
                    <a id="messages" href="/messages.php" data-toggle="tooltip" data-placement="bottom" title="<?php echo $translate->getString("newMessages");?>"><i class="fa fa-envelope"></i><span><?php echo $newMessages; ?></span></a><!--tylko zalogowany-->
                    <a id="notifications" href="/dashboard-user" data-toggle="tooltip" data-placement="bottom" title="<?php echo $translate->getString("notifications");?>"><i class="fa fa-bell"></i><span><?php echo $user->getUnreadedNotification(); ?></span></a><!--tylko zalogowany-->
                    <!--<a id="invites" href="/invites.php" data-toggle="tooltip" data-placement="bottom" title="<?php //echo $translate->getString("invites");?>"><i class="fa fa-user-circle"></i><span>1</span></a>tylko zalogowany-->
                    <a id="tokens" href="/store" data-toggle="tooltip" data-placement="bottom" title="<?php echo $translate->getString("tokens");?>"><i class="fa fa-diamond"></i><span class="tokens__container"><?php echo $user->getTokens() ?></span></a><!--tylko zalogowany-->
                    <a href="/login.php?action=logout"><i class="fa fa-sign-out"></i><span><?php echo $translate->getString("signOut");?></span></a><!--tylko zalogowany-->
                    <a href="/cart"><i class="fa fa-shopping-cart"></i><span><?php echo $translate->getString("cart");?> (<?php echo isset($_COOKIE['cart']) ? count(unserialize(base64_decode($_COOKIE['cart']))) : 0; ?>)</span></a>
                <?php }?>
                <?php if(!isset($_SESSION['user'])){ ?><a href="/login"><i class="fa fa-sign-in"></i><span><?php echo $translate->getString("signIn");?></span></a><?php }?><!--tylko niezalogowany-->
                <?php if(!isset($_SESSION['user'])){ ?><a href="/register"><i class='material-icons'>person_add</i><span><?php echo $translate->getString("register");?></span></a><?php }?><!--tylko niezalogowany-->
                <?php include_once dirname(dirname(dirname(__FILE__))).'/language/langSelect.html.php'; ?>
            </div>
        </div>      
    </div>
    
    <div class="main">
        <div class="container">
            <div class="logo">
                <a href="/home">
                    <img src="/img/logo-menu.png" alt="logo" title="logo" />
                </a>
            </div>
            
            <div class="menu">
                <nav class="navbar navbar-default">	
                    
                    <a class="button dark-prim-bg hidden" id="showRightPush"><span class="animated fadeIn"></span></a>
                    <div class="navbar-collapse hidden-xs" id="main-menu">

                        <ul class="nav navbar-nav">
                            <?php if(isset($_SESSION['user'])){ ?>
                            <li>
                                <?php if($user->getType() == 1){ ?>
                                    <a href="/dashboard-user"><?php echo $translate->getString("dashboard");?></a>
                                <?php }elseif($user->getType() == 2){?>
                                    <a href="/dashboard-model"><?php echo $translate->getString("dashboard");?></a>
                                <?php }?>
                            </li>
                            <?php }?>
                            <li>
                                <a href="/live-cams"><?php echo $translate->getString("liveCams");?></a>
                            </li>
                            <li>
                                <a href="/escort"><?php echo $translate->getString("escort");?></a>
                            </li>  
                            <li>
                                <a href="/contest"><?php echo $translate->getString("contest");?></a>
                            </li>  
                            <li>
                                <a href="/store"><?php echo $translate->getString("store");?></a>
                            </li> 
                        </ul>
                        <div id="sb-search" class="sb-search hidden-xs">
                            <form action="search.php" method="post">
                                <input class="sb-search-input animated fadeIn" placeholder="Search..." type="text" value="" name="search" id="search">
                                <input class="sb-search-submit" type="submit" value="search" name="action">
                                <span class="sb-icon-search"></span>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    
</div>

<!-- menu mobilne-->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
    <div class="top">
       <h3>
          <span>Menu</span>
          <div id="sb-search2" class="sb-search">
            <form action="search.php" method="post">
                <input class="sb-search-input" placeholder="Search..." type="text" value="" name="search" id="search">
                <input class="sb-search-submit" type="submit" value="search" name="action">
                <span class="sb-icon-search"></span>
            </form>
          </div>
      </h3>
      <ul>
        <li class="uppercase"><a href="/dashboard-model"><?php echo $translate->getString("dashboard");?></a></li><!--tylko zalogowany, jezeli zalogowany jest user to plik dashboard-user.php-->
        <li class="uppercase"><a href="/live-cams"><?php echo $translate->getString("liveCams");?></a></li>
        <li class="uppercase"><a href="/escort"><?php echo $translate->getString("escort");?></a></li>  
        <li class="uppercase"><a href="/contest"><?php echo $translate->getString("contest");?></a></li>  
        <?php if(isset($user)){?>
        <li class="uppercase inline">
            <a href="/store">Store</a>
            <a id="tokens" href="/store"><i class="fa fa-diamond"></i><span class="tokens__container"><?php echo $user->getTokens() ?></span></a><!--tylko zalogowany - ilość diamentów-->
        </li>
        
        <li><a href="/cart"><i class="fa fa-shopping-cart"></i><span><?php echo $translate->getString("cart");?> (<?php echo isset($_COOKIE['cart']) ? count(unserialize(base64_decode($_COOKIE['cart']))) : 0; ?>)</span></a></li>
        <?php }?>
        <li class="inline">
            <?php if(isset($_SESSION['user'])): ?>
            <a id="messages" href="/messages.php"><i class="fa fa-envelope"></i><span><?php echo $newMessages; ?></span></a><!--tylko zalogowany-->
            <a id="notifications" href="/dashboard-user"><i class="fa fa-bell"></i><span><?php echo $user->getUnreadedNotification(); ?></span></a><!--tylko zalogowany-->
            <!--<a id="invites" href="/invites.php"><i class="fa fa-user-circle"></i><span>1</span></a>tylko zalogowany-->
            <?php endif; ?>
        </li>
        <li class="lang-change">
            <?php include dirname(dirname(dirname(__FILE__))).'/language/langSelect.html.php'; ?>	
        </li>
      </ul>
    </div>
  
    <div class="bottom">
        <a href="/login.php" class="button med-prim-bg"><i class="fa fa-sign-in"></i><span><?php echo $translate->getString("signIn");?></span></a><!--tylko niezalogowany-->
        <a href="/register.php" class="button med-prim-bg"><i class='material-icons'>person_add</i><span><?php echo $translate->getString("register");?></span></a><!--tylko niezalogowany-->
        <a href="#" class="button med-prim-bg"><i class="fa fa-sign-out"></i><span><?php echo $translate->getString("signOut");?></span></a><!--tylko zalogowany-->
      </div>
</nav><!-- koniec -->

<div class="small-chats">
    <div class="inside" id="content-chats">
    
    </div>
</div>

<?php if(isset($user)):?>
<div style="display: none;">
    <?php foreach($notifications->getNotificationsAll() as $notification):  $userType = $notification->getUser()->getType() == 1 ? 'user' : 'model'; ?>
        <div>
            <?php switch($notification->getType()): 

                case '1': //gift ?>
                    <span>You've received a new gift from</span>
                    <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin() ?></strong></a>
                <?php break; ?>

                <?php case '2': //new activity ?>
                    <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin(); ?></strong></a>
                    <span>has planned a new</span>
                    <span><strong>activity</strong></span>
                <?php break;?>

                <?php case '3': //new blog ?>
                    <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin(); ?></strong></a>
                    <span>has added a new</span>
                    <span><strong>blog entry</strong></span>
                <?php break; ?>

                <?php case '4': //new photo?>
                    <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin(); ?></strong></a>
                    <span>has added a new</span>
                    <span><strong>photo</strong></span>
                <?php break;?>

                <?php case '5': //new product?>
                    <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin(); ?></strong></a>
                    <span>has added a new</span>
                    <span><strong><?php echo $notification->getProduct()->getName(); ?></strong></span>
                    <span>to her shop</span>
                <?php break;?>

                <?php case '6': //someone bought?>
                    <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin() ?></strong></a>
                    <span>has bought</span>
                    <a href="/product/<?php echo $notification->getProduct()->getId() . '/' . $notification->getProduct()->getURLName() ?>"><strong><?php echo $notification->getProduct()->getName() ?></strong></a>
                    <span class="lt-prim-txt"><strong><span>+</span><i class="fa fa-diamond"></i><span><?php echo $notification->getProduct()->getPrice() ?></span></strong></span>
                <?php break; ?>

                <?php case '7': //new message ?>
                    <span>You've got a new message from</span>
                    <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin() ?></strong></a>
                <?php break; ?>

                <?php case '8': //new followers ?>
                    <a href="/<?php echo $userType . '/' . $notification->getUser()->getLogin() ?>"><strong><?php echo $notification->getUser()->getLogin() ?></strong></a>
                    <span><?php echo $translate->getString("startedfollowingY") ?></span>
                <?php break; ?>

            <?php endswitch; ?>
        </div>
    <?php endforeach;?>
</div>
<?php endif; ?>

<script src="/js/uisearch.js"></script>
<script>
    new UISearch( document.getElementById( 'sb-search' ) );
    new UISearch( document.getElementById( 'sb-search2' ) );
</script>