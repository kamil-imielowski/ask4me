<?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
<?php include dirname(__FILE__).'/include/top_menu.html.php'; ?>

<div class="page-content">
    <div class="row">
		<?php include dirname(__FILE__).'/include/left_menu.html.php'; ?>
		<div class="col-md-10">
			<?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
			
			<h2><?php echo $admin->getName()?></h2>

			<div class="col-md-12 content-box-large">
                <h4><?php echo $translate->getString('passChange') ?></h4>
                <form method="POST" action="" id="passChange">
                    <div class="form-group"> 
                        <label><?php echo $translate->getString('currentPass') ?></label>
                        <input type="password" name="cpass" class="form-control" required>
                    </div>
                    <div class="form-group"> 
                        <label><?php echo $translate->getString('newPass') ?></label>
                        <input type="password" name="npass" class="form-control" required>
                    </div>
                    <div class="form-group"> 
                        <label><?php echo $translate->getString('rNewPass') ?></label>
                        <input type="password" name="rpass" class="form-control" required>
                    </div>
                    <div class="form-group"> 
                        <button type="submit" form="passChange" name="action" value="passChange" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $translate->getString('save') ?></button>
                    </div>
                </form>
            </div>

		</div>
	</div>
</div>

<?php include dirname(__FILE__).'/include/footer.html.php'; ?>