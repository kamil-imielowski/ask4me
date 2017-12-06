<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="login register content section">
    
    <div class="container">
    
        <h2>Forgot your password?</h2>
        <?php include_once dirname(__FILE__).'/includes/alerts.html.php'; ?>
        
        <p class="xl-txt">Nam sodales elementum dolor non semper. Donec ac risus risus. Proin lacus nulla, bibendum aliquam nibh vel, viverra aliquam arcu. Ut eu tempus tellus. Nam sodales elementum dolor non semper</p>
        
        <form action="" method="post">
            <div class="form-group email">
                <input type="email" name="email" placeholder="E-mail address">
            </div>

            <button type="submit" class="button med-prim-bg" name="action" value="sendRequest-passChange">Reset password</button>

        </form>
        
    </div>
    
</div>
    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>