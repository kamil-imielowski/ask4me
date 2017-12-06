<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$user->loadActivityPrices($user->getId());

$translate = new \classes\Languages\Translate();
?>
<div class="section pricing animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString('priceTables') ?></h4>
    
    <div class="form">
        
        <form id="modelDasPricesActivity" method="post" action="">


            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#inPerson"><?php echo $translate->getString('price-inPerson-escortServices') ?></a></li>
                <li><a data-toggle="tab" href="#public"><?php echo $translate->getString('publicWebcamPerformance') ?></a></li>
                <li><a data-toggle="tab" href="#private"><?php echo $translate->getString('privateWebcamPerformance') ?></a></li>
            </ul>

            <div class="tab-content">

                <div id="inPerson" class="tab-pane fade in active">
                    <div class="part">
                        <h6><?php echo $translate->getString('price-inPerson-escortServices') ?></h6>
                        <p><?php echo $translate->getString('price-inPerson-escortServices-description') ?></p>                

                        <?php foreach($user->getActivityPrices()->getEscort() as $escortActivityPrice){ ?>
                            <div class="activity active">
                                <input type="hidden" name="escort[<?php echo $escortActivityPrice->getId(); ?>][id]" value="<?php echo $escortActivityPrice->getId(); ?>" >
                                <div class="form-group">
                                    <label><?php echo $translate->getString('activityDescription') ?>:</label>
                                    <input type="text" name="escort[<?php echo $escortActivityPrice->getId(); ?>][description]" placeholder="<?php echo $translate->getString('dWhatUllDo') ?>" value="<?php echo $escortActivityPrice->getDescription(); ?>">
                                </div>

                                <div class="radios">
                                    <div class="form-group half">
                                        <label><?php echo $translate->getString('price') ?></label>
                                        <input type="number" min="0" name="escort[<?php echo $escortActivityPrice->getId(); ?>][price]" placeholder="<?php echo $translate->getString('price') ?>" value="<?php echo $escortActivityPrice->getPrice(); ?>">
                                    </div>
                                    <div class="form-group radio inline">
                                        <input type="radio" name="escort[<?php echo $escortActivityPrice->getId(); ?>][priceType]" value="1" id="escortR<?php echo $escortActivityPrice->getId(); ?>" <?php if($escortActivityPrice->getTypePrice() == 1){echo "checked";} ?>>
                                        <label for="escortR<?php echo $escortActivityPrice->getId(); ?>">
                                            <?php echo $translate->getString('perHour') ?>
                                        </label>
                                    </div>
                                    <div class="form-group radio inline">
                                        <input type="radio" name="escort[<?php echo $escortActivityPrice->getId(); ?>][priceType]" value="2" id="escortR2<?php echo $escortActivityPrice->getId(); ?>" <?php if($escortActivityPrice->getTypePrice() == 2){echo "checked";} ?>>
                                        <label for="escortR2<?php echo $escortActivityPrice->getId(); ?>">
                                            <?php echo $translate->getString('forTheActivity') ?>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="form-group checkbox">
                                    <input type="checkbox" id="delCheckE<?php echo $escortActivityPrice->getId(); ?>" name="delete[escort][]" value="<?php echo $escortActivityPrice->getId(); ?>">
                                    <label class="add-activity" for="delCheckE<?php echo $escortActivityPrice->getId(); ?>"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?><span></label>
                                </div>
                                <!-- <a h-ref="#" class="add-activity"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?></span></a> -->
                                
                            </div>
                        <?php }?>

                        <div id="personActivityAddContentD"></div>
                        
                        <a h-ref="#" class="add-activity" onClick="personActivityAddContent()"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString('addEscortActivity') ?></span></a>
                        
                    </div>
                </div>

                <div id="public" class="tab-pane fade">
                    <div class="part">
                        <h6><?php echo $translate->getString('publicWebcamPerformance') ?></h6>
                        <p><?php echo $translate->getString('publicWebcamPerformance-description') ?></p>
                        
                        <?php foreach($user->getActivityPrices()->getPublicVote() as $publicVoteActivityPrice){?>
                        <div class="activity active">
                            <input type="hidden" name="public[<?php echo $publicVoteActivityPrice->getId(); ?>][id]" value="<?php echo $publicVoteActivityPrice->getId(); ?>" >
                            <input type="hidden" name="public[<?php echo $publicVoteActivityPrice->getId(); ?>][type]" value="2" >
                            <div class="form-group">
                                <label><?php echo $translate->getString('typeOfActivity') ?>:</label>
                                <span><?php echo $translate->getString('vote') ?></span>
                            </div>

                            <div class="vote">
                                <h6 class="dashboard-heading"><?php echo $translate->getString('whatNext') ?></h6>
                                <div class="form-group multiple">
                                    <input type="text" class="desc" name="public[<?php echo $publicVoteActivityPrice->getId(); ?>][description1]" placeholder="<?php echo $translate->getString('describe1stOpt') ?>" value="<?php echo $publicVoteActivityPrice->getFirstOption()->getDescription();  ?>">
                                    <input type="number" min="0" class="price" name="public[<?php echo $publicVoteActivityPrice->getId(); ?>][price1]" placeholder="<?php echo $translate->getString('pricePerVote') ?>" value="<?php echo $publicVoteActivityPrice->getFirstOption()->getPrice(); ?>">
                                </div>
                                <div class="form-group multiple">
                                    <input type="text" class="desc" name="public[<?php echo $publicVoteActivityPrice->getId(); ?>][description2]" placeholder="<?php echo $translate->getString('describe2ndOpt') ?>" value="<?php echo $publicVoteActivityPrice->getSecondOption()->getDescription(); ?>">
                                    <input type="number" min="0" class="price" name="public[<?php echo $publicVoteActivityPrice->getId(); ?>][price2]" placeholder="<?php echo $translate->getString('pricePerVote') ?>" value="<?php echo $publicVoteActivityPrice->getSecondOption()->getPrice(); ?>">
                                </div>
                                <div class="form-group multiple">
                                    <input type="text" class="desc" name="public[<?php echo $publicVoteActivityPrice->getId(); ?>][description3]" placeholder="<?php echo $translate->getString('describe3rdOpt') ?>" value="<?php echo $publicVoteActivityPrice->getThirdOption()->getDescription(); ?>">
                                    <input type="number" min="0" class="price" name="public[<?php echo $publicVoteActivityPrice->getId(); ?>][price3]" placeholder="<?php echo $translate->getString('pricePerVote') ?>" value="<?php echo $publicVoteActivityPrice->getThirdOption()->getPrice(); ?>">
                                </div>
                                <div class="form-group multiple">
                                    <input type="number" min="1" class="votes-count" name="public[<?php echo $publicVoteActivityPrice->getId(); ?>][votesForWin]" placeholder="<?php echo $translate->getString("howManyVotesForWin") ?>" value="<?php echo $publicVoteActivityPrice->getVotesToWin(); ?>">
                                </div>
                            </div>

                            <div class="form-group checkbox">
                                <input type="checkbox" id="delCheckPV<?php echo $publicVoteActivityPrice->getId(); ?>" name="delete[publicVote][]" value="<?php echo $publicVoteActivityPrice->getId(); ?>">
                                <label class="add-activity" for="delCheckPV<?php echo $publicVoteActivityPrice->getId(); ?>"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?><span></label>
                            </div>
                            <!-- <a h-ref="#" class="add-activity"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?></span></a> -->
                        </div>
                        <?php }?>
                        
                        <?php foreach($user->getActivityPrices()->getPublicDoSTH() as $publicDoSthActivityPrice){?>
                        <input type="hidden" name="public[d<?php echo $publicDoSthActivityPrice->getId(); ?>][id]" value="<?php echo $publicDoSthActivityPrice->getId(); ?>" >
                        <input type="hidden" name="public[d<?php echo $publicDoSthActivityPrice->getId(); ?>][type]" value="1" >
                        <div class="activity active">
                            <div class="form-group">
                                <label><?php echo $translate->getString('typeOfActivity') ?>:</label>
                                <span><?php echo $translate->getString('doingSTH') ?></span>
                            </div>
                            
                            <div class="doing-sth">
                                <div class="form-group multiple">
                                    <input type="text" class="desc" name="public[d<?php echo $publicDoSthActivityPrice->getId(); ?>][description]" placeholder="<?php echo $translate->getString('dWhatUllDo') ?>" value="<?php echo $publicDoSthActivityPrice->getDescription(); ?>">
                                    <input type="number" min="0" class="price" name="public[d<?php echo $publicDoSthActivityPrice->getId(); ?>][price]" placeholder="Price" value="<?php echo $publicDoSthActivityPrice->getPrice(); ?>">
                                </div>
                            </div>
                            
                            <div class="form-group checkbox">
                                <input type="checkbox" id="delCheckPDS<?php echo $publicDoSthActivityPrice->getId(); ?>" name="delete[publicDoSTH][]" value="<?php echo $publicDoSthActivityPrice->getId(); ?>">
                                <label class="add-activity" for="delCheckPDS<?php echo $publicDoSthActivityPrice->getId(); ?>"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?><span></label>
                            </div>
                            <!-- <a h-ref="#" class="add-activity"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?></span></a> -->
                        </div>
                        <?php }?>
                        
                        <div id="publicActivityAddContent"></div>

                        <a h-ref="#" class="add-activity" onClick="publicActivityAddContent()"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString('addPublicWebcamActivity') ?></span></a>
                        
                    </div>
                </div>

                <div id="private" class="tab-pane fade">
                    <div class="part">
                        <h6><?php echo $translate->getString('privateWebcamPerformance') ?></h6>
                        <p><?php echo $translate->getString('privateWebcamPerformance-description') ?></p>
                        
                        <div class="chat-only part">
                            <h6 class="dashboard-heading"><?php echo $translate->getString('Tactivity-privateChat') ?></h6>
                            
                            <!-- cena spy cam tylko jeśli zaznaczy checkbox-->
                            <?php foreach($user->getActivityPrices()->getPrivateChat() as $privateChatActivityPrice){?>
                            <div class="activity active">
                                <input type="hidden" name="private[<?php echo $privateChatActivityPrice->getId(); ?>][id]" value="<?php echo $privateChatActivityPrice->getId(); ?>" >
                                <input type="hidden" name="private[<?php echo $privateChatActivityPrice->getId(); ?>][type]" value="1" >
                                <div class="form-group multiple">
                                    <input type="text" class="desc" name="private[<?php echo $privateChatActivityPrice->getId(); ?>][description]" placeholder="<?php echo $translate->getString('dWhatUllDo') ?>" value="<?php echo $privateChatActivityPrice->getDescription(); ?>">
                                    <input type="number" min="0" class="price" name="private[<?php echo $privateChatActivityPrice->getId(); ?>][price]" placeholder="<?php echo $translate->getString('pricePerMinute') ?>" value="<?php echo $privateChatActivityPrice->getPrice(); ?>">
                                </div>
                                <div class="form-group checkbox multiple">
                                    <input type="checkbox" id="checkbox1" <?php if($privateChatActivityPrice->getSpyCam()){echo "checked";} ?> name="private[<?php echo $privateChatActivityPrice->getId(); ?>][spycam]">
                                    <label for="checkbox1">
                                        <?php echo $translate->getString('spyCamEnabledWB') ?>
                                    </label>
                                    <?php if($privateChatActivityPrice->getSpyCam()){ ?>
                                        <input type="number" min="0" class="spy-price" name="private[<?php echo $privateChatActivityPrice->getId(); ?>][spyCamPrice]" placeholder="<?php echo $translate->getString('priceForSpyCam-perMinute') ?>" value="<?php echo $privateChatActivityPrice->getSpyCamPrice(); ?>">
                                    <?php }?>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" id="delCheckPRIV<?php echo $privateChatActivityPrice->getId(); ?>" name="delete[private][]" value="<?php echo $privateChatActivityPrice->getId(); ?>">
                                    <label class="add-activity" for="delCheckPRIV<?php echo $privateChatActivityPrice->getId(); ?>"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?><span></label>
                                </div>
                                <!-- <a h-ref="#" class="add-activity"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?></span></a> -->
                            </div>
                            <?php }?>

                            <div id="privateChatActivityAddContent"></div>
                            
                            <a h-ref="#" class="add-activity" onclick="privateChatActivityAddContent()"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString('addPrivateChatWebcamActivity') ?></span></a>
                        </div>
                        
                        <div class="audio-video part">
                            <h6 class="dashboard-heading"><?php echo $translate->getString('privateWebCamP2W') ?></h6>
                            
                            <?php foreach($user->getActivityPrices()->getPrivate2W() as $private2WActivityPrice){?>
                            <div class="activity active">
                                <input type="hidden" name="private[<?php echo $private2WActivityPrice->getid(); ?>][id]" value="<?php echo $private2WActivityPrice->getid(); ?>" >
                                <input type="hidden" name="private[<?php echo $private2WActivityPrice->getid(); ?>][type]" value="2" >
                                <div class="form-group multiple">
                                    <input type="text" class="desc"name="private[<?php echo $private2WActivityPrice->getid(); ?>][description]" placeholder="<?php echo $translate->getString('dWhatUllDo') ?>" value="<?php echo $private2WActivityPrice->getDescription(); ?>">
                                    <input  type="number" min="0" class="price" name="private[<?php echo $private2WActivityPrice->getid(); ?>][price]" placeholder="<?php echo $translate->getString('pricePerMinute') ?>" value="<?php echo $private2WActivityPrice->getPrice(); ?>">
                                </div>
                                <div class="form-group checkbox multiple">
                                    <input type="checkbox" id="checkbox1" <?php if($private2WActivityPrice->getSpyCam()){ echo "checked";} ?> name="private[<?php echo $private2WActivityPrice->getid(); ?>][spycam]">
                                    <label for="checkbox1">
                                        <?php echo $translate->getString('spyCamEnabledWB') ?>
                                    </label>
                                    <?php if($private2WActivityPrice->getSpyCam()){ ?>
                                        <input type="number" min="0" class="spy-price"name="private[<?php echo $private2WActivityPrice->getid(); ?>][spyCamPrice]" placeholder="<?php echo $translate->getString('priceForSpyCam-perMinute') ?>" value="<?php echo $private2WActivityPrice->getSpyCamPrice(); ?>">
                                    <?php }?>
                                </div>

                                <div class="form-group checkbox">
                                    <input type="checkbox" id="delCheckPRIV<?php echo $private2WActivityPrice->getId(); ?>" name="delete[private][]" value="<?php echo $private2WActivityPrice->getId(); ?>">
                                    <label class="add-activity" for="delCheckPRIV<?php echo $private2WActivityPrice->getId(); ?>"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?><span></label>
                                </div>
                                <!-- <a h-ref="#" class="add-activity"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?></span></a> -->
                            </div>
                            <?php }?>

                            <div id="private2WActivityAddContent"></div>
                            
                            <a h-ref="#" class="add-activity" onClick="private2WActivityAddContent()"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString('addPrivateWebcamActivity') ?></span></a>
                        </div>
                        
                    </div>
                </div>

            </div>
            
            <button type="submit" class="button med-prim-bg" name="action" value="modelDasPricesActivity" form="modelDasPricesActivity" ><?php echo $translate->getString('save') ?></button>
        
        </form>
        
    </div>
