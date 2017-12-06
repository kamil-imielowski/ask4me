var me = document.querySelector('script[data-id="watch-live-cam"]');
var username = me.getAttribute("data-username");
var userId = me.getAttribute("data-userId");
var transmissionId = me.getAttribute("data-transmissionId");
var broadcaster = me.getAttribute("data-broadcaster");
var invitedUser = me.getAttribute("data-invitedUser");
var antiSpam = true;
var mostTokensFrom = new Object();

bailiff();

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

socket.on('trasmission-tip', function(message){
    var message = JSON.parse(message);
    if(message.transMID !== transmissionId){return false;}
    if(!mostTokensFrom[message.username]){
        mostTokensFrom[message.username] = new Object();
        mostTokensFrom[message.username].amount = parseInt(message.amount);
    }else{
        mostTokensFrom[message.username].amount = parseInt(mostTokensFrom[message.username].amount) + parseInt(message.amount);
    }
    updateMostTokensFrom();

});


socket.on('trasmission-end', function(message){
    var message = JSON.parse(message);
    if(message.transMID !== transmissionId){return false;}
    alert("broadcaster endeed transmission");
    document.location.href = '/live-cams';
});

function sendChatMessage(){
    if(userId){
        if(username !== invitedUser){
            $("#chatContent").append(`<p class="message warning"><span>You don't have permission to chat on this transmission</span></p>`).animate({ scrollTop: $("#chatContent").height() }, "slow");
            $("#boxMSGC").val("");
            return false;
        }
        var message = new Object();
        var msg = $("#boxMSGC").val();
        if(msg.trim()){
            if(antiSpam){
                message.username = username;
                message.transMID = transmissionId;
                message.type = 1;
                message.text = msg;
                socket.emit('trasmission-public_chat', JSON.stringify(message));
                $("#boxMSGC").val("");
                antiSpam = false;
                setTimeout(function(){ antiSpam = true; }, 1000);
                updateChatFile("group", username, msg, transmissionId);
            }else{
                $("#chatContent").append(`<p class="message warning"><span>Do not spam</span></p>`).animate({ scrollTop: $("#chatContent").height() }, "slow");
            }
        }
    }else{
        $("#chatContent").append(`<p class="message warning"><span><a class="message" href="/login.php?action=referer">sing in to send a message</a></span></p>`).animate({ scrollTop: $("#chatContent").height() }, "slow");
        $("#boxMSGC").val("");
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

function sendATip(){
    if(userId){
        var amount = $("#tip_amount").val();
        var action ="sendATip";
        $.ajax({
            url: "/ajax/ajax.php",
            type: "POST",
            data: {action, broadcaster, amount},
            success: function(data){
                var response = JSON.parse(data);
                if(response.success){
                    updateTokensContainer(parseInt(amount) * -1);
                    $("#tipsAllerts").html(`<span class="success">Tip has been sent</span>`).fadeIn('slow');
                    var message = new Object();
                    message.username = username;
                    message.transMID = transmissionId;
                    message.type = 4; // tips
                    message.amount = amount;
                    socket.emit('trasmission-tip', JSON.stringify(message));
                }else{
                    $("#tipsAllerts").html(`<span class="danger">`+response.error+`</span>`).fadeIn('slow');
                }
                $('#tipsAllerts').delay(4000).fadeOut('slow');
                $("#tip_amount").val("");
            }
        })
    }else{
        $("#tip_amount").val("");
        $("#tipsAllerts").html(`<span class="danger"><a href="/login.php?action=referer">Log in if you want send a tip</a></span>`).fadeIn('slow');
        $('#tipsAllerts').delay(6000).fadeOut('slow');
    }
}


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
        $("#mostTokensFromContainer").append(`<li><a href="user.php">`+item.key+`</a><span> - </span><i class="fa fa-diamond"></i><span>`+item.amount+`</span></li>`);
        counter++;
    })
}

function loadTransmissionState(){
    var action="loadPublicTransmissionState";
    $.ajax({
        url: "/ajax/ajax.php",
        type: "GET",
        data: {action, broadcaster},
        success: function(data){
            var results = JSON.parse(data);
            mostTokensFrom = results.mostTokensFrom;
            updateMostTokensFrom()
        }
    });
}

function bailiff(){
    setTimeout(bailiff, 60000); // wywolanie na poczatku (pewnosc ze co 60 sek bedzie kolejny request[gdyby mial sie wykruszyc poprzedni ajax])
    var action = "private_transmission-bailiff";
    $.ajax({
        url: "/ajax/ajax.php",
        type: "post",
        data: {action, broadcaster},
        success: function(data){
            console.log(data);
            var response = JSON.parse(data);
            if(response.success){
                updateTokensContainer(parseInt(response.amount) * -1);
                var message = new Object();
                message.username = username;
                message.transMID = transmissionId;
                message.amount = response.amount;
                socket.emit('trasmission-tip', JSON.stringify(message));
                console.log("you pay for next minute of (.)(.)");
            }else{
                console.log("brak tokenow na kolejna minutke");
                var message = new Object();
                message.username = username;
                message.transMID = transmissionId;
                socket.emit('private-trasmission-watcher_lack_of_resources', JSON.stringify(message));
            }
        }
    })
}

$(window).on('beforeunload', function(){
    return false;
});