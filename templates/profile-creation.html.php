<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="dashboard create-profile content has-sidebar">
    
    <div class="container">
   		<!-- 
        <div class="sidebar">
            <?php //include_once dirname(__FILE__).'/includes/sidebar-left.html.php';?>
        </div>
        -->
        <div class="main">
        
            <form method="post" id="become-model">
	            <div class="form-group user">
	                <input type="text" name="name" placeholder="<?php echo $translate->getString("firstName"); ?>" required <?php if(isset($data['name'])){?>value="<?php echo $data['name'] ?>"<?php }?>>
	            </div>
	            
	            <div class="form-group user">
	                <input type="text" name="surname" placeholder="<?php echo $translate->getString("lastName"); ?>" required <?php if(isset($data['surname'])){?>value="<?php echo $data['surname'] ?>"<?php }?>>
	            </div>
	            
	            <div class="form-group select">
	                <select name="sex">
	                    <option value="0" disabled selected><?php echo $translate->getString("gender"); ?></option>
	                    <option value="1" <?php if(isset($data['sex']) && $data['sex'] == 1){echo "selected";} ?>><?php echo $translate->getString("woman"); ?></option>
	                    <option value="2" <?php if(isset($data['sex']) && $data['sex'] == 2){echo "selected";} ?>><?php echo $translate->getString("man"); ?></option>
	                    <option value="3" <?php if(isset($data['sex']) && $data['sex'] == 3){echo "selected";} ?>><?php echo $translate->getString("transgender"); ?></option>
	                </select>
	            </div>

	            <div class="form-group select">
	                <select name="country">
	                    <option value="0" disabled selected><?php echo $translate->getString("country"); ?></option>
	                    <?php foreach($countries as $country){?>
	                        <option value="<?php echo $country->getIsoCode2() ?>" <?php if(isset($data['country']) && $data['country'] == $country->getIsoCode2()){echo "selected";} ?>><?php echo $country->getName() ?></option>
	                    <?php }?>
	                </select>
	            </div>

	            <div class="center">
	                <label><?php echo $translate->getString("howDidYouHear"); ?></label>

		            <div class="form-group select">
		                <select name="hear">
		                    <option value="1" <?php if(isset($data['hear']) && $data['hear'] == 1){echo "selected";} ?>><?php echo $translate->getString("searchEngineAd"); ?></option>
		                    <option value="2" <?php if(isset($data['hear']) && $data['hear'] == 2){echo "selected";} ?>><?php echo $translate->getString("searchEngineResults"); ?></option>
		                    <option value="3" <?php if(isset($data['hear']) && $data['hear'] == 3){echo "selected";} ?>><?php echo $translate->getString("friend"); ?></option>
		                    <option value="4" <?php if(isset($data['hear']) && $data['hear'] == 4){echo "selected";} ?>><?php echo $translate->getString("blogOrForum"); ?></option>
		                    <option value="5" <?php if(isset($data['hear']) && $data['hear'] == 5){echo "selected";} ?>><?php echo $translate->getString("newspaperOrMagazine"); ?></option>
		                    <option value="6" <?php if(isset($data['hear']) && $data['hear'] == 6){echo "selected";} ?>><?php echo $translate->getString("eventOrConference"); ?></option>
		                    <option value="7" <?php if(isset($data['hear']) && $data['hear'] == 7){echo "selected";} ?>><?php echo $translate->getString("radio"); ?></option>
		                    <option value="8" <?php if(isset($data['hear']) && $data['hear'] == 8){echo "selected";} ?>><?php echo $translate->getString("television"); ?></option>
		                    <option value="9" <?php if(isset($data['hear']) && $data['hear'] == 9){echo "selected";} ?>><?php echo $translate->getString("other"); ?></option>
		                </select>
		            </div>

		            <div class="form-group checkbox">
		                <input type="checkbox" id="checkbox1" name="terms" required>
		                <label for="checkbox1"></label>
		                <span><?php echo $translate->getString("registerModelCheck1-1"); ?> </span> 
		                <a href="terms.php" target="blank"><?php echo $translate->getString("thermsAndService"); ?></a>
		                <span>, <?php echo $translate->getString("includingThe"); ?> </span>
		                <a href="agreement.php" target="blank"><?php echo $translate->getString("userAgreement"); ?></a>
		                <span><?php echo $translate->getString("and"); ?></span>
		                <a href="privacy-policy.php" target="blank"><?php echo $translate->getString("privacyPolicy"); ?></a>
		            </div>

		            <div class="form-group checkbox">
		                <input type="checkbox" id="checkbox2" name="notify-mails">
		                <label for="checkbox2">
		                    <?php echo $translate->getString("registerModelCheck2"); ?>
		                </label>
		            </div>

		            <button
		                type="submit"
		                name="action"
		                value="become-model"
		                form="become-model"
		                class="button med-prim-bg g-recaptcha"
		                data-callback="YourOnSubmitFn">
		                Finish profile creation
		            </button>
		            <!-- data-sitekey="6Lfl0icUAAAAAE8GYsIPvK3JGhk0mqIPptpo49TI" -->
	            </div>

	        </form>
        
        </div>

    </div>
    
</div>

<script>
$(document).ready(function(){
	var elem = $(".horizontal li:first-child a");
	tab('categories', elem);
});
function tab(url, elem){
	$('#content').html('<div class="center animated fadeIn"><img src="img/loader.gif" /></div>'); //gif buforowania
	$('.nav-tab').removeClass("active");
	$(elem).parent().addClass("active");
	jQuery.ajax({
		url: "ajax/create-profile-"+url+".php",
		type: "POST",
		success: function(data){
			$("#content").html(data);
		}
	});
}
</script>
    
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>