<?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
<?php include dirname(__FILE__).'/include/top_menu.html.php'; ?>

<div class="page-content">
    <div class="row">
        <?php include dirname(__FILE__).'/include/left_menu.html.php'; ?>
        <div class="col-md-10">
            <?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
            
            <h2><?php echo $translate->getString('addTokens')?></h2>
            
            <form method="POST" action="products.php" id="add" enctype="multipart/form-data">

                <div class="col-md-4 margin-padding-none">
                    <label>Dodaj nową ofertę tokenów</label>
                    <input type="text" name="name" placeholder="Nazwa" required class="form-control margin-bottom" >
                    <textarea class="form-control margin-bottom" name="description" placeholder="Opis"></textarea>
                    <input type="number" name="tokens" class="form-control margin-bottom" placeholder="Ilość tokenów" value="" required>
                    <input type="number" name="price" class="form-control margin-bottom" placeholder="Cena ($)" value="" required>
                    <label>Zdjęcie</label>
                    <input class="margin-bottom" type="file" name="img">
                </div>
                <div class="form-group col-md-12 margin-padding-none"> 
                    <button type="submit" form="add" name="action" value="uploadTokens" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $translate->getString('save')?></button>
                    <a href="products.php" class="btn btn-warning"><i class="fa fa-times" aria-hidden="true"></i> <?php echo $translate->getString('cancel')?></a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include dirname(__FILE__).'/include/footer.html.php'; ?>
