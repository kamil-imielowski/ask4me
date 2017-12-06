var me = document.querySelector('script[data-id="broadcast"]');
var username = me.getAttribute("data-username");
var transmissionId = me.getAttribute("data-transmissionId");
var antiSpam = true;
var mostTokensFrom = new Object();


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
        $("#chatContent").append(`<p class="message"><span><strong>`+message.username+`: </strong></span><span>`+message.text+`</span>`).animate({ scrollTop: $("#chatContent").height() }, "slow");
    }else{
        $("#chatContent").append(`<p class="message owner"><span><strong>`+message.username+`: </strong></span><span>`+message.text+`</span></p>`).animate({ scrollTop: $("#chatContent").height() }, "slow");
    }
});

//brak srodkow nadajacego
socket.on('private-trasmission-watcher_lack_of_resources', function(message){
    var message = JSON.parse(message);
    if(message.transMID !== transmissionId){return false;}
    $("#userWhoDidntHaveTokens").html(message.username);
    $('#continuePrivBroadcast').modal('show'); 
});


socket.on('trasmission-tip', function(message){
    var message = JSON.parse(message);
    if(message.transMID !== transmissionId){return false;}
    updateTokensContainer(parseInt(message.amount));
    var currentTokens = $("#tokensReceived").html();
    $("#tokensReceived").html(parseInt(currentTokens) + parseInt(message.amount));
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
            $("#chatContent").append(`<p class="message warning"></span><span>Do not spam</span></p>`).animate({ scrollTop: $("#chatContent").height() }, "slow");
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

async function endedPrivBroadcast(){
    var message = new Object();
    message.username = username;
    message.transMID = transmissionId;
    socket.emit('trasmission-end', JSON.stringify(message));
    setTimeout(function(){ 
        document.location.href = '/broadcast-private-model.php?action=end';
    }, 50);  
}