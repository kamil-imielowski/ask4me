<?php include dirname(__FILE__).'/include/subheader.html.php'; ?>
<?php include dirname(__FILE__).'/include/top_menu.html.php'; ?>

<div class="page-content">
    <div class="row">
        <?php include dirname(__FILE__).'/include/left_menu.html.php'; ?>
        <div class="col-md-10">
            <?php include dirname(__FILE__).'/include/alerts.html.php'; ?>
            
            <h2><?php echo $translate->getString('settings')?> / <?php echo $translate->getString('socialMedia')?></h2>
            
            <form method="POST" action="" id="add">

                <div class="content-box-large">

                    <div class="form-group">
                        <label for="ckeditor_full">Facebook:</label>
                        <input type="text" name="facebook" class="form-control" value="<?php echo $socialMedia->getFacebook(); ?>" >
                    </div>

                    <div class="form-group">
                        <label for="ckeditor_full">Google Plus:</label>
                        <input type="text" name="googlePlus" class="form-control" value="<?php echo $socialMedia->getGooglePlus() ?>" >
                    </div>

                    <div class="form-group">
                        <label for="ckeditor_full">Instagram: </label>
                        <input type="text" name="instagram" class="form-control" value="<?php echo $socialMedia->getInstagram() ?>" >
                    </div>

                    <div class="form-group">
                        <label for="ckeditor_full">Twitter:</label>
                        <input type="text" name="twitter" class="form-control" value="<?php echo $socialMedia->getTwitter() ?>" >
                    </div>

                    <div class="form-group">
                        <label for="ckeditor_full">YouTube:</label>
                        <input type="text" name="youTube" class="form-control" value="<?php echo $socialMedia->getYouTube() ?>" >
                    </div>

                </div>
                

                <div class="form-group"> 
                    <button type="submit" form="add" name="action" value="form-edit-add" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo $translate->getString('save')?></button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php include dirname(__FILE__).'/include/footer.html.php'; ?>
