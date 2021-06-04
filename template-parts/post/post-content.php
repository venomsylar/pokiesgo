<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article class="post_content">
		<?php the_content(); ?>
		<hr>
	</article>
<?php endwhile; endif;