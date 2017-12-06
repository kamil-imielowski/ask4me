var userLogin;

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

$(function(){
	var action="getSessionData";
    $.ajax({
        url: "/ajax/messages.php",
        type: "post",
        data: {action},
        success: function(data){
        	console.log(data);
            data = JSON.parse(data);
            userLogin = data['userLogin'];
            conversation = data['conversation'];

            if(conversation != ""){
            	$.each( conversation, function( key, value ) {
					loadConversation(value);
				});
            }
        }
    })
});

$(document.body).on("click", ".message", function(){
	var to = $(this).attr('login');
	var returnNow=false;
	$("#content-chats").find('.expand').each(function(){
		if($(this).text() === to){
			returnNow=true;
			return;
		}
	});
	if(returnNow)return;
	var conversation = getConversation(to);
	addConversationToSession(to);

	$("#content-chats").append(
								`<div class="item animated fadeIn">
						            <div  class="chat small animated slideInUp">
						                <div  style="overflow: auto;" to=`+to+` class="message-box">`+
						                	conversation
						                +`</div>
						                <div  class="form-group type-message">
						                    <input type="text" class="value-msg" placeholder="Enter your message...">
						                    <input type="submit" value="" class="send-msg" >
						                </div>
						            </div>
						            <div class="main-part">
						                <span class="expand">` + to + `</span>
						                <div class="icons">
						                    <a href="messages.php"><i class='material-icons'>open_in_new</i></a>
						                    <a h-ref="#" class="close-chat"><i class='material-icons'>close</i></a>
						                </div>
						            </div>
						        </div>`
	);
});

//wysyłanie wiadomości
function sendMessage(to, msg){
	var message = new Object();
	
	message.to = to;
	message.from = userLogin;
	message.msg = msg;

	//socket.emit('users-private_chat', JSON.stringify(message));
	saveMessageToDB(to, msg);
	
}
$(document.body).on("click", '.send-msg', function () {
	var msg = $(this).closest('.type-message').find('.value-msg').val();
	var to = $(this).closest('.item').find('.expand').text();
	if(msg != ''){
		$("div[to='"+to+"']").closest('.item').find('.message-box').append('<p class="message owner"><span><strong>'+userLogin+': </strong></span><span>'+ msg +'</span></p>');
		$(this).closest('.type-message').find('.value-msg').val('');
		sendMessage(to, msg);
	}
	$("div[to='"+to+"']").stop().animate({
	  scrollTop: $("div[to='"+to+"']")[0].scrollHeight
	}, 800);
});
//wysyłanie wiadomości enter
$(document.body).on('keypress', '.value-msg', function(e) {
	if(e.keyCode == 13){
		var msg = $(this).val();
		var to = $(this).closest('.item').find('.expand').text();
		if(msg != ''){
			$("div[to='"+to+"']").closest('.item').find('.message-box').append('<p class="message owner"><span><strong>'+userLogin+': </strong></span><span>'+ msg +'</span></p>');
			$(this).val('');
			sendMessage(to, msg);
		}
		$("div[to='"+to+"']").stop().animate({
		  scrollTop: $("div[to='"+to+"']")[0].scrollHeight
		}, 800);
	}
})


//odebrano nową wiadomość
/*socket.on('users-private_chat', function(message){
	var message = JSON.parse(message);
    if(message.to !== userLogin){return false;}

	var pathname = window.location.pathname;
	pathname = pathname.replace('/', '');

	if(pathname == 'messages.php' || pathname == 'messages'){// gdy znajduje się w messages.php
		if($("#conversation").attr("to") == message.from){
			$("#conversation").append(
										`<div class="left">
	                                        <p class="message-content">`+message.msg+`</p>
	                                        <p class="message-info">
	                                            <span class="date">`+today+`</span>
	                                            <span><a href=""><i class="fa fa-trash"></i></a></span>
	                                        </p>
	                                    </div>`
	                                    );
			$('#conversation').stop().animate({
	          scrollTop: $('#conversation')[0].scrollHeight
	        }, 800);
		}else{
			$(".contacts").find("[to='"+message.from+"']").addClass('unread');
		}
	}else{
		if($("div[to='"+message.from+"']").length > 0){//gdy jest juz wyswietlone okienko z konwersacją od tego usera
			$("div[to='"+message.from+"']").closest('.item').find('.message-box').append('<p class="message"><span><strong>'+message.from+': </strong></span><span>'+ message.msg +'</span></p>');
			
			if(!$("div[to='"+message.from+"']").closest('.item').hasClass("expanded")){// gdy jest otwarte
				if(!$("div[to='"+message.from+"']").closest('.item').hasClass('unread')){
					$("div[to='"+message.from+"']").closest('.item').addClass('unread');
				}
			}
    		
		}else{//gdy nie ma okienka
			loadConversation(message.from);
			addConversationToSession(message.from);
			$("div[to='"+message.from+"']").closest('.item').addClass('unread');
		}
		$("div[to='"+message.from+"']").stop().animate({
	      scrollTop: $("div[to='"+message.from+"']")[0].scrollHeight
	    }, 800);
	}
    
});*/

