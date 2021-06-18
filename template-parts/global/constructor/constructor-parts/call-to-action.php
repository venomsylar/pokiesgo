<?php
$args = isset($args) ? $args : null;
$button_text = get_data_from_template('button_text', $args);
$casino_id = get_data_from_template('casino_id', $args);

if ($button_text && $casino_id) { ?>
	<div class="call_to_action">
		<div class="container">
			<button class="button" data-casino-id="<?php echo $casino_id ?>">
				<span class="anim"></span>
				<span><?php echo $button_text ?></span>
			</button>
		</div>
	</div>
<?php }