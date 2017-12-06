<div class="activity public">

    <div class="top">
        <h6><?php echo $plannedActivity->getBroadcastTitle() ?></h6>
        <p class="xs-txt"><?php echo $translate->getString("Tactivity-public") ?></p>
    </div>

    <div class="when">
        <p class="date"><strong><?php echo $translate->getString("startingSoon") ?></strong></p>
        <a href="broadcast.php?action=start&id=<?php echo $plannedActivity->getPlannedActivityId() ?>" class="button med-prim-bg"><?php echo $translate->getString("startNow") ?></a>
    </div>

    <div class="icons">
        <a h-ref="#" onClick="editPlannedActivity(<?php echo $plannedActivity->getPlannedActivityId() ?>, <?php echo $plannedActivity->getType() ?>);"><i class='fa fa-pencil'></i><span><?php echo $translate->getString('edit') ?></span></a>
        <a h-ref="#" data-toggle="modal" data-target="#cancel" onClick="deletePlannedActivityModalData(<?php echo $plannedActivity->getType()?>, <?php echo $plannedActivity->getPlannedActivityId() ?>)" ><i class='fa fa-close'></i><span><?php echo $translate->getString('cancel') ?></span></a>
    </div>

</div>