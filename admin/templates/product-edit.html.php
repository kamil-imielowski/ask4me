<?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
<?php include dirname(__FILE__).'/include/top_menu.html.php'; ?>

<div class="page-content">
    <div class="row">
        <?php include dirname(__FILE__).'/include/left_menu.html.php'; ?>
        <div class="col-md-10">
            <?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
            
            <h2><?php echo $translate->getString('editProduct')?></h2>
            
            <form method="POST" action="" id="add" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $product->getId() ?>">
                <div class="col-md-4">
                    <input type="text" name="name" placeholder="Nazwa produktu" class="form-control margin-bottom" value="<?php echo $product->getName() ?>" required>
                    <textarea name="description" placeholder="Opis produktu" class="form-control margin-bottom" required><?php echo $product->getDescription() ?></textarea>
                    <!--
                    <select name="type" onchange="addHtml()" class="form-control margin-bottom" required>
                        <option value="">Jaki produkt?</option>
                        <option value="1" <?php echo $product->getAdminProductType() == 1 ? 'selected' : ''; ?>>Tokeny</option>
                        <option value="2" <?php echo $product->getAdminProductType() == 2 ? 'selected' : ''; ?>>Członkostwo</option>
                    </select>
                    -->
                    <?php if($product->getAdminProductType() == 2){ ?>
                        <label>Członkostwo</label>
                        <select name="membership" class="form-control margin-bottom">
                            <option value="">Jaki rodzaj?</option>
                            <option value="basic" <?php echo $product->getAdminProductDetail() == 'basic' ? 'selected' : ''; ?>>Basic</option>
                            <option value="vip" <?php echo $product->getAdminProductDetail() == 'vip' ? 'selected' : ''; ?>>VIP</option>
                        </select>
                    <?php }?>
                    <?php if($product->getAdminProductType() == 1){ ?>
                        <label>Tokeny</label>
                        <input type="number" name="tokens" class="form-control margin-bottom" placeholder="Ilość tokenów" value="<?php echo $product->getAdminProductDetail() ?>">
                    <?php }?>
                    <input type="number" name="price" class="form-control margin-bottom" placeholder="Cena ($)" value="<?php echo $product->getPrice() ?>" required>
                    
                    <label>Zdjęcie</label>
                    <input class="margin-bottom" type="file" name="img">
                    <div class="form-group"> 
                        <button type="submit" form="add" name="action" value="uploadProduct" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $translate->getString('save')?></button>
                        <a href="categories.php" class="btn btn-warning"><i class="fa fa-times" aria-hidden="true"></i> <?php echo $translate->getString('cancel')?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    //$("select[name='membership']").hide();
    //$("input[name='tokens']").hide();
    function addHtml(){
        if($("select[name='type']").val() == 2){
            $("select[name='membership']").show();
            $("select[name='membership']").attr('required', true);

            $("input[name='tokens']").hide();
            $("input[name='tokens']").removeAttr('required');
        }else{
            $("select[name='membership']").hide();
            $("select[name='membership']").removeAttr('required');

            $("input[name='tokens']").show();
            $("input[name='tokens']").attr('required', true);
        }
    }
</script>
<?php include dirname(__FILE__).'/include/footer.html.php'; ?>