function saveMessageToDB(to, msg){
	var action="saveMessageToDB";
    $.ajax({
        url: "/ajax/messages.php",
        type: "post",
        data: {action, to, msg},
        success: function(data){
            console.log(data);
        }
    })
}

function getConversation(recipient){
	var action="getConversation";
	var msgContent = null;
	var conversation;
    $.ajax({
        url: "/ajax/messages.php",
        type: "post",
        async: false,
        data: {action, recipient},
        success: function(data){
        	conversation = data;
        }
    });
    return conversation;
}

function loadConversation(to){//from session

	//var to = $(this).attr('login');
	var conversation = getConversation(to);

	$('.cs-options').addClass('mCustomScrollbar');
	if($("#content-chats").find('.expand').text() != to){
		$("#content-chats").append(
									`<div class="item animated fadeIn">
							            <div id="small-chat1" class="chat small animated slideInUp">
							                <div id="small-chat-content1" to=`+to+` class="message-box" style="overflow: auto;">`+
							                	conversation
							                +`</div>
							                <div id="chat-input" class="form-group type-message">
							                    <input type="text" class="value-msg" placeholder="Enter your message...">
							                    <input type="submit" value="" class="send-msg" >
							                </div>
							            </div>
							            <div class="main-part">
							                <span class="expand">` + to + `</span>
							                <div class="icons">
							                    <a href="messages.php"><i class='material-icons'>open_in_new</i></a>
							                    <a h-ref="#" class="close-chat"><i class='material-icons'>close</i></a>
							                </div>
							            </div>
							        </div>`
		);
	}
    $("div[to='"+to+"']").scrollTop($("div[to='"+to+"']")[0].scrollHeight);
}

function addConversationToSession(to){
	var action="addConversationToSession";
    $.ajax({
        url: "/ajax/messages.php",
        type: "post",
        data: {action, to},
        success: function(data){
            //console.log(data);
        }
    });
}

function deleteConversationFromSession(to){
	var action="deleteConversationFromSession";
    $.ajax({
        url: "/ajax/messages.php",
        type: "post",
        data: {action, to},
        success: function(data){
            //console.log(data);
        }
    });
}

//close chat window
$(document.body).on('click', '.close-chat', function () {
	var to = $(this).closest(".item").find('.expand').text();
	deleteConversationFromSession(to);

   $(this).closest(".item").remove();

});

function markAsRead(to){
	var message = new Object();
	message.to = to;
	message.from = userLogin;
    //socket.emit('users-private_chat-mark_as_read', JSON.stringify(message));
}

$(document.body).on("click", ".expand", function(){
	var to = $(this).text();
	markAsRead(to);
	setTimeout(function(){ $("div[to='"+to+"']").scrollTop($("div[to='"+to+"']")[0].scrollHeight); }, 3000);
   	
});

//odbiorca przeczytal wiadomosc
/*socket.on('users-private_chat-mark_as_read', function(message){
	var pathname = window.location.pathname;
	pathname = pathname.replace('/', '');

	if(pathname == 'messages.php' || pathname == 'messages'){
    	var message = JSON.parse(message);
	    if(message.to !== userLogin){return false;}
	    if($("#conversation").attr('to') == message.from){
	        $("#conversation").find("i.material-icons").not(':has(.read)').addClass('read');
	    }
	}
})*/

$("#notifications").click(function(){
	var action="resetCountNotification";
    $.ajax({
        url: "/ajax/ajax.php",
        type: "post",
        data: {action},
        success: function(data){
            //console.log(data);
        }
    });
});
