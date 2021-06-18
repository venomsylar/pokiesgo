<?php
$rating = get_field('rating');
$short_description = get_field('short_description');
global $post;
?>

<div class="post_info post_box">
	<div class="post_top_info post_top_info_additional">
		<?php
		if($rating) { ?>
			<div class="post_rating"><span>Rating :</span>
				<div class="stars_rating">
					<div class="stars_inner" style="width: <?php echo $rating * 20 ?>%"></div>
				</div>
			</div>
		<?php }
		$author_user_firstname = get_the_author_meta('user_firstname', $post->post_author);
		$author_user_lastname = get_the_author_meta('user_lastname', $post->post_author); ?>
		<span class="post_author">By : <?php echo $author_user_firstname. ' ' . $author_user_lastname ?></span>
		<time datetime="<?php echo get_the_date('Y-m-d'); ?>">Published : <?php echo get_the_date(get_option('date_format_custom')); ?></time>
	</div>
	<div class="post_bottom_info flex_md">
		<?php if (has_post_thumbnail()) { ?>
			<span class="post_thumbnail">
				<?php $alt = venom_attachment_alt_attr(get_post_thumbnail_id()); ?>
				<img src="<?php echo get_the_post_thumbnail_url(null, '328x175'); ?>" alt="<?php echo $alt ? $alt : get_the_title(); ?>">
			</span>
		<?php } else {
			$holder = get_field('default_image', 'option'); ?>
			<span class="post_thumbnail">
				<?php $alt = $holder['alt']; ?>
				<img src="<?php echo $holder['sizes']['328x175']; ?>" alt="<?php echo $alt ? $alt : get_the_title(); ?>">
			</span>
			<?php
		} ?>
		<p class="trim"><?php echo wp_trim_words(get_field('short_description'), 100); ?></p>
	</div>
</div>
