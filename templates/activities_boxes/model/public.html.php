<div class="activity public">

    <div class="top">
        <h6><?php echo $plannedActivity->getBroadcastTitle() ?></h6>
        <p class="xs-txt"><?php echo $translate->getString("Tactivity-public") ?></p>
    </div>

    <div class="when">
        <p class="date"><strong><?php echo $plannedActivity->getDate()->format("d.m.Y") ?></strong></p>
        <p class="time"><strong><?php echo $plannedActivity->getDate()->format("h:i a") ?></strong></p>
    </div>

    <div class="icons">
        <a h-ref="#" onClick="editPlannedActivity(<?php echo $plannedActivity->getPlannedActivityId() ?>, <?php echo $plannedActivity->getType() ?>);"><i class='fa fa-pencil'></i><span><?php echo $translate->getString('edit') ?></span></a>
        <a h-ref="#" data-toggle="modal" data-target="#cancel" onClick="deletePlannedActivityModalData(<?php echo $plannedActivity->getType()?>, <?php echo $plannedActivity->getPlannedActivityId() ?>)" ><i class='fa fa-close'></i><span><?php echo $translate->getString('cancel') ?></span></a>
    </div>
    
</div>