var me = document.querySelector('script[data-id="broadcast"]');
var username = me.getAttribute("data-username");
var transmissionId = me.getAttribute("data-transmissionId");
var antiSpam = true;
var mostTokensFrom = new Object();

var activePrivateChatTab = " active";
var activePrivateChatTabC = " active in";

loadTransmissionState()

var update = setTimeout(updateActivity, 1000);
function updateActivity(){
    var action="update_activity";
    $.ajax({
        url: "/ajax/transmission.php",
        type: "post",
        data: {action},
        success: function(data){
            console.log(data);
            update = setTimeout(updateActivity, 60000);
        }
    })
}

///////////
// chat{ //
///////////

//listener wykryl nowa wiadomosc
socket.on('trasmission-public_chat', function(message){
    var message = JSON.parse(message);
    if(message.transMID !== transmissionId){return false;}
    if(message.username != username){
        $("#chatGrupContent").append(`<p class="message"><span><strong>`+message.username+`: </strong></span><span>`+message.text+`</span>`).animate({ scrollTop: $("#chatGrupContent").height() }, "slow");
    }else{
        $("#chatGrupContent").append(`<p class="message owner"><span><strong>`+message.username+`: </strong></span><span>`+message.text+`</span></p>`).animate({ scrollTop: $("#chatGrupContent").height() }, "slow");
    }
});

//listener wykryl nowego usera
socket.on('trasmission-addUserToList', function(message){
    var message = JSON.parse(message);
    if($("#watch-"+message.username).length === 0){
        $("#watchingUserList").prepend(`<div class="user" id="watch-`+message.username+`">
                                            <span><strong>`+message.username+`</strong></span>
                                            <a href="">Block</a>
                                            <a href="">Silence</a>
                                            <div class="icons">
                                                <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                                            </div>
                                        </div>`);
    }
});

//wiadomosc prywatna
socket.on('trasmission-private_chat', function(message){
    var message = JSON.parse(message);
    if(message.transMID !== transmissionId){return false;}
    if(message.username != username){
        if($("#userLi"+message.username).length === 0){
            $("#user-nav").append(`<li role="presentation" class="`+activePrivateChatTab+`" id="userLi`+message.username+`"><a href="#user`+message.username+`" aria-controls="username" role="tab" data-toggle="tab">`+message.username+`</a></li>`);
            $("#userContentLiTab").append(`<div id="user`+message.username+`" role="tabpanel" class="tab-pane fade`+activePrivateChatTabC+`">
                                                <div class="mCustomScrollbar messages2" id="msgPrivateContent-`+message.username+`"></div>
                                                <div id="" class="form-group type-message">
                                                    <input type="text" placeholder="Enter your message..." id="boxMSGCPrivate-`+message.username+`">
                                                    <button type="button" onclick="sendPrivateChatMessage('`+message.username+`')">send</button>
                                                </div>
                                            </div>
                                            <script>
                                                $('#boxMSGCPrivate-`+message.username+`').keyup(function(e){
                                                    if(e.keyCode == 13)
                                                    {
                                                        sendPrivateChatMessage('`+message.username+`');
                                                    }
                                                });
                                            </script>`);
            activePrivateChatTab = "";      
            activePrivateChatTabC = "";           
        }
    }
    if(message.username != username){
        $("#msgPrivateContent-"+message.username).prepend(`<p class="message"><span><strong>`+message.username+`: </strong></span><span>`+message.text+`</span>`).animate({ scrollTop: $("#msgPrivateContent-"+message.username).height() }, "slow");
    }else{
        $("#msgPrivateContent-"+message.to).prepend(`<p class="message owner"><span><strong>`+message.username+`: </strong></span><span>`+message.text+`</span></p>`).animate({ scrollTop: $("#msgPrivateContent-"+message.to).height() }, "slow");
    }
});

//nowy ogladajacy 
socket.on('trasmission-new_watcher', function(message){
    var message = JSON.parse(message);
    if(message.transMID !== transmissionId){return false;}
    if($("#watch-"+message.username).length === 0){
        $("#watchingUserList").prepend(`<div class="user" id="watch-`+message.username+`">
                                            <span><strong>`+message.username+`</strong></span>
                                            <a href="">Block</a>
                                            <a href="">Silence</a>
                                            <div class="icons">
                                                <a class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="right" title="Follow"><i class='follow material-icons'></i></a>
                                            </div>
                                        </div>`);
    }
});


socket.on('trasmission-tip', function(message){
    var message = JSON.parse(message);
    if(message.transMID !== transmissionId){return false;}
    if(!mostTokensFrom[message.username]){
        mostTokensFrom[message.username] = new Object();
        mostTokensFrom[message.username].amount = parseInt(message.amount);
    }else{
        mostTokensFrom[message.username].amount = parseInt(mostTokensFrom[message.username].amount) + parseInt(message.amount);
    }
    var currentTokens = $("#tokenReceivedContainer").html();
    $("#tokenReceivedContainer").html(parseInt(currentTokens) + parseInt(message.amount));
    updateMostTokensFrom();
});

socket.on('trasmission-vote', function(message){
    var message = JSON.parse(message);
    if(message.transMID !== transmissionId){return false;}
    updateVoteCounter(message.option);
});

