<form id="langIdForm" action="/language/changeLanguage.php" method="post">
    <select class="selectpicker" onchange="sendLangIdForm();" name="langID">
        <option value="en" <?php if(isset($_COOKIE['lang']) && $_COOKIE['lang']=="en"){echo "selected";} ?> selected data-content="<img src='/img/en.png' /><span>English</span>">English</option>
        <option value="pl" <?php if(isset($_COOKIE['lang']) && $_COOKIE['lang']=="pl"){echo "selected";} ?> data-content="<img src='/img/pl.png' /><span>Polish</span>">Polish</option>
    </select>
</form>

<script>
	function sendLangIdForm(){
		$('#langIdForm').submit();
	}
</script>