</div>	


<script>

function personActivityAddContent(){
    var i = idGen.getId();
    var uid1 = idGen.getId();
    var uid2 = idGen.getId();
    $("#personActivityAddContentD").append(''+
        '<div class="activity">'+
        '    <div class="form-group">'+
        '        <label><?php echo $translate->getString("activityDescription") ?>:</label>'+
        '        <input type="text" name="escort['+i+'][description]" placeholder="<?php echo $translate->getString("dWhatUllDo") ?>">'+
        '    </div>'+
        '    <div class="radios">'+
        '        <div class="form-group half">'+
        '            <label><?php echo $translate->getString("price") ?></label>'+
        '            <input type="number" min="0" name="escort['+i+'][price]" placeholder="<?php echo $translate->getString("price") ?>">'+
        '        </div>'+
        '        <div class="form-group radio inline">'+
        '            <input type="radio" name="escort['+i+'][priceType]" value="1" id="'+uid1+'">'+
        '            <label for="'+uid1+'">'+
        '                <?php echo $translate->getString("perHour") ?>'+
        '            </label>'+
        '        </div>'+
        '        <div class="form-group radio inline">'+
        '            <input type="radio" name="escort['+i+'][priceType]" value="2" id="'+uid2+'">'+
        '            <label for="'+uid2+'">'+
        '                <?php echo $translate->getString("forTheActivity") ?>'+
        '            </label>'+
        '        </div>'+
        '    </div>'+
        '   <a h-ref="#" class="add-activity" onClick="$(this).parent().remove()"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?></span></a>'+
        '</div>');
}

