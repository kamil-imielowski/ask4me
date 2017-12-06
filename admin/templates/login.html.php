 <?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
	
	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-10">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="index.html"><?php echo $translate->getString('adminPanel') ?></a></h1>
	              </div>
	           </div>
			   <?php include_once dirname(dirname(dirname(__FILE__))).'/language/langSelect.html.php'; ?>
	        </div>
	     </div>
	</div>

	<div class="page-content container">
		<div class="row">
			<?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
			        <div class="box">
			            <div class="content-wrap">
			                <h6><?php echo $translate->getString('logIn') ?></h6>
			                <form method="post" action="">
								<input class="form-control" name="login" type="text" placeholder="<?php echo $translate->getString('email') ?>">
								<input class="form-control" name="password" type="password" placeholder="<?php echo $translate->getString('password') ?>">
								<div class="action">
									<button class="btn btn-primary signup" name="action" value="login" type="submit" ><?php echo $translate->getString('logIn') ?></button>
								</div>   
							</form>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>
	