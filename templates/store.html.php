<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="store content">
    <div class="container section">
        
        <div class="top">
            <div id="banner-slider" class="carousel slide banners carousel-fade" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#banner-slider" data-slide-to="0" class="active"></li>
                    <li data-target="#banner-slider" data-slide-to="1"></li>
                    <li data-target="#banner-slider" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="/img/banner.jpg" alt="Baner 1">
                    </div>

                    <div class="item">
                        <img src="/img/banner.jpg" alt="Baner 2">
                    </div>

                    <div class="item">
                        <img src="/img/banner.jpg" alt="Baner 3">
                    </div>
                </div>
            </div>

            <div class="menu">
                <ul class="horizontal white-txt med-bg">
                    <div class="nav-list">
                        <li class="nav-tab"><a h-ref="#" onClick="tab('homepage', this);"><?php echo $translate->getString("storeHomepage") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('membership', this);"><?php echo $translate->getString("membershipAndTokens") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('model', this);"><?php echo $translate->getString("modelItems") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('featured', this);"><?php echo $translate->getString("featured") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('bestsellers', this);"><?php echo $translate->getString("bestsellers") ?></a></li>
                        <li class="nav-tab"><a h-ref="#" onClick="tab('new', this);"><?php echo $translate->getString("newItems") ?></a></li>
                    </div>         
                </ul>
            </div>      
        </div>

        <div id="content" class="store-data"></div>
    
    </div>
</div>


<script>
$(document).ready(function(){
	var elem = $(".horizontal li:first-child a");
	tab('homepage', elem);
});
function tab(url, elem){
	$('#content').html('<div class="center animated fadeIn"><img src="/img/loader.gif" /></div>'); //gif buforowania
	$('.nav-tab').removeClass("active");
	$(elem).parent().addClass("active");
	jQuery.ajax({
		url: "/ajax/store-"+url+".php",
		type: "POST",
		success: function(data){
			$("#content").html(data);
		}
	});
}
</script>
    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>