<?php get_header(); ?>
	<div id="blog" class="content">
		<?php echo do_shortcode('[breadcrumbs]') ?>
		<div class="flex_parent container">
			<main>
				<h1><?php echo get_the_title(BLOG_ID); ?></h1>
				<?php get_template_part('template-parts/blog/loop'); ?>
			</main>
			<aside>
				<?php get_sidebar() ?>
			</aside>
		</div>
	</div>
<?php get_footer(); ?>