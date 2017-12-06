<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="login register content section">
    
    <div class="container">
        
        <h2>Register</h2>
        <?php include_once dirname(__FILE__).'/includes/alerts.html.php'; ?>
        <a href="/register/model"><strong><?php echo $translate->getString("createModel"); ?></strong></a>
    
        <form method="POST" id ="register_standard" action="">
            <div class="form-group email">
                <input type="email" name="email" placeholder="<?php echo $translate->getString("email-address"); ?>" value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
            </div>
            
            <div class="form-group user">
                <input type="text" name="login" placeholder="<?php echo $translate->getString("username"); ?>" value="<?php echo isset($data['login']) ? $data['login'] : ''; ?>">
            </div>

            <div class="form-group password">
                <input type="password" name="password" placeholder="<?php echo $translate->getString("password"); ?>">
            </div>
            
            <div class="form-group password">
                <input type="password" name="re_password" placeholder="<?php echo $translate->getString("rePassword"); ?>">
            </div>
            
            <div class="form-group checkbox">
                <input type="checkbox" name="check1" id="checkbox1">
                <label for="checkbox1"></label>
                <span><?php echo $translate->getString("iAgreeTo"); ?></span> 
                <a href="terms.php" target="blank"><?php echo $translate->getString("termsAndConditions"); ?></a>
            </div>
            
            <div class="form-group checkbox">
                <input type="checkbox" name="check2" id="checkbox2">
                <label for="checkbox2">
                   <?php echo $translate->getString("checkAdult"); ?>
                </label>
            </div>

            <button
                type="submit"
                name="action"
                value="register_standard"
                form="register_standard"
                class="button med-prim-bg g-recaptcha"
                data-callback="YourOnSubmitFn">
                <?php echo $translate->getString("register"); ?>
            </button>
            <!-- data-sitekey="6Lfl0icUAAAAAE8GYsIPvK3JGhk0mqIPptpo49TI" -->
        </form>
        
    </div>
        
    </div>
    
</div>
    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>