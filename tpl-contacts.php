<?php
/** * Template Name: Contacts*/
?>

<?php get_header(); ?>
<div class="content">
	<?php echo do_shortcode('[breadcrumbs]') ?>
	<div class="flex_parent container">
		<main>
			<h1><?php the_title(); ?></h1>
			<?php
			echo do_shortcode( '[contact-form-7 id="1025" title="Contact form 1"]' );
			get_template_part('template-parts/global/constructor/constructor');
			?>
		</main>
		<aside>
			<?php get_sidebar() ?>
		</aside>
	</div>
</div>
<?php get_footer(); ?>

