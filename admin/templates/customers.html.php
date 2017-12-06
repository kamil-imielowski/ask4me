<?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
<?php include dirname(__FILE__).'/include/top_menu.html.php'; ?>

<div class="page-content">
    <div class="row">
		<?php include dirname(__FILE__).'/include/left_menu.html.php'; ?>
		<div class="col-md-10">
			<?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
			
			<h2><?php echo $translate->getString('customers')?></h2>
			
            <div class="panel-body">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center"><?php echo $translate->getString('login')?></th>
							<th class="text-center"><?php echo $translate->getString('type')?></th>
							<th class="text-center"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($customers as $customer){?>
							<tr>
								<td><?php echo $customer->getId();  ?></td>
								<td><?php echo $customer->getLogin(); ?></td>
								<td><?php echo $customer->getType(); ?></td>
								<td>
									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php echo $translate->getString('actions')?> <span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu">
											<li><a href="customers.php?action=delete&id=<?php echo $customer->getId(); ?>"><?php echo $translate->getString('delete')?></a></li>
											<?php if($customer->getBanned() == 0){ ?>
												<li><a href="customers.php?action=ban&id=<?php echo $customer->getId(); ?>"><?php echo $translate->getString('ban')?></a></li>
											<?php }else{?>
												<li><a href="customers.php?action=unBan&id=<?php echo $customer->getId(); ?>"><?php echo $translate->getString('unBan')?></a></li>
											<?php }?>
										</ul>
									</div>
								</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="js/dlaPodstron/index.js"></script>
<?php include dirname(__FILE__).'/include/footer.html.php'; ?>
<link href="vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="vendors/datatables/dataTables.bootstrap.js"></script>
<script src="js/tables.js"></script>