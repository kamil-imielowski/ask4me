<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();
$user = unserialize(base64_decode($_SESSION['user']));
$user->loadNotificationSettings();
?>
<div class="section notifications animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString('notificationsSettings') ?></h4>
    
    <div class="form">
        
        <form action="" method="post" id="userNotiSET">
            
            <div class="part">
                <h6><?php echo $translate->getString('notifications') ?></h6>   
                
                <h6 class="dashboard-heading"><?php echo $translate->getString('receiveNotAb') ?>:</h6>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox1" name="npw" <?php if($user->getNotificationSettings()->getPrivateMessage() == 1){echo "checked";} ?>>
                    <label for="checkbox1">
                        <?php echo $translate->getString('np_npm') ?>
                    </label>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox2" name="nr" <?php if($user->getNotificationSettings()->getRequest() == 1){echo "checked";} ?>>
                    <label for="checkbox2">
                        <?php echo $translate->getString('np_nr') ?>
                    </label>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox3" name="nf" <?php if($user->getNotificationSettings()->getFollowers() == 1){echo "checked";} ?>>
                    <label for="checkbox3">
                        <?php echo $translate->getString('np_nf') ?>
                    </label>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox4" name="ng" <?php if($user->getNotificationSettings()->getGift() == 1){echo "checked";} ?>>
                    <label for="checkbox4">
                        <?php echo $translate->getString('np_ng') ?>
                    </label>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox5" name="sp" <?php if($user->getNotificationSettings()->getSoldProduct() == 1){echo "checked";} ?>>
                    <label for="checkbox5">
                        <?php echo $translate->getString('np_sp') ?>
                    </label>
                </div>
                
                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox6" name="afuif" <?php if($user->getNotificationSettings()->getFollowingActivity() == 1){echo "checked";} ?>>
                    <label for="checkbox6">
                        <?php echo $translate->getString('np_afuif') ?>
                    </label>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox7" name="rmataihp" <?php if($user->getNotificationSettings()->getPlannedActivity() == 1){echo "checked";} ?>>
                    <label for="checkbox7">
                        <?php echo $translate->getString('np_rmataihp') ?>
                    </label>
                </div>
                
                <h6 class="dashboard-heading"><?php echo $translate->getString('np_sound') ?></h6>

                <div class="radios">
                    <div class="form-group radio inline">
                        <input type="radio" name="sound" value="1" id="radio1" <?php if($user->getNotificationSettings()->getSound() == 1){echo "checked";} ?>>
                        <label for="radio1">
                            <?php echo $translate->getString('yes') ?>
                        </label>
                    </div>

                    <div class="form-group radio inline">
                        <input type="radio" name="sound" value="0" id="radio2" <?php if($user->getNotificationSettings()->getSound() == 0){echo "checked";} ?>>
                        <label for="radio2">
                            <?php echo $translate->getString('no') ?>
                        </label>
                    </div>
                </div>
                
            </div>
            
            <div class="part">
                <h6><?php echo $translate->getString('Email_notifications') ?></h6>   
                
                <h6 class="dashboard-heading"><?php echo $translate->getString('receiveEmialNotAb') ?>:</h6>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox8" name="enpm" <?php if($user->getNotificationSettings()->getPrivateMessageEmail() == 1){echo "checked";} ?>>
                    <label for="checkbox8">
                    <?php echo $translate->getString('np_npm') ?>
                    </label>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox9" name="enr" <?php if($user->getNotificationSettings()->getRequestEmail() == 1){echo "checked";} ?>>
                    <label for="checkbox9">
                        <?php echo $translate->getString('np_nr') ?>
                    </label>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox10" name="enf" <?php if($user->getNotificationSettings()->getFollowersEmail() == 1){echo "checked";} ?>>
                    <label for="checkbox10">
                        <?php echo $translate->getString('np_nf') ?>
                    </label>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox11" name="eng" <?php if($user->getNotificationSettings()->getGiftEmail() == 1){echo "checked";} ?>>
                    <label for="checkbox11">
                        <?php echo $translate->getString('np_ng') ?>
                    </label>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox12" name="esp" <?php if($user->getNotificationSettings()->getSoldProductEmail() == 1){echo "checked";} ?>>
                    <label for="checkbox12">
                        <?php echo $translate->getString('np_sp') ?>
                    </label>
                </div>
                
                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox13" name="eafuif" <?php if($user->getNotificationSettings()->getFollowingActivityEmail() == 1){echo "checked";} ?>>
                    <label for="checkbox13">
                        <?php echo $translate->getString('np_afuif') ?>
                    </label>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox14" name="ermataihp" <?php if($user->getNotificationSettings()->getPlannedActivityEmail() == 1){echo "checked";} ?>>
                    <label for="checkbox14">
                        <?php echo $translate->getString('np_rmataihp') ?>
                    </label>
                </div>
                
            </div>

            <button type="submit" name="action" form="userNotiSET" value="notifySettings" class="button med-prim-bg"><?php echo $translate->getString('save') ?></button>
        
        </form>
        
    </div>
</div>	

