<div class="col-md-2">
	<div class="sidebar content-box" style="display: block;">
        <ul class="nav">
            <li <?php if(isset($indexPage) && $indexPage){ ?>class="current"<?php }?>>
            	<a href="index.php"><i class="glyphicon glyphicon-home"></i> <?php echo $translate->getString('dashboard') ?></a>
            </li>							
            <li class="submenu <?php if(isset($productsPage) && $productsPage){ ?>current<?php }?>">
            	<a h-ref="#">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i></i><?php echo $translate->getString("store") ?>
					<span class="caret pull-right"></span>
				</a>
				<ul>
					<li><a href="products.php"><?php echo $translate->getString("products") ?></a></li>
				</ul>
				<ul>
					<li><a href="products.php?action=membership"><?php echo $translate->getString("membership") ?></a></li>
				</ul>
				<ul>
					<li><a href="products.php?action=tokens"><?php echo $translate->getString("addTokens") ?></a></li>
				</ul>
            </li>
            <!--
            <li <?php if(isset($discountCodesPage) && $discountCodesPage){ ?>class="current"<?php }?>>
            	<a href="discount_codes.php"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> <?php echo $translate->getString('discountCodes') ?></a>
            </li>
            -->
            <li <?php if(isset($categoriesPage) && $categoriesPage){ ?>class="current"<?php }?>><a href="categories.php">
            	<i class="fa fa-tags" aria-hidden="true"></i> <?php echo $translate->getString('categories') ?></a>
            </li>								
            <li <?php if(isset($customersPage) && $customersPage){ ?>class="current"<?php }?>><a href="customers.php">
            	<i class="fa fa-users" aria-hidden="true"></i> <?php echo $translate->getString('customers') ?></a>
            </li>
            <li <?php if(isset($tokensWithdrawsPage) && $tokensWithdrawsPage){ ?>class="current"<?php }?>><a href="tokens_withdrawals.php">
            	<i class="fa fa-money" aria-hidden="true"></i> Wypłaty za tokeny</a>
            </li>	

			<li class="submenu <?php if(isset($cmsPage) && $cmsPage){ ?>current<?php }?>">
				<a h-ref="#">
					<i class="fa fa-pencil" aria-hidden="true"></i>CMS
					<span class="caret pull-right"></span>
				</a>
				<ul>
					<li <?php if(isset($FAQ) && $FAQ){ ?>class="current"<?php }?>><a href="cms.php?action=editContent&id=1">FAQ</a></li>
					<li <?php if(isset($About) && $About){ ?>class="current"<?php }?>><a href="cms.php?action=editContent&id=2">About</a></li>
					<li><a href="cms.php?action=editContent&id=3">Partnership</a></li>
					<li><a href="cms.php?action=editContent&id=4">Terms and Conditions</a></li>
					<li><a href="cms.php?action=editContent&id=5">User agreement</a></li>
					<li><a href="cms.php?action=editContent&id=6">Privacy policy</a></li>
					<li><a href="cms.php?action=editContent&id=7">Copyrights</a></li>
				</ul>
			</li>							
			<li class="submenu <?php if(isset($settingsPage) && $settingsPage){ ?>current<?php }?>">
				<a h-ref="#">
					<i class="fa fa-cog" aria-hidden="true"></i> <?php echo $translate->getString('settings') ?>
					<span class="caret pull-right"></span>
				</a>
				<ul>
					<li <?php if(isset($socialMediaPage) && $socialMediaPage){ ?>class="current"<?php }?>><a href="social-media.php"><?php echo $translate->getString('socialMedia') ?></a></li>
				</ul>
				<ul>
					<li <?php if(isset($generalSettingsPage) && $generalSettingsPage){ ?>class="current"<?php }?>><a href="settings.php"><?php echo $translate->getString('general') ?></a></li>
				</ul>
			</li>	 				
			
        </ul>
    </div>
</div>