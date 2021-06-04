<?php
$args = isset($args) ? $args : null;
$current_page_id = get_queried_object_id();
$float = get_data_from_template('float', $args);
$casinos_table = get_field('all_casinos_table', 'option');
$casinos_table = array_slice($casinos_table, 0, 3);

if ($casinos_table && count($casinos_table)) { ?>
	<div class="top_3_casino_small <?php echo $float ?: ''  ?>">
		<h2>Top 3 Casinos</h2>
		<div class="casino_headings">
			<span class="casino_position_heading">#</span>
			<span class="casino_name_heading">Casino</span>
			<span class="casino_bonus_heading">Bonus</span>
			<span class="casino_button_heading">Play</span>
		</div>
		<?php
		$index = 1;
		foreach($casinos_table as $casino_id):
			$image = get_the_post_thumbnail_url($casino_id, '180x80');
			$default_image = get_field('default_image', 'option')['sizes']['180x80'];
			$title = get_the_title($casino_id);
			$bonus = get_field('bonus_casino',$casino_id);
			?>
			<div class="casino_item">
				<div class="casino_position">
					<span class="circled_position"><?php echo $index++ ?></span>
				</div>
				<div class="casino_image">
					<button data-casino-id="<?php echo $casino_id ?>">
						<img src="<?php echo $image ? $image : $default_image ?>" alt="<?php echo $title ?>">
					</button>
				</div>
				<div class="casino_info">
					<strong><?php echo $bonus ?></strong>
				</div>
				<div class="casino_button">
					<button class="button" data-casino-id="<?php echo $casino_id ?>">
						<span class="anim"></span>
						<span>Play now</span>
					</button>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php }