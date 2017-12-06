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
                    <div class='input-group date'>
                        <input type='text' class="form-control" name="date" value="<?php echo date("m/d/Y h:i A") ?>" required onlyread/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label><?php echo $translate->getString('typeOfActivity') ?>:</label>
                    <div class="select">
                        <select  id="typeActivitySelect" name="type">
                            <option value="1"><?php echo $translate->getString('Tactivity-public') ?></option>
                         </select>
                    </div>
                </div>

                <div id="publicPlanTab">
                    <div class="form-group"><!--tylko dla public webcam broadcast-->
                        <label><?php echo $translate->getString('broadcastTitle') ?>:</label>
                        <input required type="text" placeholder="<?php $translate->getString('enterTitle') ?>" name="public[broadcastTitle]">
                    </div>


                    <div class="part" id=""><!--tylko dla public webcam broadcast-->
                        <div class="form-group">
                            <label><?php echo $translate->getString('activity') ?></label>
                            <div class="select">
                                <select required name="public[activity][]">
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
                          
            </div> 
            
            <button type="submit" class="button med-prim-bg" name="action" form="dashboardPlanActivity" value="dashboardPlanAndStartPublicActivity" ><?php echo $translate->getString('startAnActivity') ?></button>
            
        </form>
    </div>
</div>

<script type="text/javascript" src="/js/fileinput.min.js"></script>
<script type="text/javascript">
    var user_id = '<?php echo $user->getId() ?>';

    function addPublicActivity(){
        $("#PublicActivityContent").append(''+
            '<div class="form-group">'+
            '   <label><?php echo $translate->getString("activity") ?></label>'+
            '    <div class="select">'+
            '        <select required name="public[activity][]">'+
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

    function updatePriceSum(input, where){
        $("#"+where+"PriceSum").html(input.value);
    }
</script>