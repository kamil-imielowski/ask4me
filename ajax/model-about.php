<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$profileCustomer = new classes\User\ModelUser(null, $_POST['nick']);
$CF = new classes\Categories\CategoriesFactory();
$translate = new \classes\Languages\Translate();
?>
<div class="about animated fadeIn">
    <div class="part overview">
        <h6><?php echo $translate->getString("overview") ?></h6>
        <p><?php echo $profileCustomer->getOverview(); ?></p>
    </div>
    
    <div class="part languages">
        <h6><?php echo $translate->getString("languages") ?></h6>
        <ul>
            <?php if(!empty($profileCustomer->getUserLanguages())): ?>
                <?php foreach($profileCustomer->getUserLanguages() as $k){ ?>
                    <li><span><?php echo $k->getName() ?></span> - <span><?php echo $translate ->getString($k->getProficiency()->getProficiencyName()) ?></span></li>
                <?php }?>
            <?php endif; ?>
        </ul>
    </div>
    
    <div class="part categories">
        <h6><?php echo $translate->getString("categories") ?></h6>
        <ul>
            <?php foreach($CF->getCategories() as $category){?>
                <?php if(in_array($category->getId(), $profileCustomer->getCategories())){?>
                    <li><a href="#">#<?php echo $category->getCategoryInfo()->getName() ?></a></li>
                <?php }?>
            <?php }?>
        </ul>
    </div>
    
    <div class="part details">
        <h6><?php echo $translate->getString("personalDetails") ?></h6>
        <ul>
            <li><strong><?php echo $translate->getString("whatTurnsMeOn") ?>:</strong><span><?php echo $profileCustomer->getTurns() ?></span></li>
            <li><strong><?php echo $translate->getString("myExpertise") ?>:</strong><span><?php echo $profileCustomer->getExpertise() ?></span></li>
            <!-- <li><strong><?php echo $translate->getString("kinkyFeatures") ?>:</strong><span><?php ?></span></li> -->
            <li><strong><?php echo $translate->getString("partnerPreferences") ?>:</strong><span><?php echo $translate->getString($profileCustomer->getPartnerPreferences()) ?></span></li>
            <li><strong><?php echo $translate->getString("realAge"); ?>:</strong><span><?php echo $profileCustomer->getRealAge() ?></span></li>
            <li><strong><?php echo $translate->getString("looksAge") ?>:</strong><span><?php echo $profileCustomer->getLooksAge() ?></span></li>
            <li><strong><?php echo $translate->getString("height") ?>:</strong><span><?php echo $profileCustomer->getHeight() ?></span></li>
            <li><strong><?php echo $translate->getString("weight") ?>:</strong><span><?php echo $profileCustomer->getWeight() ?></span></li>
            <li><strong><?php echo $translate->getString("chestCupSize") ?>:</strong><span><?php echo $profileCustomer->getChestCupSize() ?></span></li>
            <li><strong><?php echo $translate->getString("pubicHair") ?>:</strong><span><?php echo $translate->getString($profileCustomer->getPubicHair()) ?></span></li>
            <li><strong><?php echo $translate->getString("dressSize") ?>:</strong><span><?php echo $profileCustomer->getDressSize() ?></span></li>
            <li><strong><?php echo $translate->getString("ethnicity") ?>:</strong><span><?php echo $translate->getString($profileCustomer->getEthnicity()) ?></span></li>
            <!-- <li><strong><?php echo $translate->getString("bodyComplexion") ?>:</strong><span><?php ?></span></li> -->
            <li><strong><?php echo $translate->getString("eyesColor") ?>:</strong><span><?php echo $profileCustomer->getEyesColor() ?></span></li>
            <li><strong><?php echo $translate->getString("hairColor") ?>:</strong><span><?php echo $profileCustomer->getHairColor() ?></span></li>
            <li><strong><?php echo $translate->getString("bodyBuild") ?>:</strong><span><?php echo $translate->getString($profileCustomer->getBodyBuild()) ?></span></li>
            <li><strong><?php echo $translate->getString("bodyDecoration") ?>:</strong><span><?php echo $profileCustomer->getBodyDecorations() ?></span></li>
        </ul>
    </div>
    
</div>
        


