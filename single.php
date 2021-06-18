<?php get_header(); ?>
<div id="post" class="content">
	<?php echo do_shortcode('[breadcrumbs]') ?>
	<div class="flex_parent container">
		<main>
			<h1><?php echo get_the_title(); ?></h1>
			<?php
			$author_block = get_field('author');
			get_template_part('template-parts/post/post-info');
			get_template_part('template-parts/post/post-content');
			get_template_part('/template-parts/global/constructor/constructor-parts/author', null);
			get_template_part('/template-parts/global/constructor/constructor-parts/table/table', null,
				[
					'top-3' => false,
					'custom' => get_field('recommended_casinos'),
					'title' => 'RECOMMENDED ONLINE CASINOS',
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

