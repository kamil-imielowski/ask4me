<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$user->loadAvailability();

$translate = new \classes\Languages\Translate($_COOKIE['lang']);
?>
<div class="section availability">
    <h4 class="dashboard-heading"><?php echo $translate->getString('availabilitySettings') ?></h4>
    
    <div class="form">
        
        <form action="" method="post" id="model_availability">
            
            <div class="part">
                <h6><?php echo $translate->getString('monday') ?></h6>
                
                <?php foreach($user->getAvailability()->getMonday() as $timerange){?>
                <div class="form-group multiple">
                    <div class='input-group date datetimepicker-from' id='d1'>
                        <input type='text' name="day[1][from][]" class="form-control" placeholder="<?php echo $translate->getString('from') ?>" value="<?php echo $timerange['from'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <div class='input-group date datetimepicker-to' id='d2'>
                        <input type='text' name="day[1][to][]" class="form-control" placeholder="<?php echo $translate->getString('to') ?>" value="<?php echo $timerange['to'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <a h-ref="#" onClick="$(this).parent().remove()" class="add-activity"><i class="fa fa-trash lt-txt"></i><span><?php echo $translate->getString('delTimeRange') ?></span></a>
                </div>
                <?php }?>

                <div id="content-day-1"></div>
                
                <a h-ref="#" onClick="addTimeRange(1)" class="add-activity"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString('addTimeRange') ?></span></a>
                
            </div>
            
            <div class="part">
                <h6><?php echo $translate->getString('tuesday') ?></h6>
                
                <?php foreach($user->getAvailability()->getTuesday() as $timerange){?>
                <div class="form-group multiple">
                    <div class='input-group date datetimepicker-from' id='d3'>
                        <input type='text' name="day[2][from][]" class="form-control" placeholder="<?php echo $translate->getString('from') ?>" value="<?php echo $timerange['from'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <div class='input-group date datetimepicker-to' id='d4'>
                        <input type='text' name="day[2][to][]" class="form-control" placeholder="<?php echo $translate->getString('to') ?>" value="<?php echo $timerange['to'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <a h-ref="#" onClick="$(this).parent().remove()" class="add-activity"><i class="fa fa-trash lt-txt"></i><span><?php echo $translate->getString('delTimeRange') ?></span></a>
                </div>
                <?php }?>

                <div id="content-day-2"></div>
                
                <a h-ref="#" onClick="addTimeRange(2)" class="add-activity"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString('addTimeRange') ?></span></a>
                
            </div>
            
            <div class="part">
                <h6><?php echo $translate->getString('wednesday') ?></h6>
                
                <?php foreach($user->getAvailability()->getWednesday() as $timerange){?>
                <div class="form-group multiple">
                    <div class='input-group date datetimepicker-from' id='d5'>
                        <input type='text' name="day[3][from][]" class="form-control" placeholder="<?php echo $translate->getString('from') ?>" value="<?php echo $timerange['from'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <div class='input-group date datetimepicker-to' id='d6'>
                        <input type='text' name="day[3][to][]" class="form-control" placeholder="<?php echo $translate->getString('to') ?>" value="<?php echo $timerange['to'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <a h-ref="#" onClick="$(this).parent().remove()" class="add-activity"><i class="fa fa-trash lt-txt"></i><span><?php echo $translate->getString('delTimeRange') ?></span></a>
                </div>
                <?php }?>

                <div id="content-day-3"></div>
                
                <a h-ref="#" onClick="addTimeRange(3)" class="add-activity"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString('addTimeRange') ?></span></a>
                
            </div>
            
            <div class="part">
                <h6><?php echo $translate->getString('thursday') ?></h6>
                
                <?php foreach($user->getAvailability()->getThursday() as $timerange){?>
                <div class="form-group multiple">
                    <div class='input-group date datetimepicker-from' id='d7'>
                        <input type='text' name="day[4][from][]" class="form-control" placeholder="<?php echo $translate->getString('from') ?>" value="<?php echo $timerange['from'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <div class='input-group date datetimepicker-to' id='d8'>
                        <input type='text' name="day[4][to][]" class="form-control" placeholder="<?php echo $translate->getString('to') ?>" value="<?php echo $timerange['to'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <a h-ref="#" onClick="$(this).parent().remove()" class="add-activity"><i class="fa fa-trash lt-txt"></i><span><?php echo $translate->getString('delTimeRange') ?></span></a>
                </div>
                <?php }?>

                <div id="content-day-4"></div>
                
                <a h-ref="#" onClick="addTimeRange(4)" class="add-activity"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString('addTimeRange') ?></span></a>
                
            </div>
            
            <div class="part">
                <h6><?php echo $translate->getString('friday') ?></h6>
                
                <?php foreach($user->getAvailability()->getFriday() as $timerange){?>
                <div class="form-group multiple">
                    <div class='input-group date datetimepicker-from' id='d9'>
                        <input type='text' name="day[5][from][]" class="form-control" placeholder="<?php echo $translate->getString('from') ?>" value="<?php echo $timerange['from'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <div class='input-group date datetimepicker-to' id='d10'>
                        <input type='text' name="day[5][to][]" class="form-control" placeholder="<?php echo $translate->getString('to') ?>" value="<?php echo $timerange['to'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <a h-ref="#" onClick="$(this).parent().remove()" class="add-activity"><i class="fa fa-trash lt-txt"></i><span><?php echo $translate->getString('delTimeRange') ?></span></a>                    
                </div>
                <?php }?>

                <div id="content-day-5"></div>
                
                <a h-ref="#" onClick="addTimeRange(5)" class="add-activity"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString('addTimeRange') ?></span></a>
                
            </div>
            
            <div class="part">
                <h6><?php echo $translate->getString('saturday') ?></h6>
                
                <?php foreach($user->getAvailability()->getSaturday() as $timerange){?>
                <div class="form-group multiple">
                    <div class='input-group date datetimepicker-from' id='d11'>
                        <input type='text' name="day[6][from][]" class="form-control" placeholder="<?php echo $translate->getString('from') ?>" value="<?php echo $timerange['from'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <div class='input-group date datetimepicker-to' id='d12'>
                        <input type='text' name="day[6][to][]" class="form-control" placeholder="<?php echo $translate->getString('to') ?>" value="<?php echo $timerange['to'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <a h-ref="#" onClick="$(this).parent().remove()" class="add-activity"><i class="fa fa-trash lt-txt"></i><span><?php echo $translate->getString('delTimeRange') ?></span></a>
                </div>
                <?php }?>

                <div id="content-day-6"></div>
                
                <a h-ref="#" onClick="addTimeRange(6)" class="add-activity"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString('addTimeRange') ?></span></a>
                
            </div>
            
            <div class="part">
                <h6><?php echo $translate->getString('sunday') ?></h6>
                
                <?php foreach($user->getAvailability()->getSunday() as $timerange){?>
                <div class="form-group multiple">
                    <div class='input-group date datetimepicker-from' id='d13'>
                        <input type='text' name="day[7][from][]" class="form-control" placeholder="<?php echo $translate->getString('from') ?>" value="<?php echo $timerange['from'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <div class='input-group date datetimepicker-to' id='d14'>
                        <input type='text' name="day[7][to][]" class="form-control" placeholder="<?php echo $translate->getString('to') ?>" value="<?php echo $timerange['to'] ?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                    <a h-ref="#" onClick="$(this).parent().remove()" class="add-activity"><i class="fa fa-trash lt-txt"></i><span><?php echo $translate->getString('delTimeRange') ?></span></a>
                </div>
                <?php }?>

                <div id="content-day-7"></div>
                
                <a h-ref="#" onClick="addTimeRange(7)" class="add-activity"><i class="fa fa-plus lt-txt"></i><span><?php echo $translate->getString('addTimeRange') ?></span></a>
                
            </div>
            
            <div class="part">
                <h6>Holidays and vacation</h6>
                
                <div class="form-group">
                    <label>Choose a date:</label>
                    <div class='input-group date' id='datetimepicker3'>
                        <input type='text' class="form-control" placeholder="Choose a date" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
                <a href="#" class="add-activity"><i class="fa fa-plus lt-txt"></i><span>Add another date</span></a>
                <a href="#" class="add-activity"><i class="fa fa-trash lt-txt"></i><span>Delete this date</span></a>
                
            </div>

            <button type="submit" class="button med-prim-bg" name="action" value="model_availability" form="model_availability"><?php echo $translate->getString("save") ?></button>
        
        </form>
        
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.datetimepicker-from').datetimepicker({
            format: 'LT'
        });
        $('.datetimepicker-to').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'LT'
        });
        $(".datetimepicker-from").on("dp.change", function (e) {
            $('.datetimepicker-to').data("DateTimePicker").minDate(e.date);
        });
        $(".datetimepicker-to").on("dp.change", function (e) {
            $('.datetimepicker-from').data("DateTimePicker").maxDate(e.date);
        });
    });
    
    $(function () {
        $('#datetimepicker3').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });

    function addTimeRange(day){
        $("#content-day-"+day).append(''+
            '<div class="form-group multiple">'+
            '   <div class="input-group date datetimepicker-from">'+
            '       <input type="text" name="day['+day+'][from][]" class="form-control" placeholder="<?php echo $translate->getString('from') ?>" />'+
            '       <span class="input-group-addon">'+
            '           <span class="glyphicon glyphicon-time"></span>'+
            '       </span>'+
            '   </div>'+
            '   <div class="input-group date datetimepicker-to">'+
            '       <input type="text" name="day['+day+'][to][]" class="form-control" placeholder="<?php echo $translate->getString('to') ?>" />'+
            '       <span class="input-group-addon">'+
            '           <span class="glyphicon glyphicon-time"></span>'+
            '       </span>'+
            '   </div>'+
            '   <a h-ref="#" onClick="$(this).parent().remove()" class="add-activity"><i class="fa fa-trash lt-txt"></i><span><?php echo $translate->getString('delTimeRange') ?></span></a>'+
            '</div>');

        $('.datetimepicker-from').datetimepicker({
            format: 'LT'
        });
        $('.datetimepicker-to').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'LT'
        });
        $(".datetimepicker-from").on("dp.change", function (e) {
            $('.datetimepicker-to').data("DateTimePicker").minDate(e.date);
        });
        $(".datetimepicker-to").on("dp.change", function (e) {
            $('.datetimepicker-from').data("DateTimePicker").maxDate(e.date);
        });
    }
</script>