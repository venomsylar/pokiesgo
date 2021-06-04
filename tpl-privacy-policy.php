<?php
/**
 * Template Name: Privacy Policy
 */
?>

<?php get_header(); ?>
<div class="content">
	<main>
		<?php echo do_shortcode('[breadcrumbs]') ?>
		<div class="container">
			<h1><?php the_title(); ?></h1>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article>
					<?php the_content(); ?>
					<hr>
				</article>
			<?php endwhile; endif; ?>
		</div>
	</main>
</div>
<?php get_footer(); ?>
