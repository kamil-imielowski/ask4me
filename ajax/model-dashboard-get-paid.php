<?php
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$withdrawals = new \classes\Withdrawal\WithdrawalsFactory($user->getId());
$withdrawal = $withdrawals->getLastWithdrawal();
$orders = new \classes\Order\OrdersFactory($user->getId());
$translate = new \classes\Languages\Translate($_COOKIE['lang']);
$settings = new \classes\Settings\SettingsFactory();
?>

<div class="section get-paid animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("getPaid") ?></h4>
    
    <div class="form">
        
        <form method="post">
            
            <div class="part">
                <h6><?php echo $translate->getString("currentBalance") ?></h6>   
                <span><i class="fa fa-diamond"></i><span><?php echo $user->getTokens() ?> - </span></span><a href="store.php"><span><?php echo $translate->getString("buyMoreTokens") ?></span></a>
            </div>
            
            <div class="part">
                <h6><?php echo $translate->getString("lastWithdrawal") ?></h6>   
                <span><i class="fa fa-calendar"></i><span><?php echo !empty($withdrawal) ? $withdrawal->getDateCreated()->format("d.m.Y") : ''; ?></span></span><!--<a href="#" onClick="tab('transactions', this);"><span>check all transactions</span></a>-->
            </div>
            
            <div class="part">
                <h6>Withdraw tokens</h6>   
                <div class="form-group">
                    <label><?php echo $translate->getString("tokenAmount") ?>:</label>
                    <input type="number" name="tokens" placeholder="<?php echo $translate->getString("tokenAmount") ?>" max="<?php echo $user->getTokens(); ?>">
                </div>
                
                <p><?php echo $translate->getString("youWillReceive") ?> <?php echo $user->getTokens() * $settings->getPriceForToken() ?>$</p>
                <!--
                <div class="form-group">
                    <label>Withdrawal method:</label>
                    <div class="select">
                        <select>
                            <option value="0" selected disabled>Withdrawal method</option>
                            <option value="1">Bank transfer</option>
                            <option value="2">Paypal</option>
                            <option value="3">Będzie tego więcej</option>
                        </select>
                    </div>
                </div>
                -->
                <div class="bank"><!--widoczne tylko przy wyborze bank transfer-->
                    <p><?php echo $translate->getString("enterBankAccountData") ?>:</p>
                    <div class="form-group">
                        <label><?php echo $translate->getString("bankAccountNumber") ?> (IBAN):</label>
                        <input type="text" name="iban" placeholder="<?php echo $translate->getString("bankAccountNumber") ?>" required>
                    </div>
                    <div class="form-group">
                        <label>SWIFT/BIC <?php echo $translate->getString("code") ?>:</label>
                        <input type="text" name="swift_bic" placeholder="SWIFT/BIC" required>
                    </div>
                    <div class="form-group">
                        <label><?php echo $translate->getString("accountOwnerName") ?>:</label>
                        <input type="text" name="owner_name" placeholder="<?php echo $translate->getString("accountOwnerName") ?>" required>
                    </div>
                    <div class="form-group">
                        <label><?php echo $translate->getString("accountOwnerLastName") ?>:</label>
                        <input type="text" name="owner_last_name" placeholder="<?php echo $translate->getString("accountOwnerLastName") ?>" required>
                    </div>
                </div>
                <!--
                <div class="paypal">
                    <p>Enter paypal account data you want the money to be transferred to:</p>
                    <div class="form-group">
                        <label>E-mail address:</label>
                        <input type="email" placeholder="E-mail address">
                    </div>
                </div>
                -->
                
            </div>

            <button type="submit" class="button med-prim-bg" name="action" value="withdrawTokens"><?php echo $translate->getString("withdraw") ?></button>
        
        </form>
        
    </div>
</div>	

