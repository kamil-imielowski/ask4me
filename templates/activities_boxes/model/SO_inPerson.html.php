<div class="activity person">

    <div class="top">
        <h6><?php echo $translate->getString("inPersonService") ?></h6>
    </div>

    <a href="/<?php echo ($correctUser->getType() == 1) ? "user/".$correctUser->getLogin() : "model/".$correctUser->getLogin() ?>" class="user">
        <div class="avatar bg-img circle" style="background:url('<?php echo $correctUser->getProfilePicture()->getSRCThumbImage() ?>') center center no-repeat;"></div>
        <span><?php echo $correctUser->getLogin() ?></span>
    </a>

    <div class="when">
        <p class="date"><strong><?php echo $translate->getString("startingSoon") ?></strong></p>
        <a href="broadcast-preview.php" class="button med-prim-bg"><?php echo $translate->getString("startNow") ?></a>
    </div>

    <div class="icons">
        <a h-ref="#" onClick="editPlannedActivity(<?php echo $plannedActivity->getPlannedActivityId() ?>, <?php echo $plannedActivity->getType() ?>);"><i class='fa fa-pencil'></i><span><?php echo $translate->getString('edit') ?></span></a>
        <a h-ref="#" data-toggle="modal" data-target="#cancel" onClick="deletePlannedActivityModalData(<?php echo $plannedActivity->getType()?>, <?php echo $plannedActivity->getPlannedActivityId() ?>)" ><i class='fa fa-close'></i><span><?php echo $translate->getString('cancel') ?></span></a>
    </div>
    
</div>