<?php
$args = isset($args) ? $args : null;
$advantages = get_data_from_template('advantages', $args);

if($advantages && count($advantages)) { ?>
	<div class="advantages_list">
		<div class="container">
			<div class="advantages_list_wrap">
				<?php foreach($advantages as $advantage):
					$advantage_image = $advantage["advantage_image"];
					$advantage_description = $advantage["advantage_description"];?>
					<div class="advantage_item">
						<figure><img src="<?php echo $advantage_image ?>" alt="image"></figure>
						<?php echo $advantage_description ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php } ?>