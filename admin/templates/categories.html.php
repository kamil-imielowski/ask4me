<?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
<?php include dirname(__FILE__).'/include/top_menu.html.php'; ?>

<div class="page-content">
    <div class="row">
		<?php include dirname(__FILE__).'/include/left_menu.html.php'; ?>
		<div class="col-md-10">
			<?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
			
			<h2><?php echo $translate->getString('categories')?></h2>

            <a href="categories.php?action=add" class="btn btn-success pull-right"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo $translate->getString('categoryAdd')?></a>
			
            <div class="panel-body">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center"><?php echo $translate->getString('name')?></th>
							<th class="text-center"><?php echo $translate->getString('dateCreated')?></th>
							<th class="text-center"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($categories as $category){?>
							<tr>
								<td><?php echo $category->getId();  ?></td>
								<td><?php echo $category->getCategoryInfo()->getName(); ?></td>
								<td><?php echo $category->getCreatedDate(); ?></td>
								<td>
									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php echo $translate->getString('actions')?> <span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu">
											<li><a href="categories.php?action=edit&id=<?php echo $category->getId(); ?>"><?php echo $translate->getString('edit')?></a></li>
											<li class="divider"></li>
											<li><a href="categories.php?action=delete&id=<?php echo $category->getId(); ?>"><?php echo $translate->getString('delete')?></a></li>
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