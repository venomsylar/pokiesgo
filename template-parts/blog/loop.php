<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php get_template_part('template-parts/blog/post'); ?>
<?php endwhile; endif; ?>
<?php echo do_shortcode('[custom-pagination]'); ?>