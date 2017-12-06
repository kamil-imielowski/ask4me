<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();
$user = unserialize(base64_decode($_SESSION['user']));
?>
<div class="section account-settings animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("accountSettings") ?></h4>
    
    <div class="form">
        
        <form action="" method="post" id="userD-AccSet">
            <div class="part">
                <h6><?php echo $translate->getString('changeEmail') ?></h6>   
            
                <div class="form-group">
                    <label><?php echo $translate->getString('newEmail') ?>:</label>
                    <input type="email" name="email" placeholder="<?php echo $translate->getString('newEmail') ?>">
                </div>
            </div>
            
            <div class="part">
                <h6><?php echo $translate->getString('changePassword') ?></h6>   
                <div class="form-group">
                    <label><?php echo $translate->getString('currentPass') ?>:</label>
                    <input type="password" name="password" placeholder="<?php echo $translate->getString('currentPass') ?>">
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString('newPass') ?>:</label>
                    <input type="password" name="npass" placeholder="<?php echo $translate->getString('newPass') ?>">
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString('rNewPass') ?>:</label>
                    <input type="password" name="rnpass" placeholder="<?php echo $translate->getString('rNewPass') ?>">
                </div>
            </div>
            
            <a href="#" class="add-activity" data-toggle="modal" data-target="#delete-account"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteYAcc') ?></span></a>

            <button type="submit" name="action" form="userD-AccSet" value="changeUserAccSettings" class="button med-prim-bg"><?php echo $translate->getString('save') ?></button>
        
        </form>
        
    </div>
</div>
