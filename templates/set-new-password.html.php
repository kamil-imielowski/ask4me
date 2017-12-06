<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="login register content section">
    
    <div class="container">
    
        <h2><?php echo $translate->getString("changePassword") ?></h2>
        <?php include_once dirname(__FILE__).'/includes/alerts.html.php'; ?>
       
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
            <input type="hidden" name="control" value="<?php echo $_GET['control'] ?>" />
            <div class="form-group email">
                <input type="password" name="new_password" placeholder="<?php echo $translate->getString("password") ?>">
            </div>

            <div class="form-group email">
                <input type="password" name="r_new_password" placeholder="<?php echo $translate->getString("repassword") ?>">
            </div>

            <button type="submit" class="button med-prim-bg" name="action" value="setNewPasswordRequest"><?php echo $translate->getString("save") ?></button>

        </form>
        
    </div>
    
</div>
    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>