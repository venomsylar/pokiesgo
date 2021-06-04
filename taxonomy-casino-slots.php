<?php get_header(); ?>
    <main id="slot" class="content">
	    <?php echo do_shortcode('[breadcrumbs]') ?>
        <?php get_template_part('template-parts/slots/slot-top-info'); ?>
        <?php get_template_part('template-parts/global/constructor/constructor'); ?>
    </main>
<?php get_footer(); ?>