<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

if(!isset($_POST['broadcaster'])){
    http_response_code(400);
    die("400 Bad Request");
}

$user = unserialize(base64_decode($_SESSION['user']));
$action = $user->getLogin()==$_POST['broadcaster'] ? "broadcaster" : "watcher";

$translate = new classes\Languages\Translate(); 

$transmission = new \classes\Transmissions\Transmission(new \classes\User\ModelUser(null, $_POST['broadcaster']));

if(is_null($transmission->getCurrentActivity())){
    echo $translate->getString("currentActivitynotSelected");
    exit();
}

switch($action):
    case 'broadcaster':?>
            <?php if($transmission->getCurrentActivity()->getType() == 1): ?>
                <div class="vote"><!--dla vote activity-->
                    <p>
                        <label><?php echo $translate->getString("currentActivityType") ?>:</label>
                        <span><?php echo $translate->getString("vote") ?></span>
                    </p>

                    <label><?php echo $translate->getString("whatNext") ?></label>
                    <form>
                        <div class="form-group">
                            <div class="radio">
                                <span><?php echo $transmission->getCurrentActivity()->getFirstOption()->getDescription() ?> - </span><i class="fa fa-diamond"></i><span><?php echo $transmission->getCurrentActivity()->getFirstOption()->getPrice() ?></span>
                            </div>
                            <div class="progress-info">
                                <div class="progress">
                                    <div class="progress-bar" id="progressBarFirstOPTVotes" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($transmission->getCurrentActivityProgress()['option1']/$transmission->getCurrentActivity()->getVotesToWin()) * 100 ?>%"></div>
                                </div>
                                <span class="xs-txt"><bdi id="currentFirstOPTVotes"><?php echo $transmission->getCurrentActivityProgress()['option1'] ?></bdi>/<?php echo $transmission->getCurrentActivity()->getVotesToWin() ?> <?php echo $translate->getString("votes") ?></span>  
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="radio">
                                <span><?php echo $transmission->getCurrentActivity()->getSecondOption()->getDescription() ?> - </span><i class="fa fa-diamond"></i><span><?php echo $transmission->getCurrentActivity()->getSecondOption()->getPrice() ?></span>
                            </div>
                            <div class="progress-info">
                                <div class="progress">
                                    <div class="progress-bar" id="progressBarSecondOPTVotes" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($transmission->getCurrentActivityProgress()['option2']/$transmission->getCurrentActivity()->getVotesToWin()) * 100 ?>%"></div>
                                </div>
                                <span class="xs-txt"><bdi id="currentSecondOPTVotes"><?php echo $transmission->getCurrentActivityProgress()['option2'] ?></bdi>/<?php echo $transmission->getCurrentActivity()->getVotesToWin() ?> <?php echo $translate->getString("votes") ?></span>  
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="radio">
                                <span><?php echo $transmission->getCurrentActivity()->getThirdOption()->getDescription() ?> - </span><i class="fa fa-diamond"></i><span><?php echo $transmission->getCurrentActivity()->getThirdOption()->getPrice() ?></span>
                            </div>
                            <div class="progress-info">
                                <div class="progress">
                                    <div class="progress-bar" id="progressBarThirdOPTVotes" role="progressbar" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($transmission->getCurrentActivityProgress()['option3']/$transmission->getCurrentActivity()->getVotesToWin()) * 100 ?>%"></div>
                                </div>
                                <span class="xs-txt"><bdi id="currentThirdOPTVotes"><?php echo $transmission->getCurrentActivityProgress()['option3'] ?></bdi>/<bdi id="requiredVotesToWin"><?php echo $transmission->getCurrentActivity()->getVotesToWin() ?></bdi> <?php echo $translate->getString("votes") ?></span>  
                            </div>
                        </div>
                    </form>
                </div>
            <?php elseif($transmission->getCurrentActivity()->getType() == 2): ?>
                <div class="doing-something"><!--dla doing something activity-->
                    <p>
                        <label><?php echo $translate->getString("currentActivityType") ?>:</label>
                        <span><?php echo $translate->getString("doingSTH") ?></span>
                    </p>

                    <label><?php echo $translate->getString("activityDescription") ?>:</label>
                    
                    <p><?php echo $transmission->getCurrentActivity()->getDescription() ?></p>
                    
                    <div class="goal-info">
                        <p>
                            <label><?php echo $translate->getString("requiredTokens") ?>:</label>
                            <span><i class="fa fa-diamond"></i><span id="requiredTokens_doSTH"><?php echo $transmission->getCurrentActivity()->getPrice() ?></span></span>
                        </p>
                        <div class="progress-info">
                            <div class="progress">
                                <div class="progress-bar" id="progressBar_doSTH" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($transmission->getCurrentActivityProgress() / $transmission->getCurrentActivity()->getPrice()) * 100 ?>%"></div>
                            </div>
                            <span class="xs-txt"><i class="fa fa-diamond"></i><span id="currentTokens_doSTH"><?php echo $transmission->getCurrentActivityProgress() ?></span></span>
                        </div>
                    </div>
                    
                </div>
            <?php endif ?>
        <?php break;?>

    <?php case 'watcher':?>
        <?php if($transmission->getCurrentActivity()->getType() == 1): ?>
            <div class="vote"><!--dla vote activity-->
                <p>
                    <label><?php echo $translate->getString("currentActivityType"); ?></label>
                    <span><?php echo $translate->getString("vote") ?></span>
                </p>

                <label><?php echo $translate->getString("whatNext") ?></label>

                <form id="voteForm" onsubmit="vote(); return false">
                    <div class="form-group">
                        <div class="radio">
                            <input type="radio" name="voteOption" id="radio1" value="option1" checked>
                            <label for="radio1">
                                <span><?php echo $transmission->getCurrentActivity()->getFirstOption()->getDescription() ?> - </span><i class="fa fa-diamond"></i><span><?php echo $transmission->getCurrentActivity()->getFirstOption()->getPrice() ?></span>
                            </label>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <div class="progress-bar" id="progressBarFirstOPTVotes" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($transmission->getCurrentActivityProgress()['option1']/$transmission->getCurrentActivity()->getVotesToWin()) * 100 ?>%"></div>
                            </div>
                            <span class="xs-txt"><bdi id="currentFirstOPTVotes"><?php echo $transmission->getCurrentActivityProgress()['option1'] ?></bdi>/<?php echo $transmission->getCurrentActivity()->getVotesToWin() ?> <?php echo $translate->getString("votes") ?></span>  
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="radio">
                            <input type="radio" name="voteOption" id="radio2" value="option2">
                            <label for="radio2">
                                <span><?php echo $transmission->getCurrentActivity()->getSecondOption()->getDescription() ?> - </span><i class="fa fa-diamond"></i><span><?php echo $transmission->getCurrentActivity()->getSecondOption()->getPrice() ?></span>
                            </label>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <div class="progress-bar" id="progressBarSecondOPTVotes" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($transmission->getCurrentActivityProgress()['option2']/$transmission->getCurrentActivity()->getVotesToWin()) * 100 ?>%"></div>
                            </div>
                            <span class="xs-txt"><bdi id="currentSecondOPTVotes"><?php echo $transmission->getCurrentActivityProgress()['option2'] ?></bdi>/<bdi id="requiredVotesToWin"><?php echo $transmission->getCurrentActivity()->getVotesToWin() ?></bdi> <?php echo $translate->getString("votes") ?></span>  
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="radio">
                            <input type="radio" name="voteOption" id="radio3" value="option3">
                            <label for="radio3">
                                <span><?php echo $transmission->getCurrentActivity()->getThirdOption()->getDescription() ?> - </span><i class="fa fa-diamond"></i><span><?php echo $transmission->getCurrentActivity()->getThirdOption()->getPrice() ?></span>
                            </label>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <div class="progress-bar" id="progressBarThirdOPTVotes" role="progressbar" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($transmission->getCurrentActivityProgress()['option3']/$transmission->getCurrentActivity()->getVotesToWin()) * 100 ?>%"></div>
                            </div>
                            <span class="xs-txt"><bdi id="currentThirdOPTVotes"><?php echo $transmission->getCurrentActivityProgress()['option3'] ?></bdi>/<?php echo $transmission->getCurrentActivity()->getVotesToWin() ?> <?php echo $translate->getString("votes") ?></span>  
                        </div>
                    </div>
                    <button type="submit" form="voteForm" class="button med-prim-bg" value="send a tip" name=""><?php echo $translate->getString("vote") ?></button>
                </form>
            </div>

        <?php elseif($transmission->getCurrentActivity()->getType() == 2): ?>
        
            <div class="doing-something"><!--dla doing something activity-->
                <p>
                    <label><?php echo $translate->getString("currentActivityType"); ?>:</label>
                    <span><?php echo strtolower($translate->getString("doingSTH")) ?></span>
                </p>

                <label><?php echo $translate->getString("activityDescription") ?>:</label>
                
                <p><?php echo $transmission->getCurrentActivity()->getDescription(); ?></p>
                
                <div class="goal-info">
                    <p>
                        <label><?php echo $translate->getString("requiredTokens") ?>:</label>
                        <span><i class="fa fa-diamond"></i><span id="requiredTokens_doSTH"><?php echo $transmission->getCurrentActivity()->getPrice() ?></span></span>
                    </p>
                    <div class="progress-info">
                        <div class="progress">
                            <div class="progress-bar" id="progressBar_doSTH" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo ($transmission->getCurrentActivityProgress() / $transmission->getCurrentActivity()->getPrice()) * 100 ?>%"></div>
                        </div>
                        <span class="xs-txt"><i class="fa fa-diamond"></i><span id="currentTokens_doSTH"><?php echo $transmission->getCurrentActivityProgress() ?></span></span>
                    </div>
                </div>
                
                <form class="inline" id="doSTHForm" onsubmit="doSTH(); return false">
                    <input type="number" min="1" max="<?php echo $transmission->getCurrentActivity()->getPrice() - $transmission->getCurrentActivityProgress() ?>" name="amount" required placeholder="<?php echo $translate->getString("enterTokenAmount") ?>">
                    <button type="submit" form="doSTHForm" class="button med-prim-bg" value="send a tip" name=""><?php echo $translate->getString("sendTip") ?></button>
                </form>
                
            </div>

        <?php endif ?>
        <?php break;?>

<?php endswitch ?>