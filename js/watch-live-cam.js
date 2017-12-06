var me = document.querySelector('script[data-id="watch-live-cam"]');
var username = me.getAttribute("data-username");
var userId = me.getAttribute("data-userId");
var transmissionId = me.getAttribute("data-transmissionId");
var broadcaster = me.getAttribute("data-broadcaster");
var antiSpam = true;
var mostTokensFrom = new Object();
loadTransmissionState();
addUserToList();
function addUserToList(){
    if(userId){
        var message = new Object();
        message.type = 3;
        message.username = username;
        message.userId = userId;
        message.transMID = transmissionId;
        socket.emit('trasmission-addUserToList', JSON.stringify(message));
    }
}

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

//wiadomosc prywatna
socket.on('trasmission-private_chat', function(message){
    var message = JSON.parse(message);
    if(message.transMID !== transmissionId){return false;}
    if(broadcaster === message.username && message.to === username){
        if(message.username != username){
            $("#chatPrivateContent").append(`<p class="message"><span><strong>`+message.username+`: </strong></span><span>`+message.text+`</span>`).animate({ scrollTop: $("#chatPrivateContent").height() }, "slow");
        }else{
            $("#chatPrivateContent").append(`<p class="message owner"><span><strong>`+message.username+`: </strong></span><span>`+message.text+`</span></p>`).animate({ scrollTop: $("#chatPrivateContent").height() }, "slow");
        }
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
    if(userId){
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
                $("#chatGrupContent").append(`<p class="message warning"><span>Do not spam</span></p>`).animate({ scrollTop: $("#chatGrupContent").height() }, "slow");
            }
        }
    }else{
        $("#chatGrupContent").append(`<p class="message warning"><span><a class="message" href="/login.php?action=referer">sing in to send a message</a></span></p>`).animate({ scrollTop: $("#chatGrupContent").height() }, "slow");
        $("#boxMSGC").val("");
    }
}

function sendPrivateChatMessage(){
    var message = new Object();
    var msg = $("#boxMSGCPrivate").val();
    if(msg.trim()){
        if(antiSpam){
            message.username = username;
            message.transMID = transmissionId;
            message.type = 2;
            message.text = msg;
            socket.emit('trasmission-private_chat', JSON.stringify(message));
            $("#boxMSGCPrivate").val("");
            antiSpam = false;
            setTimeout(function(){ antiSpam = true; }, 1000);
            updateChatFile("private-"+username+"-"+broadcaster, username, msg, transmissionId);
        }else{
            $("#chatPrivateContent").append(`<p class="message warning"></span><span>Do not spam</span></p>`).animate({ scrollTop: $("#chatPrivateContent").height() }, "slow");
        }
    }
}

$('#boxMSGC').keyup(function(e){
    if(e.keyCode == 13)
    {
        sendChatMessage();
    }
});

$("#boxMSGCPrivate").keyup(function(e){
    if(e.keyCode == 13)
    {
        sendPrivateChatMessage();
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

function vote(){
    if(!checkCurrentActivityPossibility()){
        return false;
    }

    var option = $('input[name=voteOption]:checked', '#voteForm').val()
    var action ="voteForTransmissionActivity";
    $.ajax({
        url: "/ajax/ajax.php",
        type: "POST",
        data: {action, broadcaster, option},
        success: function(data){
            var response = JSON.parse(data);
            if(response.success){
                $("#currentActivityAllerts").html(`<span class="success">You vote</span>`).fadeIn('slow');
                //wyslanie powiadomienia o zagłosowaniu do odswiezenia dla pozostałych ogladajacych 
                var message = new Object();
                message.transMID = transmissionId;
                message.type = 5; // vote
                message.option = option;
                socket.emit('trasmission-vote', JSON.stringify(message));

                //aktualizacja tokenów głosującego
                updateTokensContainer(parseInt(response.amount));
                if(response.changeActivity){
                    realodPublicTransmissionActivity();
                    var message = new Object();
                    message.transMID = transmissionId;
                    message.type = 7; // zmiana aktualnej aktywnosci
                    socket.emit('trasmission-load_new_activity', JSON.stringify(message));
                }   

            }else{
                $("#currentActivityAllerts").html(`<span class="danger">`+response.error+`</span>`).fadeIn('slow');
            }
            $('#currentActivityAllerts').delay(4000).fadeOut('slow');
        }
    })
}

function doSTH(){
    if(!checkCurrentActivityPossibility()){
        return false;
    }
    var amount = $('#doSTHForm input[name=amount]').val();
    var action ="doSthDonate";
    $.ajax({
        url: "/ajax/ajax.php",
        type: "POST",
        data: {action, broadcaster, amount},
        success: function(data){
            var response = JSON.parse(data);
            if(response.success){
                $("#currentActivityAllerts").html(`<span class="success">You send a tip for current activitty</span>`).fadeIn('slow');

                //wyslanie powiadomienia o donate do odswiezenia dla pozostałych ogladajacych 
                var message = new Object();
                message.transMID = transmissionId;
                message.type = 6; // dosth
                message.amount = parseInt(response.amount) * -1;
                //conn.send(JSON.stringify(message))
                socket.emit('trasmission-dosth', JSON.stringify(message));

                //aktualizacja tokenów głosującego
                updateTokensContainer(parseInt(response.amount));

                if(response.changeActivity){
                    realodPublicTransmissionActivity();
                    var message = new Object();
                    message.transMID = transmissionId;
                    message.type = 7; // zmiana aktualnej aktywnosci
                    socket.emit('trasmission-load_new_activity', JSON.stringify(message));
                }   

            }else{
                $("#currentActivityAllerts").html(`<span class="danger">`+response.error+`</span>`).fadeIn('slow');
            }
            $('#currentActivityAllerts').delay(4000).fadeOut('slow');
        }
    })
}

function checkCurrentActivityPossibility(){
    if(userId){
        return true;
    }else{
        $("#currentActivityAllerts").html(`<span class="danger"><a href="/login.php?action=referer">Log in if you want increase progress of this activity</a></span>`).fadeIn('slow');
        $('#currentActivityAllerts').delay(6000).fadeOut('slow');
        return false;
    }
    return false;
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
    $.ajax({
        url: "/ajax/reloadPublicTransmissionActivity.php",
        type: "POST",
        data: {broadcaster},
        success: function(data){
            $("#currentActivityContainer").html(data);
        }
    })
}