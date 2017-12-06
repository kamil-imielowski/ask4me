<div class="form-group form-errors">
	<?php if(!empty($errors)){ ?>
		<div class="alert alert-danger">
			<ul>
				<?php foreach($errors as $value) {?>
						
					<?php echo "<li>".$value."</li>";?>
							
				<?php }?>
			</ul>
		</div>
	<?php } else { 
		if(isset($ok)){?>
			<div class="alert alert-success" role="alert">
					
				<?php echo $ok;?>
						
			</div>
		<?php }?>
	<?php }?>		
</div>