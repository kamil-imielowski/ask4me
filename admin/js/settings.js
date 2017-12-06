function saveAdminSettings(key, value){
	var action = 'saveAdminSettings';
	$.ajax({
		url: '/admin/ajax/ajax.php',
		type: 'POST',
		data: {key, value, action},
		success: function(data){
			//console.log(data);
		}
	})
}