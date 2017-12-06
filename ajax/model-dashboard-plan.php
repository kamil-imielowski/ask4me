<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$user->loadActivityPrices($user->getId());

$translate = new \classes\Languages\Translate($_COOKIE['lang']);
?>

<div class="section requests plan animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("planAnActivity") ?></h4>
            
    <div class="form">
        
        <form action="" method="post" id="dashboardPlanActivity" >
            
            <div class="part">
                
                <div class="form-group">
                    <label><?php echo $translate->getString('dateAndTime') ?>:</label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' class="form-control" name="date" required/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label><?php echo $translate->getString('typeOfActivity') ?>:</label>
                    <div class="select">
                        <select onchange="inputContentOption(this)"  id="typeActivitySelect" name="type">
                            <option value="1"><?php echo $translate->getString('Tactivity-public') ?></option>
                            <option value="2"><?php echo $translate->getString('Tactivity-privateChat') ?></option>
                            <option value="3"><?php echo $translate->getString('Tactivity-privateAll') ?></option>
                            <option value="4"><?php echo $translate->getString('Tactivity-person') ?></option>
                         </select>
                    </div>
                </div>

                <div id="publicPlanTab">
                    <div class="form-group"><!--tylko dla public webcam broadcast-->
                        <label><?php echo $translate->getString('broadcastTitle') ?>:</label>
                        <input  class="required" type="text" placeholder="<?php $translate->getString('enterTitle') ?>" name="public[broadcastTitle]">
                    </div>

                    <!--tylko dla public webcam broadcast - narazie rezygnujemy bo watpie ze trasmisja się będzie zaczynać bez uzytkownika-->
                    <!-- <div class="form-group">
                        <h6 class="dashboard-heading">Add custom video</h6>
                        <p>You can add a custom video for your viewers to watch while waiting for you.</p>
                        <p><span><strong>Recommended format: </strong></span><span>.mp4</span></p>
                        <input id="custom-video" name="default-video[]" type="file" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
                    </div>  -->

                    <div class="part" id=""><!--tylko dla public webcam broadcast-->
                        <div class="form-group">
                            <label><?php echo $translate->getString('activity') ?></label>
                            <div class="select">
                                <select class="required" name="public[activity][]">
                                    <option value="" disabled selected><?php echo $translate->getString('selectActivity') ?></option>
                                    <?php if(!empty($user->getActivityPrices()->getPublicVote())){?>
                                        <optgroup label="<?php echo $translate->getString('vote') ?>">
                                            <?php foreach($user->getActivityPrices()->getPublicVote() as $publicVoteActivityPrice){?>
                                                <option value="V|<?php echo $publicVoteActivityPrice->getId(); ?>"><?php echo $publicVoteActivityPrice->getFirstOption()->getDescription(); ?></option>
                                            <?php }?>
                                        </optgroup>
                                    <?php }?>
                                    <?php if(!empty($user->getActivityPrices()->getPublicVote())){?>
                                        <optgroup label="<?php echo $translate->getString('doingSTH') ?>">
                                            <?php foreach($user->getActivityPrices()->getPublicDoSTH() as $publicDoSthActivityPrice){?>
                                                <option value="D|<?php echo $publicDoSthActivityPrice->getId(); ?>"><?php echo $publicDoSthActivityPrice->getDescription(); ?></option>
                                            <?php }?>
                                        </optgroup>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div id="PublicActivityContent"></div>

                        <a h-ref="#" class="add-activity" onClick="addPublicActivity()"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString("addAnActivity") ?></span></a>
                    </div>
                </div>

                <div id="privateChatPlanTab">
                    <div class="form-group">
                        <label><?php echo $translate->getString('username') ?>:</label>
                        <input type="text" class="required" id="privChatUserNameInput" onblur="$('#privateChatUserSugest').slideUp()" onfocus="$('#privateChatUserSugest').show('slow')" name="privateChat[username]" onkeyup="sugestUser(this, 'privateChatUserSugest')" placeholder="<?php echo $translate->getString('enterUsername') ?>">
                        <div id="privateChatUserSugest"></div>
                    </div>

                    <!-- <div class="form-group">
                        <label><?php echo $translate->getString('chooseFPCustomers') ?></label>
                        <div class="select">
                            <select name="privateChat[usernameSelect]">
                                <option value="" selected disabled><?php echo $translate->getString("chooseFromTheList") ?></option>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label><?php echo $translate->getString("chooseActivity") ?>:</label>
                        <div class="select">
                            <select class="requiredSelect" name="privateChat[activity]" onChange="getPrivateActivityInfo(this, 'privateChat')">
                                <option value="" selected disabled><?php echo $translate->getString("chooseFromTheList") ?></option>
                                <?php foreach($user->getActivityPrices()->getPrivateChat() as $privateChatActivityPrice){?>
                                    <option value="<?php echo $privateChatActivityPrice->getId(); ?>"><?php echo $privateChatActivityPrice->getDescription(); ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("minDurationInMin") ?>:</label>
                        <input type="number" min="1" max="360" class="required" name="privateChat[minDuration]" placeholder="<?php echo $translate->getString("minimumDuration") ?>">
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("confirmChangePriceTokens") ?>:</label>
                        <input type="number" min="0" class="required" onChange="updatePriceSum(this, 'privateChat')" id="privateChatPriceInput" name="privateChat[price]" placeholder="<?php echo $translate->getString('price') ?>">
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("additionalComments") ?>:</label>
                        <textarea name="privateChat[additionalComments]" placeholder="<?php echo $translate->getString("enterAdditionalInfo") ?>"></textarea>
                    </div>

                    <div class="form-group checkbox">
                        <input type="checkbox" id="privateChatSpyCamCheckbox" name="privateChat[spyCam]">
                        <label for="privateChatSpyCamCheckbox">
                            <?php echo $translate->getString("spyCamEnabled") ?>
                        </label>
                    </div>

                    <div class="part">
                        <p class="xl-txt"><strong><?php echo $translate->getString("pricePerMinute") ?>: </strong><span><bdi id="privateChatPriceSum"></bdi> <i class="fa fa-diamond"></i></span></p>
                    </div>
                </div>

                <div id="privateCamPlanTab">
                    <div class="form-group">
                        <label><?php echo $translate->getString('username') ?>:</label>
                        <input type="text" class="required" id="privCamUserNameInput" name="privateCam[username]" onblur="$('#privateCamUserSugest').slideUp()" onfocus="$('#privateCamUserSugest').show('slow')" onkeyup="sugestUser(this, 'privateCamUserSugest')"  placeholder="<?php echo $translate->getString('enterUsername') ?>">
                        <div id="privateCamUserSugest"></div>
                    </div>

                    <!-- <div class="form-group">
                        <label><?php echo $translate->getString('chooseFPCustomers') ?></label>
                        <div class="select">
                            <select name="privateCam[usernameSelect]">
                                <option value="" selected disabled><?php echo $translate->getString("chooseFromTheList") ?></option>
                                <option value="1">username</option>
                                <option value="2">username</option>
                                <option value="3">username</option>
                                <option value="4">username</option>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label><?php echo $translate->getString("chooseActivity") ?>:</label>
                        <div class="select">
                            <select class="requiredSelect" name="privateCam[activity]" onChange="getPrivateActivityInfo(this, 'privateCam')">
                                <option value="" selected disabled><?php echo $translate->getString("chooseFromTheList") ?></option>
                                <?php foreach($user->getActivityPrices()->getPrivate2W() as $private2WActivityPrice){?>
                                    <option value="<?php echo $private2WActivityPrice->getId(); ?>"><?php echo $private2WActivityPrice->getDescription(); ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("minDurationInMin") ?>:</label>
                        <input type="number" min="1" max="360"  class="required" name="privateCam[minDuration]" placeholder="<?php echo $translate->getString("minimumDuration") ?>">
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("confirmChangePriceTokens") ?>:</label>
                        <input type="number" min="1" class="required" onChange="updatePriceSum(this, 'privateCam')" id="privateCamPriceInput" name="privateCam[price]" placeholder="<?php echo $translate->getString('price') ?>" value="99">
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("additionalComments") ?>:</label>
                        <textarea name="privateCam[additionalComments]" placeholder="<?php echo $translate->getString("enterAdditionalInfo") ?>"></textarea>
                    </div>

                    <div class="form-group checkbox">
                        <input type="checkbox" id="privateCamSpyCamCheckbox" name="privateCam[spyCam]" id="checkbox123">
                        <label for="checkbox123">
                            <?php echo $translate->getString("spyCamEnabled") ?>
                        </label>
                    </div>

                    <div class="part">
                        <p class="xl-txt"><strong><?php echo $translate->getString("pricePerMinute") ?>: </strong><span><bdi id="privateCamPriceSum"></bdi> <i class="fa fa-diamond"></i></span></p>
                    </div>
                </div>

                <div id="EscortPlanTab">
                    <div class="form-group">
                        <label><?php echo $translate->getString('username') ?>:</label>
                        <input type="text" class="required" id="escortUserNameInput" name="escort[username]" onblur="$('#escortUserSugest').slideUp()" onfocus="$('#escortUserSugest').show('slow')" onkeyup="sugestUser(this, 'escortUserSugest')" placeholder="<?php echo $translate->getString('enterUsername') ?>">
                        <div id="escortUserSugest"></div>
                    </div>

                    <!-- <div class="form-group">
                        <label><?php echo $translate->getString('chooseFPCustomers') ?></label>
                        <div class="select">
                            <select name="escort[usernameSelect]">
                                <option value="" selected disabled><?php echo $translate->getString("chooseFromTheList") ?></option>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label><?php echo $translate->getString("chooseActivity") ?>:</label>
                        <div class="select">
                            <select class="requiredSelect" name="escort[activity]" onChange="getEscortActivityInfo(this)">
                                <option value="" selected disabled><?php echo $translate->getString("chooseFromTheList") ?></option>
                                <?php foreach($user->getActivityPrices()->getEscort() as $escortActivityPrice){ ?>
                                    <option value="<?php echo $escortActivityPrice->getId(); ?>"><?php echo $escortActivityPrice->getDescription(); ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="escortDurationContent"><!-- dla activity ktore maja zdefinowana cenę na godzinę a nie za całość -->
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("confirmChangePriceTokens") ?>:</label>
                        <input type="number" min="1" class="required" id="escortPriceInput" name="escort[price]" placeholder="<?php echo $translate->getString("price") ?>" value="99">
                    </div>

                    <div class="form-group">
                        <label><?php echo $translate->getString("additionalComments") ?>:</label>
                        <textarea name="escort[additionalComments]" placeholder="<?php echo $translate->getString("enterAdditionalInfo") ?>"></textarea>
                    </div>

                    <div class="part">
                        <p class="xl-txt"><strong><?php echo $translate->getString("totalPrice") ?>: </strong><span><bdi id="escortPriceSum"></bdi> <i class="fa fa-diamond"></i></span></p>
                    </div>
                </div>
                          
            </div> 
            
            <button type="submit" class="button med-prim-bg" name="action" form="dashboardPlanActivity" value="dashboardPlanActivity" ><?php echo $translate->getString('save') ?></button>
            
        </form>
    </div>
</div>

<script type="text/javascript" src="/js/fileinput.min.js"></script>
<script type="text/javascript">
    var user_id = '<?php echo $user->getId() ?>';

    $( document ).ready(function() {
        inputContentOption(document.getElementById("typeActivitySelect"));
    });

    $(function () {
        $('#datetimepicker1').datetimepicker({
            minDate: moment()
        });
    });

    function inputContentOption(select){
        $("#publicPlanTab").hide();
        $("#privateChatPlanTab").hide();
        $("#privateCamPlanTab").hide();
        $("#EscortPlanTab").hide();

        switch(select.value){
            case '1':
                $("#publicPlanTab").show();
                break;

            case '2':
                $("#privateChatPlanTab").show();
                break;

            case '3':
                $("#privateCamPlanTab").show();
                break;

            case '4':
                $("#EscortPlanTab").show();
                break;
        }

        requiredChange();
    }

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
        var duration = $("#escortDurationInput").val();
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