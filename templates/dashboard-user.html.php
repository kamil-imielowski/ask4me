<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="dashboard user content has-sidebar">
    
    <div class="container">
    
        <div class="sidebar">
            <?php include_once dirname(__FILE__).'/includes/sidebar-left.html.php';?>
        </div>
        
        <div class="main">
			<?php include_once dirname(__FILE__).'/includes/alerts.html.php'; ?>
            <div id="content" class="dashboard-data"></div>
        </div>

    </div>
    
    <?php include_once dirname(__FILE__).'/includes/modals.html.php';?>
    
</div>
<script src="/js/cookies.js"></script>
<script src="/js/page-scripts/dashboard-user.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src='/js/moment.js'></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>