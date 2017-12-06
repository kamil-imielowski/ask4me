<div class="form-group form-errors" id="ajax_alerts">
	<?php if(!empty($errors)){ ?>
		<div class="alert alert-danger text-center" id="errorsAlerts">
			<ul>
				<?php foreach($errors as $value) {?>
						
					<?php echo "<li>".$value."</li>";?>
							
				<?php }?>
			</ul>

		</div>
	<?php } else { 
		if(isset($ok)){?>
			<div class="alert alert-success text-center" role="alert" id="errorsAlerts">
				
				<?php echo $ok;?>
				
			</div>
		<?php }?>
	<?php }?>		
</div>

<script>
$(document).ready(function(){
	$('#errorsAlerts').delay(4000).fadeOut('slow');
})
</script>