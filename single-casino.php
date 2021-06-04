<?php get_header(); ?>
<main id="casino" class="content">
    <?php echo do_shortcode('[breadcrumbs]') ?>
    <?php get_template_part('template-parts/single-casino/casino-top'); ?>
    <?php get_template_part('template-parts/single-casino/single-casino-review'); ?>
    <?php get_template_part('template-parts/global/constructor/constructor'); ?>
</main>
<?php get_footer(); ?>

