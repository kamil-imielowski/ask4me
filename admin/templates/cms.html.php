<?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
<?php include dirname(__FILE__).'/include/top_menu.html.php'; 
$languages = new \classes\Languages\LanguagesFactory();
?>


<div class="page-content">
    <div class="row">
		<?php include dirname(__FILE__).'/include/left_menu.html.php'; ?>
		<div class="col-md-10">
			<?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
			
			<h2>CMS</h2>
			<div class="col-md-12">
				<ul class="nav nav-tabs">
					<?php $i=0; foreach($languages->getLanguages() as $k){?>
					<li class="<?php echo $i==0 ? 'active' : ''; ?>"><a data-toggle="tab" href="#<?php echo $k->getCode(); ?>"><?php echo $k->getName(); ?></a></li>
					<?php $i++;}?>
				</ul>

				<div class="tab-content">
					<?php $i=0; foreach($languages->getLanguages() as $k){?>
						<div id="<?php echo $k->getCode(); ?>" class="tab-pane fade <?php echo $i==0 ? 'in active' : ''; ?>">
							<h3>Treść</h3>
							<textarea form="add" name="<?php echo $k->getCode() ?>" class="ckeditor" >
							<?php 
							foreach($cms->getCms() as $v){
								if($k->getCode() == $v->getLanguageCode()){
								echo $v->getContent();
								}
							}?>
							</textarea>

						</div>
					<?php $i++;}?>
				</div>
				<form class="text-right margin-top" id="add" action="cms.php" method="post">
					<input type="hidden" name="id" value=<?php echo $_GET['id']; ?>>
					<button type="submit" form="add" name="action" value="saveContent" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $translate->getString('save')?></button>
				</form>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="js/index.js"></script>
<script src="vendors/ckeditor/ckeditor.js"></script>
<script>
	CKEDITOR.replaceClass( 'ckeditor' );
</script>

<?php include dirname(__FILE__).'/include/footer.html.php'; ?>
<link href="vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">