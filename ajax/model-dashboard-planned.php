<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
try{
    $PA = new classes\PlannedActivities\PlannedActivitiesFactory($user->getId());
}catch(Exception $e){
    //echo $e->getMesage();
}

$translate = new \classes\Languages\Translate($_COOKIE['lang']);
?>
<div class="section planned-activities animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("plannedActivities") ?></h4>
   
    <div class="part filters">
        <div class="wrapper">
            
            <div class="calendar">
                <div id="dateselector"></div> <!-- kalendarz --> 
            </div>
            
            <div class="search-filters">
                <form>
                    <div class="form-group">
                        <input type="text" id="keywordFilter" placeholder="Search by keyword">
                    </div>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='text' id="dateFilter" class="form-control" placeholder="Date and time"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <button type="button" class="button med-prim-bg" onClick="filter()">Filter</button>
                </form>
            </div>
            
            <div class="links">
                <a h-ref="#" onClick="tab('plan', this);" class="add-activity xl-txt"><i class="fa fa-calendar lt-txt"></i><span><?php echo $translate->getString("planAnActivity") ?></span></a>
                <a h-ref="#" onClick="tab('start', this);" class="add-activity xl-txt"><i class="fa fa-check lt-txt"></i><span><?php echo $translate->getString("startAnActivity") ?></span></a>
            </div>
            
        </div>
    </div>
    
    <hr>
    
    <div class="part activities">
        <div class="wrapper" id="ActivitiesDivContent">

            <?php 
            if(!empty($PA->getStartSoon())){  
                $plannedActivity = $PA->getStartSoon();
                switch($plannedActivity->getType()){
                    case 1:
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/SO_public.html.php");
                        break;

                    case 2:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/SO_private_chat.html.php");                
                        break;

                    case 3:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/SO_private_cam.html.php");                                          
                        break;

                    case 4:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/SO_inPerson.html.php");      
                        break;
                }
            }
            ?>


            <?php 
            $plannedActivities = !empty($PA->getStartSoon()) ? $PA->getPlannedActivitiesLimit(3) : $PA->getPlannedActivitiesLimit(4);
            foreach($plannedActivities as $plannedActivity){
                switch($plannedActivity->getType()){
                    case 1:
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/public.html.php");
                        break;

                    case 2:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/private_chat.html.php");    
                        break;

                    case 3:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/private_cam.html.php");                
                        break;

                    case 4:
                        $correctUser = $plannedActivity->getInvitedUser()->getId() == $user->getId() ? $plannedActivity->getUser() : $plannedActivity->getInvitedUser();
                        include(dirname(dirname(__FILE__))."/templates/activities_boxes/model/inPerson.html.php");      
                        break;
                }
            }
            ?>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>

<script type="text/javascript">

var userId = <?php echo $user->getId() ?>;
var arrayable = getHighlightDates();

function getHighlightDates(){
    var daty;
    action = "getHighlightDates";
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

$('#dateselector').datepicker({
    dateFormat: 'yy-mm-dd',
    beforeShowDay: function (date) {
        var datestring = jQuery.datepicker.formatDate('yy-mm-dd', date);
        var hindex = $.inArray(datestring, arrayable);
        if (hindex > -1) {
            return [true, 'highlight', ""];
        }
        //var aindex = $.inArray(datestring, arrayable);
        return [false]
    },
    onSelect: function(dateText) {
        var data = this.value;
        $("#ActivitiesDivContent").html('<div class="center animated fadeIn"><img src="/img/loader.gif" /></div>')
        action = "getPlannedActivitiesForSelectedDate";
        jQuery.ajax({
            url: "/ajax/ajax.php",
            type: "GET",
            data: {data, action, userId},
            success:function(data){
                $("#ActivitiesDivContent").html(data)
            }
        });
        //datet = pobierz();
    }
})

function filter(){
    var keywords = $("#keywordFilter").val();
    var date = $("#dateFilter").val();
    var action = "getPlannedActivitiesforDateAndKeywordFilter";
    $("#ActivitiesDivContent").html('<div class="center animated fadeIn"><img src="/img/loader.gif" /></div>')
    jQuery.ajax({
        url: "/ajax/ajax.php",
        type: "GET",
        data: {keywords, action, date, userId},
        success:function(data){
            $("#ActivitiesDivContent").html(data);
            $("#dateselector").datepicker("setDate", date);
        }
    });
}

function editPlannedActivity(activityId, type){
    $('#content').html('<div class="center animated fadeIn"><img src="/img/loader.gif" /></div>'); //gif buforowania
	$('.nav-tab').removeClass("active");
	jQuery.ajax({
		url: "ajax/model-dashboard-edit.php",
        type: "POST",
        data: {activityId, type},
		success: function(data){
			$("#content").html(data);
		}
	});
}

function deletePlannedActivityModalData(type, plannedActivityId){
    $("#modalDeletePlannedActivityA").attr("href", "/dashboard-model.php?action=deletePlannedActivity&type="+type+"&plannedActivityId="+plannedActivityId);
}
</script>