function updateTokensContainer(amount){
    var current = parseInt($(".tokens__container").html());
    var toUpdate = current + amount;
    $(".tokens__container").html(toUpdate);
}