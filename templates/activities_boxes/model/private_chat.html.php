<div class="activity private">

    <div class="top">
        <h6><?php echo $translate->getString("privateWebcamPerformance") ?></h6>
        <p class="xs-txt"><?php echo $translate->getString("chatOnly") ?></p>
    </div>

    <a href="/<?php echo ($correctUser->getType() == 1) ? "user/".$correctUser->getLogin() : "model/".$correctUser->getLogin() ?>" class="user">
        <div class="avatar bg-img circle" style="background:url('<?php echo $correctUser->getProfilePicture()->getSRCThumbImage() ?>') center center no-repeat;"></div>
        <span><?php echo $correctUser->getLogin() ?></span>
    </a>

    <div class="when">
        <p class="date"><strong><?php echo $plannedActivity->getDate()->format("d.m.Y") ?></strong></p>
        <p class="time"><strong><?php echo $plannedActivity->getDate()->format("h:i a") ?></strong></p>
    </div>
    
    <div class="icons">
        <a h-ref="#" onClick="editPlannedActivity(<?php echo $plannedActivity->getPlannedActivityId() ?>, <?php echo $plannedActivity->getType() ?>);"><i class='fa fa-pencil'></i><span><?php echo $translate->getString('edit') ?></span></a>
        <a h-ref="#" data-toggle="modal" data-target="#cancel" onClick="deletePlannedActivityModalData(<?php echo $plannedActivity->getType()?>, <?php echo $plannedActivity->getPlannedActivityId() ?>)" ><i class='fa fa-close'></i><span><?php echo $translate->getString('cancel') ?></span></a>
    </div>

</div>