<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="login content section">
    
    <div class="container">
        <h2><?php echo $translate->getString("signIn"); ?></h2>
        <?php include_once dirname(__FILE__).'/includes/alerts.html.php'; ?>
        <form method="POST">
            <input type="hidden" name="action" value="login">
            <div class="form-group email">
                <input type="email" name="email" placeholder="<?php echo $translate->getString("email-address"); ?>">
            </div>

            <div class="form-group password">
                <input type="password" name="password" placeholder="<?php echo $translate->getString("password"); ?>">
            </div>

            <div class="form-group checkbox">
                <input type="checkbox" id="checkbox1">
                <label for="checkbox1">
                    <?php echo $translate->getString("rememberMe"); ?>
                </label>
            </div>

            <input type="submit" name="forgot" class="button med-prim-bg" value="<?php echo $translate->getString("signIn"); ?>">
            <a href="forgotten-password.php"><?php echo $translate->getString("forgotPassword"); ?></a>

        </form>
        
    </div>
    
</div>

    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>