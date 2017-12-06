var me = document.querySelector('script[data-id="model-profile-S"]');
var nick = me.getAttribute("data-nick");

$(document).ready(function(){
	var elem = $(".horizontal li:first-child a");
	var cookieTab = getCookie("model_profil");
	//alert();
	if(cookieTab == false){
		tab('about', elem);
	}else{
		elem = document.getElementById('model-' + cookieTab);
		tab(cookieTab, elem)
		delete_cookie("model_profil");
		$(elem).parent().parent().collapse('show');
	}
});

function tab(url, elem){
	$('#content').html('<div class="center animated fadeIn"><img src="/img/loader.gif" /></div>'); //gif buforowania
	$('.nav-tab').removeClass("active");
	$(elem).parent().addClass("active");
	jQuery.ajax({
		url: "/ajax/model-"+url+".php",
		type: "POST",
        data: {nick},
		success: function(data){
			$("#content").html(data);
		}
	});
}

//kalendarz
