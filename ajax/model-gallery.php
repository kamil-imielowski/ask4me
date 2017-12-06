<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$profileCustomer = new classes\User\ModelUser(null, $_POST['nick']);
$galleryList = $profileCustomer->loadGallery();

$translate = new \classes\Languages\Translate();
?>
<div class="gallery animated fadeIn">
    <div class="grid" id="links" data-masonry='{ "itemSelector": ".grid-item"}'>

        <!-- <?php foreach($profileCustomer->getPhotos() as $photo){?>
            <div class="data-box grid-item">
                <a href="<?php echo $photo->getSRCOrginalImage() ?>" title="<?php echo $photo->getTitle() ?>" data-gallery>
                    <img src="<?php echo $photo->getSRCThumbImage() ?>" alt="<?php echo $photo->getAlt() ?>">
                </a>
            </div>
        <?php }?>
        
        <?php foreach($profileCustomer->getVideos() as $video){?>
            <div class="data-box grid-item">
                <a 
                href="<?php echo $video->getSRCVideo() ?>"
                title="<?php echo $video->getTitle() ?>"
                type="video/mp4"
                data-poster="<?php echo $video->getSRCThumbVideo() ?>"
                data-sources='[{"href": "<?php echo $video->getSRCVideo() ?>", "type": "video/mp4"}]'
                data-gallery><img src="<?php echo $video->getSRCThumbVideo() ?>" alt="<?php echo $video->getAlt() ?>" /><h6>Video</h6></a>
            </div>
        <?php }?> -->

        <?php foreach($galleryList as $k){?>
            <?php if($k['type'] == "photo"){?>
                <?php $photo =  $profileCustomer->getPhotos()[$k['id']] ?>
                <div class="data-box grid-item">
                    <a href="<?php echo $photo->getSRCOrginalImage() ?>" title="<?php echo $photo->getTitle() ?>" data-gallery>
                        <img src="<?php echo $photo->getSRCThumbImage() ?>" alt="<?php echo $photo->getAlt() ?>">
                    </a>
                </div>
            <?php }?>
            <?php if($k['type'] == "video"){?>
                <?php $video =  $profileCustomer->getVideos()[$k['id']] ?>
                <div class="data-box grid-item">
                    <a 
                    href="<?php echo $video->getSRCVideo() ?>"
                    title="<?php echo $video->getTitle() ?>"
                    type="video/mp4"
                    data-poster="<?php echo $video->getSRCThumbVideo() ?>"
                    data-sources='[{"href": "<?php echo $video->getSRCVideo() ?>", "type": "video/mp4"}]'
                    data-gallery><img src="<?php echo $video->getSRCThumbVideo() ?>" alt="<?php echo $video->getAlt() ?>" /><h6>Video</h6></a>
                </div>
            <?php }?>
        <?php }?>

    </div>
</div>

<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-hide-page-scrollbars="false">
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <ol class="indicator"></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left prev">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                        Previous
                    </button>
                    <button type="button" class="btn btn-primary next">
                        Next
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
				</div>
            </div>
        </div>
	</div>
</div>
		
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>

<script>
// init Masonry
var $grid = $('.grid').masonry({
  // options...
});
// layout Masonry after each image loads
$grid.imagesLoaded().progress( function() {
  $grid.masonry('layout');
});
</script>
