<form id="langIdForm" action="/language/changeLanguage.php" method="post">
    <select class="selectpicker" onchange="sendLangIdForm();" name="langID">
        <option value="en" <?php if(isset($_COOKIE['lang']) && $_COOKIE['lang']=="en"){echo "selected";} ?> selected data-content="<img src='/img/en.png' /><span>English</span>">English</option>
        <!-- <option value="pl" <?php if(isset($_COOKIE['lang']) && $_COOKIE['lang']=="pl"){echo "selected";} ?> data-content="<img src='/img/pl.png' /><span>Polish</span>">Polish</option> -->
        <option value="fr" <?php if(isset($_COOKIE['lang']) && $_COOKIE['lang']=="fr"){echo "selected";} ?> data-content="<img src='/img/fr.png' /><span>français</span>">français</option>
        <option value="zt" <?php if(isset($_COOKIE['lang']) && $_COOKIE['lang']=="zt"){echo "selected";} ?> data-content="<img src='/img/zt.png' /><span>中国</span>">中国</option>
        <option value="ar" <?php if(isset($_COOKIE['lang']) && $_COOKIE['lang']=="ar"){echo "selected";} ?> data-content="<img src='/img/ar.png' /><span>العربية</span>">العربية</option>
    </select>
</form>

<script>
	function sendLangIdForm(){
		$('#langIdForm').submit();
	}
</script>