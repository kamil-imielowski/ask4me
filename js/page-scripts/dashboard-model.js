$(document).ready(function(){
	var elem = $(".horizontal li:first-child a");
	var cookieTab= getCookie("user_sideTab");
	if(cookieTab == false){
		tab('home', elem);
	}else{
		elem = document.getElementById('dbm-' + cookieTab);
		tab(cookieTab, elem)
		delete_cookie("user_sideTab");
		$(elem).parent().parent().collapse('show');
		
		if(getCookie("collapse") != false){
			$("#"+getCookie("collapse")).collapse('show');
			delete_cookie("collapse");
		}
	}
});
function tab(url, elem){
	$('#content').html('<div class="center animated fadeIn"><img src="/img/loader.gif" /></div>'); //gif buforowania
	$('.nav-tab').removeClass("active");
	$(elem).parent().addClass("active");
	jQuery.ajax({
		url: "ajax/model-dashboard-"+url+".php",
		type: "POST",
		success: function(data){
			$("#content").html(data);
		}
	});
}