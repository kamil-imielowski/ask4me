<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$user->loadActivityPrices($user->getId());

$request = new \classes\Requests\Request($_POST['requestId']);

if($request->getType() === 3){
    $request = new classes\Requests\EscortActivityRequest($request->getFromUser(), $request->getToUser(), $request->getRealatedTableId());
}else{
    $request = new \classes\Requests\PrivateActivityRequest($request->getFromUser(), $request->getToUser(), $request->getRealatedTableId());
}

$translate = new \classes\Languages\Translate($_COOKIE['lang']); 
?>

<div class="section requests edit animated fadeIn"><!--strona odnosi się do edycji requestów i activities-->
    <h4 class="dashboard-heading"><?php echo $translate->getString("editRequest") ?></h4>
            
    <div class="form">

        <form action="" method="post" id="editRequest" >
            <input type="hidden" name="related_id" value="<?php echo $request->getRealatedTableId() ?>" >
            <input type="hidden" name="id" value="<?php echo $request->getFromUser()->getId() ?>" >
            <div class="part">
                
                <div class="form-group">
                    <label><?php echo $translate->getString('dateAndTime') ?>:</label>
                    <div class='input-group date' id='datetimepicker123'>
                        <input type='text' class="form-control" name="date" required value="<?php echo $request->getDate()->format("m/d/Y h:i a"); ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label><?php echo $translate->getString('typeOfActivity') ?>:</label>
                    <input type="hidden" name="type" value="<?php echo $request->getType() ?>">
                    <div class="select">
                        <select  id="typeActivitySelect" disabled>
                            <option value="1" <?php echo $request->getType()===1 ? "selected" : ""; ?>><?php echo $translate->getString('Tactivity-privateChat') ?></option>
                            <option value="2" <?php echo $request->getType()===2 ? "selected" : ""; ?>><?php echo $translate->getString('Tactivity-privateAll') ?></option>
                            <option value="3" <?php echo $request->getType()===3 ? "selected" : ""; ?>><?php echo $translate->getString('Tactivity-person') ?></option>
                         </select>
                    </div>
                </div>

                <?php if($request->getType() == 1){ ?>
                <div id="privateChatPlanTab">
                    <div class="form-group">
                        <label><?php echo $translate->getString('username') ?>:</label>
                        <input type="text" readonly value="<?php echo $request->getFromUser()->getLogin(); ?>" class="required" id="privChatUserNameInput" onblur="$('#privateChatUserSugest').slideUp()" onfocus="$('#privateChatUserSugest').show('slow')" name="privateChat[username]" onkeyup="sugestUser(this, 'privateChatUserSugest')" placeholder="<?php echo $translate->getString('enterUsername') ?>">
                        <div id="privateChatUserSugest"></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("chooseActivity") ?>:</label>
                        <div class="select">
                            <select class="requiredSelect" name="privateChat[activity]" onChange="getPrivateActivityInfo(this, 'privateChat')">
                                <option value="" selected disabled><?php echo $translate->getString("chooseFromTheList") ?></option>
                                <?php foreach($user->getActivityPrices()->getPrivateChat() as $privateChatActivityPrice){?>
                                    <option value="<?php echo $privateChatActivityPrice->getId(); ?>" <?php if($request->getActivity()->getId() == $privateChatActivityPrice->getId()){echo "selected";} ?>><?php echo $privateChatActivityPrice->getDescription(); ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("minDurationInMin") ?>:</label>
                        <input type="number" min="1" max="360" value="<?php echo $request->getMinDuration() ?>" class="required" name="privateChat[minDuration]" placeholder="<?php echo $translate->getString("minimumDuration") ?>">
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("confirmChangePriceTokens") ?>:</label>
                        <input type="number" min="0" class="required" value="<?php echo $request->getPrice() ?>" onChange="updatePriceSum(this, 'privateChat')" id="privateChatPriceInput" name="privateChat[price]" placeholder="<?php echo $translate->getString('price') ?>">
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("additionalComments") ?>:</label>
                        <textarea name="privateChat[additionalComments]" placeholder="<?php echo $translate->getString("enterAdditionalInfo") ?>"><?php echo $request->getAdditionalComments() ?></textarea>
                    </div>

                    <div class="form-group checkbox">
                        <input type="checkbox" id="privateChatSpyCamCheckbox" name="privateChat[spyCam]" <?php if($request->getSpyCam()){echo "checked";} ?>>
                        <label for="privateChatSpyCamCheckbox">
                            <?php echo $translate->getString("spyCamEnabled") ?>
                        </label>
                    </div>

                    <div class="part">
                        <p class="xl-txt"><strong><?php echo $translate->getString("pricePerMinute") ?>: </strong><span><bdi id="privateChatPriceSum"><?php echo $request->getPrice() ?></bdi> <i class="fa fa-diamond"></i></span></p>
                    </div>
                </div>
                <?php }?>

                <?php if($request->getType() == 2){ ?>
                <div id="privateCamPlanTab">
                    <div class="form-group">
                        <label><?php echo $translate->getString('username') ?>:</label>
                        <input type="text" readonly value="<?php echo $request->getFromUser()->getLogin() ?>" class="required" id="privCamUserNameInput" name="privateCam[username]" onblur="$('#privateCamUserSugest').slideUp()" onfocus="$('#privateCamUserSugest').show('slow')" onkeyup="sugestUser(this, 'privateCamUserSugest')"  placeholder="<?php echo $translate->getString('enterUsername') ?>">
                        <div id="privateCamUserSugest"></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("chooseActivity") ?>:</label>
                        <div class="select">
                            <select class="requiredSelect" name="privateCam[activity]" onChange="getPrivateActivityInfo(this, 'privateCam')">
                                <option value="" selected disabled><?php echo $translate->getString("chooseFromTheList") ?></option>
                                <?php foreach($user->getActivityPrices()->getPrivate2W() as $private2WActivityPrice){?>
                                    <option value="<?php echo $private2WActivityPrice->getId(); ?>" <?php if($request->getActivity()->getId() == $private2WActivityPrice->getId()){echo "selected";} ?>><?php echo $private2WActivityPrice->getDescription(); ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("minDurationInMin") ?>:</label>
                        <input type="number" min="1" max="360" value="<?php echo $request->getMinDuration() ?>"  class="required" name="privateCam[minDuration]" placeholder="<?php echo $translate->getString("minimumDuration") ?>">
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("confirmChangePriceTokens") ?>:</label>
                        <input type="number" min="1" class="required" value="<?php echo $request->getPrice() ?>" onChange="updatePriceSum(this, 'privateCam')" id="privateCamPriceInput" name="privateCam[price]" placeholder="<?php echo $translate->getString('price') ?>" value="99">
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("additionalComments") ?>:</label>
                        <textarea name="privateCam[additionalComments]" placeholder="<?php echo $translate->getString("enterAdditionalInfo") ?>"><?php echo $request->getAdditionalComments() ?></textarea>
                    </div>

                    <div class="form-group checkbox">
                        <input type="checkbox" id="privateCamSpyCamCheckbox" name="privateCam[spyCam]" <?php if($request->getSpyCam()){echo "checked";} ?>>
                        <label for="privateCamSpyCamCheckbox">
                            <?php echo $translate->getString("spyCamEnabled") ?>
                        </label>
                    </div>

                    <div class="part">
                        <p class="xl-txt"><strong><?php echo $translate->getString("pricePerMinute") ?>: </strong><span><bdi id="privateCamPriceSum"><?php echo $request->getPrice() ?></bdi> <i class="fa fa-diamond"></i></span></p>
                    </div>
                </div>
                <?php }?>

                <?php if($request->getType() == 3){ ?>
                <div id="EscortPlanTab">
                    <div class="form-group">
                        <label><?php echo $translate->getString('username') ?>:</label>
                        <input type="text" class="required" readonly value="<?php echo $request->getFromUser()->getLogin() ?>" id="escortUserNameInput" name="escort[username]" onblur="$('#escortUserSugest').slideUp()" onfocus="$('#escortUserSugest').show('slow')" onkeyup="sugestUser(this, 'escortUserSugest')" placeholder="<?php echo $translate->getString('enterUsername') ?>">
                        <div id="escortUserSugest"></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("chooseActivity") ?>:</label>
                        <div class="select">
                            <select class="requiredSelect" name="escort[activity]" onChange="getEscortActivityInfo(this)">
                                <option value="" selected disabled><?php echo $translate->getString("chooseFromTheList") ?></option>
                                <?php foreach($user->getActivityPrices()->getEscort() as $escortActivityPrice){ ?>
                                    <option value="<?php echo $escortActivityPrice->getId(); ?>" <?php if($request->getActivity()->getId() ==  $escortActivityPrice->getId()){echo "selected";}?>><?php echo $escortActivityPrice->getDescription(); ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="escortDurationContent"><!-- dla activity ktore maja zdefinowana cenę na godzinę a nie za całość -->
                        <?php if(!empty($request->getDuration())){?>
                            <label><?php echo $translate->getString("durationInHours") ?>:</label>
                            <input type="number" class="required" onchange="escortTotalPriceUpdate()" onkeyup="escortTotalPriceUpdate()" min="1" max="24" id="escortDurationInput" name="escort[duration]" placeholder="<?php echo $translate->getString('duration') ?>" value="<?php echo $request->getDuration() ?>">        
                        <?php }?>
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("confirmChangePriceTokens") ?>:</label>
                        <input type="number" min="1" class="required" onchange="escortTotalPriceUpdate()" value="<?php echo $request->getPrice(); ?>" id="escortPriceInput" name="escort[price]" placeholder="<?php echo $translate->getString("price") ?>" value="99">
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("additionalComments") ?>:</label>
                        <textarea name="escort[additionalComments]" placeholder="<?php echo $translate->getString("enterAdditionalInfo") ?>"><?php echo $request->getAdditionalComments() ?></textarea>
                    </div>

                    <div class="part">
                        <p class="xl-txt"><strong><?php echo $translate->getString("totalPrice") ?>: </strong><span><bdi id="escortPriceSum"><?php echo $request->getPrice(); ?></bdi> <i class="fa fa-diamond"></i></span></p>
                    </div>
                </div>
                <?php }?>
                          
            </div> 
            
            <button type="submit" class="button med-prim-bg" name="action" form="editRequest" value="editRequest" ><?php echo $translate->getString('save') ?></button>
            
        </form>
        
    </div>
</div>

<script type="text/javascript">
    var user_id = '<?php echo $user->getId() ?>';
    escortTotalPriceUpdate();

    $(function () {
        $('#datetimepicker123').datetimepicker({
            minDate: moment()
        });
    });

    function addPublicActivity(){
        $("#PublicActivityContent").append(''+
            '<div class="form-group">'+
            '   <label><?php echo $translate->getString("activity") ?></label>'+
            '    <div class="select">'+
            '        <select class="required" name="public[activity][]">'+
            '            <option value="" disabled selected><?php echo $translate->getString("selectActivity") ?></option>'+
            '            <?php if(!empty($user->getActivityPrices()->getPublicVote())){ ?>'+
            '                <optgroup label="<?php echo $translate->getString("vote") ?>">'+
            '                    <?php foreach($user->getActivityPrices()->getPublicVote() as $publicVoteActivityPrice){?>'+
            '                        <option value="V|<?php echo $publicVoteActivityPrice->getId(); ?>"><?php echo $publicVoteActivityPrice->getFirstOption()->getDescription(); ?></option>'+
            '                    <?php }?>'+
            '                </optgroup>'+
            '            <?php }?>'+
            '            <?php if(!empty($user->getActivityPrices()->getPublicVote())){?>'+
            '                <optgroup label="<?php echo $translate->getString("doingSTH") ?>">'+
            '                    <?php foreach($user->getActivityPrices()->getPublicDoSTH() as $publicDoSthActivityPrice){?>'+
            '                        <option value="D|<?php echo $publicDoSthActivityPrice->getId(); ?>"><?php echo $publicDoSthActivityPrice->getDescription(); ?></option>'+
            '                    <?php }?>'+
            '                </optgroup>'+
            '            <?php }?>'+
            '            </select>'+
            '    </div>'+
            '</div>');
    }

    function sugestUser(input, divId){
        var query = input.value;
        var inputId = $(input).attr('id');
        var action = "getSugestUser";
        jQuery.ajax({
            url: "/ajax/ajax.php",
            type: "GET",
            data: {action, query},
            success:function(data){
                if(data === ""){
                    $("#"+divId).html("");
                }else{
                    var results = JSON.parse(data);
                    var echo = "<ul>";
                    $.each(results, function(i, item) {
                        echo += '<li><a h-ref="#" onClick="userHasBeenSelected(\''+inputId+'\',\''+item.login+'\')">'+item.login+'</a></li>';
                    });
                    echo += "</ul>"
                    $("#"+divId).html(echo);
                }
            }
        });
    }

    function userHasBeenSelected(inputId, login){
        $("#"+inputId).val(login);
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
                $("#"+where+"PriceInput").val(results.price);
                $("#"+where+"PriceSum").html(results.price);
                if(results.spyCam){
                    $("#"+where+"SpyCamCheckbox").attr("checked", "checked");
                }else{
                    $("#"+where+"SpyCamCheckbox").removeAttr("checked");
                }
            }
        });
    }

    function updatePriceSum(input, where){
        $("#"+where+"PriceSum").html(input.value);
    }

    function getEscortActivityInfo(select){
        var activityId = select.value;
        var action = "getEscortActivityInfo";
        jQuery.ajax({
            url: "/ajax/ajax.php",
            type: "GET",
            data: {action, activityId, user_id},
            success:function(data){
                var results = JSON.parse(data);
                $("#escortPriceInput").val(results.price);
                $("#escortPriceSum").html(results.price);
                escortDurationContentDependsPriceType(results.priceType);
            }
        });
    }

    function escortDurationContentDependsPriceType(type){
        switch(type){
            case '2':
                $("#escortDurationContent").html('<label><?php echo $translate->getString("durationInHours") ?>:</label> '+
                    '<input type="number" class="required" onchange="escortTotalPriceUpdate()" onkeyup="escortTotalPriceUpdate()" min="1" max="24" id="escortDurationInput" name="escort[duration]" placeholder="<?php echo $translate->getString("duration") ?>" value="1">');
                escortTotalPriceUpdate();
                break;

            case '1':
                $("#escortDurationContent").html("");
                break;
        }
    }   
    function escortTotalPriceUpdate(){
        var duration = 1;
        if ($("#escortDurationInput").length) {
            duration = $("#escortDurationInput").val();
        }
        var price = $("#escortPriceInput").val();
        var total = duration * price;
        $("#escortPriceSum").html(total);
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