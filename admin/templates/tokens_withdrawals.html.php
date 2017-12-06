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
							<th class="text-center">Użytkownik (#)</th>
							<th class="text-center">Ilość tokenów</th>
							<th class="text-center">Należność</th>
							<th class="text-center">IBAN</th>
							<th class="text-center">SWIFT/BIC</th>
							<th class="text-center">Nazwa właściciela</th>
							<th class="text-center">Data utworzenia</th>
							<th>Status zobowiązania</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($withdrawals as $withdrawal){?>
							<tr>
								<td><?php echo $withdrawal->getId();  ?></td>
								<td><?php echo $withdrawal->getUser()->getLogin() . ' (' . $withdrawal->getUser()->getId() . ')'; ?></td>
								<td><?php echo $withdrawal->getTokens(); ?></td>
								<td><?php echo $withdrawal->getDolars() . '$'; ?></td>
								<td><?php echo $withdrawal->getIban(); ?></td>
								<td><?php echo $withdrawal->getSwiftBic(); ?></td>
								<td><?php echo $withdrawal->getOwnerName(); ?></td>
								<td><?php echo $withdrawal->getDateCreated()->format("d-m-Y"); ?></td>
								<td>
									<?php if($withdrawal->getPayment() == 0 ): ?>
										<a href="tokens_withdrawals.php?action=updatePayment&id=<?php echo $withdrawal->getId() ?>" class="btn btn-warning">Zapłaciłem</a>
									<?php else:?>
										<p>Opłacono</p>
									<?php endif;?>
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