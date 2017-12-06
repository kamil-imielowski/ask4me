function addToWishlist(idProduct){//also deleting
	var action = 'addToWishlist';
	$.ajax({
		url: '/ajax/ajax.php',
		type: 'post',
		data: {idProduct, action},
		success: function(data){
			//alert(data);
		}
	});
}

