<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="store cart order-completed content">
    <div class="container section center">
		<?php include_once dirname(__FILE__).'/includes/alerts.html.php';?>
        <h3>Order completed</h3>
        
        <p class="xl-txt">You have succesfully completed your order.</p>
        
        <a href="dashboard-model.php?action=purchases" class="button empty med-prim-br">View your purchases</a>
    </div>   
</div>

    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>