<?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
<?php include dirname(__FILE__).'/include/top_menu.html.php'; ?>

<div class="page-content">
    <div class="row">
        <?php include dirname(__FILE__).'/include/left_menu.html.php'; ?>
        <div class="col-md-10">
            <?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
            
            <h2><?php echo $translate->getString('products')?></h2>

            <div class="panel-body">
	            <table id="dataTable" class="table table-striped table-bordered">
	            	<thead>
	            		<tr>
	            			<th>ID</th>
	            			<th>Nazwa</th>
	            			<th>Cena</th>
	            			<th>Data dodania</th>
	            			<th>Sprzedano</th>
	            			<th></th>
	            		</tr>
	            	</thead>
	            	<tbody>
	            		<?php foreach($products->getProducts() as $product){?>
	            		<tr>
	            			<td><?php echo $product->getId() ?></td>
	            			<td><?php echo $product->getName() ?></td>
	            			<td><?php echo $product->getPrice() ?></td>
	            			<td><?php echo $product->getDateCreated() ?></td>
	            			<td><?php echo $product->getSolds() ?></td>
	            			<td><a href="products.php?action=delete&id=<?php echo $product->getId() ?>">Usuń</a>
	            			<?php if($product->getType() == 3){?>
	            				<a href="products.php?action=editTokens&id=<?php echo $product->getId() ?>">Edytuj</a>
	            			<?php }?>
	            			</td>
	            		</tr>
	            		<?php }?>
	            	</tbody>
	            </table>
           	</div>
        </div>
    </div>
</div>


<?php include dirname(__FILE__).'/include/footer.html.php'; ?>
<link href="vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="vendors/datatables/dataTables.bootstrap.js"></script>
<script src="js/tables.js"></script>