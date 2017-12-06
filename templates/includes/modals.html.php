<div class="modal fade" id="block" tabindex="-1" role="dialog" aria-labelledby="BlockLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content center">
      <div class="modal-header">
        <h4 class="modal-title" id="BlockLabel">Block user</h4>
      </div>
      <div class="modal-body">
            <p><span>Are you sure you want to block </span><span class="med-prim-txt"><strong>username</strong></span><span>?</span></p>
            <p>If you block this user, <!--lista rzeczy które powoduje blokowanie użytkowników--> </p>
      </div>
      <div class="modal-footer buttons">
            <button type="button" class="button med-prim-bg">Yes</button>
            <button type="button" class="button empty med-prim-br" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="continuePrivBroadcast" tabindex="-1" role="dialog" aria-labelledby="BlockLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content center">
            <div class="modal-header">
                <h4 class="modal-title"><bdi id="userWhoDidntHaveTokens"></bdi> <?php echo $translate->getString("hasNoToken") ?></h4>
            </div>
            <div class="modal-body">
                    <p><span><?php echo $translate->getString("areUsureToContinue") ?>?</span></p>
            </div>
            <div class="modal-footer buttons">
                    <a h-ref="#" onClick="endedPrivBroadcast()" class="button med-prim-bg"><?php echo $translate->getString('no')?></a>
                    <button type="button" class="button empty med-prim-br" data-dismiss="modal"><?php echo $translate->getString('yes')?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="ReportLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content center">
      <div class="modal-header">
        <h4 class="modal-title" id="ReportLabel">Report user</h4>
      </div>
      <div class="modal-body">
            <textarea placeholder="Enter the reason of your report"></textarea>
      </div>
      <div class="modal-footer buttons">
            <button type="button" class="button med-prim-bg">Send the report</button>
            <button type="button" class="button empty med-prim-br" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="request" tabindex="-1" role="dialog" aria-labelledby="RequestLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content center">
      <div class="modal-header">
        <h4 class="modal-title" id="RequestLabel">Send a request</h4>
      </div>
      <div class="modal-body">
          <div class="form">
              <form>

                <div class="form-group">
                    <label>Type of activity:</label>
                    <div class="select">
                        <select>
                            <option value="public">Planned public broadcast</option>
                            <option value="private-chat">Private webcam performance with chat only</option>
                            <option value="private-all">Private webcam performance with 2-way audio/video</option>
                            <option value="person">In person</option>
                         </select>
                    </div>
                </div>


                <div class="form-group">
                    <label>Date and time:</label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' class="form-control" placeholder="Date and time" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                  
                <!--w przypadku planned public broadcast lista zaplanowanych transmisji na wybrany dzień-->
                <div class="form-group">
                    <label>Choose activity:</label>
                    <div class="select">
                        <select>
                            <option value="1">Activity 1</option>
                            <option value="2">Activity 2</option>
                            <option value="3">Activity 3</option>
                         </select>
                    </div>
                </div>

                <!--tylko dla private webcam performance-->
                <div class="form-group">
                    <label>Min. duration (in minutes):</label>
                    <input type="text" placeholder="Minimum duration">
                </div>

                <!--tylko dla in person, dla activity ktore maja zdefinowana cenę na godzinę a nie za całość-->
                <div class="form-group">
                    <label>Duration (in hours):</label>
                    <input type="text" placeholder="Duration">
                </div>
                  
                <!--tylko dla private webcam performance oraz in person-->
                <div class="form-group">
                    <label>Confirm or change the price (in tokens):</label>
                    <input type="text" placeholder="Price" value="99">
                </div>

                <div class="form-group">
                    <label>Additional comments:</label>
                    <textarea placeholder="Enter additional information, like place of meeting etc..."></textarea>
                </div>


                <div class="center">
                    <!--tylko dla private webcam performance-->
                    <div class="form-group checkbox">
                        <input type="checkbox" id="checkbox3">
                        <label for="checkbox3">
                            Spy cam enabled
                        </label>
                    </div>

                    <!--tylko dla private webcam performance-->
                    <p><strong>Price per minute: </strong><span>99 <i class="fa fa-diamond"></i></span></p>

                    <!--tylko dla in person-->
                    <p><strong>Total price: </strong><span>999 <i class="fa fa-diamond"></i></span></p>

                    
                    <div class="modal-footer buttons">
                        <input type="submit" class="button med-prim-bg" value="Send request">
                        <button type="button" class="button empty med-prim-br" data-dismiss="modal">Cancel</button>
                    </div>
                </div>

            </form>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="gift" tabindex="-1" role="dialog" aria-labelledby="GiftLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content center">
      <div class="modal-header">
        <h4 class="modal-title" id="GiftLabel">Send a gift</h4>
      </div>
      <div class="modal-body">
          <div class="form">
              <form onsubmit="return false">

                <div class="form-group">
                    <label>Type of gift:</label>
                    <div class="select">
                        <select id="gift-type">
                            <option value="file">Photo or video file</option>
                            <option value="tokens">Tokens</option>
                            <option value="wishlist">Item from user's wishlist</option>
                         </select>
                    </div>
                </div>

                <!--tylko dla plików-->
                <div class="form-group" style="display: none;" id="gift-file">
                    <label class="control-label">Select a file:</label>
                    <input id="file" type="file" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
                </div>
                  
                <!--tylko dla tokenów-->
                <div class="form-group" style="display: none;" id="gift-tokens">
                    <label>Enter token amount:</label>
                    <input type="number" id="gift-tokens-amount" placeholder="Token amount">
                </div>

                  
                <!--tylko dla item from user's wishlist-->
                <div class="form-group" style="display: none;" id="gift-item">
                    <label>Choose the item:</label>
                    <div class="select">
                        <select id="gift-item-select">
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Additional comment:</label>
                    <textarea name="gift-description" placeholder="You can add a message to your gift"></textarea>
                </div>


                <div class="center">
                    <!--tylko dla in person-->
                    <p id="gift-price" style="display: none;"><strong>Price: </strong><span class="gift-price"> <i class="fa fa-diamond"></i></span></p>

                    
                    <div class="modal-footer buttons">
                        <input type="hidden" id="gift-user-id" value="<?php echo isset($profileCustomer) ? $profileCustomer->getId() : ''; ?>">
                        <input type="submit" class="button med-prim-bg" id="sendGift" value="<?php echo $translate->getString("sendGift") ?>">
                        <button type="button" class="button empty med-prim-br" data-dismiss="modal"><?php echo $translate->getString("cancel") ?></button>
                    </div>
                </div>

            </form>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="gift-product" tabindex="-1" role="dialog" aria-labelledby="GiftLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content center">
      <div class="modal-header">
        <h4 class="modal-title" id="GiftLabel">Send a gift</h4>
      </div>
      <div class="modal-body">
          <div class="form">
              <form onsubmit="return false">
                <input type="hidden" name="productId" id="gift-productId" value="">
                <div class="form-group">
                    <label>Additional comment:</label>
                    <textarea placeholder="You can add a message to your gift" name="gift-product-description"></textarea>
                </div>


                <div class="center">
                    <!--tylko dla in person-->
                    <p><strong>Price: </strong><span class="gift-price"> <i class="fa fa-diamond"></i></span></p>

                    
                    <div class="modal-footer buttons">
                        <input type="hidden" id="gift-product-user-id" value="<?php echo isset($profileCustomer) ? $profileCustomer->getId() : ''; ?>">
                        <button class="button med-prim-bg" data-dismiss="modal" id="sendProductAsGift" ><?php echo $translate->getString("sendGift") ?></button>
                        <button type="button" class="button empty med-prim-br" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="invitation" tabindex="-1" role="dialog" aria-labelledby="InvitationLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content center">
      <div class="modal-header">
        <h4 class="modal-title" id="InvitationLabel">Before you start</h4>
      </div>
      <div class="modal-body">
          <p>Customize the messages which will be sent to your group chat and online users:</p>
          <div class="form">
              <form>
                
                <div class="form-group">
                    <label>Group chat greeting:</label>
                    <input type="text" placeholder="Minimum duration">
                </div>

                <div class="form-group">
                    <label>Invitation for online users:</label>
                    <input type="text" placeholder="Duration">
                </div>

                <div class="modal-footer buttons">
                    <input type="submit" class="button med-prim-bg" value="Send and proceed" />
                    <input type="submit" class="button empty med-prim-br" value="Don't send and proceed" />
                </div>


            </form>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-labelledby="CancelLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content center">
            <div class="modal-header">
                <h4 class="modal-title" id="CancelLabel"><?php echo $translate->getString("cancelAnActivity"); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $translate->getString("cancelAnActivityQuestion") ?></p>
                <!-- <p><span>If you cancel, you will be charged a penalty of </span><i class='fa fa-diamond'></i><span>999</span></p> -->
            </div>
            <div class="modal-footer buttons">
                <a id="modalDeletePlannedActivityA" class="button med-prim-bg"><?php echo $translate->getString("yes") ?></a>
                <button type="button" class="button empty med-prim-br" data-dismiss="modal"><?php echo $translate->getString("no") ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="unsubscribe" tabindex="-1" role="dialog" aria-labelledby="UnsubscribeLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content center">
            <div class="modal-header">
                <h4 class="modal-title" id="UnsubscribeLabel">Unsubscribe an activity</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to unsubscribe the activity?</p>
                <p>If you unsubscribe, you will no longer get notifications about this activity.</p>
            </div>
            <div class="modal-footer buttons">
                <button type="button" class="button med-prim-bg">Yes</button>
                <button type="button" class="button empty med-prim-br" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>


