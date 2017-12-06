<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="cms blog-entry content">
    <div class="container section">
    
        <h3><?php echo $blog->getTitle() ?></h3>
        
        <div class="cms-content">
            <?php echo $blog->getContent() ?>
        </div>
        
    </div>
</div>

    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>