<?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
<?php include dirname(__FILE__).'/include/top_menu.html.php'; ?>

<div class="page-content">
    <div class="row">
		<?php include dirname(__FILE__).'/include/left_menu.html.php'; ?>
		<div class="col-md-10">
			<?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
			
			<h2><?php echo $translate->getString('dashboard') ?></h2>
			
			<div class="col-md-12 content-box-large">
				<div id="chart_div"><img src="images/loader.gif" class="img-responsive center-block"/></div>
			</div>
			
		</div>
	</div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="js/index.js"></script>
<?php include dirname(__FILE__).'/include/footer.html.php'; ?>
<link href="vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">