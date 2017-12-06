function displayAlert(type, string){
	if(type==true){//ok
		$("#ajax_alerts").append(`
								<div class="alert alert-success text-center errorsAlerts">
									<ul>` 
										+ string +
									`</ul>
								</div>
			`);
	}else if(type==false){//error 
		$("#ajax_alerts").append(`
								<div class="alert alert-danger text-center errorsAlerts" role="alert">
									<ul>` 
										+ string +
									`</ul>
								</div>
			`);
	}
	$('.errorsAlerts').delay(4000).fadeOut('slow');
}