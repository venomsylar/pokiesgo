<?php
$first = 'first_footer_menu';
$second = 'second_footer_menu';
$third = 'third_footer_menu';
$locations = get_nav_menu_locations();
if (has_nav_menu($first) || has_nav_menu($second) || has_nav_menu($third)) { ?>
    <section class="footer_menus">
        <?php if (has_nav_menu($first)) { ?>
            <nav id="<?php echo $first ?>" class="footer_menu">
                <strong class="h5"><?php echo wp_get_nav_menu_object($locations[$first])->name; ?></strong>
                <?php wp_nav_menu(['container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' => $first]); ?>
            </nav>
        <?php }
        if (has_nav_menu($second)) { ?>
            <nav id="<?php echo $second ?>" class="footer_menu">
                <strong class="h5"><?php echo wp_get_nav_menu_object($locations[$second])->name; ?></strong>
                <?php wp_nav_menu(['container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' => $second]); ?>
            </nav>
        <?php }
        if (has_nav_menu($third)) { ?>
            <nav id="<?php echo $third ?>" class="footer_menu">
                <strong class="h5"><?php echo wp_get_nav_menu_object($locations[$third])->name; ?></strong>
                <?php wp_nav_menu(['container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' => $third]); ?>
            </nav>
        <?php } ?>
    </section>
<?php }
