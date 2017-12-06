<!-- bedzie dobrze tylko na stronie modela trzeba patrzec -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src='/js/moment.js'></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="right">
    
    <div class="box upcoming">
        <h6><?php echo $translate->getString('upcomingActivities') ?></h6>
        <div class="inside">
            <div id="dateselector"></div> <!-- kalendarz --> 
            
            <div id="dayContent"></div>

        </div>     
    </div>
    
    <div class="box availability">
        <h6><?php echo $translate->getString("availability") ?></h6>
        <div class="inside">
            <p>
                <label><?php echo $translate->getString("monday") ?>:</label>
                <?php foreach($profileCustomer->getAvailability()->getMonday() as $timerange){?>
                    <span><?php echo $timerange['from'] ?> - <?php echo $timerange['to'] ?></span>
                <?php }?>
            </p>
            <p>
                <label><?php echo $translate->getString("tuesday") ?>:</label>
                <?php foreach($profileCustomer->getAvailability()->getTuesday() as $timerange){?>
                    <span><?php echo $timerange['from'] ?> - <?php echo $timerange['to'] ?></span>
                <?php }?>
            </p>
            <p>
                <label><?php echo $translate->getString("wednesday") ?>:</label>
                <?php foreach($profileCustomer->getAvailability()->getWednesday() as $timerange){?>
                    <span><?php echo $timerange['from'] ?> - <?php echo $timerange['to'] ?></span>
                <?php }?>
            </p>
            <p>
                <label><?php echo $translate->getString("thursday") ?>:</label>
                <?php foreach($profileCustomer->getAvailability()->getThursday() as $timerange){?>
                    <span><?php echo $timerange['from'] ?> - <?php echo $timerange['to'] ?></span>
                <?php }?>
            </p>
            <p>
                <label><?php echo $translate->getString("friday") ?>:</label>
                <?php foreach($profileCustomer->getAvailability()->getFriday() as $timerange){?>
                    <span><?php echo $timerange['from'] ?> - <?php echo $timerange['to'] ?></span>
                <?php }?>
            </p>
            <p>
                <label><?php echo $translate->getString("saturday") ?>:</label>
                <?php foreach($profileCustomer->getAvailability()->getSaturday() as $timerange){?>
                    <span><?php echo $timerange['from'] ?> - <?php echo $timerange['to'] ?></span>
                <?php }?>
            </p>
            <p>
                <label><?php echo $translate->getString("sunday") ?>:</label>
                <?php foreach($profileCustomer->getAvailability()->getSunday() as $timerange){?>
                    <span><?php echo $timerange['from'] ?> - <?php echo $timerange['to'] ?></span>
                <?php }?>
            </p>
        </div>
    </div>
    
    <?php if(!empty($profileCustomer->getRecentActivity())){?>
    <div class="box recent">
        <h6><?php echo $translate->getString('recentActivity') ?></h6>
        <div class="inside">
            <?php foreach($profileCustomer->getRecentActivity() as $recentActivity){?>
                
                <?php if($recentActivity['type'] == 1){ ?>
                    <div class="activity">
                        <p><strong><?php echo $recentActivity["date"]->format("d.m.Y h:i a") ?></strong></p>
                        <p><?php echo $profileCustomer->getLogin() ?> <?php echo $translate->getString("addedPhoto") ?></p>
                        <a h-ref="#" onClick="tab('gallery', document.getElementById('model-gallery-nav-tab'));"><?php echo $translate->getString("visitGallery") ?></a>
                    </div>
                <?php }?>

                <?php if($recentActivity['type'] == 2){ ?>
                    <div class="activity">
                        <p><strong><?php echo $recentActivity["date"]->format("d.m.Y h:i a") ?></strong></p>
                        <p><?php echo $profileCustomer->getLogin() ?> <?php echo $translate->getString("receivedFeedback"); ?></p>
                        <a h-ref="#" onClick="tab('feedback', document.getElementById('model-feedback-nav-tab'));"><?php echo $translate->getString("visitFeedBackPage") ?></a>
                    </div>
                <?php }?>

                <?php if($recentActivity['type'] == 3){ ?>
                    <div class="activity">
                        <p><strong><?php echo $recentActivity["date"]->format("d.m.Y h:i a") ?></strong></p>
                        <p><?php echo $profileCustomer->getLogin() ?> <?php echo $translate->getString("addedBlogEntry") ?></p>
                        <a h-ref="#" onClick="tab('blog', document.getElementById('model-blog-nav-tab'));"><?php echo $translate->getString("visitBlog") ?></a>
                    </div>
                <?php }?>

                <?php if($recentActivity['type'] == 4){ ?>
                    <div class="activity">
                        <p><strong><?php echo $recentActivity["date"]->format("d.m.Y h:i a") ?></strong></p>
                        <p><?php echo $profileCustomer->getLogin() ?> <?php echo $translate->getString("addedNewProduct") ?></p>
                        <a h-ref="#" onClick="tab('store', document.getElementById('model-store-nav-tab'));"><?php echo $translate->getString("visitStore") ?></a>
                    </div>
                <?php }?>

                <?php if($recentActivity['type'] == 5){ ?>
                    <div class="activity">
                        <p><strong><?php echo $recentActivity["date"]->format("d.m.Y h:i a") ?></strong></p>
                        <p><?php echo $profileCustomer->getLogin() ?> <?php echo $translate->getString("addedVideo") ?></p>
                        <a h-ref="#" onClick="tab('gallery', document.getElementById('model-gallery-nav-tab'));"><?php echo $translate->getString("visitGallery") ?></a>
                    </div>
                <?php }?>

            <?php }?>
        </div>
    </div>
    <?php }?>
    
    <div class="ban">
        <a h-ref="#" data-toggle="modal" data-target="#block">
            <i class='material-icons'>block</i>
            <span><?php echo $translate->getString('block') ?></span>
        </a>
        <a h-ref="#" data-toggle="modal" data-target="#report">
            <i class='material-icons'>report</i>
            <span><?php echo $translate->getString('report') ?></span>
        </a>
    </div>
    
