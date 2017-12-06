<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="login register model content section">
    
    <div class="container">
    
        <h2><?php echo $translate->getString("register"); ?></h2>
        
        <a href="/register"><strong><?php echo $translate->getString("createRegular"); ?></strong></a>
        <?php include_once dirname(__FILE__).'/includes/alerts.html.php'; ?>
        <form action="/register.php" method="post" id="register_model">
            <div class="form-group user">
                <input type="text" name="name" placeholder="<?php echo $translate->getString("firstName"); ?>" required <?php if(isset($data['name'])){?>value="<?php echo $data['name'] ?>"<?php }?>>
            </div>
            
            <div class="form-group user">
                <input type="text" name="surname" placeholder="<?php echo $translate->getString("lastName"); ?>" required <?php if(isset($data['surname'])){?>value="<?php echo $data['surname'] ?>"<?php }?>>
            </div>
            
            <div class="form-group user">
                <input type="text" name="login" placeholder="<?php echo $translate->getString("username"); ?>" required <?php if(isset($data['login'])){?>value="<?php echo $data['login'] ?>"<?php }?>>
            </div>
            
            <div class="form-group email">
                <input type="email" name="email" placeholder="<?php echo $translate->getString("email-address"); ?>" required <?php if(isset($data['email'])){?>value="<?php echo $data['email'] ?>"<?php }?>>
            </div>

            <div class="form-group password">
                <input type="password" name="password" placeholder="<?php echo $translate->getString("password"); ?>" required>
            </div>
            
            <div class="form-group password">
                <input type="password" name="re_password" placeholder="<?php echo $translate->getString("rePassword"); ?>" required>
            </div>
            
            <div class="form-group select">
                <select name="sex">
                    <option value="0" disabled selected><?php echo $translate->getString("gender"); ?></option>
                    <option value="1" <?php if(isset($data['sex']) && $data['sex'] == 1){echo "selected";} ?>><?php echo $translate->getString("woman"); ?></option>
                    <option value="2" <?php if(isset($data['sex']) && $data['sex'] == 2){echo "selected";} ?>><?php echo $translate->getString("man"); ?></option>
                    <option value="3" <?php if(isset($data['sex']) && $data['sex'] == 3){echo "selected";} ?>><?php echo $translate->getString("transgender"); ?></option>
                </select>
                </div>

                <div class="form-group select">
                    <select name="country">
                        <option value="0" disabled selected><?php echo $translate->getString("country"); ?></option>
                        <?php foreach($countries as $country){?>
                            <option value="<?php echo $country->getIsoCode2() ?>" <?php if(isset($data['country']) && $data['country'] == $country->getIsoCode2()){echo "selected";} ?>><?php echo $country->getName() ?></option>
                        <?php }?>
                    </select>
                </div>

                <div class="center">
                    <label><?php echo $translate->getString("howDidYouHear"); ?></label>

                <div class="form-group select">
                    <select name="hear">
                        <option value="1" <?php if(isset($data['hear']) && $data['hear'] == 1){echo "selected";} ?>><?php echo $translate->getString("searchEngineAd"); ?></option>
                        <option value="2" <?php if(isset($data['hear']) && $data['hear'] == 2){echo "selected";} ?>><?php echo $translate->getString("searchEngineResults"); ?></option>
                        <option value="3" <?php if(isset($data['hear']) && $data['hear'] == 3){echo "selected";} ?>><?php echo $translate->getString("friend"); ?></option>
                        <option value="4" <?php if(isset($data['hear']) && $data['hear'] == 4){echo "selected";} ?>><?php echo $translate->getString("blogOrForum"); ?></option>
                        <option value="5" <?php if(isset($data['hear']) && $data['hear'] == 5){echo "selected";} ?>><?php echo $translate->getString("newspaperOrMagazine"); ?></option>
                        <option value="6" <?php if(isset($data['hear']) && $data['hear'] == 6){echo "selected";} ?>><?php echo $translate->getString("eventOrConference"); ?></option>
                        <option value="7" <?php if(isset($data['hear']) && $data['hear'] == 7){echo "selected";} ?>><?php echo $translate->getString("radio"); ?></option>
                        <option value="8" <?php if(isset($data['hear']) && $data['hear'] == 8){echo "selected";} ?>><?php echo $translate->getString("television"); ?></option>
                        <option value="9" <?php if(isset($data['hear']) && $data['hear'] == 9){echo "selected";} ?>><?php echo $translate->getString("other"); ?></option>
                    </select>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox1" name="terms" required>
                    <label for="checkbox1"></label>
                    <span><?php echo $translate->getString("registerModelCheck1-1"); ?> </span> 
                    <a href="terms.php" target="blank"><?php echo $translate->getString("thermsAndService"); ?></a>
                    <span>, <?php echo $translate->getString("includingThe"); ?> </span>
                    <a href="agreement.php" target="blank"><?php echo $translate->getString("userAgreement"); ?></a>
                    <span><?php echo $translate->getString("and"); ?></span>
                    <a href="privacy-policy.php" target="blank"><?php echo $translate->getString("privacyPolicy"); ?></a>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="checkbox2" name="notify-mails">
                    <label for="checkbox2">
                        <?php echo $translate->getString("registerModelCheck2"); ?>
                    </label>
                </div>

                <button
                    type="submit"
                    name="action"
                    value="register_model"
                    form="register_model"
                    class="button med-prim-bg g-recaptcha"
                    data-callback="YourOnSubmitFn">
                    <?php echo $translate->getString("register"); ?>
                </button>
                <!-- data-sitekey="6Lfl0icUAAAAAE8GYsIPvK3JGhk0mqIPptpo49TI" -->
            </div>

        </form>
        
    </div>
    
</div>
    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>