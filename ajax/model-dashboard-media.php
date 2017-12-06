<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$user->loadSocialMedia();
$translate = new \classes\Languages\Translate();
?>
<div class="section social-media animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("socialMedia"); ?></h4>
    
    <div class="form">
        
        <form method="post">
            <h6 class="dashboard-heading"><?php echo $translate->getString("addLinkToYourSocialMedia") ?>:</h6>
            
            <div class="form-group">
                <label><i class="fa fa-facebook"></i><span>Facebook</span></label>
                <input type="text" name="facebook" placeholder="Enter facebook url" value="<?php echo $user->getSocialMedia()->getFacebook(); ?>">
            </div>
            
            <div class="form-group">
                <label><i class="fa fa-google-plus"></i><span>Google+</span></label>
                <input type="text" name="googlePlus" placeholder="Enter google+ url" value="<?php echo $user->getSocialMedia()->getGooglePlus(); ?>">
            </div>
            
            <div class="form-group">
                <label><i class="fa fa-twitter"></i><span>Twitter</span></label>
                <input type="text" name="twitter" placeholder="Enter twitter url" value="<?php echo $user->getSocialMedia()->getTwitter(); ?>">
            </div>
            
            <div class="form-group">
                <label><i class="fa fa-instagram"></i><span>Instagram</span></label>
                <input type="text" name="instagram" placeholder="Enter instagram url" value="<?php echo $user->getSocialMedia()->getInstagram(); ?>">
            </div>
            
            <div class="form-group">
                <label><i class="fa fa-snapchat"></i><span>Snapchat</span></label>
                <input type="text" name="snapchat" placeholder="Enter snapchat url" value="<?php echo $user->getSocialMedia()->getSnapchat(); ?>">
            </div>
            
            <div class="form-group">
                <label><i class="fa fa-pinterest"></i><span>pinterest</span></label>
                <input type="text" name="pinterest" placeholder="Enter pinterest url" value="<?php echo $user->getSocialMedia()->getPinterest(); ?>">
            </div>
            
            <div class="form-group">
                <label><i class="fa fa-linkedin"></i><span>Linkedin</span></label>
                <input type="text" name="linkedin" placeholder="Enter linkedin url" value="<?php echo $user->getSocialMedia()->getLinkedin(); ?>">
            </div>

            <button name="action" value="socialMedia" type="submit" class="button med-prim-bg"><?php echo $translate->getString("save") ?></button>
        
        </form>
        
    </div>
</div>
		

