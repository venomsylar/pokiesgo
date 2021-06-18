<?php

/***
 * Registration const
 */
define('HOME_PAGE_ID', get_option('page_on_front'));
define('BLOG_ID', get_option('page_for_posts'));
define('POSTS_PER_PAGE', get_option('posts_per_page'));

/**
 * images sizes
 */
add_image_size('free', '1920', '', true);
add_image_size('180x80', '180', '80', true);
add_image_size('300x133', '300', '133', true);
add_image_size('328x175', '328', '175', true);
add_image_size('430x314', '430', '314', true);

/**
 * Register menus
 */
register_nav_menus(array(
    'main_menu' => 'Main menu',
    'first_footer_menu' => 'First Footer menu',
    'second_footer_menu' => 'Second Footer menu',
    'third_footer_menu' => 'Third Footer menu'
));

/**
 * Adding post thumbnail support
 */
add_theme_support('post-thumbnails');

/**
 * Register sidebar
 */
register_sidebar(
    array(
        'name'          => __('Page Sidebar'),
        'id'            => 'page_sidebar',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<strong class="widgetTitle h3">',
        'after_title'   => '</strong>',
    )
);

/**
 * Acf option pages
 */
if (function_exists('acf_add_options_page')) {
    // Theme General Settings
    acf_add_options_page(array(
        'page_title'    => 'Constructor',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => true
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Header Settings',
        'menu_title'	=> 'Header',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Footer Settings',
        'menu_title'	=> 'Footer',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Constructor Settings',
        'menu_title'	=> 'Constructor',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Options',
        'menu_title'	=> 'Options',
        'parent_slug'	=> 'theme-general-settings',
    ));

    // SEO Settings
    acf_add_options_page(array(
        'page_title'    => 'SEO Settings',
        'menu_title'    => 'SEO Settings',
        'menu_slug'     => 'theme-seo',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'icon_url' => 'dashicons-update'
    ));
}

/**
 * Create CPT and Taxonomies
 */

if(class_exists('CustomPostType')) {
    new CustomPostType('Casino', 'casino', 'dashicons-money-alt', false, true, ['title', 'thumbnail', 'author']);
}
if (class_exists('CustomTaxonomy')) {
    new CustomTaxonomy('casino', 'Category', 'casino-category', true);
    new CustomTaxonomy('casino', 'Games', 'casino-games', true);
    new CustomTaxonomy('casino', 'Provider', 'casino-provider', true);
    new CustomTaxonomy('casino', 'Payment', 'casino-payment', true);
    new CustomTaxonomy('casino', 'Slots', 'casino-slots', true);
}
/**
 * Cut CPT base
 */
function venom_delete_cpt_base() {
    if (post_type_exists('casino')) {
        $casino = get_post_type_object('casino');
        new PostUrlShortcutRewriter($casino);
    }
    if (post_type_exists('slots')) {
        $slots = get_post_type_object('slots');
        new PostUrlShortcutRewriter($slots);
    }
}
add_action('init', 'venom_delete_cpt_base');
/**
 * Cut taxonomy base
 */
function venom_delete_slug_from_taxonomy()
{
    if (taxonomy_exists('category') && class_exists(TaxUrlShortcutRewriter::class))
    {
        new TaxUrlShortcutRewriter( get_taxonomy('category') );
    }
    if (taxonomy_exists('post_tag') && class_exists(TaxUrlShortcutRewriter::class))
    {
        new TaxUrlShortcutRewriter( get_taxonomy('post_tag') );
    }
    if (taxonomy_exists('casino-category') && class_exists(TaxUrlShortcutRewriter::class))
    {
        new TaxUrlShortcutRewriter( get_taxonomy('casino-category') );
    }
    if (taxonomy_exists('casino-provider') && class_exists(TaxUrlShortcutRewriter::class))
    {
        new TaxUrlShortcutRewriter( get_taxonomy('casino-provider') );
    }
    if (taxonomy_exists('casino-payment') && class_exists(TaxUrlShortcutRewriter::class))
    {
        new TaxUrlShortcutRewriter( get_taxonomy('casino-payment') );
    }
    if (taxonomy_exists('casino-slots') && class_exists(TaxUrlShortcutRewriter::class))
    {
        new TaxUrlShortcutRewriter( get_taxonomy('casino-slots') );
    }
}
add_action('init', 'venom_delete_slug_from_taxonomy');