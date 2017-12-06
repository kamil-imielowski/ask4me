<div class="header">
	<div class="container">
	    <div class="row">
	        <div class="col-md-5">
	            <!-- Logo -->
	            <div class="logo">
	                <h1><a href="index.php"><?php $translate->getString('adminPanel') ?></a></h1>
	            </div>
	        </div>

			<div class="col-md-3">

	        </div>
			
	        <div class="col-md-2">
	           <?php include_once dirname(dirname(dirname(dirname(__FILE__)))).'/language/langSelect.html.php'; ?>
	        </div>
			
	        <div class="col-md-2">
	            <div class="navbar navbar-inverse" role="banner">
	                <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
	                    <ul class="nav navbar-nav">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $translate->getString('myAccount') ?> <b class="caret"></b></a>
								<ul class="dropdown-menu animated fadeInUp">
									<li><a href="profile.php"><?php echo $translate->getString('profile') ?></a></li>
									<li><a href="login.php?action=logout"><?php echo $translate->getString('logOut') ?></a></li>
								</ul>
							</li>
	                    </ul>
	                </nav>
	            </div>
	        </div>
	    </div>
	</div>
</div>