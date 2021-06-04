<?php
function table_filter_item($args) {
	ob_start();
	$title = $args['title'];
	$taxonomy = $args['taxonomy'];
	$data = get_terms([
		'taxonomy' => $taxonomy
	]);
	?>
	<div class="table_filter_item" datatype="<?php echo $taxonomy ?>">
		<strong class="table_filter_item_title"><?php echo $title ?></strong>
		<div class="table_filter_item_list">
			<ul>
				<?php
				foreach ($data as $item) { ?>
					<li>
						<input datatype="<?php echo $taxonomy ?>_term" name="<?php echo $item->name ?>" data-term-id="<?php echo $item->term_id ?>" type="checkbox" id="<?php echo $item->slug ?>_id">
						<label for="<?php echo $item->slug ?>_id"><?php echo $item->name ?></label>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>

	<?php return ob_get_clean();
}