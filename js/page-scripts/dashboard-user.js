$(document).ready(function(){
	var elem = $(".horizontal li:first-child a");
	var cookieTab= getCookie("user_sideTab");
	if(cookieTab == false){
		tab('home', elem);
	}else{
		tab(cookieTab, document.getElementById('dbu-' + cookieTab))
		delete_cookie("user_sideTab");
	}
});
function tab(url, elem){
	$('#content').html('<div class="center animated fadeIn"><img src="/img/loader.gif" /></div>'); //gif buforowania
	$('.nav-tab').removeClass("active");
	$(elem).parent().addClass("active");
	jQuery.ajax({
		url: "/ajax/user-dashboard-"+url+".php",
		type: "POST",
		success: function(data){
			$("#content").html(data);
		}
	});
}