</div>

<script type="text/javascript">
var userId = <?php echo $profileCustomer->getId() ?>;

$(document).ready(function(){
    var data = $.datepicker.formatDate('yy-mm-dd', new Date());
    var action = "getPublicPlannedActivitiesForSelectedDate";
    jQuery.ajax({
        url: "/ajax/ajax.php",
        type: "GET",
        data: {data, action, userId},
        success:function(data){
            var results = JSON.parse(data);
            $("#dayContent").html("");
            $.each(results, function(i, item) {
                $("#dayContent").append('<div class="description">'+
                                        '    <p><strong>'+item.date+'</strong></p>'+
                                        '    <p><?php echo $translate->getString("Tactivity-public") ?></p>'+
                                        '    <a h-ref="'+item.id+'">Subscribe</a>'+
                                        '</div>');
            });
        }
    });
})

function getHighlightDates(){
    var daty;
    action = "getHighlightPublicDates";
    jQuery.ajax({
            url: "/ajax/ajax.php",
            type: "GET",
            data: {userId, action},
            async: false,
            success:function(data){
                daty = $.parseJSON(data);
            }
        });
    return daty;
}

var arrayable = getHighlightDates();

$('#dateselector').datepicker({
    dateFormat: 'yy-mm-dd',
    beforeShowDay: function (date) {
        var datestring = jQuery.datepicker.formatDate('yy-mm-dd', date);
        var hindex = $.inArray(datestring, arrayable);
        if (hindex > -1) {
            action = "getPublicPlannedActivitiesForSelectedDate";
            return [true, 'highlight', ""];
        }
        //var aindex = $.inArray(datestring, arrayable);
        return [false]
    },
    onSelect: function(dateText) {
        var data = this.value;
        action = "getPublicPlannedActivitiesForSelectedDate";
        jQuery.ajax({
            url: "/ajax/ajax.php",
            type: "GET",
            data: {data, action, userId},
            success:function(data){
                var results = JSON.parse(data);
                $("#dayContent").html("");
                $.each(results, function(i, item) {
                    $("#dayContent").append('<div class="description">'+
                                            '    <p><strong>'+item.date+'</strong></p>'+
                                            '    <p><?php echo $translate->getString("Tactivity-public") ?></p>'+
                                            '    <a h-ref="'+item.id+'">Subscribe</a>'+
                                            '</div>');
                });
            }
        });
    }
})
</script>