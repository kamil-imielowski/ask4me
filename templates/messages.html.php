<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="messages-container content">
    <div class="container section">
    
        <div class="wrapper">

            <div class="contacts">

                <h4>Contact list</h4>	
                
                <ul class="contact-list mCustomScrollbar">
                    <!-- class active i unread, class left do wiadomoźci odebrnych, right do wysłanych -->
                    <?php foreach($usersConversations->getUsersConversations() as $k => $user): ?>
                        <li class="user <?php echo $usersConversations->getConversationsSomeDetails()[$k]->getReaded() == 0 ? 'unread' : ''; ?>" to="<?php echo $user->getLogin() ?>">
                            <div class="avatar bg-img" style="background:url(<?php echo $user->getProfilePicture()->getSRCThumbImage(); ?>) center center no-repeat;"></div>
                            <span><?php echo $user->getLogin() ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="conversation">
                <div class="top scrollbar" id="conversation">

                </div>

                <div class="form-group type-message bottom">
                    <input id="msg-value" type="text" placeholder="Enter your message...">
                    <input id="msg-send" type="submit" value="">
                </div>
	
            </div>
        </div>
        
    </div>
</div>

<script>
$("body").addClass("messages-page");
$(".user").click(function(){
    $(".user").removeClass('active');
    $(this).addClass('active');

    var recipient = $(this).attr('to');
    var action="getConversationToMessenger";
    $("#conversation").attr("to", recipient);
    $.ajax({
        url: "/ajax/messages.php",
        type: "post",
        async: false,
        data: {action, recipient},
        success: function(data){
            $("#conversation").empty();
            $("#conversation").append(data);
            $("#conversation").scrollTop($("#conversation").prop("scrollHeight"));
        }
    });
    markAsRead(recipient);
});

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
var h = today.getHours();
var i = today.getMinutes();

if(dd<10) {
    dd = '0'+dd
} 

if(mm<10) {
    mm = '0'+mm
} 

if(h<10){
    h = '0'+h
}

if(i<10){
    i = '0'+i;
} 
today = dd + '.' + mm + '.' + yyyy + ' ' + h + ':' + i;

$("#msg-send").on("click", function () {
    var msg = $("#msg-value").val();
    $("#msg-value").val('');
    var to = $("#conversation").attr("to");
    
    $("#conversation").append(`

                                        <div class="right">
                                            <p class="message-content">`+msg+`</p>             
                                            <p class="message-info">
                                                <span class="o-sans">`+today+`</span>
                                                <span><i class="material-icons">done_all</i></span>
                                                <span><a href=""><i class="fa fa-trash"></i></a></span>
                                            </p>
                                        </div>
                            `);
    sendMessage(to, msg);
    $('#conversation').stop().animate({
      scrollTop: $('#conversation')[0].scrollHeight
    }, 800);
});
//wysyłanie wiadomości enter
$("#msg-value").on('keypress', function(e) {
    if(e.keyCode == 13){
        var msg = $("#msg-value").val();
        $("#msg-value").val('');
        var to = $("#conversation").attr("to");
        $("#conversation").append(`

                                        <div class="right">
                                            <p class="message-content">`+msg+`</p>             
                                            <p class="message-info">
                                                <span class="o-sans">`+today+`</span>
                                                <span><i class="material-icons">done_all</i></span>
                                                <span><a href=""><i class="fa fa-trash"></i></a></span>
                                            </p>
                                        </div>
                            `);
        sendMessage(to, msg);
        $('#conversation').stop().animate({
          scrollTop: $('#conversation')[0].scrollHeight
        }, 800);
    }
})
$(function(){
    $('.user').first().click();
    $('.user').first().addClass('active');
});


$(document.body).on('click', '.fa-trash', function(){
    $(this).closest("div").remove();
    var id = $(this).attr('msg');

    var action="deleteMessage";
    $.ajax({
        url: "/ajax/messages.php",
        type: "post",
        data: {action, id},
        success: function(data){
            console.log(data);
        }
    });
    
});
</script>
    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>