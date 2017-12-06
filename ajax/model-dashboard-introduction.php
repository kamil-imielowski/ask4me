<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$translate = new \classes\Languages\Translate();
$languages = new \classes\Languages\LanguagesFactory();
?>
<div class="section introduction animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("basicInformation"); ?></h4>
    
    <div class="form">
        
        <form action="" method="post" id="introduction" enctype="multipart/form-data">
            
            <div class="profile-photo">
                <h6 class="dashboard-heading"><?php echo $translate->getString("profilePhoto"); ?>:</h6>   
                <div class="wrapper">
                    <div class="preview" style="background:url(<?php echo $user->getProfilePicture()->getSRCThumbImage() ?>) no-repeat center center;"></div>
                    <div class="form-group">
                        <input id="upload-avatar" type="file" name="profile" accept="image/*" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
                        <p><span><strong><?php echo $translate->getString("recommendedSize"); ?>: </strong></span><span>200px x 200px</span></p>
                        <p><span><strong><?php echo $translate->getString("recommendedFormat"); ?>: </strong></span><span>.jpg</span></p>
                    </div>
                </div>
            </div>
            
            <div class="cover">
                <h6 class="dashboard-heading">Cover photo:</h6>   
                <div class="wrapper">
                    <div class="preview" style="background:url(<?php echo $user->getCoverPhoto()->getSRCThumbImage() ?>) no-repeat center center;"></div>
                    <div class="form-group full">
                        <input id="upload-cover" type="file" name="cover" accept="image/*" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
                        <p><span><strong><?php echo $translate->getString("recommendedSize"); ?>: </strong></span><span>855px x 220px</span></p>
                        <p><span><strong><?php echo $translate->getString("recommendedFormat"); ?>: </strong></span><span>.jpg</span></p>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label><?php echo $translate->getString("tagLine"); ?>:</label>
                <input type="text" value="<?php echo $user->getTagLine(); ?>" name="tag_line" placeholder="<?php echo $translate->getString("enterTagLine"); ?>">
            </div>
            
            <div class="form-group">
                <label><?php echo $translate->getString("overview"); ?></label>
                <textarea name="overview" placeholder="<?php echo $translate->getString("enterDescription"); ?>"><?php echo $user->getOverview(); ?></textarea>
            </div>
            
            <div class="form-group">
                <label><?php echo $translate->getString("whatTurnsMeOn"); ?>:</label>
                <input type="text" name="turns" value="<?php echo $user->getTurns(); ?>" placeholder="<?php echo $translate->getString("enterTurns"); ?>">
            </div>
            
            <div class="form-group">
                <label><?php echo $translate->getString("myExpertise"); ?>:</label>
                <input type="text" name="expertise" value="<?php echo $user->getExpertise(); ?>" placeholder="<?php echo $translate->getString("describeExpertise"); ?>">
            </div>
            
            <div class="form-group">
                <label><?php echo $translate->getString("partnerPreferences"); ?>:</label>
                <div class="select">
                    <select name="partner_preferences">
                        <option value="0" selected disabled><?php echo $translate->getString("partnerPreferences"); ?></option>
                        <option value="solo" <?php echo $user->getPartnerPreferences() == "solo" ? 'selected' : ''; ?>><?php echo $translate->getString("solo"); ?></option>
                        <option value="girl-girl" <?php echo $user->getPartnerPreferences() == "girl-girl" ? 'selected' : ''; ?>><?php echo $translate->getString("girl-girl"); ?></option>
                        <option value="boy-girl" <?php echo $user->getPartnerPreferences() == "boy-girl" ? 'selected' : ''; ?>><?php echo $translate->getString("boy-girl"); ?></option>
                        <option value="boy-girl-girl" <?php echo $user->getPartnerPreferences() == "boy-girl-girl" ? 'selected' : ''; ?>><?php echo $translate->getString("boy-girl-girl"); ?></option>
                        <option value="boy-boy-girl" <?php echo $user->getPartnerPreferences() == "boy-boy-girl" ? 'selected' : ''; ?>><?php echo $translate->getString("boy-boy-girl"); ?></option>
                        <option value="fetish" <?php echo $user->getPartnerPreferences() == "fetish" ? 'selected' : ''; ?>><?php echo $translate->getString("fetish"); ?></option>
                        <option value="girl-transgender" <?php echo $user->getPartnerPreferences() == "girl-transgender" ? 'selected' : ''; ?>><?php echo $translate->getString("girl-transgender"); ?></option>
                     </select>
                </div>
            </div>
            
            <div class="form-group">
                <label><?php echo $translate->getString("englishProficiency"); ?>:</label>
                <div class="select">
                    <select name="english_proficiency">
                        <option value="0" selected disabled><?php echo $translate->getString("englishProficiency"); ?></option>
                        <option value="1" <?php echo $user->getEnglishProficiency() == 1 ? 'selected' : ''; ?>><?php echo $translate->getString("basic"); ?></option>
                        <option value="2" <?php echo $user->getEnglishProficiency() == 2 ? 'selected' : ''; ?>><?php echo $translate->getString("conversational"); ?></option>
                        <option value="3" <?php echo $user->getEnglishProficiency() == 3 ? 'selected' : ''; ?>><?php echo $translate->getString("fluent"); ?></option>
                        <option value="4" <?php echo $user->getEnglishProficiency() == 4 ? 'selected' : ''; ?>><?php echo $translate->getString("nativeOrBilingual"); ?></option>
                     </select>
                </div>
            </div>
            
            <div class="form-group multiple">
                <h6 class="dashboard-heading"><?php echo $translate->getString("addLanguages"); ?>:</h6>
                <?php if(!empty($user->getUserLanguages())){foreach($user->getUserLanguages() as $v){ ?>
                    <div class="select">
                        <select name="language[]">
                            <option value="0" selected disabled><?php echo $translate->getString("chooseLanguage") ?></option>
                            <?php foreach($languages->getLanguages() as $k){ ?>
                                <option value="<?php echo $k->getCode(); ?>"<?php echo $v->getCode() == $k->getCode() ? 'selected' : ''; ?> ><?php echo $k->getName(); ?></option>
                            <?php }?>
                        </select>
                    </div>
                    
                    <div class="select">
                        <select name="proficiency[]">
                            <option value="0" selected disabled><?php echo $translate->getString("languageProficiency"); ?></option>
                            <option value="1" <?php echo $v->getProficiency()->getProficiencyId() == 1 ? 'selected' : ''; ?>><?php echo $translate->getString("basic"); ?></option>
                            <option value="2" <?php echo $v->getProficiency()->getProficiencyId() == 2 ? 'selected' : ''; ?>><?php echo $translate->getString("conversational"); ?></option>
                            <option value="3" <?php echo $v->getProficiency()->getProficiencyId() == 3 ? 'selected' : ''; ?>><?php echo $translate->getString("fluent"); ?></option>
                            <option value="4" <?php echo $v->getProficiency()->getProficiencyId() == 4 ? 'selected' : ''; ?>><?php echo $translate->getString("nativeOrBilingual"); ?></option>
                        </select>
                    </div>
                <?php }}else{?>
                    <div class="select">
                        <select name="language[]">
                            <option value="0" selected disabled><?php echo $translate->getString("chooseLanguage") ?></option>
                            <?php foreach($languages->getLanguages() as $k){ ?>
                                <option value="<?php echo $k->getCode(); ?>"><?php echo $k->getName(); ?></option>
                            <?php }?>
                        </select>
                    </div>
                        
                    <div class="select">
                        <select name="proficiency[]">
                            <option value="0" selected disabled><?php echo $translate->getString("languageProficiency"); ?></option>
                            <option value="1"><?php echo $translate->getString("basic"); ?></option>
                            <option value="2"><?php echo $translate->getString("conversational"); ?></option>
                            <option value="3"><?php echo $translate->getString("fluent"); ?></option>
                            <option value="4"><?php echo $translate->getString("nativeOrBilingual"); ?></option>
                        </select>
                    </div>
                <?php }?>
                
                <a id="a-language" onclick="addLanguage()" class="add-activity"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString("addAnotherLocation"); ?></span></a>
                
            </div>

            <button type="submit" class="button med-prim-bg" form="introduction" name="action" value="introduction"><?php echo $translate->getString("save"); ?></button>
        
        </form>
        
    </div>
</div>	

<script type="text/javascript" src="js/fileinput.min.js"></script>
<script>
    function addLanguage(){
        var select = "<div class='select language_select'>"+
                        "<select name='language[]'>"+
                            "<option value='0' selected disabled><?php echo $translate->getString('chooseLanguage') ?></option>"+
                            "<?php foreach($languages->getLanguages() as $k){ ?>"+
                                "<option value='<?php echo $k->getCode(); ?>'><?php echo $k->getName(); ?></option>"+
                            "<?php }?>"+
                        "</select>"+
                    "</div>";
        var select2 = "<div class='select'>"+
                        "<select name='proficiency[]'>"+
                            "<option value='0' selected disabled><?php echo $translate->getString('languageProficiency'); ?></option>"+
                            "<option value='1'><?php echo $translate->getString('basic'); ?></option>"+
                            "<option value='2'><?php echo $translate->getString('conversational'); ?></option>"+
                            "<option value='3'><?php echo $translate->getString('fluent'); ?></option>"+
                            "<option value='4'><?php echo $translate->getString('nativeOrBilingual'); ?></option>"+
                        "</select>"+
                    "</div>";
        $('#a-language').before(select);
        $('#a-language').before(select2);
    }
</script>
