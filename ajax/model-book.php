<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$profileCustomer = new classes\User\ModelUser(null, $_POST['nick']);
$profileCustomer->loadActivityPrices($profileCustomer->getId());

if(isset($_SESSION['user'])){
    $user = unserialize(base64_decode($_SESSION['user']));
}

$translate = new \classes\Languages\Translate();
?>
<div class="book form animated fadeIn">
    
    <form action="" method="post" id="bookModelForm">
        <input type="hidden" name="id" value="<?php echo $profileCustomer->getId() ?>" />
        <div class="form-group">
            <label><?php echo $translate->getString("typeOfActivity") ?>:</label>
            <div class="select">
                <select onchange="inputContentOption(this)"  id="typeActivitySelect" name="type">
                    <option value="1"><?php echo $translate->getString("Tactivity-privateChat") ?></option>
                    <option value="2"><?php echo $translate->getString("Tactivity-privateAll") ?></option>
                    <option value="3"><?php echo $translate->getString("Tactivity-person") ?></option>
                 </select>
            </div>
        </div>
        

        <div class="form-group">
            <label><?php echo $translate->getString("dateAndTime") ?>:</label>
            <div class='input-group date' id='datetimepicker1'>
                <input type='text' class="form-control" name="date" required/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>

        <div id="privateChatBookTab">

            <div class="form-group">
                <label><?php echo $translate->getString("chooseActivity") ?>:</label>
                <div class="select">
                    <select class="requiredSelect" name="privateChat[activity]" onChange="getPrivateActivityInfo(this, 'privateChat')">
                        <option value="" selected disabled><?php echo $translate->getString("chooseFromTheList") ?></option>
                        <?php foreach($profileCustomer->getActivityPrices()->getPrivateChat() as $privateChatActivityPrice){?>
                            <option value="<?php echo $privateChatActivityPrice->getId(); ?>"><?php echo $privateChatActivityPrice->getDescription(); ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <!--tylko dla webcam performance-->
            <div class="form-group">
                <label><?php echo $translate->getString("minDurationInMin") ?>:</label>
                <input type="number" min="1" max="360" class="required" name="privateChat[minDuration]" placeholder="<?php echo $translate->getString("minimumDuration") ?>">
            </div>

            <div class="form-group">
                <label><?php echo $translate->getString("additionalComments") ?>:</label>
                <textarea name="privateChat[additionalComments]"></textarea>
            </div>

            <div class="center">
                <!--tylko dla webcam performance-->
                <div class="form-group checkbox">
                    <input type="checkbox" id="privateChatSpyCamCheckbox" name="privateChat[spyCam]">
                    <label for="privateChatSpyCamCheckbox">
                        <?php echo $translate->getString("spyCamEnabled") ?>
                    </label>
                </div>

                <!--tylko dla webcam performance-->
                <p><strong><?php echo $translate->getString("pricePerMinute") ?>: </strong><span><bdi id="privateChatPriceSum"></bdi> <i class="fa fa-diamond"></i></span></p>
                <input type="hidden" id="privateChatPrice" name="privateChat[price]" onlyread>
            </div>

        </div>

        <div id="privateCamBookTab">

            <div class="form-group">
                <label><?php echo $translate->getString("chooseActivity") ?>:</label>
                <div class="select">
                    <select class="requiredSelect" name="privateCam[activity]" onChange="getPrivateActivityInfo(this, 'privateCam')">
                        <option value="" disabled selected><?php echo $translate->getString('selectActivity') ?></option>
                        <?php foreach($profileCustomer->getActivityPrices()->getPrivate2W() as $private2WActivityPrice){?>
                            <option value="<?php echo $private2WActivityPrice->getId(); ?>"><?php echo $private2WActivityPrice->getDescription(); ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <!--tylko dla webcam performance-->
            <div class="form-group">
                <label><?php echo $translate->getString("minDurationInMin") ?>:</label>
                <input type="number" min="1" max="360" class="required" name="privateCam[minDuration]" placeholder="<?php echo $translate->getString("minimumDuration") ?>">
            </div>

            <div class="form-group">
                <label><?php echo $translate->getString("additionalComments") ?>:</label>
                <textarea name="privateCam[additionalComments]"></textarea>
            </div>

            <div class="center">
                <!--tylko dla webcam performance-->
                <div class="form-group checkbox">
                    <input type="checkbox"  id="privateCamSpyCamCheckbox" name="privateCam[spyCam]">
                    <label for="privateCamSpyCamCheckbox">
                        <?php echo $translate->getString("spyCamEnabled") ?>
                    </label>
                </div>

                <!--tylko dla webcam performance-->
                <p><strong><?php echo $translate->getString("pricePerMinute") ?>: </strong><span><bdi id="privateCamPriceSum"></bdi> <i class="fa fa-diamond"></i></span></p>
                <input type="hidden" id="privateCamPrice" name="privateCam[price]" onlyread>
            </div>

        </div>

        <div id="escortBookTab">

            <div class="form-group">
                <label><?php echo $translate->getString("chooseActivity") ?>:</label>
                <div class="select">
                    <select class="requiredSelect" name="escort[activity]" onChange="getEscortActivityInfo(this)">
                        <option value="" disabled selected><?php echo $translate->getString('selectActivity') ?></option>
                        <?php foreach($profileCustomer->getActivityPrices()->getEscort() as $escortActivityPrice){ ?>
                            <option value="<?php echo $escortActivityPrice->getId(); ?>"><?php echo $escortActivityPrice->getDescription(); ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <!--tylko dla in person, dla activity ktore maja zdefinowana cenę na godzinę a nie za całość-->
            <div class="form-group" id="escortDurationContent"></div>

            <div class="form-group">
                <label><?php echo $translate->getString("additionalComments") ?>:</label>
                <textarea name="escort[additionalComments]"></textarea>
            </div>

            <div class="center">
                <p><strong><?php echo $translate->getString("totalPrice") ?>: </strong><span><bdi id="escortPriceSum"></bdi> <i class="fa fa-diamond"></i></span></p>
                <input type="hidden" id="escortPrice" name="escort[price]" onlyread>
            </div>

        </div>

        <div class="center">
            <?php if(isset($user) && $user->getId() === $profileCustomer->getId()){?>
                <button type="submit" class="button med-prim-bg" disabled><?php echo $translate->getString("sendRequest") ?></button>
            <?php }elseif(!isset($user)){?>
                <a href="/login.php?action=referer" class="button med-prim-bg"><?php echo $translate->getString("sendRequest") ?></a>
            <?php }else{ ?>
                <button type="submit" class="button med-prim-bg" form="bookModelForm" name="action" value="bookModelForm"><?php echo $translate->getString("sendRequest") ?></button>
            <?php }?>
        </div>
        
        
    </form>
    
</div>
		
<script type="text/javascript">
    var user_id = <?php echo $profileCustomer->getId(); ?>;
    var escortPriceHour = 1;

    $( document ).ready(function() {
        inputContentOption(document.getElementById("typeActivitySelect"));
    });

    $(function () {
        $('#datetimepicker1').datetimepicker({
            minDate: moment()
        });
    });

    function inputContentOption(select){
        $("#privateChatBookTab").hide();
        $("#privateCamBookTab").hide();
        $("#escortBookTab").hide();

        switch(select.value){
            case '1':
                $("#privateChatBookTab").show();
                break;

            case '2':
                $("#privateCamBookTab").show();
                break;

            case '3':
                $("#escortBookTab").show();
                break;
        }

        requiredChange();
    }

    function getPrivateActivityInfo(select, where){
        var activityId = select.value;
        var action = "getPrivateActivityInfo";
        jQuery.ajax({
            url: "/ajax/ajax.php",
            type: "GET",
            data: {action, activityId, user_id},
            success:function(data){
                var results = JSON.parse(data);
                $("#"+where+"Price").val(results.price);
                $("#"+where+"PriceSum").html(results.price);
                if(results.spyCam){
                    $("#"+where+"SpyCamCheckbox").attr("checked", "checked");
                }else{
                    $("#"+where+"SpyCamCheckbox").removeAttr("checked");
                }
            }
        });
    }

    function getEscortActivityInfo(select){
        var activityId = select.value;
        var action = "getEscortActivityInfo";
        jQuery.ajax({
            url: "/ajax/ajax.php",
            type: "GET",
            data: {action, activityId, user_id},
            success:function(data){
                console.log(data);
                var results = JSON.parse(data);
                escortPriceHour = results.price;
                escortDurationContentDependsPriceType(results.priceType);
            }
        });
    }

    function escortDurationContentDependsPriceType(type){
        switch(type){
            case '2':
                $("#escortDurationContent").html('<label><?php echo $translate->getString("durationInHours") ?>:</label> '+
                    '<input type="number" class="required" onchange="escortTotalPriceUpdate()" onkeyup="escortTotalPriceUpdate()" min="1" max="24" id="escortDurationInput" name="escort[duration]" placeholder="<?php echo $translate->getString("duration") ?>" value="1">');
                break;

            case '1':
                $("#escortDurationContent").html("");
                break;
        }
        escortTotalPriceUpdate();
    }   

    function escortTotalPriceUpdate(){
        var duration = 1;
        if ($("#escortDurationInput").length) {
            duration = $("#escortDurationInput").val();
        }
        var total = duration * escortPriceHour;
        $("#escortPriceSum").html(total);
        $("#escortPrice").val(total);
    }

    function requiredChange(){
        $('.required').prop('required', function(){
            return  $(this).parent().parent().is(':not(:hidden)')
        });

        $('.requiredSelect').prop('required', function(){
            return  $(this).parent().parent().parent().is(':not(:hidden)')
        });
    }
</script>