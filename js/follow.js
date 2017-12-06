function follow(followingUserId){
    $.ajax({
        url: "/ajax/follow.php",
        type: "post",
        data: {followingUserId},
        success: function(data){
            //alert(data);
        }
    })
}

function updateQFollowers(userId){
    var action = "getQuantityFollowers";
    $.ajax({
        url: "/ajax/ajax.php",
        type: "get",
        data: {userId,action},
        success: function(data){
            $("#quntityFollowers").html(data)
        }
    })
}