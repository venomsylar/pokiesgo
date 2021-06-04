<div class="post post_box">
	<div class="post_top_info">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<div class="post_top_info_additional">
			<?php
			$author = get_field('author');
			if($author) { ?>
				<span class="post_author">By : <?php echo $author['name'] ?></span>
			<?php } ?>
			<time datetime="<?php echo get_the_date('Y-m-d'); ?>">Published : <?php echo get_the_date(get_option('date_format_custom')); ?></time>
		</div>
	</div>
    <div class="post_bottom_info flex_md">
	    <?php if (has_post_thumbnail()) { ?>
		    <a class="post_thumbnail" href="<?php the_permalink(); ?>">
			    <?php $alt = venom_attachment_alt_attr(get_post_thumbnail_id()); ?>
			    <img src="<?php echo get_the_post_thumbnail_url(null, '328x175'); ?>" alt="<?php echo $alt ? $alt : get_the_title(); ?>">
		    </a>
	    <?php } else {
		    $holder = get_field('default_image', 'option'); ?>
		    <a class="post_thumbnail" href="<?php the_permalink(); ?>">
			    <?php $alt = $holder['alt']; ?>
			    <img src="<?php echo $holder['sizes']['328x175']; ?>" alt="<?php echo $alt ? $alt : get_the_title(); ?>">
		    </a>
	    <?php
	    } ?>
	    <p class="trim"><?php echo wp_trim_words(get_field('short_description'), 100); ?></p>
    </div>
</div>
