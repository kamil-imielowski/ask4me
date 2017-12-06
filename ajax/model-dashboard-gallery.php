<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$user->loadGallery();
$translate = new \classes\Languages\Translate($_COOKIE['lang']);
?>
<div class="section gallery animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("addPhotosAndVideos"); ?></h4>
    
    <div class="form">
        
        <form method="POST" id="gallery" enctype="multipart/form-data">
            <input type="hidden" name="action" value="gallery">
            <div class="part">
                <div class="form-group">
                    <h6 class="dashboard-heading"><?php echo $translate->getString("addPhotos"); ?>:</h6> 
                    <p><span><strong><?php echo $translate->getString("recommendedFormat"); ?>: </strong></span><span>.jpg</span></p>
                    <input id="upload-photo" type="file" name="image[]" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
                    <a href="#" class="add-activity" id="a-image" onclick="addImage()"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString("addAnotherPhoto") ?></span></a>
                </div>
            </div>
            
            <div class="part">
                <div class="form-group">
                    <h6 class="dashboard-heading"><?php echo $translate->getString("addVideos"); ?>:</h6> 
                    <p><span><strong><?php echo $translate->getString("recommendedFormat"); ?>: </strong></span><span>.mp4</span></p>
                    <input id="upload-video" name="video[]" type="file" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
                    <a href="#" class="add-activity" id="a-video" onclick="addVideo()"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString("addAnotherVideo") ?></span></a>
                </div>
            </div>
            
            <div class="part">
                <div class="form-group">
                    <h6 class="dashboard-heading"><?php echo $translate->getString("defaultVideo"); ?>:</h6> 
                    <p><span><strong><?php echo $translate->getString("recommendedFormat"); ?>: </strong></span><span>.mp4</span></p>
                    <input id="offline-video" name="default-video[]" type="file" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
                </div> 
            </div>

            <input type="submit" class="button med-prim-bg" value="<?php echo $translate->getString("save"); ?>" form="gallery" />
        
        </form>
        
    </div>
</div>	

<div class="section your-gallery">
    <h4 class="dashboard-heading"><?php echo $translate->getString("yourPhotosAndVideos") ?></h4>
    
    <div class="images">
        <?php foreach($user->getPhotos() as $k){ ?>
            <div class="image" style="background:url(<?php echo $k->getSRCThumbImage(); ?>) no-repeat center center">
                <a href="dashboard-model.php?action=delete_photo&id=<?php echo $k->getId(); ?>">
                    <i class='fa fa-close'></i>
                </a>
            </div>
        <?php }?>
        <?php foreach($user->getVideos() as $k){ ?>
            <div class="image" style="background:url(<?php echo $k->getSRCThumbVideo() ?>) no-repeat center center">
                <h6>Video</h6>
                <a href="dashboard-model.php?action=delete_video&id=<?php echo $k->getId(); ?>">
                    <i class='fa fa-close'></i>
                </a>
            </div>
        <?php }?>
        <!-- </div> -->
    </div>	

<script type="text/javascript" src="js/fileinput.min.js"></script>
<script type="text/javascript">
    function addVideo(){
        $("#a-video").before('<input  name="video[]" type="file" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">');
    }

    function addImage(){
        $("#a-image").before('<input id="upload-photo" type="file" name="image[]" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">');
    }
</script>