<?php if (isset($user)) {?>
<div class="modal fade" id="delete-account" tabindex="-1" role="dialog" aria-labelledby="Delete-accountLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content center">
        <div class="modal-header">
            <h4 class="modal-title" id="Delete-account"><?php echo $translate->getString('deleteAcc') ?></h4>
        </div>
        <div class="modal-body">
                <p><?php echo $translate->getString('delAccQe') ?>?</p>
                <p><?php echo $translate->getString("delAccTi") ?>.</p>
        </div>
        <div class="modal-footer buttons">
                <a href="dashboard-<?php echo $user->getType() == 2 ? "model" : "user" ?>.php?action=delete_account" class="button med-prim-bg"><?php echo $translate->getString('yes') ?></a>
                <button type="button" class="button empty med-prim-br" data-dismiss="modal"><?php echo $translate->getString('no') ?></button>
        </div>
        </div>
    </div>
</div>
<?php }?>


<div class="modal fade" id="membership" tabindex="-1" role="dialog" aria-labelledby="membershipLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content center">
      <div class="modal-header">
        <h4 class="modal-title" id="membership">Membership change notification</h4>
      </div>
      <div class="modal-body">
            <p>Are you sure you want to change your membership plan?</p>
            <p>Your membership plan will be changed on 01.08.2017, after your current membership expires.</p>
      </div>
      <div class="modal-footer buttons">
            <a href="store.php" class="button med-prim-bg">Yes (go to store)</a>
            <button type="button" class="button empty med-prim-br" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
</script>