socket.on('trasmission-dosth', function(message){
    var message = JSON.parse(message);
    if(message.transMID !== transmissionId){return false;}
    updateDoSTHProgress(message.amount);
});

socket.on('trasmission-load_new_activity', function(message){
    var message = JSON.parse(message);
    if(message.transMID !== transmissionId){return false;}
    realodPublicTransmissionActivity()
});

function sendChatMessage(){
    var message = new Object();
    var msg = $("#boxMSGC").val();
    if(msg.trim()){
        if(antiSpam){
            message.username = username;
            message.text = msg;
            message.type = 1;
            message.transMID = transmissionId;
            socket.emit('trasmission-public_chat', JSON.stringify(message));
            $("#boxMSGC").val("");
            antiSpam = false;
            setTimeout(function(){ antiSpam = true; }, 1000);
            updateChatFile("group", username, msg, transmissionId);
        }else{
            $("#chatGrupContent").append(`<p class="message warning"></span><span>Do not spam</span></p>`).animate({ scrollTop: $("#chatGrupContent").height() }, "slow");
        }
    }
}

function sendPrivateChatMessage(to){
    var message = new Object();
    var msg = $("#boxMSGCPrivate-"+to).val();
    if(msg.trim()){
        if(antiSpam){
            message.username = username;
            message.transMID = transmissionId;
            message.type = 2;
            message.text = msg;
            message.to = to;
            socket.emit('trasmission-private_chat', JSON.stringify(message));
            $("#boxMSGCPrivate-"+to).val("");
            antiSpam = false;
            setTimeout(function(){ antiSpam = true; }, 1000);
            updateChatFile("private-"+to+"-"+username, username, msg, transmissionId);
        }else{
            $("#msgPrivateContent-"+to).prepend(`<p class="message warning"></span><span>Do not spam</span></p>`).animate({ scrollTop: $("#msgPrivateContent-"+to).height() }, "slow");
        }
    }
}

$('#boxMSGC').keyup(function(e){
    if(e.keyCode == 13)
    {
        sendChatMessage();
    }
});

function updateChatFile(type, user, message, transmissionId){
    $.ajax({
        url: "/chats/main.php",
        type: "POST",
        data: {type, user, message, transmissionId},
        async: false,
        success: function(data){
            console.log(data);
        }
    })
}

//////////
// }chat//
//////////

function updateMostTokensFrom(){
    $("#mostTokensFromContainer").html("");

    var output = [];
    
    for (var key in mostTokensFrom) {
        mostTokensFrom[key].key = key;   // save key so you can access it from the array (will modify original data)
        output.push(mostTokensFrom[key]);
    }
    
    output.sort(function(a,b) {
        return parseInt(b.amount) - parseInt(a.amount);
    });

    counter = 0;
    $.each(output, function(i, item) {
        if(counter >= 5)
            return false;
        $("#mostTokensFromContainer").append(`<li><a h-ref="#">`+item.key+`</a><span> - </span><i class="fa fa-diamond"></i><span>`+item.amount+`</span></li>`);
        counter++;
    })
}

function loadTransmissionState(){
    var broadcaster = username;
    var action="loadPublicTransmissionState";
    $.ajax({
        url: "/ajax/ajax.php",
        type: "GET",
        data: {action, broadcaster},
        success: function(data){
            var results = JSON.parse(data);
            mostTokensFrom = results.mostTokensFrom;
            updateMostTokensFrom();
            $("#tokenReceivedContainer").html(results.tokensReceived);
        }
    });
}

function updateVoteCounter(option){
    var requiredVotesToWin = parseInt($("#requiredVotesToWin").html());
    switch(option){
        case 'option1':
            var currentVotes = parseInt($("#currentFirstOPTVotes").html());
            $("#currentFirstOPTVotes").html(currentVotes+1);
            var width = ((currentVotes+1) / requiredVotesToWin) * 100;
            $("#progressBarFirstOPTVotes").width(width + '%');
            break;

        case 'option2':
            var currentVotes = parseInt($("#currentSecondOPTVotes").html());
            $("#currentSecondOPTVotes").html(currentVotes+1);
            var width = ((currentVotes+1) / requiredVotesToWin) * 100;
            $("#progressBarSecondOPTVotes").width(width + '%');
            break;

        case 'option3':
            var currentVotes = parseInt($("#currentThirdOPTVotes").html());
            $("#currentThirdOPTVotes").html(currentVotes+1);
            var width = ((currentVotes+1) / requiredVotesToWin) * 100;
            $("#progressBarThirdOPTVotes").width(width + '%');
            break;
    }
}

function updateDoSTHProgress(amount){
    var requiredTokens = parseInt($("#requiredTokens_doSTH").html());
    var currentTokens = parseInt($("#currentTokens_doSTH").html());
    var toUpdate = currentTokens + parseInt(amount);
    $("#currentTokens_doSTH").html(toUpdate);
    var width = (toUpdate / requiredTokens) * 100;
    $("#progressBar_doSTH").width(width + '%');
}

function realodPublicTransmissionActivity(){
    var broadcaster = username;
    $.ajax({
        url: "/ajax/reloadPublicTransmissionActivity.php",
        type: "POST",
        data: {broadcaster},
        success: function(data){
            $("#currentActivityContainer").html(data);
        }
    })
}