<?php
$id_page = get_queried_object_id();
$post_query = new WP_Query(array(
		'post_type' => 'post',
		'posts_per_page' => -1,
	    'orderby' => 'date',
	    'meta_query' => [
		    [
			    'key'       => 'promoted',
			    'value'     => true,
			    'compare'   => '=',
		    ]
	    ]
));
if ($post_query->have_posts()) : ?>
	<div class="most_popular_posts">
		<h2>Most Popular Blogposts</h2>
		<ul>
			<?php while ($post_query->have_posts())  : $post_query->the_post(); ?>
				<?php if ($id_page !== get_the_ID()) { ?>
					<li><a href="<?php echo get_the_permalink() ?>"><?php the_title(); ?></a></li>
				<?php } ?>
			<?php endwhile; endif; ?>
		</ul>
	</div>
<?php wp_reset_query(); ?>