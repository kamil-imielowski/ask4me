<div class="activity private">
    <div class="top">
        <h6><?php echo $translate->getString("privateWebcamPerformance") ?></h6>
        <p class="xs-txt"><?php echo $translate->getString("w2AudioVideo") ?></p>
    </div>
    <a href="/<?php echo ($correctUser->getType() == 1) ? "user/".$correctUser->getLogin() : "model/".$correctUser->getLogin() ?>" class="user">
        <div class="avatar bg-img circle" style="background:url('<?php echo $correctUser->getProfilePicture()->getSRCThumbImage() ?>') center center no-repeat;"></div>
        <span><?php echo $correctUser->getLogin() ?></span>
    </a>
    <div class="when">
        <p class="date"><strong><?php echo $translate->getString("startingSoon") ?></strong></p>
        <a href="/private-live-cam/<?php echo $correctUser->getLogin() ?>" class="button med-prim-bg"><?php echo $translate->getString("enter") ?></a>
    </div>
    <!-- <div class="icons">
        <a href="#" onClick="tab('edit', this);"><i class='fa fa-pencil'></i><span>edit</span></a>
        <a href="#" data-toggle="modal" data-target="#cancel" ><i class='fa fa-close'></i><span>cancel</span></a>
    </div> -->
</div>