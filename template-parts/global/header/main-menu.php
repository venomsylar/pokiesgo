<?php if (has_nav_menu('main_menu')) { ?>
    <nav id="main_menu" class="js_main_menu">
        <?php wp_nav_menu(['container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' => 'main_menu']); ?>
    </nav>
    <div id="menu_open">
        <div id="menu_hamburger" class="js_hamburger">
            <span></span>
            <span></span>
        </div>
    </div>
<?php } ?>