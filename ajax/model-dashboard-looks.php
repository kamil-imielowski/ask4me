<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$translate = new \classes\Languages\Translate($_COOKIE['lang']);
?>
<div class="section looks animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("looks"); ?></h4>
    
    <div class="form">
        
        <form method="post">
            
            <div class="columns">
                <div class="form-group">
                    <label><?php echo $translate->getString("realAge"); ?>:</label>
                    <input type="number" name="real_age" placeholder="<?php echo $translate->getString("enterRealAge"); ?>" value="<?php echo $user->getRealAge(); ?>">
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("looksAge"); ?>:</label>
                    <div class="select">
                        <select name="looks_age">
                            <option value="0" disabled><?php echo $translate->getString("looksAge"); ?></option>
                            <option value="18-20" <?php echo $user->getLooksAge() == "18-20" ? 'selected' : '';?>>18-20</option>
                            <option value="20-25" <?php echo $user->getLooksAge() == "20-25" ? 'selected' : '';?>>20-25</option>
                            <option value="25-30" <?php echo $user->getLooksAge() == "25-30" ? 'selected' : '';?>>25-30</option>
                            <option value="30+" <?php echo $user->getLooksAge() == "30+" ? 'selected' : '';?>>30+</option>
                            <option value="40+" <?php echo $user->getLooksAge() == "40+" ? 'selected' : '';?>>40+</option>
                            <option value="50+" <?php echo $user->getLooksAge() == "50+" ? 'selected' : '';?>>50+</option>
                            <option value="60+" <?php echo $user->getLooksAge() == "60+" ? 'selected' : '';?>>60+</option>
                            <option value="70+" <?php echo $user->getLooksAge() == "70+" ? 'selected' : '';?>>70+</option>
                         </select>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("height"); ?>:</label>
                    <input name="height" type="number" placeholder="<?php echo $translate->getString("enterHeight"); ?>" value="<?php echo $user->getHeight(); ?>">
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("weight"); ?>:</label>
                    <input type="number" name="weight" placeholder="<?php echo $translate->getString("enterWeight"); ?>" value="<?php echo $user->getWeight(); ?>">
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("chestCupSize"); ?>:</label>
                    <input type="text" name="chest_cup_size" placeholder="<?php echo $translate->getString("enterChestCupSize"); ?>" value="<?php echo $user->getChestCupSize(); ?>">
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("pubicHair"); ?>:</label>
                    <div class="select">
                        <select name="pubic_hair">
                            <option value="0" disabled><?php echo $translate->getString("pubicHair"); ?></option>
                            <option value="yes" <?php echo $user->getPubicHair() == "yes" ? 'selected' : '';?>><?php echo $translate->getString("yes"); ?></option>
                            <option value="no" <?php echo $user->getPubicHair() == "no" ? 'selected' : '';?>><?php echo $translate->getString("no"); ?></option>
                         </select>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("dressSize"); ?>:</label>
                    <div class="select">
                        <select name="dress_size">
                            <option value="0" disabled><?php echo $translate->getString("dressSize"); ?></option>
                            <option value="0-4" <?php echo $user->getDressSize() == "0-4" ? 'selected' : '';?>>0-4</option>
                            <option value="6" <?php echo $user->getDressSize() == "6" ? 'selected' : '';?>>6</option>
                            <option value="8" <?php echo $user->getDressSize() == "8" ? 'selected' : '';?>>8</option>
                            <option value="10" <?php echo $user->getDressSize() == "10" ? 'selected' : '';?>>10</option>
                            <option value="12" <?php echo $user->getDressSize() == "12" ? 'selected' : '';?>>12</option>
                            <option value="14" <?php echo $user->getDressSize() == "14" ? 'selected' : '';?>>14</option>
                            <option value="16" <?php echo $user->getDressSize() == "16" ? 'selected' : '';?>>16</option>
                            <option value="16 + BBW" <?php echo $user->getDressSize() == "16 + BBW" ? 'selected' : '';?>>16 + BBW</option>
                         </select>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("ethnicity"); ?>:</label>
                    <div class="select">
                        <select name="ethnicity">
                            <option value="0" disabled><?php echo $translate->getString("ethnicity"); ?></option>
                            <option value="ethnicity_asian" <?php echo $user->getEthnicity() == "ethnicity_asian" ? 'selected' : '';?>><?php echo $translate->getString("ethnicity_asian"); ?></option>
                            <option value="ethnicity_black" <?php echo $user->getEthnicity() == "ethnicity_black" ? 'selected' : '';?>><?php echo $translate->getString("ethnicity_black"); ?></option>
                            <option value="ethnicity_latina" <?php echo $user->getEthnicity() == "ethnicity_latina" ? 'selected' : '';?>><?php echo $translate->getString("ethnicity_latina"); ?></option>
                            <option value="ethnicity_middleEastern" <?php echo $user->getEthnicity() == "ethnicity_middleEastern" ? 'selected' : '';?>><?php echo $translate->getString("ethnicity_middleEastern"); ?></option>
                            <option value="ethnicity_white" <?php echo $user->getEthnicity() == "ethnicity_white" ? 'selected' : '';?>><?php echo $translate->getString("ethnicity_white"); ?></option>
                            <option value="ethnicity_mixedRace" <?php echo $user->getEthnicity() == "ethnicity_mixedRace" ? 'selected' : '';?>><?php echo $translate->getString("ethnicity_mixedRace"); ?></option>
                         </select>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("skinColor"); ?>:</label>
                    <div class="select">
                        <select name="skin_color">
                            <option value="0" disabled><?php echo $translate->getString("skinColor"); ?></option>
                            <option value="yellow" <?php echo $user->getSkinColor() == 'yellow' ? 'selected' : '';?>>Yellow</option>
                            <option value="white" <?php echo $user->getSkinColor() == 'white' ? 'selected' : '';?>>White</option>
                         </select>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("eyesColor"); ?>:</label>
                    <div class="select">
                        <select name="eyes_color">
                            <option value="0" disabled><?php echo $translate->getString("eyesColor"); ?></option>
                            <option value="green" <?php echo $user->getEyesColor() == 'green' ? 'selected' : '';?>>Green</option>
                            <option value="brown" <?php echo $user->getEyesColor() == 'brown' ? 'selected' : '';?>>Brown</option>
                         </select>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("hairColor"); ?>:</label>
                    <div class="select">
                        <select name="hair_color">
                            <option value="0" disabled><?php echo $translate->getString("hairColor"); ?></option>
                            <option value="black" <?php echo $user->getHairColor() == 'black' ? 'selected' : '';?>>Black</option>
                            <option value="brown" <?php echo $user->getHairColor() == 'brown' ? 'selected' : '';?>>Brown</option>
                         </select>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("bodyBuild"); ?>:</label>
                    <div class="select">
                        <select name="body_build">
                            <option value="0" disabled><?php echo $translate->getString("bodyBuild"); ?></option>
                            <option value="bodyBuild_slim" <?php echo $user->getBodyBuild() == "bodyBuild_slim" ? 'selected' : '';?>><?php echo $translate->getString("bodyBuild_slim") ?></option>
                            <option value="bodyBuild_athletic" <?php echo $user->getBodyBuild() == "bodyBuild_athletic" ? 'selected' : '';?>><?php echo $translate->getString("bodyBuild_athletic") ?></option>
                            <option value="bodyBuild_healthy" <?php echo $user->getBodyBuild() == "bodyBuild_healthy" ? 'selected' : '';?>><?php echo $translate->getString("bodyBuild_healthy") ?></option>
                            <option value="bodyBuild_veryHealthy" <?php echo $user->getBodyBuild() == "bodyBuild_veryHealthy" ? 'selected' : '';?>><?php echo $translate->getString("bodyBuild_veryHealthy") ?></option>
                         </select>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("bodyDecorations"); ?>:</label>
                    <input type="text" name="body_decorations" placeholder="<?php echo $translate->getString("bodyDecorations"); ?>" value="<?php echo $user->getBodyDecorations(); ?>">
                </div>
            </div>
            <button name="action" value="saveLooks" type="submit" class="button med-prim-bg"><?php echo $translate->getString("save"); ?></button>
        </form>
        
    </div>
</div>	

<script type="text/javascript" src="js/fileinput.min.js"></script>
