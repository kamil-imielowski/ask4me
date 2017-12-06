<div class="left">
    
    <div class="box dashboard-model">
        <h6><?php echo $translate->getString("dashboard") ?></h6>
        <div class="inside">
            <div class="menu" id="accordion" role="tablist" aria-multiselectable="true">
                <ul class="vertical">
                    <li class="nav-tab active"><a h-ref="#" onClick="tab('home', this);" id="dbm-home"><?php echo $translate->getString("home") ?></a></li>
                    <li class="nav-tab" role="tab" id="profile-heading">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#profile-content" aria-expanded="true" aria-controls="profile-content">
                          <span><?php echo $translate->getString("profile") ?></span><i class="fa fa-angle-down"></i>
                        </a>
                    </li>
                    <div id="profile-content" class="panel-collapse collapse" role="tabpanel" aria-labelledby="profile-heading">
                      <ul>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('categories', this);" id="dbm-categories"><?php echo $translate->getString("categoriesAndServices") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('media', this);" id="dbm-media"><?php echo $translate->getString("socialMedia") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('introduction', this);" id="dbm-introduction"><?php echo $translate->getString("introduceYourself") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('looks', this);" id="dbm-looks"><?php echo $translate->getString("looks") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('gallery', this);" id="dbm-gallery"><?php echo $translate->getString("addPhotosAndVideos") ?></a></li>
                      </ul>
                    </div>
                    <li class="nav-tab" role="tab" id="account-heading">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#account-content" aria-expanded="true" aria-controls="account-content">
                          <span><?php echo $translate->getString("account") ?></span><i class="fa fa-angle-down"></i>
                        </a>
                    </li>
                    <div id="account-content" class="panel-collapse collapse" role="tabpanel" aria-labelledby="account-heading">
                      <ul>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('account-settings', this);" id="dbm-account-settings"><?php echo $translate->getString("accountSettings") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('get-paid', this);" id="dbm-get-paid"><?php echo $translate->getString("getPaid") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('membership', this);" id="dbm-membership"><?php echo $translate->getString("membershipAndEarnings") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('notification-settings', this);" id="dbm-notification-settings"><?php echo $translate->getString("notificationSettings") ?></a></li>
                      </ul>
                    </div>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('followers', this);" id="dbm-followers"><?php echo $translate->getString("followers") ?></a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('following', this);" id="dbm-following"><?php echo $translate->getString("following") ?></a></li>
                    <li class="nav-tab" role="tab" id="activity-heading">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#activity-content" aria-expanded="true" aria-controls="activity-content">
                          <span><?php echo $translate->getString("activity") ?></span><i class="fa fa-angle-down"></i>
                        </a>
                    </li>
                    <div id="activity-content" class="panel-collapse collapse" role="tabpanel" aria-labelledby="activity-heading">
                      <ul>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('planned', this);" id="dbm-planned"><?php echo $translate->getString("plannedActivities") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('availability', this);" id="dbm-availability"><?php echo $translate->getString("availabilitySettings") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('pricing', this);" id="dbm-pricing"><?php echo $translate->getString("priceTables") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('start', this);" id="dbm-start"><?php echo $translate->getString("startAnActivity") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('requests', this);" id="dbm-requests"><?php echo $translate->getString("requests") ?></a></li>
                      </ul>
                    </div>
                    <!--
                    <li class="nav-tab"><a h-ref="#" onClick="tab('bots', this);" id="dbm-bots">Chat bots</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('raports', this);" id="dbm-raports">Raports</a></li>
                    -->
                    <li class="nav-tab"><a h-ref="#" onClick="tab('store', this);" id="dbm-store"><?php echo $translate->getString("store") ?></a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('blog', this);" id="dbm-blog"><?php echo $translate->getString("blog") ?></a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('purchases', this);" id="dbm-purchases"><?php echo $translate->getString("purchases") ?></a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('gifts', this);" id="dbm-gifts"><?php echo $translate->getString("gifts") ?></a></li>
                </ul>
            </div>
            <div class="buttons">
                <a h-ref="#" onClick="tab('code', this);" class="button med-prim-bg"><?php echo $translate->getString("enterCode") ?></a>
            </div>
        </div>
    </div>
    
    <div class="box dashboard-user">
        <h6><?php echo $translate->getString("dashboard") ?></h6>
        <div class="inside">
            <div class="menu">
                <ul class="vertical">
                    <li class="nav-tab"><a h-ref="#" onClick="tab('home', this);" id="dbu-home">Home</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('profile', this);" id="dbu-profile">Profile page</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('account-settings', this);" id="dbu-account-settings">Account settings</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('notification-settings', this);" id="dbu-notification-settings">Notification settings</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('membership', this);" id="dbu-membership">Membership and tokens</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('following', this);" id="dbu-following">Following</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('followers', this);" id="dbu-followers">Followers</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('activities', this);" id="dbu-activities">Activities</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('requests', this);" id="dbu-requests">Requests</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('raports', this);" id="dbu-raports">Raports</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('purchases', this);" id="dbu-purchases">My purchases</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('gifts', this);" id="dbu-gifts">Gifts</a></li>
                    <li class="nav-tab"><a h-ref="#" onClick="tab('screenshots', this);" id="dbu-screenshots">My saved screenshots</a></li>
                </ul>
            </div>
            <div class="buttons">
                <a href="store.php" class="button med-prim-bg"><i class="fa fa-diamond"></i><span>Buy tokens</span></a>
                <a href="store.php" class="button med-prim-bg">Upgrade membership</a>
                <a href="profile-creation.php" class="button med-prim-bg">Become a model</a>
            </div>
        </div>
    </div>
    
    <div class="box your-profile">
        <h6>Create your profile</h6>
        <div class="inside">
            <ul class="vertical">
                <li class="nav-tab"><a h-ref="#" onClick="tab('categories', this);">Categories and services</a></li>
                <li class="nav-tab"><a h-ref="#" onClick="tab('media', this);">Social media</a></li>
                <li class="nav-tab"><a h-ref="#" onClick="tab('introduction', this);">Introduce yourself</a></li>
                <li class="nav-tab"><a h-ref="#" onClick="tab('looks', this);">Looks</a></li>
                <li class="nav-tab"><a h-ref="#" onClick="tab('pricing', this);">Price tables</a></li>
                <li class="nav-tab"><a h-ref="#" onClick="tab('age', this);">Age confirmation</a></li>
            </ul>
        </div>
    </div>
    
</div>