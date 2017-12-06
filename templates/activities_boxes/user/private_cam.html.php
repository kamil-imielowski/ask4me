<div class="activity private">
    <div class="top">
        <h6>Private webcam performance</h6>
        <p class="xs-txt">chat only</p>
    </div>
    <a href="model.php" class="user">
        <div class="avatar bg-img circle" style="background:url('<?php  echo $correctUser->getProfilePicture()->getSRCThumbImage() ?>') center center no-repeat;"></div>
        <span><?php echo $correctUser->getLogin() ?></span>
    </a>
    <div class="when">
        <p class="date"><strong>30.07.17</strong></p>
        <p class="time"><strong>21:00</strong></p>
    </div>
    <div class="icons">
        <a href="#" onClick="tab('edit', this);"><i class='fa fa-pencil'></i><span>edit</span></a>
        <a href="#" data-toggle="modal" data-target="#cancel" ><i class='fa fa-close'></i><span>cancel</span></a>
    </div>
</div>