function publicActivityAddContent(){
    var i = idGen.getId();
    $("#publicActivityAddContent").append(''+
        '<div class="activity">'+
        '    <div class="form-group">'+
        '        <label><?php echo $translate->getString("typeOfActivity") ?>:</label>'+
        '        <div class="select">'+
        '            <select onchange="publicActivityType(this, '+i+')" name="public['+i+'][type]">'+
        '                <option value="0" selected disabled><?php echo $translate->getString("typeOfActivity") ?></option>'+
        '                <option value="1"><?php echo $translate->getString("doingSTH") ?></option>'+
        '                <option value="2"><?php echo $translate->getString("vote") ?></option>'+
        '            </select>'+
        '        </div>'+
        '    </div>'+
        '    <div class="public-type-content"></div>'+
        '   <a h-ref="#" class="add-activity" onClick="$(this).parent().remove()"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?></span></a>'+
        '</div>');
}

function publicActivityType(select, i){
    var vote =  '    <div class="vote"><!-- tylko dla vote-->'+
                '        <h6 class="dashboard-heading"><?php echo $translate->getString("whatNext") ?></h6>'+
                '        <div class="form-group multiple">'+
                '            <input type="text" class="desc" name="public['+i+'][description1]" placeholder="<?php echo $translate->getString("describe1stOpt") ?>">'+
                '            <input type="number" min="0" class="price" name="public['+i+'][price1]" placeholder="<?php echo $translate->getString("pricePerVote") ?>">'+
                '        </div>'+
                '        <div class="form-group multiple">'+
                '            <input type="text" class="desc" name="public['+i+'][description2]" placeholder="<?php echo $translate->getString("describe2ndOpt") ?>">'+
                '            <input type="number" min="0" class="price" name="public['+i+'][price2]" placeholder="<?php echo $translate->getString("pricePerVote") ?>">'+
                '        </div>'+
                '        <div class="form-group multiple">'+
                '            <input type="text" class="desc" name="public['+i+'][description3]" placeholder="<?php echo $translate->getString("describe3rdOpt") ?>">'+
                '            <input type="number" min="0" class="price" name="public['+i+'][price3]" placeholder="<?php echo $translate->getString("pricePerVote") ?>">'+
                '        </div>'+
                '        <div class="form-group multiple">'+
                '            <input type="number" min="1" class="votes-count" name="public['+i+'][votesForWin]" placeholder="<?php echo $translate->getString("howManyVotesForWin") ?>">'+
                '        </div>'+
                '    </div>';

    var doin =  '    <div class="doing-sth"><!-- tylko dla doing something-->'+
                '        <div class="form-group multiple">'+
                '            <input type="text" class="desc" name="public['+i+'][description]" placeholder="<?php echo $translate->getString("dWhatUllDo") ?>">'+
                '            <input type="number" min="0" class="price" name="public['+i+'][price]" placeholder="<?php echo $translate->getString("price") ?>">'+
                '        </div>'+
                '    </div>';

    switch(select.value){
        case '1':
            $(select).parent().parent().parent().find(".public-type-content").html(doin);
            break;

        case '2':
            $(select).parent().parent().parent().find(".public-type-content").html(vote);
            break;
    }
}

