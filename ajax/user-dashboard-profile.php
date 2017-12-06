<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$CF = new classes\Categories\CategoriesFactory();
$categories = $CF->getCategories();

$user = unserialize(base64_decode($_SESSION['user']));
?>
<div class="section introduction animated fadeIn">
    <h4 class="dashboard-heading">Profile page</h4>
    
    <div class="form">
        
        <form action="" method="post" id="profile_page_form" enctype="multipart/form-data">
            
            <div class="profile-photo">
                <h6 class="dashboard-heading">Profile photo:</h6>   
                <div class="wrapper">
                    <div class="preview" style="background:url(<?php echo $user->getProfilePicture()->getSRCThumbImage() ?>) no-repeat center center;"></div>
                    <div class="form-group">
                        <input id="upload-avatar" type="file" class="file" name="profile" accept="image/*" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
                        <p><span><strong>Recommended size: </strong></span><span>200px x 200px</span></p>
                        <p><span><strong>Recommended format: </strong></span><span>.jpg</span></p>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Overview</label>
                <textarea name="overview" placeholder="Enter your profile description"><?php echo $user->getOverview() ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Gender:</label>
                <div class="select">
                    <select name="sex">
                        <option value="0" selected disabled>Choose your gender</option>
                        <option value="1" <?php if($user->getSex() == 1){echo "selected";} ?>>Man</option>
                        <option value="2" <?php if($user->getSex() == 2){echo "selected";} ?>>Woman</option>
                        <option value="3" <?php if($user->getSex() == 3){echo "selected";} ?>>Transgender</option>
                     </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Looking for:</label>
                <div class="select">
                    <select name="looking_for">
                        <option value="0" selected disabled>Choose preferred partner's gender</option>
                        <option value="1" <?php if($user->getLookingFor() == 1){echo "selected";} ?>>Man</option>
                        <option value="2" <?php if($user->getLookingFor() == 2){echo "selected";} ?>>Woman</option>
                        <option value="3" <?php if($user->getLookingFor() == 3){echo "selected";} ?>>Transgender</option>
                     </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Services:</label>
                <div class="select">
                    <select name="services">
                        <option value="0" selected disabled>Choose services</option>
                        <option value="1" <?php if($user->getServices() == 1){echo "selected";} ?>>Web</option>
                        <option value="2" <?php if($user->getServices() == 2){echo "selected";} ?>>In person</option>
                        <option value="3" <?php if($user->getServices() == 3){echo "selected";} ?>>Both</option>
                     </select>
                </div>
            </div>
            
            <div class="part">
                <h6 class="dashboard-heading">Choose categories you are interested in:</h6>
        
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
                <h6 class="dashboard-heading">Profile visivbility</h6>

                <div class="radios">

                    <div class="form-group radio inline">
                        <input type="radio" name="profile_visibility" value="1" id="radio1" checked <?php if($user->getProfileVisibility() == 1){ echo "checked";} ?>>
                        <label for="radio1">
                            Public
                        </label>
                    </div>

                    <div class="form-group radio inline">
                        <input type="radio" name="profile_visibility" value="2" id="radio2" <?php if($user->getProfileVisibility() == 2){ echo "checked";} ?>>
                        <label for="radio2">
                            Private (required membership)
                        </label>
                    </div>

                </div>
            </div>

            <button type="submit" class="button med-prim-bg" form="profile_page_form" name="action" value="profile_page_form">Save</button>
        
        </form>
        
    </div>
</div>	

<script type="text/javascript" src="js/fileinput.min.js"></script>
