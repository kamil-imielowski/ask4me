<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$CF = new classes\Categories\CategoriesFactory();
$categories = $CF->getCategories();

$translate = new \classes\Languages\Translate();

$user = unserialize(base64_decode($_SESSION['user']));
?>
<div class="section introduction animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("profilePage") ?></h4>
    
    <div class="form">
        
        <form action="" method="post" id="profile_page_form" enctype="multipart/form-data">
            
            <div class="profile-photo">
                <h6 class="dashboard-heading"><?php echo $translate->getString("profilePhoto") ?>:</h6>   
                <div class="wrapper">
                    <div class="preview" style="background:url(<?php echo $user->getProfilePicture()->getSRCThumbImage() ?>) no-repeat center center;"></div>
                    <div class="form-group">
                        <input id="upload-avatar" type="file" class="file" name="profile" accept="image/*" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
                        <p><span><strong><?php echo $translate->getString("recommendedSize") ?>: </strong></span><span>200px x 200px</span></p>
                        <p><span><strong><?php echo $translate->getString("recommendedFormat") ?>: </strong></span><span>.jpg</span></p>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label><?php echo $translate->getString("overview")?></label>
                <textarea name="overview" placeholder="Enter your profile description"><?php echo $user->getOverview() ?></textarea>
            </div>
            
            <div class="form-group">
                <label><?php echo $translate->getString("gender")?>:</label>
                <div class="select">
                    <select name="sex" required>
                        <option value="" selected disabled><?php echo $translate->getString("chooseYourGender") ?></option>
                        <option value="1" <?php if($user->getSex() == 1){echo "selected";} ?>><?php echo $translate->getString("man") ?></option>
                        <option value="2" <?php if($user->getSex() == 2){echo "selected";} ?>><?php echo $translate->getString("woman") ?></option>
                        <option value="3" <?php if($user->getSex() == 3){echo "selected";} ?>><?php echo $translate->getString("transgender") ?></option>
                     </select>
                </div>
            </div>
            
            <div class="form-group">
                <label><?php echo $translate->getString("lookingFor")?>:</label>
                <div class="select">
                    <select name="looking_for" required>
                        <option value="" selected disabled><?php echo $translate->getString('choosePreferredPartnergender') ?></option>
                        <option value="1" <?php if($user->getLookingFor() == 1){echo "selected";} ?>><?php echo $translate->getString("man") ?></option>
                        <option value="2" <?php if($user->getLookingFor() == 2){echo "selected";} ?>><?php echo $translate->getString("woman") ?></option>
                        <option value="3" <?php if($user->getLookingFor() == 3){echo "selected";} ?>><?php echo $translate->getString("transgender") ?></option>
                     </select>
                </div>
            </div>
            
            <div class="form-group">
                <label><?php echo $translate->getString("services") ?>:</label>
                <div class="select">
                    <select name="services">
                        <option value="0" selected disabled><?php echo $translate->getString("chooseServices") ?></option>
                        <option value="1" <?php if($user->getServices() == 1){echo "selected";} ?>><?php echo $translate->getString("web") ?></option>
                        <option value="2" <?php if($user->getServices() == 2){echo "selected";} ?>><?php echo $translate->getString("Tactivity-person") ?></option>
                        <option value="3" <?php if($user->getServices() == 3){echo "selected";} ?>><?php echo $translate->getString("both") ?></option>
                     </select>
                </div>
            </div>
            
            <div class="part">
                <h6 class="dashboard-heading"><?php echo $translate->getString("ChooseCategoriesYouAreInterestedIn") ?>:</h6>
        
                <div class="columns">
                    <?php foreach($categories as $category){?>
                        <div class="form-group checkbox">
                            <input type="checkbox" id="checkbox<?php echo $category->getId() ?>" name="categories[]" value="<?php echo $category->getId() ?>" <?php if(in_array($category->getId(), $user->getCategories())){echo "checked";} ?>>
                            <label for="checkbox<?php echo $category->getId() ?>">
                                <?php echo $category->getCategoryInfo()->getName() ?>
                            </label>
                        </div>
                    <?php }?>
                </div>

            </div>
            
            <div class="part">
                <h6 class="dashboard-heading"><?php echo $translate->getString("ProfileVisivbility") ?></h6>

                <div class="radios">

                    <div class="form-group radio inline">
                        <input type="radio" name="profile_visibility" value="1" id="radio1" checked <?php if($user->getProfileVisibility() == 1){ echo "checked";} ?>>
                        <label for="radio1">
                            <?php echo $translate->getString("public"); ?>
                        </label>
                    </div>

                    <div class="form-group radio inline">
                        <input type="radio" name="profile_visibility" value="2" id="radio2" <?php if($user->getProfileVisibility() == 2){ echo "checked";} ?>>
                        <label for="radio2">
                            <?php echo $translate->getString("PrivateRequiredMembership") ?>
                        </label>
                    </div>

                </div>
            </div>

            <button type="submit" class="button med-prim-bg" form="profile_page_form" name="action" value="profile_page_form">Save</button>
        
        </form>
        
    </div>
</div>	

<script type="text/javascript" src="js/fileinput.min.js"></script>