function privateChatActivityAddContent(){
    var i = idGen.getId();
    $("#privateChatActivityAddContent").append(''+
        '<div class="activity">'+
        '    <input type="hidden" name="private['+i+'][type]" value="1" >'+
        '    <div class="form-group multiple">'+
        '        <input type="text" class="desc" name="private['+i+'][description]" placeholder="<?php echo $translate->getString("dWhatUllDo") ?>">'+
        '        <input type="number" min="0" class="price" name="private['+i+'][price]" placeholder="<?php echo $translate->getString("pricePerMinute") ?>">'+
        '    </div>'+
        '    <div class="form-group checkbox multiple">'+
        '        <input type="checkbox" onChange="checkSpyCam(this, '+i+')" name="private['+i+'][spycam]">'+
        '        <label>'+
        '            <?php echo $translate->getString("spyCamEnabledWB") ?>'+
        '        </label>'+
        '    </div>'+
        '   <a h-ref="#" class="add-activity" onClick="$(this).parent().remove()"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?></span></a>'+
        '</div>');
}

function private2WActivityAddContent(){
    var i = idGen.getId();
    $("#private2WActivityAddContent").append(''+
        '<div class="activity">'+
        '    <input type="hidden" name="private['+i+'][type]" value="2" >'+
        '    <div class="form-group multiple">'+
        '        <input type="text" class="desc" name="private['+i+'][description]" placeholder="<?php echo $translate->getString("dWhatUllDo") ?>">'+
        '        <input type="number" min="0" class="price" name="private['+i+'][price]" placeholder="<?php echo $translate->getString("pricePerMinute") ?>">'+
        '    </div>'+
        '    <div class="form-group checkbox multiple">'+
        '        <input type="checkbox" onChange="checkSpyCam(this, '+i+')" name="private['+i+'][spycam]">'+
        '        <label for="checkbox1">'+
        '            <?php echo $translate->getString("spyCamEnabledWB") ?>'+
        '        </label>'+
        '    </div>'+
        '   <a h-ref="#" class="add-activity" onClick="$(this).parent().remove()"><i class="fa fa-trash lt-prim-txt"></i><span><?php echo $translate->getString('deleteActivity') ?></span></a>'+
        '</div>');
}

function checkSpyCam(checkbox, i){
    if(checkbox.checked){
        $(checkbox).parent().append('<input type="text" class="spy-price checkboxSpyinput" name="private['+i+'][spyCamPrice]" placeholder="<?php echo $translate->getString("priceForSpyCam-perMinute") ?>">');
    }else{
        $(checkbox).parent().find(".checkboxSpyinput").remove();
    }
}

function Generator() {};

Generator.prototype.rand =  Math.floor(Math.random() * 26) + Date.now();

Generator.prototype.getId = function() {
return this.rand++;
};
var idGen =new Generator();

</script>