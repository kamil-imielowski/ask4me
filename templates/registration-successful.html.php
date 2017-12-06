<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="login register content section">
    
    <div class="container">
    
        <h2>Registration successful</h2>
        
        <p class="xl-txt">Nam sodales elementum dolor non semper. Donec ac risus risus. Proin lacus nulla, bibendum aliquam nibh vel, viverra aliquam arcu. Ut eu tempus tellus. Nam sodales elementum dolor non semper</p>
        
        <a href="register.php?action=resendFromLogin&login=<?php echo $_GET['login']; ?>" class="button empty med-prim-br">Resend verification link</a>
        
    </div>
    
</div>
    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>