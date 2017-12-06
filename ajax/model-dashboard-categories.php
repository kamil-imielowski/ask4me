<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$CF = new classes\Categories\CategoriesFactory();
$categories = $CF->getCategories();

$user = unserialize(base64_decode($_SESSION['user']));
$translate = new \classes\Languages\Translate();
$countries = new \classes\Country\CountriesFactory();
?>
<div class="section categories animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("categoriesAndServices"); ?></h4>
    
    <div class="form">
        
        <form method="post">
            <h6 class="dashboard-heading"><?php echo $translate->getString("chooseCategoriesYourProfile"); ?>:</h6>
        
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

            <h6 class="dashboard-heading"><?php echo $translate->getString("whatServiceAreYouProvide"); ?>?</h6>

            <div class="radios">

                <div class="form-group radio inline">
                    <input type="radio" name="service" value="1" id="radio1" <?php echo $user->getServiceProvide() == 1 ? 'checked' : ''; ?>>
                    <label for="radio1">
                        <?php echo $translate->getString("escortOnly") ?>
                    </label>
                </div>

                <div class="form-group radio inline">
                    <input type="radio" name="service" value="2" id="radio2" <?php echo $user->getServiceProvide() == 2 ? 'checked' : ''; ?>>
                    <label for="radio2">
                        <?php echo $translate->getString("webcamOnly") ?> (<?php echo $translate->getString("requiredBasicMembership") ?>)
                    </label>
                </div>

                <div class="form-group radio inline">
                    <input type="radio" name="service" value="3" id="radio3" <?php echo $user->getServiceProvide() == 3 ? 'checked' : ''; ?>>
                    <label for="radio3">
                        <?php echo $translate->getString("both") ?> (<?php echo $translate->getString("requiredBasicMembership") ?>)
                    </label>
                </div>

            </div>
            
            <div class="escort-info"><!--tylko do escort services i both-->
                <h6 class="dashboard-heading"><?php echo $translate->getString("addLocationsYourServices"); ?>:</h6>
                <div class="form-group multiple" id="location">
                    <?php if(!empty($user->getUserCountries())){foreach($user->getUserCountries() as $v){?>
                        <div class="select">
                            <select name="country[]">
                                <option value="0" selected disabled><?php echo $translate->getString('chooseCountry') ?></option>
                                <?php foreach($countries->getCountries() as $k){ ?>
                                    <option value="<?php echo $k->getIsoCode2() ?>" <?php echo $k->getIsoCode2() == $v->getIsoCode2() ? 'selected' : ''; ?>><?php echo $k->getName(); ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <input type="text" name="cityOrRegion[]" placeholder='<?php echo $translate->getString('city'); ?>' value='<?php echo $v->getCityOrRegion(); ?>'>
                    <?php }}?>
                </div>
                
                <a onclick="addLocation()" class="add-activity"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString("addAnotherLocation"); ?></span></a>
                
            </div>

            <button type="submit" name="action" value="categoriesAndServices" class="button med-prim-bg"><?php echo $translate->getString("save") ?></button>
        
        </form>
        
    </div>
</div>
<script>
    if($("input[name='service']:checked").val() == 1 || $("input[name='service']:checked").val() == 3){
        $(".escort-info").show();
    }else{
        $(".escort-info").hide();
    }
    $("input[name='service']").change(function(){
        if($(this).filter(':checked').val() == 1 || $(this).filter(':checked').val() == 3){
            $(".escort-info").show();
        }else{
            $(".escort-info").hide();
        }
    });
    function addLocation(){
        var select = "<div class='select'>"+
                        "<select name='country[]'>"+
                            "<option value='0' selected disabled><?php echo $translate->getString('chooseCountry') ?></option>"+
                            "<?php foreach($countries->getCountries() as $k){ ?>"+
                                "<option value='<?php echo $k->getIsoCode2() ?>'><?php echo $k->getName(); ?></option>"+
                            "<?php }?>"+
                         "</select>"+
                    "</div>";

        var input = "<input type='text' name='cityOrRegion[]' placeholder='<?php echo $translate->getString('city'); ?>'>"

       $("#location").append(select + input);
    }
</script>
		

