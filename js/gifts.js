function getPrice(productId){
	var action = 'getPrice';
	$.ajax({
		url: '/ajax/ajax.php',
		type: 'post',
		data: {productId, action},
		success: function(data){
			$(".gift-price").empty();
			$(".gift-price").append(data+"<i class='fa fa-diamond'>");
			$("#gift-price").css("display", "block");
			$("#gift-productId").val(productId);
		}
	});
}

$("#sendProductAsGift").click(function(){
	var action = 'sendProductAsGift';
	var productId = $("#gift-productId").val();
	var description = $("textarea[name='gift-product-description']").val();
	$.ajax({
		url: '/ajax/ajax.php',
		type: 'post',
		data: {userId, action, productId, description},
		success: function(data){
			var msg = JSON.parse(data);
			$('#gift').modal('toggle');
			displayAlert(msg[0], msg[1]);
		},
		error: function(){
			$('#gift').modal('toggle');
			displayAlert(false,	'Somethink wrong');
		}
	})
})
$("#gift-type").change(function(){
	var type = $(this).val();
	$("#gift-tokens").css("display", "none");
	$("#gift-file").css("display", "none");
	$("#gift-item").css("display", "none");
	$("#gift-price").css("display", "none");
	switch(type){
		case 'tokens':
			$("#gift-tokens").css("display", "block");
			break;

		case 'file':
			$("#gift-file").css("display", "block");
			break;

		case 'wishlist':
			$("#gift-item").css("display", "block");
			var action = 'getModelsProducts';
			$.ajax({
				url: '/ajax/ajax.php',
				type: 'post',
				data: {action},
				success: function(data){
					$("#gift-item-select").empty();
					$("#gift-item-select").append(data);
				}
			})
			break;
	}
})

$("#gift-item-select").change(function(){
	var productId = $(this).val();
	getPrice(productId);
})

$("#sendGift").click(function(){
	var type = $("#gift-type").val();
	var description = $("textarea[name='gift-description']").val();
	var userId = $("#gift-user-id").val();
	switch(type){
		case 'tokens':
			var tokenAmount = $("#gift-tokens-amount").val();
			var action = 'sendTokensAsGift';
			$.ajax({
				url: '/ajax/ajax.php',
				type: 'post',
				data: {action, userId, description, tokenAmount},
				success: function(data){
					var msg = JSON.parse(data);

					displayAlert(msg[0], msg[1]);
					$('#gift').modal('toggle');
				},
				error: function(){
					displayAlert(false,	'Somethink wrong');
					$('#gift').modal('toggle');
				}
			})
			break;

		case 'file':
			var action = 'sendFileAsGift';
			var data = new FormData();
			jQuery.each(jQuery('#file')[0].files, function(i, file) {
			    data.append('file', file);
			});
			data.append('action', 'sendFileAsGift');
			data.append('description', description);
			data.append('userId', userId);
			$.ajax({
				url: '/ajax/ajax.php',
				type: 'POST',
				data: data,
				cache: false,
			    contentType: false,
			    processData: false,
			    success: function(data){
			    	var msg = JSON.parse(data);
					displayAlert(msg[0], msg[1]);
			    },
				error: function(){
					displayAlert(false,	'Somethink wrong');
				}
			})

			$('#gift').modal('toggle');
			break;

		case 'wishlist':
			var action = 'sendProductAsGift';
			var productId = $("#gift-item-select").val();
			$.ajax({
				url: '/ajax/ajax.php',
				type: 'post',
				data: {userId, action, productId, description},
				success: function(data){
					var msg = JSON.parse(data);
					$('#gift').modal('toggle');
					displayAlert(msg[0], msg[1]);
				},
				error: function(){
					$('#gift').modal('toggle');
					displayAlert(false,	'Somethink wrong');
				}
			})
			break;
	}
})