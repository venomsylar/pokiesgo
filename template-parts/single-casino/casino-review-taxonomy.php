<?php
$args = isset($args) ? $args : null;
$categories = get_data_from_template('terms', $args);
$other_categories = get_data_from_template('other_terms', $args);
$taxonomy = get_data_from_template('taxonomy', $args);
$label = get_data_from_template('label', $args);

?>
<div class="casino_review_box_item taxonomy_box flex_align_top_sm">
	<div class="casino_review_label"><?php echo $label ?></div>
	<div id="<?php echo $taxonomy . '_list' ?>" class="casino_review_value">
		<div class="casino_review_value_wrap">
			<?php
			$categories_sorted = split_terms($categories, $other_categories);
			foreach ($categories_sorted as $category) {
				$short_name = '';
				$name = $category['name'];
				$link = $category['link'];
				$id = $category['term_id'];
				if ($id) {
					$short_name = get_field('short_name', $taxonomy . '_' . $id);
				}
				$name = $short_name ? $short_name : $name;
				if ($link) { ?>
					<a href="<?php echo $link ?>"><?php echo $name ?></a>
				<?php } else { ?>
					<span><?php echo $name ?></span>
				<?php }
			}
			$count = count($categories_sorted);
			if ($categories_sorted && $count > 10) { ?>
				<strong class="taxonomy_list_read_more" data-src="#<?php echo $taxonomy . '_list' ?>"><em>+<?php echo $count - 10 . ' ' ?></em> View all</strong>
			<?php } ?>
		</div>
	</div>
</div>
