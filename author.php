<?php get_header();
	global $author;
?>
	<div id="blog" class="content">
		<?php echo do_shortcode('[breadcrumbs]') ?>
		<div class="flex_parent container">
			<main>
				<?php
				$name = get_the_author_meta('first_name', $author) .' '. get_the_author_meta('last_name', $author);
				?>
				<h1><?php echo 'Author: '.$name ?></h1>
				<?php get_template_part('template-parts/blog/loop');
				get_template_part('/template-parts/global/constructor/constructor-parts/table/table', null,
					[
						'top-3' => false,
						'custom' => false,
						'title' => 'Casinos by ' .$name,
						'index' => 0,
						'hide_payments' => true
					]
				); ?>
			</main>
			<aside>
				<?php get_sidebar() ?>
			</aside>
		</div>
	</div>
<?php get_footer(); ?>