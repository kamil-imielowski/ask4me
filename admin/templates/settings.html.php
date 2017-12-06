<?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
<?php include dirname(__FILE__).'/include/top_menu.html.php'; ?>

<div class="page-content">
    <div class="row">
        <?php include dirname(__FILE__).'/include/left_menu.html.php'; ?>
        <div class="col-md-10">
            <?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
            
            <h2><?php echo $translate->getString('settings')?></h2>
            <div class="content-box-large col-md-12">
            	<div class="col-md-3">
	            	<label>Cena za 1 token przy wypłacie pieniędzy</label>
	            	<input type="number" name="price_for_token" class="form-control" value="<?php echo $settings->getPriceForToken() ?>">
	            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/admin/js/settings.js"></script>
<script type="text/javascript">
	$("input[name='price_for_token']").on("keyup", function(){
		saveAdminSettings('price_for_token', $("input[name='price_for_token']").val());
	});
</script>
<?php include dirname(__FILE__).'/include/footer.html.php'; ?>
