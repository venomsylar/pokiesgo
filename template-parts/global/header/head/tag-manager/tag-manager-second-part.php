<?php if (get_field('tag_manager', 'option')&&get_field('gtm_id', 'option')) { ?>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo get_field('gtm_id', 'option') ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php } ?>