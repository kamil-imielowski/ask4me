<?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
<?php include dirname(__FILE__).'/include/top_menu.html.php'; ?>
<div class="page-content">
    <div class="row">
        <?php include dirname(__FILE__).'/include/left_menu.html.php'; ?>
        <div class="col-md-10">
            <?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
            
            <h2><?php echo $translate->getString('membership')?></h2>
            
            <form method="POST" action="products.php" id="add" enctype="multipart/form-data">

                <div class="col-md-4 margin-padding-none">
                    <label>Basic Membership</label>
                    <input type="text" name="name-basic" placeholder="Nazwa" required class="form-control margin-bottom" value="<?php echo $basic->getProducts()[0]->getName() ?>">
                    <textarea class="form-control margin-bottom" name="description-basic" placeholder="Opis"><?php echo $basic->getProducts()[0]->getDescription() ?></textarea>
                    <input type="number" name="price-basic" class="form-control margin-bottom" placeholder="Cena ($)" value="<?php echo $basic->getProducts()[0]->getPrice() ?>" required>
                    <img style="height: 150px; width: auto;" src="<?php echo $basic->getProducts()[0]->getPhoto()->getSRCOrginalImage() ?>">
                    <label>Zdjęcie</label>
                    <input class="margin-bottom" type="file" name="img-basic">
                </div>
                <div class="col-md-4 margin-padding-none">
                    <label>VIP Membership</label>
                    <input type="text" name="name-vip" placeholder="Nazwa" required class="form-control margin-bottom" value="<?php echo $vip->getProducts()[0]->getName() ?>">
                    <textarea class="form-control margin-bottom" name="description-vip" placeholder="Opis"><?php echo $vip->getProducts()[0]->getDescription() ?></textarea>
                    <input type="number" name="price-vip" class="form-control margin-bottom" placeholder="Cena ($)" value="<?php echo $vip->getProducts()[0]->getPrice() ?>" required>
                    <img style="height: 150px; width: auto;" src="<?php echo $vip->getProducts()[0]->getPhoto()->getSRCOrginalImage() ?>">
                    <label>Zdjęcie</label>
                    <input class="margin-bottom" type="file" name="img-vip">
                </div>
                <div class="form-group col-md-12 margin-padding-none"> 
                    <button type="submit" form="add" name="action" value="uploadMembership" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $translate->getString('save')?></button>
                    <a href="products.php" class="btn btn-warning"><i class="fa fa-times" aria-hidden="true"></i> <?php echo $translate->getString('cancel')?></a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include dirname(__FILE__).'/include/footer.html.php'; ?>
