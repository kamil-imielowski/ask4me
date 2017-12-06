<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';
$translate = new classes\Languages\Translate();
$user = unserialize(base64_decode($_SESSION['user']));
$user->loadInvoiceData();
$CF = new classes\Country\CountriesFactory();
$countries = $CF->getCountries();
?>
<div class="section membership animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString('membershipAndErnings') ?></h4>
    
    <div class="form">
        
        <form action="" method="post" id="invoiceDataForm">
            
            <div class="part">
                <h6><?php echo $translate->getString('currentBalance') ?></h6>   
                <span><i class="fa fa-diamond"></i><span><?php echo $user->getTokens() ?> - </span></span><a href="store.php"><span><?php echo $translate->getString('buyMoreTokens') ?></span></a>
            </div>
            
            <div class="part">
                <h6><?php echo $translate->getString('currentMemberShipPlan') ?></h6>   
                <span><span><?php echo $user->getMembership()->getStringType() ?> <?php echo $user->getMembership()->getValidTo() ?> - </span></span><a href="#" data-toggle="modal" data-target="#membership"><span><?php echo $translate->getString('change') ?></span></a>
            </div>
            
            <div class="part">
                <h6>Invoice data</h6>   
                <div class="columns">
                    
                    <div class="form-group">
                        <label><?php echo $translate->getString('companyName') ?>:</label>
                        <input type="text" name="company_name" value="<?php echo $user->getInvoiceData()->getCompanyName() ?>">
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString('firstName') ?>:</label>
                        <input type="text" name="first_name" value="<?php echo $user->getInvoiceData()->getFirstName() ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><?php echo $translate->getString('lastName') ?>:</label>
                        <input type="text" name="last_name" value="<?php echo $user->getInvoiceData()->getLastName() ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><?php echo $translate->getString('address') ?>:</label>
                        <input type="text" name="address" value="<?php echo $user->getInvoiceData()->getAddress() ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><?php echo $translate->getString('city') ?>:</label>
                        <input type="text" name="city" value="<?php echo $user->getInvoiceData()->getCity() ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><?php echo $translate->getString('postalCode') ?>:</label>
                        <input type="text" name="postal_code" value="<?php echo $user->getInvoiceData()->getPostalCode() ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><?php echo $translate->getString('country') ?>:</label>
                        <div class="select">
                            <select name="country">
                                <option value="0" selected disabled><?php echo $translate->getString('selectCountry') ?></option>
                                <?php foreach($countries as $country){?>
                                    <option value="<?php echo $country->getIsoCode2() ?>" <?php if(!empty($user->getInvoiceData()->getCountry()) && $user->getInvoiceData()->getCountry()->getIsoCode2() == $country->getIsoCode2()){echo "selected";} ?>><?php echo $country->getName() ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    
                </div>
            </div>

            <button type="submit" name="action" form="invoiceDataForm" value="invoiceDataForm" class="button med-prim-bg"><?php echo $translate->getString('save') ?></button>
        
        </form>
        
    </div>
</div>	

