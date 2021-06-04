</div>
<footer>
    <div class="container">
        <div class="footer_top">
            <?php get_template_part('template-parts/global/footer/footer-info'); ?>
            <?php get_template_part('template-parts/global/footer/footer-menus'); ?>
            <?php get_template_part('template-parts/global/footer/footer-images'); ?>
        </div>
        <?php get_template_part('template-parts/global/footer/copyright'); ?>
    </div>
    <?php get_template_part('template-parts/global/footer/policy-block'); ?>
    <?php get_template_part('template-parts/global/footer/scroll-to-top'); ?>
</footer>
<?php wp_footer(); ?>
<?php get_template_part('template-parts/global/footer/google-rating'); ?>
<!--[if (IE 6) | (IE 7) | (IE 8)]>
<?php get_template_part('template-parts/global/footer/browser-alert'); ?>
<![endif]-->
</body>
</html>