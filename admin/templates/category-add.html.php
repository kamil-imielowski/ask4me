<?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
<?php include dirname(__FILE__).'/include/top_menu.html.php'; ?>

<div class="page-content">
    <div class="row">
        <?php include dirname(__FILE__).'/include/left_menu.html.php'; ?>
        <div class="col-md-10">
            <?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
            
            <h2><?php echo $translate->getString('categoryAdd')?></h2>
            
            <form method="POST" action="" id="add">


                <ul class="nav nav-tabs">
                    <?php foreach($languages as $language){ ?>
                        <li <?php if($_COOKIE['lang'] == $language->getCode()){echo 'class="active"';} ?>><a data-toggle="tab" href="#<?php echo $language->getCode() ?>"><?php echo $language->getName() ?></a></li>
                    <?php }?>
                </ul>

                <div class="tab-content">

                    <?php foreach($languages as $language){ ?>
                        <div id="<?php echo $language->getCode() ?>" class="tab-pane fade <?php if($_COOKIE['lang'] == $language->getCode()){echo 'in active';} ?>">
                            <div class="content-box-large">
                                <div class="form-group">
					                <label for="ckeditor_full"><?php echo $translate->getString('name') ?>:</label>
                                    <input type="text" name="language[<?php echo $language->getCode() ?>][name]" class="form-control" value="<?php if(isset($data['language'][$language->getCode()]['name'])){echo $data['language'][$language->getCode()]['name'];} ?>" >
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>

                <div class="form-group"> 
                    <button type="submit" form="add" name="action" value="form-edit-add" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $translate->getString('save')?></button>
                    <a href="categories.php" class="btn btn-warning"><i class="fa fa-times" aria-hidden="true"></i> <?php echo $translate->getString('cancel')?></a>
                </div>

            </form>

        </div>
    </div>
</div>

<?php include dirname(__FILE__).'/include/footer.html.php'; ?>
